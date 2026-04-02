<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
 
class ForumThread extends Model
{
    protected $fillable = [
        'user_id', 'category_id', 'title', 'body',
        'is_pinned', 'is_resolved', 'views_count'
    ];
 
    public function user()      { return $this->belongsTo(User::class); }
    public function category()  { return $this->belongsTo(ForumCategory::class); }
    public function replies()   { return $this->hasMany(ForumReply::class, 'thread_id'); }
    public function likes()     { return $this->morphMany(Like::class, 'likeable'); }
    public function latestReply() {
        return $this->hasOne(ForumReply::class, 'thread_id')->latestOfMany();
    }
}