<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Tag extends Model
{
    /**
    * The attributes that are mass assignable.
    *
    * @var string[]
    */
    protected $fillable = [
    'name'
    ];
    /**
    * The attributes excluded from the model's JSON form.
    *
    * @var string[]
    */
    protected $hidden = [];

    public function posts()
    {
        return $this->belongsToMany(Post::class, 'post_tag', 'tagId', 'postId');
    }
}