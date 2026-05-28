<?php

namespace Database\Seeders;

use App\Models\BlogPost;
use Illuminate\Database\Seeder;

class SampleBlogPostSeeder extends Seeder
{
    public function run(): void
    {
        $posts = [
            [
                'title' => 'Laravel 12 untuk Portofolio Akademik yang Mudah Dirawat',
                'category' => 'Web Development',
                'excerpt' => 'Laravel 12 cocok dipakai sebagai fondasi portofolio dinamis karena fokus pada kestabilan, update dependency, dan pola kerja MVC yang rapi.',
                'content' => "Laravel 12 dirilis sebagai kelanjutan dari Laravel 11 dengan fokus pada pembaruan dependency, starter kit baru, dan perubahan yang relatif minim. Untuk web profil dosen atau portofolio profesional, pendekatan ini menarik karena fitur utama seperti routing, middleware, Blade, Eloquent, validation, dan storage tetap stabil untuk membangun halaman yang mudah dikelola dari admin panel.\n\nDalam konteks portofolio akademik, Laravel memberi ruang yang rapi untuk memisahkan data profil, publikasi, project, teaching, dan pesan kontak. Dengan struktur MVC dan database dinamis, halaman publik tidak perlu terus diedit manual setiap kali ada karya, publikasi, atau aktivitas baru.\n\nReferensi: https://laravel.com/docs/12.x/releases",
            ],
            [
                'title' => 'AI di Ruang Kelas: Kompetensi Dosen yang Perlu Disiapkan',
                'category' => 'Teaching',
                'excerpt' => 'Perkembangan AI membuat peran dosen bergeser: bukan hanya menyampaikan materi, tetapi juga membimbing penggunaan teknologi secara etis dan produktif.',
                'content' => "UNESCO menekankan bahwa AI telah mengubah hubungan belajar menjadi dinamika antara pengajar, mahasiswa, dan sistem AI. Karena itu, dosen perlu memahami bukan hanya cara memakai AI, tetapi juga batasan, etika, perlindungan data, dan dampaknya terhadap proses berpikir mahasiswa.\n\nUntuk bidang web technology dan multimedia, AI dapat dipakai sebagai pendamping eksplorasi ide, review kode, perancangan media belajar, dan simulasi workflow. Namun pemanfaatannya tetap perlu diarahkan agar mahasiswa tidak hanya menghasilkan output cepat, tetapi juga memahami konsep, logika, dan tanggung jawab akademiknya.\n\nReferensi: https://www.unesco.org/en/articles/ai-competency-framework-teachers",
            ],
            [
                'title' => 'Merawat Jejak Riset melalui Google Scholar dan SINTA',
                'category' => 'Research',
                'excerpt' => 'Profil akademik yang terawat membantu publik melihat publikasi, sitasi, dan identitas riset secara lebih jelas.',
                'content' => "Google Scholar Profiles menyediakan cara sederhana bagi penulis untuk menampilkan publikasi akademik dan metrik sitasi yang diperbarui otomatis mengikuti indeks Google Scholar. Agar profil mudah ditemukan, Google menyarankan profil publik dengan email institusi yang terverifikasi.\n\nDi Indonesia, SINTA berperan sebagai sistem informasi riset berbasis web yang memberi akses pada sitasi, kepakaran, dan performa peneliti, institusi, serta jurnal. Menghubungkan profil pribadi, Google Scholar, SINTA, dan halaman portofolio membuat rekam jejak akademik lebih mudah dibaca oleh mahasiswa, kolaborator, dan mitra riset.\n\nReferensi: https://scholar.google.com/intl/en-US/scholar/citations.html | https://sinta.kemdikbud.go.id/",
            ],
            [
                'title' => 'Portofolio Digital sebagai Arsip Karya Dosen dan Mahasiswa',
                'category' => 'Portfolio',
                'excerpt' => 'Portofolio digital membantu karya pengembangan sistem, riset, dan bimbingan mahasiswa terdokumentasi dalam satu tempat.',
                'content' => "Bagi dosen yang aktif mengajar, membimbing, meneliti, dan membangun sistem, portofolio digital bukan sekadar halaman profil. Ia dapat menjadi arsip hidup untuk menampilkan project, publikasi, mata kuliah, bimbingan mahasiswa, serta tautan ke repository atau demo aplikasi.\n\nDengan admin panel yang dinamis, setiap karya baru dapat dipublikasikan tanpa mengubah Blade secara manual. Ini membuat website pribadi lebih mudah dipelihara, tetap relevan, dan bisa berkembang menjadi pusat dokumentasi akademik-profesional yang terhubung dengan publikasi, SINTA, Google Scholar, dan project industri.\n\nReferensi: https://sinta.kemdikbud.go.id/ | https://laravel.com/docs/12.x/releases",
            ],
        ];

        foreach ($posts as $index => $post) {
            BlogPost::query()->updateOrCreate(
                ['title' => $post['title']],
                $post + [
                    'status' => 'published',
                    'published_at' => now()->subDays(count($posts) - $index),
                ]
            );
        }
    }
}
