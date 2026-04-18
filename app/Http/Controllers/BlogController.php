<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $blogs = Blog::where("user_id", request()->user()->id)
            ->orderBy("id", "DESC")
            ->paginate(5);

        return view("blogs.index", [
            "blogs" => $blogs
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("blogs.create");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            "title" => "required|string|max:50",
            "description" => "required|string",
            "banner_image" => "required|image|mimes:jpg,jpeg,png,webp|max:2048"
        ]);

        //debug
        // echo "<pre>";
        // print_r($request->all());

        if ($request->hasFile("banner_image")) {
            $path = $request->file("banner_image")->store("blogs", "public");
            $data['banner_image'] = $path;
        }

        $data['user_id'] = request()->user()->id;
        Blog::create($data);

        return redirect()
            ->route("blog.index")
            ->with("success", "Blog criado com sucesso");
    }

    /**
     * Display the specified resource.
     */
    public function show(Blog $Blog)
    {
        return view("blogs.show", [
            "blog" => $Blog
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Blog $Blog)
    {
        return view("blogs.edit", [
            "blog" => $Blog
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Blog $Blog)
    {
        $data = $request->validate([
            "title" => "required|string|max:50",
            "description" => "required|string",
            "banner_image" => "nullable|image|mimes:jpg,jpeg,png,webp|max:2048"
        ]);

        if ($request->hasFile("banner_image")) {
            if ($Blog->banner_image)
                Storage::disk("public")->delete($Blog->banner_image);

            $path = $request->file("banner_image")->store("blogs", "public");
            $data["banner_image"] = $path;
        }

        $Blog->update($data);
        return redirect()
            ->route("blog.show", $Blog)
            ->with("success", "Blog updated successfuly");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Blog $Blog)
    {
        if ($Blog->banner_image) {
            Storage::disk("public")->delete($Blog->banner_image);
        }
        $Blog->delete();

        return redirect()
        ->route("blog.index")
        ->with("success", "Blog deleted successfuly");
    }
}
