<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Polylines extends Model
{
    use HasFactory;

    protected $table = 'JalanKota';

    protected $guarded = ['id'];

    public function polylines()
    {
        return $this->select(DB::raw('id, remark, lcode, ST_AsGeoJSON(geom) as geom, image, shape_leng, created_at, updated_at'))->get();
    }
    public function polyline($id)
    {
        return $this->select(DB::raw('id, remark, lcode, ST_AsGeoJSON(geom) as geom, image, shape_leng, created_at, updated_at'))
        -> where('id', $id)->get();
    }
}
