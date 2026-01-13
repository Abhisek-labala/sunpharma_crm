<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Response;

class FileController extends Controller
{
   public function show($path)
    {
        $disk = Storage::disk('private');

        if (!$disk->exists($path)) {
            abort(404);
        }

        $file = $disk->get($path);
        $mime = $disk->mimeType($path);

        return response($file, 200)->header('Content-Type', $mime);
    }
}
