<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('category_id');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('title');
            $table->text('description', 500)->nullable();
            $table->integer('position')->default(0)->comment("posiçao dentro da categoria");
            $table->timestamps();

            $table->foreign('user_id', 'user_id_task_fk')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('category_id', 'category_id_fk')->references('id')->on('categories')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
