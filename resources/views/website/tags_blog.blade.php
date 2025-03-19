@extends('website.layouts.master')

@section('content')
    <div class="breadcrumb-bar">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-md-12 col-12">
                    <nav aria-label="breadcrumb" class="page-breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('website') }}">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Blogs</li>
                        </ol>
                    </nav>
                    <h2 class="breadcrumb-title">Blogs</h2>
                </div>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-md-12">
                    <div class="row blog-grid-row">
                        @foreach($tagBlogs as $blog)
                            <div class="col-md-6 col-sm-12">
                                <div class="blog grid-blog">
                                    <div class="blog-image">
                                        <!-- No route, just use static links for blog details -->
                                        <a href="{{route('blog_detail', ['id' => $blog->id])}}"><img class="img-fluid" src="{{ asset('backend/' . $blog->attachment->file) }}" alt="Post Image"></a>
                                    </div>
                                    <div class="blog-content">
                                        <ul class="entry-meta meta-item">
                                            <li>
                                                <div class="post-author">
                                                    <a href="#"><img src="{{ asset('backend/' . $blog->doctor->profile->image) }}" alt="Post Author"> <span>{{ $blog->doctor->first_name }} {{ $blog->doctor->last_name }}</span></a>
                                                </div>
                                            </li>
                                            <li><i class="far fa-clock"></i> {{ $blog->created_at->format('j M Y') }}</li>
                                        </ul>
                                        <h3 class="blog-title"><a href="#">{{ $blog->title }}</a></h3>
                                        <p class="mb-0">{{ \Illuminate\Support\Str::limit($blog->description, 50, '') }}</p>

                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="col-lg-4 col-md-12 sidebar-right theiaStickySidebar">
                    <div class="card search-widget">
                        <div class="card-body">
                            <form class="search-form">
                                <div class="input-group">
                                    <input type="text" placeholder="Search..." class="form-control">
                                    <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i></button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="card post-widget">
                        <div class="card-header">
                            <h4 class="card-title">Latest Posts</h4>
                        </div>
                        <div class="card-body">
                            <ul class="latest-posts">
                                @foreach($latestBlogs as $blog)
                                    <li>
                                        <div class="post-thumb">
                                            <!-- No route, just static links for blog thumbnails -->
                                            <a href="#"><img class="img-fluid" src="{{ asset('backend/' . $blog->attachment->file) }}" alt=""></a>
                                        </div>
                                        <div class="post-info">
                                            <h4><a href="#">{{ $blog->title }}</a></h4>
                                            <p>{{ $blog->created_at->format('d M Y') }}</p>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>

                    <div class="card category-widget">
                        <div class="card-header">
                            <h4 class="card-title">Specialties Blog</h4>
                        </div>
                        <div class="card-body">
                            <ul class="categories">
                                @foreach($specialities as $speciality)
                                    <li><a href="#">{{ $speciality->name }} <span>{{ $speciality->blog_count }}</span></a></li>
                                @endforeach

                            </ul>
                        </div>
                    </div>

                    <div class="card tags-widget">
                        <div class="card-header">
                            <h4 class="card-title">Tags</h4>
                        </div>
                        <div class="card-body">
                            <ul class="tags">
                                @foreach($tags as $tag)
                                    <li><a href="{{url('tag-blogs', $tag->id)}}" class="tag">{{$tag->name}}</a></li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
