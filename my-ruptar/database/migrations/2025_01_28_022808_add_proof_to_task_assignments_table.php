<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddProofToTaskAssignmentsTable extends Migration
{
    public function up()
    {
        Schema::table('task_assignments', function (Blueprint $table) {
            $table->string('proof')->nullable()->after('completed_at'); // Add proof column
        });
    }

    public function down()
    {
        Schema::table('task_assignments', function (Blueprint $table) {
            $table->dropColumn('proof'); // Remove proof column on rollback
        });
    }
}
