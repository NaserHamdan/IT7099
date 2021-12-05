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
        return view('invigilators');
    }

    public function LoadTutors(Request $request)
    {
        $term = '202101';
        $tutors = Schedule::select('sec_tutor')->distinct()->where('SEC_TERM_CODE', $term)->where('SEC_COLLEGE', 'IT')->get();
        foreach ($tutors as $tutor) {
            if (!str_contains($tutor['sec_tutor'],'NA')) {
                $ttutor = Tutor::where('tutor_name', $tutor['sec_tutor'])->firstOrCreate(
                    ['tutor_name' => $tutor['sec_tutor']],
                    ['position' => 'undefined']
                );

            } else {

            }
        }
    }
}
