<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Section extends Model
{
    use HasFactory;
    public function getNextId() 
    {
        $statement = DB::select("show table status like 'sections'");
        return $statement[0]->Auto_increment;
    }
}
