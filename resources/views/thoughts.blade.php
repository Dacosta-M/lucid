@extends('layouts.lucid')
@section('title')
  @if(Auth::user() && Auth::user()->username == $user->username)
   Thoughts - {{ $user->username }} - Lucid
  @else
  {{ $user->name }} (@ {{ $user->username }}) - Lucid
  @endif
@endsection
@php
$location= 'thoughts';
@endphp
@section('sidebar')
@parent

@endsection
@section('content')
<!-- Editor -->
<style>
  .form-control{
    outline: 0px !important;
    -webkit-appearance: none;
    box-shadow: none !important;
  }

  .text-danger{
  font-weight:400px !important;
  font-size:12px !important;

}
</style>
@if(Auth::user() && Auth::user()->username == $user->username)
<p>Write a thought</p>

<form method="POST" action="{{url('/save-post')}}" autocomplete="off" enctype="multipart/form-data" class="mb-3">
  @csrf
  <div class="form-group">
    <textarea type="text" name="body" class="form-control h-25" placeholder="Tell your story"></textarea>
    @if($errors->has('body'))
    <span class="text-danger">Fill out this field to publish your thoughts</span>
    @endif
  </div>
  <div class="text-right">
    <button type="submit" class="btn bg-alt text-white">Publish</button>
  </div>
</form>
@endif
<!-- End Editor -->
<br />
<h5 class="font-weight-bold mb-4">Latest stories</h5>
<!-- Begin content -->


@foreach ($posts as $feeds)
<div class="post-content">

  <div class="post-content-body">
    <p class="mb-1">{{$user->name}}-<small class="text-muted">{{$feeds['date']}}</small></p>
    <p class="">
      {!!$feeds['body']!!}
    </p>
  </div>
</div>

@endforeach
  @guest
  @else
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

<script>
const j = jQuery.noConflict();
 j(document).ready(function (){
    const check = "{{ route('notif',['username'=>$user->username])  }}"
    j.ajaxSetup({
        headers:{
            'X-CSRF-TOKEN': j('meta[name="csrf-token"]').attr('content')
        }
     })

function load_unseen_notification(view = '')
{
j.ajax({
  url:check,
  method:"POST",
  data:{view:view},
  dataType:"json",
  })
.then (
  function(data) {
  //  console.log(data);

   if(data.unseen_notification > 0)
   {
    j('.count').html(data.unseen_notification);
   }


 })
.catch(function(err) {
    //console.log('Fetch Error :-S', err);
    });
  }
  const view_notif = "{{ route('getNotif',['username'=>$user->username])  }}"

  view = "";
  j.ajax({
    url:view_notif,
    method:"Get",
    data:{view:view},
    dataType:"json",
    })
  .then (
    function(data) {
  //    console.log(data);
  j(document).on('click', '#load', function(){
    j('#notif').html(data.notification);
  });

     })

  setInterval(function(){
load_unseen_notification();
}, 2000);

j(document).on('click', '#notif', function(){
 j('.count').html('');
 load_unseen_notification('yes');
  });



})

</script>
  @endguest
<!-- End content -->
@endsection
