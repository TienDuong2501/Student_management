<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DoneHomeWork extends Model
{
    protected $table = "done_homeworks";

    protected $fillable = [
        'student_id',
        'home_work_id',
        'result',
        'original_name',
        'description',
        'saved_path',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    public function homeworks()
    {
        return $this->belongsTo(HomeWork::class, 'home_work_id');
    }

    public function getLinkAttribute()
    {
    	return url('/') . '/storage/' . $this->saved_path;
    }
}
