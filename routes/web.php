<?php

use Illuminate\Support\Facades\Route;

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/posts/novo', 'PostsController@novo');
Route::get('/posts/{post}', 'PostsController@show')->name('posts.show');
Route::post('/posts', 'PostsController@store')->name('posts.store');
Route::get('/posts/{post}/edit', 'PostsController@edit')->name('posts.edit');
Route::match(['put', 'patch'], '/posts/{posts}', 'PostsController@update')->name('posts.update');
Route::delete('/posts/{post}', 'PostsController@destroy')->name('posts.destroy');
Route::match(['put', 'patch'], '/posts/{post}/publish', 'PostsController@publish')->name('posts.publish');

// public routes
Route::get('/postagem/{post}', 'PublicController@postagem')->name('postagem');
Route::get('/', 'PublicController@index');
