<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkExperience extends Model
{
    use HasFactory;
    protected $table = 'work_experience'; // Specify the table name
    protected $fillable = ['title_en', 'title_ar', 'description_en', 'description_ar', 'image'];
}
