<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DashboardPostController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

// Redirect root
Route::redirect('/', '/posts');

// Authentication Routes
Route::controller(LoginController::class)->group(function () {
    Route::get('/login', 'show')->name('login');
    Route::post('/login', 'authenticate')->name('login');
    Route::get('/logout', 'logout')->middleware('auth')->name('logout');
});

Route::controller(RegisterController::class)->group(function () {
    Route::get('/register', 'show')->name('register');
    Route::post('/register', 'store')->name('register');
});

// Public Post Routes (Search harus di atas post detail agar tidak tertangkap oleh {slug})
Route::get('/posts/search', [SearchController::class, 'index'])->name('search');

Route::prefix('categories')->name('categories.')->controller(CategoryController::class)->group(function(){
    Route::get('/{slug}', 'show')->name('show');
});


Route::controller(PostController::class)->group(function () {
    Route::get('/posts', 'index')->name('posts');
    Route::get('/posts/{slug}', 'show')->name('posts.slug')->middleware('auth');
});

// Authenticated User Routes
Route::middleware('auth')->group(function () {
    Route::prefix('comments')->name('comments.')->controller(CommentController::class)->group(function () {
        Route::post('/store', [CommentController::class, 'store'])->name('store');
        Route::delete('/delete/{id}', [CommentController::class, 'delete'])->name('delete');
    });

    // Dashboard Home
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Dashboard Profile
    Route::prefix('/dashboard/profile')->controller(DashboardController::class)->group(function () {
        Route::get('/', 'profile')->name('profile');
        Route::get('/edit', 'editProfile')->name('edit-profile');
        Route::post('/update', 'update')->name('update-profile');
        Route::put('/update', 'update')->name('update-profile');
    });

    // Dashboard Posts
    Route::prefix('/posts')->name('posts.')->controller(DashboardPostController::class)->group(function () {
        Route::post('/upload', 'store')->name('upload');
        Route::get('/preview/{slug}', 'preview')->name('preview');

        Route::get('/edit/{slug}', 'edit')->name('edit');
        Route::post('/update/{slug}', 'update')->name('update');
        Route::put('/update/{slug}', 'update')->name('update');

        Route::delete('/delete/{id}', 'delete')->name('delete');
    });

    // Legacy Route
    Route::get('/post', [DashboardPostController::class, 'show'])->name('show.post');

    // User Routes
    Route::get('/users/{username}', [UserController::class, 'preview'])->name('users.preview');
    Route::get('/users/{user:username}/posts', [UserController::class, 'all'])->name('users.posts.all');
    Route::get('/users/{user:username}/posts/{post:slug}', [UserController::class, 'show'])->name('users.posts.show');

    Route::middleware(['auth'])->group(function () {
        Route::delete('/admin/users/{username}', [AdminController::class, 'destroyUser'])->name('admin.users.destroy');

        // Route::delete('/admin/posts/{username}', [AdminController::class, 'destroyPost'])->name('admin.posts.destroy');

        Route::delete('/admin/posts/{id}', [AdminController::class, 'destroyPost'])->name('admin.posts.destroy');

    });

});
