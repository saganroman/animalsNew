@extends('layouts.app')
@section('title','| Головна')
@section('content')
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCHnwJxlNzPi5tU6LVJaRFrqKWLPwuUvjA&libraries=places,drawing&callback=initMap"
            async defer></script>
    <div class="container">
        <div class="row">
            <div class="col-md-10">

                <div id="map"></div>

            </div>

            <div class="col-md-2">

                <form {{--action="/search" method="get"--}}>
                    {{ csrf_field() }}

                    <div class=" form-group">
                        <label for="InSpecies">Вид тварини</label>
                        <select class=" form-control" id="InSpecies" name="species">
                            <option selected> Всі</option>

                            @foreach( $species as $specy)
                                @if ((isset($s))and($specy->id==$s)) {
                                <option selected value="{{$specy->id}}">{{$specy->name}}</option>}
                                @else{
                                <option value="{{$specy->id}}">{{$specy->name}}</option>}
                                @endif
                            @endforeach


                        </select>

                    </div>
                    <div class=" form-group">
                        <label for="InBreed">Порода тварини</label>
                        <select class=" form-control" id="InBreed" name="breed" disabled>
                            @if((isset($b))and   ($b!='Всі')){
                            <option selected> <?php echo($br->name);?> </option>}
                            @else{
                            <option selected> Всі</option>}
                            @endif
                        </select>
                    </div>
                </form>

            </div>
        </div>
    </div>

    <script>


        function initMap() {
            var markers = [];
            var shapes = [];

            function clearMarkers() {
                for (var i = 0; i < markers.length; i++) {
                    markers[i].setMap(null);
                }
                markers = [];
            }

            function clearShapes() {
                for (var i = 0; i < shapes.length; i++) {
                    shapes[i].setMap(null);
                }
            }
//function for processing received data and display it on uor map
            function markersShow(str) {
                var obj = JSON.parse(str);
                for (var i = 0; i < obj.length; i++) {
                    var name = obj[i]["name"];
                    var species = obj[i]["species_id"];
                    var breed = obj[i]["breed_id"];
                    var content = obj[i]["content"];
                    var photo = '{!!URL::asset('images')!!}/' + obj[i]["photo"];
                    var photo_s = '{!!URL::asset('images')!!}/s_' + obj[i]["photo"];
                    var position = obj[i]["LatLn"];
                    var coordinates = position.split(',');
                    var Lat = +coordinates[0].trim();
                    var Lng = +coordinates[1].trim();

                    var animalObject = new Animal(name, species, breed, content, photo, photo_s, Lat, Lng);
                    markers.push(animalObject.draw());
                }
            }
// Main Class with its properties and methods
            function Graphics(name) {
                this.name = name;

            };
            Graphics.prototype.getInfoWindowContent = function () {
                console.log('123');
            }
            Graphics.prototype.draw = function () {

                var image = {
                    url: this.photo_s,
                    origin: new google.maps.Point(0, 0),
                    anchor: new google.maps.Point(0, 75)
                };
                var marker = new google.maps.Marker({
                    position: {lat: this.Lat, lng: this.Lng},
                    map: map,
                    icon: image,
                    title: this.name,
                });

                var infWindow=this.getInfoWindowContent();
                 marker.addListener('click', function () {
                     infWindow.open(map, marker);
                 });
                return marker;
            };

//Chield Class
            function Animal(name, species, breed, content, photo, photo_s, Lat, Lng) {
                this.species = species;
                this.breed = breed;
                this.content = content;
                this.photo = photo;
                this.photo_s = photo_s;
                this.Lat = Lat;
                this.Lng = Lng;
                Graphics.call(this, name);

            };

            Animal.prototype = new Graphics();
            Animal.prototype.getInfoWindowContent = function () {
                var infowindow = new google.maps.InfoWindow({
                    content: "<div><img src=\"" + this.photo + "\"><p><b>Кличка -</b>" + this.name + "</p>  <p> Вид-" + this.species + " <br> Порода- " + this.breed + "  </p> " + this.content + " </div>",
                    maxWidth: 200,
                });
               return infowindow;

            }

            var map = new google.maps.Map(document.getElementById('map'), {
                zoom: 12,
                center: {lat: 49.844285, lng: 24.027050},
                mapTypeControl: true,
                mapTypeControlOptions: {
                    position: google.maps.ControlPosition.LEFT_BOTTOM
                },
            });
//get data when load main page
            $.ajax({
                type: "GET",
                url: "/getAnimals",
                cache: false,
                success: function (responce) {
                    markersShow(responce);

                }
            });
// cteate Drawing Manager and show it in center
            var drawingManager = new google.maps.drawing.DrawingManager({
                map: map,
                drawingMode: google.maps.drawing.OverlayType.circle,
                drawingControl: true,
                drawingControlOptions: {
                    position: google.maps.ControlPosition.TOP_CENTER,
                    drawingModes: [
                        google.maps.drawing.OverlayType.CIRCLE,
                        google.maps.drawing.OverlayType.POLYGON,
                    ]
                }
            });

//get data for our filters
            $("#InSpecies").change(function () {
                clearShapes();
                var speciesId = $("#InSpecies").val();
                clearMarkers();
                $("#InBreed").attr('disabled', false);
                $.ajax({
                    type: "GET",
                    url: "/getBreed/" + speciesId,
                    cache: false,
                    success: function (responce) {
                        $("#InBreed").html(responce);
                    }
                });
//get data according our filters and display it
                $.ajax({
                    type: "GET",
                    url: "/getAnimalsBySpecies/" + speciesId,
                    cache: false,
                    success: function (responce) {
                        markersShow(responce);
                    }
                });

            });

            $("#InBreed").change(function () {
                clearMarkers();
                var speciesId = $("#InSpecies").val();
                var breedId = $("#InBreed").val();
                clearShapes();
                $.ajax({
                    type: "GET",
                    url: "/getAnimalsByBreed/" + speciesId + "/" + breedId,
                    cache: false,
                    success: function (responce) {

                        markersShow(responce);
                    }
                });
            })
//processing drawing manager events
            google.maps.event.addListener(drawingManager, 'circlecomplete', function (circle) {
                center = circle.getCenter();
                radius = circle.getRadius();
                clearShapes();
                clearMarkers();
                circleObj = new google.maps.Circle({
                    center: center,
                    radius: radius,
                    strokeColor: '#FF0000',
                    strokeOpacity: 0.5,

                });
                shapes.push(circleObj);
                circle.setMap(null);
                shapes[shapes.length - 1].setMap(map);
                var speciesId = $("#InSpecies").val();
                var breedId = $("#InBreed").val();
                $.ajax({
                    type: "GET",
                    url: "/checkoutCircle/" + center + "/" + radius + "/" + speciesId + "/" + breedId,
                    cache: false,
                    success: function (responce) {

                        markersShow(responce);

                    }
                });
            });
            google.maps.event.addListener(drawingManager, 'polygoncomplete', function (polyg) {
                clearShapes();
                clearMarkers();
                draw = new google.maps.Polygon({
                    paths: polyg.getPaths(),
                    strokeColor: '#FF0000',
                    strokeOpacity: 0.8,
                    strokeWeight: 2,
                    fillColor: '#FF0000',
                    fillOpacity: 0.35,
                });
                shapes.push(polyg);
                polyg.setMap(null);
                shapes[shapes.length - 1].setMap(map);
                var speciesId = $("#InSpecies").val();
                var breedId = $("#InBreed").val();
                vertexes = polyg.getPaths().b[0].b.toString().replace(/\(/g, "[").replace(/\)/g, "]");
                c = '[' + vertexes + ']'
                $.ajax({
                    type: "GET",
                    url: "/checkoutPolygon/" + c + "/" + speciesId + "/" + breedId,
                    cache: false,
                    success: function (responce) {

                        markersShow(responce);
                    }
                });

            });
        }
    </script>
@endsection
@section('scripts')


@endsection
