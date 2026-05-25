<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Concerns\HandlesUploads;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\SiteSettingRequest;
use App\Models\SiteSetting;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class SiteSettingController extends Controller
{
    use HandlesUploads;

    public function edit(): View
    {
        return view('admin.singletons.form', [
            'title' => 'Site Settings',
            'description' => 'SEO, identitas website, logo, favicon, dan file CV.',
            'action' => route('admin.settings.update'),
            'item' => SiteSetting::current(),
            'fields' => $this->fields(),
        ]);
    }

    public function update(SiteSettingRequest $request): RedirectResponse
    {
        $setting = SiteSetting::current();
        $data = $request->validated();

        foreach (['logo' => 'settings', 'favicon' => 'settings', 'cv_file' => 'documents'] as $field => $directory) {
            $stored = $this->storeUpload($request, $field, $directory, $setting->{$field});
            if ($stored) {
                $data[$field] = $stored;
            } else {
                unset($data[$field]);
            }
        }

        $setting->update($data);

        return back()->with('success', 'Site settings berhasil diperbarui.');
    }

    private function fields(): array
    {
        return [
            ['name' => 'site_name', 'label' => 'Site Name', 'type' => 'text', 'col' => 'col-md-6'],
            ['name' => 'site_title', 'label' => 'Site Title', 'type' => 'text', 'col' => 'col-md-6'],
            ['name' => 'meta_description', 'label' => 'Meta Description', 'type' => 'textarea', 'rows' => 3, 'col' => 'col-12'],
            ['name' => 'meta_keywords', 'label' => 'Meta Keywords', 'type' => 'textarea', 'rows' => 2, 'col' => 'col-12'],
            ['name' => 'logo', 'label' => 'Logo', 'type' => 'file', 'accept' => 'image/*', 'col' => 'col-md-4'],
            ['name' => 'favicon', 'label' => 'Favicon', 'type' => 'file', 'accept' => 'image/*', 'col' => 'col-md-4'],
            ['name' => 'cv_file', 'label' => 'File CV (PDF)', 'type' => 'file', 'accept' => 'application/pdf', 'col' => 'col-md-4'],
        ];
    }
}
