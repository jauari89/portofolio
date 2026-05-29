<?php

namespace Database\Seeders;

use App\Models\TeachingCourse;
use Illuminate\Database\Seeder;

class TeachingCourseDetailSeeder extends Seeder
{
    public function run(): void
    {
        $courses = [
            'Animasi 3D' => [
                'description' => 'Mata kuliah yang membahas produksi aset, animasi, dan visualisasi 3D untuk kebutuhan multimedia interaktif.',
                'overview' => 'Animasi 3D memperkenalkan alur kerja produksi objek dan adegan tiga dimensi mulai dari modeling, texturing, lighting, rigging sederhana, animation blocking, sampai rendering. Fokus pembelajaran diarahkan pada kemampuan mahasiswa membuat aset 3D yang komunikatif untuk media edukasi, promosi, simulasi, dan visualisasi produk.',
                'materials' => "Pengenalan pipeline produksi 3D\nModeling objek hard-surface dan organic sederhana\nTexturing, material, lighting, dan camera setup\nDasar rigging dan keyframe animation\nRendering still image dan short animation\nOptimasi aset 3D untuk media interaktif",
                'rps_summary' => 'RPS mencakup capaian pembelajaran produksi aset 3D, praktik studio, penilaian project bertahap, presentasi hasil, dan evaluasi kualitas visual berdasarkan kerapian model, komposisi, serta kesesuaian kebutuhan media.',
                'sample_projects' => "Visualisasi 3D produk atau fasilitas kampus\nAnimasi pendek layanan publik berbasis karakter sederhana\nAset 3D low-poly untuk virtual tour atau katalog interaktif",
            ],
            'Desain Web' => [
                'description' => 'Mata kuliah desain antarmuka web yang menekankan struktur halaman, estetika visual, responsivitas, dan pengalaman pengguna.',
                'overview' => 'Desain Web membahas proses merancang halaman web yang informatif, responsif, mudah dipindai, dan sesuai kebutuhan pengguna. Mahasiswa belajar menyusun hierarki konten, layout, warna, tipografi, komponen UI, serta prototipe halaman yang siap dikembangkan menjadi website dinamis.',
                'materials' => "Prinsip layout, grid, spacing, dan visual hierarchy\nHTML semantik dan struktur konten web\nCSS responsive design dan component styling\nUI pattern untuk navbar, card, table, form, dan detail page\nAccessibility dasar dan readability\nPrototyping halaman profil, landing page, dan dashboard sederhana",
                'rps_summary' => 'RPS menekankan capaian desain UI web responsif, praktik pembuatan halaman statis, evaluasi visual, dan project akhir berupa website tematik yang memiliki struktur konten jelas.',
                'sample_projects' => "Landing page portofolio profesional\nWebsite profil laboratorium atau komunitas akademik\nPrototype dashboard informasi kegiatan mahasiswa",
            ],
            'Praktikum Desain Web' => [
                'description' => 'Praktikum untuk menerapkan desain web menjadi halaman responsif berbasis HTML, CSS, dan komponen frontend.',
                'overview' => 'Praktikum Desain Web berfokus pada implementasi langsung desain menjadi halaman web responsif. Mahasiswa mengerjakan latihan terstruktur untuk membangun komponen, mengatur layout, memperbaiki tampilan mobile, dan memastikan halaman dapat digunakan dengan baik pada berbagai ukuran layar.',
                'materials' => "Setup struktur project frontend\nImplementasi layout responsif\nReusable component: navbar, hero, card, form, dan footer\nResponsive image dan media handling\nDebugging tampilan mobile dan desktop\nDeploy halaman statis atau prototype",
                'rps_summary' => 'RPS praktikum berisi latihan mingguan, penilaian komponen, tugas integrasi halaman, dan project akhir berupa website responsif yang dapat dipresentasikan.',
                'sample_projects' => "Website profil personal satu halaman\nKatalog project mahasiswa dengan filter kategori\nHalaman event akademik dengan form pendaftaran",
            ],
            'Teknologi Web' => [
                'description' => 'Mata kuliah yang membahas pengembangan aplikasi web modern dari sisi frontend, backend, database, dan deployment.',
                'overview' => 'Teknologi Web menghubungkan konsep client-server, routing, database, autentikasi, validasi input, dan pengelolaan konten dinamis. Mahasiswa diarahkan memahami bagaimana aplikasi web dibangun sebagai sistem yang dapat dipelihara, bukan hanya halaman statis.',
                'materials' => "Arsitektur HTTP, request-response, dan routing\nTemplate engine dan komponen frontend\nDatabase relational dan query dasar\nCRUD, validation, authentication, dan authorization\nUpload file dan pengelolaan storage\nDeployment, environment, dan maintenance aplikasi web",
                'rps_summary' => 'RPS mencakup capaian pengembangan aplikasi web dinamis, tugas CRUD, studi kasus sistem informasi, evaluasi keamanan dasar, serta project akhir berbasis kebutuhan nyata.',
                'sample_projects' => "Sistem informasi portofolio dosen\nAplikasi manajemen publikasi dan karya mahasiswa\nDashboard monitoring data layanan akademik",
            ],
            'Pemrograman Visual' => [
                'description' => 'Mata kuliah pemrograman berbasis antarmuka visual untuk membangun aplikasi desktop atau aplikasi interaktif.',
                'overview' => 'Pemrograman Visual membahas cara membangun aplikasi berbasis event, form, komponen UI, validasi, serta integrasi data. Pembelajaran diarahkan agar mahasiswa memahami hubungan antara logika program, interaksi pengguna, dan struktur data aplikasi.',
                'materials' => "Konsep event-driven programming\nKomponen form, input, table, dialog, dan menu\nValidasi data dan error handling\nKoneksi database sederhana\nCRUD berbasis antarmuka visual\nPackaging aplikasi dan dokumentasi penggunaan",
                'rps_summary' => 'RPS memuat praktik membuat aplikasi visual bertahap, evaluasi fungsi, struktur kode, penggunaan database, dan project akhir berbasis kasus operasional.',
                'sample_projects' => "Aplikasi inventaris sederhana\nSistem kasir mini dengan laporan transaksi\nAplikasi pendataan kegiatan laboratorium",
            ],
            'Pemograman Visual' => [
                'description' => 'Mata kuliah pemrograman berbasis antarmuka visual untuk membangun aplikasi desktop atau aplikasi interaktif.',
                'overview' => 'Pemograman Visual membahas cara membangun aplikasi berbasis event, form, komponen UI, validasi, serta integrasi data. Pembelajaran diarahkan agar mahasiswa memahami hubungan antara logika program, interaksi pengguna, dan struktur data aplikasi.',
                'materials' => "Konsep event-driven programming\nKomponen form, input, table, dialog, dan menu\nValidasi data dan error handling\nKoneksi database sederhana\nCRUD berbasis antarmuka visual\nPackaging aplikasi dan dokumentasi penggunaan",
                'rps_summary' => 'RPS memuat praktik membuat aplikasi visual bertahap, evaluasi fungsi, struktur kode, penggunaan database, dan project akhir berbasis kasus operasional.',
                'sample_projects' => "Aplikasi inventaris sederhana\nSistem kasir mini dengan laporan transaksi\nAplikasi pendataan kegiatan laboratorium",
            ],
            'Praktikum Pemograman Visual' => [
                'description' => 'Praktikum implementasi aplikasi visual dengan penekanan pada UI, event handling, database, dan penyelesaian studi kasus.',
                'overview' => 'Praktikum Pemograman Visual memberi ruang latihan intensif untuk membangun aplikasi berbasis form. Mahasiswa mempraktikkan pembuatan komponen, pengelolaan event, koneksi database, serta pengujian fungsi aplikasi.',
                'materials' => "Pembuatan form dan navigasi aplikasi\nEvent handling dan state sederhana\nCRUD database melalui interface visual\nValidasi input dan pesan kesalahan\nLaporan sederhana dan export data\nFinalisasi aplikasi studi kasus",
                'rps_summary' => 'RPS praktikum mengukur kemampuan implementasi fitur, kerapian UI, kelengkapan validasi, dokumentasi, dan demonstrasi project.',
                'sample_projects' => "Aplikasi presensi kegiatan\nAplikasi manajemen data anggota komunitas\nAplikasi peminjaman alat laboratorium",
            ],
            'Pemograman Jaringan Multimedia' => [
                'description' => 'Mata kuliah yang membahas komunikasi data, layanan jaringan, dan distribusi konten multimedia.',
                'overview' => 'Pemograman Jaringan Multimedia membahas konsep jaringan komputer yang digunakan untuk mengirim, memproses, dan menampilkan konten multimedia. Mahasiswa dikenalkan pada protokol komunikasi, client-server, API, streaming dasar, dan pengelolaan data media.',
                'materials' => "Konsep dasar jaringan dan protokol komunikasi\nPemrograman socket atau HTTP client-server\nAPI untuk distribusi data multimedia\nPengiriman file dan metadata media\nStreaming dan real-time communication dasar\nMonitoring performa layanan multimedia",
                'rps_summary' => 'RPS mencakup capaian pemahaman protokol, praktik komunikasi client-server, pengiriman konten multimedia, dan project integrasi layanan jaringan sederhana.',
                'sample_projects' => "Aplikasi berbagi file multimedia lokal\nPrototype streaming informasi kampus\nDashboard monitoring perangkat multimedia berbasis jaringan",
            ],
            'Praktikum Pemograman Jaringan Multimedia' => [
                'description' => 'Praktikum implementasi komunikasi jaringan untuk pengiriman data, file, dan konten multimedia.',
                'overview' => 'Praktikum Pemograman Jaringan Multimedia berfokus pada percobaan langsung membangun layanan client-server, mengirim data media, dan menguji performa komunikasi. Mahasiswa belajar membaca masalah jaringan dari sisi aplikasi dan pengalaman pengguna.',
                'materials' => "Setup environment jaringan lokal\nImplementasi client-server sederhana\nUpload, download, dan transfer file media\nIntegrasi API dan format data JSON\nPengujian latensi dan respons aplikasi\nMini project layanan multimedia jaringan",
                'rps_summary' => 'RPS praktikum menilai keberhasilan komunikasi data, kestabilan aplikasi, dokumentasi uji coba, dan presentasi project akhir.',
                'sample_projects' => "Aplikasi transfer media antar perangkat lokal\nSistem katalog video berbasis API\nPrototype remote display untuk informasi akademik",
            ],
        ];

        foreach ($courses as $courseName => $detail) {
            TeachingCourse::query()->updateOrCreate(
                ['course_name' => $courseName],
                $detail + [
                    'is_active' => true,
                ]
            );
        }
    }
}
