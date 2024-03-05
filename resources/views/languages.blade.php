@extends('layouts.app')

@section('content')
<div class="container ">
    <div class="row justify-content-center " style="margin-top:5%">


            <div class="col col-lg-8 col-md-8 col-sm-8 m-2 " align="center">
                <div class="card">
                    <div class="card-header text-white" style="background-color: purple"><p class="my-0" style="color:#f0d419;">{{ __('Subject') }}</p></div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('GetLanguage') }}">
                            @csrf

                            <div class="row mb-3">
                                <label for="subject" class="col-md-4 col-form-label text-md-end">{{ __('Topic') }}</label>

                                <div class="col-md-6">
                                    <input id="subject" type="text" class="form-control " name="subject" value="" required  autofocus>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="subject" class="col-md-4 col-form-label text-md-end">{{ __('Test') }}</label>

                                <div class="col-md-6">
                                    <select class="form-select" aria-label="Default select example" name="exam">
                                        <option></option>
                                        <option value="1">TCF</option>
                                        <option value="2">IELTS</option>
                                      </select>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="subject" class="col-md-4 col-form-label text-md-end">{{ __('Level') }}</label>

                                <div class="col-md-6">
                                    <select class="form-select" aria-label="Default select example" name="level">
                                        <option></option>
                                        <option value="A1">A1</option>
                                        <option value="A2">A2</option>
                                        <option value="B1">B1</option>
                                        <option value="B2">B2</option>
                                        <option value="C1">C1</option>
                                        <option value="C2">C2</option>
                                      </select>
                                </div>
                            </div>

                            <div class="row mb-3 justify-content-center">
                                <div class="col-md-8 offset-md-4 ">
                                    <button type="submit" class="btn btn-primary border-0" style="color:#f0d419;background-color: purple">
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
