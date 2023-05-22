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
               <h1 class="h3 mb-2 text-gray-800">View State</h1>
            </div>
            <div class="col-md-2">
                <a href="{{ route('state_lists') }}" class="btn btn-dark btn-icon-split">
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
                                <td>State Name</td>
                                <td>{{ $view_state->name }}</td>
                            </tr>
                            <tr>
                                <td colspan="2"><h2>SIT</h2></td>
                            </tr>
                            <tr>
                                <td>SIT</td>
                                <td>{{ $view_state->siu }}</td>
                            </tr>
                            <tr>
                                <td>Website</td>
                                <td>{{ $view_state->website }}</td>
                            </tr>
                            <tr>
                                <td>User Name</td>
                                <td>{{ $view_state->user_name }}</td>
                            </tr>
                            <tr>
                                <td>Password</td>
                                <td>{{ $view_state->password }}</td>
                            </tr>
                            <tr>
                                <td>Notes</td>
                                <td>{{ $view_state->notes }}</td>
                            </tr>
                            <tr>
                                <td colspan="2"><h2>SUI</h2></td>
                            </tr>
                            <tr>
                                <td>SUI</td>
                                <td>{{ $view_state->su }}</td>
                            </tr>
                            <tr>
                                <td>Website</td>
                                <td>{{ $view_state->siu_website }}</td>
                            </tr>
                            <tr>
                                <td>User Name</td>
                                <td>{{ $view_state->siu_user_name }}</td>
                            </tr>
                            <tr>
                                <td>Password</td>
                                <td>{{ $view_state->siu_password }}</td>
                            </tr>
                            <tr>
                                <td>Notes</td>
                                <td>{{ $view_state->siu_notes }}</td>
                            </tr>
                            <tr>
                                <td colspan="2"></td>
                            </tr>
                            <tr>
                                <td>Comments</td>
                                <td>{{ $view_state->comments }}</td>
                            </tr>

                            <tr>
                                <td>Update</td>
                                <td>{{ $view_state->status }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection