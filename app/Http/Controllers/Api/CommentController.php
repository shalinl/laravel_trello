<?php

namespace App\Http\Controllers\Api;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Comment;

class CommentController extends Controller
{
    public function createComment(Request $req){

        $req->validate(['description'=>'required|min:6',
                        'task_id'=>'required|integer'
                        ]);
        
        try{
            $comment = Comment::create([
                'description' => $req->description,
                'user_id'=>$req->user()->id,
                'task_id'=>$req->task_id
            ]);
            return response()->json(['message'=>"Comment created successfully",
                'data' => $comment],201);
        }
        catch(\Exception $e){
            return response()->json(['error'=>$e->getMessage()],500);
        }
    }

    public function updateComment(Request $req,string $id){

        $req->validate(['description'=>'required|min:6'
                        ]);
        
        try{

            $comment = Comment::where(['id'=>$id])
                                ->first();
            if(!$comment){
                return response()->json(['error'=>'Comment Not found'],404);
            }

            $comment->update([
                                    'description'=>$req->description
                            ]);
            return response()->json(['data'=>$comment],200);
        }
        catch(\Exception $e){
            return response()->json(['error'=>$e->getMessage()],500);
        }
    }

    public function deleteComment(Request $req,string $id){

        try{
            $comment = Comment::where(['id'=>$id,
                                       'user_id'=>$req->user()->id])
                                ->first();
            if(!$comment){
                return response()->json(['error'=>'Comment Not found'],404);
            }
            $comment->delete();
            return response()->json(['message'=>'deleted successfully'],200);
        }
        catch(\Exception $e){
            return response()->json(['error'=>$e->getMessage()],500);
        }
    }

    
    public function getAllComments(Request $req){
        try{
            $comments = Comment::where('user_id',$req->user()->id)->get();
            return response()->json(['status'=>'success','data'=>$comments],200);
        }
        catch(\Exception $e){
            return response()->json(['error'=>$e->getMessage()],500);
        }
    }

    public function getAllCommentsbyTask(Request $req){
        try{
            $comments = Comment::where(['user_id'=>$req->user()->id,
                                        'task_id'=>$req->task_id])->get();
            return response()->json(['status'=>'success','data'=>$comments],200);
        }
        catch(\Exception $e){
            return response()->json(['error'=>$e->getMessage()],500);
        }
    }

    public function getCommentbyId(Request $req,string $id){
        try{
            $comment = DB::table('comments')
                        ->join('files','comments.id','=','files.comment_id')
                        ->where('comments.id',$id)->get();
            return response()->json(['status'=>'success','data'=>$comment],200);
        }
        catch(\Exception $e){
            return response()->json(['error'=>$e->getMessage()],500);
        }
    }
}
