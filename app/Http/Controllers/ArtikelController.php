<?php

namespace App\Http\Controllers;

use App\Models\Artikel;
use App\Models\Setting;
use App\Services\WhatsAppService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class ArtikelController extends Controller
{
    /**
     * Display public articles landing page.
     */
    public function publicIndex(Request $request)
    {
        $search = $request->query('q');

        $query = Artikel::where('status', 'approved');
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('judul', 'like', '%' . $search . '%')
                  ->orWhere('isi', 'like', '%' . $search . '%')
                  ->orWhere('nama_uploader', 'like', '%' . $search . '%')
                  ->orWhere('kategori', 'like', '%' . $search . '%');
            });
        }

        $mostRead = (clone $query)->orderBy('views', 'desc')->take(10)->get();
        $latest = (clone $query)->orderBy('tanggal_upload', 'desc')->orderBy('created_at', 'desc')->take(10)->get();

        $favorites = collect();
        if (Auth::check()) {
            $favorites = Artikel::where('status', 'approved')
                ->whereHas('favoritedBy', function($q) {
                    $q->where('user_id', Auth::id());
                })->get();
        }

        return view('pages.artikel', compact('mostRead', 'latest', 'favorites'));
    }

    public function publicDetail($slug)
    {
        $artikel = Artikel::where('status', 'approved')->where('slug', $slug)->firstOrFail();
        $artikel->increment('views');

        $otherArticles = Artikel::where('status', 'approved')
            ->where('id', '!=', $artikel->id)
            ->orderBy('created_at', 'desc')
            ->take(3)
            ->get();

        return view('pages.detailartikel', compact('artikel', 'otherArticles'));
    }

    public function showUploadForm()
    {
        if (!Auth::check()) {
            return redirect('/login')->with('error', 'Silakan masuk terlebih dahulu untuk mengunggah artikel.');
        }

        if (!Auth::user()->can_upload_artikel) {
            return redirect('/artikel')->with('error', 'Anda tidak memiliki hak akses untuk mengunggah artikel.');
        }

        // Clean up rejected articles older than 5 days (120 hours)
        $oldRejected = Artikel::where('status', 'rejected')
            ->where('updated_at', '<', now()->subDays(5))
            ->get();

        foreach ($oldRejected as $oldArt) {
            if ($oldArt->foto_utama && File::exists(public_path($oldArt->foto_utama))) {
                File::delete(public_path($oldArt->foto_utama));
            }
            if ($oldArt->foto_pendukung && File::exists(public_path($oldArt->foto_pendukung))) {
                File::delete(public_path($oldArt->foto_pendukung));
            }
            $oldArt->delete();
        }

        $draft = Artikel::where('user_id', Auth::id())->where('status', 'draft')->orderBy('updated_at', 'desc')->first();
        $rejectedArticles = Artikel::where('user_id', Auth::id())->where('status', 'rejected')->orderBy('updated_at', 'desc')->get();

        return view('pages.uploadartikel', compact('draft', 'rejectedArticles'));
    }

    /**
     * Store the submitted article.
     */
    public function store(Request $request)
    {
        if (!Auth::check() || !Auth::user()->can_upload_artikel) {
            return redirect('/artikel')->with('error', 'Akses ditolak.');
        }

        $action = $request->input('action', 'publish');
        
        // Find existing draft
        $draft = Artikel::where('user_id', Auth::id())->where('status', 'draft')->orderBy('updated_at', 'desc')->first();

        // 1. Handle discard draft action
        if ($action === 'discard') {
            if ($draft) {
                // Delete files if they exist
                if (!empty($draft->foto_utama) && $draft->foto_utama !== 'uploads/articles/default.jpg' && File::exists(public_path($draft->foto_utama))) {
                    File::delete(public_path($draft->foto_utama));
                }
                if (!empty($draft->foto_pendukung) && File::exists(public_path($draft->foto_pendukung))) {
                    File::delete(public_path($draft->foto_pendukung));
                }
                $draft->delete();
            }
            return redirect('/upload-artikel')->with('success', 'Draft artikel berhasil dihapus.');
        }

        $isDraft = $action === 'draft';

        // 2. Build validation rules
        $rules = [
            'judul' => $isDraft ? 'nullable|string|max:255' : 'required|string|max:255',
            'nama_uploader' => 'required|string|max:255',
            'tanggal_upload' => 'required|date',
            'isi' => $isDraft ? 'nullable|string' : 'required|string',
            'kategori' => 'required|string|max:100',
            'keywords' => $isDraft ? 'nullable|string|max:255' : 'required|string|max:255',
            'foto_pendukung' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ];

        // If publishing, cover is required unless already present in draft
        if (!$isDraft) {
            if (!$draft || empty($draft->foto_utama) || $draft->foto_utama === 'uploads/articles/default.jpg') {
                $rules['foto_utama'] = 'required|image|mimes:jpeg,png,jpg,webp|max:2048';
            } else {
                $rules['foto_utama'] = 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048';
            }
        } else {
            $rules['foto_utama'] = 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048';
        }

        $request->validate($rules);

        // Determine category value (handle 'LAINNYA')
        $kategori = $request->kategori;
        if (strtoupper($kategori) === 'LAINNYA' && $request->filled('kategori_baru')) {
            $kategori = strtoupper($request->kategori_baru);
        }

        // Determine title & body fallback for draft
        $judul = $request->judul;
        if (empty($judul)) {
            $judul = $isDraft ? 'Draf Tanpa Judul' : 'Artikel Tanpa Judul';
        }
        $isi = $request->isi ?? '';

        $articleData = [
            'judul' => $judul,
            'nama_uploader' => $request->nama_uploader,
            'user_id' => Auth::id(),
            'tanggal_upload' => $request->tanggal_upload,
            'isi' => $isi,
            'kategori' => strtoupper($kategori),
            'keywords' => $request->keywords,
            'status' => $isDraft ? 'draft' : 'pending',
        ];

        // Ensure upload directory exists
        $uploadPath = public_path('uploads/articles');
        if (!File::exists($uploadPath)) {
            File::makeDirectory($uploadPath, 0755, true);
        }

        // Handle cover photo
        if ($request->hasFile('foto_utama')) {
            $file = $request->file('foto_utama');
            $fileName = time() . '_main_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move($uploadPath, $fileName);
            $articleData['foto_utama'] = 'uploads/articles/' . $fileName;
        } elseif ($draft && !empty($draft->foto_utama)) {
            $articleData['foto_utama'] = $draft->foto_utama;
        } else {
            $articleData['foto_utama'] = 'uploads/articles/default.jpg';
        }

        // Handle supporting photo
        if ($request->hasFile('foto_pendukung')) {
            $file = $request->file('foto_pendukung');
            $fileName = time() . '_support_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move($uploadPath, $fileName);
            $articleData['foto_pendukung'] = 'uploads/articles/' . $fileName;
        } elseif ($draft && !empty($draft->foto_pendukung)) {
            $articleData['foto_pendukung'] = $draft->foto_pendukung;
        }

        if ($draft) {
            $draft->update($articleData);
        } else {
            $draft = Artikel::create($articleData);
        }

        if ($isDraft) {
            return redirect('/upload-artikel')->with('success', 'Draft artikel berhasil disimpan.');
        } else {
            return redirect('/artikel')->with('success', 'Artikel berhasil diunggah! Menunggu persetujuan admin.');
        }
    }

    /**
     * Display admin article management dashboard.
     */
    public function adminIndex(Request $request)
    {
        $status = $request->query('status', 'all');

        $query = Artikel::query();

        if ($status !== 'all') {
            if ($status === 'publish') {
                $query->where('status', 'approved');
            } else {
                $query->where('status', $status);
            }
        } else {
            $query->where('status', '!=', 'draft');
        }

        $search = $request->query('q');
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('judul', 'like', '%' . $search . '%')
                  ->orWhere('isi', 'like', '%' . $search . '%')
                  ->orWhere('nama_uploader', 'like', '%' . $search . '%')
                  ->orWhere('kategori', 'like', '%' . $search . '%');
            });
        }

        $articles = $query->orderBy('created_at', 'desc')->paginate(5)->withQueryString();

        // Calculate counts for each status to display in tab badges.
        $countPending = Artikel::where('status', 'pending')->count();
        $countApproved = Artikel::where('status', 'approved')->count();
        $countRejected = Artikel::where('status', 'rejected')->count();
        $countAll = Artikel::where('status', '!=', 'draft')->count();

        return view('pages.admin.artikel.index', compact('articles', 'status', 'countPending', 'countApproved', 'countRejected', 'countAll'));
    }

    /**
     * Display custom admin detail view for a specific article.
     */
    public function adminDetail($id)
    {
        $artikel = Artikel::findOrFail($id);
        return view('pages.admin.artikel.detail', compact('artikel'));
    }

    /**
     * Approve article.
     */
    public function approve($id)
    {
        $article = Artikel::findOrFail($id);
        $article->update([
            'status' => 'approved',
            'alasan_ditolak' => null
        ]);

        // Send WhatsApp Notification to the uploader
        $user = $article->user;
        if ($user && $user->whatsapp) {
            $template = Setting::get('wa_template_article_approved', 'Halo {name}, artikel Anda yang berjudul "{title}" telah disetujui oleh admin. Terima kasih!');
            $message = str_replace(
                ['{name}', '{title}'],
                [$user->name, $article->judul],
                $template
            );
            WhatsAppService::send($user->whatsapp, $message);
        }

        return redirect('/admin/artikel')->with('success', 'Artikel "' . $article->judul . '" berhasil disetujui dan diterbitkan!');
    }

    /**
     * Reject article.
     */
    public function reject(Request $request, $id)
    {
        $request->validate([
            'alasan_ditolak' => 'required|string'
        ]);

        $article = Artikel::findOrFail($id);
        $article->update([
            'status' => 'rejected',
            'alasan_ditolak' => $request->input('alasan_ditolak')
        ]);

        // Send WhatsApp Notification to the uploader
        $user = $article->user;
        if ($user && $user->whatsapp) {
            $template = Setting::get('wa_template_article_rejected', 'Halo {name}, artikel Anda yang berjudul "{title}" ditolak oleh admin dengan alasan: {reason}. Silakan perbaiki.');
            $message = str_replace(
                ['{name}', '{title}', '{reason}'],
                [$user->name, $article->judul, $article->alasan_ditolak],
                $template
            );
            WhatsAppService::send($user->whatsapp, $message);
        }

        return redirect('/admin/artikel')->with('success', 'Artikel "' . $article->judul . '" telah ditolak.');
    }

    /**
     * Delete article.
     */
    public function destroy($id)
    {
        $article = Artikel::findOrFail($id);

        // Delete images from storage if exists
        if ($article->foto_utama && File::exists(public_path($article->foto_utama))) {
            File::delete(public_path($article->foto_utama));
        }
        if ($article->foto_pendukung && File::exists(public_path($article->foto_pendukung))) {
            File::delete(public_path($article->foto_pendukung));
        }

        $article->delete();

        return redirect('/admin/artikel')->with('success', 'Artikel berhasil dihapus dari arsip.');
    }

    public function toggleFavorite($id)
    {
        $artikel = Artikel::findOrFail($id);
        $user = Auth::user();

        if ($artikel->favoritedBy()->where('user_id', $user->id)->exists()) {
            $artikel->favoritedBy()->detach($user->id);
            return back()->with('success', 'Artikel dihapus dari favorit.');
        } else {
            $artikel->favoritedBy()->attach($user->id);
            return back()->with('success', 'Artikel ditambahkan ke favorit.');
        }
    }
}
