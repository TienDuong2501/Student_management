<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class HomeWork extends Model
{
    protected $table = "homeworks";
    protected $fillable = [
        'home_work',
        'name',
        'original_name',
        'saved_path',
        'hash',
    ];

    public function getLinkAttribute()
    {
    	return url('/') . '/storage/' . $this->saved_path;
    }

    public function answers()
    {
        return $this->hasMany(DoneHomeWork::class);
    }
}
