<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    // Specify the table to use (since we're using the users table)
    protected $table = 'users';

    // You can also define any specific fields you want to interact with
    protected $fillable = ['name', 'email', 'role'];

    // Optionally, if you have timestamps in the `users` table:
    public $timestamps = true;

    // Add a scope for students only (filter users by role)
    public function scopeStudents($query)
    {
        return $query->where('role', 'student');
    }
}
