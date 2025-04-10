<!-- resources/views/admin/index.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Grand Archives</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #121246;
            color: #121246;
            margin: 0;
            padding: 20px;
        }
        .header {
            background: #ded9c3;
            padding: 20px;
            text-align: center;
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 20px;
        }
        .button {
            background: #ded9c3;
            padding: 10px 20px;
            border: none;
            cursor: pointer;
            margin-bottom: 20px;
        }
        .section {
            margin-bottom: 40px;
        }
        .section h2 {
            color: #ded9c3;
            margin-bottom: 10px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            background: #ded9c3;
        }
        th, td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #b5835a;
        }
        th {
            background: #b5835a;
            color: #121246;
        }
        .action-button {
            background: #b5835a;
            padding: 5px 10px;
            border: none;
            cursor: pointer;
            margin-right: 5px;
        }
        .paid-button {
            background: #6aa933;
            color: #fff;
            padding: 5px 10px;
            border: none;
            cursor: pointer;
        }
        .message {
            text-align: center;
            padding: 10px;
            margin-bottom: 20px;
        }
        .message.success {
            background: #6aa933;
            color: #fff;
        }
        .message.error {
            background: #ff3333;
            color: #fff;
        }
    </style>
</head>
<body>
    <div class="header">Admin Dashboard</div>

    @if(session('success'))
        <div class="message success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="message error">{{ session('error') }}</div>
    @endif

    <a href="{{ route('admin.create') }}"><button class="button">Add New Book</button></a>

    <div class="section">
        <h2>Books</h2>
        <table>
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Author</th>
                    <th>Genre</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($books as $book)
                    <tr>
                        <td>{{ $book->title }}</td>
                        <td>{{ $book->author }}</td>
                        <td>{{ $book->genre->name ?? 'N/A' }}</td>
                        <td>
                            <a href="{{ route('admin.edit', $book) }}"><button class="action-button">Edit</button></a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="section">
        <h2>Borrowed Books</h2>
        <table>
            <thead>
                <tr>
                    <th>Book Title</th>
                    <th>User</th>
                    <th>Contact No</th>
                    <th>Address</th>
                    <th>Status</th>
                    <th>Borrowed At</th>
                    <th>Due Date</th>
                    <th>Returned At</th>
                    <th>Late Fee</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($borrowedBooks as $borrowedBook)
                    <tr>
                        <td>{{ $borrowedBook->book->title }}</td>
                        <td>{{ $borrowedBook->user->name }}</td>
                        <td>{{ $borrowedBook->user->contact_no ?? 'N/A' }}</td>
                        <td>{{ $borrowedBook->user->address ?? 'N/A' }}</td>
                        <td>{{ $borrowedBook->status }}</td>
                        <td>{{ $borrowedBook->borrowed_at->format('Y-m-d H:i') }}</td>
                        <td>{{ $borrowedBook->due_date->format('Y-m-d') }}</td>
                        <td>{{ $borrowedBook->returned_at ? $borrowedBook->returned_at->format('Y-m-d H:i') : 'N/A' }}</td>
                        <td>${{ number_format($borrowedBook->late_fee, 2) }}</td>
                        <td>
                            <form action="{{ route('admin.updateBorrowStatus', $borrowedBook) }}" method="POST" style="display:inline;">
                                @csrf
                                <select name="status" onchange="this.form.submit()">
                                    <option value="borrowed" {{ $borrowedBook->status == 'borrowed' ? 'selected' : '' }}>Borrowed</option>
                                    <option value="returned" {{ $borrowedBook->status == 'returned' ? 'selected' : '' }}>Returned</option>
                                </select>
                            </form>
                            @if($borrowedBook->late_fee > 0 && $borrowedBook->status == 'borrowed')
                                <form action="{{ route('admin.markAsPaid', $borrowedBook) }}" method="POST" style="display:inline;">
                                    @csrf
                                    <button type="submit" class="paid-button">Mark as Paid</button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>