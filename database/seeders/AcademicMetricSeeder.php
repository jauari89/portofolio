<?php

namespace Database\Seeders;

use App\Models\AcademicMetric;
use Illuminate\Database\Seeder;

class AcademicMetricSeeder extends Seeder
{
    public function run(): void
    {
        $academicMetrics = [
            [
                'label' => 'SINTA ID',
                'value' => '6722409',
                'source_name' => 'SINTA',
                'source_url' => 'https://sinta.kemdiktisaintek.go.id/authors/profile/6722409',
                'icon' => 'bi bi-person-badge',
                'description' => 'Author profile on SINTA Kemdiktisaintek.',
            ],
            [
                'label' => 'SINTA Score',
                'value' => '784',
                'source_name' => 'SINTA Overall',
                'source_url' => 'https://sinta.kemdiktisaintek.go.id/authors/profile/6722409',
                'icon' => 'bi bi-graph-up-arrow',
                'description' => 'Current overall SINTA score summary.',
            ],
            [
                'label' => 'Scholar Citations',
                'value' => '293',
                'source_name' => 'Google Scholar via SINTA',
                'source_url' => 'https://sinta.kemdiktisaintek.go.id/authors/profile/6722409/?view=googlescholar',
                'icon' => 'bi bi-mortarboard',
                'description' => 'Google Scholar citation count shown by SINTA.',
            ],
            [
                'label' => 'Scholar h-index',
                'value' => '9',
                'source_name' => 'Google Scholar via SINTA',
                'source_url' => 'https://sinta.kemdiktisaintek.go.id/authors/profile/6722409/?view=googlescholar',
                'icon' => 'bi bi-journal-check',
                'description' => 'Google Scholar h-index shown by SINTA.',
            ],
            [
                'label' => 'Scopus Articles',
                'value' => '15',
                'source_name' => 'SINTA Scopus',
                'source_url' => 'https://sinta.kemdiktisaintek.go.id/authors/profile/6722409/?view=scopus',
                'icon' => 'bi bi-database-check',
                'description' => 'Indexed Scopus article count shown by SINTA.',
            ],
            [
                'label' => 'ORCID',
                'value' => '0000-0002-2713-0919',
                'source_name' => 'ORCID / DBLP',
                'source_url' => 'https://orcid.org/0000-0002-2713-0919',
                'icon' => 'bi bi-fingerprint',
                'description' => 'Researcher identifier linked from public scholarly indexes.',
            ],
        ];

        foreach ($academicMetrics as $index => $metric) {
            AcademicMetric::query()->updateOrCreate(
                ['label' => $metric['label']],
                $metric + ['sort_order' => $index + 1, 'is_active' => true]
            );
        }
    }
}
