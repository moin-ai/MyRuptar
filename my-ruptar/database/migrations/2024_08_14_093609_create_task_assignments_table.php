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
    Schema::create('task_assignments', function (Blueprint $table) {
        $table->id();
        $table->foreignId('task_id')->constrained('tasks')->onDelete('cascade');
        $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
        $table->timestamp('assigned_at');
        $table->timestamp('completed_at')->nullable();
        $table->timestamps();
    });
}

};
