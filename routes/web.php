<?php

use App\Http\Controllers\V1\RenderForm;

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


Route::get('form/{slug}', [RenderForm::class,'show'])->name('form.show');
Route::post('/form/{slug}', [RenderForm::class,'submit'])->name('form.submit');