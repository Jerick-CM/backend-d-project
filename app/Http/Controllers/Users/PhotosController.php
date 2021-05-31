<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PhotosController extends Controller
{
    /**
     * Get user photo/avatar
     *
     * @param int $id
     * @return file
     */
    public function get($filename)
    {
        if (! Storage::exists("avatar/$filename")) {
            $filename = public_path('img/default-avatar.png');
        } else {
            $filename = storage_path("app/avatar/$filename");
        }

        return response()->file($filename);
    }
}
