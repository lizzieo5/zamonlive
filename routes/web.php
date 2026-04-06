<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SubscribeController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\NewsletterController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\TagController;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::view('/about', 'about')->name('about');
Route::get('/subscribe', [SubscribeController::class, 'index'])->name('subscribe');
Route::get('lang/{lang}', [LanguageController::class, 'switch'])->name('lang.switch');
Route::get('/search', [SearchController::class, 'index'])->name('search');
Route::post('/newsletter/subscribe', [NewsletterController::class, 'subscribe'])->name('newsletter.subscribe');
Route::post('/newspaper/subscribe', [NewsletterController::class, 'subscribe'])->name('newspaper.subscribe');

Route::get('/news/{slug}', [NewsController::class, 'show'])->name('news.show');
Route::get('/category/{slug}', [CategoryController::class, 'index'])->name('category');
Route::get('/tag/{slug}', [TagController::class, 'show'])->name('tag');
