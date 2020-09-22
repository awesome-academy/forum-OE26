<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('setlocale/{locale}', 'LocaleController@setLocale')->name('set_locale');

Route::group(['middleware' => 'locale'], function () {
    Auth::routes();

    Route::get('/', 'HomeController@index')->name('home');
    Route::put('/', 'HomeController@editProfile')->name('profile');

    Route::resource('questions', 'QuestionController');
    Route::get('question-notifications', 'QuestionController@getQuestionNotifications');

    Route::resource('contents', 'ContentController')->only([
        'show',
    ]);

    Route::resource('answers', 'AnswerController')->only([
        'store',
        'edit',
        'update',
        'destroy',
    ]);

    Route::resource('comments', 'CommentController')->only([
        'store',
        'update',
        'destroy',
    ]);

    Route::get('searched', 'SearchController@searchedQuestions')->name('search');

    Route::group(['prefix' => 'tag'], function () {
        Route::get('/list', 'TagController@list')->name('tags');
        Route::get('/list-questions/{tag}', 'TagController@listQuestions')->name('tag_question');
    });

    Route::group(['prefix' => 'admin'], function () {
        Route::get('/dashboard', 'AdminController@index')->name('admin');
        Route::get('/tag', 'AdminController@createTag')->name('create_tag');
        Route::post('/tag', 'AdminController@storeTag')->name('store_tag');
        Route::put('/role', 'AdminController@updateUserRole')->name('update_role');
        Route::get('/chart', 'AdminController@userChart')->name('chart');
    });

    Route::get('history/{type}/{id}', 'HistoryController@getHistory')->name('history');
});

Route::get('search/{query}', 'SearchController@searchQuestion');

Route::prefix('/vote')->group(function () {
    Route::put('/up', 'VoteController@upVote');
    Route::put('/down', 'VoteController@downVote');
});
