<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $book->title }} - Book Description</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    @vite(['resources/css/app.css'])
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }
        body {
            font-family: "Inter-Regular", sans-serif;
            background: #f9f8f4;
            color: #fff;
            padding: 20px;
        }
        .book-container {
            max-width: 800px;
            margin: 0 auto;
            background: #ded9c3;
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
            color: #121246;
            margin-bottom: 10px;
        }
        .book-author {
            color: #121246;
            margin-bottom: 15px;
        }
        .book-publisher {
            color: #121246;
            margin-bottom: 15px;
        }
        .book-description {
            color: #121246;
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
        .fa-star {
            font-size: 24px;
            cursor: pointer;
            color: #ccc;
        }
        .checked {
            color: #ffca08;
        }
        .star-rating input[type="radio"] {
            display: none;
        }
        .star-rating label {
            color: #ccc;
            font-size: 24px;
            padding: 0 5px;
            cursor: pointer;
        }
        .star-rating input[type="radio"]:checked ~ label {
            color: #ffca08;
        }
        .star-rating label:hover,
        .star-rating label:hover ~ label {
            color: #ffca08;
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
                <h3 class="book-publisher">Publisher: {{ $book->publisher ?? 'Unknown' }}</h3>
                <div class="book-description">
                    {{ $book->description ?? 'No description available.' }}
                </div>
                <form action="{{ route('books.borrow', $book) }}" method="POST">
                    @csrf
                    <button type="submit" class="borrow-button" {{ $book->is_borrowed ? 'disabled' : '' }}>
                        {{ $book->is_borrowed ? 'Currently Borrowed' : 'Borrow This Book' }}
                    </button>
                </form>
                
                <div class="book-rating" style="margin-top: 20px; color: #121246;">
                    <h4>Average Rating: {{ number_format($averageRating ?? 0, 1) }} / 5</h4>

                    @auth
                    <form action="{{ route('books.rate', $book->id) }}" method="POST" style="margin-top: 10px; display: flex; align-items: center; gap: 10px;">
                        @csrf
                        <label for="rating" style="margin-right: 10px;">Rate this book:</label>
                        <div class="star-rating" style="font-size: 24px; display: flex; gap: 5px; direction: rtl; unicode-bidi: normal;">
                            <input type="radio" id="star5" name="rating" value="5" required><label for="star5" title="5 stars">&#9733;</label>
                            <input type="radio" id="star4" name="rating" value="4"><label for="star4" title="4 stars">&#9733;</label>
                            <input type="radio" id="star3" name="rating" value="3"><label for="star3" title="3 stars">&#9733;</label>
                            <input type="radio" id="star2" name="rating" value="2"><label for="star2" title="2 stars">&#9733;</label>
                            <input type="radio" id="star1" name="rating" value="1"><label for="star1" title="1 star">&#9733;</label>
                        </div>
                        <button type="submit" style="margin-left: 10px; padding: 5px 10px; background: #d4a373; color: #121246; border: none; border-radius: 4px; cursor: pointer;">Submit</button>
                    </form>
                    @else
                    <p><a href="{{ route('login') }}">Log in</a> to rate this book.</p>
                    @endauth
                </div>
            </div>
        </div>
        <a href="{{ route('dashboard') }}" class="back-button">Back to Previous Page</a>
    </div>
    @vite(['resources/js/app.js'])
</body>
</html>
