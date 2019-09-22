<?php

namespace Lucid\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;
use Validator;
use DB;
use Storage;
use Parsedown;
use Image;
use Lucid\user_settings;
use Lucid\Core\Follow;

class UserAccountSettingsController extends Controller
{
    public function settings(){
        $user = Auth::user();
        $username = $user['username'];
        // follower and following Count

          //User Follower checker
          if(Auth::user()){
            $check = new \Lucid\Core\Follow(Auth::user()->username);
            $fcheck = $check->followCheck($user->name);
          }
          else {
            $fcheck = "no";
          }
        $user_settings = user_settings::where('user_id', Auth::user()->id)->first();
      $tabs = unserialize($user_settings->tabs);
  
        return view('settings', ['fcheck' => $fcheck,'user'=>$user,'set'=>$user_settings , 'tabs' => $tabs]);

      }



      public function saveSettings(Request $request) {
        $validator=Validator::make($request->all(),[
          'name' => 'required',
          'email' => ['required','email',
           Rule::unique('users')->ignore(Auth::user()->id),
          ],
          'profileimage' => 'image|mimes:jpeg,png,jpg,gif|max:5048',
          'user_id' =>'required',
          'username'=>['required',
           Rule::unique('users')->ignore(Auth::user()->id),
          ]
      ]);

    if($validator->fails()){
        return response()->json($validator->messages(), 200);
    }

    $oldname = Auth::user()->name;
    $newname = $request->name;
    $user_id = $request->user_id;
    $email = $request->email;
    $username= Str::slug($request->username, '_');
    $bio = $request->bio;
    $FolderName = storage_path('app/'.Auth::user()->id);

    if(!is_null($request->file('profileimage')) && $request->file('profileimage') !== ""){

      $filenamewithextension = $request->file('profileimage')->getClientOriginalName();

      //get filename without extension
      $filename = pathinfo($filenamewithextension, PATHINFO_FILENAME);

      //get file extension
      $extension = $request->file('profileimage')->getClientOriginalExtension();

      $image = $request->file('profileimage');
      $fullPath = $this->store($image, $filenamewithextension,$filename,$extension);


       $updated =   DB::transaction(function ()
        use ($oldname,$newname,$fullPath,$FolderName,$user_id,$email,$username,$bio) {

        $updated= DB::table('users')->where('id',$user_id)
        ->update(['name'=>$newname,'username'=>$username,'email'=>$email,'image'=>$fullPath,'short_bio'=>$bio]);

        DB::table('extfeeds')->where('site',$oldname)
        ->update([
            'site'=>$newname,
            'site_image' => $fullPath
        ]);

        return true;

        });

      if($updated) {

        return response()->json(['success'=>"Your changes has been saved successfully",'img_path'=>$fullPath,'renamedUserContentFolderName'=>$username], 200);
      }
    } else {
            $fullPath = Auth::user()->image;

            $updated =   DB::transaction(function ()
                use ($oldname,$newname,$fullPath,$FolderName,$user_id,$email,$username,$bio) {

                DB::table('users')->where('id',$user_id)
                            ->update(['name'=>$newname,'username'=>$username,'email'=>$email,'short_bio'=>$bio,'image' => $fullPath]);

                DB::table('ext_rsses')->where('title',$oldname)
                            ->update([
                                'title'=>$newname,
                                'url'=> $FolderName."/rss/rss.xml",
                                'link'=> $FolderName."/rss/rss.xml",
                                'image' => $fullPath
                            ]);
                return true;

                });
                if($updated){
                    return response()->json(['success'=>"Your changes has been saved successfully",'renamedUserContentFolderName'=>$username], 200);
                }
    }

  }

  public function store($image,$filenamewithextension,$filename,$extension)
{

  //Log::debug($image);

      //filename to store
      $filenametostore = $filename.'_'.time().'.'.$extension;

      //small thumbnail name
      $smallthumbnail = $filename.'_small_'.time().'.'.$extension;

      //medium thumbnail name
      $mediumthumbnail = $filename.'_medium_'.time().'.'.$extension;

      //large thumbnail name
      $largethumbnail = $filename.'_large_'.time().'.'.$extension;

      //Upload File
      $image->storeAs('public/'.Auth::user()->id.'/images/', $filenametostore);
      $image->storeAs('public/'.Auth::user()->id.'/images/thumbnail', $smallthumbnail);
      $image->storeAs('public/'.Auth::user()->id.'/images/thumbnail', $mediumthumbnail);
      $image->storeAs('public/'.Auth::user()->id.'/images/thumbnail', $largethumbnail);

      //create small thumbnail
      $smallthumbnailpath = public_path('storage/'.Auth::user()->id.'/images/thumbnail/'.$smallthumbnail);
      $this->createThumbnail($smallthumbnailpath, 150, 93);

      //create medium thumbnail
      $mediumthumbnailpath = public_path('storage/'.Auth::user()->id.'/images/thumbnail/'.$mediumthumbnail);
      $this->createThumbnail($mediumthumbnailpath, 300, 185);

      //create large thumbnail
      $largethumbnailpath = public_path('storage/'.Auth::user()->id.'/images/thumbnail/'.$largethumbnail);
      $this->createThumbnail($largethumbnailpath, 550, 340);

      $imagePath ='/storage/'.Auth::user()->id.'/images/thumbnail/'.$smallthumbnail;
      return $imagePath;

}
      /**
      * Create a thumbnail of specified size
      *
      * @param string $path path of thumbnail
      * @param int $width
      * @param int $height
      */
      public function createThumbnail($path, $width, $height)
      {
      $img = Image::make($path)->resize($width, $height, function ($constraint) {
      $constraint->aspectRatio();
      });
      $img->save($path);

      //$img = Image::make($path)->resize($width, $height)->save($path);
      }


      public function AccountSetting(Request $request)
      {
       $tags =  serialize($request->tags);
    //    Log::debug($tags);

        $site_settings=
        DB::table('user_settings')
        ->where('user_id', Auth::user()->id)
        ->update([
          'tabs' => $tags,
          'view' => $request->view,
          'public_view' => $request->pubView
        ]);
      }

}
