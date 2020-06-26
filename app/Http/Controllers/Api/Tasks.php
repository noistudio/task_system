<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Status;
use App\Task;
use App\TaskUser;
use App\User;
use Illuminate\Http\Request;

class Tasks extends Controller
{
    public function index()
    {


        $get_name = request()->get("name");
        $get_status_id = request()->get("status_id");
        $get_description = request()->get("description");
        $user = request()->user();

        $tasks = Task::with('users.user', 'status')->where(function ($query) use ($get_name, $get_status_id, $get_description, $user) {
            if (isset($get_name) and strlen($get_name) > 0) {
                $query->where("name", "like", "%" . $get_name . "%");
            }
            if (isset($get_description) and strlen($get_description) > 0) {
                $query->where("description", "like", "%" . $get_name . "%");
            }
            if (isset($get_status_id) and is_numeric($get_status_id) > 0) {
                $query->where("status_id", $get_status_id);
            }
            if ($user->isadmin == false) {
                $query->whereHas("users", function ($subquery) use ($user) {
                    $subquery->where("user_id", $user->id);
                });
            }


        })->get();

        $response = array();


        return response($tasks);
    }

    public function edit($id)
    {
        $task = Task::with("users")->findOrFail($id);
        $newusers = array();
        if (isset($task)) {

            if (isset($task->users) and count($task->users) > 0) {
                $users = $task->users;

                foreach ($users as $user) {
                    $newusers[] = $user->user_id;
                }

                $task->users = $newusers;


            }
        }

        $response = array();
        $response['task'] = $task;
        $response['users'] = $newusers;

        return $response;
    }

    public function update($id)
    {
        $request = request();
        $task = Task::findOrFail($id);
        if (isset($task)) {
            $params = $request->all();
            $task->name = $params['name'];
            $task->description = $params['description'];
            $task->status_id = $params['status_id'];

            if (isset($params['users']) and is_array($params['users']) and count($params['users']) > 0) {
                foreach ($params['users'] as $id_user => $user) {
                    $task_user = new TaskUser();
                    $task_user->task_id = $task->id;
                    $task_user->user_id = $id_user;
                    $task_user->save();

                }
            }
        }


        return $task;
    }


    public function store()
    {
        $request = request();
        $all = $request->all();

        if (isset($request['id'])) {
            $task = Task::with('users')->findOrFail($request['id']);
        } else {
            $task = new Task();
        }


        $task->name = $all['name'];
        $task->description = $all['description'];
        $task->status_id = $all['status_id'];
        $task->save();
        if (isset($task->users) and count($task->users)) {
            $task->users()->delete();
        }
        // \DB::table("tasks_users")->where("task_id", $task->id)->delete();

        if (isset($all['users']) and is_array($all['users']) and count($all['users']) > 0) {
            foreach ($all['users'] as $id_user) {
                if (!(is_bool($id_user) or is_null($id_user))) {
                    $task_user = new TaskUser();
                    $task_user->task_id = $task->id;
                    $task_user->user_id = $id_user;
                    $task_user->save();
                }

            }
        }


        return $task;
    }

    public function destroy($id)
    {
        $task = Task::findOrFail($id);
        $task->delete();
        return '';
    }
}
