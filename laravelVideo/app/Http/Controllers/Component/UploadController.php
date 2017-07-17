<?php

namespace App\Http\Controllers\Component;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UploadController extends Controller
{
    public function uploader(Request $request)
    {
        $upload = $request->file;
        if ($upload->isValid()) {
            $path = $upload->store(date('ym'), 'attachment');

            return ['valid' => 1, 'message' => asset('attachment/'.$path)];
        }

        return ['valid' => 0, 'message' => '上传失败文件大小不能超过2MB'];
    }

    public function filesLists()
    {
        return ['data' => [], 'page' => ''];
    }
}
