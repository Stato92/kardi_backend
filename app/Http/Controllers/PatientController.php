<?php

namespace App\Http\Controllers;

use App\Disease;
use App\Http\Requests\StorePatient;
use App\Http\Resources\PatientCollection;
use App\Patient;
use App\Providers\PatientCreated;
use App\Providers\PatientDeleted;
use App\Providers\PatientEdited;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class PatientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        if ($request->search) {
            $patients = new PatientCollection(Patient::search($request->search)->get());
        } else {
            $patients = new PatientCollection(Patient::all());
        }
        $offset = !empty($request->offset) ? $request->offset : 1;
        $params = [];
        if (!empty($request->showDead)) {
            $param = !filter_var($request->showDead, FILTER_VALIDATE_BOOLEAN);
            $patients = $patients->filter(function ($patient) use ($param) {
                return $patient->is_alive == $param;
            });
        }
        if (!empty($request->eventType)) {
            $param = $request->eventType;
            $patients = $patients->filter(function ($patient) use ($param) {
                return $patient->events->contains('event_type_id', $param);
            });
        }
        if (!empty($request->clinic)) {
            $param = $request->clinic;
            $patients = $patients->filter(function ($patient) use ($param) {
                return $patient->user->clinic === $param;
            });
        }
        if (!empty($request->disease)) {
            $param = $request->disease;
            $patients = $patients->filter(function ($patient) use ($param) {
                return $patient->diseases->contains('name', $param);
            });
        }

        if (!empty($request->sort)) {
            if (!empty($request->type) && $request->type === 'desc') {
                $patients = $patients->sortByDesc($request->sort);
            } else
                $patients = $patients->sortBy($request->sort);
        }

        return response($patients->values()->forPage($offset, 20));
    }


    /**
     * @param StorePatient $request
     * @return mixed
     */
    public function store(StorePatient $request)
    {
        $patient = Patient::create([
            'name' => $request->name,
            'surname' => $request->surname,
            'email' => $request->email,
            'pesel' => $request->pesel,
            'user_id' => $request->doctor,
            'phone_numbers' => !empty($request->phone_numbers)?json_encode($request->phone_numbers):null,
            'diagnosis' => $request->diagnosis,
        ]);
        if (!empty($request->diseases)) {
            foreach ($request->diseases as $val) {
                $patient->diseases()->save(Disease::firstOrCreate(['name' => $val]));
                }
            }
        broadcast(new PatientCreated($patient))->toOthers();
        return $patient;
    }

    /**
     * Display the specified resource.
     *
     * @param $id
     * @return Response
     */
    public function show($id)
    {
        $patient = Patient::findOrFail($id)->loadMissing([
            'user:id,name,surname,clinic',
            'diseases:name']);
        $statuses = $patient->statuses->loadMissing('user:id,name,surname');
        $uploadedFiles = \App\UploadedFile::where('patient_id',$patient->id)
            ->orderByDesc('created_at')
            ->with('user:id,name,surname')->get();
        return response()->json(['patient' => $patient,'statuses' => $statuses,'uploadedFiles' => $uploadedFiles]);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param Patient $patient
     * @return Response
     */
    public function update(StorePatient $request)
    {
        $patient = Patient::findOrFail($request->id);
        $patient->name = $request->name;
        $patient->surname = $request->surname;
        $patient->email = $request->email;
        $patient->pesel = $request->pesel;
        $patient->user_id = $request->doctor;
        $patient->phone_numbers = !empty($request->phone_numbers)?json_encode($request->phone_numbers):null;
        $patient->diagnosis = $request->diagnosis;
        if (!empty($request->diseases)) {
            $patient->diseases()->delete();
            foreach ($request->diseases as $val) {
                $patient->diseases()->save(Disease::firstOrCreate(['name' => $val]));
            }
        }
        $patient->save();
        $patient->loadMissing('user:id,name,surname')->loadMissing('diseases:name');
        broadcast(new PatientEdited($patient));
        return new Response($patient,200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Patient $patient
     * @return Response
     */
    public function destroy(Request $request)
    {
        $patient = Patient::findOrFail($request->id);
        broadcast(new PatientDeleted($patient))->toOthers();
            $patient->delete();
        return new Response(null,204);
    }
}
