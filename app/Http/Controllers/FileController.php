<?php

namespace App\Http\Controllers;

use App\Models\File;

class FileController extends Controller
{
    public function index()
    {
        return view('welcome', [
            'files' => File::latest('id')->paginate(5),
        ]);
    }
}
