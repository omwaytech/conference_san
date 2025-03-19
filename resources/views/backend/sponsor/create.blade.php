@extends('layouts.dash')

@section('title')
    {{isset($sponsor) ? 'Edit' : 'Add'}} Sponsor
@endsection

@section('content')
    <div class="main-content">
        <div class="breadcrumb">
            <h1>{{isset($sponsor) ? 'Edit' : 'Add'}} Sponsor</h1>
        </div>
        <div class="separator-breadcrumb border-top"></div>
        <div class="col-md-12">
            <div class="card mb-4">
                <div class="card-body">
                    <form action="{{isset($sponsor) ? route('sponsor.update', $sponsor->id) : route('sponsor.store')}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @isset($sponsor)
                            @method('patch')
                        @endisset
                        <div class="row">
                            <div class="col-md-3 form-group mb-3">
                                <label for="sponsor_category_id">Category <code>*</code></label>
                                <select name="sponsor_category_id" class="form-control @error('sponsor_category_id') is-invalid @enderror">
                                    <option value="" hidden>-- Select Category --</option>
                                    @foreach ($categories as $category)
                                        <option value="{{$category->id}}" @selected(old('sponsor_category_id', @$sponsor->sponsor_category_id) == $category->id)>{{$category->category_name}}</option>
                                    @endforeach
                                </select>
                                @error('sponsor_category_id')
                                    <p class="text-danger">{{$message}}</p>
                                @enderror
                            </div>
                            <div class="col-md-3 form-group mb-3">
                                <label for="name">Name <code>*</code></label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="name" value="{{isset($sponsor) ? $sponsor->name : old('name')}}" placeholder="Enter sponsor name" />
                                @error('name')
                                    <p class="text-danger">{{$message}}</p>
                                @enderror
                            </div>
                            <div class="col-md-3 form-group mb-3">
                                <label for="amount">Amount <code>*</code></label>
                                <input type="text" class="form-control @error('amount') is-invalid @enderror" name="amount" id="amount" value="{{isset($sponsor) ? $sponsor->amount : old('amount')}}" placeholder="Enter amount" />
                                @error('amount')
                                    <p class="text-danger">{{$message}}</p>
                                @enderror
                            </div>
                            <div class="col-md-3 form-group mb-3">
                                <label for="logo">Logo </label>
                                <input type="file" class="form-control @error('logo') is-invalid @enderror" name="logo" id="image" />
                                @error('logo')
                                    <p class="text-danger">{{$message}}</p>
                                @enderror
                                <div class="row" id="imgPreview">
                                    @if (isset($sponsor))
                                        <div class="col-3 mt-2">
                                            <img src="{{asset('storage/sponsors/'.$sponsor->logo)}}" alt="logo" class="img-fluid">
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-3 form-group mb-3">
                                <label for="address">Address </label>
                                <input type="text" class="form-control @error('address') is-invalid @enderror" name="address" id="address" value="{{isset($sponsor) ? $sponsor->address : old('address')}}" placeholder="Enter address" />
                                @error('address')
                                    <p class="text-danger">{{$message}}</p>
                                @enderror
                            </div>
                            <div class="col-md-3 form-group mb-3">
                                <label for="contact_person">Contact Person </label>
                                <input type="text" class="form-control @error('contact_person') is-invalid @enderror" name="contact_person" id="contact_person" value="{{isset($sponsor) ? $sponsor->contact_person : old('contact_person')}}" placeholder="Enter contact person" />
                                @error('contact_person')
                                    <p class="text-danger">{{$message}}</p>
                                @enderror
                            </div>
                            <div class="col-md-3 form-group mb-3">
                                <label for="email">Email </label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" id="email" value="{{isset($sponsor) ? $sponsor->email : old('email')}}" placeholder="Enter email" />
                                @error('email')
                                    <p class="text-danger">{{$message}}</p>
                                @enderror
                            </div>
                            <div class="col-md-3 form-group mb-3">
                                <label for="phone">Phone <code>*</code></label>
                                <input type="text" class="form-control @error('phone') is-invalid @enderror" name="phone" id="phone" value="{{isset($sponsor) ? $sponsor->phone : old('phone')}}" placeholder="Enter phone" />
                                @error('phone')
                                    <p class="text-danger">{{$message}}</p>
                                @enderror
                            </div>
                            <div class="col-md-12 form-group mb-3">
                                <label for="description">Description </label>
                                <textarea class="form-control" name="description" id="description" cols="30" rows="5">{{isset($sponsor) ? $sponsor->description : old('description')}}</textarea>
                                @error('description')
                                    <p class="text-danger">{{$message}}</p>
                                @enderror
                            </div>
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary">{{isset($sponsor) ? 'Update' : 'Submit'}}</button>
                                <a href="{{route('sponsor.index')}}" class="btn btn-danger">Cancel</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
