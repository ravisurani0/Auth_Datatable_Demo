<?php

namespace App\Http\Controllers;

use App\Models\Blogs;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\Datatables;

class BlogsController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Blogs::where('user_id',Auth()->user()->id)->with('Users')->orderBy('id', 'DESC')->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<div><a href="/blog/' . $row->id . '" class="btn btn-primary btn-sm mr-2">
                    <i class="fas fa-pencil-alt icon-md"></i> Details</a>
                    <a href="/remove-blog/' . $row->id . '" class="btn btn-danger btn-sm mr-2" onclick="return confirm("Are you sure?")">
                    <i class="fas fa-pencil-alt icon-md"></i> Remove</a> </div>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }


        return view('layouts.Blog.index');
    }

    public function allBlogs(Request $request)
    {
        if ($request->ajax()) {
            $data = Blogs::with('Users')->orderBy('id', 'DESC')->get();
            return Datatables::of($data)
                ->addIndexColumn()
               
                ->make(true);
        }
        return view('layouts.Blog.allBlogs');
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data = [
            "blogs" => null,
        ];
        return view('layouts.Blog.form')->with($data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required',
            'description' => 'required',
            'user_id' => 'required',
        ]);


        Blogs::create($validated);

        return redirect(route('blog.index'))->with('msg', 'New Blog Created successful.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Blogs $blogs)
    {
        return view('layouts.Blog.form', compact($blogs));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Blogs $blogs)
    {
        return view('layouts.Blog.form', compact($blogs));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Blogs $blogs)
    {
        $validated = $request->validate([
            'title' => 'required',
            'description' => 'required',
            'user_id' => 'required',
        ]);


        $blogs->update($validated);

        return redirect(route('blog.index'))->with('msg', 'Blog Updated successful!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Blogs $blogs)
    {
        return redirect(route('blog.index'))->with('msg', 'Blog Deleted successful!');
    }
}
