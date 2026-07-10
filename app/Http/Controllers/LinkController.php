<?php

namespace App\Http\Controllers;

use App\Models\Link;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class LinkController extends Controller
{
    // Display list of links in admin
    public function index()
    {
        $links = Link::with('parent')->orderBy('order')->get();

        $settingsPath = storage_path('app/settings.json');
        $settings = file_exists($settingsPath) ? json_decode(file_get_contents($settingsPath), true) : [
            'title' => 'SMK Budi Utomo Way Jepara',
            'bio' => 'Pusat tautan resmi SMK Budi Utomo'
        ];

        return view('admin.links.index', compact('links', 'settings'));
    }

    // Show form to create a new link
    public function create()
    {
        $subpages = Link::where('is_subpage', true)->orderBy('title')->get();
        return view('admin.links.create', compact('subpages'));
    }

    // Store new link
    public function store(Request $request)
    {
        $data = $request->validate([
            'parent_id' => 'nullable|exists:links,id',
            'icon' => 'nullable|string|max:255',
            'icon_file' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp,svg|max:2048',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'url' => 'required_unless:is_subpage,1|nullable|url',
            'order' => 'required|integer',
            'is_active' => 'sometimes|boolean',
            'is_subpage' => 'sometimes|boolean',
        ]);

        if ($request->hasFile('icon_file')) {
            $filename = time() . '_' . $request->file('icon_file')->getClientOriginalName();
            $request->file('icon_file')->move(public_path('uploads/icons'), $filename);
            $data['icon'] = 'uploads/icons/' . $filename;
        }

        $data['is_active'] = $request->has('is_active');
        $data['is_subpage'] = $request->has('is_subpage');

        if ($data['is_subpage']) {
            $data['url'] = null;
        }

        Link::create($data);
        return redirect()->route('admin.links.index')->with('success', 'Link berhasil ditambahkan.');
    }

    // Show edit form
    public function edit(Link $link)
    {
        $subpages = Link::where('is_subpage', true)
            ->where('id', '!=', $link->id)
            ->orderBy('title')
            ->get();
        return view('admin.links.edit', compact('link', 'subpages'));
    }

    // Update existing link
    public function update(Request $request, Link $link)
    {
        $data = $request->validate([
            'parent_id' => 'nullable|exists:links,id',
            'icon' => 'nullable|string|max:255',
            'icon_file' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp,svg|max:2048',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'url' => 'required_unless:is_subpage,1|nullable|url',
            'order' => 'required|integer',
            'is_active' => 'sometimes|boolean',
            'is_subpage' => 'sometimes|boolean',
        ]);

        if ($request->hasFile('icon_file')) {
            $filename = time() . '_' . $request->file('icon_file')->getClientOriginalName();
            $request->file('icon_file')->move(public_path('uploads/icons'), $filename);
            $data['icon'] = 'uploads/icons/' . $filename;
        }

        $data['is_active'] = $request->has('is_active');
        $data['is_subpage'] = $request->has('is_subpage');

        if ($data['is_subpage']) {
            $data['url'] = null;
        } else {
            // Keep parent_id null or change it if we want. Actually if it becomes not a subpage, children links should be updated? Or we can just save parent_id as requested
        }

        $link->update($data);
        return redirect()->route('admin.links.index')->with('success', 'Link berhasil diupdate.');
    }

    // Delete link
    public function destroy(Link $link)
    {
        $link->delete();
        return redirect()->route('admin.links.index')->with('success', 'Link berhasil dihapus.');
    }

    // Upload Logo
    public function uploadLogo(Request $request)
    {
        $request->validate([
            'logo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('logo')) {
            $file = $request->file('logo');
            $file->move(public_path(), 'logo.png');
            return back()->with('success', 'Logo/Ikon berhasil diupdate.');
        }

        return back()->withErrors(['logo' => 'File gagal diupload.']);
    }

    // Upload Background
    public function uploadBackground(Request $request)
    {
        $request->validate([
            'background' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:3072',
        ]);

        if ($request->hasFile('background')) {
            $file = $request->file('background');
            // Overwrite bg.jpg in public directory
            $file->move(public_path(), 'bg.jpg');
            return back()->with('success', 'Background (Latar Belakang) berhasil diupdate.');
        }

        return back()->withErrors(['background' => 'File background gagal diupload.']);
    }

    // Delete Background
    public function deleteBackground()
    {
        $bgPath = public_path('bg.jpg');
        if (file_exists($bgPath)) {
            unlink($bgPath);
        }
        return back()->with('success', 'Background berhasil dihapus. Kembali menggunakan warna default.');
    }

    // Upload Theme Song
    public function uploadMusic(Request $request)
    {
        $request->validate([
            'music' => 'required|file|mimes:mp3,wav,ogg,mpga|max:5120', // max 5MB
        ]);

        if ($request->hasFile('music')) {
            $file = $request->file('music');
            $file->move(public_path(), 'theme.mp3');
            return back()->with('success', 'Lagu tema (Theme Song) berhasil diupdate. MP3 telah dipasang.');
        }

        return back()->withErrors(['music' => 'File audio gagal diupload.']);
    }

    // Delete Theme Song
    public function deleteMusic()
    {
        $musicPath = public_path('theme.mp3');
        if (file_exists($musicPath)) {
            unlink($musicPath);
        }
        return back()->with('success', 'Lagu tema (Theme Song) berhasil dihapus dari halaman.');
    }

    // Upload Gallery Photo
    public function uploadGallery(Request $request)
    {
        $request->validate([
            'photo' => 'required|image|mimes:jpeg,png,jpg,webp|max:3072',
            'slot' => 'required|integer|min:1|max:3',
        ]);

        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $file->move(public_path(), 'gallery' . $request->slot . '.jpg');
            return back()->with('success', 'Foto Galeri ' . $request->slot . ' berhasil diupdate.');
        }

        return back()->withErrors(['photo' => 'File foto gagal diupload.']);
    }

    // Delete Gallery Photo
    public function deleteGallery($slot)
    {
        if (in_array($slot, [1, 2, 3])) {
            $path = public_path('gallery' . $slot . '.jpg');
            if (file_exists($path)) {
                unlink($path);
            }
        }
        return back()->with('success', 'Foto Galeri ' . $slot . ' berhasil dihapus.');
    }

    // Update Text Settings
    public function updateSettings(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'bio' => 'nullable|string|max:255',
            'font' => 'nullable|string|max:100',
        ]);

        $settings = [
            'title' => $request->title,
            'bio' => $request->bio ?? '',
            'font' => $request->font ?? 'font-sans'
        ];

        file_put_contents(storage_path('app/settings.json'), json_encode($settings, JSON_PRETTY_PRINT));

        return back()->with('success', 'Profil teks dan gaya huruf berhasil diupdate.');
    }
}
