@extends('layouts.teacher_layout')

@section('teacher_content')

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-3 bg bg-light pt-3 left-container full-height">

            <!-- Edit group  -->
                <form class="" action="/teacher/groups/{{$group->id}}" method="POST">
                    @method('put')
                    @csrf
                    <h5 class="mb-3 text-center">Edit Group</h5>
                    <div class="d-flex gap-2 mb-3">

                        <div>
                            <label class="form-label">Group ID</label>
                            <input type="text" name="group_id" class="form-control
                            @error('group_id') border border-danger @enderror"
                            value="{{old("group_id",$group->group_id)}}">

                            @error('group_id')
                                    <p class="text-danger pt-1">{{$message}}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="form-label">Topic ID</label>
                            <input type="text" class="form-control
                            @error('topic_id') border border-danger @enderror"
                            name="topic_id" value='{{old("topic_id",$group->topic_id)}}'>

                            @error('topic_id')
                                    <p class="text-danger pt-1">{{$message}}</p>
                            @enderror
                        </div>
                    </div>
                    <div class="mb-3">
                    </div>
                    <div class="mb-3">
                        <label for="exampleFormControlSelect1">Group Status</label>
                        <select value='{{$group->group_status? true: false}}' name="group_status" class="form-control" id="exampleFormControlSelect1">
                            <option value={{true}} selected>Active</option>
                            <option value="" @if(!$group->group_status) selected @endif>In-Active</option>
                        </select>
                    </div>
                    <div class="d-flex gap-2 mb-3">

                        <div>
                            <label class="form-label">Password</label>
                            <input type="password" class="form-control
                            @error('password') border border-danger @enderror"
                            name="password" value='{{old("group_password",$group->group_password)}}'>

                            @error('password')
                                    <p class="text-danger pt-1">{{$message}}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="form-label">Confirm Password</label>
                            <input type="password" class="form-control
                            @error('confirm_password') border border-danger @enderror"
                            name="confirm_password"
                            value='{{old("confirm_password",$group->group_password)}}'>

                            @error('confirm_password')
                                    <p class="text-danger pt-1">{{$message}}</p>
                            @enderror
                        </div>

                    </div>

                    <button type="submit" class="btn btn-success px-4">Update</button>
                </form>



            </div>
            <div class="col-md-9 bg px-5 pt-3 right-container">

                <!-- Search bar  -->
                <form class="d-flex align-items-center ms-auto border rounded-pill mb-1" id="search">
                    <input class="form-control me-2 rounded-pill border-0" type="search" placeholder="Search" aria-label="Search">
                    <button class="btn border-0 text-dark p-0" id="search-icon" type="submit"><i class="fas fa-search"></i></button>
                </form>

                <!-- Group Table  -->
                <table class="table">
                    <thead>
                    <tr>
                        <th scope="col">No.</th>
                        <th scope="col">Group ID</th>
                        <th scope="col">Topic ID</th>
                        <th scope="col">Teacher's ID</th>
                        <th scope="col">Group Status</th>
                        <th scope="col">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                        <?php $i = ($groups->currentPage()-1) * 5; ?>
                    @foreach($groups as $group)
                        <tr>
                            <td>{{++$i}}</td>
                            <td>{{$group->group_id}}</td>
                            <td>{{$group->topic_id}}</td>
                            <td>{{$group->t_id}}</td>
                            <td>{{ ($group->group_status)? "Active" : "In-Active"}}</td>
                            <td class="d-flex">
                                <a href="{{url('/teacher/groups/'.$group->id)}}" class="">
                                    <button class="btn btn-info me-1">Edit</button>
                                </a>
                                <form action="/teacher/groups/{{$group->id}}" method="POST">
                                    @method('delete')
                                    @csrf
                                    <button type="submit"
                                    onclick="return confirm('Are you sure you want to delete {{$group->group_id}} ?')"
                                    class="btn btn-danger">Delete</button>
                                </form>
                                <a href="{{url('/teacher/group/manage/'.$group->group_id)}}" class="">
                                    <button class="btn btn-secondary ms-1">Manage</button>
                                </a>
                            </td>
                        </tr>
                    @endforeach

                    </tbody>
                </table>
                <div class="mt-4">
                    {{$groups->links()}}
                </div>
            </div>
        </div>
    </div>


@endsection
