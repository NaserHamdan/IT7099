<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    //


    function updateSettings(Request $request){
        $date = $request->all();
        $settings = Setting::updateOrCreate([
            'setting_id'=>1
        ],
        [
            'start_date'=> $date['start_date'],
            'end_date'=> $date['end_date'],
        ]);
        return response(['successful'=>true,'start_date'=>$date['start_date'],'end_date'=>$date['end_date']]);
    }
}
