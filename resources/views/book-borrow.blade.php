<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Borrow {{ $book->title }} - Grand Archives</title>
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

        .borrow-container {
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

        .borrow-page {
            flex: 1;
            background: #f9f8f4;
            min-height: 100vh;
            padding-left: 0px;
            transition: padding-left 0.3s ease-in-out;
        }

        .borrow-page.nav-active {
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

        .borrow-title {
            color: #121246;
            text-align: center;
            font-family: "Inter-Regular", sans-serif;
            font-size: 28px;
            font-weight: 600;
            z-index: 2;
        }

        .form-container {
            max-width: 600px;
            margin: 100px auto 40px;
            padding: 20px;
            background: #ded9c3;
            border-radius: 8px;
        }

        .book-details {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
        }

        .book-details img {
            width: 100px;
            height: 150px;
            object-fit: cover;
            border-radius: 8px;
            margin-right: 20px;
        }

        .book-info h3 {
            color: #121246;
            font-family: "Inter-Regular", sans-serif;
            font-size: 20px;
            font-weight: 500;
            margin-bottom: 5px;
        }

        .book-info p {
            color: #121246;
            font-family: "Inter-Regular", sans-serif;
            font-size: 16px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
            color: #121246;
            font-family: "Inter-Regular", sans-serif;
            font-size: 16px;
        }

        .form-group input {
            width: 100%;
            padding: 8px;
            border-radius: 4px;
            border: none;
            background: #d9d9d9;
            color: #121246;
        }

        .submit-btn {
            display: block;
            width: 100%;
            padding: 10px;
            background: #b5835a;
            color: #121246;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-family: "Inter-Regular", sans-serif;
            font-size: 16px;
            font-weight: 500;
        }

        .submit-btn:hover {
            background: #d4a373;
        }

        .back-btn {
            display: inline-block;
            margin-bottom: 20px;
            padding: 8px 16px;
            background: #d4a373;
            color: #121246;
            border-radius: 4px;
            text-decoration: none;
            font-family: "Inter-Regular", sans-serif;
            font-size: 16px;
        }

        .back-btn:hover {
            background: #b5835a;
        }

        .error-message {
            background: #ff6b6b;
            color: #fff;
            padding: 10px;
            border-radius: 4px;
            margin-bottom: 20px;
            text-align: center;
        }

        @media (max-width: 768px) {
            .borrow-page {
                padding-left: 50px;
            }

            .borrow-page.nav-active {
                padding-left: 260px;
            }

            .borrow-title {
                font-size: 22px;
            }

            .book-details img {
                width: 80px;
                height: 120px;
            }

            .book-info h3 {
                font-size: 18px;
            }

            .book-info p {
                font-size: 14px;
            }
        }

        @media (max-width: 480px) {
            .navigation {
                width: 200px;
            }

            .borrow-page.nav-active {
                padding-left: 220px;
            }

            .menu-button {
                left: 10px;
                top: 15px;
            }

            .book-details {
                flex-direction: column;
                align-items: flex-start;
            }

            .book-details img {
                margin-bottom: 10px;
                margin-right: 0;
            }
        }
    </style>
</head>
<body>
    <div class="borrow-container">
        <div class="navigation">
            @include('layouts.navigation')
        </div>
        <div class="borrow-page">
            <button class="menu-button">
                <span class="material-symbols-outlined">menu</span>
            </button>
            <div class="header">
                <div class="borrow-title">Borrow Book</div>
            </div>
            <div class="form-container">
                <a href="{{ route('genre.show', $book->genre_id) }}" class="back-btn">Back to Genre</a>
                @if (session('error'))
                    <div class="error-message">
                        {{ session('error') }}
                    </div>
                @endif
                <div class="book-details">
                    <img src="{{ asset($book->cover_image) }}" alt="{{ $book->title }}">
                    <div class="book-info">
                        <h3>{{ $book->title }}</h3>
                        <p>{{ $book->author ?? 'Unknown Author' }}</p>
                    </div>
                </div>
                <form action="{{ route('books.borrow', $book->id) }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="borrow_days">Borrow Duration (days)</label>
                        <input type="number" name="borrow_days" id="borrow_days" value="14" min="1" max="30" required>
                    </div>
                    <button type="submit" class="submit-btn">Borrow Book</button>
                </form>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const menuButton = document.querySelector('.menu-button');
            const navigation = document.querySelector('.navigation');
            const borrowPage = document.querySelector('.borrow-page');

            menuButton.addEventListener('click', function() {
                navigation.classList.toggle('active');
                borrowPage.classList.toggle('nav-active');
            });
        });
    </script>
</body>
</html>
