<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Practicum extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'location',
        'schedule',
        'department_id',
    ];

    public function department()
    {
        return $this->belongsTo(Department::class);
    }
    public function activities()
    {
        return $this->hasMany(Activity::class);
    }
    public function users()
    {
        return $this->belongsToMany(User::class, 'user_practicum');
    }
}
