<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous" />
  <link href="https://unpkg.com/ionicons@4.5.9-1/dist/css/ionicons.min.css" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css?family=Roboto:400,500,700&display=swap" rel="stylesheet" />
  <link rel="short icon" type="image/png" sizes="16x16" href="{{ secure_asset('img/luci-logo.png') }}">
  <link href="{{ secure_asset('css/style.css') }}" rel="stylesheet">
  <link href="{{ secure_asset('css/main-style.css') }}" rel="stylesheet">
  <link href="{{ secure_asset('css/tabletcss.css') }}" rel="stylesheet">
  <title>Explore</title>

  <style>
    .grid {
      display: grid;
    }

    .drop {
      width: 120px;
      text-transform: capitalize;
      right: 5%;
      position: absolute;
    }
  </style>
</head>

<body>
  <div class="container">
    <!-- Beginning of Navbar -->
    <div class="pt-2 text-right">
      <small>Have an account? <a class="text-secondary font-weight-bold" href="/login">Sign in</a> or <a class="text-secondary font-weight-bold" href="/register">Sign Up</a></small>
    </div>
    <!-- End of Navbar -->
    <div>
      <h4 class="ml-4 mb-3 pl-1">Explore Lucid</h4>
      <!-- Begin content -->
      <!-- Posts Page -->

      <div class="row mx-3">
        <div class="col-xs-12 col-md-8">
          <!-- Technology section -->
          <div class="mt-4">
            <h5 class="border-bottom pb-2 w-100 px-2">Technology</h5>
            <div class="row no-gutters">
              <div class="col-4 col-md-2 text-center">
                <img src="{{ secure_asset('img/mb-1.png') }}" class="img-fluid" alt="user" />
                <small><a href="" class="d-block mb-0 text-main font-weight-bold">Angel Roberts</a></small>
                <small>
                  <p>2k Followers</p>
                </small>
              </div>
              <div class="col-4 col-md-2 text-center">
                <img src="{{ secure_asset('img/mb-2.png') }}" class="img-fluid" alt="user" />
                <small><a href="" class="d-block mb-0 text-main font-weight-bold">Angel Roberts</a></small>
                <small>
                  <p>2k Followers</p>
                </small>
              </div>
              <div class="col-4 col-md-2 text-center">
                <img src="{{ secure_asset('img/mb-3.png') }}" class="img-fluid" alt="user" />
                <small><a href="" class="d-block mb-0 text-main font-weight-bold">Angel Roberts</a></small>
                <small>
                  <p>2k Followers</p>
                </small>
              </div>
              <a href="" class="mx-4 my-3"><i class="icon ion-md-arrow-dropright-circle text-secondary" style="font-size: 30px;"></i></a> 
            </div>
            <h5 class="mt-4 mb-3">Most popular Technology posts in Nigeria</h5>
            <div class="post-content">
              <div class="post-image d-none d-md-flex">
                <img src="{{ secure_asset('img/technology.png') }}" class="img-fluid post-img" alt="image" />
              </div>
              <div class="post-content-body row">
                <div class="">
                  <h5>
                    <a class="no-decoration text-dark" href="">What Is Rust Doing Behind the Curtains?</a>
                  </h5>
                  <p class="post-body">
                    Rust allows for a lot of syntactic sugar, that makes it a pleasure to write. It is sometimes hard, however, to look behind the curtain and see what the compiler is really doing with our code.
                  </p>
                  <small>Angel Roberts</small>
                </div>
              </div>
            </div>
            <div class="post-content pb-3">
              <div class="post-image d-none d-md-flex">
                <img src="{{ secure_asset('img/technology.png') }}" class="img-fluid post-img" alt="image" />
              </div>
              <div class="post-content-body row">
                <div class="">
                  <h5>
                    <a class="no-decoration text-dark" href="">What Is Rust Doing Behind the Curtains?</a>
                  </h5>
                  <p class="post-body">
                    Rust allows for a lot of syntactic sugar, that makes it a pleasure to write. It is sometimes hard, however, to look behind the curtain and see what the compiler is really doing with our code.
                  </p>
                  <small>Angel Roberts</small>
                </div>
              </div>
            </div>
            <a href="" class="text-secondary font-weight-bold pb-3">Show more ></a>
          </div>
          <!-- End Technology section -->

          <!-- Start Politics -->
          <div class="mt-5">
            <h5 class="border-bottom pb-2 w-100 px-2">Politics</h5>
            <div class="row no-gutters">
              <div class="col-4 col-md-2 text-center">
                <img src="{{ secure_asset('img/mb-1.png') }}" class="img-fluid" alt="user" />
                <small><a href="" class="d-block mb-0 text-main font-weight-bold">Angel Roberts</a></small>
                <small>
                  <p>2k Followers</p>
                </small>
              </div>
              <div class="col-4 col-md-2 text-center">
                <img src="{{ secure_asset('img/mb-2.png') }}" class="img-fluid" alt="user" />
                <small><a href="" class="d-block mb-0 text-main font-weight-bold">Angel Roberts</a></small>
                <small>
                  <p>2k Followers</p>
                </small>
              </div>
              <div class="col-4 col-md-2 text-center">
                <img src="{{ secure_asset('img/mb-3.png') }}" class="img-fluid" alt="user" />
                <small><a href="" class="d-block mb-0 text-main font-weight-bold">Angel Roberts</a></small>
                <small>
                  <p>2k Followers</p>
                </small>
              </div>
              <a href="" class="mx-4 my-3"><i class="icon ion-md-arrow-dropright-circle text-secondary" style="font-size: 30px;"></i></a> 
            </div>
            <h5 class="mt-4 mb-3">Most popular Politics posts in Nigeria</h5>
            <div class="post-content">
              <div class="post-image d-none d-md-flex">
                <img src="{{ secure_asset('img/politics.png') }}" class="img-fluid post-img" alt="image" />
              </div>
              <div class="post-content-body row">
                <div class="">
                  <h5>
                    <a class="no-decoration text-dark" href="">What Is Rust Doing Behind the Curtains?</a>
                  </h5>
                  <p class="post-body">
                    Rust allows for a lot of syntactic sugar, that makes it a pleasure to write. It is sometimes hard, however, to look behind the curtain and see what the compiler is really doing with our code.
                  </p>
                  <small>Angel Roberts</small>
                </div>
              </div>
            </div>
            <div class="post-content pb-3">
              <div class="post-image d-none d-md-flex">
                <img src="{{ secure_asset('img/politics.png') }}" class="img-fluid post-img" alt="image" />
              </div>
              <div class="post-content-body row">
                <div class="">
                  <h5>
                    <a class="no-decoration text-dark" href="">What Is Rust Doing Behind the Curtains?</a>
                  </h5>
                  <p class="post-body">
                    Rust allows for a lot of syntactic sugar, that makes it a pleasure to write. It is sometimes hard, however, to look behind the curtain and see what the compiler is really doing with our code.
                  </p>
                  <small>Angel Roberts</small>
                </div>
              </div>
            </div>
            <a href="" class="text-secondary font-weight-bold pb-3">Show more ></a>
          </div>
          <!-- End Politics section -->

          <!-- Start Health Section -->
          <div class="mt-5">
            <h5 class="border-bottom pb-2 w-100 px-2">Health</h5>
            <div class="row no-gutters">
              <div class="col-4 col-md-2 text-center">
                <img src="{{ secure_asset('img/mb-1.png') }}" class="img-fluid" alt="user" />
                <small><a href="" class="d-block mb-0 text-main font-weight-bold">Angel Roberts</a></small>
                <small>
                  <p>2k Followers</p>
                </small>
              </div>
              <div class="col-4 col-md-2 text-center">
                <img src="{{ secure_asset('img/mb-2.png') }}" class="img-fluid" alt="user" />
                <small><a href="" class="d-block mb-0 text-main font-weight-bold">Angel Roberts</a></small>
                <small>
                  <p>2k Followers</p>
                </small>
              </div>
              <div class="col-4 col-md-2 text-center">
                <img src="{{ secure_asset('img/mb-3.png') }}" class="img-fluid" alt="user" />
                <small><a href="" class="d-block mb-0 text-main font-weight-bold">Angel Roberts</a></small>
                <small>
                  <p>2k Followers</p>
                </small>
              </div>
              <a href="" class="mx-4 my-3"><i class="icon ion-md-arrow-dropright-circle text-secondary" style="font-size: 30px;"></i></a> 
            </div>
            <h5 class="mt-4 mb-3">Most popular Health posts in Nigeria</h5>
            <div class="post-content">
              <div class="post-image d-none d-md-flex">
                <img src="{{ secure_asset('img/health.png') }}" class="img-fluid post-img" alt="image" />
              </div>
              <div class="post-content-body row">
                <div class="">
                  <h5>
                    <a class="no-decoration text-dark" href="">What Is Rust Doing Behind the Curtains?</a>
                  </h5>
                  <p class="post-body">
                    Rust allows for a lot of syntactic sugar, that makes it a pleasure to write. It is sometimes hard, however, to look behind the curtain and see what the compiler is really doing with our code.
                  </p>
                  <small>Angel Roberts</small>
                </div>
              </div>
            </div>
            <div class="post-content pb-3">
              <div class="post-image d-none d-md-flex">
                <img src="{{ secure_asset('img/health.png') }}" class="img-fluid post-img" alt="image" />
              </div>
              <div class="post-content-body row">
                <div class="">
                  <h5>
                    <a class="no-decoration text-dark" href="">What Is Rust Doing Behind the Curtains?</a>
                  </h5>
                  <p class="post-body">
                    Rust allows for a lot of syntactic sugar, that makes it a pleasure to write. It is sometimes hard, however, to look behind the curtain and see what the compiler is really doing with our code.
                  </p>
                  <small>Angel Roberts</small>
                </div>
              </div>
            </div>
            <a href="" class="text-secondary font-weight-bold pb-3">Show more ></a>
          </div>

          <!-- End Health section -->
        </div>

        <div class="col-xs-12 col-md-4 bg-light h-100 mt-4 mb-3 mt-md-0 mb-md-0">
          <div class="form-group border-bottom mt-2 pb-3">
            <label for="country" class="font-weight-bold">
              <h5>Country</h5>
            </label>
            <select id="country" class="form-control w-100">
              <option selected>Nigeria</option>
              <option>Canada</option>
              <option>USA</option>
              <option>UK</option>
            </select>
          </div>
          <div class="form-group border-bottom mt-3 pb-2">
            <label for="categories" class="font-weight-bold">
              <h5>Categories</h5>
            </label>
            <div class="form-check">
              <input class="form-check-input" type="checkbox" value="" id="politics">
              <label class="form-check-label" for="politics">
                Politics
              </label>
            </div>
            <div class="form-check">
              <input class="form-check-input" type="checkbox" value="" id="sports">
              <label class="form-check-label" for="sports">
                Sports
              </label>
            </div>
            <div class="form-check">
              <input class="form-check-input" type="checkbox" value="" id="health">
              <label class="form-check-label" for="health">
                Health
              </label>
            </div>
            <div class="form-check">
              <input class="form-check-input" type="checkbox" value="" id="technology">
              <label class="form-check-label" for="technology">
                Technology
              </label>
            </div>
            <div class="form-check">
              <input class="form-check-input" type="checkbox" value="" id="music">
              <label class="form-check-label" for="mucis">
                Music
              </label>
            </div>
            <div class="form-check">
              <input class="form-check-input" type="checkbox" value="" id="lifestyle">
              <label class="form-check-label" for="lifestyle">
                Lifestyle
              </label>
            </div>
            <div class="form-check">
              <input class="form-check-input" type="checkbox" value="" id="fitness">
              <label class="form-check-label" for="fitness">
                Fitness
              </label>
            </div>
          </div>
          <div class="form-group my-3">
            <label for="hastags" class="font-weight-bold">
              <h5>hastags</h5>
            </label>
            <a href="" class="d-block text-dark">#wizkid</a>
            <a href="" class="d-block text-dark">#dmxchallenge</a>
            <a href="" class="d-block text-dark">#bbnaija</a>
            <a href="" class="d-block text-dark">#hotelsng</a>
            <a href="" class="d-block text-dark">#php</a>
            <a href="" class="d-block text-dark">#opay</a>
            <a href="" class="d-block text-dark">#gokada</a>
          </div>
        @empty
        @endforelse
          
        </div>
      </div>
      <!-- End Posts page -->


      <!--   Old Posts content
    <div class="tab-pane" role="tabpanel" id="page">
      <div class="row mx-3">
        <div class="col-xs-12 col-md-8 grid">
          <select onchange="filter()" name="" id="sortMethod" class="float-right form-control drop">
            <option value="Recent">
              recent
            </option>
            <option value="Popular">
              popular
            </option>
          </select>
          <div class="post mt-5" id="posts"></div>
        </div>
        <div class="col-xs-12 col-md-4 bg-light" style="height: 30vh;">
          <p class="font-weight-bold">Popular Topics</p>
        </div>
      </div>
    </div> -->
      <!-- End Posts page -->
    </div>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

    {{-- <script>
    const j = jQuery.noConflict();
     j(document).ready(function (){
        const check = "{{ secure_url('notif',['username'=>$user->username])  }}"
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
    // console.log(data);

    if(data.unseen_notification > 0)
    {
    j('.count').html(data.unseen_notification);
    }


    })
    .catch(function(err) {
    //console.log('Fetch Error :-S', err);
    });
    }
    const view_notif = "{{ secure_url('getNotif',['username'=>$user->username])  }}"

    view = "";
    j.ajax({
    url:view_notif,
    method:"Get",
    data:{view:view},
    dataType:"json",
    })
    .then (
    function(data) {
    // console.log(data);
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

    </script> --}}
    <script>
      const j = jQuery.noConflict();

      function filter() {
        j.ajaxSetup({
          headers: {
            'X-CSRF-TOKEN': j('meta[name="csrf-token"]').attr('content')
          }
        });
        const selectedMethod = document.getElementById('sortMethod').value;
        j.ajax({
          type: "GET",
          url: "/filter/" + selectedMethod,
          success: function(data) {
            j("#posts").html(data);
          },

        });
      }
      j(document).ready(function() {
        j.ajaxSetup({
          headers: {
            'X-CSRF-TOKEN': j('meta[name="csrf-token"]').attr('content')
          }
        });
        j.ajax({
          type: "GET",
          url: "/filter/Recent",
          success: function(data) {
            j("#posts").html(data);
          },

        });
      })
    </script>
</body>

</html>