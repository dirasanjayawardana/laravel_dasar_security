<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get("/users/login", [\App\Http\Controllers\UserController::class, "login"]);
Route::get("/users/current", [\App\Http\Controllers\UserController::class, "current"])
->middleware(["auth"]);
Route::get("/api/users/current", [\App\Http\Controllers\UserController::class, "current"])
->middleware(["auth:token"]);
Route::get("/simple-api/users/current", [\App\Http\Controllers\UserController::class, "current"])
->middleware(["auth:simple-token"]);

Route::post("/api/todo", [\App\Http\Controllers\TodoController::class, "create"]);


require __DIR__ . '/auth.php';
