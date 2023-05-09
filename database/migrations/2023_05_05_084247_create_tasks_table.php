<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
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
            $table->string('name');
            $table->unsignedBigInteger('assignee')->nullable();
            $table->foreign('assignee')->references('id')->on('users');
            $table->enum('status', ['new', 'in_progress', 'resolved', 'closed'])->default('new')->nullable();
            $table->enum('priority', ['normal', 'low', 'high', 'urgent'])->default('normal')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('project_id')->nullable();
            $table->foreign('created_by')->references('id')->on('users');
            $table->foreign('project_id')->references('id')->on('projects');
            $table->timestamps();
            $table->softDeletes();
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
    }
};
