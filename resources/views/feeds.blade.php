
        @foreach($posts as $feeds)

        <div class="post-content">
          <!--           @if (empty($feeds['site_image']))
              <img src="{{ secure_asset('img/logo.jpg') }}" class="img-fluid img-thumb" alt="user" />
              @else
              <img src="{{ $feeds['site_image']}}" class="img-fluid img-thumb" alt="user" />
              @endif -->
              @if ($feeds['tags'] == "RSS")
              @else
              @php
              $user = DB::table('users')->where('name',$feeds['site'])->first();
              $post = DB::table('posts')->where(['title' => $feeds['title'],'user_id' => $feeds['user_id']])->first();
              @endphp
              @endif
          <img src="{{$feeds['site_image']}}" class="timeline-img" alt="{{$feeds['site']}}" />
          <div class="post-content-body mb-0">
            <span class="text-muted">{{$feeds['tags']}}</span>
            @if ($feeds['tags'] == "RSS")
            <a href="{{$feeds['link']}}" class="no-decoration">
              <h5 class="font-weight-bold on-hover">{{$feeds['title']}}</h5>
            </a>
            @else
            <a href="@if($isLocal){{url('/')}}/{{$feeds['username'].$feeds['link']}} @else {{secure_url('/')}}/{{$feeds['username'].$feeds['link']}} @endif" class="no-decoration">
              <h5 class="font-weight-bold on-hover">{{$feeds['title']}}</h5>
            </a>
            @endif
            <p class="mb-1">
              {{$feeds['des']}}
            </p>
            <div class="row">
              @if ($feeds['tags'] == "RSS")
              @php
              $rss = DB::table('ext_rsses')->where("title","=",$feeds['site'])->first('link');
              @endphp
              <span class="col-12 col-sm-6 col-md-8">
                <small>
                <a href="{{$rss->link}}" class="text-muted">{{$feeds['site']}}</a>
                <span class="font-weight-bold">.</span>
                <span class="text-muted">{{$feeds['date']}}</span>
                </small>
              </span>
              @else
              <span class="col-12 col-sm-6 col-md-8">
                <small>
                <a href="@if($isLocal) {{url('/')}}/{{$user->username}} @else {{secure_url('/')}}/{{$user->username}}@endif" class="text-muted">{{$feeds['site']}}</a>
                <span class="font-weight-bold">.</span>
                <span class="text-muted">{{$feeds['date']}}</span>
                </small>
              </span>
              <span class="col-12 col-sm-6 col-md-4">
                @php
                $lcount = \Lucid\Notification::where(['post_id' => $post->id,'action' => "Like"])->count();
                $likes = \Lucid\Notification::where(['post_id' => $post->id, 'sender_id' => Auth::user()->id,'action' => "Like"])->first();
              //  dd($likes);
                @endphp
                @if(!empty($likes))
                <span id="like{{$feeds['id']}}">
                <button type='button' title='unlike this Post' onclick='like(0,{{$feeds["id"]}})' class='btn'><i class='fas fa-thumbs-up text-secondary' style='font-size: 1.2em;'></i>
                <sub id="lcount{{$feeds['id']}}">{{ $lcount }}</sub>
                </button></span>
                @else
                <span id="like{{$feeds['id']}}">
                  <button type="button" title="like this Post" onclick='like(1,{{ $feeds["id"] }})' class="btn">
                    <i class='fas fa-thumbs-up' style='font-size: 1.2em;'></i>
                    <sub id="lcount{{$feeds['id']}}">{{ $lcount }}</sub>
                  </button>
                </span>
                @endif

                @php
                $count = \Lucid\Notification::where(['post_id' => $post->id,'action' => "Love"])->count();
                $love = \Lucid\Notification::where(['post_id' => $post->id, 'sender_id' => Auth::user()->id,'action' => "Love"])->first();

                @endphp
                @if(!empty($love))
                <span id="love{{$feeds['id']}}">
                <button type='button' title='unlove this Post' onclick='love(0,{{$feeds["id"]}})' class='btn'>
                  <i class='fas fa-heart text-secondary' style="font-size: 1.2em;"></i>
                <sub id="count{{$feeds['id']}}">{{ $count }}</sub>
                </button></span>
                @else
                <span id="love{{$feeds['id']}}">
                  <button type="button" title="love this Post" onclick='love(1,{{ $feeds["id"] }})' class="btn">
                    <i class='fas fa-heart'style="font-size: 1.2em;"></i>
                    <sub id="count{{$feeds['id']}}">{{ $count }}</sub>
                  </button>
                </span>
                @endif
                @php
                $ccount = \Lucid\Notification::where(['post_id' => $post->id,'action' => "Commented"])->count();
                @endphp
                <a href="@if($isLocal) {{url('/')}}/{{$feeds['username'].$feeds['link']}} @else {{secure_url('/')}}/{{$feeds['username'].$feeds['link']}}@endif#comment">
                  <button type="button"  class="btn">
                  <i class="fas fa-comments text-secondary" style="font-size: 1.2em;"></i>
                  <sub id="count{{$feeds['id']}}">{{ $ccount }}</sub>
                </button>
                </a>
              </span>
              @endif
            </div>
          </div>
        </div>

        @endforeach

        <div id='pagination' style="display:none">
      {{ $posts->appends(request()->input())->links()}}
    </div>
     <!-- End timeline Page -->
     <div class="load-more" style="text-align: -webkit-center; display:none">
       <div class="spinner" style="    position: inherit;"></div>
     </div>
