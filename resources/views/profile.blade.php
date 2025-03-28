<!-- resources/views/profile.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile - Grand Archives</title>
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

        .profile-container {
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
            color: #d4a373;
            font-size: 28px;
            background: transparent;
            border: none;
            transition: color 0.2s;
        }

        .menu-button:hover {
            color: #b5835a;
        }

        /* Main content styles */
        .profile-page {
            flex: 1;
            background: #121246;
            min-height: 100vh;
            padding-left: 60px;
            transition: padding-left 0.3s ease-in-out;
            overflow-y: auto; /* Enable vertical scrolling */
        }

        .profile-page.nav-active {
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

        .profile {
            color: #121246;
            text-align: center;
            font-family: "Inter-Regular", sans-serif;
            font-size: 28px;
            font-weight: 600;
            position: relative;
            top: 25px;
            z-index: 2;
        }

        /* Profile content */
        .profile-content {
            background: #d4a373;
            border-radius: 12px;
            width: 100%;
            max-width: 1203px;
            margin: 100px auto 40px;
            padding: 40px;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 15px;
        }

        .images-1-1 {
            border-radius: 85.5px;
            width: 171px;
            height: 171px;
            object-fit: cover;
        }

        .dreamy-bull {
            color: #121246;
            text-align: center;
            font-family: "Inter-Regular", sans-serif;
            font-size: 32px;
            font-weight: 400;
        }

        .profile-info {
            color: #121246;
            text-align: center;
            font-family: "Inter-Regular", sans-serif;
            font-size: 20px;
            font-weight: 400;
            max-width: 600px;
        }

        .library-stats {
            margin-top: 20px;
            width: 100%;
            max-width: 600px;
            background: #c2a379;
            border-radius: 8px;
            padding: 20px;
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .stat-item {
            display: flex;
            justify-content: space-between;
            color: #121246;
            font-family: "Inter-Regular", sans-serif;
            font-size: 18px;
            font-weight: 400;
        }

        .stat-item span:first-child {
            font-weight: 600;
        }

        .button-group {
            display: flex;
            gap: 20px;
            margin-top: 20px;
        }

        .edit-profile,
        .logout {
            padding: 10px 20px;
            border-radius: 8px;
            color: #ffffff;
            font-family: "Inter-Regular", sans-serif;
            font-size: 16px;
            font-weight: 400;
            text-align: center;
            cursor: pointer;
            transition: background 0.2s ease;
        }

        .edit-profile {
            background: #6aa933;
        }

        .edit-profile:hover {
            background: #5a8b2a;
        }

        .logout {
            background: #c22d2d;
        }

        .logout:hover {
            background: #a82525;
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .profile-page {
                padding-left: 50px;
            }

            .profile-page.nav-active {
                padding-left: 260px;
            }

            .profile {
                font-size: 22px;
            }

            .profile-content {
                max-width: 600px;
                padding: 20px;
            }

            .images-1-1 {
                width: 120px;
                height: 120px;
                border-radius: 60px;
            }

            .dreamy-bull {
                font-size: 24px;
            }

            .profile-info {
                font-size: 16px;
            }

            .library-stats {
                padding: 15px;
            }

            .stat-item {
                font-size: 16px;
            }

            .edit-profile,
            .logout {
                font-size: 14px;
                padding: 8px 16px;
            }
        }

        @media (max-width: 480px) {
            .navigation {
                width: 200px;
            }

            .profile-page.nav-active {
                padding-left: 220px;
            }

            .menu-button {
                left: 10px;
                top: 15px;
            }

            .profile-content {
                max-width: 400px;
            }

            .images-1-1 {
                width: 100px;
                height: 100px;
                border-radius: 50px;
            }

            .library-stats {
                padding: 10px;
            }

            .stat-item {
                font-size: 14px;
                flex-direction: column;
                gap: 5px;
                align-items: center;
            }

            .button-group {
                flex-direction: column;
                gap: 10px;
            }
        }
    </style>
</head>
<body>
    <div class="profile-container">
        <div class="navigation">
            @include('layouts.navigation')
        </div>
        <div class="profile-page">
            <button class="menu-button">
                <span class="material-symbols-outlined">menu</span>
            </button>
            <div class="rectangle-5"></div>
            <div class="profile">PROFILE</div>
            <div class="profile-content">
                <img class="images-1-1" src="{{ asset('images/' . (Auth::user()->profile_picture ?? 'images-1-10.png')) }}" alt="Profile Picture" />
                <div class="dreamy-bull">{{ Auth::user()->name }}</div>
                <div class="profile-info">Contact: {{ Auth::user()->contact_no ?? 'Not provided' }}</div>
                <div class="profile-info">Email: {{ Auth::user()->email }}</div>
                <div class="profile-info">Address: {{ Auth::user()->address ?? 'Not provided' }}</div>
                <div class="library-stats">
                    <div class="stat-item">
                        <span>Membership ID:</span>
                        <span>{{ Auth::user()->membership_id ?? 'Not assigned' }}</span>
                    </div>
                    <div class="stat-item">
                        <span>Join Date:</span>
                        <span>{{ Auth::user()->created_at->format('Y-m-d') }}</span>
                    </div>
                    <div class="stat-item">
                        <span>Total Books Borrowed:</span>
                        <span>{{ $totalBooksBorrowed }}</span>
                    </div>
                    <div class="stat-item">
                        <span>Books Currently Borrowed:</span>
                        <span>{{ $currentlyBorrowed }}</span>
                    </div>
                    <div class="stat-item">
                        <span>Overdue Books:</span>
                        <span>{{ $overdueBooks }}</span>
                    </div>
                    <div class="stat-item">
                        <span>Fines Due:</span>
                        <span>${{ number_format($finesDue, 2) }}</span>
                    </div>
                </div>
                <div class="button-group">
                    <a href="{{ route('profile.edit') }}" class="edit-profile">Edit Profile</a>
                    <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                        @csrf
                        <button type="submit" class="logout">Logout</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const menuButton = document.querySelector('.menu-button');
            const navigation = document.querySelector('.navigation');
            const profilePage = document.querySelector('.profile-page');

            menuButton.addEventListener('click', function() {
                navigation.classList.toggle('active');
                profilePage.classList.toggle('nav-active');
            });
        });
    </script>
</body>
</html>