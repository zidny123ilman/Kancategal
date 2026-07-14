<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Artikel;
use App\Models\Review;
use App\Models\Peminjaman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class BukuController extends Controller
{
    /**
     * Display landing page with weekly picks (latest 4 books).
     */
    public function landingPage()
    {
        $weeklyBooks = Buku::where('status_publish', 'publish')->orderBy('created_at', 'desc')->take(4)->get();
        $articles = Artikel::where('status', 'approved')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();
        $reviews = Review::orderBy('created_at', 'desc')->get();
        
        $totalBuku = Buku::where('status_publish', 'publish')->count();
        $totalAnggota = \App\Models\User::count();
        
        return view('pages.home', compact('weeklyBooks', 'articles', 'reviews', 'totalBuku', 'totalAnggota'));
    }

    /**
     * Display public books archive list.
     */
    public function userIndex(Request $request)
    {
        $category = $request->query('category');
        $search = $request->query('q');
        $showOnlyFavorites = $request->query('favorite') == 1;
        
        $query = Buku::where('status_publish', 'publish');

        if ($showOnlyFavorites) {
            if (\Illuminate\Support\Facades\Auth::check()) {
                $favBookIds = \App\Models\Favorite::where('user_id', \Illuminate\Support\Facades\Auth::id())->pluck('buku_id')->toArray();
                $query->whereIn('id', $favBookIds);
            } else {
                return redirect('/login')->with('error', 'Silakan masuk terlebih dahulu untuk melihat daftar buku favorit Anda.');
            }
        }

        if ($category && strtolower($category) !== 'semua') {
            $query->where('kategori', 'like', $category);
        }

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('judul', 'like', '%' . $search . '%')
                  ->orWhere('penulis', 'like', '%' . $search . '%')
                  ->orWhere('sinopsis', 'like', '%' . $search . '%')
                  ->orWhere('kategori', 'like', '%' . $search . '%');
            });
        }
        
        $books = $query->orderBy('created_at', 'desc')->paginate(12)->withQueryString();
        
        // Get unique categories for filtering pills
        $categories = Buku::where('status_publish', 'publish')->select('kategori')->distinct()->whereNotNull('kategori')->where('kategori', '!=', '')->pluck('kategori')->toArray();

        $userFavorites = [];
        if (\Illuminate\Support\Facades\Auth::check()) {
            $userFavorites = \App\Models\Favorite::where('user_id', \Illuminate\Support\Facades\Auth::id())->pluck('buku_id')->toArray();
        }

        return view('pages.Buku', compact('books', 'categories', 'category', 'userFavorites', 'showOnlyFavorites'));
    }

    /**
     * Display details of a specific book.
     */
    public function userDetail($id)
    {
        $book = Buku::where('status_publish', 'publish')->findOrFail($id);
        
        $activePeminjaman = null;
        if (\Illuminate\Support\Facades\Auth::check()) {
            $activePeminjaman = \App\Models\Peminjaman::where('user_id', \Illuminate\Support\Facades\Auth::id())
                ->where('buku_id', $id)
                ->whereIn('status', ['pending_pinjam', 'aktif', 'pending_kembali'])
                ->first();
        }
        
        // Calculate status card variables
        $statusText = 'AVAILABLE IN ARCHIVE';
        $statusIcon = 'fa-check-circle';
        $statusColor = '#137333'; // green

        if (\Illuminate\Support\Facades\Auth::check() && $activePeminjaman) {
            if ($activePeminjaman->status === 'pending_pinjam') {
                $statusText = 'MENUNGGU KONFIRMASI PINJAM';
                $statusIcon = 'fa-clock';
                $statusColor = '#1A73E8'; // blue
            } elseif ($activePeminjaman->status === 'aktif') {
                $statusText = 'DIPINJAM (SEDANG ANDA PINJAM)';
                $statusIcon = 'fa-book-reader';
                $statusColor = '#92400E'; // amber/brown
            } elseif ($activePeminjaman->status === 'pending_kembali') {
                $statusText = 'MENUNGGU KONFIRMASI KEMBALI';
                $statusIcon = 'fa-clock';
                $statusColor = '#E27B00'; // orange
            }
        } elseif (strtolower($book->status) === 'dipinjam') {
            $statusText = 'DIPINJAM';
            $statusIcon = 'fa-times-circle';
            $statusColor = '#92400E'; // amber/brown
        }

        $resensis = \App\Models\Peminjaman::with('user')
            ->where('buku_id', $id)
            ->whereNotNull('resensi_rating')
            ->orderBy('updated_at', 'desc')
            ->get();

        $isFavorited = false;
        if (\Illuminate\Support\Facades\Auth::check()) {
            $isFavorited = \App\Models\Favorite::where('user_id', \Illuminate\Support\Facades\Auth::id())
                ->where('buku_id', $id)
                ->exists();
        }

        return view('pages.detailbuku', compact('book', 'activePeminjaman', 'statusText', 'statusIcon', 'statusColor', 'resensis', 'isFavorited'));
    }

    /* ==========================================================================
       ADMIN METHODS
       ========================================================================== */

    /**
     * Display admin book management list.
     */
    public function index(Request $request)
    {
        $genre = $request->query('genre');
        $availability = $request->query('availability');

        $query = Buku::query();

        if ($genre && strtolower($genre) !== 'all') {
            $query->where('kategori', 'like', $genre);
        }

        if ($availability && strtolower($availability) !== 'all') {
            if (strtolower($availability) === 'publish') {
                $query->where('status_publish', 'publish');
            } elseif (strtolower($availability) === 'draft') {
                $query->where('status_publish', 'draft');
            } else {
                $statusVal = strtolower($availability) === 'borrowed' ? 'dipinjam' : strtolower($availability);
                $query->where('status', $statusVal);
            }
        }
        $search = $request->query('q');
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('judul', 'like', '%' . $search . '%')
                  ->orWhere('penulis', 'like', '%' . $search . '%')
                  ->orWhere('sinopsis', 'like', '%' . $search . '%')
                  ->orWhere('kategori', 'like', '%' . $search . '%')
                  ->orWhere('isbn', 'like', '%' . $search . '%');
            });
        }

        $books = $query->orderBy('created_at', 'desc')->paginate(10)->withQueryString();
        $totalCollection = Buku::count();

        // Get unique categories for filtering pills dynamically
        $genres = Buku::select('kategori')->distinct()->whereNotNull('kategori')->where('kategori', '!=', '')->pluck('kategori')->toArray();

        return view('pages.admin.buku.index', compact('books', 'genres', 'genre', 'availability', 'totalCollection'));
    }

    /**
     * Show form to upload/create a new book.
     */
    public function tambah()
    {
        $defaultCategories = ['BUDAYA', 'SEJARAH', 'SASTRA', 'TEKNOLOGI', 'SENI', 'POLITIK', 'FILOSOFI', 'SOSIOLOGI'];
        $dbCategories = Buku::select('kategori')->distinct()->pluck('kategori')->toArray();
        $dbCategories = array_map('strtoupper', $dbCategories);
        $categories = array_unique(array_merge($defaultCategories, $dbCategories));
        $categories = array_filter($categories, function($c) {
            return $c !== 'LAINNYA' && !empty($c);
        });
        sort($categories);

        return view('pages.admin.buku.tambah', compact('categories'));
    }

    /**
     * Store the newly uploaded book in the database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'foto' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
            'judul' => 'required|string|max:255',
            'penulis' => 'required|string|max:255',
            'penerbit' => 'required|string|max:255',
            'jumlah_halaman' => 'required|integer|min:1',
            'sinopsis' => 'required|string',
            'bahasa' => 'required|string|max:100',
            'kategori' => 'required|string|max:100',
            'kategori_baru' => 'nullable|required_if:kategori,LAINNYA|string|max:100',
            'isbn' => 'required|string|max:50',
            'tentang_penulis' => 'nullable|string',
            'status_publish' => 'required|string|in:publish,draft',
        ]);

        $bookData = $request->only([
            'judul',
            'penulis',
            'penerbit',
            'jumlah_halaman',
            'sinopsis',
            'bahasa',
            'kategori',
            'isbn',
            'tentang_penulis',
            'status_publish',
        ]);

        if (strtoupper($bookData['kategori']) === 'LAINNYA' && $request->filled('kategori_baru')) {
            $bookData['kategori'] = strtoupper(trim($request->input('kategori_baru')));
        } else {
            $bookData['kategori'] = strtoupper($bookData['kategori']);
        }

        // Handle File Upload
        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            
            // Define the uploads directory inside public folder
            $uploadPath = public_path('uploads/books');
            
            // Ensure folder exists
            if (!File::exists($uploadPath)) {
                File::makeDirectory($uploadPath, 0755, true);
            }
            
            // Move file
            $file->move($uploadPath, $fileName);
            
            // Save relative URL path to DB
            $bookData['foto'] = 'uploads/books/' . $fileName;
        }

        // Set default status
        $bookData['status'] = 'ready';

        // Create book
        Buku::create($bookData);

        return redirect('/admin/buku')->with('success', 'Buku baru berhasil diunggah!');
    }

    /**
     * Delete a book from the database.
     */
    public function destroy($id)
    {
        $book = Buku::findOrFail($id);
        
        // Delete the photo file if it exists locally in uploads
        if ($book->foto && File::exists(public_path($book->foto))) {
            File::delete(public_path($book->foto));
        }
        
        $book->delete();

        return redirect('/admin/buku')->with('success', 'Buku berhasil dihapus dari arsip.');
    }

    /**
     * Show the edit form for a specific book.
     */
    public function edit($id)
    {
        $buku = Buku::findOrFail($id);

        $defaultCategories = ['BUDAYA', 'SEJARAH', 'SASTRA', 'TEKNOLOGI', 'SENI', 'POLITIK', 'FILOSOFI', 'SOSIOLOGI'];
        $dbCategories = Buku::select('kategori')->distinct()->pluck('kategori')->toArray();
        $dbCategories = array_map('strtoupper', $dbCategories);
        $categories = array_unique(array_merge($defaultCategories, $dbCategories));
        $categories = array_filter($categories, function($c) {
            return $c !== 'LAINNYA' && !empty($c);
        });
        sort($categories);

        return view('pages.admin.buku.edit', compact('buku', 'categories'));
    }

    /**
     * Update the book details in the database.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'judul' => 'required|string|max:255',
            'penulis' => 'required|string|max:255',
            'penerbit' => 'required|string|max:255',
            'jumlah_halaman' => 'required|integer|min:1',
            'sinopsis' => 'required|string',
            'bahasa' => 'required|string|max:100',
            'kategori' => 'required|string|max:100',
            'kategori_baru' => 'nullable|required_if:kategori,LAINNYA|string|max:100',
            'isbn' => 'required|string|max:50',
            'tentang_penulis' => 'nullable|string',
            'status_publish' => 'required|string|in:publish,draft',
        ]);

        $buku = Buku::findOrFail($id);
        $bookData = $request->only([
            'judul',
            'penulis',
            'penerbit',
            'jumlah_halaman',
            'sinopsis',
            'bahasa',
            'kategori',
            'isbn',
            'tentang_penulis',
            'status_publish',
        ]);

        if (strtoupper($bookData['kategori']) === 'LAINNYA' && $request->filled('kategori_baru')) {
            $bookData['kategori'] = strtoupper(trim($request->input('kategori_baru')));
        } else {
            $bookData['kategori'] = strtoupper($bookData['kategori']);
        }

        // Handle File Upload if provided
        if ($request->hasFile('foto')) {
            // Delete old photo if it exists locally in uploads and is not a default/external URL
            if ($buku->foto && File::exists(public_path($buku->foto))) {
                File::delete(public_path($buku->foto));
            }

            $file = $request->file('foto');
            $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $uploadPath = public_path('uploads/books');
            
            if (!File::exists($uploadPath)) {
                File::makeDirectory($uploadPath, 0755, true);
            }
            
            $file->move($uploadPath, $fileName);
            $bookData['foto'] = 'uploads/books/' . $fileName;
        }

        $buku->update($bookData);

        return redirect('/admin/buku')->with('success', 'Data buku berhasil diperbarui!');
    }

    /**
     * Export all loans as an Excel-compatible sheet (.xls).
     */
    public function exportPeminjamanExcel()
    {
        $loans = Peminjaman::with(['user', 'buku'])->orderBy('tanggal_pinjam', 'desc')->get();

        $fileName = 'laporan_peminjaman_' . date('Ymd_His') . '.xls';

        $headers = [
            'Content-Type' => 'application/vnd.ms-excel',
            'Content-Disposition' => 'attachment; filename="' . $fileName . '"',
            'Cache-Control' => 'max-age=0',
        ];

        $callback = function() use ($loans) {
            echo '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40">';
            echo '<head><meta charset="utf-8"></head>';
            echo '<body>';
            echo '<table border="1">';
            echo '<thead>';
            echo '<tr>';
            echo '<th>ID</th>';
            echo '<th>Nama Peminjam</th>';
            echo '<th>No WhatsApp</th>';
            echo '<th>Judul Buku</th>';
            echo '<th>Kategori/Genre</th>';
            echo '<th>Tanggal Pinjam</th>';
            echo '<th>Masa Pengembalian</th>';
            echo '<th>Tanggal Dikembalikan</th>';
            echo '<th>Status</th>';
            echo '</tr>';
            echo '</thead>';
            echo '<tbody>';
            foreach ($loans as $loan) {
                echo '<tr>';
                echo '<td>' . $loan->id . '</td>';
                echo '<td>' . ($loan->user->name ?? '-') . '</td>';
                echo '<td>' . ($loan->user->whatsapp ?? '-') . '</td>';
                echo '<td>' . ($loan->buku->judul ?? '-') . '</td>';
                echo '<td>' . ($loan->buku->kategori ?? '-') . '</td>';
                echo '<td>' . ($loan->tanggal_pinjam ? date('d-m-Y', strtotime($loan->tanggal_pinjam)) : '-') . '</td>';
                echo '<td>' . ($loan->tanggal_kembali ? date('d-m-Y', strtotime($loan->tanggal_kembali)) : '-') . '</td>';
                echo '<td>' . ($loan->tanggal_dikembalikan ? date('d-m-Y', strtotime($loan->tanggal_dikembalikan)) : '-') . '</td>';
                echo '<td>' . strtoupper($loan->status) . '</td>';
                echo '</tr>';
            }
            echo '</tbody>';
            echo '</table>';
            echo '</body>';
            echo '</html>';
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Display public global search results.
     */
    public function globalSearch(Request $request)
    {
        $search = $request->query('q');

        $books = [];
        $articles = [];

        if ($search) {
            $books = Buku::where('status_publish', 'publish')
                ->where(function($q) use ($search) {
                    $q->where('judul', 'like', '%' . $search . '%')
                      ->orWhere('penulis', 'like', '%' . $search . '%')
                      ->orWhere('sinopsis', 'like', '%' . $search . '%')
                      ->orWhere('kategori', 'like', '%' . $search . '%');
                })
                ->orderBy('created_at', 'desc')
                ->get();

            $articles = Artikel::where('status', 'approved')
                ->where(function($q) use ($search) {
                    $q->where('judul', 'like', '%' . $search . '%')
                      ->orWhere('isi', 'like', '%' . $search . '%')
                      ->orWhere('nama_uploader', 'like', '%' . $search . '%')
                      ->orWhere('kategori', 'like', '%' . $search . '%');
                })
                ->orderBy('created_at', 'desc')
                ->get();
        }

        return view('pages.search', compact('search', 'books', 'articles'));
    }

    public function toggleFavorite($id)
    {
        $userId = \Illuminate\Support\Facades\Auth::id();
        
        $favorite = \App\Models\Favorite::where('user_id', $userId)
            ->where('buku_id', $id)
            ->first();

        if ($favorite) {
            $favorite->delete();
            return response()->json(['status' => 'removed', 'message' => 'Buku dihapus dari favorit.']);
        } else {
            \App\Models\Favorite::create([
                'user_id' => $userId,
                'buku_id' => $id,
            ]);
            return response()->json(['status' => 'added', 'message' => 'Buku ditambahkan ke favorit.']);
        }
    }

    /**
     * Cetak laporan daftar buku dalam format PDF.
     */
    public function cetak(Request $request)
    {
        $genre = $request->query('genre');
        $availability = $request->query('availability');
        $search = $request->query('q');

        $query = Buku::query();

        if ($genre && strtolower($genre) !== 'all') {
            $query->where('kategori', 'like', $genre);
        }

        if ($availability && strtolower($availability) !== 'all') {
            if (strtolower($availability) === 'publish') {
                $query->where('status_publish', 'publish');
            } elseif (strtolower($availability) === 'draft') {
                $query->where('status_publish', 'draft');
            } else {
                $statusVal = strtolower($availability) === 'borrowed' ? 'dipinjam' : strtolower($availability);
                $query->where('status', $statusVal);
            }
        }

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('judul', 'like', '%' . $search . '%')
                  ->orWhere('penulis', 'like', '%' . $search . '%')
                  ->orWhere('sinopsis', 'like', '%' . $search . '%')
                  ->orWhere('kategori', 'like', '%' . $search . '%')
                  ->orWhere('isbn', 'like', '%' . $search . '%');
            });
        }

        $books = $query->orderBy('created_at', 'desc')->get();
        
        // Base64 Logo
        $logoPath = public_path('images/logo_kanca_tegal.jpg');
        $logoBase64 = '';
        if (file_exists($logoPath)) {
            $logoBase64 = 'data:image/jpeg;base64,' . base64_encode(file_get_contents($logoPath));
        }

        $adminName = session('admin_fullname', \App\Models\Setting::get('admin_fullname', 'Admin'));
        
        $periode = 'Semua';
        $filterParts = [];
        if ($genre && strtolower($genre) !== 'all') {
            $filterParts[] = 'Genre: ' . strtoupper($genre);
        }
        if ($availability && strtolower($availability) !== 'all') {
            $filterParts[] = 'Status: ' . strtoupper($availability);
        }
        if ($search) {
            $filterParts[] = 'Pencarian: "' . $search . '"';
        }
        if (!empty($filterParts)) {
            $periode = implode(', ', $filterParts);
        }

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('pages.admin.buku.cetak', compact('books', 'logoBase64', 'adminName', 'periode'));
        return $pdf->stream('laporan_buku_' . date('Ymd_His') . '.pdf');
    }
}

