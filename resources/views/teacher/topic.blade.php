@extends('layouts.teacher_layout')

@section('teacher_content')

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-3 bg bg-light pt-5 full-height left-container">

            <!-- Add Topic  -->
                <form action="/teacher/topic" method="POST">
                    @csrf
                    <h4 class="mb-3 text-center">Add Topic</h4>
                    <div class="mb-3">
                        <label class="form-label">Topic ID</label>
                        <input type="text" class="form-control
                        @error('topic_id') border border-danger @enderror"
                        name="topic_id" value="{{old('topic_id')}}">

                        @error('topic_id')
                            <p class="text-danger mt-1">{{$message}}</p>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Topic Description</label>
                        <input type="text" class="form-control
                        @error('topic_description') border border-danger @enderror"
                        name="topic_description" value="{{old('topic_description')}}">

                        @error('topic_description')
                            <p class="text-danger mt-1">{{$message}}</p>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-secondary">Add Topic</button>
                </form>



            </div>
            <div class="col-md-9 pt-5 px-5 right-container">

{{--                <!-- Search bar  -->--}}
{{--                <form class="d-flex align-items-center ms-auto mb-1" id="search">--}}
{{--                    <input class="form-control me-2 rounded-pill border-0" type="search" placeholder="Search" aria-label="Search">--}}
{{--                    <button class="btn border-0 text-dark p-0" id="search-icon" type="submit"><i class="fas fa-search"></i></button>--}}
{{--                </form>--}}

                <!-- Group Table  -->

                    <table class="table">
                        <thead>
                        <tr>
                            <th scope="col">No.</th>
                            <th scope="col">Topic ID</th>
                            <th scope="col">Topic Description</th>
                            <th scope="col">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                            <?php $i = (($topics->currentPage())-1) * 5; ?>
                            @foreach($topics as $topic)
                                <tr>
                                    <td>{{++$i}}</td>
                                    <td>{{$topic->topic_id}}</td>
                                    <td class="text-break">{{$topic->topic_description}}</td>
                                    <td>
                                        <div class="d-flex">
                                            <a href="{{url('/teacher/topic/'.$topic->id)}}" class="">
                                                <button class="btn btn-info me-1">Edit</button>
                                            </a>
                                            <form action="/teacher/topic/{{$topic->id}}" method="POST">
                                                @method('delete')
                                                @csrf
                                                <button type="submit"
                                                onclick="return confirm('Are you sure you want to delete this topic: {{$topic->topic_id}} ?')"
                                                class="btn btn-danger">Delete</button>
                                            </form>
                                        </div>
                                        @if(session('topicError') && session('topicError')[1]==$topic->topic_id)
                                        <p class="text-danger mt-1">{{session('topicError')[0]}}</p>
                                        @endif

                                    </td>
                                </tr>
                            @endforeach

                        </tbody>
                    </table>

                    <div class="mt-4">
                        {{$topics->links()}}
                    </div>

            </div>
        </div>
    </div>


@endsection
