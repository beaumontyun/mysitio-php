<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\blogs_images;
use App\Models\User;
use App\Models\user_blogsimg;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        $this->address = storage_path();
    }

    public function show()
    {
        return Inertia::render('Blog/Index', [
            'blogs' => Blog::all()->map(function ($blog) {
                return [
                    'id' => $blog->id,
                    'title' => $blog->title,
                    'body' => $blog->body,
                    'created_at' => $blog->created_at,
                ];
            })
        ]);
    }

    public function index()
    {
        return Inertia::render('Blog/Index', [
            // 'filters' => Request::all('search', 'trashed'), // search feature
            'blogs' => Auth::user()->blogs()
                ->orderBy('id')
                ->through(fn ($blog) => [
                    'id' => $blog->id,
                    'title' => $blog->title,
                    'body' => $blog->body,
                    'created_at' => $blog->created_at,
                ]),
        ]);
    }

    // public function index()
    // {
    //     $user = User::find(Auth::id());

    //     $get_user_blog = DB::table('user_blogsimg')
    //         ->join('blogs', 'blogs.id', '=', 'user_blogsimg.blogs_id') // <-- associate the blogs with users
    //         ->join('blogs_images', 'blogs_images.id', '=', 'user_blogsimg.blogs_images_id') // <-- associate the images with blog
    //         ->where('user_id', $user->id)
    //         ->get();

    //     // dump($get_user_blog);

    //     //error_log($blog_id->id);

    //     // Blog::where('user_id', $user->id)
    //     // ->where('id', $id)
    //     // $image_path= $blog_id ->
    //     $address = storage_path();
    //     //return response()->file($address . '\app\Public/' . $image_path);

    //     // Zipper::make('mydir/mytest12.zip')->add(['thumbnail/1461610581.jpg','thumbnail/1461610616.jpg']);

    //     // response()->download($address . '\app\Public/' . $get_user_blog[0]->blogs_images);
    //     return $get_user_blog;
    // }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function storingImage(Request $request, $param_key, User $user, $blog_id)
    {

        $blog_image = $request->file($param_key);
        foreach ($blog_image as $value) {

            $image_name = $value->getClientOriginalName();

            $image_name = str_replace(' ', '_', $image_name);

            $image_path = Storage::putFileAs($user->email . "/blogsProfiles", $value, $image_name);

            $blog_img_id = blogs_images::create([
                'blogs_images' => $image_path,
            ])->id;

            user_blogsimg::create([
                'blogs_images_id' => $blog_img_id,
                'blogs_id' => $blog_id,
                'users_id' => Auth::id(),
            ]);
        }

        $address = storage_path();
        // response()->file($address . '\app\Public/' . $image_path);
        return $image_path;
    }

    public function store(Request $request)
    {

        $user = User::find(Auth::id()); //<------------find the user

        $fields = $request->validate([
            'title' => 'required',
            'body' => 'required',
            'category_id' => 'required',
            'blog_image[]' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg',
        ]);

        $blog_id = Blog::create([
            'title' => $fields['title'],
            'body' => $fields['body'],
            'category_id' => $fields['category_id'],
            'blog_image' => "",
            'user_id' => Auth::id(),
        ])->id;

        if ($request->hasFile('blog_image')) {

            $image_path = $this->storingImage($request, 'blog_image', $user, $blog_id); //<------------store images and create path

        } else {
            $image_path = "";
        }

        $address = storage_path(); //< -- return the default directory for storing images (see filesystems.php)

        return response()->file($address . '\app\Public/' . $image_path);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show_image($id)
    {

        $blogs_images = blogs_images::find($id, ['blogs_images']);
        return response()->file($this->address . '\app\Public/' . $blogs_images->blogs_images);
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

        $user = User::find(Auth::id());
        error_log($id);

        if ($request->hasFile('blog_image')) {
            error_log("this is running");
            $image_path = $this->storingImage($request, 'blog_image', $user, $id);
            error_log($image_path);

            $request->blog_image = $image_path;
        } else {
            $request->blog_image = "";
        }

        $blog = Blog::where('user_id', $user->id)
            ->where('id', $id)
            ->update($request->except(['_method']));

        return $blog;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $list_of_images_id = $request->list_of_images_id;
        $user = User::find(Auth::id());
        $user_id = $user->id;
        $images_owned_by_user = user_blogsimg::where('users_id', '=', $user->id)->get();

        foreach ($list_of_images_id as $value) {
            if (is_numeric($value)) {
                $image = blogs_images::find($value, ['*']);

                if (!is_null($image)) {
                    $images_owned_by_user = $images_owned_by_user->where("blogs_images_id", '=', $value)->toJson();

                    error_log("inside");
                    user_blogsimg::where(['blogs_images_id' => $image->id])
                        ->delete();
                    blogs_images::find($image->id)->delete();
                    Storage::delete($user->email . "/blogsProfiles", $value, $image->blogs_images);
                }
            }
        }
        // user_blogsimg::delete([
        //     'blogs_images_id' => $blog_img_id,
        //     'blogs_id' => $blog_id,
        //     'users_id' => Auth::id(),
        // ]);

        return $this->index();
    }

    /**
     * Search for a blog.
     *
     * @param  str  $title
     * @return \Illuminate\Http\Response
     */
    public function search($title)
    {
        return Blog::where('title', 'ilike', '%' . $title . "%")->get();
    }
}
