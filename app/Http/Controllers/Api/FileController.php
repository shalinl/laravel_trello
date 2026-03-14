<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Comment;
use App\Models\File;

class FileController extends Controller
{
    

    public function uploadFile(Request $req){
         $req->validate([
            'file' => 'required|mimes:jpg,png,pdf|max:2048', // Max 2MB
            'task_id'=>'required|integer'
        ]);

        try{
            // Store file inside storage/app/public/uploads
            $path = $req->file('file')->store('uploads', 'public');
            $url = Storage::url($path);
            $comment = Comment::create([
                    'description' => "",
                    'user_id'=>$req->user()->id,
                    'task_id'=>$req->task_id,
            ]);

            $uploadFile = File::create([
                    'url' => $url,
                    'comment_id'=>$comment->id
                ]);


            return response()->json(['status'=>'success', 'message'=>'File uploaded successfully!'],201);
        }
        catch (\Exception $e) {

            return response()->json([
                'status' => 'error',
                'message' => 'File upload failed'
            ], 500);

        }
    }

}
