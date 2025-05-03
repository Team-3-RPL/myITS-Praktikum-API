<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    use HasFactory;


    protected $fillable = [
        'name',
        'activity_type',
        'start_time',
        'end_time',
        'location',
        'practicum_id',
        'description',
    ];
}
