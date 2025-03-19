@extends('layouts.dash')

@section('title')
    Committee Members
@endsection

@section('content')
    <div class="row mb-4">
        <div class="col-md-12 mb-3">
            <div class="card text-left">
                <div class="card-body">
                    <div class="row mb-2">
                        <h4 class="card-title">Committee Members Of <span
                                class="text-danger">{{ $committee->committee_name }}</span></h4>
                        <div class="ml-auto">
                            <a href="{{ route('committee.index', $committee->slug) }}" class="btn btn-danger"> Back</a>
                            <a href="{{ route('committeeMember.create', $committee->slug) }}" class="btn btn-primary">
                                Add</a>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered" id="zero_configuration_table" style="width: 100%;">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Designation</th>
                                    <th scope="col">Is Featured ?</th>
                                    <th scope="col" style="width: 12%">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($committee->committeeMembers->where('conference_id', $latestConference->id)->where('status', 1) as $member)
                                    <tr>
                                        <th scope="row">{{ $loop->iteration }}</th>
                                        @if ($member->user)
                                            <td>{{ $member->user->fullName($member, 'user') }}</td>
                                        @else
                                            <td>

                                                ''
                                            </td>
                                        @endif
                                        <td>{{ $member->designation->designation }}</td>
                                        <td>
                                            @if ($member->is_featured == 1)
                                                <a href="{{ route('committeeMember.changeFeatured', $member->id) }}"
                                                    class="btn btn-success btn-sm ml-2" title="Remove Featured"><i
                                                        class="nav-icon i-Yes"></i></a>
                                            @else
                                                <a href="{{ route('committeeMember.changeFeatured', $member->id) }}"
                                                    class="btn btn-danger btn-sm ml-2" title="Make Featured"><i
                                                        class="nav-icon i-Close-Window"></i></a>
                                            @endif
                                        </td>
                                        <td>
                                            <form action="{{ route('committeeMember.destroy', $member->id) }}"
                                                method="POST">
                                                @method('delete')
                                                @csrf
                                                <a href="{{ route('committeeMember.edit', $member->id) }}"
                                                    class="btn btn-success btn-sm" title="Edit Data"><i
                                                        class="nav-icon i-Pen-2"></i></a>
                                                <button title="Delete Data" class="btn btn-danger btn-sm delete"
                                                    type="submit"><i class="nav-icon i-Close-Window"></i></button>
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
