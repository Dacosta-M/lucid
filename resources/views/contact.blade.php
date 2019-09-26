@extends('layouts.lucid')
@section('title')
  Contact - {{ $user->name }} - Lucid
@endsection
@php
$location= 'contact';
@endphp
@section('sidebar')
@parent
@endsection
@section('content')
<!-- Beginning of contact page -->

<!-- Beginning of Post Content -->
<style>
  .form-control{
    outline: 0px !important;
    -webkit-appearance: none;
    box-shadow: none !important;
  }

.standard-color{
  background: #871e99;
  color:#fff;
  border:1px solid #871e99;
}

.standard-color:hover{
  background: #871e99 !important;
  color:#fff;
  border:1px solid #871e99 !important;
}

.text-danger{
  font-weight:400px !important;
  font-size:12px !important;

}
</style>

<div class="container">
    @if(Auth::user() && Auth::user()->username == $user->username)

    <form class="font-weight-bold mb-0 editContactForm" autocomplete="OFF" method="post" id="formFields" action="">
        <div class="form-group row">
            <div class="col-sm-12 col-md-10">
                <div class="d-flex justify-content-between">
                <label for="email" class="mb-2 mr-sm-2 d-block">Contact Email</label>
                <button id="edit-button" type="button" class="btn mb-2 text-secondary btn-border-secondary col-3">Edit</button>
                </div>
                <hr class="mt-0">
                <input type="email" class="form-control mb-2 mr-sm-2" id="email" placeholder="Enter Email" name="email"
                value="@if($contact) {{ $contact->email   }} @else {{ Auth::user()->email }} @endif " disabled>
                <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                <span class="text-danger" id="emailError" style="display:none;"></span>
            </div>
        </div>
        <div class="form-group row mt-4">
          <div class="col-sm-12 col-md-10">
          <label for="message">Display Text</label>
        <textarea name="message" id="message" rows="5" class="form-control" placeholder="Enter Display Text" disabled>@if($contact){{ $contact->display_message }}@endif</textarea>
        <span class="text-danger" id="msgError" style="display:none;"></span>
        <button type="submit" name="editContactDetails" id="saveBtn" class="btn bg-alt text-white col-sm-12 col-md-3 mt-5 d-none">Save</button>
          </div>
        </div>
    </form>

    @else
    <h4 class="font-weight-bold mb-4" style="text-transform:capitalize;">Contact {{ $user->name }}</h4>
    <p>
        @if($contact) {{ $contact->display_message  }} @endif
    </p>
    <form class="font-weight-bold mt-4 mb-0 contact-form" autocomplete="OFF" id="formFields" method="post" action="">
        <div class="form-group">
            <div class="col-sm-12 col-md-8">
                <label for="name" class="mb-2 mr-sm-2"><i class="fas fa-user text-secondary mr-2"></i> Name *</label>
                <input type="text" class="form-control mb-2 mr-sm-2" id="name"  placeholder="Enter Name" name="name">
                <span class="text-danger" id="nameError" style="display:none;"></span>
            </div>
        </div>
        <div class="form-group">
          <div class="col-sm-12 col-md-8">
            <label for="email" class="mb-2 mr-sm-2"><i class="fas fa-envelope text-secondary mr-2"></i> Email *</label>
            <input type="email" class="form-control mb-2 mr-sm-2" id="email" placeholder="Enter Email" name="email">
            <span class="text-danger" id="emailError" style="display:none;"></span>
          </div>
        </div>
        <div class="form-group">
          <div class="col-sm-12 col-md-8">
            <label for="subject" class="mb-2 mr-sm-2"><i class="fas fa-align-justify text-secondary mr-2"></i> Subject *</label>
            <input type="text" class="form-control mb-2 mr-sm-2" name="subject" id="subject" placeholder="Purpose of Email">
            <span class="text-danger" id="subjectError" style="display:none;"></span>
          </div>
        </div>
        <div class="form-group mt-4 col-md-8 col-sm-12">
        <label for="message">Message *</label>

        <textarea name="message" id="message" rows="5" class="form-control" placeholder="Enter Message"></textarea>
        <span class="text-danger" id="msgError" style="display:none;"></span>
        <button type="submit" name="sendMail" class="btn bg-alt text-white col-sm-12 col-md-12 mt-5" id="sendEmailBtn"> <i class="fas fa-paper-plane mr-2"></i> Send Message</button>
        </div>
        <p class="ml-5">* Required fields</p>
    </form>
    @endif


</div>
<!-- End of contact page -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
@if($isLocal)
<script src="{{ asset('js/contact.js') }}"></script>
<script src="{{ asset('js/edit-contact-details.js') }}"></script>
<script src="{{ asset('js/edit-contact-logic.js') }}"></script>
@else
<script src="{{ secure_asset('js/contact.js') }}"></script>
<script src="{{ secure_asset('js/edit-contact-details.js') }}"></script>
<script src="{{ secure_asset('js/edit-contact-logic.js') }}"></script>
@endif
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>


@endsection
