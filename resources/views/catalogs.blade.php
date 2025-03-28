<!-- resources/views/catalogs.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catalogs - Grand Archives</title>
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

        .catalog-container {
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
            color: #121246; /* Changed to match theme */
            font-size: 28px;
            background: transparent;
            border: none;
            transition: color 0.2s;
        }

        .menu-button:hover {
            color: #b5835a;
        }

        /* Main content styles */
        .catalog-selection-page {
            flex: 1;
            background: #121246;
            min-height: 100vh;
            padding-left: 0px;
            transition: padding-left 0.3s ease-in-out;
        }

        .catalog-selection-page.nav-active {
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

        .catalogs {
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

        /* Genre cards */
        .genre-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 20px;
            padding: 0 20px;
            margin-bottom: 40px;
        }

        .genre-card {
            background: #b5835a;
            border-radius: 12px;
            height: 86px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
            cursor: pointer;
        }

        .genre-card:hover {
            transform: scale(1.05);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
        }

        .genre-card a {
            color: #000000;
            text-align: center;
            font-family: "Inter-Regular", sans-serif;
            font-size: 20px;
            font-weight: 400;
            padding: 0 10px; /* Add padding for longer genre names */
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            text-decoration: none;
            width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* Pagination styles */
        .pagination {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-top: 20px;
            margin-bottom: 40px;
            font-family: "Inter-Regular", sans-serif;
            font-size: 14px;
            color: #d4a373;
        }

        .pagination a, .pagination span {
            color: #d4a373;
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
            background-color: #b5835a;
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

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .catalog-selection-page {
                padding-left: 50px;
            }

            .catalog-selection-page.nav-active {
                padding-left: 260px;
            }

            .catalogs {
                font-size: 22px;
            }

            .rectangle-7 {
                max-width: 400px;
            }

            .genre-grid {
                grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
            }

            .genre-card {
                height: 70px;
            }

            .genre-card a {
                font-size: 16px;
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

            .catalog-selection-page.nav-active {
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
    <div class="catalog-container">
        <div class="navigation">
            @include('layouts.navigation')
        </div>
        <div class="catalog-selection-page">
            <button class="menu-button">
                <span class="material-symbols-outlined">menu</span>
            </button>
            <div class="rectangle-5"></div>
            <div class="catalogs">CATALOGS</div>
            <div class="search-container">
                <form method="GET" action="{{ route('catalogs') }}" class="rectangle-7">
                    <input type="text" name="search" class="search-input" placeholder="Search genres..." value="{{ request('search') }}" />
                    <button type="submit" style="background: none; border: none; padding: 0;">
                        <img class="magnifying-1" src="{{ asset('images/magnifying-10.png') }}" alt="Search" />
                    </button>
                </form>
            </div>
            <div class="genre-grid">
                @forelse ($genres as $genre)
                    <div class="genre-card">
                        <a href="{{ route('genre.show', $genre->id) }}">{{ $genre->name }}</a>
                    </div>
                @empty
                    <div class="text-center text-gray-400">No genres found.</div>
                @endforelse
            </div>
            <div class="pagination">
                {{ $genres->links('vendor.pagination.custom') }}
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const menuButton = document.querySelector('.menu-button');
            const navigation = document.querySelector('.navigation');
            const catalogPage = document.querySelector('.catalog-selection-page');

            menuButton.addEventListener('click', function() {
                navigation.classList.toggle('active');
                catalogPage.classList.toggle('nav-active');
            });
        });
    </script>
</body>
</html>