<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    //


    function updateSettings(Request $request){
        $data = $request->all();
        $settings = Setting::updateOrCreate([
            'setting_id'=>1
        ],
        [
            'start_date'=> $data['start_date'],
            'end_date'=> $data['end_date'],
            'timetable_type'=> $data['timetable_type'],
        ]);
        return response(['successful'=>true,'start_date'=>$data['start_date'],'end_date'=>$data['end_date'],'timetable_type'=>$data['timetable_type']]);
    }
}
