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
        return self::with('phone')->get();
    }

    public function getUserById($id)
    {
        return self::with('phone')->find($id);
    }

    public function createUser($data,$phoneData)
    {
        $user = self::create($data);
        $this->addNewPhone($user->id, $phoneData);
    }

    public function updateUser($data, $id, $phoneData)
    {
        self::find($id)->update($data);
        $this->updatePhone($phoneData, $id);
    }

    public function deleteUser($id)
    {
        $user = self::find($id);
        $user->phone()->delete();
        $user->delete();
    }

    public function addNewPhone($userId, $phoneData)
    {
        $user = self::find($userId);

        if ($user) {
            $phone = new Phone($phoneData);
            $user->phone()->save($phone);
        }
    }

    public function updatePhone($phoneData, $userId){
        $user = self::find($userId);    
        if ($user) {
            $user->phone()->update($phoneData);
        }
    }

    public function phone():HasOne
    {
        return $this->hasOne(Phone::class, 'user_id');
    }
}
