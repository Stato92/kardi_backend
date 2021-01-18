<?php

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


use App\UploadedFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


//Route::get('login/gogle', 'AuthController@redirectToProvider');
//Route::get('login/google/callback', 'AuthController@handleProviderCallback');
Route::get('/uploads/{id}/show', function (Request $request) {
    $upload = UploadedFile::findOrFail($request->id);
    return Storage::download("uploads/".$upload->file_name, $upload->original_name, ["Content-Disposition" => "inline; filename=".$upload->original_name]);
})->middleware('signed')->name('showUpload');
//Route::any('/{any}', function () {
//    return view('app');
//})->where('any', '^(?!api).*$');
Route::any('/', function () {
    return view('app');
});
//Route::get('/', function () {
//    return view('welcome');
//});
//Route::any('{query}',
//    function() { return redirect('/'); })
//    ->where('query', '.*');
