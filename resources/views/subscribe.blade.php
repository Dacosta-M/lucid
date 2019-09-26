@extends('layouts.lucid')
@section('title')
  {{ $user->name }} - Lucid
@endsection
@php
$location= 'subscribe';
@endphp
@section('sidebar')
@parent

@endsection
@section('content')
<form method="POST" action="@if($isLocal){{ url('/')}}@else {{secure_url('/')}}@endif/{{Auth::user()->username}}/extrss">
    @csrf

  <div class="form-group">
    <input type="text" name="rss" class="form-control h-25" placeholder="Enter External Rss"/>
  </div>
  <div class="text-right">
    <button type="submit" class="btn bg-alt text-white">Add</button>
  </div>
</form>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>



@endsection
