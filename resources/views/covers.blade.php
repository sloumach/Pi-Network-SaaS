@extends('layouts.app')

@section('content')
<div class="container ">
    <div class="row justify-content-center " style="margin-top:5%">


            <div class="col col-lg-8 col-md-8 col-sm-8 m-2 " align="center">
                <div class="card">
                    <div class="card-header">{{ __('Cover Letter') }}</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('GetCover') }}">
                            @csrf

                            <div class="row mb-3">
                                <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('Your full name:') }}</label>

                                <div class="col-md-6">
                                    <input id="name" type="text" class="form-control " name="name" value="" required autocomplete="name" autofocus>

                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="company_name" class="col-md-4 col-form-label text-md-end">{{ __('Company name:') }}</label>

                                <div class="col-md-6">
                                    <input id="company" type="text" class="form-control " name="company" value="" required  autofocus>

                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="role" class="col-md-4 col-form-label text-md-end">{{ __('Position') }}</label>

                                <div class="col-md-6">
                                    <input id="position" type="text" class="form-control " name="position" value="" required  autofocus>

                                </div>
                            </div>

                            <div class="row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Get Cover Letter') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
        </div>


    </div>

</div>
@endsection
