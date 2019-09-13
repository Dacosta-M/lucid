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
Route::get('login', function () {
    return view('auth/login');
});
Route::get('register', function () {
    return view('auth/register');
});

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

Route::prefix('{username}')->group(function () {

    //get Request
    Route::get('/contact', 'pageController@contact');
    Route::get('/post/{postTitle}','PostController@singlePostPage')->name('post');
    Route::get('/post-data/{id}','PostController@getPostData');
    Route::get('/','PostController@homePage');
    Route::get('/home','PostController@homePage');
    Route::get('/thoughts','pageController@thoughts');
    Route::get('/logout', "Auth\LoginController@logout");
    Route::get('/posts','PostController@posts')->middleware('auth');
    Route::get('/subscribe','HomeController@subscribe');
    Route::get('/settings', 'UserAccountSettingsController@settings');
    Route::get('/followers','pageController@followers')->name("followers");
    Route::get('/following','pageController@following')->name("following");
    Route::get('/comments/{post_id}','pageController@comments')->name('comment');
    Route::get('/notif','pageController@notification');
    Route::get('/reply','pageController@reply');
    Route::get('/like','ReactionsController@like');
    Route::get('/love','ReactionsController@love');
    Route::get('/feeds','pageController@Feeds');
    Route::get('/update-post-status/{post_id}/{action}','PostController@updatePostStatus')->middleware('auth');




    //post Request
    Route::post('/save-post','HomeController@savePost');
    Route::post('/addrss','ExtRssController@addRss');
    Route::post('/unfollow','ExtRssController@unfollow');
    Route::post('/extrss','ExtRssController@addExtRss');
    Route::post('/publish','PostController@publish')->middleware('auth');
    Route::post('/send-mail','SendEmailController@sendEmail');
    Route::post('/save_settings','UserAccountSettingsController@saveSettings');
    Route::post('/update-contact-details','HomeController@updateContactDetails');
    Route::post('/delete-post','PostController@deletePost')->name('deletePost')->middleware('auth');
    Route::post('/save-comment','HomeController@saveComment')->name('save-comment');
    Route::post('/notif','pageController@notification');
    Route::post('/edit-post','PostController@editPost')->middleware('auth');



});
