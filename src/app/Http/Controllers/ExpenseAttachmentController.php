<?php

namespace App\Http\Controllers;

use App\Models\ExpenseAttachment;
use Illuminate\Support\Facades\Storage;

class ExpenseAttachmentController extends Controller
{

    public function download(ExpenseAttachment $attachment)
    {

        if (!Storage::disk('public')->exists($attachment->file_path)) {
            abort(404, 'File not found.');
        }

        return Storage::disk('public')->download($attachment->file_path, $attachment->file_name);
    }
} 