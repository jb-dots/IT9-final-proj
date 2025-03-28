<!-- resources/views/crime-fiction.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Books - Grand Archives</title>
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
        .crime-fiction-container {
            display: flex;
            width: 100%;
            min-height: 100vh;
            position: relative;
        }

        /* Navigation (consistent with catalog-selection.blade.php) */
        .navigation {
            width: 309px; /* Updated to match catalog-selection.blade.php */
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

        .nav-content {
            display: flex;
            flex-direction: column;
            align-items: center;
            height: 100%;
            padding: 20px 0;
        }

        .nav-logo {
            width: 150px;
            height: 150px;
            object-fit: cover;
            margin-bottom: 20px;
        }

        .nav-title {
            color: #ffffff;
            text-align: center;
            font-family: "JacquesFrancoisShadow-Regular", sans-serif;
            font-size: 28px;
            font-weight: 400;
            margin-bottom: 30px;
        }

        .nav-links {
            list-style: none;
            width: 100%;
            padding: 0;
        }

        .nav-links li {
            width: 100%;
        }

        .nav-links a {
            display: block;
            color: #ffffff;
            text-align: center;
            font-family: "Inter-Regular", sans-serif;
            font-size: 18px;
            font-weight: 400;
            padding: 15px 0;
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        .nav-links a:hover {
            background-color: #d4a373;
            color: #121246;
        }

        /* Main content */
        .crime-fiction-page {
            flex: 1;
            background: #121246;
            min-height: 100vh;
            padding-left: 60px;
            transition: padding-left 0.3s ease-in-out;
            overflow-y: auto;
        }

        .crime-fiction-page.nav-active {
            padding-left: 310px; /* Updated to match navigation width */
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

        .crime-fiction {
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

            .crime-fiction-page {
                padding-left: 50px;
            }

            .crime-fiction-page.nav-active {
                padding-left: 260px;
            }

            .crime-fiction {
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

            .crime-fiction-page.nav-active {
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
    <div class="crime-fiction-container">
        <!-- Navigation Sidebar -->
        <div class="navigation">
            <div class="nav-content">
                <img class="nav-logo" src="{{ asset('images/logo-1-removebg-preview-10.png') }}" alt="Grand Archives Logo" />
                <div class="nav-title">GRAND ARCHIVES</div>
                <ul class="nav-links">
                    <li><a href="{{ route('catalog.selection') }}">Catalogs</a></li>
                    <li><a href="{{ route('catalog.show', 'fantasy') }}">Fantasy</a></li>
                    <li><a href="{{ route('catalog.show', 'sci-fi') }}">Sci-Fi</a></li>
                    <li><a href="{{ route('catalog.show', 'romance') }}">Romance</a></li>
                    <li><a href="{{ route('catalog.show', 'thriller') }}">Thriller</a></li>
                    <li><a href="{{ route('catalog.show', 'comedy') }}">Comedy</a></li>
                    <li><a href="{{ route('catalog.show', 'crime-fiction') }}">Crime Fiction</a></li>
                    <li><a href="{{ route('catalog.show', 'western-fiction') }}">Western Fiction</a></li>
                    <li><a href="{{ route('catalog.show', 'biography') }}">Biography</a></li>
                    <li><a href="{{ route('catalog.show', 'non-fiction') }}">Non-Fiction</a></li>
                    <li><a href="{{ route('catalog.show', 'historical-fiction') }}">Historical Fiction</a></li>
                    <li><a href="{{ route('catalog.show', 'mystery') }}">Mystery</a></li>
                    <li><a href="{{ route('catalog.show', 'horror') }}">Horror</a></li>
                    <li><a href="{{ route('catalog.show', 'adventure') }}">Adventure</a></li>
                    <li><a href="{{ route('catalog.show', 'young-adult') }}">Young Adult</a></li>
                    <li><a href="{{ route('catalog.show', 'self-help') }}">Self-Help</a></li>
                    <li><a href="{{ route('catalog.show', 'classics') }}">Classics</a></li>
                    <li><a href="{{ route('catalog.show', 'contemporary-fiction') }}">Contemporary Fiction</a></li>
                    <li><a href="{{ route('catalog.show', 'dystopian') }}">Dystopian</a></li>
                    <li><a href="{{ route('catalog.show', 'erotica') }}">Erotica</a></li>
                    <li><a href="{{ route('catalog.show', 'graphic-novels') }}">Graphic Novels</a></li>
                    <li><a href="{{ route('catalog.show', 'literary-fiction') }}">Literary Fiction</a></li>
                    <li><a href="{{ route('catalog.show', 'magical-realism') }}">Magical Realism</a></li>
                    <li><a href="{{ route('catalog.show', 'paranormal') }}">Paranormal</a></li>
                    <li><a href="{{ route('catalog.show', 'poetry') }}">Poetry</a></li>
                    <li><a href="{{ route('catalog.show', 'psychological-thriller') }}">Psychological Thriller</a></li>
                    <li><a href="{{ route('catalog.show', 'satire') }}">Satire</a></li>
                    <li><a href="{{ route('catalog.show', 'science') }}">Science</a></li>
                    <li><a href="{{ route('catalog.show', 'spirituality') }}">Spirituality</a></li>
                    <li><a href="{{ route('catalog.show', 'sports') }}">Sports</a></li>
                    <li><a href="{{ route('catalog.show', 'travel') }}">Travel</a></li>
                    <li><a href="{{ route('catalog.show', 'true-crime') }}">True Crime</a></li>
                    <li><a href="{{ route('catalog.show', 'urban-fantasy') }}">Urban Fantasy</a></li>
                    <li><a href="{{ route('catalog.show', 'womens-fiction') }}">Women's Fiction</a></li>
                    <li><a href="{{ route('catalog.show', 'childrens-literature') }}">Children's Literature</a></li>
                    <li><a href="{{ route('catalog.show', 'middle-grade') }}">Middle Grade</a></li>
                    <li><a href="{{ route('catalog.show', 'cookbooks') }}">Cookbooks</a></li>
                    <li><a href="{{ route('catalog.show', 'business') }}">Business</a></li>
                    <li><a href="{{ route('catalog.show', 'technology') }}">Technology</a></li>
                    <li><a href="{{ route('catalog.show', 'health-wellness') }}">Health & Wellness</a></li>
                    <li><a href="{{ route('catalog.show', 'philosophy') }}">Philosophy</a></li>
                    <li><a href="{{ route('catalog.show', 'political-fiction') }}">Political Fiction</a></li>
                    <li><a href="{{ route('catalog.show', 'short-stories') }}">Short Stories</a></li>
                    <li><a href="{{ route('catalog.show', 'essays') }}">Essays</a></li>
                    <li><a href="{{ route('catalog.show', 'memoirs') }}">Memoirs</a></li>
                    <li><a href="{{ route('catalog.show', 'autobiographies') }}">Autobiographies</a></li>
                    <li><a href="{{ route('home') }}">Back to Dashboard</a></li>
                </ul>
            </div>
        </div>

        <!-- Main Content -->
        <div class="crime-fiction-page">
            <button class="menu-button">
                <span class="material-symbols-outlined">menu</span>
            </button>
            <div class="rectangle-5"></div>
            <div class="crime-fiction">Crime Fiction</div>
            <div class="search-container">
                <input type="text" class="rectangle-7" placeholder="Search books...">
                <img class="magnifying-1" src="{{ asset('images/magnifying-10.png') }}" alt="Search Icon" />
            </div>
            <div class="book-grid">
                <div class="book-item">
                    <a href="{{ route('books.borrow', ['id' => 1]) }}">
                        <img src="{{ asset('images/the-great-adventures-of-sherlock-holmes-1-10.png') }}" alt="Sherlock Holmes">
                    </a>
                </div>

                <div class="book-item">
                    <a href="{{ route('books.borrow', ['id' => 2]) }}">
                        <img src="{{ asset('images/the-adventures-of-arsene-lupin-gentleman-thief-10.png') }}" alt="Arsene Lupin">
                    </a>
                </div>

                <div class="book-item">
                    <a href="{{ route('books.borrow', ['id' => 3]) }}">
                        <img src="{{ asset('images/a-56-cf-750-558-a-4812-8010-68911-e-06-c-7-eb-10.png') }}" alt="Crime Fiction Book">
                    </a>
                </div>

                <div class="book-item">
                    <a href="{{ route('books.borrow', ['id' => 4]) }}">
                        <img src="{{ asset('images/_91-d-dv-9-w-oc-fl-ac-uf-1000-1000-ql-80-10.png') }}" alt="Crime Fiction Book">
                    </a>
                </div>

                <div class="book-item">
                    <a href="{{ route('books.borrow', ['id' => 5]) }}">
                        <img src="{{ asset('images/ars-ne-lupin-contre-herlock-sholm-s-10.png') }}" alt="Arsene vs Sherlock">
                    </a>
                </div>

                <div class="book-item">
                    <a href="{{ route('books.borrow', ['id' => 6]) }}">
                        <img src="{{ asset('images/_220-px-mystery-january-1934-10.png') }}" alt="Mystery Magazine">
                    </a>
                </div>

                <div class="book-item">
                    <a href="{{ route('books.borrow', ['id' => 7]) }}">
                        <img src="{{ asset('images/i-511101288-witness-to-murder-800-x-1200-web-sample-10.png') }}" alt="Witness to Murder">
                    </a>
                </div>

                <div class="book-item">
                    <a href="{{ route('books.borrow', ['id' => 8]) }}">
                        <img src="{{ asset('images/_220-px-arsene-lupin-1907-french-edition-10.png') }}" alt="Arsene Lupin 1907">
                    </a>
                </div>

            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const menuButton = document.querySelector('.menu-button');
            const navigation = document.querySelector('.navigation');
            const crimeFictionPage = document.querySelector('.crime-fiction-page');

            menuButton.addEventListener('click', function() {
                navigation.classList.toggle('active');
                crimeFictionPage.classList.toggle('nav-active');
            });
        });
    </script>
    @vite(['resources/js/app.js'])
</body>
</html>
