<?php

use App\Models\UserModel;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $users = UserModel::with('passwords')->get();
    return response()->json($users);
});
