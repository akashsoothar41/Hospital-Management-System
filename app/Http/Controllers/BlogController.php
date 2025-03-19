<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\BlogAttachment;
use App\Models\BlogTag;
use App\Models\Comment;
use App\Models\Speciality;
use Illuminate\Http\Request;
use Auth;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $doctor = Auth::user();
        $blogs = Blog::where('doctor_id', $doctor->id)->with(['doctor','speciality', 'attachment'])->get();
        return view('backend.doctor.blogs.index', compact('blogs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $specialities = Speciality::where('status', '1')->get();
        return view('backend.doctor.blogs.create', compact('specialities'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {      extract($request->all());
        // return $request->all();
        $input = $request->validate([
            'speciality_id' => 'required',
            'title' => 'required',
            'description' => 'required',
            'tags' => 'nullable|string',
            'status' => 'required',
        ]);

        $input['doctor_id'] = auth()->id();

        $blog = Blog::create($input);


        if (isset($attachments)) {
            foreach ($attachments as $file) {
                $filename = $this->storeFile('blog_attachments',$file);
                BlogAttachment::create(['file' => $filename, 'blog_id'=>$blog->id]);
            }
        }
        if (isset($tags)) {
            foreach (explode(',', $tags) as $tag) {
                BlogTag::create(['name' => $tag, 'blog_id'=>$blog->id]);
            }
        }
        if ($blog!=null) {
            return redirect(url('blogs'))->with(['msg' => "Blog created successfully", 'title' => 'Done!','type' => 'success']);
        } else {
            return redirect()->back()->with(['msg' => "Unable to create blog, try again",'title' => 'Fail!','type' => 'error' ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request,  $id)
    {
         $blog = Blog::find($id);
        $blogComments= Comment::where('blog_id', $id)->get();
        return view('backend.doctor.blogs.show', compact('blog', 'blogComments'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $blog = Blog::with(['tags', 'attachments'])->find($id);
        $specialities = Speciality::get();
        $tags = $blog->tags->pluck('name')->implode(',');

        return view('backend.doctor.blogs.edit', compact('blog', 'specialities', 'tags'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,  $id)
    {
        $input = $request->validate([
           'speciality_id' => 'required',
            'title' => 'required',
            'description' => 'required',
            'tags' => 'nullable | string ',
            'status' => 'required'
        ]);

        $blog = Blog::findorFail($id);
        $blog->update($input);

        // Handle attachments
        if ($request->hasFile('attachment')) {
            // Optionally delete existing attachments if needed
            foreach ($request->file('attachment') as $file) {
                $filename = $this->storeFile('blog_attachments',$file);
                BlogAttachment::create(['file' => $filename, 'blog_id' => $blog->id]);
            }
        }

        // Handle tags
        if ($request->filled('tags')) {
            // Delete existing tags to replace with new ones
            $blog->tags()->delete();

            foreach (explode(',', $request->tags) as $tag) {
                $blog->tags()->create(['name' => trim($tag)]);
            }
        }

        // Redirect with a success or error message
        return redirect()->route('blogs.index')->with([
            'msg' => "Blog updated successfully",
            'title' => 'Done!',
            'type' => 'success'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, $id)
    {
//        return $request->all();
        $blog = Blog::findorFail($id);
        $blog->attachments()->delete();
        $blog->tags()->delete();
        $blog->comments()->delete();

        $blog->delete();

        return redirect(url('blogs'))->with(['title'=> 'Done!', 'type' => 'success', 'msg' => 'Blog deleted successfully!' ]);
    }
}
