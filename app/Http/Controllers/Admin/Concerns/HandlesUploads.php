<?php

namespace App\Http\Controllers\Admin\Concerns;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

trait HandlesUploads
{
    protected function storeUpload(Request $request, string $field, string $directory, ?string $oldPath = null): ?string
    {
        if (! $request->hasFile($field)) {
            return null;
        }

        if ($oldPath) {
            Storage::disk('public')->delete($oldPath);
        }

        return $request->file($field)->store($directory, 'public');
    }
}
