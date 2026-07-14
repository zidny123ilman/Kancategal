<?php

namespace App\Http\Controllers;

use App\Models\Ebook;
use App\Models\EbookPeminjaman;
use App\Http\Requests\StoreEbookRequest;
use App\Http\Requests\UpdateEbookRequest;
use App\Models\AdminLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AdminEbookController extends Controller
{
    /**
     * Display a listing of Ebooks for admin.
     */
    public function index(Request $request)
    {
        $search = $request->query('q');
        $query = Ebook::query();

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('judul', 'like', '%' . $search . '%')
                  ->orWhere('penulis', 'like', '%' . $search . '%')
                  ->orWhere('kategori', 'like', '%' . $search . '%');
            });
        }

        $ebooks = $query->orderBy('created_at', 'desc')->paginate(10)->withQueryString();
        $totalEbooks = Ebook::count();

        return view('pages.admin.ebook.index', compact('ebooks', 'totalEbooks'));
    }

    /**
     * Show the form for creating a new Ebook.
     */
    public function create()
    {
        // Get categories for dropdown suggestions
        $categories = Ebook::select('kategori')->distinct()->whereNotNull('kategori')->pluck('kategori')->toArray();
        $defaultCategories = ['BUDAYA', 'SEJARAH', 'SASTRA', 'TEKNOLOGI', 'SENI', 'POLITIK', 'FILOSOFI', 'SOSIOLOGI'];
        $categories = array_unique(array_merge($defaultCategories, array_map('strtoupper', $categories)));
        sort($categories);

        return view('pages.admin.ebook.tambah', compact('categories'));
    }

    /**
     * Store a newly created Ebook in storage.
     */
    public function store(StoreEbookRequest $request)
    {
        $data = $request->validated();

        // Handle category input
        if (strtoupper($data['kategori']) === 'LAINNYA' && $request->filled('kategori_baru')) {
            $data['kategori'] = strtoupper(trim($request->input('kategori_baru')));
        } else {
            $data['kategori'] = strtoupper($data['kategori']);
        }

        // Handle cover file upload
        if ($request->hasFile('cover')) {
            $data['cover'] = $request->file('cover')->store('ebook-cover', 'public');
        }

        // Handle pdf file upload
        if ($request->hasFile('file_pdf')) {
            $data['file_pdf'] = $request->file('file_pdf')->store('ebooks', 'public');
        }

        // Generate slug
        $data['slug'] = Str::slug($data['judul']);

        $ebook = Ebook::create($data);

        // Log the action
        $adminName = session('admin_fullname', 'Admin');
        AdminLog::create([
            'action' => 'EBOOK CREATED',
            'details' => 'Admin (' . $adminName . ') uploaded E-Book "' . $ebook->judul . '"',
        ]);

        return redirect('/admin/ebook')->with('success', 'E-Book baru berhasil diunggah!');
    }

    /**
     * Display the specified Ebook.
     */
    public function show($id)
    {
        $ebook = Ebook::findOrFail($id);

        // Fetch stats
        $totalBorrowed = EbookPeminjaman::where('ebook_id', $id)->count();
        $totalReaders = EbookPeminjaman::where('ebook_id', $id)->distinct('user_id')->count('user_id');
        $averageRating = EbookPeminjaman::where('ebook_id', $id)->whereNotNull('rating')->avg('rating') ?? 0;
        $totalReviews = EbookPeminjaman::where('ebook_id', $id)->whereNotNull('rating')->count();
        $averageProgress = EbookPeminjaman::where('ebook_id', $id)->avg('progress_persen') ?? 0;

        return view('pages.admin.ebook.detail', compact(
            'ebook',
            'totalBorrowed',
            'totalReaders',
            'averageRating',
            'totalReviews',
            'averageProgress'
        ));
    }

    /**
     * Show the form for editing the specified Ebook.
     */
    public function edit($id)
    {
        $ebook = Ebook::findOrFail($id);
        
        $categories = Ebook::select('kategori')->distinct()->whereNotNull('kategori')->pluck('kategori')->toArray();
        $defaultCategories = ['BUDAYA', 'SEJARAH', 'SASTRA', 'TEKNOLOGI', 'SENI', 'POLITIK', 'FILOSOFI', 'SOSIOLOGI'];
        $categories = array_unique(array_merge($defaultCategories, array_map('strtoupper', $categories)));
        sort($categories);

        return view('pages.admin.ebook.edit', compact('ebook', 'categories'));
    }

    /**
     * Update the specified Ebook in storage.
     */
    public function update(UpdateEbookRequest $request, $id)
    {
        $ebook = Ebook::findOrFail($id);
        $data = $request->validated();

        // Handle category input
        if (strtoupper($data['kategori']) === 'LAINNYA' && $request->filled('kategori_baru')) {
            $data['kategori'] = strtoupper(trim($request->input('kategori_baru')));
        } else {
            $data['kategori'] = strtoupper($data['kategori']);
        }

        // Handle cover update
        if ($request->hasFile('cover')) {
            if ($ebook->cover) {
                Storage::disk('public')->delete($ebook->cover);
            }
            $data['cover'] = $request->file('cover')->store('ebook-cover', 'public');
        }

        // Handle pdf update
        if ($request->hasFile('file_pdf')) {
            if ($ebook->file_pdf) {
                Storage::disk('public')->delete($ebook->file_pdf);
            }
            $data['file_pdf'] = $request->file('file_pdf')->store('ebooks', 'public');
        }

        $ebook->update($data);

        // Log the action
        $adminName = session('admin_fullname', 'Admin');
        AdminLog::create([
            'action' => 'EBOOK UPDATED',
            'details' => 'Admin (' . $adminName . ') updated E-Book "' . $ebook->judul . '"',
        ]);

        return redirect('/admin/ebook')->with('success', 'E-Book berhasil diperbarui!');
    }

    /**
     * Remove the specified Ebook from storage.
     */
    public function destroy($id)
    {
        $ebook = Ebook::findOrFail($id);
        $title = $ebook->judul;

        // Delete files
        if ($ebook->cover) {
            Storage::disk('public')->delete($ebook->cover);
        }
        if ($ebook->file_pdf) {
            Storage::disk('public')->delete($ebook->file_pdf);
        }

        $ebook->delete();

        // Log the action
        $adminName = session('admin_fullname', 'Admin');
        AdminLog::create([
            'action' => 'EBOOK DELETED',
            'details' => 'Admin (' . $adminName . ') deleted E-Book "' . $title . '"',
        ]);

        return redirect('/admin/ebook')->with('success', 'E-Book berhasil dihapus!');
    }
}
