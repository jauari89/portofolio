<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Concerns\HandlesUploads;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ProfileSectionRequest;
use App\Models\ProfileSection;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ProfileController extends Controller
{
    use HandlesUploads;

    public function edit(): View
    {
        return view('admin.singletons.form', [
            'title' => 'Profile & About',
            'description' => 'Biodata utama, ringkasan profesional, kontak, dan foto profil.',
            'action' => route('admin.profile.update'),
            'item' => ProfileSection::current(),
            'fields' => $this->fields(),
        ]);
    }

    public function update(ProfileSectionRequest $request): RedirectResponse
    {
        $profile = ProfileSection::current();
        $data = $request->validated();
        $stored = $this->storeUpload($request, 'profile_photo', 'profile', $profile->profile_photo);

        if ($stored) {
            $data['profile_photo'] = $stored;
        } else {
            unset($data['profile_photo']);
        }

        $profile->update($data);

        return back()->with('success', 'Profile berhasil diperbarui.');
    }

    private function fields(): array
    {
        return [
            ['name' => 'full_name', 'label' => 'Full Name', 'type' => 'text', 'col' => 'col-md-6'],
            ['name' => 'professional_title', 'label' => 'Professional Title', 'type' => 'text', 'col' => 'col-md-6'],
            ['name' => 'short_description', 'label' => 'Short Description', 'type' => 'textarea', 'rows' => 3, 'col' => 'col-12'],
            ['name' => 'long_description', 'label' => 'Long Description', 'type' => 'textarea', 'rows' => 7, 'col' => 'col-12'],
            ['name' => 'location', 'label' => 'Location', 'type' => 'text', 'col' => 'col-md-6'],
            ['name' => 'birthdate', 'label' => 'Birthdate', 'type' => 'date', 'col' => 'col-md-6'],
            ['name' => 'primary_email', 'label' => 'Primary Email', 'type' => 'email', 'col' => 'col-md-4'],
            ['name' => 'secondary_email', 'label' => 'Secondary Email', 'type' => 'email', 'col' => 'col-md-4'],
            ['name' => 'phone', 'label' => 'Phone', 'type' => 'text', 'col' => 'col-md-4'],
            ['name' => 'profile_photo', 'label' => 'Profile Photo', 'type' => 'file', 'accept' => 'image/*', 'col' => 'col-md-6'],
        ];
    }
}
