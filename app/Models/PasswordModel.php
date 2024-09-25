<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PasswordModel extends Model
{
    use HasFactory;

    protected $table = 'passwords';

    // each password belongs to a user
    public function user() {
        return $this->belongsTo(UserModel::class, 'user_id');
    }
}
