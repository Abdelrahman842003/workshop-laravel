<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Report</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 12px;
        }

        table {
            width: 100%;
            border-spacing: 0;
            margin-top: 20px;
            table-layout: fixed;
            word-wrap: break-word;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
    </style>
</head>

<body>
    <h1>Analytics Report</h1>
    <div class="meta">
        Generated on: {{ now()->toDateTimeString() }}
    </div>

    <table>
        <thead>
            <tr>
                @if(count($data) > 0)
                    @foreach(array_keys((array) $data[0]) as $header)
                        <th>{{ ucfirst(str_replace('_', ' ', $header)) }}</th>
                    @endforeach
                @endif
            </tr>
        </thead>
        <tbody>
            @foreach($data as $row)
                <tr>
                    @foreach((array) $row as $cell)
                        <td>{{ is_array($cell) ? \Illuminate\Support\Str::limit(json_encode($cell), 50) : $cell }}</td>
                    @endforeach
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>