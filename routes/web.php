<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

use App\Models\User;

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

Route::get('/', function () {
    $user = User::get();

    return view('homepage', compact('user'));
})->name('root');

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/token', function (Request $request) {
    $token = $request->session()->token();

    $token = csrf_token();

    return response()->json([
        "token" => $token
    ]);
});

/*
|---------------------------------------------------------------------------
| Grouping route by controller
|---------------------------------------------------------------------------
| This is the place where you grouping the route by where you store the 
| controller to make the work more maintainable!
*/
Route::group(['namespace' => 'App\http\Controllers'], function() {
    /*
    |---------------------------------------------------------------------------
    | Auth regarding routes
    |---------------------------------------------------------------------------
    | This is the place where your authentication routes exists!
    */
    Auth::routes();

    Auth::routes();

    /*
    |---------------------------------------------------------------------------
    | Grouping route by prefix and middleware
    |---------------------------------------------------------------------------
    | This is the place where you grouping the route by prefix and auth
    | middleware to make the work more maintainable!
    */
    Route::group(['prefix' => 'user-panel', 'middleware' => 'auth'], function() {
        Route::get('/dashboard', 'HomeController@index')->name('home');
        Route::get('/dashboard', function() {
            return view('home');
        })->name('dashboard')->middleware('auth');
        /*
        |---------------------------------------------------------------------------
        | Addresses route
        |---------------------------------------------------------------------------
        | Here is where you can find the addresses route to access CRUD addresses.
        | You can add other addresses route here!
        */
        Route::resource('addresses', 'AddressController');
        Route::post('addresses/inisiate-default-address/{id}', 'AddressController@inisiateDefaultAddress')->name('inisiateDefaultAddress');
        Route::get('addresses/send-mail-before-delete/{id}', 'AddressController@sendMailBeforeDelete')->name('sendMailBeforeDelete');

        /*
        |---------------------------------------------------------------------------
        | User route
        |---------------------------------------------------------------------------
        | Here is where you can find the user route to access user list.
        */
        Route::get('users', 'UserController@index')->name('userList');
    });

    /*
    |---------------------------------------------------------------------------
    | Public route
    |---------------------------------------------------------------------------
    | Here is where you can find the public route. Anyone can access this route!
    */
    // Route::resource('addresses', 'AddressController');
    // Route::post('addresses/inisiate-default-address/{id}', 'AddressController@inisiateDefaultAddress')->name('inisiateDefaultAddress');
    // Route::get('addresses/send-mail-before-delete/{id}', 'AddressController@sendMailBeforeDelete')->name('sendMailBeforeDelete');
});
