@extends('layouts.app')
@section('title','| Кабінет')
@section('scripts')
    <script type="text/javascript" src="{{ URL::asset('ckeditor/ckeditor.js') }}"></script>
    <script>
        CKEDITOR.replace('editor1');
    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCHnwJxlNzPi5tU6LVJaRFrqKWLPwuUvjA&libraries=places&callback=initAutocomplete"
            async defer></script>
    <script type="text/javascript" src="{{ URL::asset('js/autocomplete.js') }}"></script>



@endsection
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <form action="/store" method="post" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label for="InName">Кличка тварини</label>
                        <input type="text" name="name" class="form-control" id="InName" placeholder="Кличка" required>
                    </div>
                    <div class=" form-group">
                        <label for="InSpecies">Вид тварини</label>
                        <select class=" form-control" id="InSpecies" name="species">
                            <optgroup label="Выберіть вид">
                                @foreach(  $species as $specy)
                                    <option value="{{$specy->id}}">{{$specy->name}}</option>
                                @endforeach
                            </optgroup>

                        </select>

                    </div>
                    <div class=" form-group">
                        <label for="InBreed">Порода тварини</label>
                        <select class=" form-control" id="InBreed" name="breed" disabled>

                        </select>
                    </div>

                    <div class="form-group">
                        <label for="exampleInputFile">Фотографія улюбленця</label>
                        <input type="file" id="exampleInputFile" accept="image/*" required name="photo">

                    </div>
                    <div class="form-group">
                        <label>Короткий опис</label>
                        <textarea class="form-control " id="editor1" rows="3" required name="content"></textarea>
                    </div>

                    <div class="form-group">
                        <label for="myIn">Адреса де знакла тварина</label>
                        <input id="myIn" class="controls form-control" type="text" name="address" required>

                    </div>
                    <input id="LatLn" name="LatLn" type="hidden">
                    <br><br>

                    <button type="submit"  class="btn  btn-success myBtn">Додати!</button>
                </form>
            </div>
        </div>
    </div>

@endsection
