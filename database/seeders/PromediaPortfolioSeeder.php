<?php

namespace Database\Seeders;

use App\Models\Portfolio;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PromediaPortfolioSeeder extends Seeder
{
    private string $baseUrl = 'https://ptpromedia.co.id';

    public function run(): void
    {
        $items = $this->scrapeProducts();
        $maxOrder = (int) Portfolio::query()->max('sort_order');

        foreach (array_values($items) as $index => $item) {
            $portfolio = Portfolio::withTrashed()
                ->where('demo_url', $item['demo_url'])
                ->orWhere('title', $item['title'])
                ->first();

            if ($portfolio) {
                if ($portfolio->trashed()) {
                    $portfolio->restore();
                }

                $portfolio->fill($item);
                $portfolio->save();

                continue;
            }

            Portfolio::query()->create($item + [
                'sort_order' => $maxOrder + $index + 1,
            ]);
        }
    }

    private function scrapeProducts(): array
    {
        $items = [];

        foreach ($this->listUrls() as $listUrl) {
            $html = $this->fetch($listUrl);

            preg_match_all('/<div class=["\']prd prd--style2[\s\S]*?<\/div>\s*<\/div>\s*<\/div>\s*<\/div>/i', $html, $matches);

            foreach ($matches[0] as $block) {
                $sourceId = (int) $this->firstMatch('/\/web\/app\/detail\/(\d+)/i', $block);

                if (! $sourceId || isset($items[$sourceId])) {
                    continue;
                }

                $title = $this->cleanText($this->firstMatch('/<h2 class=["\']prd-title["\']>\s*<a[^>]*>([\s\S]*?)<\/a>/i', $block));
                $short = $this->cleanText($this->firstMatch('/<div class=["\']prd-description["\']>([\s\S]*?)<\/div>/i', $block));

                if (Str::lower($title) === 'asd' || Str::lower($short) === 'asds') {
                    continue;
                }

                $category = $this->cleanText($this->firstMatch('/<div class=["\']prd-tag["\']>\s*<a[^>]*>([\s\S]*?)<\/a>/i', $block)) ?: 'Produk Digital';
                $detailUrl = $this->absoluteUrl('/web/app/detail/'.$sourceId);
                $imageUrl = $this->absoluteUrl($this->firstMatch('/<img[^>]+src=["\']([^"\']+)["\']/i', $block));
                $detailHtml = $this->fetch($detailUrl);
                $detailShort = $this->shortDescription($detailHtml);
                $contentText = $this->detailDescription($detailHtml);

                $items[$sourceId] = [
                    'title' => $title,
                    'category' => $category,
                    'short_description' => Str::limit($detailShort ?: $short ?: 'Produk digital dari PT Promedia Citra Digital Informatika.', 590, ''),
                    'content' => trim("Sumber: {$detailUrl}\n\nKategori: {$category}\n\n".($contentText ?: $short)),
                    'thumbnail' => $this->storeThumbnail($imageUrl, $sourceId),
                    'year' => $this->yearFromImageUrl($imageUrl),
                    'client_or_institution' => 'PT Promedia Citra Digital Informatika',
                    'demo_url' => $detailUrl,
                    'repository_url' => null,
                    'status' => 'published',
                ];
            }
        }

        return $items;
    }

    private function listUrls(): array
    {
        return [
            'https://ptpromedia.co.id/web/app/product',
            'https://ptpromedia.co.id/web/app/product?page=2&per-page=8',
            'https://ptpromedia.co.id/web/app/product?page=3&per-page=8',
            'https://ptpromedia.co.id/web/app/product?page=4&per-page=8',
            'https://ptpromedia.co.id/web/app/product?page=5&per-page=8',
        ];
    }

    private function fetch(string $url): string
    {
        return Http::timeout(30)
            ->withUserAgent('JauariPortfolioSeeder/1.0')
            ->get($url)
            ->throw()
            ->body();
    }

    private function cleanText(string $html): string
    {
        $html = preg_replace('/<\s*br\s*\/?>/i', ' ', $html) ?? $html;
        $text = html_entity_decode(strip_tags($html), ENT_QUOTES | ENT_HTML5, 'UTF-8');
        $text = str_replace("\xc2\xa0", ' ', $text);
        $text = preg_replace('/\s+/u', ' ', $text) ?? $text;

        return trim($text);
    }

    private function firstMatch(string $pattern, string $subject): string
    {
        return preg_match($pattern, $subject, $matches) ? $matches[1] : '';
    }

    private function absoluteUrl(string $url): string
    {
        $url = trim($url);

        if (str_starts_with($url, 'http://') || str_starts_with($url, 'https://')) {
            return $url;
        }

        if (str_starts_with($url, '/')) {
            return $this->baseUrl.$url;
        }

        return $this->baseUrl.'/web/app/'.$url;
    }

    private function detailDescription(string $html): string
    {
        return $this->cleanText($this->firstMatch('/<div[^>]+role=["\']tabpanel["\'][^>]*id=["\']Tab1["\'][^>]*>([\s\S]*?)<\/div>/i', $html));
    }

    private function shortDescription(string $html): string
    {
        return $this->cleanText($this->firstMatch('/<div class=["\']prd-block_description[\s\S]*?<h3>\s*Penjelasan Singkat\s*<\/h3>([\s\S]*?)<div class=["\']mt-2["\']/i', $html));
    }

    private function storeThumbnail(string $imageUrl, int $sourceId): ?string
    {
        if (! $imageUrl) {
            return null;
        }

        $response = Http::timeout(30)
            ->withUserAgent('JauariPortfolioSeeder/1.0')
            ->get($imageUrl);

        if (! $response->successful()) {
            return null;
        }

        $extension = strtolower(pathinfo(parse_url($imageUrl, PHP_URL_PATH) ?: '', PATHINFO_EXTENSION));
        $extension = in_array($extension, ['jpg', 'jpeg', 'png', 'webp'], true) ? $extension : 'jpg';
        $path = "portfolios/promedia-{$sourceId}.{$extension}";

        Storage::disk('public')->put($path, $response->body());

        return $path;
    }

    private function yearFromImageUrl(string $imageUrl): ?int
    {
        return preg_match('/\/(20\d{2})\d{4}_/i', $imageUrl, $matches) ? (int) $matches[1] : null;
    }
}
