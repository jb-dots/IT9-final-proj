<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile - Grand Archives</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200&display=swap" />
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <style>
        /* Reuse styles from profile.blade.php */
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

        .profile-page {
            flex: 1;
            background: #f0f0e4;
            min-height: 100vh;
            padding-left: 0px;
            transition: padding-left 0.3s ease-in-out;
            overflow-y: auto;
        }

        .profile-page.nav-active {
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

        .profile-content {
            background: #baba82;
            border-radius: 12px;
            width: 100%;
            max-width: 1203px;
            margin: 100px auto 40px;
            padding: 40px;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 20px;
        }

        .form-group {
            width: 100%;
            max-width: 600px;
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .form-group label {
            color: #121246;
            font-family: "Inter-Regular", sans-serif;
            font-size: 18px;
            font-weight: 600;
        }

        .form-group input,
        .form-group textarea {
            width: 100%;
            padding: 10px;
            border-radius: 8px;
            border: 1px solid #b5835a;
            font-family: "Inter-Regular", sans-serif;
            font-size: 16px;
            color: #121246;
            background: #fff;
        }

        .form-group textarea {
            resize: vertical;
            min-height: 100px;
        }

        .form-group img.profile-picture {
            border-radius: 85.5px;
            width: 171px;
            height: 171px;
            object-fit: cover;
            margin: 0 auto;
            display: block;
        }

        .button-group {
            display: flex;
            gap: 20px;
            margin-top: 20px;
        }

        .save-button,
        .cancel-button {
            padding: 10px 20px;
            border-radius: 8px;
            color: #ffffff;
            font-family: "Inter-Regular", sans-serif;
            font-size: 16px;
            font-weight: 400;
            text-align: center;
            cursor: pointer;
            transition: background 0.2s ease;
            border: none;
        }

        .save-button {
            background: #6aa933;
        }

        .save-button:hover {
            background: #5a8b2a;
        }

        .cancel-button {
            background: #c22d2d;
        }

        .cancel-button:hover {
            background: #a82525;
        }

        .error-message {
            color: #c22d2d;
            font-size: 14px;
            margin-top: 5px;
        }

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

            .form-group img.profile-picture {
                width: 120px;
                height: 120px;
                border-radius: 60px;
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

            .form-group img.profile-picture {
                width: 100px;
                height: 100px;
                border-radius: 50px;
            }

            .button-group {
                flex-direction: column;
                gap: 10px;
            }
        }
        .images-1-1 {
            border-radius: 85.5px;
            width: 171px;
            height: 171px;
            object-fit: cover;
            z-index: 5;
            position: relative;
            display: block; /* Ensure it’s visible */
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
            <div class="profile">EDIT PROFILE</div>
            <div class="profile-content">
                <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PATCH')

                    <!-- Profile Picture -->
                    <div class="form-group">
                        <label for="profile_picture">Profile Picture</label>
                        <img src="{{ Auth::user()->profile_picture ? asset('storage/' . Auth::user()->profile_picture) : asset('images/logo1.png') }}" alt="Profile Picture" class="images-1-1" style="display: block; margin: 0 auto;"/>
                        <input type="file" name="profile_picture" id="profile_picture" accept="image/*">
                        @error('profile_picture')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Name -->
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" name="name" id="name" value="{{ old('name', Auth::user()->name) }}" required>
                        @error('name')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" name="email" id="email" value="{{ old('email', Auth::user()->email) }}" required>
                        @error('email')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Contact Number -->
                    <div class="form-group">
                        <label for="contact_no">Contact Number</label>
                        <input type="text" name="contact_no" id="contact_no" value="{{ old('contact_no', Auth::user()->contact_no) }}">
                        @error('contact_no')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Address -->
                    <div class="form-group">
                        <label for="address">Address</label>
                        <textarea name="address" id="address">{{ old('address', Auth::user()->address) }}</textarea>
                        @error('address')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Buttons -->
                    <div class="button-group">
                        <button type="submit" class="save-button">Save Changes</button>
                        <a href="{{ route('user.profile') }}" class="cancel-button">Cancel</a>
                    </div>
                </form>
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
