@extends('layouts.dash')

@section('title')
    Download Files
@endsection

@section('content')
    <div class="row mb-4">
        <div class="col-md-12 mb-3">
            <div class="card text-left">
                <div class="card-body">
                    <div class="row mb-2">
                        <h4 class="card-title">Download Files</h4>
                        <div class="ml-auto">
                            <a href="{{ route('download.create') }}" class="btn btn-primary"> Add</a>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered" id="zero_configuration_table" style="width: 100%;">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Title</th>
                                    <th scope="col">File</th>
                                    <th scope="col">Is Featured?</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($downloads as $download)
                                    <tr>
                                        <th scope="row">{{$loop->iteration}}</th>
                                        <td>{{$download->title}}</td>
                                        <td>
                                            <a href="{{asset('storage/downloads/'.$download->file)}}" target="_blank">
                                                @php
                                                    $fileName = explode('.', $download->file);
                                                @endphp
                                                @if ($fileName[1] == 'pdf')
                                                    <img src="{{asset('default-images/pdf.png')}}" height="50" alt="pdf">
                                                @elseif ($fileName[1] == 'doc' || $fileName[1] == 'docx')
                                                    <img src="{{asset('default-images/word.png')}}" height="50" alt="word file">
                                                @else
                                                    <img src="{{asset('storage/downloads/'.$download->file)}}" height="50" alt="image">
                                                @endif
                                            </a>
                                        </td>
                                        <td>
                                            @if ($download->is_featured == 1)
                                                <a href="{{route('download.changeFeatured', $download->id)}}" class="btn btn-success btn-sm ml-2" title="Remove Featured"><i class="nav-icon i-Yes"></i></a>
                                            @else
                                                <a href="{{route('download.changeFeatured', $download->id)}}" class="btn btn-danger btn-sm ml-2" title="Make Featured"><i class="nav-icon i-Close-Window"></i></a>
                                            @endif
                                        </td>
                                        <td>
                                            <form action="{{route('download.destroy', $download->id)}}" method="POST">
                                                @method('delete')
                                                @csrf
                                                <a href="{{route('download.edit', $download->id)}}" class="btn btn-sm btn-success" title="Edit Data"><i class="nav-icon i-Pen-2"></i></a>
                                                <button title="Delete Data" class="btn btn-sm btn-danger delete" type="submit"><i class="nav-icon i-Close-Window"></i></button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
