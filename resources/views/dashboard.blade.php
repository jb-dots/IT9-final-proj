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
            background: #121246;
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
            color: #b5835a;
        }

        /* Main content styles */
        .home-page {
            flex: 1;
            background: #121246;
            min-height: 100vh;
            padding-left: 60px; /* Space for menu button */
            transition: padding-left 0.3s ease-in-out;
        }

        .home-page.nav-active {
            padding-left: 310px; /* Shift content when nav is active */
        }

        .rectangle-5 {
            background: #d4a373;
            width: 100%;
            height: 80px;
            position: fixed;
            left: 0;
            top: 0;
            border-bottom: 2px solid #b5835a;
            z-index: 1;
        }

        .home-title {
            color: #121246;
            text-align: center;
            font-family: "Inter-Regular", sans-serif;
            font-size: 28px;
            font-weight: 600;
            position: relative;
            top: 25px;
            z-index: 2;
        }

        /* Section headers */
        .trending, .trending2, .trending3 {
            color: #d4a373;
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
            background: #712222;
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

            .trending, .trending2, .trending3 {
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
            <div class="rectangle-5"></div>
            <div class="home-title">DASHBOARD</div>
            <div class="trending">Trending</div>
            <div class="book-container">
                @foreach($books as $book)
                    <div class="book-card">
                        <img src="{{ asset('images/' . $book->image) }}" alt="{{ $book->title }}">
                        <p>{{ $book->title }}</p>
                    </div>
                @endforeach
            </div>
            <div class="trending2">Top Books</div>
            <div class="book-container">
                <!-- Add books here -->
            </div>
            <div class="trending3">Most Read</div>
            <div class="book-container">
                <!-- Add books here -->
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