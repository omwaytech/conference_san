@extends('layouts.dash')

@section('title')
    Contents
@endsection

@section('content')
    <div class="row mb-4">
        <div class="col-md-12 mb-3">
            <div class="card text-left">
                <div class="card-body">
                    <div class="row mb-2">
                        <h4 class="card-title">Contents</h4>
                        <div class="ml-auto">
                            <a href="{{ route('content.create') }}" class="btn btn-primary"> Add</a>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered" id="zero_configuration_table" style="width: 100%;">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Title</th>
                                    <th scope="col">File</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($contents as $content)
                                    <tr>
                                        <th scope="row">{{$loop->iteration}}</th>
                                        <td>{{$content->title}}</td>
                                        <td>
                                            @if (!empty($content->file))
                                                <a href="{{asset('storage/contents/'.$content->file)}}" target="_blank">
                                                    @php
                                                        $fileName = explode('.', $content->file);
                                                    @endphp
                                                    @if ($fileName[1] == 'pdf')
                                                        <img src="{{asset('default-images/pdf.png')}}" height="50" alt="pdf">
                                                    @elseif ($fileName[1] == 'doc' || $fileName[1] == 'docx')
                                                        <img src="{{asset('default-images/word.png')}}" height="50" alt="word file">
                                                    @else
                                                        <img src="{{asset('storage/contents/'.$content->file)}}" height="50" alt="image">
                                                    @endif
                                                </a>
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td>
                                            <form action="{{route('content.destroy', $content->id)}}" method="POST">
                                                @method('delete')
                                                @csrf
                                                <a href="{{route('content.edit', $content->id)}}" class="btn btn-sm btn-success" title="Edit Data"><i class="nav-icon i-Pen-2"></i></a>
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
