
@forelse($categories as $category)
<div class="mt-4">
            <h5 class="border-bottom pb-2 w-100 px-2" style="text-transform:capitalize;">{{ $category }}</h5>
            <div class="row no-gutters">
            @php 
            $userArray = [];
            foreach($users as $user){
              $tags = explode(',',$user->tags);
              $tags = array_filter(array_map('trim',$tags));
              $tags = array_filter(array_map('strtolower',$tags));
              if(in_array(strtolower($category), $tags)) {
                $userArray[] = array('username'=>$user->username,'image'=>$user->image);
              }}
            @endphp
            @foreach(array_unique($userArray,SORT_REGULAR) as $user)
              <div class="col-4 col-md-2 text-center">
                <img src="{{  $user['image'] }}" class="img-fluid" style="border-radius:50%;object-fit:cover;" alt="user" width="55" height="56"/>
               
                <small><a href="{{ $user['username'] }}" class="d-block mb-0 text-main font-weight-bold">{{ $user['username'] }}</a></small>
               
                <small>
                  <p>2k Followers</p>
                </small>
              </div>
            @endforeach
              
              
              <a href="" class="mx-4 my-3"><i class="icon ion-md-arrow-dropright-circle text-secondary" style="font-size: 30px;"></i></a> 
            </div>
            <h5 class="mt-4 mb-3" style="text-transform:capitalize;">Most popular {{ $category }} posts</h5>
            @php 
            foreach($posts as $post) {
              $tags = explode(',',$post->tags);
              $tags = array_filter(array_map('trim',$tags));
              $tags = array_filter(array_map('strtolower',$tags));
              if(in_array(strtolower($category), $tags)) {
                $parsedown  = new Parsedown();
                $postContent = $parsedown->text($post->content);
                preg_match('/<img[^>]+src="((\/|\w|-)+\.[a-z]+)"[^>]*\>/i', $postContent, $matches);
                $first_img = "";
                if (isset($matches[1])) {
                    // there are images
                    $first_img = $matches[1];
                    // strip all images from the text
                    $postContent = preg_replace("/<img[^>]+\>/i", " ", $postContent);
                }
            @endphp
              <div class="post-content">
              @if($first_img !=="")
                <div class="post-image d-none d-md-flex">
                  <img src="@php echo   $first_img @endphp" class="img-fluid post-img" alt="image" />
                </div>
              @endif
                <div class="post-content-body row">
                  <div class="">
                    <h5>
                      <a class="no-decoration text-dark" href="{{ route('post',['username'=>$post->username,'postTitle'=>$post->slug]) }}">@php echo $post->title; @endphp</a>
                    </h5>
                    <p class="post-body">
                     @php 
                      echo $pageController->trim_words($postContent, 200);
                     @endphp
                    </p>
                    <small>Angel Roberts</small>
                  </div>
                </div>
              </div>
             @php
              } 
            }
            @endphp
            <a href="" class="text-secondary font-weight-bold pb-3">Show more ></a>
          </div>
          <!-- End Technology section -->
@empty
@endforelse