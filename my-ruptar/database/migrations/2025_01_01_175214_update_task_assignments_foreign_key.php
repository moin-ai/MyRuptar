<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateTaskAssignmentsForeignKey extends Migration
{
    public function up()
    {
        Schema::table('task_assignments', function (Blueprint $table) {
            // First drop the existing foreign key
            $table->dropForeign(['user_id']);
            
            // Add the new foreign key with cascade delete
            $table->foreign('user_id')
                  ->references('id')
                  ->on('users')
                  ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('task_assignments', function (Blueprint $table) {
            // Drop the cascade delete foreign key
            $table->dropForeign(['user_id']);
            
            // Restore the original foreign key without cascade
            $table->foreign('user_id')
                  ->references('id')
                  ->on('users');
        });
    }
}
