@forelse($categories as $category)
<div class="mt-4">
            <h5 class="border-bottom pb-2 w-100 px-2">{{ $category }}</h5>
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
@empty
@endforelse