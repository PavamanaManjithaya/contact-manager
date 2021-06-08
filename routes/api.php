<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Contact;

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

Route::middleware(['api'])->group(function () {
    Route::get('contacts', function () {
        return Contact::latest()->orderBy('created_at','desc')->get();
    });
    Route::get('contact/{id}', function ($id) {
        return Contact::findOrFail($id);
    });
    Route::post('contact/store', function (Request $request) {
        return Contact::create(['name'=>$request->input(['name']),'email'=>$request->input(['email']),'phone'=>$request->input(['phone'])]);
    });
    Route::patch('contact/{id}', function (Request $request, $id) {
        return Contact::findOrFail($id)->update(['name'=>$request->input(['name']),'email'=>$request->input(['email']),'phone'=>$request->input(['phone'])]);
    });
    Route::delete('contact/{id}', function ($id) {
       
     return Contact::destroy($id);
    });
   });


Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
