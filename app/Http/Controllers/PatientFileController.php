<?php

namespace App\Http\Controllers;

use App\UploadedFile;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;

class PatientFileController extends Controller
{
    public function store(Request $request){
        $validatedData = $this->validate($request, [
            'file' => 'bail|required|mimetypes:image/jpeg,image/gif,image/bmp,image/png,video/mp4,video/x-ms-wmv,video/x-msvideo,video/3gpp,video/MP2T,video/avi,video/mpeg,video/quicktime,application/pdf,application/zip,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document,application/vnd.ms-excel,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet,application/vnd.ms-excel.sheet.macroEnabled.12|max:50000',
        ]);
        $file = $request->file;
        $user = Auth::user();
        $patientId = $request->patient_id;
        $originalName = $file->getClientOriginalName();
        $filename = $request->file->hashName();
        $upload_success = $request->file('file')->store('uploads');
        $uploadedFile = UploadedFile::create([
                'original_name' => $originalName,
                'file_name' => $filename,
                'user_id' => $user->id,
                'patient_id' => $patientId
            ]);
        if ( $upload_success && $uploadedFile ) {
            return response()->json([
                'status' => 'success',
                'uploaded_file' => $uploadedFile
            ],201,['Location' => url('/uploads/'.$uploadedFile->id)]);
        } else {
            return response()->json('error', 400);
        }
    }
    public function destroy($id) {
        $upload = UploadedFile::findOrFail($id);
        $fileName = $upload->file_name;
        if (Storage::disk()->exists("uploads/".$fileName)) {
            Storage::delete("uploads/".$fileName);
        }
        $upload->delete();
        return response('success',200);
    }
    public function generateTemporaryLink($id) {
        $upload = UploadedFile::findOrFail($id);
        return response()->json(URL::temporarySignedRoute('showUpload',now()->addSeconds(60),['id' => $upload->id]));
    }
    public function download($id) {
        $upload = UploadedFile::findOrFail($id);
        return Storage::download("uploads/".$upload->file_name, $upload->original_name);
    }
    public function preview($id) {
        $upload = UploadedFile::findOrFail($id);
        $file = Storage::download("uploads/".$upload->file_name, $upload->original_name);
        $extension = \File::mimeType(storage_path().'\\app\\uploads\\'.$upload->file_name);
        return $extension;
    }
}
