<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Section;
use App\Models\Order;
use App\Models\Place;
use App\Models\Menu;

class PlaceController extends Controller
{
    public function places($id) {
        if (!Auth::check())
            abort(403);
        $menu = Menu::find($id);
        return view('places', ['menu' => $menu]);
    }
    
    public function seeqr(Request $request) {
        $place = Place::find($request->p);
        $menu = Menu::find($request->m);
        if (!Auth::check() or ($menu->userId != Auth::id()))
            abort(403);
        return view('seeqr', ['place' => $place,
                              'menu'  => $menu]);
    }

    public function getPlaces($id) {
        $menu = Menu::find($id);
        if (!Auth::check() or ($menu->userId != Auth::id()))
            abort(403);
        $places = Place::where('menuId', $id)->get();
        return json_encode($places);
    }

    public function addPlace(Request $request) {
        if (!Auth::check())
            abort(403);
        $place = new Place;
        $place->name = $request->name;
        $place->menuId = $request->menuId;
        $place->save();
        return json_encode($place);
    }

    public function deletePlace(Request $request) {
        if (!Auth::check())
            abort(403);
        Place::destroy(intval($request->placeId));
        return json_encode($request->placeId);
    }
}
