<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attachment extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'link',
        'filename',
        'submission_id',
        'activity_id',
    ];

    public function submission()
    {
        return $this->belongsTo(Submission::class);
    }

    public function activity()
    {
        return $this->belongsTo(Activity::class);
    }
}
