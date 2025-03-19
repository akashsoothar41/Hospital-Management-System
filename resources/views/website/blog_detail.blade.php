@extends('website.layouts.master')
@section('content')
<div class="content">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-md-12">
                <div class="blog-view">
                    <div class="blog blog-single-post">
                        <div class="blog-image">
                            <a href="javascript:void(0);"><img alt="" src="{{ asset('backend/'.$blogsDetail->attachment->file) }}" class="img-fluid"></a>
                        </div>
                        <h3 class="blog-title">{{$blogsDetail->title}}</h3>
                        <div class="blog-info clearfix">
                            <div class="post-left">
                                <ul>
                                    <li>
                                        <div class="post-author">
                                            <a href="{{ route('doctor_profile', ['id' => $blogsDetail->doctor->id]) }}"><img src="{{asset('backend')}}/{{$blogsDetail->doctor->profile->image}}" alt="Post Author"> <span>Dr. Darren Elder</span></a>
                                        </div>
                                    </li>
                                    <li><i class="far fa-calendar"></i>{{\carbon\Carbon::parse($blogsDetail->created_at)->format('j M y')}}</li>
                                    <li><i class="far fa-comments"></i>({{$commentCount}}) Comments</li>
                                    <li><i class="fa fa-tags"></i>Health Tips</li>
                                </ul>
                            </div>
                        </div>
                        <div class="blog-content">
                            <p>{!! $blogsDetail->description !!}</p>
                        </div>
                    </div>
                    <div class="card blog-share clearfix">
                        <div class="card-header">
                            <h4 class="card-title">Share the post</h4>
                        </div>
                        <div class="card-body">
                            <ul class="social-share">
                                <li><a href="#" title="Facebook"><i class="fab fa-facebook"></i></a></li>
                                <li><a href="#" title="Twitter"><i class="fab fa-twitter"></i></a></li>
                                <li><a href="#" title="Linkedin"><i class="fab fa-linkedin"></i></a></li>
                                <li><a href="#" title="Google Plus"><i class="fab fa-google-plus"></i></a></li>
                                <li><a href="#" title="Youtube"><i class="fab fa-youtube"></i></a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="card author-widget clearfix">
                        <div class="card-header">
                            <h4 class="card-title">About Author</h4>
                        </div>
                        <div class="card-body">
                            <div class="about-author">
                                <div class="about-author-img">
                                    <div class="author-img-wrap">
                                        <a href="{{ route('doctor_profile', ['id' => $blogsDetail->doctor->id]) }}">
                                            <img src="{{ asset('backend')}}/{{$blogsDetail->doctor->profile->image }}" alt="Post Author">
                                        </a>

                                    </div>
                                </div>
                                <div class="author-details">
                                    <a href="{{ route('doctor_profile', ['id' => $blogsDetail->doctor->id]) }}" class="blog-author-name">Dr. {{$blogsDetail->doctor->first_name}} {{$blogsDetail->doctor->last_name}}</a>
                                    <p class="mb-0">{{$blogsDetail->doctor->profile->about}}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card blog-comments clearfix">
                        <div class="card-header">
                            <h4 class="card-title">Comments ({{$commentCount}})</h4>
                        </div>
                        <div class="card-body pb-0">
                            <ul class="comments-list">
                                @foreach($comments as $comment)
                                <li>
                                    <div class="comment">
                                        <div class="comment-author">
                                            <img class="avatar" alt="" src="{{asset('backend')}}/{{$comment->user->profile->image}}">
                                        </div>
                                        <div class="comment-block">
                                            <span class="comment-by">
                                            <span class="blog-author-name">{{$comment->user->first_name}}</span>
                                            </span>
                                            <p>{{$comment->message}}</p>
                                            <p class="blog-date">{{\carbon\Carbon::parse($comment->created_at)->format('j M y')}}</p>
                                            <a class="comment-btn" href="#">
                                                <i class="fas fa-reply"></i> Reply
                                            </a>
                                        </div>
                                    </div>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    <div class="card new-comment clearfix">
                        <div class="card-header">
                            <h4 class="card-title">Leave Comment</h4>
                        </div>
                        <div class="card-body">
                            <!-- Update the action attribute to use the route() helper function with the correct route name -->
                            <form action="{{ route('comment') }}" method="POST">
                                @csrf
                                <input type="hidden" name="blog_id" value="{{ $blogsDetail->id }}">
                                <div class="form-group">
                                    <label>Name <span class="text-danger">*</span></label>
                                    <input type="text" name="name" class="form-control" value="{{ old('name') }}">
                                    <!-- Display validation error for 'name' -->
                                    @error('name')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>Your Email Address <span class="text-danger">*</span></label>
                                    <input type="email" name="email" class="form-control" value="{{ old('email') }}">
                                    <!-- Display validation error for 'email' -->
                                    @error('email')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>Comments</label>
                                    <textarea rows="4" name="message" class="form-control">{{ old('message') }}</textarea>
                                    <!-- Display validation error for 'message' -->
                                    @error('message')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="submit-section">
                                    <button class="btn btn-primary submit-btn" type="submit">Submit</button>
                                </div>
                            </form>
                        </div>
                    </div>
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
                        <h4 class="card-title">Latest Blogs</h4>
                    </div>
                    <div class="card-body">
                        <ul class="latest-posts">
                            @foreach($latestBlogs as $blog)
                            <li>
                                <div class="post-thumb">
                                    <a href="">
                                        <img class="img-fluid" src="{{asset('backend')}}/{{$blog->attachment->file}}" alt="">
                                    </a>
                                </div>
                                <div class="post-info">
                                    <h4>
                                        <a href="">{{$blog->title}}</a>
                                    </h4>
                                    <p>{{\Carbon\Carbon::parse($blog->created_at)->format('j M Y')}}</p>
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
