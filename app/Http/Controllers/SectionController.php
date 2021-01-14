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

class SectionController extends Controller
{
    public function addSection(Request $request) {
        if (!Auth::check())
            abort(403);
        $this->validate($request, [
            'name' => 'required',
            'menuId' => 'required',
            'img' => 'required'
        ]);
        $section = new Section;
        $section->name = $request->name;
        $section->menuId = $request->menuId;

        $img = $request->file('img');
        $name = pathinfo($img->getClientOriginalName(), PATHINFO_FILENAME);
        $extension = $img->getClientOriginalExtension();
        $img_name = $name . '-at-' . time() . '.' . $extension;
        $section->img = $img_name;

        $section->save();
        Storage::disk('public')->put('menus/' . strval($section->menuId) . '/' . strval($section->id) . '/' . $img_name, file_get_contents($img));
        return json_encode($section);
    }

    public function updateSection(Request $request) {
        //
    }

    public function changeSectionAvailability(Request $request) {
        $section = Section::find($request->id);
        $section->available = !$section->available;
        $section->save();
        return json_encode($section);
    }

    public function deleteSection(Request $request) {
        $section = Section::find($request->sectionId);
        if (Auth::id() != Menu::find($section->menuId)->userId)
            abort(403);
        File::deleteDirectory(public_path('/storage/menus/' . strval($section->menuId) . '/' . strval($section->id) . '/'));
        Section::destroy($section->id);
    }
}
