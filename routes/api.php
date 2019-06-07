<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/add_author', 'AddController@addAuthor');

Route::post('/add_heading', 'AddController@addHeading');

Route::post('/add_news', 'AddController@addNews');





//выдача всех новостей конкретного автора
Route::get('/find_news', 'SearchController@searchAllNewsOfAuthor');

//выдача списка всех новостей, которые относятся к указанной рубрике
Route::get('/find_news_by_heading', 'SearchController@searchNewsByHeading');

//выдача списка авторов
Route::get('/find_all_authors', 'SearchController@searchAllAuthors');

//выдача информации о статьях по их идентификаторам
Route::get('/find_news_by_id', 'SearchController@searchNewsByNewsId');


Route::get('/find_news_by_name', 'SearchController@searchNewsByName');

Route::get('/find_news_by_asd', 'SearchController@searchNewsByHeadingAndItsChildrenHeadings');