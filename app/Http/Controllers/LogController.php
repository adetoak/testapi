<?php

namespace App\Http\Controllers; 

use App\Logs;
use Illuminate\Http\Request;

class LogController extends Controller
{
	public function index()
    {
        $logs = Logs::paginate(10);

        return response()->json($logs);
    }
}