<h5 class="font-weight-bold mb-5">Manage Your Timeline on the Page</h5>

<!-- Main Timeline Start -->
<div class="mb-5">
  <div class="pb-2 px-2 d-flex justify-content-between text-secondary font-weight-bold border-bottom border-secondary" data-toggle="collapse" data-target="#mainTimeline">
    <p class="mb-0">Main Timeline</p>
    <i class="fas fa-chevron-up"></i>
  </div>
  <div id="mainTimeline" class="collapse in show pt-3">
    <div>
      <div class="row">
        @php $count = DB::table('following')->where('my_id', $user->id)->count();@endphp
        @foreach ($following as $follow)
        @php $fcount = DB::table('following')->where('follower_id', $follow['id'])->count();@endphp
        <div class="col-2 text-center">
          <img src="{{$follow['img']}}" class="img-fluid" style="border-radius:100%;" alt="user" />
          <small><a href="" class="d-block mb-0 text-main font-weight-bold">{{$follow['name']}}</a></small>
          <small>
            <p>{{$fcount}}</p>
          </small>
        </div>
      @endforeach
        <div class="col-12 col-sm-2 align-self-center">
          @if ($count > 4)
          <a href="" class="font-weight-bold text-secondary">{{$count - 4}}</a>
          @else
          @endif
        </div>
      </div>
      <div class="container mt-5 mt-sm-3">
        @foreach ($rss as $rss)
        <div id="RssId{{ $rss->id}}"class="post-content">
          <img src="{{ $rss->image }}" class="img-fluid" alt="user" />
          <div class='ml-2 ml-sm-3'>
            <a href="{{ $rss->url}}" class="d-block mb-0 text-dark font-weight-bold">{{ $rss->title}}</a>
            <span>
              <small>{{ $rss->description}}</small>
              <button class="btn btn-secondary btn-sm p-0 timeline-rss-btn"> <small>RSS</small></button>
            </span>
          </div>
          <div class="ml-4 ml-sm-5 pt-sm-3">
          <!--  <a href="" class="d-block d-sm-inline-block font-weight-bold text-success ml-sm-3">Edit</a>-->
            <button id="DeleteRss{{ $rss->id}}" onclick='DeleteRss("{{ $rss->id}}")' class="d-block d-sm-inline-block font-weight-bold text-danger ml-sm-3">Remove</button>
          </div>
        </div>
        @endforeach
        <div class="preAddmain"></div>
        <div id="rssloadermain" class="post-content" style="display:none">
        <div class='ml-2 ml-sm-3'>
            <div class="spinner" style="    position: inherit;"></div>
          </div>
          <div class="ml-4 ml-sm-5 pt-sm-3">
            Adding RSS
          </div>
        </div>

<form name="RssMain" id="RssMain"  action="#" class="form-inline">

          <div class="form-group mb-2">
            <label for="addUser" class="sr-only">Email</label>
            <input type="hidden" name="tags" value="main">
            <input type="text" id="addRss"class="form-control no-border-radius" name="Addrss"  placeholder="Add RSS Feed or Twitter User" size="30">
          </div>
          <button id="SubmitRss" type="button" onclick="rssAdd('RssMain','main')" class="btn btn-secondary mb-2 no-border-radius">Add User</button>

        </form>
      </div>
    </div>
  </div>
</div>
<!-- Main Timeline Ends -->
  @forelse($tabs as $tab)
<!-- {{$tab}} Timeline Start -->
<div class="mb-5">
  <div class="pb-2 px-2 d-flex justify-content-between text-secondary font-weight-bold border-bottom border-secondary" data-toggle="collapse" data-target="#{{$tab}}Timeline">
    <p class="mb-0">{{$tab}} Timeline</p>
    <div>
      <i class="fas fa-trash text-danger mr-2"></i>
      <i class="fas fa-chevron-down"></i>
    </div>
  </div>
  <div id="{{$tab}}Timeline" class="collapse in pt-3">
    <div>
      <div>
        <div class="row">
          @php
          $userArray = [];
          foreach($users as $user){
            $tags = explode(',',$user->tags);
            $tags = array_filter(array_map('trim',$tags));
            $tags = array_filter(array_map('strtolower',$tags));
            $fcount = DB::table('following')->where('my_id', $user->user_id)->count();
            if(in_array(strtolower($tab), $tags)) {
              $userArray[] = array('name'=>$user->name,'username'=>$user->username,'image'=>$user->image, 'count'=>$fcount);
            }}
            $i = 0;
            $rssTags = DB::table('ext_rsses')->where(['user_id' => Auth::user()->id, 'category' => $tab])->get();
          @endphp

          @foreach(array_unique($userArray,SORT_REGULAR) as $user)
          @php
          $i++;
          @endphp
          <div class="col-2 text-center">
            <img src="{{  $user['image'] }}" class="img-fluid" style="border-radius:100%;" alt="user" />
            <small><a href="{{secure_url('/').'/'.$user['username'] }}" class="d-block mb-0 text-main font-weight-bold">{{ $user['name'] }}</a></small>
            <small>
              <p>{{$user['count'] }}</p>
            </small>
          </div>
        @endforeach
          <div class="col-12 col-sm-2 align-self-center">
            @if ($count > 4)
            <a href="" class="font-weight-bold text-secondary">{{$count - 4}}</a>
            @else
            @endif
          </div>
        </div>
        <div class="container mt-5 mt-sm-3">

          @foreach ($rssTags as $rssTag)
          <div id='RssId{{ $rssTag->id}}'class="post-content">
            <img src="{{ $rssTag->image }}" class="img-fluid" alt="user" />
            <div class='ml-2 ml-sm-3'>
              <a href="{{ $rssTag->url}}" class="d-block mb-0 text-dark font-weight-bold">{{ $rssTag->title}}</a>
              <span>
                <small>{{ $rssTag->description}}</small>
                <button class="btn btn-secondary btn-sm p-0 timeline-rss-btn"> <small>RSS</small></button>
              </span>
            </div>
            <div class="ml-4 ml-sm-5 pt-sm-3">
            <!--  <a href="" class="d-block d-sm-inline-block font-weight-bold text-success ml-sm-3">Edit</a>-->
              <button id="DeleteRss{{ $rssTag->id}}" onclick='DeleteRss("{{ $rssTag->id}}")' class="d-block d-sm-inline-block font-weight-bold text-danger ml-sm-3">Remove</button>
            </div>
          </div>
          @endforeach

          <div class="preAdd{{$tab}}"></div>
          <div id="rssloader{{$tab}}" class="post-content" style="display:none">
          <div class='ml-2 ml-sm-3'>
              <div class="spinner" style="    position: inherit;"></div>
            </div>
            <div class="ml-4 ml-sm-5 pt-sm-3">
              Adding RSS
            </div>
          </div>

  <form name="Rss{{$tab}}" action="#" class="form-inline">

            <div class="form-group mb-2">
              <label for="addUser" class="sr-only">Email</label>
              <input type="hidden" name="tags" value="{{$tab}}">
              <input type="text" id="addRss"class="form-control no-border-radius" name="Addrss"  placeholder="Add RSS Feed or Twitter User" size="30">
            </div>
            <button id="SubmitRss" type="button" onclick='rssAdd("Rss{{$tab}}","{{$tab}}")' class="btn btn-secondary mb-2 no-border-radius">Add User</button>

          </form>
        </div>
      </div>
  </div>
</div>
</div>
@empty
<!-- {{$tab}} Timeline Ends -->
  @endforelse
