@extends('layouts.app')
@section('scripts')
    <script type="text/javascript" src="{{ URL::asset('ckeditor/ckeditor.js') }}"></script>
    <script>
        CKEDITOR.replace('editor1');
    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCHnwJxlNzPi5tU6LVJaRFrqKWLPwuUvjA&libraries=places&callback=initAutocomplete"
            async defer></script>





@endsection
@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <form action="/updateAnimal/{!! $animal->id !!}" method="get">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label for="InName">Кличка тварини</label>
                        <input type="text" name="name" class="form-control" id="InName" placeholder="Кличка"
                               value="{{ $animal->name}}">
                    </div>
                    <div class=" form-group">
                        <label for="InSpecies">Вид тварини</label>
                        <select class=" form-control" id="InSpecies" name="species">
                            <option selected value="{{$animal->species->id}}"> {{$animal->species->name}}</option>

                            @foreach( $species as $specy)

                                <option value="{{$specy->id}}">{{$specy->name}}</option>}

                            @endforeach


                        </select>

                        </select>

                    </div>
                    <div class=" form-group">
                        <label for="InBreed">Порода тварини</label>
                        <select class=" form-control" id="InBreed" name="breed">
                            <option selected value="{{$animal->breed->id}}"> {{$animal->breed->name}}</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <img src="{{ URL::asset('images') }}/s_{!! $animal->photo !!}"> <br>
                        <label for="exampleInputFile">Фотографія улюбленця</label>
                        <input type="file" id="exampleInputFile" accept="image/*" name="photo">

                    </div>
                    <div class="form-group">
                        <label>Короткий опис</label>
                        <textarea class="form-control " id="editor1" rows="3" required
                                  name="content"> {!! $animal->content!!}</textarea>
                    </div>

                    <div class="form-group">
                        <label for="myIn">Адреса де знакла тварина</label>
                        <input id="myIn" class="controls form-control" type="text" name="address"
                               value="{!!$animal->address  !!}">

                    </div>


                    <input id="id" name="id" type="hidden" value="{!! $animal->id  !!}">
                    <input name="oldLatLn" type="hidden" value="{!! $animal->LatLn  !!}">
                    <input id="oldPhoto" name="oldPhoto" type="hidden" value="{!! $animal->photo  !!}">
                    <input id="LatLn" name="LatLn" type="hidden">
                    <br><br>

                    <button type="submit" class="btn  btn-success myBtn">Редагувати!</button>


                </form>
            </div>
        </div>
    </div>
    <script>


        function initAutocomplete() {
            /* var geocoder = new google.maps.Geocoder();

             var input = '{!! $animal->LatLn !!}';
             var latlngStr = input.split(',', 2);
             var latlng = {lat: parseFloat(latlngStr[0]), lng: parseFloat(latlngStr[1])};

             geocoder.geocode({
             'latLng': latlng
             }, function (results, status) {
             if (status === google.maps.GeocoderStatus.OK) {
             if (results[1]) {
             // console.log(results[1]);
             $('#myIn').val(results[1].formatted_address) ;
             // console.log(results[1].formatted_address)}
             }
             }
             });*/

            input = document.getElementById('myIn');
            autocomplete = new google.maps.places.Autocomplete(input);
            autocomplete.addListener('place_changed', fillInAddress);

        }
        ;
        function fillInAddress() {

            var place = autocomplete.getPlace();
            document.getElementById('LatLn').value = place.geometry.location;
        }
        ;
        $("#InSpecies").change(function () {
            var speciesId = $("#InSpecies").val();
            $("#InBreed").attr('disabled', false);
            $.ajax({
                type: "GET",
                url: "/getBreedPort/" + speciesId,
                cache: false,
                success: function (responce) {
                    $("#InBreed").html(responce);
                }
            });
        })


        //   $("#InSpecies").click(function () { alert('sad');})

    </script>
@endsection