<!-- resources/views/book-borrow.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Borrow - Grand Archives</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200&display=swap" />
    @vite(['resources/css/app.css'])

    <style>
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

        .book-borrow-container {
            display: flex;
            width: 100%;
            min-height: 100vh;
            position: relative;
        }

        /* Navigation Sidebar */
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

        /* Main Content */
        .book-borrow-page {
            flex: 1;
            background: #121246;
            min-height: 100vh;
            padding-left: 60px;
            transition: padding-left 0.3s ease-in-out;
            overflow-y: auto;
        }

        .book-borrow-page.nav-active {
            padding-left: 310px;
        }

        .menu-button {
            position: fixed;
            left: 20px;
            top: 20px;
            cursor: pointer;
            z-index: 20;
            color: #d4a373;
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

        .grand-archives {
            color: #121246;
            text-align: center;
            font-family: "Inter-Regular", sans-serif;
            font-size: 28px;
            font-weight: 600;
            position: relative;
            top: 25px;
            z-index: 2;
        }

        .book-details {
            max-width: 1203px;
            margin: 100px auto 40px;
            padding: 20px;
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .book-header {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .book-image {
            width: 146px;
            height: 224px;
            object-fit: cover;
            border-radius: 8px;
        }

        .book-info {
            flex: 1;
        }

        .title-ars-ne-lupin-gentleman-burglar {
            color: #ffffff;
            font-family: "Inter-Regular", sans-serif;
            font-size: 32px;
            font-weight: 400;
            margin-bottom: 10px;
        }

        .author-maurice-leblanc-date-published-june-10-1907-genre-classics-mystery-fiction-crime-france-short-stories-detective-mystery-thriller-thriller {
            color: #d4a373;
            font-family: "Itim-Regular", sans-serif;
            font-size: 16px;
            font-weight: 400;
            line-height: 1.5;
        }

        .synopsis-container {
            background: #555353;
            border-radius: 12px;
            padding: 20px;
            margin-top: 20px;
        }

        .synopsis-title {
            color: #ffffff;
            font-family: "Inter-Regular", sans-serif;
            font-size: 24px;
            font-weight: 400;
            margin-bottom: 10px;
        }

        .synopsis-text {
            color: #ffffff;
            font-family: "Inter-Regular", sans-serif;
            font-size: 16px;
            font-weight: 400;
            line-height: 1.5;
        }

        .action-buttons {
            display: flex;
            gap: 20px;
            margin-top: 20px;
            justify-content: center;
        }

        .borrow-book-btn, .add-to-favorites-btn, .back-btn {
            background: #555353;
            border-radius: 12px;
            width: 145px;
            height: 43px;
            color: #ffffff;
            font-family: "Itim-Regular", sans-serif;
            font-size: 16px;
            font-weight: 400;
            text-align: center;
            line-height: 43px;
            transition: background-color 0.2s ease, transform 0.2s ease;
        }

        .borrow-book-btn:hover, .add-to-favorites-btn:hover, .back-btn:hover {
            background: #d4a373;
            transform: scale(1.05);
        }

        /* Responsive Adjustments */
        @media (max-width: 768px) {
            .navigation {
                width: 250px;
                left: -250px;
            }

            .book-borrow-page {
                padding-left: 50px;
            }

            .book-borrow-page.nav-active {
                padding-left: 260px;
            }

            .grand-archives {
                font-size: 24px;
            }

            .book-details {
                padding: 15px;
            }

            .book-header {
                flex-direction: column;
                text-align: center;
            }

            .book-image {
                margin: 0 auto;
            }

            .title-ars-ne-lupin-gentleman-burglar {
                font-size: 24px;
            }

            .synopsis-container {
                padding: 15px;
            }

            .action-buttons {
                flex-direction: column;
                gap: 15px;
            }
        }

        @media (max-width: 480px) {
            .navigation {
                width: 200px;
                left: -200px;
            }

            .book-borrow-page.nav-active {
                padding-left: 220px;
            }

            .menu-button {
                left: 10px;
                top: 15px;
            }

            .book-image {
                width: 120px;
                height: 180px;
            }

            .title-ars-ne-lupin-gentleman-burglar {
                font-size: 20px;
            }

            .synopsis-title {
                font-size: 20px;
            }

            .synopsis-text {
                font-size: 14px;
            }

            .action-buttons {
                gap: 10px;
            }
        }
    </style>
</head>
<body>
    <div class="book-borrow-container">
        <!-- Navigation Sidebar -->
        <div class="navigation">
            <div class="nav-content">
                <img class="nav-logo" src="{{ asset('images/logo-1-removebg-preview-10.png') }}" alt="Grand Archives Logo" />
                <div class="nav-title">GRAND ARCHIVES</div>
                <ul class="nav-links">
                    <li><a href="{{ route('dashboard') }}">Home</a></li>
                    <li><a href="{{ route('catalogs') }}">Catalogs</a></li>
                    <li><a href="{{ route('transaction') }}">Transaction</a></li>
                    <li><a href="{{ route('favorites') }}">Favorites</a></li>
                    <li><a href="{{ route('user.profile') }}">Profile</a></li>
                </ul>
            </div>
        </div>

        <!-- Main Content -->
        <div class="book-borrow-page">
            <button class="menu-button">
                <span class="material-symbols-outlined">menu</span>
            </button>
            <div class="rectangle-5"></div>
            <div class="grand-archives">Grand Archives</div>
            <div class="book-details">
                <div class="book-header">
                    <img class="book-image" src="{{ asset('images/_220-px-arsene-lupin-1907-french-edition-12.png') }}" alt="Arsène Lupin, Gentleman Burglar">
                    <div class="book-info">
                        <div class="title-ars-ne-lupin-gentleman-burglar">Title: Arsène Lupin, Gentleman Burglar</div>
                        <div class="author-maurice-leblanc-date-published-june-10-1907-genre-classics-mystery-fiction-crime-france-short-stories-detective-mystery-thriller-thriller">
                            Author: Maurice Leblanc<br>
                            Date Published: June 10, 1907<br>
                            Genre: Classics, Mystery, Fiction, Crime, France, Short Stories, Detective, Mystery Thriller, Thriller
                        </div>
                    </div>
                </div>
                <div class="synopsis-container">
                    <div class="synopsis-title">Synopsis:</div>
                    <div class="synopsis-text">
                        The suave adventures of a gentleman rogue—a French Thomas Crown. Created by Maurice LeBlanc during the early twentieth century, Arsene Lupin is a witty confidence man and burglar, the Sherlock Holmes of crime. The poor and innocent have nothing to fear from him; often they profit from his spontaneous generosity.
                    </div>
                </div>
                <div class="action-buttons">
                    <a href="{{ route('book.borrow') }}" class="borrow-book-btn">Borrow Book</a>
                    <a href="{{ route('book.favorite') }}" class="add-to-favorites-btn">Add to Favorites</a>
                    <a href="{{ route('catalog.show', 'crime-fiction') }}" class="back-btn">Back</a>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const menuButton = document.querySelector('.menu-button');
            const navigation = document.querySelector('.navigation');
            const bookBorrowPage = document.querySelector('.book-borrow-page');

            menuButton.addEventListener('click', function() {
                navigation.classList.toggle('active');
                bookBorrowPage.classList.toggle('nav-active');
            });
        });
    </script>
    @vite(['resources/js/app.js'])
</body>
</html>