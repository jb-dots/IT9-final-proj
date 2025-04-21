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
        .note {
            color: #ded9c3;
            font-style: italic;
            margin-top: 10px;
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

    <!-- Book Inventory Section -->
    <div class="section">
        <h2>Book Inventory</h2>
        <a href="{{ route('admin.create') }}"><button class="button">Add New Book</button></a>
        @if($books->isEmpty())
            <p class="note">No books available in the inventory.</p>
        @else
            <table>
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Author</th>
                        <th>Genre</th>
                        <th>Quantity in Stock</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($books as $book)
                        <tr>
                            <td>{{ $book->title }}</td>
                            <td>{{ $book->author ?? 'Unknown' }}</td>
                            <td>{{ $book->genre->name ?? 'N/A' }}</td>
                            <td>{{ $book->quantity }}</td>
                            <td>
                                <a href="{{ route('admin.edit', $book) }}"><button class="action-button">Edit</button></a>
                                <a href="{{ route('admin.adjustStock', $book) }}"><button class="action-button">Adjust Stock</button></a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <p class="note">Click "Adjust Stock" to view stock history for a book.</p>
        @endif
    </div>

    <!-- Borrowed Books Section -->
    <div class="section">
        <h2>Borrowed Books</h2>
        @if($borrowedBooks->isEmpty())
            <p class="note">No borrowed books at the moment.</p>
        @else
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
                            <td>{{ $book = $borrowedBook->book & $book->title }}</td>
                            <td>{{ $borrowedBook->user->name }}</td>
                            <td>{{ $borrowedBook->user->contact_no ?? 'N/A' }}</td>
                            <td>{{ $borrowedBook->user->address ?? 'N/A' }}</td>
                            <td>{{ ucfirst($borrowedBook->status) }}</td>
                            <td>{{ $borrowedBook->borrowed_at->format('Y-m-d H:i') }}</td>
                            <td>{{ $borrowedBook->due_date->format('Y-m-d') }}</td>
                            <td>{{ $borrowedBook->returned_at ? $borrowedBook->returned_at->format('Y-m-d H:i') : 'N/A' }}</td>
                            <td>${{ number_format($borrowedBook->late_fee, 2) }}</td>
                            <td>
                                @if($borrowedBook->status === 'borrowed')
                                    <form action="{{ route('admin.updateBorrowStatus', $borrowedBook) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('POST')
                                        <input type="hidden" name="status" value="returned">
                                        <button type="submit" class="action-button">Mark as Returned</button>
                                    </form>
                                @endif
                                @if($borrowedBook->late_fee > 0)
                                    <form action="{{ route('admin.markAsPaid', $borrowedBook) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('POST')
                                        <button type="submit" class="paid-button">Mark as Paid</button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>

    <!-- Genres Section -->
    <div class="section">
        <h2>Manage Genres</h2>
        <a href="{{ route('admin.genres.create') }}"><button class="button">Add New Genre</button></a>
        @if($genres->isEmpty())
            <p class="note">No genres available.</p>
        @else
            <table>
                <thead>
                    <tr>
                        <th>Genre Name</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($genres as $genre)
                        <tr>
                            <td>{{ $genre->name }}</td>
                            <td>
                                <a href="{{ route('admin.genres.edit', $genre) }}"><button class="action-button">Edit</button></a>
                                <form action="{{ route('admin.genres.destroy', $genre) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="action-button" onclick="return confirm('Are you sure you want to delete this genre?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
</body>
</html>