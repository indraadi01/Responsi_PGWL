<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Polygon extends Model
{
    use HasFactory;

    protected $table = 'MergePL';

    protected $guarded = ['id'];

    public function polygons()
    {
        return $this->select(DB::raw('id, remark, lcode, ST_AsGeoJSON(geom) as geom, image, shape_area, created_at, updated_at'))->get();
    }
    public function polygon($id)
    {
        return $this->select(DB::raw('id, remark, lcode, ST_AsGeoJSON(geom) as geom, image, shape_area, created_at, updated_at'))
        -> where('id', $id)->get();
    }
}
