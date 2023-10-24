<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Comment extends Model
{
    /**
    * The attributes that are mass assignable.
    *
    * @var string[]
    */
    protected $fillable = [
    'review',
    'postId'
    ];
    /**
    * The attributes excluded from the model's JSON form.
    *
    * @var string[]
    */
    protected $hidden = [];
    public function post()
    {
        return $this->belongsTo(Post::class, 'postId');
    }
}