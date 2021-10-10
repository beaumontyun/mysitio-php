<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       $user = User::find(Auth::id());
        return $user;
        
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
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */


    public function updateImage($user, $file)
    {
        // $user = User::find(Auth::id());
        // $file = $request->file('file');
        $name = $file->getClientOriginalName();
        //error_log($name);
        $imagePath = "images/usersProfile/" . $user->name;
        $file->move($imagePath, $name);
        // User::where('id','=',Auth::id())->update(['path_for_profile_pic'=> $imagePath ]);
        // echo $file -> getClientOriginalName();
        return $imagePath;
    }
    
    public function edit(Request $request)
    {
        $user = User::find(Auth::id());
        $file = $request->file('path_for_profile_pic');
        // error_log($user);
        // var_dump($file);
        $imagePath = $this->updateImage($user, $file);
        // error_log($request->request->password);
        // $request->request->password=bcrypt($request->request);
        // $request->request->add(['password' => $imagePath]);
        $request->request->remove('_method');
        $request->request->add(['path_for_profile_pic' => $imagePath]);
        // $strippted=var_export($request); 
        // $strippted=json_decode($request);
        // var_dump($strippted);
    //     $request=http_build_query($request->except("header"));
    //    error_log($request);
    //     $request=json_decode($request); 
        
        User::where('id', '=', Auth::id())->update( $request->except(["email"]));

    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
