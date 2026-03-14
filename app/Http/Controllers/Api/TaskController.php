<?php

namespace App\Http\Controllers\Api;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Task;

class TaskController extends Controller
{
    

    public function createTask(Request $req){

        $req->validate(['name'=>'required|min:2',
                        'description'=>'required|min:6'
                        ]);
        
        try{
            $task = Task::create([
                'name' => $req->name,
                'description' => $req->description,
                'user_id'=>$req->user()->id
            ]);
            return response()->json(['message'=>"Task created successfully",
                'data' => $task],201);
        }
        catch(\Exception $e){
            return response()->json(['error'=>$e->getMessage()],500);
        }
    }

    public function updateTask(Request $req,string $id){

        $req->validate(['name'=>'required|min:2',
                        'description'=>'required|min:6'
                        ]);
        
        try{

            $task = Task::where(['id'=>$id,'user_id'=>$req->user()->id])->first();
            if(!$task){
                return response()->json(['error'=>'Task Not found'],404);
            }

            $task->update([
                                    'name'=>$req->name,
                                    'description'=>$req->description
                            ]);
            return response()->json(['data'=>$task],200);
        }
        catch(\Exception $e){
            return response()->json(['error'=>$e->getMessage()],500);
        }
    }

    public function deleteTask(Request $req,string $id){

        try{
            $task = Task::where(['id'=>$id,'user_id'=>$req->user()->id])
                        ->first();
            if(!$task){
                return response()->json(['error'=>'Task Not found'],404);
            }
            $task->delete();
            return response()->json(['message'=>'deleted successfully'],200);
        }
        catch(\Exception $e){
            return response()->json(['error'=>$e->getMessage()],500);
        }
    }

    public function getAllTasks(Request $req){
        try{
            $tasks = Task::where('user_id',$req->user()->id)->get();
            return response()->json(['status'=>'success','data'=>$tasks],200);
        }
        catch(\Exception $e){
            return response()->json(['error'=>$e->getMessage()],500);
        }
    }

    public function getTaskbyId(Request $req,string $id){
        try{
            $task = DB::table('tasks')
                        ->join('comments','tasks.id','=','comments.task_id')
                        ->join('users','tasks.user_id','=','users.id')
                        ->join('files','comments.id','=','files.comment_id')
                        ->where('tasks.id',$id)->get();
            return response()->json(['status'=>'success','data'=>$task],200);
        }
        catch(\Exception $e){
            return response()->json(['error'=>$e->getMessage()],500);
        }
    }


}
