<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Blog\PostController as GuestPostController;
use App\Http\Controllers\Api\Blog\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Api\Blog\Admin\PostController as AdminPostController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::group(['prefix' => 'blog'], function () {
    Route::apiResource('posts', GuestPostController::class)->names('blog.posts');
});

$groupData = [
    'prefix' => 'admin/blog',
];

Route::group($groupData, function () {

    $methods = ['index', 'store', 'update'];
    Route::apiResource('categories', AdminCategoryController::class)
        ->only($methods)
        ->names('blog.admin.categories');

    // Пости
    Route::apiResource('posts', AdminPostController::class)
        ->except(['show'])
        ->names('blog.admin.posts');
});
