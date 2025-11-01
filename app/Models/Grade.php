<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Grade extends Model
{
    use HasFactory;

    // Specify which fields are mass assignable
    protected $fillable = [
        'student_name',
        'course_code',
        'course_title',
        'term',
        'credit_hours',
        'grade'
    ];
}
