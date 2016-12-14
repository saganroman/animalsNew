@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <table class="table table-hover">
                    <tr class="info">
                        <td>Id</td>
                        <td>Кличка</td>
                        <td>Вид</td>
                        <td>Порода</td>
                        <td>Адреса де пропала</td>
                        <td>Редагувати</td>
                        <td>Видалити</td>
                    </tr>
                   @foreach( $animals as $animal)


                        <tr>
                            <td>{!! $animal->id !!}</td>
                            <td>{!! $animal->name !!}</td>
                            <td>{!! $animal->species->name !!}</td>
                            <td>{!! $animal->breed->name !!}</td>
                            <td>{!! $animal->address !!}</td>
                            <td><a href="/editAnimal/{!! $animal->id !!}"> <img src="{!!URL::asset('images')!!}/update.jpg" width="20" height="20"></a></td>
                            <td><a href="/deleteAnimal/{!! $animal->id !!}"> <img src="{!!URL::asset('images')!!}/Remove.png"  width="20" height="20"> </a> </td>
                        </tr>
                    @endforeach
                </table>
                {!! $animals->links(); !!}
            </div>
        </div>
    </div>
@endsection