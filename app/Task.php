<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    //
    protected $table = "tasks";

    public function users()
    {

        return $this->hasMany("App\TaskUser", "task_id", "id");
    }

    public function status()
    {
        return $this->hasOne("App\Status", "id", "status_id");
    }
}
