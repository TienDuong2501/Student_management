<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Comment extends Model
{
	protected $table = "comments";
    protected $fillable = [
        'commenter_id',
        'user_id',
        'content',
    ];

    public function user()
    {
    	$this->belongsTo(User::class, 'user_id');
    }

    public function getCommenterAttribute()
    {
        return User::find($this->commenter_id);
    }
}
