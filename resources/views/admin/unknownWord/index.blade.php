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
                    <div class="card-header">Unknown Words</div>
                    <div class="card-body">
                        <table id="unknowTable" class="display nowrap" style="width:100%">
                            <thead>
                            <tr>
                                <th>#Q</th>
                                <th>Word</th>
                                <th>Translate</th>
                                <th>Root</th>
                                <th>Level</th>
{{--                                <th>type</th>--}}
                                <th>Difficulty percentage</th>
                                <th>Repeat</th>
                                <th>Add to</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($unknown as $item)
                                <tr>
                                    <td>{{$item->id}}</td>
                                    <td>{{$item->word}}</td>
                                    <td>{{$item->translate}}</td>
                                    <td>{{$item->root}}</td>
                                    <td>{{$item->level}}</td>
{{--                                    <td>{{$item->type}}</td>--}}
                                    <td>
                                        <div class="progress">
                                            <div class="progress-bar" role="progressbar" style="width: {{$item->difficultyRate}}%">{{$item->difficultyRate}}%</div>
                                        </div>
                                        {{--                                        <progress id="file" value="" title="{{$item->difficultyRate}}" max="100">ige</progress>--}}
                                    </td>
                                    <td>{{$item->repetition}}</td>
                                    <td>
                                        <a class="btn btn-warning" onclick="addsimple()" href="{{route('simple.edit', ['id' => $item->id])}}">Simple</a>
                                        <a class="btn btn-dark" onclick="addknown()" href="{{route('known.edit', ['id' => $item->id])}}">Known</a>
                                    </td>
                                </tr>
                            @endforeach

                            </tbody>
                            <tfoot>
                            <tr>
                                <th>#Q</th>
                                <th>Word</th>
                                <th>Translate</th>
                                <th>Root</th>
                                <th>Level</th>
                                <th>Difficulty percentage</th>
                                <th>Repeat</th>
                            </tr>
                            </tfoot>
                        </table>
                        <a class="btn btn-danger"  href="{{route('unknown.create')}}">Remove All Data In Unknown Table</a>


                    </div>
                </div>
            </div>

        </div>
    </div>






@endsection
@section('js')
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/2.3.6/js/dataTables.buttons.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.html5.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.html5.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.print.mi"></script>
    <script>
        function addsimple()
        {

            alert("Your Item Added To SimpleWords");
        }
        function addknow()
        {
            alert("Your Item Added To KnowWords");
        }
        $(document).ready(function() {

            $('#unknowTable').DataTable( {
                dom: 'Bfrtip',
                buttons: [
                    'copy', 'csv', 'excel', 'pdf', 'print'
                ],
                responsive: true
            } );

        } );
    </script>
@endsection
