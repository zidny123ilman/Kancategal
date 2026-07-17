<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use App\Models\AdminLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;

class AdminKontenController extends Controller
{
    /**
     * Display content editor panel.
     */
    public function index()
    {
        // Get settings, fallback to defaults if not set in DB
        $settings = [
            'hero_title' => Setting::get('hero_title', "KANCA\nTEGAL"),
            'hero_subtitle' => Setting::get('hero_subtitle', "A creative community that dedicated to the preservation of local wisdom and the cultivation of modern literacy discussion in Tegal."),
            'hero_image' => Setting::get('hero_image', 'https://images.unsplash.com/photo-1544947950-fa07a98d237f?auto=format&fit=crop&q=80&w=1000'),
            'schedule_info' => Setting::get('schedule_info', "Kanca Tegal library open everyday on 09.00-18.00."),
            'map_label' => Setting::get('map_label', "LAPAK KAMI: Alun-alun Kota Tegal (Setiap Minggu Pagi)"),
            'map_embed_url' => Setting::get('map_embed_url', "https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3961.037107771746!2d109.1369796!3d-6.886123!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e6fb9e2b17a1b3b%3A0xe54fb7be43f4f1a2!2sAlun-Alun%20Kota%20Tegal!5e0!3m2!1sid!2sid!4v1719400000000!5m2!1sid!2sid"),
        ];

        // Retrieve only content configuration logs from the last 5 days
        $logs = AdminLog::where('action', 'LIKE', 'CONTENT_%')
            ->where('created_at', '>=', now()->subDays(5))
            ->orderBy('created_at', 'desc')
            ->get();

        return view('pages.admin.konten.index', compact('settings', 'logs'));
    }

    /**
     * Update landing page settings.
     */
    public function update(Request $request)
    {
        $request->validate([
            'hero_title' => 'required|string|max:255',
            'hero_subtitle' => 'required|string',
            'schedule_info' => 'required|string|max:255',
            'hero_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'map_label' => 'required|string|max:255',
            'map_embed_url' => 'required|string',
        ]);

        $adminName = session('admin_fullname', 'Admin');

        // Check each value to see if it changed, and log specific changes
        $fields = [
            'hero_title' => 'HERO_TITLE',
            'hero_subtitle' => 'HERO_SUBTITLE',
            'schedule_info' => 'SCHEDULE',
            'map_label' => 'MAP_LABEL',
            'map_embed_url' => 'MAP_EMBED',
        ];

        $hasChanges = false;

        foreach ($fields as $key => $actionTag) {
            $oldVal = Setting::get($key);
            $newVal = $request->input($key);

            // Normalize newlines for comparison
            if (str_replace("\r", "", $oldVal) !== str_replace("\r", "", $newVal)) {
                Setting::set($key, $newVal);
                AdminLog::create([
                    'action' => 'CONTENT_' . $actionTag,
                    'details' => $adminName . ' updated ' . ucwords(str_replace('_', ' ', $key)) . ' to: ' . substr($newVal, 0, 60) . (strlen($newVal) > 60 ? '...' : ''),
                ]);
                $hasChanges = true;
            }
        }

        // Handle Hero Image Upload
        if ($request->hasFile('hero_image')) {
            // Remove old image file if it was a local file
            $oldImage = Setting::get('hero_image');
            if ($oldImage && !str_starts_with($oldImage, 'http') && File::exists(public_path($oldImage))) {
                File::delete(public_path($oldImage));
            }

            $path = $request->file('hero_image')->store('landing', 'public');
            $newPath = 'storage/' . $path;
            Setting::set('hero_image', $newPath);

            AdminLog::create([
                'action' => 'CONTENT_HERO_IMAGE',
                'details' => $adminName . ' uploaded a new Hero Background image.',
            ]);
            $hasChanges = true;
        }

        if ($hasChanges) {
            return redirect()->back()->with('success', 'Konfigurasi landing page berhasil diperbarui!');
        } else {
            return redirect()->back()->with('info', 'Tidak ada perubahan konfigurasi.');
        }
    }
}
