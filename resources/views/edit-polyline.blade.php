@extends('layouts.template')

@section('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet.draw/1.0.4/leaflet.draw.css">
    <style>
        html,
        body,
        {
        height: 100%;
        width: 100%;
        }

        #map {
            height: calc(100vh - 56px);
            width: 100%;
            margin: 0;
        }
    </style>
@endsection

@section('content')
    <div id="map"></div>

    <!-- Modal Create Polyline-->
    <div class="modal fade" id="PolylineModal" tabindex="-1" aria-labelledby="PolylineModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="PolylineModalLabel">Edit Polyline</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('update-polyline', $id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PATCH')
                        <div class="mb-3">
                            <label for="remark" class="form-label">Name</label>
                            <input type="text" class="form-control" id="remark" name="remark" value="{{ $polyline->remark }}" placeholder="Fill polyline name">
                        </div>
                        <div class="mb-3">
                            <label for="lcode" class="form-label">Description</label>
                            <textarea class="form-control" id="lcode" name="lcode" rows="3">{{ $polyline->lcode }}</textarea>
                        </div>
                        <div class="mb-3">
                            <label for="geom" class="form-label">Geometry</label>
                            <textarea class="form-control" id="geom_polyline" name="geom" rows="3" readonly></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="image" class="form-label">Image</label>
                            <input type="file" class="form-control" id="image_polyline" name="image"
                                onchange="document.getElementById('preview-image-polyline').src = window.URL.createObjectURL(this.files[0])">

                                <input type="hidden" class="form-control" id="image_old" name="image_old">
                        </div>
                        <div class="mb-3">
                            <img src="" alt="Preview" id="preview-image-polyline" class="img-thumbnail"
                                width="400">
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection


@section('script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet.draw/1.0.4/leaflet.draw.js"></script>
    <script src="https://unpkg.com/@terraformer/wkt"></script>

    <script>
        // map
        var map = L.map('map').setView([-7.7715537, 110.2952981], 13);
        // layer
        L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
        }).addTo(map);

        var drawnItems = new L.FeatureGroup();
        map.addLayer(drawnItems);

        var drawControl = new L.Control.Draw({
            draw: {
                position: 'topleft',
                polyline: false,
                polygon: false,
                rectangle: false,
                circle: false,
                marker: false,
                circlemarker: false
            },
            edit: {
                featureGroup: drawnItems,
                edit: true,
                remove: false
            }
        });

        map.addControl(drawControl);

        map.on('draw:edited', function(e) {
            var layer = e.layers;

            layer.eachLayer(function(layer){
                var geojson = layer.toGeoJSON();

                var wkt = Terraformer.geojsonToWKT(geojson.geometry);
            // console.log(geojson); Mendebug keluaran data
                $('#remark').val(layer.feature.properties.remark);
                $('#lcode').val(layer.feature.properties.lcode);
                $('#geom_polyline').val(wkt);
                $('#image_old').val(layer.feature.properties.image);
                $('#preview-image-polyline').attr('src', '{{ asset('storage/images/') }}/' + layer.feature.properties.image);
                $('#PolylineModal').modal('show');


            });
        });

        /* GeoJSON Polyline */
        var polyline = L.geoJson(null, {
            onEachFeature: function(feature, layer) {

                //Add polyline layer
                drawnItems.addLayer(layer);

                var popupContent = "Name: " + feature.properties.remark + "<br>" +
                    "Description: " + feature.properties.lcode + "<br>" +
                    "Photo: <br> <img src='{{ asset('storage/images/') }}/" + feature.properties.image +
                    "' class='' alt='...' width='200'>";

                    ;
                layer.on({
                    click: function(e) {
                        polyline.bindPopup(popupContent);
                    },
                    mouseover: function(e) {
                        polyline.bindTooltip(feature.properties.remark);
                    },
                });
            },
        });
        $.getJSON("{{ route('api.polyline', $id) }}", function(data) {
            polyline.addData(data);
            map.addLayer(polyline);
            map.fitBounds(polyline.getBounds());
        });

    </script>
@endsection
