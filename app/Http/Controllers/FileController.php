<?php

namespace App\Http\Controllers;

use App\Http\Requests\File\UploadRequest;
use App\Models\File;
use Illuminate\Support\Facades\Storage;

class FileController extends Controller
{
    public function index()
    {
        return view('welcome', [
            'files' => File::latest('id')->paginate(5),
        ]);
    }

    public function upload(UploadRequest $request)
    {
        /** @var UploadedFile $file */
        foreach ($request->file('files') as $file) {
            $path = $file->store('uploads');

            if ($path) {
                File::create([
                    'name' => $file->getClientOriginalName(),
                    'path' => $path,
                ]);
            } else {
                $unsavedFiles[] = $file;
            }
        }

        $redirect = redirect()->route('files.index');

        if (isset($unsavedFiles)) {
            $redirect->with('status', 'Some files could not be uploaded: ' . implode(', ', array_map(fn ($file) => $file->getClientOriginalName(), $unsavedFiles)));
        } else {
            $redirect->with('status', 'Files were uploaded successfully!');
        }

        return $redirect;
    }

    public function delete(File $file)
    {
        if (Storage::delete($file->path) && $file->delete()) {
            return redirect()->route('files.index')->with('status', 'File deleted successfully!');
        }

        return redirect()->route('files.index')->with('status', 'Failed to delete the file.');
    }
}
