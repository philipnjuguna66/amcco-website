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
        $page = \App\Models\Page::query()->with('sections', 'link')->where('is_front_page', true)->firstOrFail();


    return view('welcome')->with(['page' => $page]);
})->name('home.page');


Route::redirect('/property','/properties-for-sale');

Route::get('location/{branch:slug}', ShowLocationPageController::class)->name('permalink.location.show');
Route::get('tag/{tag:slug}', ShowTagPageController::class)->name('permalink.tag.show');
Route::get('property/{permalink:slug}', ShowPageController::class)->name('permalink.property.show');
Route::get('/{permalink:slug}', ShowPageController::class)->name('permalink.show');

Route::fallback(function () {
    $page = \App\Models\Page::query()->with('sections', 'link')->where('is_front_page', true)->firstOrFail();

    return view('welcome')->with(['page' => $page]);
});
