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
                            <tr>
                                <th scope="row" class="text-center" >{{ $counter }}</th>
                                <td class="text-center">{{ substr($cover->letter, 0, 90) }}...</td>
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
                                    @if ($cover->status == "completed"  )

                                    <a href="{{ route('editor', ['id' => $cover->id]) }}" class="btn btn-success border-0" style="background-color: purple">
                                        {{ __('Show') }}
                                    </a>

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
