<?php

use App\Http\Controllers\ShowLocationPageController;
use App\Http\Controllers\ShowPageController;
use App\Http\Controllers\ShowPropertyController;
use App\Http\Controllers\ShowTagPageController;
use App\Imports\PropertiesImport;
use Illuminate\Support\Facades\Route;
use Maatwebsite\Excel\Facades\Excel;
use Spatie\LaravelSettings\Migrations\SettingsMigration;
use Spatie\Sitemap\SitemapGenerator;
use Illuminate\Support\Facades\Cache;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/



Route::get('/', function () {

    if (!Cache::has("page.1")) {
        return redirect('/');
    }


    $page = Cache::get("page.1");


    return view('welcome')->with(['page' => $page]);
})->name('home.page');


Route::redirect('/property','/properties');

Route::get('location/{branch:slug}', ShowLocationPageController::class)->name('permalink.location.show');
Route::get('tag/{tag:slug}', ShowTagPageController::class)->name('permalink.tag.show');
Route::get('properties/{permalink:slug}', ShowPageController::class)->name('permalink.property.show');
Route::get('/{permalink:slug}', ShowPageController::class)->name('permalink.show');

Route::fallback(function () {
    $page = \App\Models\Page::query()->with('sections', 'link')->where('is_front_page', true)->firstOrFail();

    return view('welcome')->with(['page' => $page]);
});
