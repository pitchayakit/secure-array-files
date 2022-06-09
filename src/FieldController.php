<?php

namespace MovexUkraine\SecureArrayFiles;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class FieldController extends Controller
{
    public function index(Request $request)
    {
        return "secure array files by Movex-Ukraine";
    }

    public function upload(Request $request)
    {
        $disk = $request->disk ? $request->disk : 'public';
        $path = $request->path ? $request->path : '/';

        $file = Storage::disk($disk)->putFileAs(
            $path, $request->file('file'), (new \DateTime('now'))->format('Y-m-d') . '/' . ($request->file('file'))->hashName()
        );

        return [
            'originalName' => $request->file('file')->getClientOriginalName(),
            'name' => $file,
            'url' => Storage::url($file),
        ];
    }

    public function download($storege, $path, $file)
    {
        $pathToFile = storage_path('app') . DIRECTORY_SEPARATOR . $path . DIRECTORY_SEPARATOR . $file;

        return response()->file($pathToFile);
    }

    public function delete(Request $request)
    {
        Storage::disk('public')->delete($request->path);

        return "Success delete file!";
    }

    public function deleteWithPath($path, $file)
    {
        Storage::delete($path . DIRECTORY_SEPARATOR . $file);

        return "Success delete file!";
    }
}
