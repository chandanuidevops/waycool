<?php

namespace App\Http\Controllers;

use App\Models\FileUpload;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Symfony\Component\Console\Input\Input;

class FileUploadController extends Controller
{
    public function index()
    {
    
       $gramworks= FileUpload::all();
     
        return view('gramworks',compact('gramworks'));
    }
    public function store(Request $request)
    {
       
        $current_time = Carbon::now()->timestamp;
        $filename = $current_time.'_'.$request->file('document')->getClientOriginalName();
        $filename = $request->file('document')->storeAs('uploads/device_firmware',$filename,'public');
        $contents= file_get_contents($request->file('document'));
        $gramwork = [
                'device_model'=>$request->device_model,
                'version'=>$request->version,
                'file_path'=> $filename,
                'file_data'=> $contents,
           ];
           $gramwork=FileUpload::create($gramwork);
        return redirect()->route('gramwork.index')->with('message', 'Successful	upload	message');;
    }
}
