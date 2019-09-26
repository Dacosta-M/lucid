@extends('layouts.lucid')
@section('title')
@if(Auth::user() && Auth::user()->username == $user->username)
Timeline - {{ $user->username }} - Lucid
@else
{{ $user->name }} ({{ '@'.$user->username }}) - Lucid
@endif
@endsection


@section('img')
@if($user->image)
{{$user->image}}
@else
{{ secure_asset('img/logo.svg') }}
@endif
@endsection

@section('desc')
{{ \Illuminate\Support\Str::limit($user->short_bio, 300) }}
@endsection

@section('tags')

@endsection

@section('url')
{{ secure_url('/').'/'.$user->name }}
@endsection



@php
$location = 'timeline';
@endphp
@section('sidebar')
@parent
@endsection
@section('content')
<style>
  .btn.btn-primary.canel-post {
    background-color: transparent !important;
    border: 1px solid red;
    color: red;
    padding: 6px 5px;
  }

  .btn.btn-primary.publish-post,
  .btn.btn-primary.save-draft,
  .btn.btn-primary.add-tags {
    background-color: #280a66 !important;
    border: 1px solid #280a66;
    padding: 6px 5px;
    color: #fff;
  }

  .main-content {
    padding-top: 30px;
    padding-bottom: 30px;
  }

  .btn-info {
    background-color: #280a66 !important;
    border: 0 !important;
  }



  .form-check-label {
    padding-right: 10px;
  }

  .mb-editor-area {
    background: #f5f5f5;
    border-radius: 5px;
  }

  #new-post-title {
    outline: 0px !important;
    -webkit-appearance: none;
    box-shadow: none !important;
  }

  .mb-editor {
    background: #ffffff;
    border-radius: 5px;
  }


  .micro-blog-enclosure {
    background-color: #E0E0E0;
    border-radius: 10px;
  }

  .editor-btns {
    background: #280a66;
    border-radius: 5px;
  }

  /*Tag styles*/
  .tags {
    padding-right: 10px;
  }

  .btn-outline-primary:not(:disabled):not(.disabled).active,
  .btn-outline-primary:not(:disabled):not(.disabled):active,
  .show>.btn-outline-primary.dropdown-toggle {
    color: #fff !important;
    background-color: #280a66 !important;
    border-color: #280a66 !important;
  }

  .btn-outline-primary {
    color: #280a66 !important;
    border-color: #280a66 !important;
  }

  .btn-outline-primary:hover {
    color: #fff !important;
    background-color: #280a66 !important;
    border-color: #280a66 !important;
  }

  /*tag styples end here..*/
  .mb-textarea {
    /* border: none; */
    font-size: 18px;
    line-height: 22px;
    resize: none;
  }

  .mb-textarea::placeholder {
    font-weight: bold;

  }

  .mb-textarea:focus {
    outline: none !important;
    border: 1px solid red;
    box-shadow: none;
  }

  .mb-icon-link {
    color: #000000;
  }

  .mb-icon-link:hover {
    color: #000000;
  }

  .icon-audio,
  .icon-photo,
  .icon-video {
    cursor: pointer;
  }

  .icon-audio {
    color: #C61639;
  }

  .icon-photo {
    color: #280a66;
  }

  .icon-video {
    color: #6C63FF;
  }

  .btn-mb-post,
  .btn-mb-submit {
    background: #3B0E75;
    color: #ffffff;
    border-radius: 5px;
    border: none;

  }

  .btn-mb-post:hover,
  .btn-mb-submit:hover,
  .btn-mb-cancel {
    background: #ffffff;
    color: #3B0E75;
    border-radius: 5px;
    border: 1px solid #3B0E75;

  }

  .mb-content {
    color: var(--mb-text-color);
    font-size: 18px;
    line-height: 140%;
  }

  .mb-image {
    object-fit: none;
    border-radius: 50%;
    width: 60px;
    height: 60px;
  }

  .mb-title {
    color: #000000;
    line-height: 1.3em;
    font-size: 24px;
  }

  .mb-title:hover {
    color: #000000;
    text-decoration: underline;
  }

  .mb-post-time {
    color: #000000;
    font-size: 14px;
    font-weight: 500;
  }

  .mb-reply {
    color: var(--primary-color);
    font-size: 14px;
    font-weight: 500;
    cursor: pointer;
  }

  .mb-reply:hover {
    color: var(--primary-color);
    text-decoration: underline;
  }

  .mb-pagination a {
    color: var(--primary-color);
    font-size: 18px;
    font-weight: 500;
  }

  .mb-pagination a:hover {
    color: var(--primary-color);
    text-decoration: underline;
  }

  /* Media Query */
  @media screen and (max-width: 768px) {
    .mb-editor {
      flex-direction: column-reverse;
      padding: 1rem 0.5rem !important;
      align-items: flex-start !important;
    }

    .textarea-control {
      align-items: flex-start !important;
      margin-top: 1rem !important;
    }

    .mb-textarea,
    .mb-audio,
    .mb-photo,
    .mb-video {
      margin: 0 0 0 4px !important;
    }

    /* .mb-textarea {
      font-size: 14px;
      padding: 0 !important;
    } */

    .reply-form {
      width: 100% !important;
    }
  }
</style>
<div class="row">
  <div class="col-12 col-sm-1"></div>
  <div class="col-12 col-sm-10">

  </div>
  <div class="col-11 col-sm-1"></div>

  <!-- Feed section ends here -->
</div>

<!-- Begin content -->
<!-- Timeline Page -->
<div>
  <!-- <h4 class="ml-4 mb-3 pl-1">Explore Lucid</h4> -->
  <!-- Begin content -->
  <div id ='nav-tab' class="page-tab mb-3">
    <ul class="nav nav-tabs navbar-light" id="nav-feed" role="tablist">
      <li class="nav-item" onclick="feeds()">
        <a href="#timeline" class="nav-link tab-link active pl-0" data-toggle="tab" role="tab" aria-controls="category" aria-selected="">
          <h6 class="mb-0">Timeline</h6>
        </a>
      </li>
      @if($tabs)
      @foreach($tabs as $tab)
      <li class="nav-item" onclick="tabfeeds('{{$tab}}')">
        <a href="#timeline" class="nav-link tab-link pl-0" data-toggle="tab" role="tab" aria-controls="category" aria-selected="">
          <h6 class="mb-0">{{$tab}}</h6>
        </a>
      </li>
      @endforeach
      @endif
      <a href="#"  class="pt-1"><i onclick="settings()" class="fas fa-plus-circle text-secondary"></i></a>
    </ul>
  </div>


    {{--@if(count($posts) > 0)--}}
    <div class="tab-pane show" role="tabpanel" id="timeline">
      <div class="row mt-5">
        <div class="col-md-12">
<section id="feeds" class="feeds">

      <!-- timeline page -->
  <div id="load">
  @include('feeds')

</div>
</section>
</div>
</div>
</div>
 {{-- @endif
--}}
<input type="hidden" value="{{ $user->username }}" id="username">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script>

    function feeds() {
      if (window.XMLHttpRequest) {
        // code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp = new XMLHttpRequest();
      } else {
        // code for IE6, IE5
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
      }
      xmlhttp.onreadystatechange = function() {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
          document.getElementById("feeds").innerHTML = xmlhttp.responseText;
        }
      };
      xmlhttp.open("GET", "/{{ $user->username }}/feeds", true);
      xmlhttp.send();

    }
    function tabfeeds(id) {
      if (window.XMLHttpRequest) {
        // code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp = new XMLHttpRequest();
      } else {
        // code for IE6, IE5
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
      }
      xmlhttp.onreadystatechange = function() {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
          document.getElementById("feeds").innerHTML = xmlhttp.responseText;
        }
      };
      xmlhttp.open("GET", "/{{ $user->username }}/feeds?tags="+id, true);
      xmlhttp.send();

    }
    function settings() {
      if (window.XMLHttpRequest) {
        // code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp = new XMLHttpRequest();
      } else {
        // code for IE6, IE5
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
      }
      xmlhttp.onreadystatechange = function() {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
          document.getElementById("feeds").innerHTML = xmlhttp.responseText;
          toggleDropDown();
        }
      };
      xmlhttp.open("GET", "/{{ $user->username }}/timeline-settings", true);
      xmlhttp.send();

    }


    const toggleDropDown = ()=>{
      const categories = document.querySelectorAll('.category');
      
      categories.forEach(category=>{
        const categoryBtn = document.querySelector('.'+category.getAttribute('id')+' .arrow')
          $('#'+category.getAttribute('id')).on('shown.bs.collapse', ()=> {
            categoryBtn.classList.add('fa-chevron-up')
            categoryBtn.classList.remove('fa-chevron-down')
        });

        $('#'+category.getAttribute('id')).on('hidden.bs.collapse', ()=> {
            categoryBtn.classList.add('fa-chevron-down')
            categoryBtn.classList.remove('fa-chevron-up')
        });
       
      })
    }
  </script>




  @endsection
