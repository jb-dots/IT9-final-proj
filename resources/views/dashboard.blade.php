<!-- resources/views/dashboard.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200&display=swap" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Grand Archives</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <style>
        /* Reset and base styles */
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
            overflow-x: hidden;
        }

        .fa-star {
            font-size: 18px;
            color: #ccc;
        }

        .checked {
            color: #ffca08;
        }

        .home-container {
            display: flex;
            width: 100%;
            min-height: 100vh;
            position: relative;
        }

        /* Navigation styles */
        .navigation {
            width: 250px;
            background: #ded9c3;
            height: 100vh;
            position: fixed;
            left: -250px; /* Hidden by default */
            top: 0;
            transition: left 0.3s ease-in-out;
            z-index: 10;
            box-shadow: 2px 0 10px rgba(0, 0, 0, 0.3);
        }

        .navigation.active {
            left: 0; /* Show when active */
        }

        .menu-button {
            position: fixed;
            left: 20px;
            top: 20px;
            cursor: pointer;
            z-index: 20;
            color: #121246;
            font-size: 28px;
            background: transparent;
            border: none;
            transition: color 0.2s;
        }

        .menu-button:hover {
            color: #121246;
        }

        /* Main content styles */
        .home-page {
            flex: 1;
            background: #f0f0e4;
            min-height: 100vh;
            padding-left: 60px; /* Space for menu button */
            transition: padding-left 0.3s ease-in-out;
        }

        .home-page.nav-active {
            padding-left: 310px; /* Shift content when nav is active */
        }

        .rectangle-5 {
            background: #ded9c3;
            width: 100%;
            height: 80px;
            position: fixed;
            left: 0;
            top: 0;
            border-bottom: 2px solid #b5835a;
            z-index: 1;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .home-title {
            color: #121246;
            text-align: center;
            font-family: "Inter-Regular", sans-serif;
            font-size: 28px;
            font-weight: 600;
            z-index: 2;
        }

        /* Messages */
        .message {
            text-align: center;
            padding: 10px;
            margin: 100px auto 20px;
            max-width: 1100px;
            border-radius: 4px;
        }
        .message.success {
            background: #6aa933;
            color: #fff;
        }
        .message.error {
            background: #ff3333;
            color: #fff;
        }

        /* Overdue notice */
        .overdue-notice {
            background: #ff6b6b;
            color: #fff;
            padding: 10px;
            border-radius: 4px;
            text-align: center;
            margin: 100px auto 20px;
            max-width: 1100px;
        }

        /* Section headers */
        .trending, .trending2, .trending3, .borrowed-books {
            color: #121246;
            font-family: "Inter-Regular", sans-serif;
            font-size: 24px;
            font-weight: 400;
            margin: 20px 0 10px;
            padding-left: 20px;
        }

        .trending {
            margin-top: 120px; /* Space below header */
        }

        /* Book container styles */
        .book-container {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 20px;
            padding: 20px;
        }

        .book-card {
            width: 100%;
            height: 300px; /* Increased to accommodate quantity and button */
            background: #b5835a;
            border-radius: 15px;
            border: 1px solid #b5835a;
            overflow: hidden;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
            position: relative;
        }

        .book-card:hover {
            transform: scale(1.05);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
        }

        .book-card img {
            width: 100%;
            height: 180px;
            object-fit: cover;
            border-radius: 10px 10px 0 0;
        }

        .book-card .book-info {
            padding: 10px;
            text-align: center;
        }

        .book-card p {
            color: #121246;
            font-family: "Inter-Regular", sans-serif;
            font-size: 14px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            margin-bottom: 5px;
        }

        .book-card .quantity {
            color: #fff;
            font-size: 12px;
            margin-bottom: 5px;
        }

        .book-card .action-button {
            background: #121246;
            color: #fff;
            padding: 5px 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 12px;
            transition: background 0.2s;
        }

        .book-card .action-button:hover {
            background: #1e2a78;
        }

        .book-card .out-of-stock {
            color: #ff6b6b;
            font-size: 12px;
            font-style: italic;
        }

        /* Borrowed books table styles */
        .borrowed-table {
            width: 100%;
            max-width: 1100px;
            margin: 0 auto;
            border-collapse: collapse;
            background: #ded9c3;
            border-radius: 8px;
            overflow: hidden;
            padding: 20px;
        }

        .borrowed-table th, .borrowed-table td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #b5835a;
        }

        .borrowed-table th {
            background: #d4a373;
            color: #121246;
            font-weight: 600;
        }

        .borrowed-table td {
            color: #121246;
        }

        .overdue {
            color: #ff6b6b;
            font-weight: bold;
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .home-page {
                padding-left: 50px;
            }

            .home-page.nav-active {
                padding-left: 260px;
            }

            .home-title {
                font-size: 22px;
            }

            .trending, .trending2, .trending3, .borrowed-books {
                font-size: 20px;
            }

            .book-container {
                grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
            }

            .book-card {
                height: 250px;
            }

            .book-card img {
                height: 130px;
            }

            .book-card p {
                font-size: 12px;
            }

            .book-card .quantity, .book-card .action-button, .book-card .out-of-stock {
                font-size: 10px;
            }

            .borrowed-table th, .borrowed-table td {
                padding: 8px;
                font-size: 14px;
            }
        }

        @media (max-width: 480px) {
            .navigation {
                width: 200px;
            }

            .home-page.nav-active {
                padding-left: 220px;
            }

            .menu-button {
                left: 10px;
                top: 15px;
            }

            .borrowed-table th, .borrowed-table td {
                padding: 6px;
                font-size: 12px;
            }
        }
    </style>
</head>
<body>
    <div class="home-container">
        <div class="navigation">
            @include('layouts.navigation')
        </div>
        <div class="home-page">
            <button class="menu-button">
                <span class="material-symbols-outlined">menu</span>
            </button>
            <div class="rectangle-5">
                <div class="home-title">DASHBOARD</div>
            </div>

            <div style="margin: 20px auto; max-width: 1100px; background: #ded9c3; border-radius: 8px; padding: 15px; color: #121246; display: flex; align-items: center; gap: 10px;">
                <span>My Ratings:</span>
                <div style="display: flex; gap: 5px; font-size: 24px; color: #ffca08;">
                    @php
                        $roundedRating = round($averageRating);
                    @endphp
                    @for ($i = 1; $i <= 5; $i++)
                        @if ($i <= $roundedRating)
                            <span class="fa fa-star checked"></span>
                        @else
                            <span class="fa fa-star"></span>
                        @endif
                    @endfor
                </div>
                <span>({{ $ratingCount }} ratings)</span>
            </div>

            @if(session('success'))
                <div class="message success">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="message error">{{ session('error') }}</div>
            @endif

            @if($overdueCount > 0)
                <div class="overdue-notice">
                    You have {{ $overdueCount }} overdue book(s)! Please return them as soon as possible.
                </div>
            @endif

            <!-- Trending Books -->
            <div class="trending">Trending</div>
            <div class="book-container">
@forelse($books as $book)
    <div class="book-card">
        <a href="{{ route('books.show', $book->id) }}">
            <img src="{{ asset('storage/' . $book->cover_image) }}" alt="{{ $book->title }}">
        </a>
        <div class="book-info">
            <a href="{{ route('books.show', $book->id) }}">
                <p>{{ $book->title }}</p>
            </a>
            <div style="display: flex; align-items: center; gap: 5px; color: #ffca08; font-size: 18px; margin-bottom: 5px;">
                @php
                    $roundedRating = round($book->average_rating);
                @endphp
                @for ($i = 1; $i <= 5; $i++)
                    @if ($i <= $roundedRating)
                        <span class="fa fa-star checked"></span>
                    @else
                        <span class="fa fa-star"></span>
                    @endif
                @endfor
                <span style="color: #121246; font-size: 14px; margin-left: 8px;">({{ number_format($book->average_rating, 2) }}/5)</span>
            </div>
            <div class="quantity">Available: {{ $book->quantity }}</div>
                @if($book->quantity > 0)
                    <form action="{{ route('dashboard.borrow', $book) }}" method="POST" style="display:inline;">
                        @csrf
                    </form>
                @else
                    <span class="out-of-stock">Out of Stock</span>
                @endif
            </div>
    </div>
@empty
    <p style="color: #121246; padding: 20px;">No trending books available.</p>
@endforelse
            </div>

            <!-- Top Books -->
            <div class="trending2">Top Books</div>
            <div class="book-container">
@forelse($topBooks as $book)
    <div class="book-card">
        <a href="{{ route('books.show', $book->id) }}">
            <img src="{{ asset('storage/' . $book->cover_image) }}" alt="{{ $book->title }}">
        </a>
        <div class="book-info">
            <a href="{{ route('books.show', $book->id) }}">
                <p>{{ $book->title }}</p>
            </a>
            <div style="display: flex; align-items: center; gap: 5px; color: #ffca08; font-size: 18px; margin-bottom: 5px;">
                @php
                    $roundedRating = round($book->average_rating);
                @endphp
                @for ($i = 1; $i <= 5; $i++)
                    @if ($i <= $roundedRating)
                        <span class="fa fa-star checked"></span>
                    @else
                        <span class="fa fa-star"></span>
                    @endif
                @endfor
                <span style="color: #121246; font-size: 14px; margin-left: 8px;">({{ number_format($book->average_rating, 2) }}/5)</span>
            </div>
            <div class="quantity">Available: {{ $book->quantity }}</div>
                @if($book->quantity > 0)
                    <form action="{{ route('dashboard.borrow', $book) }}" method="POST" style="display:inline;">
                        @csrf
                        </form>
                @else
                    <span class="out-of-stock">Out of Stock</span>
                @endif
            </div>
    </div>
@empty
    <p style="color: #121246; padding: 20px;">No top books available.</p>
@endforelse
            </div>

            <!-- Most Read Books -->
            <div class="trending3">Most Read</div>
            <div class="book-container">
@forelse($mostReadBooks as $book)
    <div class="book-card">
        <a href="{{ route('books.show', $book->id) }}">
            <img src="{{ asset('storage/' . $book->cover_image) }}" alt="{{ $book->title }}">
        </a>
            <div class="book-info">
                <a href="{{ route('books.show', $book->id) }}">
                    <p>{{ $book->title }}</p>
                </a>
                <div style="display: flex; align-items: center; gap: 5px; color: #ffca08; font-size: 18px; margin-bottom: 5px;">
                    @php
                        $roundedRating = round($book->average_rating);
                    @endphp
                    @for ($i = 1; $i <= 5; $i++)
                        @if ($i <= $roundedRating)
                            <span class="fa fa-star checked"></span>
                        @else
                            <span class="fa fa-star"></span>
                        @endif
                    @endfor
                    <span style="color: #121246; font-size: 14px; margin-left: 8px;">({{ number_format($book->average_rating, 2) }}/5)</span>
                </div>
                <div class="quantity">Available: {{ $book->quantity }}</div>
                @if($book->quantity > 0)
                @else
                    <span class="out-of-stock">Out of Stock</span>
                @endif
            </div>
    </div>
@empty
    <p style="color: #121246; padding: 20px;">No most read books available.</p>
@endforelse
            </div>

            <!-- Borrowed Books -->
            <div class="borrowed-books">Your Borrowed Books</div>
            <div class="borrowed-table">
                @if($borrowedBooks->isEmpty())
                    <p style="color: #121246; text-align: center; padding: 20px;">You have not borrowed any books yet.</p>
                @else
                    <table>
                        <thead>
                            <tr>
                                <th>Book Title</th>
                                <th>Due Date</th>
                                <th>Status</th>
                                <th>Late Fee</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($borrowedBooks as $borrowedBook)
                                <tr>
                                    <td>{{ $borrowedBook->book->title }}</td>
                                    <td>
                                        {{ $borrowedBook->due_date->format('Y-m-d') }}
                                        @if($borrowedBook->due_date->isPast() && !$borrowedBook->returned_at)
                                            <span class="overdue">(Overdue)</span>
                                        @endif
                                    </td>
                                    <td>{{ ucfirst($borrowedBook->status) }}</td>
                                    <td>
                                        @if($borrowedBook->late_fee > 0)
                                            ${{ number_format($borrowedBook->late_fee, 2) }}
                                        @else
                                            $0.00
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const menuButton = document.querySelector('.menu-button');
            const navigation = document.querySelector('.navigation');
            const homePage = document.querySelector('.home-page');

            menuButton.addEventListener('click', function() {
                navigation.classList.toggle('active');
                homePage.classList.toggle('nav-active');
            });
        });
    </script>
</body>
</html>