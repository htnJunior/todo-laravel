<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Todo;
use Illuminate\Support\Facades\Validator;

class ApiController extends Controller
{
    public function createTodo(Request $request){
        $array = ['error' => ''];
        $rules = ['title' => 'required|min:2'];

        $validator = Validator::make($request->all(), $rules);

        if($validator->fails()){
            $array['error'] = $validator->messages();
            return $array;
        }

        $validator = $this->validatation($request, $rules);

        $title = $request->input('title');

        $todo = new Todo;
        $todo->title = $title;
        $todo->save();


        return $array;

    }

    public function readAllTodos(){
        $array = ['error' => ''];

        $array['list'] = Todo::All();

        return $array;
    }

    public function readTodo($id){
        $array = ['error' => ''];

        $todo = Todo::find($id);

        if($todo){
            $array['todo'] = $todo;
        }else{
            $array['error'] = 'No assignment has been found';
        }

        return $array;

    }

    public function updateTodo($id, Request $request){
        $array = ['error' => ''];
        $rules = [
            'title' => 'min:2',
            'done'  => 'boolean'
        ];

        $validator = Validator::make($request->all(), $rules);

        if($validator->fails()){
            $array['error'] = $validator->messages();
            return $array;
        }

        $title = $request->input('title');
        $done  = $request->input('done');

        $todo = Todo::find($id);

        if($todo){
            if($title){
                $todo->title = $title;
            }
            if($done !== NULL){
                $todo->done = $done;
            }

            $todo->save();
        }else{
            $array['error'] = 'No assignment has been found';
        }

        return $array;

    }

    public function deleteTodo($id){
        $array = ['error' => ''];

        $todo = Todo::find($id);
        if($todo){
            $todo->delete();
        }else{
            $array['error'] = 'No assignment has been found';
        }

    
        return $array;
    }

}
