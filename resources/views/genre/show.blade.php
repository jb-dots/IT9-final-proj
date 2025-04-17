<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $genre->name }} - Grand Archives</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200&display=swap" />
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
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
            overflow-x: hidden;
        }

        .genre-container {
            display: flex;
            width: 100%;
            min-height: 100vh;
            position: relative;
        }

        .navigation {
            width: 250px;
            background: #121246;
            height: 100vh;
            position: fixed;
            left: -250px;
            top: 0;
            transition: left 0.3s ease-in-out;
            z-index: 10;
            box-shadow: 2px 0 10px rgba(0, 0, 0, 0.3);
        }

        .navigation.active {
            left: 0;
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

        .genre-page {
            flex: 1;
            background: #f9f8f4;
            min-height: 100vh;
            padding-left: 0px;
            transition: padding-left 0.3s ease-in-out;
        }

        .genre-page.nav-active {
            padding-left: 310px;
        }

        .header {
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

        .genre-title {
            color: #121246;
            text-align: center;
            font-family: "Inter-Regular", sans-serif;
            font-size: 28px;
            font-weight: 600;
            z-index: 2;
        }

        .search-container {
            display: flex;
            justify-content: center;
            margin: 100px 0 40px;
        }

        .rectangle-7 {
            background: #d9d9d9;
            border-radius: 8px;
            width: 100%;
            max-width: 500px;
            height: 47px;
            display: flex;
            align-items: center;
            padding: 0 15px;
            position: relative;
        }

        .search-input {
            flex: 1;
            background: transparent;
            color: #121246;
            font-family: "Inter-Regular", sans-serif;
            font-size: 16px;
            outline: none;
            border: none;
        }

        .magnifying-1 {
            width: 24px;
            height: 24px;
            margin-left: 10px;
            cursor: pointer;
        }

        .book-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 20px;
            padding: 0 20px 40px;
            margin-bottom: 40px;
        }

        .book-card {
            background: #b5835a;
            border-radius: 12px;
            padding: 15px;
            text-align: center;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .book-card:hover {
            transform: scale(1.05);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
        }

        .book-card img {
            width: 100%;
            height: 150px;
            object-fit: cover;
            border-radius: 8px;
            margin-bottom: 10px;
        }

        .book-card h3 {
            color: #121246;
            font-family: "Inter-Regular", sans-serif;
            font-size: 16px;
            font-weight: 500;
            margin-bottom: 5px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .book-card p {
            color: #121246;
            font-family: "Inter-Regular", sans-serif;
            font-size: 14px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .borrow-btn {
            display: inline-block;
            margin-top: 10px;
            padding: 8px 16px;
            background: #d4a373;
            color: #121246;
            border-radius: 4px;
            text-decoration: none;
            font-family: "Inter-Regular", sans-serif;
            font-size: 14px;
        }

        .borrow-btn:hover {
            background: #b5835a;
        }

        .pagination {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-top: 20px;
            margin-bottom: 40px;
            font-family: "Inter-Regular", sans-serif;
            font-size: 14px;
            color: #ded9c3;
        }

        .pagination a, .pagination span {
            color: #121246;
            padding: 4px 8px;
            text-decoration: none;
            margin: 0 4px;
            border-radius: 4px;
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        .pagination a:hover {
            background-color: #b5835a;
            color: #121246;
        }

        .pagination .current {
            background-color: #ded9c3;
            color: #121246;
            padding: 4px 8px;
            border-radius: 4px;
        }

        .pagination .disabled {
            color: #b5835a;
            opacity: 0.5;
            cursor: not-allowed;
        }

        .pagination .chevron {
            font-size: 18px;
            vertical-align: middle;
        }

        .message {
            text-align: center;
            padding: 10px;
            margin: 10px 20px;
        }

        .message.success {
            background: #6aa933;
            color: #fff;
        }

        .message.error {
            background: #ff3333;
            color: #fff;
        }

        @media (max-width: 768px) {
            .genre-page {
                padding-left: 50px;
            }

            .genre-page.nav-active {
                padding-left: 260px;
            }

            .genre-title {
                font-size: 22px;
            }

            .rectangle-7 {
                max-width: 400px;
            }

            .book-grid {
                grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
            }

            .book-card h3 {
                font-size: 14px;
            }

            .book-card p {
                font-size: 12px;
            }

            .borrow-btn {
                font-size: 12px;
                padding: 6px 12px;
            }

            .pagination {
                font-size: 12px;
            }

            .pagination a, .pagination span {
                padding: 3px 6px;
            }

            .pagination .chevron {
                font-size: 16px;
            }
        }

        @media (max-width: 480px) {
            .navigation {
                width: 200px;
            }

            .genre-page.nav-active {
                padding-left: 220px;
            }

            .menu-button {
                left: 10px;
                top: 15px;
            }

            .rectangle-7 {
                max-width: 300px;
            }

            .pagination {
                font-size: 10px;
            }

            .pagination a, .pagination span {
                padding: 2px 4px;
            }

            .pagination .chevron {
                font-size: 14px;
            }
        }
    </style>
</head>
<body>
    <div class="genre-container">
        <div class="navigation">
            @include('layouts.navigation')
        </div>
        <div class="genre-page">
            <button class="menu-button">
                <span class="material-symbols-outlined">menu</span>
            </button>
            <div class="header">
                <div class="genre-title">{{ $genre->name }}</div>
            </div>
            <div class="search-container">
                <form method="GET" action="{{ route('genre.show', $genre->id) }}" class="rectangle-7">
                    <input type="text" name="search" class="search-input" placeholder="Search books..." value="{{ request('search') }}" />
                    <button type="submit" style="background: none; border: none; padding: 0;">
                        <img class="magnifying-1" src="{{ asset('images/magnifying-10.png') }}" alt="Search" />
                    </button>
                </form>
            </div>
            @if(session('success'))
                <div class="message success">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="message error">{{ session('error') }}</div>
            @endif
            <div class="book-grid">
                @forelse ($books as $book)
                    <div class="book-card">
                        <img src="{{ asset($book->cover_image) }}" alt="{{ $book->title }}">
                        <h3>{{ $book->title }}</h3>
                        <p>{{ $book->author ?? 'Unknown Author' }}</p>
                        @if(auth()->check())
                            <a href="{{ route('catalogs.borrow', $book->id) }}" class="borrow-btn">Borrow</a>
                        @else
                            <p style="color: #121246; font-size: 12px; margin-top: 10px;">Please log in to borrow.</p>
                        @endif
                    </div>
                @empty
                    <div class="text-center text-gray-400" style="grid-column: 1 / -1;">No books found in this genre.</div>
                @endforelse
            </div>
            <div class="pagination">
                {{ $books->links('vendor.pagination.custom') }}
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const menuButton = document.querySelector('.menu-button');
            const navigation = document.querySelector('.navigation');
            const genrePage = document.querySelector('.genre-page');

            menuButton.addEventListener('click', function() {
                navigation.classList.toggle('active');
                genrePage.classList.toggle('nav-active');
            });
        });
    </script>
</body>
</html>