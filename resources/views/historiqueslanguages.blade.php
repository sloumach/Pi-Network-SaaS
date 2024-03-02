@extends('layouts.app')

@section('content')
<div class="container ">
    <div class="row justify-content-center " style="margin-top:5%">


            <div class="col col-lg-12 col-md-8 col-sm-8 m-2 " align="center">
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
                            @foreach ($articles as $article )
                            <tr>
                                <th scope="row" class="text-center" >{{ $counter }}</th>
                                <td class="text-center">{{ substr($article->letter, 0, 90) }}...</td>
                                @if ($article->status != "error")
                                <td class="text-center" >{{ $article->status }}</td>
                                @else
                                <td class="text-center" >Error while générating, due to high demand</td>

                                @endif

                                <td class="text-center">
                                    @if ($article->status == "in progress"  )

                                    <div  id="spinner-{{ $article->id }}" class="spinner-border text-primary" role="status">
                                        <span class="visually-hidden">Loading...</span>
                                      </div>

                                    @endif
                                    @if ($article->status == "completed"  )

                                    <a href="{{ route('editor', ['id' => $article->id,'type'=>$type]) }}" class="btn btn-success border-0" style="background-color: purple">
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
    <script src="{{ asset('js/languageslistener.js') }}"></script>
@endpush
@endsection
