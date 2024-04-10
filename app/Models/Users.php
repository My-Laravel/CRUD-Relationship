<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Phone;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Users extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'email', 'password'];

    public function getAllUsers()
    {
        return self::with('posts')->get();
    }

    public function getUserById($id)
    {
        return self::with('posts')->find($id);
    }

    public function createUser($data)
    {
        self::create($data);
    }

    public function updateUser($data, $id)
    {
        self::find($id)->update($data);
    }

    public function deleteUser($id)
    {
        self::find($id)->delete();
    }

    public function posts(){
        return $this->hasMany(Post::class, 'user_id');
    }
}
