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
        'has_submission',
        'start_time',
        'end_time',
        'description',
        'location',
        'practicum_id',
    ];

    public function practicum()
    {
        return $this->belongsTo(Practicum::class);
    }

    public function submissions()
    {
        return $this->hasMany(Submission::class);
    }

    public function attachments()
    {
        return $this->hasMany(Attachment::class);
    }
}
