<?php

namespace App\Http\Controllers\PublicSite;

use App\Http\Controllers\Controller;
use App\Http\Requests\ContactRequest;
use App\Models\ContactMessage;
use Illuminate\Http\RedirectResponse;

class ContactController extends Controller
{
    public function store(ContactRequest $request): RedirectResponse
    {
        ContactMessage::query()->create($request->validated());

        return back()
            ->with('success', __('site.home.form.success'));
    }
}
