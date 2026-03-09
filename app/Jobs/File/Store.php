<?php

namespace App\Jobs\File;

use App\Models\File;
use Exception;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class Store implements ShouldQueue
{
    use Queueable;

    public function __construct(
        protected string $tempPath,
        protected string $originalName,
    ) {
    }

    public function handle(): void
    {
        $path = sprintf('uploads/%s', basename($this->tempPath));
        $isMoved = Storage::move($this->tempPath, $path);
        
        if (!$isMoved) {
            throw new Exception(sprintf(
                'Failed to store the file: %s',
                $this->tempPath
            ));
        }

        $file = File::create([
            'name' => $this->originalName,
            'path' => $path,
        ]);

        if (!$file) {
            throw new Exception(sprintf(
                'Failed to create a database record for the file: %s',
                $path
            ));
        }
    }
}
