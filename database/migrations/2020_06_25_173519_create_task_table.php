<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTaskTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->string("name", 200);
            $table->text("description");
            $table->integer("status_id")->nullable();


            $table->timestamps();
        });
        Schema::create('tasks_users', function (Blueprint $table) {
            $table->id();
            $table->integer("task_id");
            $table->integer("user_id");

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tasks');
        Schema::dropIfExists('tasks_users');

    }
}
