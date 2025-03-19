@extends('layouts.dash')

@section('title')
    Member Types Price
@endsection

@section('content')
    <div class="row mb-4">
        <div class="col-md-12 mb-3">
            <div class="card text-left">
                <div class="card-body">
                    <div class="row mb-2">
                        @if (!empty($latestConference))
                            <h4 class="card-title">Member Types Price For Conference ({{$latestConference->conference_theme}})</h4>
                        @else
                            <h4 class="card-title text-danger">NOTE: Atleast one conference is required to add price related to it.</h4>
                        @endif
                    </div>
                    <div class="table-responsive">
                        <div class="table-responsive">
                            <form action="{{route('member-type-price.update')}}" method="POST" enctype="multipart/form-data" id="priceForm">
                                @csrf
                                <table class="table table-bordered" id="dynamic_field">
                                    <thead>
                                        <tr>
                                            <th>Member Type</th>
                                            <th>Early Bird Amount</th>
                                            <th>Regular Amount</th>
                                            <th>On-Site Amount</th>
                                            <th>Guest Amount</th>
                                        </tr>
                                    </thead>
                                    @foreach ($memberTypes as $memberType)
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <label>{{$loop->iteration}}) {{$memberType->type}} <small class="text-danger">(Price in {{$memberType->delegate == 'National' ? 'Rs.' : '$'}})</small></label>
                                                    <input type="hidden" name="member_type_id[]" value="{{$memberType->id}}">
                                                    <input type="hidden" name="price_id[]" value="{{$memberType->price_id}}">
                                                    <input type="hidden" name="conference_id" value="{{$memberType->conference_id}}">
                                                </td>
                                                <td>
                                                    <input type="number" name="early_bird_amount[]" value="{{$memberType->early_bird_amount}}" placeholder="Enter early bird amount" class="form-control priceList"/>
                                                </td>
                                                <td>
                                                    <input type="number" name="regular_amount[]" value="{{$memberType->regular_amount}}" placeholder="Enter regular amount" class="form-control priceList"/>
                                                </td>
                                                <td>
                                                    <input type="number" name="on_site_amount[]" value="{{$memberType->on_site_amount}}" placeholder="Enter on-site amount" class="form-control priceList"/>
                                                </td>
                                                <td>
                                                    <input type="number" name="guest_amount[]" value="{{$memberType->guest_amount}}" placeholder="Enter guest amount" class="form-control priceList"/>
                                                </td>
                                            </tr>
                                        </tbody>
                                    @endforeach
                                </table>
                                <div class="text-right">
                                    <button type="submit" class="btn btn-primary" id="submitButton">{{empty($memberTypes[0]->price_id) ? 'Submit' : 'Update'}}</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script type="text/javascript">
        $(document).ready(function () {
            $(".priceList").on("keydown", function(event) {
            // Allow backspace, delete, tab, escape, and enter keys
                if (event.keyCode == 46 || event.keyCode == 8 || event.keyCode == 9 || event.keyCode == 27 || event.keyCode == 13 ||
                    // Allow Ctrl+A
                    (event.keyCode == 65 && event.ctrlKey === true) ||
                    // Allow home, end, left, right
                    (event.keyCode >= 35 && event.keyCode <= 39) ||
                    // Allow numbers from the main keyboard (0-9) and the numpad (96-105)
                    (event.keyCode >= 48 && event.keyCode <= 57) || (event.keyCode >= 96 && event.keyCode <= 105)) {
                        return;
                } else {
                    event.preventDefault();
                }
            });

            $("#submitButton").click(function(e) {
                e.preventDefault();
                $(this).attr('disabled', true);
                $("#priceForm").submit();
            });
        });
    </script>
@endsection
