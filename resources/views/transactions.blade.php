<!-- resources/views/transactions.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transactions - Grand Archives</title>
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
            background: #ded9c3;
            color: #fff;
            overflow-x: hidden;
        }

        .transaction-container {
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
            color: #121246;
        }

        /* Main content styles */
        .transaction-page {
            flex: 1;
            background: #f0f0e4;
            min-height: 100vh;
            padding-left: 0px;
            transition: padding-left 0.3s ease-in-out;
        }

        .transaction-page.nav-active {
            padding-left: 310px;
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
            display: flex; /* Added to center the transaction text */
            justify-content: center; /* Horizontally center */
            align-items: center; /* Vertically center */
        }

        .transaction {
            color: #121246;
            text-align: center;
            font-family: "Inter-Regular", sans-serif;
            font-size: 28px;
            font-weight: 600;
            z-index: 2;
        }

        /* Due amount section */
        .due-amount-section {
            background: #d9d9d9;
            border-radius: 12px;
            width: 100%;
            max-width: 863px;
            height: 101px;
            margin: 100px auto 40px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .due-amount-here {
            color: #121246;
            text-align: center;
            font-family: "Inter-Regular", sans-serif;
            font-size: 32px;
            font-weight: 400;
        }

        /* Books that are due sections */
        .books-due-section {
            background: #b5835a;
            border-radius: 12px;
            padding: 20px;
            margin: 0 20px 40px;
        }

        .books-that-are-due {
            color: #121246;
            font-family: "Inter-Regular", sans-serif;
            font-size: 24px;
            font-weight: 400;
            margin-bottom: 20px;
        }

        .book-entry {
            background: #d9d9d9;
            border-radius: 12px;
            padding: 15px;
            margin-bottom: 15px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .book-info {
            color: #121246;
            font-family: "Inter-Regular", sans-serif;
            font-size: 16px;
        }

        .book-info div {
            margin-bottom: 5px;
        }

        .status {
            padding: 5px 15px;
            border-radius: 12px;
            color: #ffffff;
            font-family: "Inter-Regular", sans-serif;
            font-size: 14px;
            font-weight: 400;
            text-align: center;
        }

        .status.due {
            background: #c22d2d;
        }

        .status.returned {
            background: #6aa933;
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .transaction-page {
                padding-left: 50px;
            }

            .transaction-page.nav-active {
                padding-left: 260px;
            }

            .transaction {
                font-size: 22px;
            }

            .due-amount-section {
                max-width: 600px;
                height: 80px;
            }

            .due-amount-here {
                font-size: 24px;
            }

            .books-that-are-due {
                font-size: 20px;
            }

            .book-info {
                font-size: 14px;
            }

            .status {
                font-size: 12px;
                padding: 5px 10px;
            }
        }

        @media (max-width: 480px) {
            .navigation {
                width: 200px;
            }

            .transaction-page.nav-active {
                padding-left: 220px;
            }

            .menu-button {
                left: 10px;
                top: 15px;
            }

            .due-amount-section {
                max-width: 400px;
                height: 60px;
            }

            .due-amount-here {
                font-size: 20px;
            }

            .book-entry {
                flex-direction: column;
                align-items: flex-start;
                gap: 10px;
            }
        }
    </style>
</head>
<body>
    <div class="transaction-container">
        <div class="navigation">
            @include('layouts.navigation')
        </div>
        <div class="transaction-page">
            <button class="menu-button">
                <span class="material-symbols-outlined">menu</span>
            </button>
            <div class="rectangle-5">
                <div class="transaction">BORROWED BOOKS</div>
            </div>
            <div class="due-amount-section">
                <div class="due-amount-here">
                    Due Amount: ${{ number_format($dueAmount, 2) }}
                </div>
            </div>
            <!-- New Section: All Borrowed Books -->
            <div class="books-due-section">
                <div class="books-that-are-due">All Borrowed Books</div>
                @foreach($borrowedBooks as $book)
                    <div class="book-entry">
                        <div class="book-info">
                            <div class="book-name">Book name: {{ $book->book->title }}</div>
                            <div class="due-date">Due Date: {{ $book->due_date->format('Y-m-d') }}</div>
                            @if($book->returned_at)
                                <div class="returned-date">Returned On: {{ $book->returned_at->format('Y-m-d') }}</div>
                            @endif
                        </div>
                        <div class="status {{ $book->returned_at ? 'returned' : ($book->due_date < now() && !$book->returned_at ? 'due' : 'borrowed') }}">
                            {{ $book->returned_at ? 'Returned' : ($book->due_date < now() && !$book->returned_at ? 'Due' : 'Borrowed') }}
                        </div>
                    </div>
                @endforeach
                @if($borrowedBooks->isEmpty())
                    <p style="text-align: center; color: #121246;">You have not borrowed any books yet.</p>
                @endif
            </div>
            <!-- Existing Due Books Section -->
            <div class="books-due-section">
                <div class="books-that-are-due">Books that are Due</div>
                @foreach($dueBooks as $book)
                    <div class="book-entry">
                        <div class="book-info">
                            <div class="book-name">Book name: {{ $book->book->title }}</div>
                            <div class="due-date">Due Date: {{ $book->due_date->format('Y-m-d') }}</div>
                        </div>
                        <div class="status due">Due</div>
                    </div>
                @endforeach
                @if($dueBooks->isEmpty())
                    <p style="text-align: center; color: #121246;">No books are currently due.</p>
                @endif
            </div>
            <!-- Existing Returned Books Section -->
            <div class="books-due-section">
                <div class="books-that-are-due">Recently Returned</div>
                @foreach($returnedBooks as $book)
                    <div class="book-entry">
                        <div class="book-info">
                            <div class="book-name">Book name: {{ $book->book->title }}</div>
                            <div class="due-date">Returned On: {{ $book->returned_at->format('Y-m-d') }}</div>
                        </div>
                        <div class="status returned">Returned</div>
                    </div>
                @endforeach
                @if($returnedBooks->isEmpty())
                    <p style="text-align: center; color: #121246;">No books have been recently returned.</p>
                @endif
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const menuButton = document.querySelector('.menu-button');
            const navigation = document.querySelector('.navigation');
            const transactionPage = document.querySelector('.transaction-page');

            menuButton.addEventListener('click', function() {
                navigation.classList.toggle('active');
                transactionPage.classList.toggle('nav-active');
            });
        });
    </script>
</body>
</html>