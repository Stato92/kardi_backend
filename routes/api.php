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
Route::middleware('auth:api')->group(function () {

    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    /** Znajdz wszystkich lekarzy z danej kliniki  */
    Route::get('/users', function (Request $request) {
        $users=App\User::select('id','name','surname','email');
        if (!empty($request->clinic)) {
            $users = $users->where('clinic',$request->clinic);
        }
        return $users->get();
    });

    /** Znajdz pacjentów do tagów  */
    Route::get('/patients/search', function (Request $request) {
        return $results['patients'] = App\Patient::search($request['query'])->select('id','name','surname')->get();
    });
    /** Znajdź moich pacjentów */
    Route::get('/user/patients', function () {
        return Auth()->user()->patients->sortByDesc('is_alive')->values()->all();
    });

    Route::get('/search/{id}', function ($query) {
        $results['patients'] = App\Patient::search($query)->get();
        $results['users'] = App\User::search($query)->get();
        $results['events'] = App\Event::search($query)->get();
        $paginator = new Illuminate\Support\Collection;
        $resultsCount = count($results['patients']) + count($results['users']) + count($results['events']);
        if ($resultsCount === 0) {
            return 'no results';
        }
        return json_encode($results);
//        return $paginator->make($results,$resultsCount,5,1);
    });


    /** Znajdź nadchodzące wydarzenia */
    Route::get('/events/incoming', function () {
        return App\Event::
        select('id','name','date','patient_id','event_type_id')
            ->whereBetween('date',[now(),now()->add(1,'week')])
            ->orderBy('date','desc')
            ->with('patient:id,name,surname,pesel','eventType')
            ->get();
    });
    /** Znajdź szczegóły pacjenta */
    Route::get('/patients/{id}', 'PatientController@show');
    /** Znajdź wydarzenia pacjenta */
    Route::get('/patients/{id}/events', function ($id) {
        return App\Event::select('id','name','date','event_type_id','patient_id')->where('patient_id',$id)->with('eventType','users:name,surname')->get();
    });
    /** Znajdź statusy pacjenta */
    Route::get('/patients/{id}/statuses', function ($id) {
        return App\Patient::findOrFail($id)->statuses->loadMissing('user:id,name,surname');
    });
    /** Znajdź komentarze do pacjenta */
    Route::get('/patients/{id}/comments', function ($id) {
        return App\PatientComment::where('patient_id',$id)->orderBy('created_at','DESC')->with('user:id,name,surname')->get();
    });
    /** Usuń komentarz pacjenta */
    Route::delete('/patients/{patientId}/comments/{id}', 'PatientCommentController@destroy');
    /** Edytuj komentarz pacjenta */
    Route::put('/patients/{patientId}/comments/{id}', 'PatientCommentController@update');

    /** Znajdź choroby pacjenta */
    Route::get('/patients/{id}/diseases', function ($id) {
        return App\Patient::findOrFail($id)->diseases;
    });
    /** Znajdź wszystkie choroby */
    Route::get('/diseases', function () {
        return App\Disease::all();
    });


    /**     PLIKI       **/
    /** Znajdź pliki pacjenta */
    Route::get('/patients/{id}/uploads', function ($id) {
        return App\UploadedFile::where('patient_id','=',$id)->with('user:id,name,surname')->orderBy('created_at','DESC')->get();
    });
    /** Upload pliku pacjenta */
    Route::post('/uploads', 'PatientFileController@store');
    /** Usuwanie pliku pacjenta */
    Route::delete('/uploads/{id}', 'PatientFileController@destroy');
    /** Generowanie jednorazowego linku do podglądu */
    Route::get('/uploads/{id}/show', 'PatientFileController@generateTemporaryLink');
    /** Pobieranie pliku pacjenta */
    Route::get('/uploads/{id}/download', 'PatientFileController@download');
    /** Podgląd pliku pacjenta */
    Route::get('/uploads/{id}/preview', 'PatientFileController@preview');
    /**     KONIEC PLIKÓW    */


    /** Pokaż rodzaje wydarzeń */
    Route::get('events/types', function () {
        return App\EventType::all();
    });
    /** Pokaż pacjentów według rodzaju wydarzenia */
    Route::get('/events/{type}/patients', function ($type) {
        return App\Event::where('event_type_id','=',$type)->get()->loadMissing('patient')->pluck('patient');
    });
    /** Pokaż pacjentów z danym statusem */
    Route::get('/statuses/{status}/patients', function ($status) {
        return App\Status::where('name','=',$status)->get()->loadMissing('patient')->pluck('patient');
    });
    /** Znajdź pacjentów z daną chorobą */
    Route::get('/diseases/{id}/patients', function ($id) {
        return App\Disease::findOrFail($id)->patients;
    });

    Route::post('/patients/{id}/comment', 'PatientCommentController@store');

    Route::post('/statuses', 'StatusController@store');
    Route::delete('/statuses/{id}', 'StatusController@destroy');

    /** Pokaż najpopularniejsze statusy */
    Route::get('/statuses/most_popular', function () {
        return App\Status::all()->unique('name')->pluck('name')->values();
    });

    Route::get('/patients', 'PatientController@index');
    Route::post('/patients', 'PatientController@store');
    Route::put('/patients/{id}', 'PatientController@update');
    Route::delete('/patients/{id}', 'PatientController@destroy');


    Route::post('/logout', 'AuthController@logout');
    Route::patch('/users', 'UserController@update');

    Route::delete('/messages/{id}', 'ChatMessageController@destroy');
    Route::get('/messages', 'ChatMessageController@index');
    Route::post('/messages', 'ChatMessageController@store');


});

/** Auth routes */
Route::post('/register', 'AuthController@register');
Route::post('/login', 'AuthController@login');
Route::post('/googleLogin', 'AuthController@googleLogin');
