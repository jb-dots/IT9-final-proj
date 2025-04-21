<!-- resources/views/genre/show.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $genre->name }} - Grand Archives</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200&display=swap" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    @vite(['resources/css/app.css'])

    <style>
        /* Reset styles */
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            border: none;
            text-decoration: none;
            -webkit-font-smoothing: antialiased;
        }

        body, html {
            height: 100%;
            font-family: "Inter-Regular", sans-serif;
            background: #121246;
            color: #fff;
            overflow-x: hidden;
        }

        /* Container for layout */
        .genre-container {
            display: flex;
            width: 100%;
            min-height: 100vh;
            position: relative;
        }

        /* Navigation (consistent with catalog-selection.blade.php) */
        .navigation {
            width: 250px;
            height: 100vh;
            position: fixed;
            left: -309px;
            top: 0;
            transition: left 0.3s ease-in-out;
            z-index: 10;
            box-shadow: 2px 0 10px rgba(0, 0, 0, 0.3);
            overflow-y: auto;
        }

        .navigation.active {
            left: 0;
        }

        /* Main content */
        .genre-page {
            flex: 1;
            background: #f9f8f4;
            min-height: 100vh;
            padding-left: 0px;
            transition: padding-left 0.3s ease-in-out;
            overflow-y: auto;
        }

        .genre-page.nav-active {
            padding-left: 310px;
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
            transition: color 0.2s;
        }

        .menu-button:hover {
            color: #b5835a;
        }

        /* Book card styles similar to dashboard */
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

        /* Responsive adjustments */
        @media (max-width: 768px) {
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
        }

        .genre-title {
            color: #121246;
            text-align: center;
            font-family: "Inter-Regular", sans-serif;
            font-size: 28px;
            font-weight: 600;
            position: relative;
            top: 25px;
            z-index: 2;
        }

        /* Search bar */
        .search-container {
            margin: 100px auto 40px;
            width: 100%;
            max-width: 537px;
            position: relative;
            display: flex;
            justify-content: center;
        }

        .rectangle-7 {
            background: #d9d9d9;
            border-radius: 8px;
            width: 100%;
            height: 47px;
            padding: 0 50px 0 15px;
            font-family: "Inter-Regular", sans-serif;
            font-size: 16px;
            color: #121246;
            outline: none;
            border: none;
        }

        .magnifying-1 {
            width: 41px;
            height: 41px;
            position: absolute;
            right: 5px;
            top: 3px;
            cursor: pointer;
        }

        /* Book grid */
        .book-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
            gap: 20px;
            width: 100%;
            max-width: 1102px;
            margin: 0 auto 40px;
            padding: 0 20px;
        }

        .book-item {
            position: relative;
            text-align: center;
        }

        .book-item img {
            width: 100%;
            height: auto;
            border-radius: 8px;
            object-fit: cover;
            aspect-ratio: 3/4;
            transition: transform 0.2s ease;
            cursor: pointer;
        }

        .book-item img:hover {
            transform: scale(1.05);
        }

        .book-item .borrow-form {
            margin-top: 10px;
        }

        .book-item .borrow-button {
            padding: 5px 10px;
            background: #d4a373;
            color: #121246;
            border-radius: 4px;
            font-size: 14px;
            font-weight: 500;
            transition: background-color 0.2s ease;
            border: none;
            cursor: pointer;
        }

        .book-item .borrow-button:hover {
            background: #b5835a;
        }

        /* Modal styles */
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.8);
            justify-content: center;
            align-items: center;
        }

        .modal-content {
            max-width: 90%;
            max-height: 90%;
            border-radius: 8px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.5);
        }

        .modal-close {
            position: absolute;
            top: 20px;
            right: 20px;
            color: #d4a373;
            font-size: 36px;
            font-weight: bold;
            cursor: pointer;
            transition: color 0.2s ease;
        }

        .modal-close:hover {
            color: #b5835a;
        }

        /* Success/Error Messages */
        .success-message, .error-message {
            text-align: center;
            padding: 10px;
            margin: 10px auto;
            border-radius: 4px;
            max-width: 500px;
        }

        .success-message {
            background: #b5835a;
            color: #121246;
        }

        .error-message {
            background: #ff6b6b;
            color: #fff;
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .navigation {
                width: 250px;
                left: -250px;
            }

            .genre-page {
                padding-left: 50px;
            }

            .genre-page.nav-active {
                padding-left: 260px;
            }

            .genre-title {
                font-size: 22px;
            }

            .search-container {
                max-width: 400px;
            }

            .book-grid {
                grid-template-columns: repeat(auto-fill, minmax(120px, 1fr));
                gap: 15px;
            }

            .book-item .borrow-button {
                font-size: 12px;
                padding: 4px 8px;
            }
        }

        @media (max-width: 480px) {
            .navigation {
                width: 200px;
                left: -200px;
            }

            .genre-page.nav-active {
                padding-left: 220px;
            }

            .menu-button {
                left: 10px;
                top: 15px;
            }

            .search-container {
                max-width: 300px;
            }

            .book-grid {
                grid-template-columns: repeat(auto-fill, minmax(100px, 1fr));
                gap: 10px;
            }

            .book-item .borrow-button {
                font-size: 10px;
                padding: 3px 6px;
            }

            .modal-close {
                font-size: 28px;
                top: 10px;
                right: 10px;
            }
        }
    </style>
</head>
<body>
    <div class="genre-container">
        <!-- Navigation Sidebar -->
        <div class="navigation">
            @include('layouts.navigation')
        </div>

        <!-- Main Content -->
        <div class="genre-page">
            <button class="menu-button">
                <span class="material-symbols-outlined">menu</span>
            </button>
            <div class="rectangle-5"></div>
            <div class="genre-title">{{ $genre->name }}</div>
            <div class="search-container">
                <form method="GET" action="{{ route('genre.show', $genre->id) }}">
                    <input type="text" name="search" class="rectangle-7" placeholder="Search books..." value="{{ request('search') }}">
                    <button type="submit" style="background: none; border: none; padding: 0;">
                        <img class="magnifying-1" src="{{ asset('images/magnifying-10.png') }}" alt="Search Icon" />
                    </button>
                </form>
            </div>
            @if (session('success'))
                <div class="success-message">
                    {{ session('success') }}
                </div>
            @endif
            @if (session('error'))
                <div class="error-message">
                    {{ session('error') }}
                </div>
            @endif
            <div class="book-grid">
                @forelse ($books as $book)
                    <div class="book-card">
                        <a href="{{ route('books.show', $book->id) }}">
                            <img src="{{ asset('storage/' . $book->cover_image) }}" alt="{{ $book->title }}">
                        </a>
                        <div class="book-info">
                            <a href="{{ route('books.show', $book->id) }}">
                                <p>{{ $book->title }}</p>
                            </a>
                            <div style="display: flex; align-items: center; gap: 5px; color: #ffca08; font-size: 12px; margin-bottom: 5px;">
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
                            @if($book->quantity > 0)
                                <span class="quantity">Available: {{ $book->quantity }}</span>
                            @else
                                <span class="out-of-stock">Out of Stock</span>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="text-center text-gray-400">No books found in this genre.</div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Remove modal since we're redirecting instead of showing a modal -->
    <!-- Modal for image viewing is no longer needed -->
    <!-- <div class="modal" id="imageModal">
        <span class="modal-close">×</span>
        <img class="modal-content" id="modalImage">
    </div> -->

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const menuButton = document.querySelector('.menu-button');
            const navigation = document.querySelector('.navigation');
            const genrePage = document.querySelector('.genre-page');

            // Toggle navigation
            menuButton.addEventListener('click', function() {
                navigation.classList.toggle('active');
                genrePage.classList.toggle('nav-active');
            });
        });
    </script>
    @vite(['resources/js/app.js'])
</body>
</html>