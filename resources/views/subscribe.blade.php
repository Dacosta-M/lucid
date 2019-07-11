@extends('layouts.lucid')
@section('sidebar')
@parent

@endsection
@section('content')
<form method="POST" action="{{URL::to('/')}}/{{Auth::user()->username}}/extrss">
    @csrf

  <div class="form-group">
    <input type="text" name="rss" class="form-control h-25" placeholder="Enter External Rss"/>
  </div>
  <div class="text-right">
    <button type="submit" class="btn bg-alt text-white">Add</button>
  </div>
</form>

@endsection
