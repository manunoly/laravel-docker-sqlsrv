<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/hello', function () {
    return 'Hello World';
});

Route::get('/mssql', function () {
    $results = DB::select('select * from users');
    return $results;
});

//test mssql connection
Route::get('/mssql/sql', function () {
    $connection = DB::connection('sqlsrv');
    $results = $connection->select("SELECT * FROM [dbo].[users]");
    return $results;
});
