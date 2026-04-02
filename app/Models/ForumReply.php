<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
 
class ForumReply extends Model
{
    protected $fillable = ['thread_id', 'user_id', 'body', 'is_best_answer'];
 
    public function user()   { return $this->belongsTo(User::class); }
    public function thread() { return $this->belongsTo(ForumThread::class); }
    public function likes()  { return $this->morphMany(Like::class, 'likeable'); }
}