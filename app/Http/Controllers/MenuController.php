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


class MenuController extends Controller
{
    public function menu($id, Request $request) {
        if (!DB::table('menus')->where('id', $id)->first())
            abort(404);
        $menu = Menu::find($id);
        $place = Place::where('id', intval($request->t))->first();
        if ($place == null or $place->menuId != $id)
            abort(404);
        return view('usermenu', ['menu' => $menu,
                                 'place' => $place]);
    }

    public function edit($id) {
        if (!DB::table('menus')->where('id', $id)->first())
            abort(404);
        $menu = Menu::find($id);
        if (Auth::id() != $menu->userId)
            abort(403);
        return view('editmenu', ['menu' => $menu]);
    }

    public function cart($id, Request $request) {
        $menu = Menu::find($id);
        return view('cart', ['menu' => $menu,
                             'place' => Place::find($request->t)]);
    }

    public function start() {
        if (!Auth::check())
            return redirect('/login');
        return view('start');
    }

    public function wait($id, Request $request) {
        return view('wait', ['menu'  => Menu::find($id),
                             'place' => Place::find(intval($request->t)),
                             'order' => Order::find(intval($request->o))]);
    }

    public function getMenus() {
        if (!Auth::check())
            abort(403);
        $menus = Menu::where('userId', Auth::id())->get();
        return json_encode($menus);
    }

    public function addMenu(Request $request) {
        if (!Auth::check())
            abort(403);
        $this->validate($request, [
            'name' => 'required',
            'img' => 'required',
            'hookah' => 'required',
            'address' => 'required'
        ]);
        $menu = new Menu;
        $menu->name = $request->name;
        if ($request->has('address'))
            $menu->address = $request->address;
        $menu->hookah = boolval($request->hookah);
        $menu->userId = Auth::id();
        
        $img = $request->file('img');
        $name = pathinfo($img->getClientOriginalName(), PATHINFO_FILENAME);
        $extension = $img->getClientOriginalExtension();
        $img_name = $name . '-at-' . time() . '.' . $extension;
        $menu->img = $img_name;
        
        $menu->save();
        Storage::disk('public')->put('menus/' . strval($menu->id) . '/' . $img_name, file_get_contents($img));
        return json_encode($menu);
    }

    public function updateMenu(Request $request) {
        $this->validate($request, [
            'id' => 'required',
            'name' => 'required',
            'address' => 'required'
        ]);
        $menu = Menu::find($request->id);
        if (!Auth::check() or (Auth::id() != $menu->userId))
            abort(403);
        
        $menu->name = $request->name;
        $menu->address = $request->address;
        if ($request->has('img')) {
            $img = $request->file('img');
            $name = pathinfo($img->getClientOriginalName(), PATHINFO_FILENAME);
            $extension = $img->getClientOriginalExtension();
            $img_name = $name . '-at-' . time() . '.' . $extension;

            File::delete(public_path('/storage/menus/' . $menu->id . '/' . $menu->img));
            $menu->img = $img_name;
            Storage::disk('public')->put('menus/' . strval($menu->id) . '/' . $img_name, file_get_contents($img));
        }

        $menu->save();
        return json_encode($menu);
    }

    public function deleteMenu(Request $request) {
        $menu = Menu::find(intval($request->menuId));
        if (!Auth::check() or $menu->userId != Auth::id())
            abort(403);
        File::deleteDirectory(public_path('/storage/menus/' . strval($menu->id) . '/'));
        Menu::destroy($menu->id);
    }

    public function test() {
        //
    }
}
