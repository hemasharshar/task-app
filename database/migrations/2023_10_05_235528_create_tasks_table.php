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
            $table->id('id');
            $table->string('title')->index();
            $table->text('description');
            $table->bigInteger('assigned_to_id')->unsigned()->index()->nullable();
            $table->bigInteger('assigned_by_id')->unsigned()->index()->nullable();
            $table->timestamp('created_at')->useCurrent()->index();
            $table->timestamp('updated_at')->useCurrent()->index();


            $table->foreign('assigned_to_id')->references('id')->on('users')
                ->onUpdate('cascade')->onDelete('restrict');
            $table->foreign('assigned_by_id')->references('id')->on('users')
                ->onUpdate('cascade')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('tasks');
    }
};
