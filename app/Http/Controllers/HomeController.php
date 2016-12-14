<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\Species;
use App\Breeds;
use App\Animals;

//use Illuminate\Http\Responce;
class HomeController extends Controller
{

    public function __construct()
    {
        //  $this->middleware('auth');
    }

    public function index()
    {
        $species = Species::all();
        // $animals = Animals::all()->toJson();
        // print_r($animals);
        //return view('welcome')->withAnimals($animals)->withSpecies($species);
        return view('welcome')->withSpecies($species);
    }

    public function getAnimals()
    {
        $animals = Animals::all()->toJson();
        // print_r($animals);
        // return view('welcome')->withAnimals($animals)->withSpecies($species);
        return (string)$animals;
    }

    public function getContact()
    {
        return view('contacts');
    }

    public function getAdmin()
    {
        $animals = Animals::paginate(15);
        return view('admin')->withAnimals($animals);
    }


    public function getPortfolio()
    {
        $species = Species::all();
        return view('portfolio')->withSpecies($species);
    }


    public function getAnimalsBySpecies($id)
    {
        if ($id == 'Всі') {
            $animals = Animals::All()->toJson();
        } else {
            $animals = Animals::where('species_id', $id)->get()->toJson();
        }
        return (string)$animals;
    }


    public function checkoutCircle($center, $radius, $sId, $bId)
    {
        $markers = array();
        $json = '';
        if (($bId !== "Всі")) {
            $animals = Animals::where('breed_id', $bId)->get();
        } else {
            if ($sId !== "Всі") {
                $animals = Animals::where('species_id', $sId)->get();
            } else {
                $animals = Animals::all();
            }
        }
        $centerPosition = explode(',', substr($center, 1, strlen($center) - 2));
        $latCircle = 1 + trim($centerPosition[0]) - 1;
        $lngCircle = 1 + trim($centerPosition[1]) - 1;
        foreach ($animals as $animal) {
            $markerPosition = explode(',', $animal['LatLn']);
            $latMarker = 1 + trim($markerPosition[0]) - 1;
            $lngMarker = 1 + trim($markerPosition[1]) - 1;
            if (sqrt(pow(($latCircle - $latMarker) * 100000, 2) + pow(($lngCircle - $lngMarker) * 100000, 2)) <= $radius) {
                $markers[] = $animal;
                $json = json_encode($markers);
            }
        };
        return $json;
    }


    public function checkoutPolygon($vertexes, $sId, $bId)
    {
        $markers = array();
        $json = '';
        if (($bId !== "Всі")) {
            $animals = Animals::where('breed_id', $bId)->get();
        } else {
            if ($sId !== "Всі") {
                $animals = Animals::where('species_id', $sId)->get();
            } else {
                $animals = Animals::all();
            }
        }
        $polygon = json_decode($vertexes);

        foreach ($animals as $animal) {
            $point = [];
            $LatLn = explode(',', $animal['LatLn']);
            $latMarker = 1 + trim($LatLn[0]) - 1;
            $lngMarker = 1 + trim($LatLn[1]) - 1;
            $point[0] = $latMarker;
            $point[1] = $lngMarker;
            if ($this->pointInPolygon($point, $polygon)) {
                $markers[] = $animal;
                $json = json_encode($markers);
            };
        }
        return $json;
    }

    function pointInPolygon($point, $polygon)
    {
        $return = false;
        foreach ($polygon as $k => $p) {
            if (!$k) $k_prev = count($polygon) - 1;
            else $k_prev = $k - 1;

            if (($p[1] < $point[1] && $polygon[$k_prev][1] >= $point[1] || $polygon[$k_prev][1] < $point[1] && $p[1] >= $point[1]) && ($p[0] <= $point[0] || $polygon[$k_prev][0] <= $point[0])) {
                if ($p[0] + ($point[1] - $p[1]) / ($polygon[$k_prev][1] - $p[1]) * ($polygon[$k_prev][0] - $p[0]) < $point[0]) {
                    $return = !$return;
                }
            }
        }
        return $return;
    }

    public function getAnimalsByBreed($sId, $bId)
    {
        if ($bId == 'Всі') {
            $animals = Animals::where('species_id', $sId)->get()->toJson();
        } else {
            $animals = Animals::where('breed_id', $bId)->get()->toJson();
        }

        return (string)$animals;
    }


    public function getBreed($id)
    {
        $breeds = Breeds::where('species_id', $id)->get();
        echo "<option  selected >" . "Всі </option>";
        foreach ($breeds as $breed) {
            echo "<option value=" . '"' . $breed->id . '">' . $breed->name . "</option>";
        };

    }


    public function getBreedPort($id)
    {
        $breeds = Breeds::where('species_id', $id)->get();
        foreach ($breeds as $breed) {
            echo "<option value=" . '"' . $breed->id . '">' . $breed->name . "</option>";
        };

    }


    public function search(Request $request)
    {
        $s = $request->input('species');
        $b = $request->input('breed');
        $br = '';
        if ($b and ($b !== "Всі")) {
            $animals = Animals::where('breed_id', $b)->get();
            $br = Breeds::find($b);
        } else {
            if ($s !== "Всі") {
                $animals = Animals::where('species_id', $s)->get();
            } else {
                $animals = Animals::all();
            }
        }
        $species = Species::all();
        return view('welcome')->withAnimals($animals)->withSpecies($species)->withS($s)->withBr($br)->withB($b);

    }
}



