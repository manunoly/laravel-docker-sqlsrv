<?php

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
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

Route::get('/', function () {
    return 'Hello World';
});

Route::get('/mssql', function () {
    //get users from sqlsrv using eloquent
    $users = User::on('sqlsrv')->limit(11)->get();
    return $users;
});

Route::get('/users/insert/{cxn?}', function ($cnx = 'mysql') {
    $name = fake()->name();
    $email = fake()->unique()->safeEmail();
    $email = preg_split('/@/', $email)[0];
    $startDate = date('Y-m-d H:i:s');
    foreach (range(1, 100000) as $index) {
        $user = new User();
        $user->name = $name;
        $user->email = $email . $index . '@gmail.com';
        $user->password = 'test123';
        $user->setConnection($cnx);
        $user->save();
        $index++;
    }
    $endDate = date('Y-m-d H:i:s');
    $time = strtotime($endDate) - strtotime($startDate);
    $message = 'Time to insert 100000 users: ' . $time . ' seconds' . ' using ' . $cnx . ' connection';
    Log::info($message);
    return $message;
});

Route::get('/users/bulk-insert/{cxn?}', function ($cnx = 'mysql') {
    $name = fake()->name();
    $email = fake()->unique()->safeEmail();
    $email = preg_split('/@/', $email)[0];
    $startDate = date('Y-m-d H:i:s');
    $users = [];
    foreach (range(1, 10000) as $index) {
        $users[] = [
            'name' => $name,
            'email' => $email . $index . '@gmail.com',
            'password' => 'test123',
        ];
        $index++;
        if ($index % 500 == 0) {
            // both works
            // DB::connection($cnx)->table('users')->insert($users);
            User::on($cnx)->insert($users);
            $users = [];
        }
    }
    $endDate = date('Y-m-d H:i:s');
    $time = strtotime($endDate) - strtotime($startDate);
    $message = 'Time to bulk insert 1000000 users: ' . $time . ' seconds';
    return $message;
});


Route::get('/users/{cxn?}', function ($cnx = 'mysql') {
    $users = User::on($cnx)->limit(11)->orderBy('id', 'desc')->get();
    return $users;
});
