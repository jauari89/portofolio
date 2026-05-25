<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Concerns\HandlesUploads;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\HeroSectionRequest;
use App\Models\HeroSection;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class HeroSectionController extends Controller
{
    use HandlesUploads;

    public function edit(): View
    {
        return view('admin.singletons.form', [
            'title' => 'Hero Section',
            'description' => 'Headline, tagline, tombol utama, dan gambar latar hero.',
            'action' => route('admin.hero.update'),
            'item' => HeroSection::current(),
            'fields' => $this->fields(),
        ]);
    }

    public function update(HeroSectionRequest $request): RedirectResponse
    {
        $hero = HeroSection::current();
        $data = $request->validated();
        $data['is_active'] = $request->boolean('is_active');
        $stored = $this->storeUpload($request, 'background_image', 'hero', $hero->background_image);

        if ($stored) {
            $data['background_image'] = $stored;
        } else {
            unset($data['background_image']);
        }

        $hero->update($data);

        return back()->with('success', 'Hero section berhasil diperbarui.');
    }

    private function fields(): array
    {
        return [
            ['name' => 'headline', 'label' => 'Headline', 'type' => 'text', 'col' => 'col-md-6'],
            ['name' => 'subheadline', 'label' => 'Subheadline', 'type' => 'text', 'col' => 'col-md-6'],
            ['name' => 'description', 'label' => 'Description', 'type' => 'textarea', 'rows' => 4, 'col' => 'col-12'],
            ['name' => 'primary_button_text', 'label' => 'Primary Button Text', 'type' => 'text', 'col' => 'col-md-6'],
            ['name' => 'primary_button_url', 'label' => 'Primary Button URL', 'type' => 'text', 'col' => 'col-md-6'],
            ['name' => 'secondary_button_text', 'label' => 'Secondary Button Text', 'type' => 'text', 'col' => 'col-md-6'],
            ['name' => 'secondary_button_url', 'label' => 'Secondary Button URL', 'type' => 'text', 'col' => 'col-md-6'],
            ['name' => 'background_image', 'label' => 'Background Image', 'type' => 'file', 'accept' => 'image/*', 'col' => 'col-md-6'],
            ['name' => 'is_active', 'label' => 'Aktif', 'type' => 'checkbox', 'col' => 'col-md-6'],
        ];
    }
}
