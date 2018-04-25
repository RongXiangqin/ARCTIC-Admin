<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return $router->app->version();
});


//添加相册
$router->post('ferret/addAlbum','Ferret\AlbumController@add');
//显示相册信息
$router->get('ferret/showAlbum/{album_id:[0-9]+}','Ferret\AlbumController@show');
//获取相册成员信息
$router->get('ferret/getAlbum/{id:[0-9]+}','Ferret\AlbumController@getAlbum');
//获取相册名称、id
$router->get('ferret/getAlbumName/{parent_id:[0-9]+}','Ferret\AlbumController@getAlbumName');

//添加图像
$router->post('ferret/addImage','Ferret\ImageController@add');
//获取图像信息
$router->get('ferret/showImage/{image_id:[0-9]+}','Ferret\ImageController@show');
//分页获取相册s
$router->get('ferret/getAlbums/{state:[0-9]+}','Ferret\AlbumController@getAlbums');
//分页获取图像s
$router->get('ferret/getImages/{album_id:[0-9]+}','Ferret\ImageController@getImages');