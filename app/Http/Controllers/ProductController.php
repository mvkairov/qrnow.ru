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

class ProductController extends Controller
{
    public function getProducts($id) {
        $sections = Section::where('menuId', $id)->get();
        $menu = [];
        foreach ($sections as $section){
            $section->products = Product::where('sectionId', $section->id)->get();
            $menu[] = $section;
        }
        return json_encode($menu);
    }

    public function addProduct(Request $request) {
        $this->validate($request, [
            'name' => 'required',
            'description' => 'required',
            'price' => 'required',
            'sectionId' => 'required',
            'img' => 'required'
        ]);

        $product = new Product;
        $product->sectionId = $request->sectionId;
        $parentMenu = Section::find($product->sectionId)->menuId;
        if (!Auth::check() or Auth::id() != Menu::find($parentMenu)->userId)
            abort(403);

        $product->name = $request->name;
        $product->description = $request->description;
        $product->price = $request->price;
        if ($request->has('prepare_time'))
            $product->prepare_time = $request->prepare_time;
        if ($request->has('ingridients'))
            $product->ingridients = $request->ingridients;
        if ($request->has('stats'))
            $product->stats = $request->stats;
        
        $img = $request->file('img');
        $name = pathinfo($img->getClientOriginalName(), PATHINFO_FILENAME);
        $extension = $img->getClientOriginalExtension();
        $img_name = $name . '-at-' . time() . '.' . $extension;
        $product->img = $img_name;
        
        $product->save();
        Storage::disk('public')->put('menus/' . strval($parentMenu) . '/' . strval($product->sectionId) . '/products/' . $img_name, file_get_contents($img));
        return json_encode($product);
    }

    public function updateProduct(Request $request) {
        $this->validate($request, [
            'id' => 'required',
            'name' => 'required',
            'description' => 'required',
            'price' => 'required'
        ]);
        $product = Product::find($request->id);
        if (!$product)
            abort(404);
        $parentMenu = Section::find($product->sectionId)->menuId;
        if(!Auth::check() or Auth::id() != Menu::find($parentMenu)->userId)
            abort(403);

        $product->name = $request->name;
        $product->description = $request->description;
        $product->price = $request->price;

        if ($request->has('prepare_time'))
            $product->prepare_time = $request->prepare_time;
        if ($request->has('ingridients'))
            $product->ingridients = $request->ingridients;
        if ($request->has('stats'))
            $product->stats = $request->stats;

        if ($request->has('img')) {
            $img = $request->file('img');
            $name = pathinfo($img->getClientOriginalName(), PATHINFO_FILENAME);
            $extension = $img->getClientOriginalExtension();
            $img_name = $name . '-at-' . time() . '.' . $extension;

            File::delete(public_path('/storage/menus/' . strval($parentMenu) . '/' . strval($product->sectionId)) . '/products/' . $product->img);        
            $product->img = $img_name;
            Storage::disk('public')->put('menus/' . strval($parentMenu) . '/' . strval($product->sectionId) . '/products/' . $img_name, file_get_contents($img));
        }
        
        $product->save();
        return json_encode($product);
    }

    public function changeProductAvailability(Request $request) {
        $product = Product::find($request->id);
        if (!Auth::check() or Auth::id() != Menu::find(Section::find($product->sectionId)->menuId)->userId)
            abort(403);
        $product->available = !$product->available;
        $product->save();
        return json_encode($product);
    }

    public function deleteProduct(Request $request) {
        $product = Product::find($request->productId);
        if (!Auth::check() or Auth::id() != Menu::find(Section::find($product->sectionId)->menuId)->userId)
            abort(403);
        $parentMenu = Section::find($product->sectionId)->menuId;
        if (Auth::id() != Menu::find($parentMenu)->userId)
            abort(403);
        File::delete(public_path('/storage/menus/' . strval($parentMenu) . '/' . strval($product->sectionId)) . '/products/' . $product->img);
        Product::destroy($request->productId);
    }
}
