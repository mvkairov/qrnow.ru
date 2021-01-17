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

class OrderController extends Controller
{
    public function orders($id) {
        if (!DB::table('menus')->where('id', $id)->first())
            abort(404);
        $menu = Menu::find($id);
        if (!Auth::check() or Auth::id() != $menu->userId)
            abort(403);
        return view('ordersAndCalls', ['menu' => $menu]);
    }

    public function getOrders($id) {
        if (!Auth::check() or Auth::id() != Menu::find($id)->userId)
            abort(403);
        $orders = [];
        foreach(Order::where('menuId', $id)->get() as $order)
            if (strtotime($order->created_at) < time() - (24 * 60 * 60))
                Order::destroy($order->id);
            else {
                $products = [];
                $productsAmount = json_decode($order->products);
                foreach ($productsAmount as $id => $count) {
                    $product = Product::find(intval($id));
                    $products[$product->name] = $count;
                }
                $order->products = $products;
                $order->place = Place::find($order->placeId)->name;
                $orders[] = $order;
            }
        return json_encode($orders);
    }

    public function getOrder($id) {
        $order = Order::find(intval($id));
        $products = [];
        $productsAmount = json_decode($order->products);
        foreach ($productsAmount as $id => $count) {
            $product = Product::find(intval($id));
            $product->count = $count;
            $products[] = $product;
        }
        return json_encode($products);
    }

    public function addOrder(Request $request) {
        $this->validate($request, [
            'placeId' => 'required',
            'products' => 'required',
            'guestName' => 'required',
            'guestNumber' => 'required',
            'paymentMethod' => 'required',
            'takeAway' => 'required',
            'menuId' => 'required',
        ]);
        $order = new Order;
        $order->menuId = $request->menuId;
        $order->placeId = $request->placeId;
        $order->products = $request->products;
        $order->guestName = $request->guestName;
        $order->guestNumber = $request->guestNumber;
        $order->paymentMethod = $request->paymentMethod;
        $order->takeAway = boolval($request->takeAway);
        if ($request->has('comment'))
            $order->comment = $request->comment;
        
        $sum = 0;
        $productsAmount = json_decode($order->products);
        foreach ($productsAmount as $id => $count) {
            $product = Product::find(intval($id));
            $sum += $product->price * intval($count);
        }
        $order->sum = $sum;
        $order->save();
        return $order->id;
    }

    public function updateOrder(Request $request) {
        //
    }

    public function deleteOrder(Request $request) {
        if (!Auth::check())
            abort(403);
        Order::destroy($request->orderId);
        return($request->orderId);
    }
}
