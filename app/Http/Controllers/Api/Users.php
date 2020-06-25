<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Status;
use App\TaskUser;
use App\User;
use Illuminate\Http\Request;

class Users extends Controller
{
    public function index()
    {


        $get_name = request()->get("name");
        $get_surname = request()->get("surname");
        $get_fathername = request()->get("fathername");
        $get_task = request()->get("task");
        $users = User::with("tasks.task.status")->where(function ($query) use ($get_name, $get_surname, $get_fathername, $get_task) {
            if (isset($get_name) and strlen($get_name) > 0) {
                $query->where("name", "like", "%" . $get_name . "%");

            }
            if (isset($get_surname) and strlen($get_surname) > 0) {
                $query->where("surname", "like", "%" . $get_surname . "%");

            }
            if (isset($get_fathername) and strlen($get_fathername) > 0) {
                $query->where("fathername", "like", "%" . $get_fathername . "%");

            }
            if (isset($get_task) and strlen($get_task) > 0) {
                $query->whereHas("tasks.task", function ($query) use ($get_task) {
                    $query->where("name", "like", "%" . $get_task . "%");
                });

            }

        })->get();

        return response($users);
    }

    public function show($id)
    {

        $user = User::with("tasks")->findOrFail($id);
        $newtasks = array();
        if (isset($user)) {

            if (isset($user->tasks) and count($user->tasks) > 0) {
                $tasks = $user->tasks;

                foreach ($tasks as $task) {
                    $newtasks[] = $task->task_id;
                }


            }
        }

        $response = array();
        $response['user'] = $user;
        $response['tasks'] = $newtasks;

        return $response;
    }

    public function update($id)
    {
        $request = request();
        $user = User::with('tasks')->findOrFail($id);
        $all = $request->all();
        if (isset($user->tasks) and count($user->tasks)) {
            $user->tasks()->delete();
        }

        $user->name = $all['name'];
        $user->surname = $all['surname'];
        $user->fathername = $all['fathername'];
        $user->email = $all['email'];
        $user->image = $all['image'];

        $user->save();

        if (isset($all['tasks']) and is_array($all['tasks']) and count($all['tasks']) > 0) {
            foreach ($all['tasks'] as $id_task) {
                if (!is_bool($id_task)) {
                    $task_user = new TaskUser();
                    $task_user->task_id = $id_task;
                    $task_user->user_id = $user->id;
                    $task_user->save();
                }

            }
        }


        return $user;
    }

    public function upload()
    {
        $request = request();
        $imageName = time() . '.' . $request->file->getClientOriginalExtension();
        $request->file->move(public_path('uploads'), $imageName);
        $web_url = "/uploads/" . $imageName;
        return response()->json(['image' => $web_url, 'success' => 'You have successfully upload image.']);
    }

    public function store()
    {
        $request = request();
        $all = $request->all();
        if (!isset($all['password'])) {
            $all['password'] = bcrypt("123456");
        }
        $request = request();
        $user = new User;


        $user->name = $all['name'];
        $user->surname = $all['surname'];
        $user->fathername = $all['fathername'];
        $user->email = $all['email'];
        if (isset($all['image'])) {
            $user->image = $all['image'];
        }
        $user->password = $all['password'];

        $user->save();

        if (isset($all['tasks']) and is_array($all['tasks']) and count($all['tasks']) > 0) {
            foreach ($all['tasks'] as $id_task) {
                if (!(is_bool($id_task) or is_null($id_task))) {
                    $task_user = new TaskUser();
                    $task_user->task_id = $id_task;
                    $task_user->user_id = $user->id;
                    $task_user->save();
                }

            }
        }


        return $user;


    }

    public function destroy($id)
    {
        $status = User::findOrFail($id);
        $status->delete();
        return '';
    }
}
