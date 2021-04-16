@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">User : {{auth()->user()->name}}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif




                    You are logged in!！！！！
                        <br>
                        <hr>
                    <todo-component  :user="{{auth()->user()}}"></todo-component>





                </div>
            </div>
        </div>
    </div>
</div>
@endsection