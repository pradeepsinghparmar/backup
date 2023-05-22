<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Laravel 7 PDF Example</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet" type="text/css" />
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center mb-3">ClinDCast Time Logs</h2>
        <div class="d-flex justify-content-end mb-4">
        </div>
        <table class="table table-bordered mb-5">
            <thead>
                <tr class="table-danger">
                    <th scope="col">Date</th>
                    <th scope="col">Name</th>
                    <th scope="col">Project-Task</th>
                    <th scope="col">Activity Hour</th>
                    <th scope="col">Count</th>
                    <th scope="col">Comments</th>
                </tr>
            </thead>
            <tbody>
                @foreach($timesheets as $key => $timesheet)
                <tr>
                    <td>{{ date("D M d ", strtotime($timesheet['date'])) }}</td>
                    <td>{{ $timesheet['name'] }}</td>
                    <td>{{ $timesheet['project'] }}</td>
                    <td>{{ $timesheet['hours'] }}</td>
                    <td>{{ $timesheet['count'] }}</td>
                    <td>{{ $timesheet['comments'] }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <script src="{{ asset('js/app.js') }}" type="text/js"></script>
</body>
</html>