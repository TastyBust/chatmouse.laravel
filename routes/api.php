<?php

use App\Http\Controllers\Messager;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;



//Получение hasha для пользователя. Передача site, name, email, и сохранять в куки. Secret сохранить тоже в куки
Route::get('/hash', 'App\Http\Controllers\Messager@getHash');
// Авторизация админа
Route::post('/login', 'App\Http\Controllers\Messager@login');
// Регистрация админа
Route::post('/register', 'App\Http\Controllers\Messager@register');
// Отправка сообшения пользователем. Передача secret, message в body
Route::post('/u/sender', 'App\Http\Controllers\Messager@senderu');
// Отпрака сообщения админом. Передача secret, message в body
Route::post('/a/sender', 'App\Http\Controllers\Messager@sendera');
// Получение всех сообщений для пользователя. Только Secret
Route::post('u/messages', 'App\Http\Controllers\Messager@messagesu');
// Получение всех сообщений для админа. Только Secret
Route::post('a/messages', 'App\Http\Controllers\Messager@messagesa');
