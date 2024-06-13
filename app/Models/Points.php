<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Points extends Model
{
    use HasFactory;

    protected $table = 'PendidikanKota';

    // protected $fillable = [
    //     'name',
    //     'description',
    //     'geom',
    //     'image'
    // ];

    protected $guarded = ['id'];


    public function points()
    {
        return $this->select(DB::raw('id, remark, lcode, ST_AsGeoJSON(geom) as geom, image, created_at, updated_at'))->get();
    }
    public function point($id)
    {
        return $this->select(DB::raw('id, remark, lcode, ST_AsGeoJSON(geom) as geom, image, created_at, updated_at'))
        -> where('id', $id)->get();
    }
}
