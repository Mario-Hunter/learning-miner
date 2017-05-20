<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use App\Course;
use App\Tag;
use App\Rank;
use App\User;
use Image;
use Auth;
class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $user ,Course $course)
    {
         return view('users.show',compact('user','course'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    protected function update(array $data)
    {   

        $oldpasswordInDB=auth()->user()->password;
        if($oldpasswordInDB==bcrypt($data['password']))
        {
        $date = $data['birthDay']." ".$data['birthMonth']." ".$data['birthYear'];
        $dob = Carbon\Carbon::parse($date);
        DB::table('users')
            ->where('id', $data['id'])
            ->update([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'dob' => $dob,
            'gender'=>$data['gender'],
            'password' => bcrypt($data['password']),
        ]);

            return view('user.info');
        }
        else{

            session()->flash('message','Please Enter the old Password right!');
            return Redirect::back();
        }
        
        
    }
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'first_name' => 'required|max:255',
            'birthDay'=>'required',
            'birthMonth'=>'required',
            'birthYear'=>'required',
            'password'          => 'required|min:8',
            'old_password'              => 'required|min:8|confirmed|different:password',
            'password_confirmation' => 'required|min:8',       
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showUserCourses(User $user)
    {
        $courses=$user->courses();
        return view('index.blade',compact('courses'));
    }

    public function showUserInfo(User $user ,Course $course)
    {
      
        return view('users.info',compact('user','course'));
    }
    
    public function update_avatar(Request $request){
    if($request->hasFile('avatar')){
    $avatar = $request->file('avatar');
    $filename=time() . '.' . $avatar->getClientOriginalExtension();
    Image::make($avatar)->resize(300,300)->save(public_path('/uploads/avatars/' . $filename));
        $user= Auth::user();
        $user->avatar='/uploads/avatars/'.$filename;
        $user->save();
        
    }
    return view('users.info',array('user'=> Auth::user()));

}
}
