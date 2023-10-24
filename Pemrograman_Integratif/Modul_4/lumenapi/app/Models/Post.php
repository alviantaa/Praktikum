<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Post extends Model
{
    /**
    * The attributes that are mass assignable.
    *
    * @var string[]
    */
    protected $fillable = [
    'content'
    ];
    /**
    * The attributes excluded from the model's JSON form.
    *
    * @var string[]
    */
    protected $hidden = [];

    public function comments()
    {
        return $this->hasMany(Comment::class, 'postId');
    }
    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'post_tag', 'postId', 'tagId');
    }
}