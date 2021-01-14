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
use App\Models\Call;

class CallController extends Controller
{
    public function getCalls($id) {
        if (!Auth::check() or (Menu::find($id)->userId != Auth::id()))
            abort(403);
        $calls = [];
        foreach (Call::where('menuId', $id)->get() as $call)
            if (strtotime($call->created_at) < time() - (24 * 60 * 60))
                Call::destroy($call->id);
            else {
                $call->place = Place::find($call->placeId)->name;
                $calls[] = $call;
            }
        return json_encode($calls);
    }

    public function addCall(Request $request) {
        $this->validate($request, [
            'placeId' => 'required',
            'menuId' => 'required',
            'type' => 'required'
        ]);
        $call = new Call;
        $call->menuId = $request->menuId;
        $call->placeId = $request->placeId;
        $call->type = $request->type;
        $call->save();
    }

    public function deleteCall(Request $request) {
        if (!Auth::check())
            abort(403);
        Call::destroy(intval($request->callId));
        return json_encode($request->callId);
    }
}
