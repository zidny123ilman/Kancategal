<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    /**
     * Normalize WhatsApp number to canonical format: 08xxxxxxxxx
     * Handles: +628xxx, 628xxx, 8xxx  → all become 08xxx
     */
    private function normalizeWhatsapp(string $number): string
    {
        // Remove all spaces, dashes, dots, parentheses
        $number = preg_replace('/[\s\-\.\(\)]/', '', $number);

        // Remove leading +
        if (str_starts_with($number, '+')) {
            $number = ltrim($number, '+');
        }

        // 628xxxxxxx -> 08xxxxxxx
        if (str_starts_with($number, '628')) {
            $number = '0' . substr($number, 2);
        }
        // 62xxxxxxx (non-8 prefix, e.g. 621xxx) -> 0xxxxxxx
        elseif (str_starts_with($number, '62')) {
            $number = '0' . substr($number, 2);
        }
        // 8xxxxxxx -> 08xxxxxxx
        elseif (str_starts_with($number, '8')) {
            $number = '0' . $number;
        }
        // 08xxxxxxx -> already correct

        return $number;
    }

    /**
     * Handle user registration request.
     */
    public function register(Request $request)
    {
        // Normalize before validation
        $request->merge([
            'no_whatsapp' => $this->normalizeWhatsapp($request->input('no_whatsapp', '')),
        ]);

        $validator = Validator::make($request->all(), [
            'nama_lengkap'     => 'required|string|max:255',
            // After normalization, valid Indonesian numbers start with 08 and are 10–13 digits total
            'no_whatsapp'      => ['required', 'string', 'regex:/^08[0-9]{8,11}$/', 'max:15', 'unique:users,whatsapp'],
            'alamat_rumah'     => 'required|string',
            'kata_sandi'       => 'required|string|min:6',
            'konfirmasi_sandi' => 'required|same:kata_sandi',
        ], [
            'no_whatsapp.required' => 'Nomor WhatsApp wajib diisi.',
            'no_whatsapp.regex'    => 'Format nomor WhatsApp tidak valid. Gunakan format: 08xx, +628xx, atau 628xx (hanya angka, 10–13 digit).',
            'no_whatsapp.unique'   => 'Nomor WhatsApp ini sudah terdaftar. Gunakan nomor lain atau masuk ke akun Anda.',
            'konfirmasi_sandi.same' => 'Konfirmasi kata sandi tidak cocok.',
            'kata_sandi.min'       => 'Kata sandi minimal 6 karakter.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $user = User::create([
            'name' => $request->nama_lengkap,
            'whatsapp' => $request->no_whatsapp,
            'alamat' => $request->alamat_rumah,
            'password' => Hash::make($request->kata_sandi),
            'can_borrow' => true,
            'can_upload_artikel' => false,
            'status' => 'active',
        ]);

        // Send WhatsApp registration notification
        $template = \App\Models\Setting::get('wa_template_register', 'Halo {name}, pendaftaran Anda di Kanca Tegal berhasil!');
        $message = str_replace('{name}', $user->name, $template);
        \App\Services\WhatsAppService::send($user->whatsapp, $message);

        Auth::login($user);

        return redirect('/')->with('success', 'Registrasi berhasil! Anda telah masuk.');
    }

    /**
     * Handle user login request.
     */
    public function login(Request $request)
    {
        $request->validate([
            'whatsapp'   => 'required|string',
            'kata_sandi' => 'required|string',
        ]);

        // Normalize number so 08xxx / +62xxx / 62xxx all work the same
        $normalizedWa = $this->normalizeWhatsapp($request->input('whatsapp'));

        $credentials = [
            'whatsapp' => $normalizedWa,
            'password' => $request->kata_sandi,
        ];

        // Retrieve user to check status before attempting auth
        $user = User::where('whatsapp', $normalizedWa)->first();

        if ($user && $user->status === 'suspended') {
            return redirect()->back()->withErrors([
                'whatsapp' => 'Akun Anda sedang dinonaktifkan (suspended). Hubungi admin.',
            ])->withInput();
        }

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect('/')->with('success', 'Selamat datang kembali, ' . Auth::user()->name . '!');
        }

        return redirect()->back()->withErrors([
            'whatsapp' => 'Nomor WhatsApp atau Kata Sandi salah.',
        ])->withInput();
    }

    /**
     * Log the user out.
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('success', 'Anda berhasil keluar.');
    }

    /**
     * Display forgot password form.
     */
    public function showForgotPasswordForm()
    {
        return view('pages.login-user.lupasandi');
    }

    /**
     * Generate OTP and send simulated WhatsApp notification.
     */
    public function sendOtp(Request $request)
    {
        $request->validate([
            'no_whatsapp' => 'required|string',
        ]);

        // Normalize so users can enter any format
        $noWhatsapp = $this->normalizeWhatsapp($request->input('no_whatsapp'));

        $user = User::where('whatsapp', $noWhatsapp)->first();
        if (!$user) {
            return redirect()->back()->withErrors([
                'no_whatsapp' => 'Nomor WhatsApp tidak terdaftar dalam sistem.',
            ])->withInput();
        }

        // Generate 6-digit random OTP
        $otp = mt_rand(100000, 999999);
        
        // Fetch WhatsApp template from Settings
        $template = \App\Models\Setting::get('wa_template_otp', 'Halo {name}, berikut adalah kode OTP untuk merubah kata sandi Anda: {otp}. Jangan sebarkan kode ini kepada siapapun!');
        
        // Format message
        $formattedMessage = str_replace(
            ['{name}', '{otp}'],
            [$user->name, $otp],
            $template
        );

        // Send WhatsApp OTP notification
        \App\Services\WhatsAppService::send($noWhatsapp, $formattedMessage);

        // Store OTP & WhatsApp in session
        session([
            'reset_otp' => $otp,
            'reset_whatsapp' => $noWhatsapp,
            'formatted_otp_message' => $formattedMessage
        ]);

        return redirect('/reset-sandi')->with('success', 'Kode OTP pemulihan kata sandi telah dikirim.');
    }

    /**
     * Display reset password form.
     */
    public function showResetPasswordForm()
    {
        if (!session()->has('reset_otp')) {
            return redirect('/lupa-sandi')->withErrors(['no_whatsapp' => 'Silakan masukkan nomor WhatsApp Anda terlebih dahulu.']);
        }
        return view('pages.login-user.resetsandi');
    }

    /**
     * Verify OTP and reset user password.
     */
    public function resetPassword(Request $request)
    {
        $request->validate([
            'otp' => 'required|string|size:6',
            'kata_sandi' => 'required|string|min:6',
            'konfirmasi_sandi' => 'required|same:kata_sandi',
        ], [
            'konfirmasi_sandi.same' => 'Konfirmasi kata sandi tidak cocok.',
            'kata_sandi.min' => 'Kata sandi minimal 6 karakter.',
            'otp.size' => 'Kode OTP harus berupa 6 digit angka.',
        ]);

        $sessionOtp = session('reset_otp');
        $sessionWhatsapp = session('reset_whatsapp');

        if ($request->input('otp') != $sessionOtp) {
            return redirect()->back()->withErrors([
                'otp' => 'Kode OTP tidak cocok atau sudah kedaluwarsa.',
            ])->withInput();
        }

        $user = User::where('whatsapp', $sessionWhatsapp)->first();
        if (!$user) {
            return redirect('/lupa-sandi')->withErrors(['no_whatsapp' => 'Pengguna tidak ditemukan. Silakan ulangi langkah pemulihan.']);
        }

        // Update password
        $user->password = Hash::make($request->input('kata_sandi'));
        $user->save();

        // Clear session keys
        session()->forget(['reset_otp', 'reset_whatsapp', 'formatted_otp_message']);

        return redirect('/login')->with('success', 'Kata sandi Anda berhasil diperbarui! Silakan masuk dengan kata sandi baru.');
    }
}
