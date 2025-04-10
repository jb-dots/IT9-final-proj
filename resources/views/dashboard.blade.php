<!-- resources/views/dashboard.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200&display=swap" />
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
            font-family: Arial, sans-serif;
            background: #121246;
            color: #fff;
            overflow-x: hidden;
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
            position: fixed; /* Kept as fixed per original design */
            left: 0;
            top: 0;
            border-bottom: 2px solid #b5835a;
            z-index: 1;
            display: flex; /* Added to center the home-title text */
            justify-content: center; /* Horizontally center */
            align-items: center; /* Vertically center */
        }

        .home-title {
            color: #121246;
            text-align: center;
            font-family: "Inter-Regular", sans-serif;
            font-size: 28px;
            font-weight: 600;
            z-index: 2;
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
            height: 250px;
            background: #b5835a;
            border-radius: 15px;
            border: 1px solid #b5835a;
            overflow: hidden;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
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

        .book-card p {
            color: #d4a373;
            text-align: center;
            font-family: "Inter-Regular", sans-serif;
            font-size: 14px;
            padding: 10px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
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

        .overdue-notice {
            background: #ff6b6b;
            color: #fff;
            padding: 10px;
            border-radius: 4px;
            text-align: center;
            margin: 20px auto;
            max-width: 1100px;
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
                height: 200px;
            }

            .book-card img {
                height: 130px;
            }

            .book-card p {
                font-size: 12px;
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

            @if($overdueCount > 0)
                <div class="overdue-notice">
                    You have {{ $overdueCount }} overdue book(s)! Please return them as soon as possible.
                </div>
            @endif

            <div class="trending">Trending</div>
            <div class="book-container">
                @forelse($books as $book)
                    <div class="book-card">
                        <img src="{{ asset('storage/' . $book->cover_image) }}" alt="{{ $book->title }}">
                        <p>{{ $book->title }}</p>
                    </div>
                @empty
                    <p style="color: #121246; padding: 20px;">No trending books available.</p>
                @endforelse
            </div>

            <div class="trending2">Top Books</div>
            <div class="book-container">
                @forelse($topBooks as $book)
                    <div class="book-card">
                        <img src="{{ asset('storage/' . $book->cover_image) }}" alt="{{ $book->title }}">
                        <p>{{ $book->title }}</p>
                    </div>
                @empty
                    <p style="color: #121246; padding: 20px;">No top books available.</p>
                @endforelse
            </div>

            <div class="trending3">Most Read</div>
            <div class="book-container">
                @forelse($mostReadBooks as $book)
                    <div class="book-card">
                        <img src="{{ asset('storage/' . $book->cover_image) }}" alt="{{ $book->title }}">
                        <p>{{ $book->title }}</p>
                    </div>
                @empty
                    <p style="color: #121246; padding: 20px;">No most read books available.</p>
                @endforelse
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