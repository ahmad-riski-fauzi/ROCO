<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = ['post_id', 'user_id', 'parent_id', 'body'];

    // Relasi user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi balasan (replies)
    public function replies()
    {
        return $this->hasMany(Comment::class, 'parent_id');
    }

    // Relasi parent (komentar yang dibalas)
    public function parent()
    {
        return $this->belongsTo(Comment::class, 'parent_id');
    }

}
