<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'description', 'user_id'];

    public function getAllPosts(){
        return self::all();
    }

    public function getPostById($id){
        $post = self::find($id);
        $post->user;
        return $post;
    }

    public function createPost($data){
        self::create($data);
    }

    public function updatePost($data, $id){
        self::find($id)->update($data);
    }

    public function deletePost($id){
        self::find($id)->delete();
    }

    public function user(){
        return $this->belongsTo(Users::class);
    }
}
