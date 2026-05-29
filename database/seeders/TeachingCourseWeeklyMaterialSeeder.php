<?php

namespace Database\Seeders;

use App\Models\TeachingCourse;
use App\Models\TeachingCourseMaterial;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class TeachingCourseWeeklyMaterialSeeder extends Seeder
{
    public function run(): void
    {
        TeachingCourse::query()
            ->ordered()
            ->get()
            ->each(function (TeachingCourse $course): void {
                foreach ($this->weeklyTopics($course) as $week => $topic) {
                    $pdfPath = $this->storeSamplePdf($course, $week, $topic);

                    TeachingCourseMaterial::query()->updateOrCreate(
                        [
                            'teaching_course_id' => $course->id,
                            'week_number' => $week,
                        ],
                        [
                            'title' => 'Pertemuan '.$week.': '.$topic,
                            'description' => 'Materi minggu '.$week.' untuk '.$course->course_name.' membahas '.$topic.'.',
                            'pdf_file' => $pdfPath,
                            'material_url' => null,
                            'sort_order' => $week,
                            'is_active' => true,
                        ]
                    );
                }
            });
    }

    /**
     * @return array<int, string>
     */
    private function weeklyTopics(TeachingCourse $course): array
    {
        $coreTopics = collect(preg_split('/\r\n|\r|\n/', (string) $course->materials))
            ->map(fn ($line) => trim($line))
            ->filter()
            ->values();

        return [
            1 => 'Orientasi perkuliahan, kontrak belajar, dan capaian pembelajaran',
            2 => $coreTopics->get(0, 'Konsep dasar '.$course->course_name),
            3 => $coreTopics->get(1, 'Prinsip, tools, dan workflow utama'),
            4 => $coreTopics->get(2, 'Latihan dasar dan studi kasus terpandu'),
            5 => $coreTopics->get(3, 'Pendalaman konsep dan praktik mandiri'),
            6 => $coreTopics->get(4, 'Integrasi komponen dan pengujian awal'),
            7 => $coreTopics->get(5, 'Review materi dan persiapan evaluasi tengah semester'),
            8 => 'Evaluasi Tengah Semester dan review progress project',
            9 => 'Analisis kebutuhan dan perancangan mini project',
            10 => 'Implementasi fitur inti mini project',
            11 => 'Pengembangan fitur lanjutan dan validasi hasil',
            12 => 'Integrasi, dokumentasi, dan perbaikan kualitas',
            13 => 'Uji coba, debugging, dan optimasi project',
            14 => 'Finalisasi project dan penyusunan laporan',
            15 => 'Presentasi, demo, dan evaluasi project',
            16 => 'Evaluasi akhir, refleksi pembelajaran, dan pengembangan lanjutan',
        ];
    }

    private function storeSamplePdf(TeachingCourse $course, int $week, string $topic): string
    {
        $weekLabel = str_pad((string) $week, 2, '0', STR_PAD_LEFT);
        $path = 'teaching/materials/'.$course->slug.'-week-'.$weekLabel.'.pdf';
        $lines = [
            $course->course_name,
            'Week '.$week.': '.$topic,
            '',
            'Overview',
            'This sample PDF is generated as editable starter material for the course page.',
            'Replace this file from the admin panel with the final lecture PDF when available.',
            '',
            'Suggested class flow',
            '1. Opening and learning goals',
            '2. Concept explanation and guided practice',
            '3. Discussion, exercise, and project checkpoint',
        ];

        Storage::disk('public')->put($path, $this->buildSimplePdf($lines));

        return $path;
    }

    /**
     * @param  array<int, string>  $lines
     */
    private function buildSimplePdf(array $lines): string
    {
        $content = "BT\n/F1 18 Tf\n72 760 Td\n";

        foreach ($lines as $index => $line) {
            if ($index === 1) {
                $content .= "/F1 12 Tf\n";
            }

            $content .= '('.$this->escapePdfText($line).") Tj\n0 -24 Td\n";
        }

        $content .= "ET\n";

        $objects = [
            '<< /Type /Catalog /Pages 2 0 R >>',
            '<< /Type /Pages /Kids [3 0 R] /Count 1 >>',
            '<< /Type /Page /Parent 2 0 R /MediaBox [0 0 612 792] /Resources << /Font << /F1 4 0 R >> >> /Contents 5 0 R >>',
            '<< /Type /Font /Subtype /Type1 /BaseFont /Helvetica >>',
            '<< /Length '.strlen($content)." >>\nstream\n".$content.'endstream',
        ];

        $pdf = "%PDF-1.4\n";
        $offsets = [0];

        foreach ($objects as $number => $object) {
            $offsets[] = strlen($pdf);
            $pdf .= ($number + 1)." 0 obj\n".$object."\nendobj\n";
        }

        $xrefOffset = strlen($pdf);
        $pdf .= "xref\n0 ".(count($objects) + 1)."\n";
        $pdf .= "0000000000 65535 f \n";

        foreach (array_slice($offsets, 1) as $offset) {
            $pdf .= sprintf("%010d 00000 n \n", $offset);
        }

        $pdf .= "trailer\n<< /Size ".(count($objects) + 1)." /Root 1 0 R >>\n";
        $pdf .= "startxref\n".$xrefOffset."\n%%EOF\n";

        return $pdf;
    }

    private function escapePdfText(string $text): string
    {
        $ascii = Str::ascii($text);

        return str_replace(['\\', '(', ')'], ['\\\\', '\(', '\)'], $ascii);
    }
}
