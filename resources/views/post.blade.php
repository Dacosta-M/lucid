@extends('layouts.lucid')
@section('title')
{{ $user->name }} - Lucid
@endsection
@php
$location= 'post';
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
    background-color: #871e99 !important;
    border: 1px solid #871e99;
    padding: 6px 5px;
    color: #fff;
  }

  .main-content {
    padding-top: 30px;
    padding-bottom: 30px;
  }

  .btn-info {
    background-color: #871e99 !important;
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
    background: #871e99;
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
    background-color: #871e99 !important;
    border-color: #871e99 !important;
  }

  .btn-outline-primary {
    color: #871e99 !important;
    border-color: #871e99 !important;
  }

  .btn-outline-primary:hover {
    color: #fff !important;
    background-color: #871e99 !important;
    border-color: #871e99 !important;
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
    color: #871e99;
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

  .tokenfield .token.standardColor {
    background: #871e99;
    color: #fff;
    padding-bottom: 23px;
  }

  .tokenfield {
    padding: 7px;
  }
</style>
<!-- The editor code goes here -->
@if(Auth::user()->username == $user->username)
<div id="form-container">
  <form method="POST" class="timeline-editor" id="editor-form" autocomplete="OFF">
    <div class=" row pb-3">
      <div class="col-12">
        <div class="white-background mb-3">
          <div class="row pb-2">
            <div class="col-12">
              <div class="row form-group">
                <div class="col-12 mb-3" id="titleBox">
                  <label for="new-post-title" class="sr-only">Title</label>
                  <input type="text" id="new-post-title" class="form-control" placeholder="Title" />
                </div>
                <div class="col-12">
                  <div id="editor">
                    <input type="text" name="body">
                  </div>
                </div>

              </div>
            </div>
          </div>
          <div class="row mt-5">
            <div class="col-12">
              <div class="row">
                <div class="col-12 collapse" id="collapseExample">
                  <div class="form-group">
                    <input type="text" name="tags" id="tags" class="form-control" placeholder="Add">
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-12 mt-3">
        <div class="row form-row flex-row-reverse">
          <!-- <div class="col-3 col-sm-3 col-md-2">
            <input type="button" class="form-control btn-sm btn btn-primary save-draft" value="Save Draft" />
          </div> -->
          <div class="col-3 col-sm-3 col-md-2">
            <input type="submit" class="form-control btn-sm btn btn-primary publish-post" value="Publish">
            <input type="hidden" class="form-control btn-sm btn btn-primary publish-post" value="Save Draft">
          </div>
          <div class="col-3 col-sm-3 col-md-2">
            <input class="form-control btn-sm btn btn-primary add-tags" type="button" data-toggle="collapse" data-target="  #collapseExample" aria-expanded="false" aria-controls="collapseExample" value="Add Tags">
          </div>
        </div>
      </div>
    </div>
    <!-- <div class="row pt-2">

      </div> -->
  </form>
</div>
<!-- Beginning of Post Content -->
@endif

@forelse($posts as $post)


<div class="post-content">
  @if($post['image'] !== '')
  <div class="post-image d-none d-lg-flex d-xl-flex d-md-flex">
    <img src="{{$post['image']}}" class="img-fluid post-img" alt="What I think of Donald Glover’s New Video" />
  </div>
  @endif
  <div class="post-content-body row">
<div class="col-10">
<p class="post-date">{{ $post['date'] }}</p>
    <h3 class="post-title">
      <a class="no-decoration text-dark" href="post/{{$post['slug']}}">{!! $post['title'] !!}</a>
    </h3>
    <p class="post-body">
      @php
      echo strip_tags($post['body'])
      @endphp
    </p>
</div>
    <div class="col-2">
      <a href="" class="mr-4 text-dark" data-toggle="modal" data-target="#editModal"><i class="icon ion-md-create" style="font-size: 1.5em"></i></a>
      <a href="" class="text-dark" onclick="deletePost({{$post['id']}})" data-toggle="modal" data-target="#deleteModal"><i class="icon ion-md-trash" style="font-size: 1.5em"></i></a>
    </div>
  </div>


</div>


<div class="text-center">
  <!--   <button class="btn btn-primary pagination">
    Previous articles <i class="pl-2 icon ion-ios-arrow-forward"></i>
  </button> -->
</div>


@empty

<div class="post-content">
  <div class="post-content-body">
    no posts yet
  </div>
</div>

@endforelse

<!--
<form>
  <div class="row">
    <div class="col-12">

    </div>
  </div>
</form>
-->


<!-- Edit Modal -->
<div class="modal fade text-center" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-body">
          <form method="POST" action="" class="mt-3">
            @csrf
            <div class="form-group">
              <label class="sr-only">Title</label>
              <input type="text" class="form-control" value="Placeholder" />
            </div>
            <div class="form-group">
              <label class="sr-only">Text</label>
              <input type="text" class="form-control" name="body" value="Placeholder">
            </div>
            <div class="row form-row flex-row-reverse">
              <div class="col-3 col-sm-3 col-md-2">
                <input type="submit" class="form-control btn-sm btn btn-primary publish-post" value="Save">
              </div>
              <div class="col-3 col-sm-3 col-md-2">
                <input class="form-control btn-sm btn btn-primary add-tags" type="button" data-toggle="collapse" data-target="  #collapseExample" aria-expanded="false" aria-controls="collapseExample" value="Add Tags">
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
  <!-- End Edit Modal  -->

  <!-- Delete Modal -->
  <div class="modal fade text-center" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-body">
          <div>
            <h4 class="text-main mb-0"> Are you sure you want to delete this post?</h4>
            <small class="text-muted mt-0"><em>This action is irreversible</em></small>
            <form method="get" action="" class="mt-3 delete-form">
              @csrf
              <button type="submit" class="btn btn-danger" name="delete">Delete</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- End Delete Modal  -->

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

<script src="https://cdn.quilljs.com/1.3.4/quill.js"></script>
<!-- Convert to markdown script -->
<script src="https://unpkg.com/turndown/dist/turndown.js"></script>
<script src="https://unpkg.com/turndown-plugin-gfm/dist/turndown-plugin-gfm.js"></script>
<!-- convert to markdown script ends -->
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tokenfield/0.12.0/bootstrap-tokenfield.min.js"></script>
<script src="{{ asset('js/posts.js') }}" type="text/javascript"></script>
<script>
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
<script>

</script>

@endsection
