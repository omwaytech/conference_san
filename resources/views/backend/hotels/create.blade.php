@extends('layouts.dash')

@section('title')
    {{isset($hotel) ? 'Edit' : 'Add'}} Hotel
@endsection

@section('content')
    <div class="main-content">
        <div class="breadcrumb">
            <h1>{{isset($hotel) ? 'Edit' : 'Add'}} Hotel</h1>
        </div>
        <div class="separator-breadcrumb border-top"></div>
        <div class="col-md-12">
            <div class="card mb-4">
                <div class="card-body">
                    <form action="{{isset($hotel) ? route('hotel.update', $hotel->id) : route('hotel.store')}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @isset($hotel)
                            @method('patch')
                        @endisset
                        <div class="row">
                            <div class="col-md-4 form-group mb-3">
                                <label for="name">Hotel Name <code>*</code></label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{isset($hotel) ? $hotel->name : old('name')}}" placeholder="Enter hotel name" />
                                @error('name')
                                    <p class="text-danger">{{$message}}</p>
                                @enderror
                            </div>
                            <div class="col-md-4 form-group mb-3">
                                <label for="address">Address <code>*</code></label>
                                <input type="text" class="form-control @error('address') is-invalid @enderror" name="address" value="{{isset($hotel) ? $hotel->address : old('address')}}" placeholder="Enter hotel address" />
                                @error('address')
                                    <p class="text-danger">{{$message}}</p>
                                @enderror
                            </div>
                            <div class="col-md-4 form-group mb-3">
                                <label for="contact_person">Contact Person </label>
                                <input type="text" class="form-control @error('contact_person') is-invalid @enderror" name="contact_person" value="{{isset($hotel) ? $hotel->contact_person : old('contact_person')}}" placeholder="Enter contact person name" />
                                @error('contact_person')
                                    <p class="text-danger">{{$message}}</p>
                                @enderror
                            </div>
                            <div class="col-md-4 form-group mb-3">
                                <label for="phone">Contact Number </label>
                                <input type="text" class="form-control @error('phone') is-invalid @enderror" name="phone" value="{{isset($hotel) ? $hotel->phone : old('phone')}}" placeholder="Enter hotel contact number" />
                                @error('phone')
                                    <p class="text-danger">{{$message}}</p>
                                @enderror
                            </div>
                            <div class="col-md-4 form-group mb-3">
                                <label for="email">Email </label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{isset($hotel) ? $hotel->email : old('email')}}" placeholder="Enter hotel email address" />
                                @error('email')
                                    <p class="text-danger">{{$message}}</p>
                                @enderror
                            </div>
                            <div class="col-md-4 form-group mb-3">
                                <label for="rating">Rating </label>
                                <select name="rating" class="form-control @error('rating') is-invalid @enderror" id="rating">
                                    <option value="">-- Give Rating --</option>
                                    <option value="1" @if(isset($hotel)) {{$hotel->rating == 1 ? 'selected' : ''}} @else @selected(old('rating') == '1') @endif>1</option>
                                    <option value="2" @if(isset($hotel)) {{$hotel->rating == 2 ? 'selected' : ''}} @else @selected(old('rating') == '2') @endif>2</option>
                                    <option value="3" @if(isset($hotel)) {{$hotel->rating == 3 ? 'selected' : ''}} @else @selected(old('rating') == '3') @endif>3</option>
                                    <option value="4" @if(isset($hotel)) {{$hotel->rating == 4 ? 'selected' : ''}} @else @selected(old('rating') == '4') @endif>4</option>
                                    <option value="5" @if(isset($hotel)) {{$hotel->rating == 5 ? 'selected' : ''}} @else @selected(old('rating') == '5') @endif>5</option>
                                </select>
                                @error('rating')
                                    <p class="text-danger">{{$message}}</p>
                                @enderror
                            </div>
                            <div class="col-md-4 form-group mb-3">
                                <label for="price">Price </label>
                                <input type="text" class="form-control @error('price') is-invalid @enderror" name="price" value="{{isset($hotel) ? $hotel->price : old('price')}}" placeholder="Enter hotel contact number" />
                                @error('price')
                                    <p class="text-danger">{{$message}}</p>
                                @enderror
                            </div>
                            <div class="col-md-4 form-group mb-3">
                                <label for="website">Website </label>
                                <input type="text" class="form-control @error('website') is-invalid @enderror" name="website" value="{{isset($hotel) ? $hotel->website : old('website')}}" placeholder="Enter hotel contact number" />
                                @error('website')
                                    <p class="text-danger">{{$message}}</p>
                                @enderror
                            </div>
                            <div class="col-md-4 form-group mb-3">
                                <label for="promo_code">Promo Code </label>
                                <input type="text" class="form-control @error('promo_code') is-invalid @enderror" name="promo_code" value="{{isset($hotel) ? $hotel->promo_code : old('promo_code')}}" placeholder="Enter hotel contact number" />
                                @error('promo_code')
                                    <p class="text-danger">{{$message}}</p>
                                @enderror
                            </div>
                            <div class="col-md-4 form-group mb-3">
                                <label for="featured_image">Logo <code>(Only JPG/PNG)</code></label>
                                <input type="file" class="form-control @error('featured_image') is-invalid @enderror" name="featured_image" id="image" />
                                @error('featured_image')
                                    <p class="text-danger">{{$message}}</p>
                                @enderror
                                <div class="row" id="imgPreview">
                                    @if (isset($hotel))
                                        <div class="col-3 mt-2">
                                            <img src="{{asset('storage/hotel/featured-image/'.$hotel->featured_image)}}" alt="image" class="img-fluid">
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-12 form-group mb-3">
                                <label for="pics">Other Images <code>(Maximum Images: 4 & Only JPG/PNG)</code></label>
                                <input type="file" class="form-control @error('pics') is-invalid @enderror" name="pics[]" id="imagesMultiple" multiple />
                                @error('pics')
                                    <p class="text-danger">{{$message}}</p>
                                @enderror
                                @if ($errors->get('pics.*'))
                                    <p class="text-danger">Images must be jpg or png.</p>
                                @endif
                                <div class="row" id="imagesPreview"></div>
                                <div class="row">
                                    @if (isset($hotel) && !empty($hotel->images))
                                        @foreach ($hotel->images as $img)
                                            <div class="col-3 mt-2">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <img src="{{asset('storage/hotel/images/thumbnail/'.$img['fileName'])}}" alt="img" height="100" class="img-fluid">
                                                        <input type="text" name="room_type_old[]" class="form-control mt-1" placeholder="Enter Room Type" value="{{$img['room_type']}}">
                                                    </div>
                                                    <div class="col-12 mt-1 text-center">
                                                        <a href="{{route('hotel.image.delete', [$hotel->id, $img['fileName']])}}" class="btn btn-danger btn-sm imgDelete">Remove</a>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-12 form-group mb-3">
                                <label for="description">Description </label>
                                <textarea class="form-control" name="description" id="description" cols="30" rows="5">{{isset($hotel) ? $hotel->description : old('description')}}</textarea>
                                @error('description')
                                    <p class="text-danger">{{$message}}</p>
                                @enderror
                            </div>
                            <div class="col-md-12 form-group mb-3">
                                <label for="facility">Facility </label>
                                <textarea class="form-control" name="facility" id="facility" cols="30" rows="5">{{isset($hotel) ? $hotel->facility : old('facility')}}</textarea>
                                @error('facility')
                                    <p class="text-danger">{{$message}}</p>
                                @enderror
                            </div>
                            <div class="col-md-12 form-group mb-3">
                                <label for="google_map">Google Map </label>
                                <input type="text" class="form-control @error('google_map') is-invalid @enderror" name="google_map" value="{{isset($hotel) ? $hotel->google_map : old('google_map')}}" placeholder="Enter hotel google map" />
                                @error('google_map')
                                    <p class="text-danger">{{$message}}</p>
                                @enderror
                            </div>
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary">{{isset($hotel) ? 'Update' : 'Submit'}}</button>
                                <a href="{{route('hotel.index')}}" class="btn btn-danger">Cancel</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script>
    $("#imagesMultiple").change(function(e) {
        e.preventDefault();
        let files = e.target.files

        $("#imagesPreview").html('');

        for (let file of files) {
            $("#imagesPreview").append(
                '<div class="col-3 mt-2">' +
                    `<img src="${URL.createObjectURL(file)}" class="mb-2" height="100"/>` +
                    '<input type="text" name="room_type[]" class="form-control" placeholder="Enter Room Type">' +
                '</div>'
            );
        }
    });
</script>
@endsection
