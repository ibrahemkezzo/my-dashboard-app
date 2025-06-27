<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <table>
        <thead>
            <tr>
                <th>User</th>
                <th>Session ID</th>

            </tr>
        </thead>
        <tbody>
            @foreach($sessions as $session)
                    <tr>
                        <td>{{ $session->user?->name ?? 'Guest' }}</td>
                        <td>{{ $session->session_id }}</td>
                    </tr>
            @endforeach
        </tbody>
    </table>
    {{ $sessions->links() }}
</body>
</html>
