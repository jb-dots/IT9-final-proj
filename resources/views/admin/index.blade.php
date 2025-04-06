<!-- resources/views/admin/index.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Grand Archives</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200&display=swap" />
    @vite(['resources/css/app.css'])

    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body, html {
            height: 100%;
            font-family: "Inter-Regular", sans-serif;
            background: #121246;
            color: #fff;
        }

        .admin-container {
            padding: 20px;
            max-width: 1200px;
            margin: 0 auto;
        }

        .header {
            background: #d4a373;
            padding: 15px;
            text-align: center;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        .header h1 {
            color: #121246;
            font-size: 28px;
            font-weight: 600;
        }

        .add-book-btn {
            display: inline-block;
            margin-bottom: 20px;
            padding: 10px 20px;
            background: #d4a373;
            color: #121246;
            border-radius: 4px;
            text-decoration: none;
            font-weight: 500;
        }

        .add-book-btn:hover {
            background: #b5835a;
        }

        .table-container {
            margin-bottom: 40px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: #1a1a4d;
            border-radius: 8px;
            overflow: hidden;
        }

        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #b5835a;
        }

        th {
            background: #d4a373;
            color: #121246;
            font-weight: 600;
        }

        td {
            color: #fff;
        }

        .action-btn {
            padding: 5px 10px;
            border-radius: 4px;
            text-decoration: none;
            font-size: 14px;
            margin-right: 5px;
        }

        .edit-btn {
            background: #d4a373;
            color: #121246;
        }

        .edit-btn:hover {
            background: #b5835a;
        }

        .status-form {
            display: inline-block;
        }

        .status-select {
            padding: 5px;
            border-radius: 4px;
            background: #d9d9d9;
            color: #121246;
            border: none;
        }

        .status-btn {
            padding: 5px 10px;
            background: #d4a373;
            color: #121246;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .status-btn:hover {
            background: #b5835a;
        }

        .success-message {
            background: #b5835a;
            color: #121246;
            padding: 10px;
            border-radius: 4px;
            margin-bottom: 20px;
            text-align: center;
        }

        .overdue {
            color: #ff6b6b;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="admin-container">
        <div class="header">
            <h1>Admin Dashboard</h1>
        </div>

        @if (session('success'))
            <div class="success-message">
                {{ session('success') }}
            </div>
        @endif

        <a href="{{ route('admin.books.create') }}" class="add-book-btn">Add New Book</a>

        <div class="table-container">
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
                    @forelse ($books as $book)
                        <tr>
                            <td>{{ $book->title }}</td>
                            <td>{{ $book->author ?? 'N/A' }}</td>
                            <td>{{ $book->genre->name }}</td>
                            <td>
                                <a href="{{ route('admin.books.edit', $book) }}" class="action-btn edit-btn">Edit</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4">No books found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="table-container">
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
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($borrowedBooks as $borrowedBook)
                        <tr>
                            <td>{{ $borrowedBook->book->title }}</td>
                            <td>{{ $borrowedBook->user->name }}</td>
                            <td>{{ $borrowedBook->user->contact_no ?? 'N/A' }}</td>
                            <td>{{ $borrowedBook->user->address ?? 'N/A' }}</td>
                            <td>
                                <span class="{{ $borrowedBook->status === 'borrowed' && $borrowedBook->due_date && $borrowedBook->due_date->isPast() ? 'overdue' : '' }}">
                                    {{ ucfirst($borrowedBook->status) }}
                                </span>
                            </td>
                            <td>{{ $borrowedBook->borrowed_at->format('Y-m-d H:i') }}</td>
                            <td>
                                <span class="{{ $borrowedBook->status === 'borrowed' && $borrowedBook->due_date && $borrowedBook->due_date->isPast() ? 'overdue' : '' }}">
                                    {{ $borrowedBook->due_date ? $borrowedBook->due_date->format('Y-m-d H:i') : 'N/A' }}
                                </span>
                            </td>
                            <td>{{ $borrowedBook->returned_at ? $borrowedBook->returned_at->format('Y-m-d H:i') : 'N/A' }}</td>
                            <td>
                                <form action="{{ route('admin.borrowed.update', $borrowedBook) }}" method="POST" class="status-form">
                                    @csrf
                                    @method('PUT')
                                    <select name="status" class="status-select">
                                        <option value="borrowed" {{ $borrowedBook->status === 'borrowed' ? 'selected' : '' }}>Borrowed</option>
                                        <option value="returned" {{ $borrowedBook->status === 'returned' ? 'selected' : '' }}>Returned</option>
                                    </select>
                                    <button type="submit" class="status-btn">Update</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9">No borrowed books found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>