<!-- resources/views/genre/show.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $genre->name }} - Grand Archives</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200&display=swap" />
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
            width: 309px;
            height: 100vh;
            background: #121246;
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
            background: #121246;
            min-height: 100vh;
            padding-left: 60px;
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
            color: #ffffff;
            font-size: 28px;
            background: transparent;
            transition: color 0.2s;
        }

        .menu-button:hover {
            color: #b5835a;
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

        .book-item img {
            width: 100%;
            height: auto;
            border-radius: 8px;
            object-fit: cover;
            aspect-ratio: 3/4;
            transition: transform 0.2s ease;
        }

        .book-item img:hover {
            transform: scale(1.05);
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
            <div class="book-grid">
                @forelse ($books as $book)
                    <div class="book-item">
                        <a href="{{ route('books.borrow', ['id' => $book->id]) }}">
                            <img src="{{ asset($book->cover_image) }}" alt="{{ $book->title }}">
                        </a>
                    </div>
                @empty
                    <div class="text-center text-gray-400">No books found in this genre.</div>
                @endforelse
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
    @vite(['resources/js/app.js'])
</body>
</html>