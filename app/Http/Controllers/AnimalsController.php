<?php

namespace App\Http\Controllers;

use App\Species;
use App\Breeds;
use App\Animals;
//use Faker\Provider\Image;
use Illuminate\Http\Request;
use Image;
use App\Http\Requests;

class AnimalsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $animals = new Animals;
        $animals->name = $request->name;
        $animals->species_id = $request->species;
        $animals->breed_id = $request->breed;
        $animals->content = $request->content;
        $animals->address = $request->address;
        $animals->LatLn = substr($request->LatLn, 1, -1);
        if ($request->hasFile("photo")) {
            $image = $request->file('photo');
            $filename = time() . '.' . $image->getClientOriginalExtension();
            $location = public_path('images/') . $filename;
            $location1 = public_path('images/s_') . $filename;
            Image::make($image)->resize(150, 150)->save($location);
            $animals->photo = $filename;
            Image::make($image)->resize(75, 75)->save($location1);
        } else {
            $animals->photo = 'default.jpg';
        }

        $animals->save();
        return redirect()->action('HomeController@index');
    }


    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $species = Species::all();
        $animal = Animals::find($id);
        return view('editAnimal')->withAnimal($animal)->withSpecies($species);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $id = $request->id;
        $animals = Animals::find($id);

        $animals->name = $request->name;
        $animals->species_id = $request->species;
        $animals->breed_id = $request->breed;
        $animals->content = $request->content;
        $animals->address = $request->address;
        $animals->LatLn = substr($request->LatLn, 1, -1);

        /*     if (!$animals->LatLn){
             $animals->LatLn = $request->oldLatLn;
                 echo "true";
         }
             else{
             $animals->LatLn = substr($request->LatLn, 1, -1);
                 echo "!true";
         }*/
        if ($request->hasFile("photo")) {
            $image = $request->file('photo');
            $filename = time() . '.' . $image->getClientOriginalExtension();
            $location = public_path('images/') . $filename;
            $location1 = public_path('images/s_') . $filename;
            Image::make($image)->resize(150, 150)->save($location);
            $animals->photo = $filename;
            Image::make($image)->resize(75, 75)->save($location1);
        } else {
            $animals->photo = $request->oldPhoto;
        }

        $animals->save();
        return redirect('/admin');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    { Animals::destroy($id);

        return redirect('/admin');
    }
}
