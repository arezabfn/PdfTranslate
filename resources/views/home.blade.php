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
                    <form action="{{route('dashboard.store')}}" method="post" enctype="multipart/form-data">
                        @csrf
                        <label for="images" class="drop-container">
                            <span class="drop-title">Drop files here</span>
                            or
                            <input type="file" id="pdf" name="pdf" accept="pdf/*" required>

                        </label>
                        <button type="submit" class="btn btn-success  mt-2 px-5">Start</button>
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
                            <form class="d-inline mx-3" action="{{route('dashboard.update',$item->id)}}" method="post" enctype="multipart/form-data">
                                @csrf
                                @method('put')
                                <input hidden type="text" vi>
                                <button type="submit" class="btn btn-success">Translate</button>
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
    <script>
        function destroyUser(event,id){
            event.preventDefault();
            document.querySelector('#userdelete-'+id).submit();
        }
    </script>
@endsection
