<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ActivityFr;

class ActivityFrController extends Controller
{
public function search(Request $request)
{
    $q = $request->code;

    return ActivityFr::where('code', 'like', $q.'%')
        ->orWhere('activity', 'like', '%'.$q.'%')
        ->limit(20)
        ->get(['id', 'code', 'activity']);
}
}