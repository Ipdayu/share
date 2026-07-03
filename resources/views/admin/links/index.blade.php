@extends('layouts.admin')

@section('content')

    @if($errors->any())
        <div class="bg-red-50 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
            <ul class="list-disc pl-5">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
        <!-- Ganti Ikon / Logo -->
        <div class="bg-white shadow rounded-lg p-6">
            <h2 class="text-xl font-bold text-gray-800 mb-4">Logo Profil</h2>
            <div class="flex flex-col gap-4">
                <div
                    class="w-16 h-16 bg-gray-100 rounded-full border border-gray-200 overflow-hidden flex items-center justify-center">
                    <img src="{{ asset('logo.png') }}?v={{ time() }}" alt="Current Logo" class="w-full h-full object-cover"
                        onerror="this.onerror=null; this.outerHTML='<i class=\'fas fa-image text-gray-400\'></i>';">
                </div>
                <form action="{{ route('admin.upload.logo') }}" method="POST" enctype="multipart/form-data"
                    class="flex items-end gap-2">
                    @csrf
                    <div class="flex-grow">
                        <input type="file" name="logo" accept="image/*" required
                            class="block w-full text-xs text-gray-500 file:mr-2 file:py-1.5 file:px-3 file:rounded-md file:border-0 file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 border border-gray-300 rounded-md">
                    </div>
                    <button type="submit"
                        class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-1.5 px-3 rounded-md text-sm shrink-0">Upload</button>
                </form>
            </div>
        </div>

        <!-- Ganti Background -->
        <div class="bg-white shadow rounded-lg p-6">
            <h2 class="text-xl font-bold text-gray-800 mb-4">Latar Belakang (Background)</h2>
            <div class="flex flex-col gap-4">
                <div
                    class="h-16 w-full bg-gray-100 rounded-md border border-gray-200 overflow-hidden relative flex items-center justify-center">
                    @if(file_exists(public_path('bg.jpg')))
                        <img src="{{ asset('bg.jpg') }}?v={{ time() }}" alt="Current Background"
                            class="w-full h-full object-cover">
                        <form action="{{ route('admin.delete.bg') }}" method="POST"
                            class="absolute inset-0 bg-black bg-opacity-40 flex items-center justify-center opacity-0 hover:opacity-100 transition-opacity">
                            @csrf
                            <button type="submit" class="text-white text-xs font-semibold bg-red-600 px-3 py-1 rounded"
                                onclick="return confirm('Hapus background?')">Hapus</button>
                        </form>
                    @else
                        <span class="text-gray-400 text-xs">Warna Default (Off-white)</span>
                    @endif
                </div>
                <form action="{{ route('admin.upload.bg') }}" method="POST" enctype="multipart/form-data"
                    class="flex items-end gap-2">
                    @csrf
                    <div class="flex-grow">
                        <input type="file" name="background" accept="image/*" required
                            class="block w-full text-xs text-gray-500 file:mr-2 file:py-1.5 file:px-3 file:rounded-md file:border-0 file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 border border-gray-300 rounded-md">
                    </div>
                    <button type="submit"
                        class="bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-1.5 px-3 rounded-md text-sm shrink-0">Upload</button>
                </form>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
        <!-- Pengaturan Teks Profil -->
        <div class="bg-white shadow rounded-lg p-6">
            <h2 class="text-xl font-bold text-gray-800 mb-4">Pengaturan Teks Profil</h2>
            <form action="{{ route('admin.settings.update') }}" method="POST" class="flex flex-col gap-4">
                @csrf
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Judul Profil (Nama Sekolah/Instansi)</label>
                    <input type="text" name="title" value="{{ $settings['title'] ?? 'SMK Budi Utomo Way Jepara' }}" required
                        class="block w-full text-sm border border-gray-300 rounded-md py-2 px-3 focus:ring-blue-500 focus:border-blue-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Garis Besar / Deskripsi Singkat
                        (Bio)</label>
                    <input type="text" name="bio" value="{{ $settings['bio'] ?? 'Pusat tautan resmi SMK Budi Utomo' }}"
                        class="block w-full text-sm border border-gray-300 rounded-md py-2 px-3 focus:ring-blue-500 focus:border-blue-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Gaya Huruf (Font) Judul</label>
                    <select name="font"
                        class="block w-full text-sm border border-gray-300 rounded-md py-2 px-3 focus:ring-blue-500 focus:border-blue-500">
                        <option value="font-sans" {{ ($settings['font'] ?? 'font-sans') == 'font-sans' ? 'selected' : '' }}>
                            Standar Modern (Sans)</option>
                        <option value="'Playfair Display', serif" {{ ($settings['font'] ?? '') == "'Playfair Display', serif" ? 'selected' : '' }}>Playfair Display (Elegan Mewah)</option>
                        <option value="'Montserrat', sans-serif" {{ ($settings['font'] ?? '') == "'Montserrat', sans-serif" ? 'selected' : '' }}>Montserrat (Tegas Kekinian)</option>
                        <option value="'Cinzel', serif" {{ ($settings['font'] ?? '') == "'Cinzel', serif" ? 'selected' : '' }}>Cinzel (Klasik Romawi)</option>
                        <option value="'Dancing Script', cursive" {{ ($settings['font'] ?? '') == "'Dancing Script', cursive" ? 'selected' : '' }}>Dancing Script (Tegak Bersambung)</option>
                        <option value="'Great Vibes', cursive" {{ ($settings['font'] ?? '') == "'Great Vibes', cursive" ? 'selected' : '' }}>Great Vibes (Latin Cantik Elegan)</option>
                    </select>
                </div>
                <div class="flex justify-end mt-2">
                    <button type="submit"
                        class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-6 rounded-md shadow-sm">
                        Simpan Profil
                    </button>
                </div>
            </form>
        </div>

        <!-- Lagu Tema (Theme Song) -->
        <div class="bg-white shadow rounded-lg p-6">
            <h2 class="text-xl font-bold text-gray-800 mb-4">Lagu Tema (Theme Song)</h2>
            <div class="flex flex-col gap-4">
                <div
                    class="h-auto w-full bg-gray-50 rounded-md border border-gray-200 p-4 flex flex-col items-center justify-center text-center">
                    @if(file_exists(public_path('theme.mp3')))
                        <div class="text-green-600 mb-2">
                            <i class="fas fa-check-circle text-2xl"></i>
                            <p class="text-sm font-semibold mt-1">Lagu Aktif</p>
                        </div>
                        <audio controls class="w-full h-8 mb-2">
                            <source src="{{ asset('theme.mp3') }}?v={{ time() }}" type="audio/mpeg">
                        </audio>
                        <form action="{{ route('admin.delete.music') }}" method="POST">
                            @csrf
                            <button type="submit"
                                class="text-white text-xs font-semibold bg-red-600 hover:bg-red-700 px-4 py-1.5 rounded transition"
                                onclick="return confirm('Hapus Lagu Tema?')">Hapus Lagu</button>
                        </form>
                    @else
                        <i class="fas fa-music text-gray-300 text-3xl mb-2"></i>
                        <span class="text-gray-400 text-sm">Belum ada lagu (Senyap)</span>
                    @endif
                </div>
                <form action="{{ route('admin.upload.music') }}" method="POST" enctype="multipart/form-data"
                    class="flex flex-col sm:flex-row items-end sm:items-center gap-2">
                    @csrf
                    <div class="flex-grow w-full">
                        <label class="block text-xs font-medium text-gray-600 mb-1">Pilih File (MP3, max 5MB)</label>
                        <input type="file" name="music" accept="audio/*" required
                            class="block w-full text-xs text-gray-500 file:mr-2 file:py-1.5 file:px-3 file:rounded-md file:border-0 file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 border border-gray-300 rounded-md">
                    </div>
                    <button type="submit"
                        class="w-full sm:w-auto bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-1.5 px-4 rounded-md text-sm shrink-0 h-[34px]">Upload</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Kumpulan Foto Galeri (Hasil Lomba) -->
    <div class="bg-white shadow rounded-lg p-6 mb-6">
        <h2 class="text-xl font-bold text-gray-800 mb-4">Galeri Foto (Contoh: Hasil Lomba)</h2>
        <p class="text-sm text-gray-500 mb-4">Tambahkan hingga 3 foto (persegi) yang akan ditampilkan tepat di bawah Logo di
            halaman utama.</p>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @for($i = 1; $i <= 3; $i++)
                <div class="border border-gray-200 rounded-md p-4 bg-gray-50 flex flex-col justify-between">
                    <div>
                        <h3 class="font-semibold text-gray-700 mb-2">Slot Foto {{ $i }}</h3>
                        <div
                            class="aspect-square bg-gray-200 rounded overflow-hidden mb-3 relative flex items-center justify-center">
                            @if(file_exists(public_path('gallery' . $i . '.jpg')))
                                <img src="{{ asset('gallery' . $i . '.jpg') }}?v={{ time() }}" class="w-full h-full object-cover">
                                <form action="{{ route('admin.delete.gallery', $i) }}" method="POST"
                                    class="absolute inset-0 bg-black bg-opacity-50 opacity-0 hover:opacity-100 flex items-center justify-center transition-opacity cursor-pointer"
                                    onsubmit="return confirm('Hapus foto di slot ini?');">
                                    @csrf
                                    <button type="submit" class="bg-red-600 text-white text-xs px-3 py-1 rounded">Hapus</button>
                                </form>
                            @else
                                <i class="fas fa-image text-gray-400 text-3xl"></i>
                            @endif
                        </div>
                    </div>

                    <form action="{{ route('admin.upload.gallery') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="slot" value="{{ $i }}">
                        <input type="file" name="photo" accept="image/*" required
                            class="block w-full text-[10px] text-gray-500 file:mr-2 file:py-1 file:px-2 file:rounded file:border-0 file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 mb-2 border border-gray-300 rounded">
                        <button type="submit"
                            class="w-full bg-blue-600 hover:bg-blue-700 text-white text-xs py-1.5 rounded text-center">Ganti</button>
                    </form>
                </div>
            @endfor
        </div>
    </div>

    <div class="bg-white shadow rounded-lg p-6">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-gray-800">Daftar Link</h2>
            <a href="{{ route('admin.links.create') }}"
                class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg inline-flex items-center">
                <i class="fas fa-plus mr-2"></i> Tambah Link
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Urutan
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Icon &
                            Detail</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status
                        </th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($links as $link)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                {{ $link->order }}
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                    <div
                                        class="flex-shrink-0 h-10 w-10 flex items-center justify-center bg-blue-50 text-blue-600 rounded-full overflow-hidden">
                                        @if($link->icon)
                                            @if(strpos($link->icon, 'uploads/') !== false)
                                                <img src="{{ asset($link->icon) }}" class="w-full h-full object-cover">
                                            @else
                                                <i class="{{ $link->icon }} text-lg"></i>
                                            @endif
                                        @else
                                            <i class="fas fa-link text-lg"></i>
                                        @endif
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900">{{ $link->title }}</div>
                                        <div class="text-sm text-gray-500">{{ $link->url }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($link->is_active)
                                    <span
                                        class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Aktif</span>
                                @else
                                    <span
                                        class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">Nonaktif</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <a href="{{ route('admin.links.edit', $link->id) }}"
                                    class="text-indigo-600 hover:text-indigo-900 mr-3">Edit</a>
                                <form action="{{ route('admin.links.destroy', $link->id) }}" method="POST"
                                    class="inline-block mt-0 mb-0"
                                    onsubmit="return confirm('Apakah Anda yakin ingin menghapus link ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="text-red-600 hover:text-red-900 focus:outline-none">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-4 text-center text-sm text-gray-500">
                                Belum ada link yang ditambahkan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection