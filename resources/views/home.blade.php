@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-3">
            <div class="card">
                <div class="card-header">Quick Links</div>

                <div class="card-body">
                    @include('admin.quickLink.link')
                </div>
            </div>
        </div>
        <div class="col-md-9">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    <form action="{{route('dashboard.store')}}" id="file_upload" method="post" enctype="multipart/form-data">
                        @csrf
                        <label for="images" class="drop-container">
                            <span class="drop-title">Drop files here</span>
                            or
                            <input type="file" id="pdf" name="pdf" accept="pdf/*" required>

                        </label>
                        <button id="button" type="submit" class="btn btn-success  mt-2 px-5">Start</button>
                        <div id="loading"></div>
                        <div id="loading-text"></div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-6 mt-2">
            <div class="card">
                <div class="card-header">Files</div>

                <div class="card-body">
                    <div class="details">
                        @foreach($file as $item)
                                ID : {{$item->id}}
                                <a
                                    class="btn btn-info mx-2"
                                    href = "{{asset('file/'.$item->name)}}"
                                   Download = "file-".{{$item->name}}>
                                    Download
                                </a>
                            <form class="d-inline mx-3" id="file_upload_2" action="{{route('dashboard.update',$item->id)}}" method="post" enctype="multipart/form-data">
                                @csrf
                                @method('put')

                                <input hidden type="text" vi>
                                <button type="submit" id="button2" class="btn btn-success">Translate</button>
                            </form>
                                <span style="color: brown">{{$item->name}}</span>
                                <a href="" onclick="destroyUser(event,{{$item->id}})" class="btn btn-danger px-5 mx-3">حذف</a>
                                <form action="{{route('dashboard.destroy',$item->id)}}" id="userdelete-{{$item->id}}" method="post">
                                    @csrf
                                    @method('delete')
                                </form>
                            <hr>
                            <div class="empty mt-2"></div>
                        @endforeach

                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
@section('js')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <script>
        function destroyUser(event,id){
            event.preventDefault();
            document.querySelector('#userdelete-'+id).submit();
        }
    </script>

    <script>
            $(document).ready(function () {
                function showLoading() {
                    $('#loading').show();
                    // $('#button').attr('disabled', 'disabled');
                    $('#loading-text').text('Please wait for upload , tokenize , translate ...');
                }

                $(document).ready(function() {
                    $('#button').click(function() {

                        showLoading();
                    });
                    $('#button2').click(function() {

                        showLoading();
                    });
                });

            });
    </script>
@endsection
