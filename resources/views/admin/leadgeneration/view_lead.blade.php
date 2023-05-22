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
               <h1 class="h3 mb-2 text-gray-800">View lead</h1>
            </div>
            <div class="col-md-2">
                <a href="{{ route('lead') }}" class="btn btn-dark btn-icon-split">
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
                                <td>{{ $view_lead->first_name }} {{ $view_lead->last_name }}</td>
                            </tr>
                            <tr>
                                <td>Work Email</td>
                                <td>{{ $view_lead->email }}</td>
                            </tr>
                            <tr>
                                <td>Phone number</td>
                                <td>{{ $view_lead->phone }}</td>
                            </tr>
                            <tr>
                                <td>Company Name</td>
                                <td>{{ $view_lead->company_name }}</td>
                            </tr>
                            <tr>
                                <td>Job Title</td>
                                <td>{{ $view_lead->job_title }}</td>
                            </tr>
                            <tr>
                                <td>Topic</td>
                                <td>{{ $view_lead->topic }}</td>
                            </tr>
                            <tr>
                                <td>Message</td>
                                <td>{{ $view_lead->message }}</td>
                            </tr>
                            <tr>
                                <td>Soure</td>
                                <td>{{ $view_lead->source }}</td>
                            </tr>
                            @php $user_id_arr = explode(',', $view_lead->user_id); @endphp
                            <tr>
                                <td>Assign To</td>
                                <td>@foreach($users as $cu)
                                        @if(in_array($cu->id, $user_id_arr)) {{ $cu->name }} @endif 
                                    @endforeach
                                </td>
                            </tr>
                            <tr>
                                <td>Notes</td>
                                <td>{{ $view_lead->notes }}</td>
                            </tr>
                        </tbody>
                    </table>
                    <div>
                        <div class="col-md-10">
                           <h1 class="h3 mb-2 text-gray-800">Comments</h1>
                        </div>
                        <table class="table table-striped table-bordered">
                            <tr>
                                <th>Name</th>
                                <th>Comment</th>
                                <th>Posted At</th>
                            </tr>
                            @foreach($lead_comments as $lead_comment)
                                <tr>
                                    <td>
                                        @foreach($users as $cu)
                                            @if($cu->id == $lead_comment->user_id)
                                                {{ $cu->name }}
                                            @endif
                                        @endforeach
                                    </td>
                                    <td>{{ $lead_comment->comment }}</td>
                                    <td>{{ date("l M d , Y, H:m a", strtotime($lead_comment->created_at)) }}</td>
                                </tr>
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection