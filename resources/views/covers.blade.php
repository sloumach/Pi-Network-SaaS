@extends('layouts.app')

@section('content')
<div class="container ">
    <div class="row justify-content-center " style="margin-top:5%">


            <div class="col col-lg-8 col-md-8 col-sm-8 m-2 " align="center">
                <div class="card">
                    <div class="card-header text-white" style="background-color: purple"><p class="my-0" style="color:#f0d419;">{{ __('Subject') }}</p></div>

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
                            <div class="row mb-3">
                                <label for="role" class="col-md-4 col-form-label text-md-end">{{ __('Projects') }}</label>

                                <div class="col-md-6">
                                    <textarea rows="4" cols="50"  class="form-control " name="projects"  required  autofocus> </textarea>

                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="role" class="col-md-4 col-form-label text-md-end">{{ __('Cover Language') }}</label>

                                <div class="col-md-6">
                                    <select id="language" class="form-control " name="coverlanguage" data-placeholder="{{ __('Select input language') }}" >
                                        @foreach ($langs as $language)
                                            <option value="{{ $language->language_code }}" data-img="{{ URL::asset($language->language_flag) }}" > {{ $language->language }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary border-0" style="color:#f0d419;background-color: purple">
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
@push('scripts')
<!-- Inclusion de Select2 CSS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

    <script>
    $(document).ready(function() {
        function formatState (state) {
            if (!state.id) {
                return state.text;
            }

            var baseUrl = "/img/flags";
            var $state = $(
                '<span><img src="' + $(state.element).data('img') + '" class="img-flag" /> ' + state.text + '</span>'            );
            return $state;
            };

            $("#language").select2({
            templateResult: formatState,
            templateSelection: formatState
            });
    });
    </script>
@endpush
@endsection
