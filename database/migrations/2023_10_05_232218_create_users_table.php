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
        Schema::create('users', function (Blueprint $table) {
            $table->id('id');
            $table->string('name')->index();
            $table->string('email')->index();
            $table->timestamp('email_verified_at');
            $table->string('password');
            $table->string('remember_token')->nullable();
            $table->timestamp('created_at')->useCurrent()->index();
            $table->timestamp('updated_at')->useCurrent()->index();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('users');
    }
};
