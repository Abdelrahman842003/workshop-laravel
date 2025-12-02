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
                @foreach($columns as $col)
                    <th>{{ ucwords(str_replace('_', ' ', $col)) }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach($data as $row)
                <tr>
                    @foreach($columns as $col)
                        @php
                            $value = is_array($row) ? ($row[$col] ?? '') : ($row->$col ?? '');

                            // Format JSON
                            if (is_string($value) && str_starts_with(trim($value), '{')) {
                                $decoded = json_decode($value, true);
                                if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                                    $formatted = [];
                                    foreach ($decoded as $k => $v) {
                                        $vStr = is_array($v) ? json_encode($v) : $v;
                                        $formatted[] = "$k: $vStr";
                                    }
                                    $value = implode("<br>", $formatted);
                                }
                            }
                        @endphp
                        <td>{!! $value !!}</td>
                    @endforeach
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>