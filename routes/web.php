<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/home', function () {
    return view('welcome');
});
Route::get('login',"pageController@loginPage");
Route::get('register','pageController@registerPage');


Route::prefix('explore')->group(function (){
    Route::get('/','ExploreController@explorePage');
    Route::get('/interest/{interest}','ExploreController@interest')->name('interest');
});
Route::get('loader', function () {
    return view('preloader');
});
Route::get('subscribe', function () {
    return view('subscribe');
});
Route::get('fix','HomeController@fix');
Route::get('post/{username}','HomeController@checkpost');
Route::get('feed/{username}','HomeController@checkfeed');
Route::get('dropfeed','HomeController@dropfeed');
Route::get('loadfeed/{username}','HomeController@loadfeed');
Route::get('postFixer/','HomeController@postFixer');
Route::get('commentFixer/','HomeController@postFixer');
//Route::get('oldfeed','HomeController@old');
//Route::get('newfeed','HomeController@new');



Route::get('under-construction', 'pageController@construction')->name('under-construction');
Route::get('microblog','HomeController@microblog');
Route::post('save-post','HomeController@savePost');
Route::post('save-subscription','pageController@saveSubscriptionEmail');

Route::get('/category/{category}','ExploreController@postCategories');
Route::get('/filter/{method}','ExploreController@filterPost');

Route::get('/sitemap_users.xml','pageController@sitemapUsers');
Route::get('/sitemap_feeds.xml','pageController@sitemapFeeds');
Route::get('/sitemaps.xml','pageController@sitemaps');
Route::get('/sitemap.xml','pageController@sitemap');


Route::get('login/{provider}', 'Auth\LoginController@redirectToProvider');
Route::get('login/{provider}/callback', 'Auth\LoginController@handleProviderCallback');
Route::post('login', 'LoginController@do')->name('login');
Route::post('/login/magic','Auth\MagicLinkLoginController@sendToken')->name('sendMagicLink');
Route::get('/login/magic/{token}','Auth\MagicLinkLoginController@validateToken');
// Route::get('/l/{hashtag}','PostController@test');

Route::prefix('{username}')->group(function () {

    //get Request
    Route::get('/','FeedsController@homePage');
    Route::get('/home','FeedsController@homePage')->name('home');
    Route::get('/contact', 'pageController@contact');
    Route::get('/logout', "Auth\LoginController@logout");


    //Feeds Controller
    Route::get('/post/{postTitle}','PostController@singlePostPage')->name('post');
    Route::get('/update-post-status/{post_id}/{action}','PostController@updatePostStatus');
    Route::get('/post-data/{id}','PostController@getPostData');
    Route::get('/posts','PostController@posts');
    Route::get('/thoughts','FeedsController@thoughts');

    //Settings Controller
    Route::get('/settings', 'UserAccountSettingsController@settings');

    //follower contorller
    //get
    Route::get('/subscribe','HomeController@subscribe');
    Route::get('/followers','FollowController@followers')->name("followers");
    Route::get('/following','FollowController@following')->name("following");
    //post
    Route::post('/addrss','ExtRssController@addRss');
    Route::post('/extrss','ExtRssController@addExtRss');
    Route::get('/deleteRss','ExtRssController@delete');
    Route::post('/unfollow','ExtRssController@unfollow');

    Route::get('/feeds','FeedsController@Feeds');
    Route::get('/timeline-settings','FeedsController@Settings');

    //Reaction Controller
    Route::get('/like','ReactionsController@like');
    Route::get('/love','ReactionsController@love');
    Route::get('/reply','pageController@reply');
    Route::get('/comments/{post_id}','pageController@comments')->name('comment');
    Route::get('/notif','pageController@notification');




    //post Request
    Route::post('/save-post','PostController@saveThoughts')->middleware('auth');
    Route::post('/publish','PostController@publish');
    Route::post('/send-mail','SendEmailController@sendEmail');

    Route::post('/save_settings','UserAccountSettingsController@saveSettings');
    Route::post('/account_settings','UserAccountSettingsController@AccountSetting');

    Route::post('/update-contact-details','HomeController@updateContactDetails');
    Route::post('/delete-post','PostController@deletePost')->name('deletePost')->middleware('auth');
    Route::post('/save-comment','HomeController@saveComment')->name('save-comment');
    Route::post('/notif','pageController@notification');
    Route::post('/edit-post','PostController@editPost')->middleware('auth');



});
