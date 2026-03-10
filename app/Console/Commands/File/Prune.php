<?php

namespace App\Console\Commands\File;

use App\Mail\File\Deleted;
use App\Models\File;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class Prune extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'file:prune';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Prune old files from storage and database';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        File::where('created_at', '<', now()->subHours(24))->chunkById(100, function ($files) {
            foreach ($files as $file) {
                $fileName = $file->name;
                $filePath = $file->path;

                if (Storage::delete($file->path)) {
                    $file->delete();
                    $this->info(sprintf(
                        'Pruned file: %s (Path: %s)',
                        $fileName,
                        $filePath
                    ));
                    Mail::to(config('mail.admin_address'))->send(new Deleted($fileName, $filePath));
                }
            }
        });
    }
}
