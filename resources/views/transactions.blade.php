<!-- resources/views/transactions.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transactions - Grand Archives</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200&display=swap" />
    @vite(['resources/css/app.css'])
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }
        body, html {
            height: 100%;
            font-family: "Inter-Regular", sans-serif;
            background: #ded9c3;
            color: #121246;
            overflow-x: hidden;
        }
        .transaction-container {
            display: flex;
            width: 100%;
            min-height: 100vh;
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
        }
        .menu-button:hover {
            color: #b5835a;
        }
        .transaction-page {
            flex: 1;
            background: #f0f0e4;
            min-height: 100vh;
            padding-left: 50px;
            transition: padding-left 0.3s ease-in-out;
        }
        .transaction-page.nav-active {
            padding-left: 310px;
        }
        .rectangle-5 {
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
        .transaction {
            color: #121246;
            text-align: center;
            font-size: 28px;
            font-weight: 600;
        }
        .due-amount-section {
            background: #d9d9d9;
            border-radius: 12px;
            max-width: 863px;
            height: 101px;
            margin: 100px auto 40px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .due-amount-here {
            font-size: 32px;
            font-weight: 400;
            display: flex;
            align-items: center;
            gap: 20px;
        }
        .pay-button, .return-button {
            background: #6aa933;
            color: #fff;
            padding: 8px 16px;
            border-radius: 12px;
            border: none;
            cursor: pointer;
            font-size: 14px;
            transition: background 0.2s;
        }
        .pay-button:hover, .return-button:hover {
            background: #5a8c2b;
        }
        .books-due-section {
            background: #b5835a;
            border-radius: 12px;
            padding: 20px;
            margin: 0 20px 40px;
        }
        .books-that-are-due {
            font-size: 24px;
            font-weight: 600;
            margin-bottom: 20px;
            position: sticky;
            top: 80px;
            background: #b5835a;
            padding: 10px 0;
            z-index: 2;
        }
        .empty-state {
            text-align: center;
            font-size: 16px;
            padding: 20px;
        }
        .empty-state a {
            color: #6aa933;
            text-decoration: underline;
        }
        .flash-message {
            max-width: 863px;
            margin: 20px auto;
            padding: 10px;
            border-radius: 8px;
            text-align: center;
        }
        .flash-message.success {
            background: #6aa933;
            color: #fff;
        }
        .flash-message.error {
            background: #c22d2d;
            color: #fff;
        }

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

            <!-- Flash Messages -->
            @if (session('success'))
                <div class="flash-message success">{{ session('success') }}</div>
            @endif
            @if (session('error'))
                <div class="flash-message error">{{ session('error') }}</div>
            @endif

            <!-- Due Amount Section -->
            <div class="due-amount-section">
                <div class="due-amount-here">
                    Due Amount: ${{ number_format($dueAmount, 2) }}
                    @if($dueAmount > 0)
                        <form action="{{ route('pay') }}" method="POST">
                            @csrf
                            <button type="submit" class="pay-button">Pay Now</button>
                        </form>
                    @endif
                </div>
            </div>

            <!-- All Borrowed Books -->
            <div class="books-due-section">
                <div class="books-that-are-due">All Borrowed Books</div>
                @foreach($borrowedBooks as $book)
                    <x-book-entry :book="$book" />
                @endforeach
                @if($borrowedBooks->isEmpty())
                    <p class="empty-state">
                        You have not borrowed any books yet. 
                        <a href="{{ route('catalogs') }}">Browse the catalog</a> to find a book!
                    </p>
                @endif
            </div>

            <!-- Books that are Due -->
            <div class="books-due-section">
                <div class="books-that-are-due">Books that are Due</div>
                @foreach($dueBooks as $book)
                    <x-book-entry :book="$book" />
                @endforeach
                @if($dueBooks->isEmpty())
                    <p class="empty-state">No books are currently due. Keep up the good work!</p>
                @endif
            </div>

            <!-- Recently Returned -->
            <div class="books-due-section">
                <div class="books-that-are-due">Recently Returned</div>
                @foreach($returnedBooks as $book)
                    <x-book-entry :book="$book" />
                @endforeach
                @if($returnedBooks->isEmpty())
                    <p class="empty-state">No books have been recently returned.</p>
                @endif
            </div>

            <!-- Payment History -->
            <div class="books-due-section">
                <div class="books-that-are-due">Payment History</div>
                @foreach($paymentHistory as $payment)
                    <div class="book-entry">
                        <div class="book-info">
                            <div>Amount: ${{ number_format($payment->amount, 2) }}</div>
                            <div>Date: {{ $payment->created_at->format('Y-m-d H:i') }}</div>
                            <div>Description: {{ $payment->description ?? 'N/A' }}</div>
                        </div>
                    </div>
                @endforeach
                @if($paymentHistory->isEmpty())
                    <p class="empty-state">No payment history available.</p>
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