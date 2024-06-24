<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Approved extends Model
{
    use HasFactory;

    protected $fillable = [

        'image',
    ];

    // Disable timestamps
    public $timestamps = false;
}
