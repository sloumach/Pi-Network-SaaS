@extends('layouts.app')

@section('content')
<div class="container ">
    <div class="row justify-content-center " style="margin-top:5%">


            <div class="col col-lg-12 col-md-8 col-sm-8 m-2 " align="center">
                {{-- <div class="card-header">{{ __('Subject') }}</div> --}}
                <table class="table table-striped table-hover">

                        <thead>
                          <tr>
                            <th scope="col" class="col-1 text-center"></th>
                            <th scope="col" class="col-2 text-center">Company</th>
                            <th scope="col" class="col-2 text-center">Candidate Name</th>
                            <th scope="col" class="col-1 text-center">options</th>
                          </tr>
                        </thead>
                        <tbody>
                            @php
                                $counter = 1;
                            @endphp
                            @foreach ($coverletters as $cover )
                            <tr >
                                <th scope="row" class="text-center text-white" style="background-color: purple" >{{ $counter }}</th>
                                @if ($cover->status == "error")
                                <td class="text-center">...</td>
                                @else
                                <td class="text-center">{{ substr($cover->letter, 0, 90) }}...</td>
                                @endif
                                @if ($cover->status != "error")
                                <td class="text-center" >{{ $cover->status }}</td>
                                @else
                                <td class="text-center" >Error while générating, due to high demand</td>

                                @endif

                                <td class="text-center">
                                    @if ($cover->status == "in progress"  )

                                    <div  id="spinner-{{ $cover->id }}" class="spinner-border text-primary" role="status">
                                        <span class="visually-hidden">Loading...</span>
                                      </div>

                                    @endif
                                    @if ($cover->status == "completed")

                                    <a href="{{ route('editor', ['id' => $cover->id,'type'=>$type]) }}" class="btn btn-success border-0" style="background-color: purple">
                                        {{ __('Show') }}
                                    </a>

                                    @endif
                                    @if ($cover->status == "error"  )


                                       <span><svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" fill="currentColor" class="bi bi-exclamation-circle-fill" viewBox="0 0 16 16">
                                        <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0M8 4a.905.905 0 0 0-.9.995l.35 3.507a.552.552 0 0 0 1.1 0l.35-3.507A.905.905 0 0 0 8 4m.002 6a1 1 0 1 0 0 2 1 1 0 0 0 0-2"/>
                                      </svg></span>


                                    @endif
                                </td>
                              </tr>
                                @php
                                    $counter++;
                                @endphp
                            @endforeach
                          {{-- <tr>
                            <th scope="row" class="text-center" >1</th>
                            <td class="">MarkMarkMarkMarkMarkMarkMarkMarkMarkMarkMarkMark</td>
                            <td >OttoOttoOttoOttoOttoOttoOttoOttoOttoOttoOtto</td>
                            <td ><button type="submit" class="btn btn-success border-0" style="background-color:purple">
                                {{ __('Show') }}
                            </button></td>
                          </tr> --}}

                        </tbody>
                      </table>
                  </table>
                </div>
        </div>


    </div>

</div>
@push('scripts')
    <script src="{{ asset('js/coverslistener.js') }}"></script>
@endpush
@endsection
