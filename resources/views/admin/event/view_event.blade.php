@extends('admin.layout')

@section('content')
 <style>
    .tile {
    position: relative;
    background: #ffffff;
    border-radius: 3px;
    padding: 15px;
    height: 100%;
    margin-bottom: 30px;
</style>
    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="row">
            <div class="col-md-10">
               <h1 class="h3 mb-2 text-gray-800">View event</h1>
            </div>
            <div class="col-md-2">
                <a href="{{ route('event') }}" class="btn btn-dark btn-icon-split">
                    <span class="text">Back</span>
                </a>
            </div>
        </div>
        <div class="card shadow">
            <div class="card-body">
                <div class="tile">
                    <table class="table table-striped table-bordered">
                        <tbody>
                            <tr>
                                <td>Name</td>
                                <td>{{ $view_event->first_name }} {{ $view_event->last_name }}</td>
                            </tr>
                            <tr>
                                <td>Work Email</td>
                                <td>{{ $view_event->email }}</td>
                            </tr>
                            <tr>
                                <td>Phone number</td>
                                <td>{{ $view_event->phone }}</td>
                            </tr>
                            <tr>
                                <td>Company Name</td>
                                <td>{{ $view_event->company_name }}</td>
                            </tr>
                            <tr>
                                <td>Soure</td>
                                <td>{{ $view_event->source }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection