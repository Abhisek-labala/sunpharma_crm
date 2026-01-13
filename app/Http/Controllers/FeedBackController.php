<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\FeedbackSubmitted;
use Illuminate\Http\Request;

class FeedBackController extends Controller
{
    public function followupForm(Request $request)
{
    $id = $request->get('patient_id'); // get query param
    $day3_data_exists = false;
    $day7_data_exists = false;
    $day15_data_exists = false;
    $day30_data_exists = false;
    $day45_data_exists = false;
    $day60_data_exists = false;
    $day90_data_exists = false;
    $day120_data_exists = false;
    $day150_data_exists = false;
    $day180_data_exists = false;

    $submitData = FeedbackSubmitted::where('patient_id', $id)
    ->select('day')
    ->distinct()
    ->orderByRaw('CAST(day AS INTEGER) ASC')
    ->get();

    return view('digitaleducator.followupForm', ['patientId' => $id, 'day3_data_exists' => $day3_data_exists,
    'day7_data_exists' => $day7_data_exists,
    'day15_data_exists' => $day15_data_exists,
    'day30_data_exists' => $day30_data_exists,
    'day45_data_exists' => $day45_data_exists,
    'day60_data_exists' => $day60_data_exists,
    'day90_data_exists' => $day90_data_exists,
    'day120_data_exists' => $day120_data_exists,
    'day150_data_exists' => $day150_data_exists,
    'day180_data_exists' => $day180_data_exists,

]);
}
   public function followupFormpm(Request $request)
{
    $id = $request->get('patient_id'); // get query param
    $day3_data_exists = false;
    $day7_data_exists = false;
    $day15_data_exists = false;
    $day30_data_exists = false;
    $day45_data_exists = false;
    $day60_data_exists = false;
    $day90_data_exists = false;
    $day120_data_exists = false;
    $day150_data_exists = false;
    $day180_data_exists = false;

    $submitData = FeedbackSubmitted::where('patient_id', $id)
    ->select('day')
    ->distinct()
    ->orderByRaw('CAST(day AS INTEGER) ASC')
    ->get();

    return view('pm.followupForm', ['patientId' => $id, 'day3_data_exists' => $day3_data_exists,
    'day7_data_exists' => $day7_data_exists,
    'day15_data_exists' => $day15_data_exists,
    'day30_data_exists' => $day30_data_exists,
    'day45_data_exists' => $day45_data_exists,
    'day60_data_exists' => $day60_data_exists,
    'day90_data_exists' => $day90_data_exists,
    'day120_data_exists' => $day120_data_exists,
    'day150_data_exists' => $day150_data_exists,
    'day180_data_exists' => $day180_data_exists,

]);
}
   public function followupFormmis(Request $request)
{
    $id = $request->get('patient_id'); // get query param
    $day3_data_exists = false;
    $day7_data_exists = false;
    $day15_data_exists = false;
    $day30_data_exists = false;
    $day45_data_exists = false;
    $day60_data_exists = false;
    $day90_data_exists = false;
    $day120_data_exists = false;
    $day150_data_exists = false;
    $day180_data_exists = false;

    $submitData = FeedbackSubmitted::where('patient_id', $id)
    ->select('day')
    ->distinct()
    ->orderByRaw('CAST(day AS INTEGER) ASC')
    ->get();

    return view('mis.followupForm', ['patientId' => $id, 'day3_data_exists' => $day3_data_exists,
    'day7_data_exists' => $day7_data_exists,
    'day15_data_exists' => $day15_data_exists,
    'day30_data_exists' => $day30_data_exists,
    'day45_data_exists' => $day45_data_exists,
    'day60_data_exists' => $day60_data_exists,
    'day90_data_exists' => $day90_data_exists,
    'day120_data_exists' => $day120_data_exists,
    'day150_data_exists' => $day150_data_exists,
    'day180_data_exists' => $day180_data_exists,

]);
}
   public function followupFormeducator(Request $request)
{
    $id = $request->get('patient_id'); // get query param
    $day3_data_exists = false;
    $day7_data_exists = false;
    $day15_data_exists = false;
    $day30_data_exists = false;
    $day45_data_exists = false;
    $day60_data_exists = false;
    $day90_data_exists = false;
    $day120_data_exists = false;
    $day150_data_exists = false;
    $day180_data_exists = false;

    $submitData = FeedbackSubmitted::where('patient_id', $id)
    ->select('day')
    ->distinct()
    ->orderByRaw('CAST(day AS INTEGER) ASC')
    ->get();

    return view('educator.followupForm', ['patientId' => $id, 'day3_data_exists' => $day3_data_exists,
    'day7_data_exists' => $day7_data_exists,
    'day15_data_exists' => $day15_data_exists,
    'day30_data_exists' => $day30_data_exists,
    'day45_data_exists' => $day45_data_exists,
    'day60_data_exists' => $day60_data_exists,
    'day90_data_exists' => $day90_data_exists,
    'day120_data_exists' => $day120_data_exists,
    'day150_data_exists' => $day150_data_exists,
    'day180_data_exists' => $day180_data_exists,

]);
}
   public function followupFormyoga(Request $request)
{
    $id = $request->get('patient_id'); // get query param
    $day7_data_exists = false;
    $day45_data_exists = false;
    $day90_data_exists = false;

    $submitData = FeedbackSubmitted::where('patient_id', $id)
    ->select('day')
    ->distinct()
    ->orderByRaw('CAST(day AS INTEGER) ASC')
    ->get();

    return view('yogaeducator.followupForm', ['patientId' => $id,
    'day7_data_exists' => $day7_data_exists,
    'day45_data_exists' => $day45_data_exists,
    'day90_data_exists' => $day90_data_exists
]);
}
}
