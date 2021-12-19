<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use App\Models\Tutor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class InvigilatorsController extends Controller
{
    public function invigilators()
    {
        $tutors = Tutor::with('invigilations')->get();
        $count = 0;
        foreach($tutors as $tutor){
            if($tutor->reviewed == 0){
                $count++;
            }
        }
        return view('invigilators', ['tutors' => $tutors,'count'=>$count]);
    }

    public function LoadTutors(Request $request)
    {
        $term = '202101';
        $tutors = Schedule::select('sec_tutor', 'sec_course')->distinct()->where('SEC_TERM_CODE', $term)->where('SEC_COLLEGE', 'IT')->get();
        foreach ($tutors as $tutor) {
            if (!str_contains($tutor['sec_tutor'], 'NA') && !str_contains($tutor['sec_course'], 'WM')) {
                $ttutor = Tutor::where('tutor_name', $tutor['sec_tutor'])->firstOrCreate(
                    [
                        'tutor_name' => $tutor['sec_tutor']
                    ],
                    [
                        'position' => 'undefined'
                    ]
                );
            } else {
            }
        }
        return redirect('/Invigilators');
    }

    public function updateTutors(Request $request){
        $data = $request->all();
        for($i=1;$i<=$data['count'];$i++){
            Tutor::where(['tutor_id'=>$data['tutor_id'.$i]])->update([
                'tutor_name' => $data['tutor_name'.$i],
                'position' => $data['position'.$i],
                'reviewed' => 1,
            ]);
        }
        return redirect('/Invigilators');
    }
}
