<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\User;

class Favorite extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'lesson_id'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}