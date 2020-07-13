@extends('layouts.app')

@section('content')
<div class="container">
    @csrf
<chat-component :user="{{ auth()->user() }}"></chat-component>
</div>

@endsection
