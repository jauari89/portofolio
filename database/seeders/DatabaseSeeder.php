<?php

namespace Database\Seeders;

use App\Models\BlogPost;
use App\Models\Experience;
use App\Models\HeroSection;
use App\Models\Portfolio;
use App\Models\ProfileSection;
use App\Models\Publication;
use App\Models\Service;
use App\Models\SiteSetting;
use App\Models\Skill;
use App\Models\Stat;
use App\Models\TeachingCourse;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::query()->updateOrCreate(
            ['email' => 'admin@jauari.local'],
            [
                'name' => 'Administrator',
                'password' => Hash::make('password'),
                'is_admin' => true,
            ]
        );

        SiteSetting::query()->updateOrCreate(
            ['site_name' => 'Jauari Akhmad Nur Hasim'],
            [
                'site_title' => 'Jauari Akhmad Nur Hasim | Lecturer, Software Engineer',
                'meta_description' => 'Portfolio profesional Jauari Akhmad Nur Hasim, dosen dan software engineer yang fokus pada web technology, multimedia, dan sistem akademik.',
                'meta_keywords' => 'Jauari Akhmad Nur Hasim, lecturer, software engineer, Laravel, multimedia, web technology, PENS',
            ]
        );

        ProfileSection::query()->updateOrCreate(
            ['full_name' => 'Jauari Akhmad Nur Hasim'],
            [
                'professional_title' => 'Lecturer, Software Engineer',
                'short_description' => 'Lecturer and software engineer focused on web technology, multimedia systems, academic platforms, and student supervision.',
                'long_description' => 'Jauari Akhmad Nur Hasim is a lecturer from Politeknik Elektronika Negeri Surabaya with professional interests in web application development, multimedia technology, digital media, curriculum systems, and research-based software engineering. This profile is designed to keep academic work, project portfolio, teaching activity, and publications maintainable from the admin panel.',
                'location' => 'Surabaya, Jawa Timur',
                'primary_email' => 'jauari@pens.ac.id',
                'secondary_email' => 'jauarifar@gmail.com',
                'phone' => null,
            ]
        );

        HeroSection::query()->updateOrCreate(
            ['headline' => "I'm Jauari"],
            [
                'subheadline' => 'Lecturer, Software Engineer, Multimedia & Web Technology Enthusiast',
                'description' => 'Building dynamic web systems, academic platforms, multimedia learning experiences, and research-driven digital products.',
                'primary_button_text' => 'View Portfolio',
                'primary_button_url' => '#portfolio',
                'secondary_button_text' => 'Contact Me',
                'secondary_button_url' => '#contact',
                'is_active' => true,
            ]
        );

        $stats = [
            ['label' => 'Projects Completed', 'value' => 157, 'icon' => 'bi bi-kanban'],
            ['label' => 'Publications', 'value' => 6, 'icon' => 'bi bi-journal-text'],
            ['label' => 'Courses', 'value' => 8, 'icon' => 'bi bi-easel'],
            ['label' => 'Years Experience', 'value' => 10, 'icon' => 'bi bi-award'],
        ];

        foreach ($stats as $index => $stat) {
            Stat::query()->updateOrCreate(
                ['label' => $stat['label']],
                $stat + ['sort_order' => $index + 1, 'is_active' => true]
            );
        }

        $this->call(AcademicMetricSeeder::class);

        $skills = [
            ['name' => 'Laravel', 'category' => 'Backend', 'percentage' => 50],
            ['name' => 'ReactJS', 'category' => 'Frontend', 'percentage' => 71],
            ['name' => 'AngularJS', 'category' => 'Frontend', 'percentage' => 48],
            ['name' => 'Express', 'category' => 'Backend', 'percentage' => 69],
            ['name' => 'Yii', 'category' => 'Backend', 'percentage' => 91],
        ];

        foreach ($skills as $index => $skill) {
            Skill::query()->updateOrCreate(
                ['name' => $skill['name']],
                $skill + ['sort_order' => $index + 1, 'is_active' => true]
            );
        }

        $services = [
            ['title' => 'Web Application Development', 'icon' => 'bi bi-window-stack', 'description' => 'Designing and developing maintainable web applications for academic, public service, and professional workflows.'],
            ['title' => 'Laravel & Backend System', 'icon' => 'bi bi-hdd-network', 'description' => 'Building backend services, databases, APIs, authentication flows, and administrative dashboards with Laravel.'],
            ['title' => 'Multimedia Technology', 'icon' => 'bi bi-play-btn', 'description' => 'Creating interactive multimedia experiences and learning media for teaching and applied projects.'],
            ['title' => 'Broadcasting & Digital Media', 'icon' => 'bi bi-broadcast', 'description' => 'Supporting digital media, broadcasting workflows, and content technology for education and communication.'],
            ['title' => 'Curriculum / OBE System', 'icon' => 'bi bi-diagram-3', 'description' => 'Developing academic information systems that support curriculum mapping, outcome-based education, and evaluation.'],
            ['title' => 'Research & Academic Supervision', 'icon' => 'bi bi-people', 'description' => 'Supervising student projects and research in software engineering, web technology, IoT, and multimedia systems.'],
        ];

        foreach ($services as $index => $service) {
            Service::query()->updateOrCreate(
                ['title' => $service['title']],
                $service + ['sort_order' => $index + 1, 'is_active' => true]
            );
        }

        $experiences = [
            ['type' => 'work', 'title' => 'Lecturer', 'institution' => 'Politeknik Elektronika Negeri Surabaya', 'location' => 'Surabaya', 'start_year' => 2015, 'end_year' => null, 'description' => 'Teaching web technology, multimedia programming, and applied software engineering while supervising student projects and research.'],
            ['type' => 'education', 'title' => 'S-2 Teknik Informatika', 'institution' => 'Institut Teknologi Sepuluh Nopember', 'location' => 'Surabaya', 'start_year' => 2012, 'end_year' => 2015, 'description' => 'Graduate study in informatics with focus on strengthening research, software architecture, and professional engineering practice.'],
            ['type' => 'education', 'title' => 'D4 Teknik Informatika', 'institution' => 'Politeknik Elektronika Negeri Surabaya', 'location' => 'Surabaya', 'start_year' => 2007, 'end_year' => 2011, 'description' => 'Undergraduate applied informatics study that became the foundation for web development, multimedia technology, and academic software projects.'],
            ['type' => 'education', 'title' => 'SMA Negeri 1 Tuban', 'institution' => 'SMA Negeri 1 Tuban', 'location' => 'Tuban', 'start_year' => 2005, 'end_year' => 2007, 'description' => 'Science-track secondary education before continuing into informatics and engineering.'],
        ];

        foreach ($experiences as $index => $experience) {
            Experience::query()->updateOrCreate(
                ['type' => $experience['type'], 'title' => $experience['title'], 'institution' => $experience['institution']],
                $experience + ['sort_order' => $index + 1, 'is_active' => true]
            );
        }

        $portfolios = [
            ['title' => 'Website Koleksi Foto', 'category' => 'Website', 'short_description' => 'Website portfolio foto dan company profile yang menampilkan koleksi visual secara terstruktur.', 'content' => 'Project website untuk mengelola dan menampilkan koleksi foto, narasi profil, dan halaman publik yang mudah diperbarui.', 'year' => 2022, 'client_or_institution' => 'Portfolio Project'],
            ['title' => 'Smart City Lubuk Linggau', 'category' => 'Smart City', 'short_description' => 'Konsep dan implementasi sistem smart city untuk kebutuhan informasi kota dan layanan digital.', 'content' => 'Project smart city yang diarahkan untuk mendukung integrasi informasi, layanan, dan representasi digital wilayah Lubuk Linggau.', 'year' => 2022, 'client_or_institution' => 'Lubuk Linggau'],
            ['title' => 'Academic System Prototype', 'category' => 'Academic System', 'short_description' => 'Prototype sistem akademik untuk pengelolaan data pembelajaran dan proses evaluasi.', 'content' => 'Prototype ini menjadi dasar pengembangan fitur akademik seperti kurikulum, pemetaan capaian, dan pelaporan proses pembelajaran.', 'year' => 2024, 'client_or_institution' => 'Academic Project'],
        ];

        foreach ($portfolios as $index => $portfolio) {
            Portfolio::query()->updateOrCreate(
                ['title' => $portfolio['title']],
                $portfolio + ['status' => 'published', 'sort_order' => $index + 1]
            );
        }

        $publications = [
            ['authors' => "Sa'adah,Umi; Permatasari,Desy Intan; Hardiansyah,Fadilah Fahrul; Yunanto,Andhik Ampuh; Hasim,Jauari Akhmad Nur; Wulandari,Irma; Pahlevi,Muhammad Reza; Shihab,Dufan Quraish", 'title' => 'Tool Refactoring Otomatis untuk Menangani Lazy Class Code Smell dengan Pendekatan Software Metrics', 'year' => 2022],
            ['authors' => 'Saputra,Ferry Astika; Salman,Muhammad; Hasim,Jauari Akhmad Nur; Nadhori,Isbat Uzzin; Ramli,Kalamullah', 'title' => 'The Next-Generation NIDS Platform: Cloud-Based Snort NIDS Using Containers and Big Data', 'year' => 2022],
            ['authors' => "Hasim,Jauari Akhmad Nur; Sa'adah,Umi; Sari,Desy Intan Permata; Damastuti,Fardani Annisa; Koirudin,Fatkul Nur", 'title' => 'Developing Microframework based on Singleton and Abstract Factory Design Pattern', 'year' => 2022],
            ['authors' => 'Desy Intan Permatasari; Umi Saadah; Jauari Akhmad Nur Hasim; Cyntya Rahma Dita', 'title' => 'User Interface Improvement in English Kids Talk Application using The Heuristic Evaluation Method', 'year' => 2021],
            ['authors' => "Umi Sa'adah; Jauari Akhmad Nur Hasim; Andhik Ampuh Yunanto; Desy Intan Permatasari; Fadilah Fahrul Hardiansyah; Irma Wulandari; Hazna At Thooriqoh", 'title' => 'Automatic Testing Framework Based on Serenity and Jenkins Automated Build', 'year' => 2021],
            ['authors' => 'Al Rasyid,M Udin Harun; Mubarrok,M Husni; Hasim,Jauari Akhmad Nur', 'title' => 'Implementation of environmental monitoring based on KAA IoT platform', 'year' => 2020],
        ];

        foreach ($publications as $index => $publication) {
            Publication::query()->updateOrCreate(
                ['title' => $publication['title']],
                $publication + ['sort_order' => $index + 1, 'is_active' => true]
            );
        }

        $courses = [
            'Animasi 3D',
            'Desain Web',
            'Pemrograman Visual',
            'Teknologi Web',
            'Praktikum Desain Web',
            'Pemograman Jaringan Multimedia',
            'Praktikum Pemograman Jaringan Multimedia',
            'Praktikum Pemograman Visual',
        ];

        foreach ($courses as $index => $course) {
            TeachingCourse::query()->updateOrCreate(
                ['course_name' => $course],
                [
                    'semester' => null,
                    'academic_year' => null,
                    'description' => 'Mata kuliah dalam rumpun web, multimedia, dan pemrograman terapan. Detail semester, tahun akademik, dan materi dapat diperbarui dari admin panel.',
                    'sort_order' => $index + 1,
                    'is_active' => true,
                ]
            );
        }

        $posts = [
            ['title' => 'Htaccess Di Nginx', 'category' => 'Web Development', 'excerpt' => 'Catatan ringkas tentang penyesuaian konfigurasi routing ketika aplikasi dipindahkan dari Apache ke Nginx.', 'content' => 'Artikel ini membahas hal-hal yang perlu diperhatikan saat menerjemahkan pola konfigurasi .htaccess ke blok konfigurasi Nginx, terutama untuk aplikasi web yang membutuhkan clean URL dan redirect yang konsisten.'],
            ['title' => 'Peluncuran Website HOMEi oleh Korina', 'category' => 'Project', 'excerpt' => 'Dokumentasi singkat peluncuran website sebagai bagian dari proses publikasi produk digital.', 'content' => 'Catatan ini mendokumentasikan proses peluncuran website HOMEi, termasuk kesiapan konten, pengecekan halaman publik, dan koordinasi publikasi digital.'],
        ];

        foreach ($posts as $post) {
            BlogPost::query()->updateOrCreate(
                ['title' => $post['title']],
                $post + ['status' => 'published', 'published_at' => now()]
            );
        }
    }
}
