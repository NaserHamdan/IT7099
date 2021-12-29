<?php

namespace App\Http\Controllers;

use App\Models\Lab;
use App\Models\Schedule;
use Illuminate\Http\Request;

class LabsController extends Controller
{
    //
    public function Labs()
    {
        $labs = Lab::with('exams_labs')->get();
        $count = 0;
        foreach($labs as $lab){
            if($lab->reviewed == 0){
                $count++;
            }
        }
        return view('labs', ['labs' => $labs,'count'=>$count]);
    }

    public function LoadLabs(Request $request)
    {
        //get all IT college courses rooms
        $term = '202101';
        $labs = Schedule::select('sec_building', 'sec_room','sec_course')->distinct('sec_room')->where('SEC_TERM_CODE', $term)->where('SEC_COLLEGE', 'IT')->get();
        foreach ($labs as $lab) {
            if ($lab['sec_building'] != null && $lab['sec_room'] != null && !str_contains($lab['sec_course'], 'WM')) {
                $llab = Lab::where('room', $lab['sec_room'])->firstOrCreate(
                    ['building' => $lab['sec_building']],
                    ['room' => $lab['sec_room']],
                );
            } else {
            }
        }
        //get all rooms from buildings 36 and 36A
        $labs = Schedule::select('sec_building', 'sec_room','sec_course')->distinct('sec_room')->where('SEC_BUILDING', 'BLDG36')->orWhere('SEC_BUILDING', 'BLD36A')->get();
        foreach ($labs as $lab) {
            if ($lab['sec_building'] != null && $lab['sec_room'] != null) {
                $llab = Lab::where('room', $lab['sec_room'])->firstOrCreate(
                    [
                        'room' => $lab['sec_room']
                    ],
                    [
                        'building' => $lab['sec_building']
                    ],
                );
            } else {
            }
        }
        return redirect('/labs');
    }

    public function getAllLabs(Request $request){
        $labs = Lab::all();
        return response(['labs' => $labs]);
    }

    public function updateLabs(Request $request){
        $data = $request->all();
        for($i=1;$i<=$data['count'];$i++){
            Lab::where(['lab_id'=>$data['lab_id'.$i]])->update([
                'room' => $data['room'.$i],
                'building' => $data['building'.$i],
                'max_capacity' => $data['max_capacity'.$i],
                'available_capacity' => $data['available_capacity'.$i],
                'reviewed' => 1,
            ]);
        }
        return redirect('/labs');
    }
}
