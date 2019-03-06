<?php

namespace App\Http\Controllers;
namespace App\Http\Controllers\API;

use App\Country;
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use Validator;

class CountryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $countries = Country::all();

        return $this->sendResponse($products->toArray(), 'Countries retrieved successfully.');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $request->validate([
            'name' => 'required',
            'continent' => 'required'
        ]);

        $country = Country::create($request->all());

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
        $input = $request->all();


        $validator = Validator::make($input, [
            'name' => 'required',
            'continent' => 'required'
        ]);


        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }


        $country = Country::create($input);


        return $this->sendResponse($country->toArray(), 'Countries created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Country  $country
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $country = Country::find($id);


        if (is_null($country)) {
            return $this->sendError('Country not found.');
        }


        return $this->sendResponse($country->toArray(), 'Country retrieved successfully.');
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

        $input = $request->all();


        $validator = Validator::make($input, [
            'name'       => 'nullable',
            'continent' => 'nullable'
        ]);


        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }


        $country->name = $input['name'];
        $country->continent = $input['continent'];
        $country->save();


        return $this->sendResponse($country->toArray(), 'Country updated successfully.');
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

        return $this->sendResponse($product->toArray(), 'Country deleted successfully.');
    }
}
