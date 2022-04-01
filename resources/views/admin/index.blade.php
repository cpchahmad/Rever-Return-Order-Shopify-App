@extends('admin.layouts.main')

@section('content')

<div class="container">

    <div class="row">


        <div class="col-12">

            <h1 class="mt-3">STORES</h1>

    <table class="table mt-3">
        <thead class="thead-light">
        <tr>
            <th scope="col">#</th>
            <th scope="col">Name</th>
            <th scope="col">Email</th>

        </tr>
        </thead>
        <tbody>
        @php
        $i=1;
        @endphp
        @foreach($user as $index=>$getuser)
        <tr>
            <th scope="row">{{$i++}}</th>
            <td>{{$getuser->name}}</td>
            <td>{{$getuser->email}}</td>

        </tr>

        @endforeach


        </tbody>
    </table>

    </div>

    </div>

</div>
@endsection
