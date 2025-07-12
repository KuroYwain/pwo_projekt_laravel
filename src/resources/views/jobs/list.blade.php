<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8" />
    <title>Lista zadań w kolejce</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f4f6f8;
            margin: 0;
            padding: 2rem;
            color: #333;
        }

        h1 {
            text-align: center;
            margin-bottom: 2rem;
            font-weight: 700;
            color: #222;
        }

        .container {
            max-width: 900px;
            margin: 0 auto;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgb(0 0 0 / 0.1);
            padding: 1.5rem 2rem;
        }

        table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0 12px;
        }

        th, td {
            padding: 12px 16px;
            text-align: left;
        }

        thead th {
            color: #555;
            font-weight: 600;
            border-bottom: 2px solid #eaecef;
        }

        tbody tr {
            background: #fafafa;
            box-shadow: 0 2px 4px rgb(0 0 0 / 0.05);
            border-radius: 6px;
            transition: background-color 0.2s ease;
        }

        tbody tr:hover {
            background-color: #e8f0fe;
        }

        tbody td.status {
            font-weight: 600;
            text-transform: capitalize;
        }

        .status-queued {
            color: #f0ad4e; /* pomarańczowy */
        }

        .status-processing {
            color: #0275d8; /* niebieski */
        }

        .status-done {
            color: #5cb85c; /* zielony */
        }

        .status-failed {
            color: #d9534f; /* czerwony */
        }

        .message {
            margin-bottom: 1.5rem;
            padding: 12px 20px;
            border-radius: 6px;
            font-weight: 600;
            font-size: 1rem;
        }

        .message-success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .message-error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        @media (max-width: 600px) {
            table, thead, tbody, th, td, tr {
                display: block;
            }

            thead tr {
                display: none;
            }

            tbody tr {
                margin-bottom: 1rem;
                background: #fff;
                box-shadow: none;
                border-radius: 8px;
                padding: 1rem;
            }

            tbody td {
                padding: 8px 0;
                position: relative;
                padding-left: 50%;
                text-align: right;
                border-bottom: 1px solid #eee;
            }

            tbody td::before {
                content: attr(data-label);
                position: absolute;
                left: 16px;
                width: 45%;
                padding-left: 0;
                font-weight: 700;
                text-align: left;
                color: #666;
            }

            tbody td:last-child {
                border-bottom: 0;
            }
        }
    </style>
</head>
<body>
<div class="container">
    <h1>Lista zadań w kolejce</h1>

    @if(session('success'))
        <div class="message message-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="message message-error">{{ session('error') }}</div>
    @endif

    <table>
        <thead>
        <tr>
            <th>ID zadania</th>
            <th>Nazwa</th>
            <th>Status</th>
            <th>Dodano</th>
        </tr>
        </thead>
        <tbody>
        @forelse($jobs as $job)
            <tr>
                <td data-label="ID zadania">{{ $job->id }}</td>
                <td data-label="Nazwa">{{ $job->name }}</td>
                <td class="status status-{{ $job->status }}" data-label="Status">{{ $job->status }}</td>
                <td data-label="Dodano">{{ $job->created_at->format('Y-m-d H:i:s') }}</td>
            </tr>
        @empty
            <tr><td colspan="4" style="text-align:center;">Brak zadań w kolejce.</td></tr>
        @endforelse
        </tbody>
    </table>
</div>
</body>
</html>
