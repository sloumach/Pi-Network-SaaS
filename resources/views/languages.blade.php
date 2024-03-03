@extends('layouts.app')

@section('content')
<div class="container ">
    <div class="row justify-content-center " style="margin-top:5%">


            <div class="col col-lg-8 col-md-8 col-sm-8 m-2 " align="center">
                <div class="card">
                    <div class="card-header text-white" style="background-color: purple">{{ __('Subject') }}</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('GetLanguage') }}">
                            @csrf

                            <div class="row mb-3">
                                <label for="subject" class="col-md-4 col-form-label text-md-end">{{ __('Topic') }}</label>

                                <div class="col-md-6">
                                    <input id="subject" type="text" class="form-control " name="subject" value="" required  autofocus>
                                </div>
                            </div>

                            <div class="row mb-3 justify-content-center">
                                <div class="col-md-8 offset-md-4 ">
                                    <button type="submit" class="btn btn-primary border-0" style="background-color: purple">
                                        {{ __('Get Article') }}
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
