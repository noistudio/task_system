<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TaskUser extends Model
{
    //
    protected $table = "tasks_users";


    public function task()
    {
        return $this->hasOne("App\Task", "id", "task_id");
    }

    public function user()
    {
        return $this->hasOne("App\User", "id", "user_id");
    }
}
