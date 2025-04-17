<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $book->title }} - Book Description</title>
    @vite(['resources/css/app.css'])
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: "Inter-Regular", sans-serif;
            background: #121246;
            color: #fff;
            padding: 20px;
        }

        .book-container {
            max-width: 800px;
            margin: 0 auto;
            background: #1a1a4d;
            border-radius: 8px;
            padding: 20px;
        }

        .book-header {
            display: flex;
            gap: 20px;
            margin-bottom: 20px;
        }

        .book-cover {
            width: 200px;
            border-radius: 4px;
        }

        .book-info {
            flex: 1;
        }

        .book-title {
            color: #d4a373;
            margin-bottom: 10px;
        }

        .book-author {
            color: #b5835a;
            margin-bottom: 15px;
        }

        .book-description {
            line-height: 1.6;
            margin-bottom: 20px;
        }

        .back-button {
            display: inline-block;
            padding: 8px 16px;
            background: #d4a373;
            color: #121246;
            border-radius: 4px;
            text-decoration: none;
            margin-top: 20px;
        }

        .back-button:hover {
            background: #b5835a;
        }

        .borrow-button {
            padding: 8px 16px;
            background: #d4a373;
            color: #121246;
            border-radius: 4px;
            border: none;
            cursor: pointer;
            font-weight: 500;
        }

        .borrow-button:hover {
            background: #b5835a;
        }

        .borrow-button:disabled {
            background: #6c757d;
            cursor: not-allowed;
        }
    </style>
</head>
<body>
    <div class="book-container">
        <div class="book-header">
            <img src="{{ asset('storage/' . $book->cover_image) }}" alt="{{ $book->title }}" class="book-cover">
            <div class="book-info">
                <h1 class="book-title">{{ $book->title }}</h1>
                <h2 class="book-author">by {{ $book->author }}</h2>
                <div class="book-description">
                    {{ $book->description ?? 'No description available.' }}
                </div>
                <form action="{{ route('books.borrow', $book) }}" method="POST">
                    @csrf
                    <button type="submit" class="borrow-button" {{ $book->is_borrowed ? 'disabled' : '' }}>
                        {{ $book->is_borrowed ? 'Currently Borrowed' : 'Borrow This Book' }}
                    </button>
                </form>
            </div>
        </div>
        <a href="{{ url()->previous() }}" class="back-button">Back to Previous Page</a>
    </div>
    @vite(['resources/js/app.js'])
</body>
</html>
