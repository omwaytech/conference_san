@extends('layouts.dash')

@section('title')
    Duplicated Council Numbers
@endsection

@section('content')
    <div class="row mb-4">
        <div class="col-md-12 mb-3">
            <div class="card text-left">
                <div class="card-body">
                    <div class="row mb-2">
                        <h4 class="card-title">
                            Duplicated Council Numbers
                        </h4>
                        <div class="ml-auto">
                            <a href="{{ route('home') }}" class="btn btn-danger"> Back</a>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered" id="zero_configuration_table" style="width: 100%;">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Council Number</th>
                                    <th scope="col">Total Signed Up</th>
                                    <th scope="col">Total Duplicated Registrations</th>
                                    <th scope="col" style="width: 9%">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($councilNumbers as $councilNumber)
                                    <tr>
                                        <th scope="row">{{$loop->iteration}}</th>
                                        <td>{{$councilNumber->council_number}}</td>
                                        <td>{{$councilNumber->totalNumbers}}</td>
                                        @php
                                            $userDatas = App\Models\UserDetail::where(['council_number' => $councilNumber->council_number, 'status' => 1])->get();
                                            $i = 0;
                                            foreach ($userDatas as $userData) {
                                                if (!empty($userData->user->conferenceRegistration)) {
                                                    $i++;
                                                }
                                            }
                                        @endphp
                                        <td>{{$i}}</td>
                                        <td>
                                            <a href="{{route('home.conferenceDuplicateDatas', $councilNumber->council_number)}}" target="_blank" class="btn btn-sm btn-info" type="button"><i class="nav-icon i-Eye"> View Data</i></a>
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
