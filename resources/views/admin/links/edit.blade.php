@extends('layouts.admin')

@section('content')
    <div class="max-w-2xl mx-auto bg-white shadow rounded-lg p-6">
        <div class="flex items-center mb-6">
            <a href="{{ route('admin.links.index') }}" class="text-gray-500 hover:text-gray-700 mr-4">
                <i class="fas fa-arrow-left"></i>
            </a>
            <h2 class="text-2xl font-bold text-gray-800">Edit Link</h2>
        </div>

        <form action="{{ route('admin.links.update', $link->id) }}" method="POST" enctype="multipart/form-data"
            class="space-y-6">
            @csrf
            @method('PUT')

            @if($errors->any())
                <div class="bg-red-50 text-red-500 p-4 rounded-lg text-sm mb-6">
                    <ul class="list-disc pl-5">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div>
                    <label for="parent_id" class="block text-sm font-medium text-gray-700">Kategori Induk (Lokasi
                        Tautan)</label>
                    <select name="parent_id" id="parent_id"
                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                        <option value="">Halaman Utama (Root)</option>
                        @foreach($subpages as $sub)
                            <option value="{{ $sub->id }}" {{ old('parent_id', $link->parent_id) == $sub->id ? 'selected' : '' }}>
                                Sub-Halaman: {{ $sub->title }}
                            </option>
                        @endforeach
                    </select>
                    <p class="mt-1 text-xs text-gray-500">Pilih jika ingin memindahkan link ini ke dalam sub-halaman lain.
                    </p>
                </div>

                <div class="flex flex-col justify-end pb-2">
                    <div class="flex items-center">
                        <input id="is_subpage" name="is_subpage" type="checkbox" value="1" {{ old('is_subpage', $link->is_subpage) ? 'checked' : '' }}
                            class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                        <label for="is_subpage" class="ml-2 block text-sm text-gray-900 font-semibold">Tipe: Sub-Halaman
                            (Kategori Link)</label>
                    </div>
                    <p class="mt-1 text-xs text-gray-500">Centang jika link ini ketika di-klik akan membuka halaman baru
                        berisi kumpulan link-link anak.</p>
                </div>
            </div>

            <div>
                <label for="title" class="block text-sm font-medium text-gray-700">Judul Link <span
                        class="text-red-500">*</span></label>
                <input type="text" name="title" id="title" value="{{ old('title', $link->title) }}" required
                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
            </div>

            <div id="url-container">
                <label for="url" class="block text-sm font-medium text-gray-700">URL Tujuan <span
                        class="text-red-500">*</span></label>
                <input type="url" name="url" id="url" value="{{ old('url', $link->url) }}" required
                    placeholder="https://..."
                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
            </div>

            <div>
                <label for="description" class="block text-sm font-medium text-gray-700">Deskripsi Singkat
                    (Opsional)</label>
                <input type="text" name="description" id="description" value="{{ old('description', $link->description) }}"
                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div>
                    <label for="icon" class="block text-sm font-medium text-gray-700">Ikon (FontAwesome Class)</label>
                    <input type="text" name="icon" id="icon" value="{{ old('icon', $link->icon) }}"
                        placeholder="Contoh: fab fa-instagram"
                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                    <p class="mt-1 text-xs text-gray-500">Gunakan class FontAwesome 6 seperti <code
                            class="text-red-400">fab fa-facebook</code>.</p>
                </div>
                <div>
                    <label for="icon_file" class="block text-sm font-medium text-gray-700">Atau Upload Gambar Ikon</label>
                    <input type="file" name="icon_file" id="icon_file" accept="image/*"
                        class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 border border-gray-300 rounded-md shadow-sm h-[42px] content-center">
                    <p class="mt-1 text-xs text-gray-500">Max 2MB. Ini akan menimpa pilihan FontAwesome.</p>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-6">
                <div>
                    <label for="order" class="block text-sm font-medium text-gray-700">Urutan (Sort Order) <span
                            class="text-red-500">*</span></label>
                    <input type="number" name="order" id="order" value="{{ old('order', $link->order) }}" required
                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                </div>

                <div class="flex flex-col justify-end pb-2">
                    <div class="flex items-center">
                        <input id="is_active" name="is_active" type="checkbox" value="1" {{ old('is_active', $link->is_active) ? 'checked' : '' }}
                            class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                        <label for="is_active" class="ml-2 block text-sm text-gray-900">Status Aktif</label>
                    </div>
                </div>
            </div>

            <div class="pt-4 flex justify-end">
                <button type="submit"
                    class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-6 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Update Link
                </button>
            </div>

            <script>
                document.addEventListener('DOMContentLoaded', function () {
                    const isSubpageCheckbox = document.getElementById('is_subpage');
                    const urlContainer = document.getElementById('url-container');
                    const urlInput = document.getElementById('url');

                    function toggleUrlField() {
                        if (isSubpageCheckbox.checked) {
                            urlContainer.style.display = 'none';
                            urlInput.removeAttribute('required');
                        } else {
                            urlContainer.style.display = 'block';
                            urlInput.setAttribute('required', 'required');
                        }
                    }

                    isSubpageCheckbox.addEventListener('change', toggleUrlField);
                    toggleUrlField(); // Run initially
                });
            </script>
        </form>
    </div>
@endsection