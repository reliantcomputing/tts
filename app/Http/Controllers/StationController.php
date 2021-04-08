<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Station;

use Auth;

class StationController extends Controller
{
    public function __construct()
    {
        $this->middleware(["auth", "verified"]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $stations = Station::all();

        return view("stations.index", ["stations"=>$stations]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (Auth::user()->role->name != "ROLE_ADMIN") {
            return redirect()->back()->with("error", "Access denied");
        }
        return view("stations.create");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (Auth::user()->role->name != "ROLE_ADMIN") {
            return redirect()->back()->with("error", "Access denied");
        }
        $this->validate($request, [
            "name"=>"required",
            "stationNumber" => "required"
        ]);

        if (Station::where("stationNumber", $request->studentNumber)->first()) {
            return redirect()->back()->with("error", "Station number already exist!");
        }

        $station = new Station;
        $station->name = $request->name;
        $station->stationNumber = $request->stationNumber;

        $station->save();

        return redirect()->route("stations")->with("success", "Station created successsfully!");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (Auth::user()->role->name != "ROLE_ADMIN") {
            return redirect()->back()->with("error", "Access denied");
        }
        if (!Station::where("stationId", $id)->first()) {
            return redirect()->route("stations")->with("error", "Station not found!");
        }
        $station = Station::where("stationId", $id)->first();
        return view("stations.edit", ["station"=>$station]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if (Auth::user()->role->name != "ROLE_ADMIN") {
            return redirect()->back()->with("error", "Access denied");
        }
        if (!Station::where("stationId", $id)->first()) {
            return redirect()->route("stations")->with("error", "Station not found!");
        }
        $station = Station::where("stationId", $id)->first();
        $station->stationNumber = $request->stationNumber;
        $station->name = $request->name;
        $station->update();
        return redirect()->route("stations")->with("success", "Station updated successsfully!");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (Auth::user()->role->name != "ROLE_ADMIN") {
            return redirect()->back()->with("error", "Access denied");
        }
        if (!Station::where("stationId", $id)->first()) {
            return redirect()->route("stations")->with("error", "Station not found!");
        }
        $station = Station::where("stationId", $id)->first();
        $station->delete();
        return redirect()->route("stations")->with("success", "Station deleted successsfully!");
    }
}
