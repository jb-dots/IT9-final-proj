<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $book->title }} - Book Description</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200&icon_names=bookmark" />
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
            color: #121246;
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
            flex-wrap: wrap;
            gap: 20px;
            margin-bottom: 20px;
            align-items: flex-start;
        }
        .book-cover-container {
            flex: 0 0 auto;
            width: 180px;
            aspect-ratio: 2 / 3;
            overflow: hidden;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .book-cover {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 8px;
            display: block;
        }
        .book-cover-container:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
        }
        @media (min-width: 768px) {
            .book-cover-container {
                width: 220px;
            }
        }
        .book-info {
            flex: 1;
            min-width: 0;
        }
        .book-title {
            font-size: 35px;
            color: #121246;
            margin-bottom: 10px;
        }
        .book-author {
            color: #121246;
            margin-bottom: 15px;
        }
        .book-genres {
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
        .book-rating {
            margin-top: 20px; 
            color: #121246;
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
        .star-rating {
            font-size: 24px;
            display: flex;
            gap: 5px;
            direction: rtl;
            unicode-bidi: normal;
        }
        .star-rating input[type="radio"] {
            display: none;
        }
        .star-rating label {
            color: #ccc;
            padding: 0 5px;
            cursor: pointer;
            transition: color 0.2s ease;
        }
        .star-rating input[type="radio"]:checked + label,
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
            <div class="book-cover-container">
                <img src="{{ asset('storage/' . $book->cover_image) }}" alt="Cover image of {{ $book->title }}" class="book-cover">
            </div>
            <div class="book-info">
                <h1 class="book-title"><strong>{{ $book->title }}</strong></h1>
                <h2 class="book-author"><strong>Author:</strong> {{ $book->author }}</h2>
                <h3 class="book-publisher"><strong>Publisher:</strong> {{ $book->publisher ?? 'Unknown' }}</h3>
                <h3 class="book-genres"><strong>Genres:</strong>
                    @if($book->genres->isNotEmpty())
                        @foreach($book->genres as $genre)
                            <span>{{ $genre->name }}@if(!$loop->last), @endif</span>
                        @endforeach
                    @else
                        <span>No genres available.</span>
                    @endif
                </h3>
                <div class="book-description"><strong>Description:</strong>
                    {{ $book->description ?? 'No description available.' }}
                </div>
                <div style="display: flex; gap: 10px; align-items: center;">
                <div id="borrow-section" style="display: flex; gap: 10px; align-items: center;">
                    @php
                        $userBorrowedRecord = auth()->check() ? auth()->user()->borrowedBooks()
                            ->where('book_id', $book->id)
                            ->where('status', 'borrowed')
                            ->whereNull('returned_at')
                            ->first() : null;

                        $isBorrowedByOthers = \App\Models\BorrowedBook::where('book_id', $book->id)
                            ->where('status', 'borrowed')
                            ->whereNull('returned_at')
                            ->where('user_id', '!=', auth()->id())
                            ->exists();

                        $borrowButtonDisabled = $isBorrowedByOthers && !$userBorrowedRecord;
                    @endphp

                    <button id="borrow-button" class="borrow-button" 
                        @if($borrowButtonDisabled) disabled @endif>
                        {{ $userBorrowedRecord ? 'Return Book' : ($borrowButtonDisabled ? 'Not Available' : 'Borrow This Book') }}
                    </button>

                    @if($userBorrowedRecord)
                        <div>
                            <strong>Due Date:</strong> {{ $userBorrowedRecord->due_date->format('Y-m-d') }}
                            @php
                                $lateFee = $userBorrowedRecord->calculateLateFee();
                            @endphp
                            @if($lateFee > 0)
                                <span style="color: red;">(Late Fee: ${{ number_format($lateFee, 2) }})</span>
                            @endif
                        </div>
                    @endif

                    <div id="borrow-feedback" style="color: green;"></div>
                </div>

                <script>
                    document.addEventListener('DOMContentLoaded', function () {
                        const borrowButton = document.getElementById('borrow-button');
                        const feedback = document.getElementById('borrow-feedback');

                        borrowButton.addEventListener('click', function () {
                            borrowButton.disabled = true;
                            feedback.textContent = '';

                            fetch("{{ route('books.toggleBorrow', $book) }}", {
                                method: 'POST',
                                headers: {
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                    'Accept': 'application/json',
                                    'X-Requested-With': 'XMLHttpRequest'
                                },
                            })
                            .then(response => response.json().then(data => ({ status: response.status, body: data })))
                            .then(({ status, body }) => {
                                if (status === 200) {
                                    if (body.borrowed) {
                                        borrowButton.textContent = 'Return Book';
                                        feedback.style.color = 'green';
                                        feedback.textContent = 'Book borrowed successfully.';
                                    } else {
                                        borrowButton.textContent = 'Borrow This Book';
                                        feedback.style.color = 'green';
                                        feedback.textContent = 'Book returned successfully.';
                                    }
                                    // Reload page after short delay to update due date and button state
                                    setTimeout(() => location.reload(), 1000);
                                } else {
                                    borrowButton.disabled = false;
                                    feedback.style.color = 'red';
                                    feedback.textContent = body.error || 'An error occurred.';
                                }
                            })
                            .catch(error => {
                                borrowButton.disabled = false;
                                feedback.style.color = 'red';
                                feedback.textContent = 'An error occurred.';
                                console.error('Error:', error);
                            });
                        });
                    });
                </script>
                <form id="favorite-form" action="{{ route('favorites.toggle', $book) }}" method="POST" style="margin: 0;">
                    @csrf
                    <button type="submit" id="favorite-button" class="borrow-button">
                        @if(!empty($isFavorited) && $isFavorited)
                            Remove from Favorites
                        @else
                            Add to Favorites
                        @endif
                    </button>
                </form>

                <script>
                    document.addEventListener('DOMContentLoaded', function () {
                        const favoriteForm = document.getElementById('favorite-form');
                        const favoriteButton = document.getElementById('favorite-button');

                        function toggleFavoriteAJAX(form, button) {
                            fetch(form.action, {
                                method: 'POST',
                                headers: {
                                    'X-CSRF-TOKEN': form.querySelector('input[name="_token"]').value,
                                    'Accept': 'application/json',
                                    'X-Requested-With': 'XMLHttpRequest'
                                },
                                body: new URLSearchParams(new FormData(form))
                            })
                            .then(response => response.json())
                            .then(data => {
                                if (data.favorited) {
                                    button.textContent = 'Remove from Favorites';
                                } else {
                                    button.textContent = 'Add to Favorites';
                                }
                                // Store favorite status in localStorage for synchronization
                                localStorage.setItem('favorite_' + form.action, JSON.stringify(data.favorited));
                            })
                            .catch(error => {
                                console.error('Error toggling favorite:', error);
                            });
                        }

                        favoriteForm.addEventListener('submit', function (e) {
                            e.preventDefault();
                            toggleFavoriteAJAX(favoriteForm, favoriteButton);
                        });

                        // On page load, synchronize favorite button based on localStorage
                        const stored = localStorage.getItem('favorite_' + favoriteForm.action);
                        if (stored !== null) {
                            const favorited = JSON.parse(stored);
                            if (favorited) {
                                favoriteButton.textContent = 'Remove from Favorites';
                            } else {
                                favoriteButton.textContent = 'Add to Favorites';
                            }
                            // Clear the stored value after applying
                            localStorage.removeItem('favorite_' + favoriteForm.action);
                        }
                    });
                </script>
                </div>

                <div class="book-rating">
                    <h4>Average Rating: {{ number_format($averageRating ?? 0, 1) }} / 5</h4>

                    @auth
                    <form action="{{ route('books.rate', $book->id) }}" method="POST" style="margin-top: 10px; display: flex; align-items: center; gap: 10px;">
                        @csrf
                        <label for="rating" style="margin-right: 10px;">Rate this book:</label>
                        <div class="star-rating">
                            <input type="radio" id="star5" name="rating" value="5" {{ auth()->user()->ratings()->where('book_id', $book->id)->first()?->rating == 5 ? 'checked' : '' }} required>
                            <label for="star5" title="5 stars">★</label>
                            <input type="radio" id="star4" name="rating" value="4" {{ auth()->user()->ratings()->where('book_id', $book->id)->first()?->rating == 4 ? 'checked' : '' }}>
                            <label for="star4" title="4 stars">★</label>
                            <input type="radio" id="star3" name="rating" value="3" {{ auth()->user()->ratings()->where('book_id', $book->id)->first()?->rating == 3 ? 'checked' : '' }}>
                            <label for="star3" title="3 stars">★</label>
                            <input type="radio" id="star2" name="rating" value="2" {{ auth()->user()->ratings()->where('book_id', $book->id)->first()?->rating == 2 ? 'checked' : '' }}>
                            <label for="star2" title="2 stars">★</label>
                            <input type="radio" id="star1" name="rating" value="1" {{ auth()->user()->ratings()->where('book_id', $book->id)->first()?->rating == 1 ? 'checked' : '' }}>
                            <label for="star1" title="1 star">★</label>
                        </div>
                        <button type="submit" style="margin-left: 10px; padding: 5px 10px; background: #d4a373; color: #121246; border: none; border-radius: 4px; cursor: pointer;">Submit</button>
                    </form>
                    @else
                    <p><a href="{{ route('login') }}">Log in</a> to rate this book.</p>
                    @endauth
                </div>
            </div>
        </div>
        <a href="{{ route('dashboard') }}" class="back-button">Back to Dashboard</a>
    </div>
    @vite(['resources/js/app.js'])
</body>
</html>