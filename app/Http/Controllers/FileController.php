<?php

namespace App\Http\Controllers;

use App\Http\Requests\File\UploadRequest;
use App\Jobs\File\Store;
use App\Mail\File\Deleted;
use App\Models\File;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Mail;
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
        $failedFiles = [];

        /** @var UploadedFile $file */
        foreach ($request->file('files') as $file) {
            $path = $file->store('temp');
        
            if (!$path) {
                $failedFiles[] = $file;
                continue;
            }

            Store::dispatch($path, $file->getClientOriginalName());
        }

        $status = match ($failedFiles === []) {
            true => 'Files are queued for storing successfully!',
            false => sprintf(
                'Some files failed to upload: %s',
                implode(', ', array_map(
                    fn ($file) => $file->getClientOriginalName(),
                    $failedFiles
                ))
            ),
        };

        return redirect()->route('files.index')->with('status', $status);
    }

    public function delete(File $file)
    {
        $fileName = $file->name;
        $filePath = $file->path;

        if (Storage::delete($file->path) && $file->delete()) {
            Mail::to(config('mail.admin_address'))->send(new Deleted($fileName, $filePath));

            return redirect()->route('files.index')->with('status', 'File deleted successfully!');
        }

        return redirect()->route('files.index')->with('status', 'Failed to delete the file.');
    }
}
