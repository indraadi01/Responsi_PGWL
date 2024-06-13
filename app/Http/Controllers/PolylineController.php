<?php

namespace App\Http\Controllers;

use App\Models\Polylines;
use Illuminate\Http\Request;

class PolylineController extends Controller
{
    public function __construct() {
        $this->polyline = new Polylines();
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $polylines =$this->polyline->polylines();

        foreach ($polylines as $p) {
            $feature[] = [
                'type' => 'Feature',
                'geometry' => json_decode($p->geom),
                'properties' => [
                    'id' => $p->id,
                    'remark' => $p->remark,
                    'lcode' => $p->lcode,
                    'image' => $p->image,
                    'shape_leng' => $p->shape_leng,
                    'created_at' => $p->created_at,
                    'updated_at' => $p->updated_at
                ]
            ];
        }

        return response()->json([
            'type' => 'FeatureCollection',
            'features' => $feature
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //validate request
        $request->validate([
            'remark' => 'required',
            'lcode' => 'required',
            'geom' => 'required',
            'image' => 'mimes:jpeg,png,jpg,tiff,gif,svg|max:10000' //10MB
        ],
        [
            'remark.required' => 'Name is required',
            'lcode.required' => 'Lcode is required',
            'geom.required' => 'Location is required',
            'image.mimes' => 'The image must be a file of type: jpeg,png,jpg,tiff,gif,svg',
            'image.max' => 'The image may not be greater than 10MB.'
        ]);

       //create folder images
       if (!is_dir('storage/images')) {
        mkdir('storage/images', 0777);
    }

    // upload image
    if ($request->hasFile('image')) {
        $image = $request->file('image');
        $filename = time() . '_polyline.' . $image->getClientOriginalExtension();
        $image->move('storage/images', $filename);
    } else {
        $filename = null;
    }

    $data = ([
        'remark' => $request->remark,
        'lcode' => $request->lcode,
        'geom' => $request->geom,
        'image' => $filename
    ]);


        //Create Polyline
        if(!$this->polyline->create($data)){
            return redirect()->back()->with('error', 'Failed to create polyline');
        }

        //redirect to map
        return redirect()->back()->with('success', 'Polyline created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $polylines = $this->polyline->polyline($id);

        foreach ($polylines as $p) {
            $feature[] = [
                'type' => 'Feature',
                'geometry' => json_decode($p->geom),
                'properties' => [
                    'id' => $p->id,
                    'name' => $p->remark,
                    'description' => $p->lcode,
                    'image' => $p->image,
                    'shape_leng' => $p->shape_leng,
                    'created_at' => $p->created_at,
                    'updated_at' => $p->updated_at
                ]
            ];
        }

        return response()->json([
            'type' => 'FeatureCollection',
            'features' => $feature
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $polylines = $this->polyline->find($id);
        $data = [
            'title' => 'Edit Polyline',
            'polylines' => $polylines,
            'id' => $id
        ];
        return view('edit-polyline', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //validate request
        $request->validate(
            [
                'remark' => 'required',
                'lcode' => 'required',
                'geom' => 'required',
                'image' => 'mimes:jpeg,png,jpg,tiff,gif,svg|max:10000' //10MB
            ],
            [
                'remark.required' => 'Remark is required',
                'lcode.required' => 'Lcode is required',
                'geom.required' => 'Location is required',
                'image.mimes' => 'The image must be a file of type: jpeg,png,jpg,tiff,gif,svg',
                'image.max' => 'The image may not be greater than 10MB.'
            ]
        );

        //create folder images
        if (!is_dir('storage/images')) {
            mkdir('storage/images', 0777);
        }

        // upload image
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = time() . '_polyline.' . $image->getClientOriginalExtension();
            $image->move('storage/images', $filename);

            //delete image
            $image_old = $request->image_old;
            if ($image_old != null) {

            }
        } else {
            $filename = $request->image_old;
        }

        $data = ([
            'remark' => $request->remark,
            'lcode' => $request->lcode,
            'geom' => $request->geom,
            'image' => $filename

        ]);

        //Update Polyline
        if (!$this->polyline->find($id)->update($data)) {
            return redirect()->back()->with('error', 'Failed to update polyline');
        }

        //redirect to map
        return redirect()->back()->with('success', 'Polyline updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //get image
        $image = $this->polyline->find($id)->image;



        //delete polyline
        if (!$this->polyline->destroy($id)) {
            return redirect()->back()->with('error', 'Failed to delete polyline');
        }

        //delete image
        if ($image != null) {
            unlink('storage/images/' . $image);
        }

        //redirect to map
        return redirect()->back()->with('success', 'Polyline deleted successfully');
    }

    public function table() {
        $polylines = $this->polyline->polylines();
        $data = [
            'title' => 'Table Polyline',
            'polylines' => $polylines
        ];
        return view('table-polyline', $data);
    }
}
