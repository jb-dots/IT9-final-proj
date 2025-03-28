<!-- resources/views/favorites.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Favorites - Grand Archives</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200&display=swap" />
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

        .favorites-container {
            display: flex;
            width: 100%;
            min-height: 100vh;
            position: relative;
        }

        /* Navigation styles (consistent with previous views) */
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

        /* Main content styles */
        .favorites-page {
            flex: 1;
            background: #121246;
            min-height: 100vh;
            padding-left: 0px;
            transition: padding-left 0.3s ease-in-out;
        }

        .favorites-page.nav-active {
            padding-left: 310px;
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

        .favorites {
            color: #121246;
            text-align: center;
            font-family: "Inter-Regular", sans-serif;
            font-size: 28px;
            font-weight: 600;
            position: relative;
            top: 25px;
            z-index: 2;
        }

        /* Search bar styles */
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
        }

        .search-input {
            flex: 1;
            background: transparent;
            color: #121246;
            font-family: "Inter-Regular", sans-serif;
            font-size: 16px;
            outline: none;
        }

        .magnifying-1 {
            width: 24px;
            height: 24px;
            margin-left: 10px;
            cursor: pointer;
        }

        /* Favorites container */
        .favorites-content {
            background: #d4a373;
            border-radius: 24px;
            padding: 20px;
            margin: 0 20px 40px;
        }

        .book-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 20px;
            max-height: 60vh;
            overflow-y: auto;
        }

        .book-grid::-webkit-scrollbar {
            width: 8px;
        }

        .book-grid::-webkit-scrollbar-track {
            background: #d4a373;
        }

        .book-grid::-webkit-scrollbar-thumb {
            background: #b5835a;
            border-radius: 4px;
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
            .favorites-page {
                padding-left: 50px;
            }

            .favorites-page.nav-active {
                padding-left: 260px;
            }

            .favorites {
                font-size: 22px;
            }

            .rectangle-7 {
                max-width: 400px;
            }

            .book-grid {
                grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
                max-height: 50vh;
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

            .favorites-page.nav-active {
                padding-left: 220px;
            }

            .menu-button {
                left: 10px;
                top: 15px;
            }

            .rectangle-7 {
                max-width: 300px;
            }

            .book-grid {
                max-height: 40vh;
            }
        }
    </style>
</head>
<body>
    <div class="favorites-container">
        <div class="navigation">
            @include('layouts.navigation')
        </div>
        <div class="favorites-page">
            <button class="menu-button">
                <span class="material-symbols-outlined">menu</span>
            </button>
            <div class="rectangle-5"></div>
            <div class="favorites">FAVORITES</div>
            <div class="search-container">
                <div class="rectangle-7">
                    <input type="text" class="search-input" placeholder="Search favorites..." />
                    <img class="magnifying-1" src="{{ asset('images/magnifying-10.png') }}" alt="Search" />
                </div>
            </div>
            <div class="favorites-content">
                <div class="book-grid">
                    @foreach($favorites as $book)
                        <div class="book-card">
                            <img src="{{ asset('images/' . $book->image) }}" alt="{{ $book->title }}">
                            <p>{{ $book->title }}</p>
                        </div>
                    @endforeach
                    <!-- Placeholder for when there are no favorites -->
                    @if($favorites->isEmpty())
                        <p style="text-align: center; color: #121246; grid-column: 1 / -1;">No favorite books yet.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const menuButton = document.querySelector('.menu-button');
            const navigation = document.querySelector('.navigation');
            const favoritesPage = document.querySelector('.favorites-page');

            menuButton.addEventListener('click', function() {
                navigation.classList.toggle('active');
                favoritesPage.classList.toggle('nav-active');
            });

            // Basic search functionality
            const searchInput = document.querySelector('.search-input');
            const bookCards = document.querySelectorAll('.book-card');

            searchInput.addEventListener('input', function() {
                const searchTerm = searchInput.value.toLowerCase();
                bookCards.forEach(card => {
                    const bookTitle = card.querySelector('p').textContent.toLowerCase();
                    if (bookTitle.includes(searchTerm)) {
                        card.style.display = 'block';
                    } else {
                        card.style.display = 'none';
                    }
                });
            });
        });
    </script>
</body>
</html>