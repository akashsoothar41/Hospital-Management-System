@extends('backend.doctor.layouts.master')
@section('content')
    <div class="col-xl-12 d-flex">
        <div class="card flex-fill">
            <div class="card-header">
                <h4 class="card-title">Blog Detail</h4>
            </div>
            <div class="content">
                <div class="container">
                    <div class="row">
                        <div class="col-12">
                            <div class="terms-content">
                                <div class="terms-text">
                                    <h6>Speciality: {{$blog->speciality->name}}</h6>
                                    <h6>{{$blog->doctor->first_name}} {{$blog->doctor->last_name}}</h6>
                                    <h3>{{$blog->title}}</h3>
                                    <p>
                                        {!! $blog->description !!}
                                    </p>
                                </div>
                                <div class="card-header">
                                    <h4 class="card-title">Attachments</h4>
                                </div>
                                <div class="card-body">
                                    @foreach($blog->attachments as $attachment)
                                        <img src="{{ asset('backend/' . ($attachment->file ?? 'no_image.jpg')) }}" alt="Attachment Image" style="width: 250px; height: 250px; margin: 20px;">
                                    @endforeach
                                </div>
                                <div class="card-header">
                                    <h4 class="card-title">Tags</h4>
                                </div>
                                <div class="card-body">
                                    <ul class="tags">
                                        @foreach($blog->tags as $tag)
                                            <li><a href="#" class="tag">{{$tag->name}}</a></li>
                                        @endforeach
                                    </ul>
                                </div>
                                <div class="card-header">
                                    <h4 class="card-title">Comments</h4>
                                </div>
                                <div class="card-body">
                                    @foreach($blogComments as $comment)
                                        <tr>
                                            <h6>{{ $comment->name}}</h6>
                                            <td>{{ $comment->message }}</td>
                                        </tr>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
