<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ __('dashboard.user_activity_report') }}</title>
</head>
<body>
    <table>
        <thead>
            <tr>
                <th>{{ __('dashboard.user') }}</th>
                <th>{{ __('dashboard.session_id') }}</th>

            </tr>
        </thead>
        <tbody>
            @foreach($sessions as $session)
                    <tr>
                        <td>{{ $session->user?->name ?? __('dashboard.guest') }}</td>
                        <td>{{ $session->session_id }}</td>
                    </tr>
            @endforeach
        </tbody>
    </table>
    {{ $sessions->links() }}
</body>
</html>
