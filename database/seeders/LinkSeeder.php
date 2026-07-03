<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Link;

class LinkSeeder extends Seeder
{
    public function run()
    {
        $links = [
            [
                'icon' => 'fab fa-globe',
                'title' => 'Website Resmi',
                'description' => 'Website resmi SMK Budi Utomo Way Jepara',
                'url' => 'https://smkbudiutomo.sch.id',
                'order' => 1,
                'is_active' => true,
            ],
            [
                'icon' => 'fas fa-user-graduate',
                'title' => 'PPDB Online',
                'description' => 'Pendaftaran Peserta Didik Baru secara online',
                'url' => 'https://ppdb.smkbudiutomo.sch.id',
                'order' => 2,
                'is_active' => true,
            ],
            [
                'icon' => 'fab fa-whatsapp',
                'title' => 'WhatsApp Admin',
                'description' => 'Hubungi admin via WhatsApp',
                'url' => 'https://wa.me/628123456789',
                'order' => 3,
                'is_active' => true,
            ],
            [
                'icon' => 'fab fa-instagram',
                'title' => 'Instagram',
                'description' => 'Instagram resmi sekolah',
                'url' => 'https://instagram.com/smkbudiutomo',
                'order' => 4,
                'is_active' => true,
            ],
            [
                'icon' => 'fab fa-tiktok',
                'title' => 'TikTok',
                'description' => 'TikTok sekolah',
                'url' => 'https://tiktok.com/@smkbudiutomo',
                'order' => 5,
                'is_active' => true,
            ],
            [
                'icon' => 'fab fa-youtube',
                'title' => 'YouTube',
                'description' => 'Channel YouTube sekolah',
                'url' => 'https://youtube.com/c/smkbudiutomo',
                'order' => 6,
                'is_active' => true,
            ],
            [
                'icon' => 'fab fa-facebook',
                'title' => 'Facebook',
                'description' => 'Facebook resmi',
                'url' => 'https://facebook.com/smkbudiutomo',
                'order' => 7,
                'is_active' => true,
            ],
            [
                'icon' => 'fas fa-map-marker-alt',
                'title' => 'Google Maps',
                'description' => 'Lokasi sekolah di Google Maps',
                'url' => 'https://goo.gl/maps/example',
                'order' => 8,
                'is_active' => true,
            ],
            [
                'icon' => 'fas fa-file-download',
                'title' => 'Download Brosur',
                'description' => 'Brosur resmi SMK',
                'url' => 'https://smkbudiutomo.sch.id/brosur.pdf',
                'order' => 9,
                'is_active' => true,
            ],
            [
                'icon' => 'fas fa-school',
                'title' => 'Profil Sekolah',
                'description' => 'Informasi lengkap tentang sekolah',
                'url' => 'https://smkbudiutomo.sch.id/profil',
                'order' => 10,
                'is_active' => true,
            ],
            [
                'icon' => 'fas fa-book-open',
                'title' => 'Jurusan',
                'description' => 'Daftar jurusan yang tersedia',
                'url' => 'https://smkbudiutomo.sch.id/jurusan',
                'order' => 11,
                'is_active' => true,
            ],
            [
                'icon' => 'fas fa-phone',
                'title' => 'Kontak',
                'description' => 'Nomor telepon dan email sekolah',
                'url' => 'https://smkbudiutomo.sch.id/kontak',
                'order' => 12,
                'is_active' => true,
            ],
        ];

        foreach ($links as $data) {
            Link::create($data);
        }
    }
}
