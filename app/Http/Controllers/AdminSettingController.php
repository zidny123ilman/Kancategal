<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use App\Models\AdminLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class AdminSettingController extends Controller
{
    /**
     * Display the settings dashboard page.
     */
    public function index()
    {
        $settings = [
            'site_title' => Setting::get('site_title', 'Kanca Tegal'),
            'default_language' => Setting::get('default_language', 'id'),
            'maintenance_mode' => Setting::get('maintenance_mode', '0'),
            
            'admin_fullname' => Setting::get('admin_fullname', 'Admin'),
            'admin_username' => Setting::get('admin_username', 'admin'),
            
            'admin2_fullname' => Setting::get('admin2_fullname', 'Admin 2'),
            'admin2_username' => Setting::get('admin2_username', 'admin2'),
            
            'loan_limit' => Setting::get('loan_limit', '2'),
            'loan_duration' => Setting::get('loan_duration', '7'),
            'late_fine_rate' => Setting::get('late_fine_rate', '1000'),
            'grace_period' => Setting::get('grace_period', '0'),
            
            'wa_api_token' => Setting::get('wa_api_token', ''),
            'wa_template_register' => Setting::get('wa_template_register', 'Halo {name}, pendaftaran Anda di Kanca Tegal berhasil!'),
            'wa_template_borrow' => Setting::get('wa_template_borrow', 'Halo {name}, peminjaman buku {title} berhasil. Harap kembalikan sebelum {due_date}.'),
            'wa_template_overdue' => Setting::get('wa_template_overdue', 'Halo {name}, peminjaman buku {title} telah terlambat. Denda saat ini adalah {fine}. Harap segera kembalikan.'),
            'wa_template_otp' => Setting::get('wa_template_otp', 'Halo {name}, berikut adalah kode OTP untuk merubah kata sandi Anda: {otp}. Jangan sebarkan kode ini kepada siapapun!'),
            
            'popup_status' => Setting::get('popup_status', '0'),
            'popup_active_type' => Setting::get('popup_active_type', 'buka'),
            'popup_buka_image' => Setting::get('popup_buka_image', ''),
            'popup_tutup_image' => Setting::get('popup_tutup_image', ''),
        ];

        return view('pages.admin.setting.index', compact('settings'));
    }

    /**
     * Update settings.
     */
    public function update(Request $request)
    {
        $request->validate([
            'site_title' => 'required|string|max:255',
            'default_language' => 'required|string|in:id,en',
            'maintenance_mode' => 'nullable|string|in:0,1',
            
            'admin_fullname' => 'required|string|max:255',
            'admin_username' => 'required|string|max:255',
            'admin_password' => 'nullable|string|min:6',
            
            'admin2_fullname' => 'required|string|max:255',
            'admin2_username' => 'required|string|max:255',
            'admin2_password' => 'nullable|string|min:6',
            
            'loan_limit' => 'required|integer|min:1',
            'loan_duration' => 'required|integer|min:1',
            'late_fine_rate' => 'required|integer|min:0',
            'grace_period' => 'required|integer|min:0',
            
            'wa_api_token' => 'nullable|string',
            'wa_template_register' => 'required|string',
            'wa_template_borrow' => 'required|string',
            'wa_template_overdue' => 'required|string',
            'wa_template_otp' => 'required|string',

            'popup_status' => 'nullable|string|in:0,1',
            'popup_active_type' => 'nullable|string|in:buka,tutup',
            'popup_buka_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'popup_tutup_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $adminName = session('admin_fullname', 'Admin');
        $changedSections = [];

        // 1. General Settings
        $generalFields = ['site_title', 'default_language'];
        $generalChanged = false;
        foreach ($generalFields as $field) {
            $old = Setting::get($field);
            $new = $request->input($field);
            if ($old != $new) {
                Setting::set($field, $new);
                $generalChanged = true;
            }
        }
        $newMaintenance = $request->has('maintenance_mode') ? '1' : '0';
        if (Setting::get('maintenance_mode') != $newMaintenance) {
            Setting::set('maintenance_mode', $newMaintenance);
            $generalChanged = true;
        }
        if ($generalChanged) $changedSections[] = 'General Settings';

        // 2. Admin Credentials (Admin 1 & Admin 2)
        $credentialsChanged = false;

        // Admin 1
        $admin1Fields = ['admin_fullname', 'admin_username'];
        foreach ($admin1Fields as $field) {
            $old = Setting::get($field);
            $new = $request->input($field);
            if ($old != $new) {
                Setting::set($field, $new);
                $credentialsChanged = true;
            }
        }
        if ($request->filled('admin_password')) {
            Setting::set('admin_password', bcrypt($request->input('admin_password')));
            $credentialsChanged = true;
        }

        // Admin 2
        $admin2Fields = ['admin2_fullname', 'admin2_username'];
        foreach ($admin2Fields as $field) {
            $old = Setting::get($field);
            $new = $request->input($field);
            if ($old != $new) {
                Setting::set($field, $new);
                $credentialsChanged = true;
            }
        }
        if ($request->filled('admin2_password')) {
            Setting::set('admin2_password', bcrypt($request->input('admin2_password')));
            $credentialsChanged = true;
        }

        if ($credentialsChanged) $changedSections[] = 'Admin Credentials';

        // 3. Loan Rules Settings
        $loanFields = ['loan_limit', 'loan_duration', 'late_fine_rate', 'grace_period'];
        $loanChanged = false;
        foreach ($loanFields as $field) {
            $old = Setting::get($field);
            $new = $request->input($field);
            if ($old != $new) {
                Setting::set($field, $new);
                $loanChanged = true;
            }
        }
        if ($loanChanged) $changedSections[] = 'Borrowing Rules';

        // 4. WhatsApp Gateway Settings
        $waFields = ['wa_api_token', 'wa_template_register', 'wa_template_borrow', 'wa_template_overdue', 'wa_template_otp'];
        $waChanged = false;
        foreach ($waFields as $field) {
            $old = Setting::get($field);
            $new = $request->input($field);
            if ($old != $new) {
                Setting::set($field, $new);
                $waChanged = true;
            }
        }
        if ($waChanged) $changedSections[] = 'WhatsApp Integration';

        // 5. Popup Settings
        $popupChanged = false;
        $newPopupStatus = $request->has('popup_status') ? '1' : '0';
        if (Setting::get('popup_status', '0') != $newPopupStatus) {
            Setting::set('popup_status', $newPopupStatus);
            $popupChanged = true;
        }

        $newPopupActiveType = $request->input('popup_active_type', 'buka');
        if (Setting::get('popup_active_type', 'buka') != $newPopupActiveType) {
            Setting::set('popup_active_type', $newPopupActiveType);
            $popupChanged = true;
        }

        if ($request->hasFile('popup_buka_image')) {
            $file = $request->file('popup_buka_image');
            $fileName = 'popup_buka_' . time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $uploadPath = public_path('uploads/landing');
            if (!File::exists($uploadPath)) {
                File::makeDirectory($uploadPath, 0755, true);
            }
            $oldFile = Setting::get('popup_buka_image');
            if ($oldFile && File::exists(public_path($oldFile))) {
                File::delete(public_path($oldFile));
            }
            $file->move($uploadPath, $fileName);
            Setting::set('popup_buka_image', 'uploads/landing/' . $fileName);
            $popupChanged = true;
        }

        if ($request->hasFile('popup_tutup_image')) {
            $file = $request->file('popup_tutup_image');
            $fileName = 'popup_tutup_' . time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $uploadPath = public_path('uploads/landing');
            if (!File::exists($uploadPath)) {
                File::makeDirectory($uploadPath, 0755, true);
            }
            $oldFile = Setting::get('popup_tutup_image');
            if ($oldFile && File::exists(public_path($oldFile))) {
                File::delete(public_path($oldFile));
            }
            $file->move($uploadPath, $fileName);
            Setting::set('popup_tutup_image', 'uploads/landing/' . $fileName);
            $popupChanged = true;
        }

        if ($popupChanged) $changedSections[] = 'Popup Settings';

        if (count($changedSections) > 0) {
            AdminLog::create([
                'action' => 'SETTINGS_UPDATE',
                'details' => $adminName . ' updated system settings. Sections changed: ' . implode(', ', $changedSections),
            ]);
            return redirect()->back()->with('success', 'Pengaturan sistem berhasil diperbarui!');
        }

        return redirect()->back()->with('info', 'Tidak ada perubahan pengaturan.');
    }

    /**
     * Clear application cache.
     */
    public function clearCache()
    {
        Artisan::call('cache:clear');
        Artisan::call('config:clear');
        Artisan::call('view:clear');

        $adminName = session('admin_fullname', 'Admin');
        AdminLog::create([
            'action' => 'SYSTEM_MAINTENANCE',
            'details' => $adminName . ' cleared the application cache (views, config, cache).',
        ]);

        return redirect()->back()->with('success', 'Cache aplikasi berhasil dihapus!');
    }

    /**
     * Generate and download database SQL backup.
     */
    public function downloadBackup()
    {
        $tables = [];
        $result = DB::select('SHOW TABLES');
        $dbNameKey = 'Tables_in_' . env('DB_DATABASE', 'nyilih');

        foreach ($result as $row) {
            $tables[] = $row->$dbNameKey;
        }

        $sql = "-- Kanca Tegal Database Backup\n";
        $sql .= "-- Generated: " . now()->toDateTimeString() . "\n\n";
        $sql .= "SET FOREIGN_KEY_CHECKS=0;\n\n";

        foreach ($tables as $table) {
            // Get create table query
            $createTable = DB::select("SHOW CREATE TABLE `{$table}`");
            $sql .= "-- Table structure for table `{$table}`\n";
            $sql .= "DROP TABLE IF EXISTS `{$table}`;\n";
            $sql .= $createTable[0]->{'Create Table'} . ";\n\n";

            // Get insert queries
            $rows = DB::select("SELECT * FROM `{$table}`");
            if (count($rows) > 0) {
                $sql .= "-- Dumping data for table `{$table}`\n";
                foreach ($rows as $row) {
                    $rowArray = (array) $row;
                    $keys = array_keys($rowArray);
                    $escapedKeys = array_map(function($key) {
                        return "`" . addslashes($key) . "`";
                    }, $keys);

                    $values = array_values($rowArray);
                    $escapedValues = array_map(function($value) {
                        if ($value === null) {
                            return 'NULL';
                        }
                        return "'" . addslashes($value) . "'";
                    }, $values);

                    $sql .= "INSERT INTO `{$table}` (" . implode(', ', $escapedKeys) . ") VALUES (" . implode(', ', $escapedValues) . ");\n";
                }
                $sql .= "\n";
            }
        }

        $sql .= "SET FOREIGN_KEY_CHECKS=1;\n";

        $adminName = session('admin_fullname', 'Admin');
        AdminLog::create([
            'action' => 'DATABASE_BACKUP',
            'details' => $adminName . ' downloaded database backup SQL file.',
        ]);

        $fileName = 'backup_' . env('DB_DATABASE', 'nyilih') . '_' . date('Ymd_His') . '.sql';

        return response($sql, 200)
            ->header('Content-Type', 'application/sql')
            ->header('Content-Disposition', 'attachment; filename="' . $fileName . '"');
    }

    /**
     * Handle admin login validation.
     */
    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        $adminUser = Setting::get('admin_username', 'admin');
        $adminPassHash = Setting::get('admin_password');

        $admin2User = Setting::get('admin2_username', 'admin2');
        $admin2PassHash = Setting::get('admin2_password');

        $inputUser = $request->input('username');
        $inputPass = $request->input('password');

        $authenticated = false;
        $fullname = 'Admin';

        if ($inputUser === $adminUser) {
            if (empty($adminPassHash)) {
                // Fallback to default credentials
                if ($inputPass === 'admin') {
                    $authenticated = true;
                    $fullname = Setting::get('admin_fullname', 'Admin');
                }
            } else {
                if (\Illuminate\Support\Facades\Hash::check($inputPass, $adminPassHash)) {
                    $authenticated = true;
                    $fullname = Setting::get('admin_fullname', 'Admin');
                }
            }
        } elseif ($inputUser === $admin2User) {
            if (empty($admin2PassHash)) {
                // Fallback to default credentials
                if ($inputPass === 'admin2') {
                    $authenticated = true;
                    $fullname = Setting::get('admin2_fullname', 'Admin 2');
                }
            } else {
                if (\Illuminate\Support\Facades\Hash::check($inputPass, $admin2PassHash)) {
                    $authenticated = true;
                    $fullname = Setting::get('admin2_fullname', 'Admin 2');
                }
            }
        }

        if ($authenticated) {
            session([
                'admin_logged_in' => true,
                'admin_username' => $inputUser,
                'admin_fullname' => $fullname,
            ]);
            
            // Log successful login
            AdminLog::create([
                'action' => 'ADMIN_LOGIN_SUCCESS',
                'details' => $fullname . ' (' . $inputUser . ') successfully logged in from IP ' . $request->ip(),
            ]);

            return redirect('/admin/dashboard');
        }

        // Log failed login attempt
        AdminLog::create([
            'action' => 'ADMIN_LOGIN_FAILED',
            'details' => 'Failed admin login attempt using username: ' . $inputUser,
        ]);

        return redirect()->back()->withErrors([
            'username' => 'Username atau Password salah.',
        ])->withInput();
    }

    /**
     * Handle admin logout.
     */
    public function logout()
    {
        session()->forget(['admin_logged_in', 'admin_username', 'admin_fullname']);
        return redirect('/admin/login')->with('success', 'Anda berhasil keluar.');
    }
}
