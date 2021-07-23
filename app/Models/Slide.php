<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Lesson;

class Slide extends Model
{
    use HasFactory;
    protected $fillable = ['lesson_id', 'title', 'content'];

    public function lesson()
    {
        return $this->belongsTo(Lesson::class, 'lesson_id', 'id');
    }

    public function belongsToUser($userId)
    {
        if ($this->lesson) {
            return $this->lesson->user_id === $userId;
        }
        return false;
    }
}
