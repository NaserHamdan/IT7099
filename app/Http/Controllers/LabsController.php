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
        return view('labs');
    }

    public function LoadLabs(Request $request)
    {
        $term = '202101';
        $labs = Schedule::select('sec_building','sec_room')->distinct('sec_room')->where('SEC_TERM_CODE', $term)->where('SEC_COLLEGE', 'IT')->get();
        foreach ($labs as $lab) {
            if ($lab['sec_building'] != null && $lab['sec_room'] != null) {
                $llab = Lab::where('room', $lab['sec_room'])->firstOrCreate(
                    ['building' => $lab['sec_building']],
                    ['room' => $lab['sec_room']],
                );

            } else {

            }
        }
        $labs = Schedule::select('sec_building','sec_room')->distinct('sec_room')->where('SEC_BUILDING', 'BLDG36')->orWhere('SEC_BUILDING','BLD36A')->get();
        foreach ($labs as $lab) {
            if ($lab['sec_building'] != null && $lab['sec_room'] != null) {
                $llab = Lab::where('room', $lab['sec_room'])->firstOrCreate(
                    ['building' => $lab['sec_building']],
                    ['room' => $lab['sec_room']],
                );

            } else {

            }
        }
    }

}
