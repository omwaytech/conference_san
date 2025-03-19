@extends('layouts.dash')

@section('title')
    Certificate Backgournd Themes
@endsection

@section('content')
    <div class="row mb-4">
        <div class="col-md-12 mb-3">
            <div class="card text-left">
                <div class="card-body">
                    <div class="row mb-2">
                        <h4 class="card-title">Certificate Backgournd Themes</h4>
                        <div class="ml-auto">
                            <a href="{{ route('background.create') }}" class="btn btn-primary"> Add</a>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered" id="zero_configuration_table" style="width: 100%;">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Background Theme</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($backgrounds as $background)
                                    <tr>
                                        <th scope="row">{{$loop->iteration}}</th>
                                        <td><a href="{{asset('storage/certificates/background-theme/'.$background->background_theme)}}" target="_blank"><img src="{{asset('storage/certificates/background-theme/'.$background->background_theme)}}" height="100" alt="image"></a></td>
                                        <td>
                                            <form action="{{route('background.destroy', $background->id)}}" method="POST">
                                                @method('delete')
                                                @csrf
                                                <a href="{{route('background.edit', $background->id)}}" class="btn btn-success" title="Edit Data"><i class="nav-icon i-Pen-2"></i></a>
                                                {{-- <button title="Delete Data" class="btn btn-danger delete" type="submit"><i class="nav-icon i-Close-Window"></i></button> --}}
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
