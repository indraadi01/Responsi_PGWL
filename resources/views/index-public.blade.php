@extends('layouts.template')

@section('style')
    <style>
        html,
        body {
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
    <div id="map" style="width: 100vw; height: 100vh; margin: 0"></div>
@endsection

@section('script')
    <script>
        // Map
        var map = L.map('map').setView([-6.8881, 109.6753], 12);

        //Basemap
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        /* GeoJSON Point */
        var point = L.geoJson(null, {
            onEachFeature: function(feature, layer) {
                var popupContent = "Name: " + feature.properties.name + "<br>" +
                    "Description: " + feature.properties.description + "<br>" +
                    "Photo: <img src='{{ asset('storage/images/') }}/" + feature.properties.image +
                    "' class='img-thumbnail' alt='...'>" + "<br>";

                layer.on({
                    click: function(e) {
                        layer.bindPopup(popupContent).openPopup();
                    },
                    mouseover: function(e) {
                        layer.bindTooltip(feature.properties.name).openTooltip();
                    },
                });
            },
        });
        $.getJSON("{{ route('api.points') }}", function(data) {
            point.addData(data);
            map.addLayer(point);
        });

        /* GeoJSON Polyline */
        var polyline = L.geoJson(null, {
            onEachFeature: function(feature, layer) {
                var popupContent = "Nama: " + feature.properties.name + "<br>" +
                    "Deskripsi: " + feature.properties.description + "<br>" +
                    "Foto: <img src='{{ asset('storage/images/') }}/" + feature.properties.image +
                    "' class='img-thumbnail' alt='...'>" + "<br>";
                layer.on({
                    click: function(e) {
                        layer.bindPopup(popupContent).openPopup();
                    },
                    mouseover: function(e) {
                        layer.bindTooltip(feature.properties.name).openTooltip();
                    },
                });
            },
        });
        $.getJSON("{{ route('api.polylines') }}", function(data) {
            polyline.addData(data);
            map.addLayer(polyline);
        });

        /* GeoJSON Polygon */
        var polygon = L.geoJson(null, {
            onEachFeature: function(feature, layer) {
                var popupContent = "Nama: " + feature.properties.name + "<br>" +
                    "Deskripsi: " + feature.properties.description + "<br>" +
                    "Foto: <img src='{{ asset('storage/images/') }}/" + feature.properties.image +
                    "' class='img-thumbnail' alt='...'>" + "<br>";

                layer.on({
                    click: function(e) {
                        layer.bindPopup(popupContent).openPopup();
                    },
                    mouseover: function(e) {
                        layer.bindTooltip(feature.properties.name).openTooltip();
                    },
                });
            },
        });
        $.getJSON("{{ route('api.polygons') }}", function(data) {
            polygon.addData(data);
            map.addLayer(polygon);
        });

        /* GeoJSON Landuse */
        var landuse = L.geoJson(null, {
            onEachFeature: function(feature, layer) {
                var popupContent = "Nama: " + feature.properties.remark + "<br>" +
                    "Deskripsi: " + feature.properties.description + "<br>" +
                    "Foto: <img src='{{ asset('storage/images/') }}/" + feature.properties.image +
                    "' class='img-thumbnail' alt='...'>" + "<br>";

                layer.on({
                    click: function(e) {
                        layer.bindPopup(popupContent).openPopup();
                    },
                    mouseover: function(e) {
                        layer.bindTooltip(feature.properties.name).openTooltip();
                    },
                });
            },
        });
        $.getJSON("{{ route('api.landuse') }}", function(data) {
            landuse.addData(data);
            map.addLayer(landuse);
        });

        // Layer control
        var overlayMaps = {
            "Point": point,
            "Polyline": polyline,
            "Polygon": polygon,
            "Landuse": landuse
        };
        var layerControl = L.control.layers(null, overlayMaps, { collapsed: false }).addTo(map);
    </script>
@endsection

</body>
</html>
