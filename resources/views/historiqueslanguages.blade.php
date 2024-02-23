@extends('layouts.app')

@section('content')
<div class="container ">
    <div class="row justify-content-center " style="margin-top:5%">


            <div class="col col-lg-12 col-md-8 col-sm-8 m-2 " align="center">
                <div class="card-header">{{ __('Subject') }}</div>
                <table class="table table-striped table-hover">

                        <thead>
                          <tr>
                            <th scope="col">#</th>
                            <th scope="col">First</th>
                            <th scope="col">Last</th>
                            <th scope="col">Handle</th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr>
                            <th scope="row">1</th>
                            <td>Mark</td>
                            <td>Otto</td>
                            <td>@mdo</td>
                            <td><button type="submit" class="btn btn-success">
                                {{ __('Show') }}
                            </button></td>
                          </tr>
                          <tr>
                            <th scope="row">2</th>
                            <td>Jacob</td>
                            <td>Thornton</td>
                            <td>@fat</td>
                            <td><button type="submit" class="btn btn-success">
                                {{ __('Show') }}
                            </button></td>
                          </tr>
                          <tr>
                            <th scope="row">3</th>
                            <td colspan="2">Larry the Bird</td>
                            <td>@twitter</td>
                            <td><button type="submit" class="btn btn-success">
                                {{ __('Show') }}
                            </button></td>
                          </tr>
                        </tbody>
                      </table>
                  </table>
                </div>
        </div>


    </div>

</div>
@endsection
