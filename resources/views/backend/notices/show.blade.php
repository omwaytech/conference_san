@extends('layouts.dash')

@section('title')
    Updates/Notices
@endsection

@section('content')
    <div class="row mb-4">
        <div class="col-md-12 mb-3">
            <div class="card text-left">
                <div class="card-body">
                    <div class="row mb-2">
                        <h4 class="card-title">News/Notices</h4>
                        <div class="ml-auto">
                            <a href="{{ route('notice.create') }}" class="btn btn-primary"> Add</a>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered" id="zero_configuration_table" style="width: 100%;">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Title</th>
                                    <th scope="col">Date</th>
                                    <th scope="col">Image</th>
                                    {{-- <th scope="col">Is Featured?</th> --}}
                                    <th scope="col" style="width: 12%">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($notices as $notice)
                                    <tr>
                                        <th scope="row">{{$loop->iteration}}</th>
                                        <td>
                                            {{$notice->title}}
                                        </td>
                                        <td>{{!empty($notice->date) ? \Carbon\Carbon::parse($notice->date)->format('d M, Y') : '-'}}</td>
                                        <td>
                                            <a href="{{asset('storage/notice/'.$notice->image)}}" target="_blank"><img src="{{asset('storage/notice/'.$notice->image)}}" alt="image" height="40"></a>
                                        </td>
                                        {{-- <td>
                                            @if ($notice->is_featured == 1)
                                                <a href="{{route('notice.changeFeatured', $notice->id)}}" class="btn btn-success btn-sm ml-2" title="Remove Featured"><i class="nav-icon i-Yes"></i></a>
                                            @else
                                                <a href="{{route('notice.changeFeatured', $notice->id)}}" class="btn btn-danger btn-sm ml-2" title="Make Featured"><i class="nav-icon i-Close-Window"></i></a>
                                            @endif
                                        </td> --}}
                                        <td>
                                            <form action="{{route('notice.destroy', $notice->id)}}" method="POST">
                                                @method('delete')
                                                @csrf
                                                <a href="{{route('notice.edit', $notice->id)}}" class="btn btn-sm btn-success mb-1" title="Edit Data"><i class="nav-icon i-Pen-2"></i></a>
                                                <button class="btn btn-sm btn-info viewData mb-1" type="button" data-id="{{$notice->id}}" data-toggle="modal" data-target="#openModal"><i class="nav-icon i-Eye"></i></button>
                                                <button title="Delete Data" class="btn btn-sm btn-danger delete mb-1" type="submit"><i class="nav-icon i-Close-Window"></i></button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="modal fade" id="openModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                        <div class="modal-dialog modal-lg custom-modal-width">
                            <div class="modal-content" id="modalContent">
                                {{-- modal body goes here --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script>
    $(document).ready(function () {
        $(document).on("click", ".viewData", function (e) {
            e.preventDefault();
            var url = '{{route('notice.show')}}';
            var _token = '{{csrf_token()}}';
            var id = $(this).data('id');
            var data = {_token:_token, id:id};
            $.post(url, data, function(response){
                $('#modalContent').html(response);
            });
        });
    });
</script>
@endsection
