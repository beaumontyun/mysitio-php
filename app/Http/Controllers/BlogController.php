<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Category;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Blog::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = User::find(Auth::id());
        //error_log($id);


        $fields = $request->validate([
            'title' => 'required',
            'body' => 'required',
            'category_id' => 'required',
            'blog_image'=>'image|mimes:jpeg,png,jpg,gif,svg'
        ]);

        $blog_image = $request->file('blog_image');//<------- get the image
        $image_name = $blog_image->getClientOriginalName();
        $image_name =str_replace(' ', '_', $image_name);
       
       $image_path=Storage::putFileAs($image_name , $blog_image,$image_name);//<------- change the image name to their original from machine-generated code

       Blog::create( [
            'title' => $fields['title'],
            'body' => $fields['body'],
            'category_id' => $fields['category_id'],
            'blog_image' => $image_path,
            'user_id' => Auth::id()
        ]);
        $address= storage_path();//< -- return the default directory for storing images (see filesystems.php)

        return    response()->file($address.'\app\Public/'.$image_path);
       
    }






    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Blog::find($id);
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
        $blog = Blog::find($id);
        $blog->update($request->all());
        return $blog;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return Blog::destroy($id);
    }

    /**
     * Search for a blog.
     *
     * @param  str  $title
     * @return \Illuminate\Http\Response
     */
    public function search($title)
    {
        return Blog::where('title', 'ilike', '%'.$title."%")->get();
    }

}
