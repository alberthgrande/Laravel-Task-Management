<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = ['title', 'description', 'category_id', 'priority_id', 'status_id'];

    public function category() {
        return $this->belongsTo(Category::class);
    }
    
    public function priority() {
        return $this->belongsTo(Priority::class);
    }
    
    public function status() {
        return $this->belongsTo(Status::class);
    }
    
    public function users() {
        return $this->belongsToMany(User::class);
    }
    
    public function comments() {
        return $this->hasMany(Comment::class);
    }
}
