<?php

namespace App\Http\Controllers;

use App\Country;
use App\Logs;
use Auth;
use Validator;
use Illuminate\Http\Request;

class CountryController extends Controller
{

    // public function __construct()
    // {
    //   $this->middleware('auth:api')->except(['index', 'show']);
    // }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $countries = Country::all();
        $this->log("Fetched Country List", "Fetched country List");
        return response()->json($countries);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request) 
    {         

        $validator = Validator::make($request->all(), [ 
            'name' => 'required',  
            'continent' => 'required',  
        ]);

        if ($validator->fails()) { 
            return response()->json(['error'=>$validator->errors()], 401);            
        }

        $country = Country::create($request->all());

        $this->log("Created Country", "Created country ".$request->Input('name'));

        return response()->json([
            'message' => 'Great! New Country created',
            'country' => $country
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'continent' => 'required'
        ]);

        $country = Country::create($request->all());

        $this->log("Created Country", "Created country ".$request->Input('name'));

        return response()->json([
            'message' => 'Great! New Country created',
            'country' => $country
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Country  $country
     * @return \Illuminate\Http\Response
     */
    public function show(Country $country)
    {
        return $country;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Country  $country
     * @return \Illuminate\Http\Response
     */
    public function edit(Country $country)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Country  $country
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Country $country)
    {
        $validator = Validator::make($request->all(), [ 
            'name' => 'nullable',  
            'continent' => 'nullable',  
        ]);

        if ($validator->fails()) { 
            return response()->json(['error'=>$validator->errors()], 401);            
        }

        $country->update($request->all());

        $this->log("Updated Country", "Updated country ".$request->Input('name'));

        return response()->json([
            'message' => 'Great! Country updated',
            'country' => $country
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Country  $country
     * @return \Illuminate\Http\Response
     */
    public function destroy(Country $country)
    {
        $country->delete();
        $this->log("Deleted Country", "Deleted country ".$country->name);
        return response()->json([
            'message' => 'Successfully deleted country!'
        ]);
    }

     public function log($action, $details) {
             

            $log = new Logs();
            $log->userid = auth()->guard('api')->user()?:9;
            $log->action = $action;
            $log->details = $details;
            $log->save();
            //$query = DB::table('logs')->insert(['userid' => $id, 'action' => $action, 'details' => $details]);                
              
      }
}
