@extends('layouts.lucid')
@section('title')
{{ $user->name }} - Lucid
@endsection
@php
$location= 'settings';
@endphp
@section('sidebar')
@parent
@endsection
@section('content')
<style>
  .form-control {
    outline: 0px !important;
    -webkit-appearance: none;
    box-shadow: none !important;
  }

  .standard-color {
    background: #871e99;
    color: #fff;
    border: 1px solid #871e99;
  }

  .standard-color:hover {
    background: #871e99 !important;
    color: #fff;
    border: 1px solid #871e99 !important;
  }

  .text-danger {
    font-weight: 400px !important;
    font-size: 12px !important;

  }
</style>
<!-- beginning of settings page -->
<div class="page-tab">
  <!-- tab navigation here -->
  <h4><strong>Settings</strong></h4>
  <ul class="nav nav-tabs navbar-light" id="settings-tabs" role="tablist">
    <li class="nav-item">
      <a href="#profile" class="nav-link tab-link active" id="profile-tab" data-toggle="tab" role="tab" aria-controls="profile" aria-selected="true">
        <h6>Profile</h6>
      </a>
    </li>
    <li class="nav-item">
      <a href="#account" class="nav-link tab-link" id="account-tab" data-toggle="tab" role="tab" aria-controls="account" aria-selected="false">
        <h6>Account</h6>
      </a>
    </li>
    <li class="nav-item">
      <a href="#links" class="nav-link tab-link" id="links-tab" data-toggle="tab" role="tab" aria-controls="links" aria-selected="false">
        <h6>Links</h6>
      </a>
    </li>
    <li class="nav-item">
      <a href="#security" class="nav-link tab-link" id="security-tab" data-toggle="tab" role="tab" aria-controls="links" aria-selected="false">
        <h6>Security</h6>
      </a>
    </li>
  </ul>
  <!-- tab content here -->
  <div class="tab-content" id="settings-tabs-content">
    <!-- profile settings tab -->
    <div class="tab-pane fade in show active" id="profile" role="tabpanel">
      <form action="" class="mt-4" autocomplete="off" id="settingsForm">
        <div class="row">
          <div class="form-group col-sm-12 col-md-6">
            <label for="name"><strong>Full Name</strong></label>
            <input class="form-control" type="text" name="name" id="name" value="{{Auth::user()->name}}" placeholder="e.g Jon Champion" />
            <span class="text-danger" id="fullname" style="display:none;"></span>
          </div>
          <div class="form-group col-sm-12 col-md-6">
            <label for="email"><strong>Email Address</strong></label>
            <input type="email" name="email" id="email" class="form-control" value="{{Auth::user()->email}}" placeholder="example@gmail.com" />
            <span class="text-danger" id="emailError" style="display:none;"></span>
          </div>
        </div>
        <div class="row">
          <div class="form-group col-sm-12 col-md-6 pb-0 mb-0">
            <label for="nick-name"><strong>Username</strong></label>
            <input class="form-control" type="text" name="username" id="nick-name" value="{{Auth::user()->username}}" />
            <span class="text-danger" id="usernameError" style="display:none;"></span>
          </div>
          <div class="form-group col-sm-12 col-md-6 pb-0 mb-0">
            <p class="font-weight-bold">Profile Image</p>
            <div class="d-flex">
              <div class="d-inline-block">
                <img src="{{Auth::user()->image}}" class="img-thumb" alt="user" id="imgtag" />
              </div>
              <div class="d-inline-block ml-3 py-2">
                <input type="file" name="profileimage" id="profileimage" class="form-control-file" accept=".png,.jpg" style="display:none">

                <label class="text-muted form-control p-2 w-100" for="profileimage" style="cursor:pointer">Choose file</label>

                <input type="hidden" name="user_id" value="{{Auth::user()->id}}" />
                <span class="text-danger" id="imgError" style="display:none;"></span>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="form-group col-sm-12 col-md-6 mt-0 pb-0">
            <label for="bio"><strong>Short Bio</strong></label>
            <textarea name="bio" id="bio" class="form-control" rows="3" placeholder="type here..">{{Auth::user()->short_bio}}</textarea>
          </div>
        </div>
        <!-- submit button -->
        <button type="submit" class="btn col-sm-12 col-md-3 mt-3" name="update">Update Profile</button>
      </form>
    </div>

    <!-- account tab -->
    <div class="tab-pane fade" id="account" role="tabpanel">
      <h3 class="mt-5">Account Settings</h3>
      <div class="form-group col-sm-12 col-md-6 pb-0 mb-0">



<form action="#" class="mt-4" name="AccountForm" autocomplete="off" id="AccountForm">
        <div class="form-group">
    <label for="Link" class="form-label">Your Lucid Url</label>

      <input type="url" readonly class="form-control-plaintext" id="Link" value="{{secure_url('/').'/'.Auth::user()->username}}">

  </div>

  <div class="form-group">
<label for="theme" class="form-label">Installed Theme</label>
<input type="text" readonly class="form-control-plaintext" id="theme" value="Default">
</div>
<div class="form-group">
<label for="View" class="form-label">Preferred View</label>

  <div class="form-group">
     <select class="custom-select" name="view" required>
       <option value="">Select View</option>
       <option @if($set->view == "timeline") selected @endif value="timeline">Timeline</option>
       <option @if($set->view == "post") selected @endif value="post">Post</option>
       <option @if($set->view == "thoughts") selected @endif value="thoughts">Thoughts</option>
     </select>
   </div>

</div>
<div class="form-group">
<label for="View" class="form-label">Guest Preferred View</label>

  <div class="form-group">
     <select class="custom-select" name="pubView" required>
       <option value="">Select View</option>
       <option @if($set->public_view == "home") selected @endif value="home">Home</option>
       <option @if($set->public_view == "thoughts") selected @endif value="thoughts">Thoughts</option>
     </select>
   </div>

</div>

        <div class="custom-control custom-switch">
          <input type="checkbox" class="custom-control-input" @if(isset($tabs) && in_array("Technology", $tabs)) checked @endif name="tags[]" value="Technology"  id="Technology">
          <label class="custom-control-label" for="Technology">Technology</label>
          </div>
       <div class="custom-control custom-switch">
         <input type="checkbox" class="custom-control-input" @if(isset($tabs) && in_array("Entertainment", $tabs)) checked @endif name="tags[]" value="Entertainment"  id="Entertainment">
         <label class="custom-control-label" for="Entertainment">Entertainment</label>
          </div>
         <div class="custom-control custom-switch">

           <input type="checkbox" class="custom-control-input" @if(isset($tabs) && in_array("Blog", $tabs)) checked @endif name="tags[]" value="Blog"  id="Blog">
           <label class="custom-control-label" for="Blog">Blog</label>
           </div>
       <div class="custom-control custom-switch">
          <input type="checkbox" class="custom-control-input" @if(isset($tabs) && in_array("Health", $tabs)) checked @endif name="tags[]" value="Health"  id="Health">
          <label class="custom-control-label" for="Health">Health</label>
          </div>
      <div class="custom-control custom-switch">

         <input type="checkbox" class="custom-control-input" name="tags[]"  @if(isset($tabs) && in_array("Lifestyle", $tabs )) checked @endif value="Lifestyle"  id="Lifestyle">
         <label class="custom-control-label" for="Lifestyle">Lifestyle</label>
         </div>
      <div class="custom-control custom-switch">
        <input type="checkbox" class="custom-control-input"  @if(isset($tabs) && in_array("Gist", $tabs)) checked @endif name="tags[]" value="Gist"  id="Gist">
        <label class="custom-control-label" for="Gist">Gist</label>
        </div>
        <div class="custom-control custom-switch">
       <input type="checkbox" class="custom-control-input"  @if(isset($tabs) && in_array("Politics", $tabs)) checked @endif name="tags[]" value="Politics"  id="Politics">
        <label class="custom-control-label" for="Politics">Politics</label>
        </div>
        </div>



        <button type="submit" class="btn col-sm-12 col-md-3 mt-3" name="updateAccount">Update Account</button>

      </form>
</div>
    </div>
    <!-- links tab -->
    <div class="tab-pane fade" id="links" role="tabpanel">
      <div class="mt-3">
      <!--
        <button class="btn border d-block my-4 w-50 text-light" style="background-color: #1da1f2;"><i class="icon ion-logo-twitter"></i> Connect to Twitter</button>
        <button class="btn border d-block my-4 w-50 text-white" style="background-color: #3b5998;"><i class="icon ion-logo-facebook"></i> Connect to Facebook</button>
        <button class="btn border d-block my-4 w-50 text-white" style="background-color: #c13584;"><i class="icon ion-logo-instagram"></i> Connect to Instagram</button>
        <button class="btn border d-block my-4 w-50 text-white" style="background-color: #0077b5;"><i class="icon ion-logo-linkedin"></i> Connect to LinkedIn</button>
      -->
      </div>
  </div>
  <!-- security tab -->
  <div class="tab-pane fade" id="security" role="tabpanel">
    <h3 class="mt-5">Security page coming soon...</h3>
  </div>
</div>
</div>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<!-- convert to markdown script ends -->
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script>
const link = "@if($isLocal){{ url($user->username.'/account_settings')  }}@else{{ secure_url($user->username.'/account_settings')  }}@endif"

document.querySelector('button[name="updateAccount"]').addEventListener('click',function (event){
  event.preventDefault();
  const formData = document.AccountForm;
 var myform = $(formData).serialize();
//console.log(myform);

  j.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': j('meta[name="csrf-token"]').attr('content')
        }
    });

  j.ajax({
        type: "POST",
        url : link,
        data:myform,
        beforeSend:function(){
          document.querySelector('button[name="updateAccount"]').innerHTML = 'Saving changes...';
        },
        success : function (response) {
          document.querySelector('button[name="updateAccount"]').innerHTML = 'Update Account';
        }
      });
    });
</script>
@if($isLocal)
<script src="{{ asset('js/settings.js') }}"></script>
@else
<script src="{{ secure_asset('js/settings.js') }}"></script>
@endif
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>


@endsection
