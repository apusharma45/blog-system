<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\FollowController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Admin\AuthController as AdminAuthController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\DashboardController;

Route::get('/', [HomeController::class, 'index'])->name('home')->middleware('no-cache-auth');

// About Us page
Route::view('/about', 'about')->name('about');

// Contact Us page
Route::get('/contact', [HomeController::class, 'contact'])->name('contact');
Route::post('/contact', [HomeController::class, 'submitContact'])->name('contact.submit')->middleware('throttle:5,1');


Route::middleware(['auth'])->group(function () {
    // User-specific routes under /{username}
    Route::prefix('{username}')->where(['username' => '[a-zA-Z0-9._-]+'])->group(function () {
        // Dashboard and profile management
        Route::get('dashboard', [DashboardController::class, 'show'])->middleware('verified')->name('dashboard');
        
        // Profile management (edit page)
        Route::get('profile', [UserController::class, 'edit'])->name('user.profile');
        Route::put('profile', [UserController::class, 'update'])->name('profile.update');
        Route::put('profile/password', [UserController::class, 'updatePassword'])->name('profile.password.update');
        Route::delete('profile', [UserController::class, 'destroy'])->name('profile.destroy');
        
        // Settings routes (Volt)
        Route::redirect('settings', 'profile');
        Volt::route('settings/password', 'settings.password')->name('settings.password');
        Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');
        
        // User's content management
        Route::get('favourites', [FavoriteController::class, 'index'])->name('favorites.index');
        Route::get('posts/create', [PostController::class, 'create'])->name('posts.create');
        Route::get('posts/{post}/edit', [PostController::class, 'edit'])->name('posts.edit');
    });

    // Global authenticated actions (not user-specific URLs)
    Route::post('comments', [CommentController::class, 'store'])->name('comments.store')->middleware('throttle:10,1');
    Route::put('comments/{comment}', [CommentController::class, 'update'])->name('comments.update');
    Route::delete('comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');

    Route::post('posts/{post}/like', [LikeController::class, 'store'])->name('posts.like')->middleware('throttle:20,1');
    Route::delete('posts/{post}/like', [LikeController::class, 'destroy'])->name('posts.unlike');

    Route::post('users/{user}/follow', [FollowController::class, 'store'])->name('users.follow')->middleware('throttle:10,1');
    Route::delete('users/{user}/follow', [FollowController::class, 'destroy'])->name('users.unfollow');

    Route::post('posts/{post}/favorite', [FavoriteController::class, 'store'])->name('posts.favorite')->middleware('throttle:20,1');
    Route::delete('posts/{post}/favorite', [FavoriteController::class, 'destroy'])->name('posts.unfavorite');

    // Post management
    Route::post('posts', [PostController::class, 'store'])->name('posts.store');
    Route::put('posts/{post}', [PostController::class, 'update'])->name('posts.update');
    Route::post('posts/upload-image', [PostController::class, 'uploadImage'])->name('posts.upload-image');
});

// Admin Authentication Routes (outside auth middleware)
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('login', [AdminAuthController::class, 'showLoginForm'])->name('login');
    Route::post('login', [AdminAuthController::class, 'login'])->name('login.post');
    Route::post('logout', [AdminAuthController::class, 'logout'])->name('logout');
});

// Admin Routes (protected by admin middleware)
Route::prefix('admin')->name('admin.')->middleware('admin')->group(function () {
    Route::get('/', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('posts', [AdminController::class, 'posts'])->name('posts');
    Route::get('users', [AdminController::class, 'users'])->name('users');
    Route::get('comments', [AdminController::class, 'comments'])->name('comments');
    Route::get('categories', [AdminController::class, 'categories'])->name('categories');
    Route::get('contacts', [AdminController::class, 'contacts'])->name('contacts');
    
    // User Management
    Route::delete('users/{id}', [AdminController::class, 'deleteUser'])->name('users.delete');
    Route::post('users/{id}/suspend', [AdminController::class, 'suspendUser'])->name('users.suspend');
    
    // Post Management
    Route::delete('posts/{id}', [AdminController::class, 'deletePost'])->name('posts.delete');
    Route::post('posts/{id}/toggle-status', [AdminController::class, 'togglePostStatus'])->name('posts.toggle-status');
    
    // Comment Management
    Route::delete('comments/{id}', [AdminController::class, 'deleteComment'])->name('comments.delete');
    
    // Category Management
    Route::post('categories', [AdminController::class, 'storeCategory'])->name('categories.store');
    Route::put('categories/{id}', [AdminController::class, 'updateCategory'])->name('categories.update');
    Route::delete('categories/{id}', [AdminController::class, 'deleteCategory'])->name('categories.delete');
    
    // Contact Management
    Route::post('contacts/{id}/read', [AdminController::class, 'markContactAsRead'])->name('contacts.read');
    Route::post('contacts/{id}/unread', [AdminController::class, 'markContactAsUnread'])->name('contacts.unread');
    Route::delete('contacts/{id}', [AdminController::class, 'deleteContact'])->name('contacts.delete');
});

// Auth routes (must come before catch-all routes)
require __DIR__.'/auth.php';

// Error routes
Route::get('error/{status?}', [App\Http\Controllers\ErrorController::class, 'show'])->name('error');

// Public post routes
Route::get('posts', [PostController::class, 'index'])->name('posts.index')->middleware('cache.pages:300');
Route::get('{username}/{slug}', [PostController::class, 'show'])->name('posts.show')->middleware('cache.pages:300');

// Public user profile (view-only)
Route::get('@{username}', [UserController::class, 'show'])->where('username', '[a-zA-Z0-9._-]+')->name('users.profile')->middleware('cache.pages:300');
