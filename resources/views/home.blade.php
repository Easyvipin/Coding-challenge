@extends('layouts.app')

@section('content')
<div class="container">

    @if(count($errors) > 0)
    @foreach($errors->all as $error)
        <div class="alert alert-danger">
            {{$error}}
        </div>
    @endforeach
    @endif

    @if(session('success'))
            <div class="alert alert-success">
                {{session('success')}}
            </div>
    @endif

    @if(session('error'))
            <div class="alert alert-success">
                {{session('error')}}
            </div>
    @endif

    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{ __('You are logged in!') }}
                </div>
            </div>
        </div>

        <div class="col-md-6">

        </div>
    </div>
    <div class="row justify-content-center mt-5">
        <div class="col-md-6">
            <h2 class="text-start">Add Interview</h2>
            <form role="form" method="POST" action="{{ route('interview.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <input type="text" class="form-control" name="name" placeholder="Name of the inteview">
            </div>
            <div class="form-group">
                <input type="file" class="form-control" name="video" placeholder="Select file">
            </div>
            <div class="form-group">
                <input type="text" class="form-control" name="time" placeholder="Video Length In Seconds e.g. 1 min will 60sec here">
            </div>
            <div class="form-group">
                <textarea name="note" class="form-control" placeholder="Enter Interview Note Here"></textarea>
            </div>
            <button type="submit" class="btn btn-primary w-100">Submit</button>
            </form>
        </div>

        <div class="col-md-6">
            <h2 class="text-start">All Interview</h2>
            <table class="table table-striped border rounded">
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
                  </tr>
                  <tr>
                    <th scope="row">2</th>
                    <td>Jacob</td>
                    <td>Thornton</td>
                    <td>@fat</td>
                  </tr>
                  <tr>
                    <th scope="row">3</th>
                    <td colspan="2">Larry the Bird</td>
                    <td>@twitter</td>
                  </tr>
                </tbody>
              </table>
        </div>
    </div>
</div>
@endsection
