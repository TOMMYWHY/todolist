@extends('layouts.app')

@section('content')

<todo-component  :user="{{auth()->user()}}"></todo-component>

@endsection
