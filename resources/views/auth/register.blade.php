<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up - Grand Archives</title>
    <style>
        /* Reset and base styles */
        *, a, button, input, select, h1, h2, h3, h4, h5 {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            border: none;
            text-decoration: none;
            background: none;
            -webkit-font-smoothing: antialiased;
        }

        menu, ol, ul {
            list-style-type: none;
            margin: 0;
            padding: 0;
        }

        /* Sign-up page styles */
        .sign-up-page {
            background: #f0f0e4;
            min-height: 100vh;
            position: relative;
            overflow-x: hidden;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .frame-rectangle-3 {
            width: 430px;
            padding: 40px 20px; /* Added padding for internal spacing */
            position: relative;
            margin: 120px auto 20px; /* Adjusted for better flow */
            border: 2px solid #b5835a;
            border-radius: 12px;
            background: #ded9c3;
        }
        .form-group {
            width: 304px;
            margin: 0 auto 25px; /* Increased spacing */
            position: relative;
        }
        .textbox {
            background: #d9d9d9;
            width: 100%;
            height: 43px;
            padding: 10px;
            font-family: "Inter-Regular", sans-serif;
            font-size: 16px;
            color: #121246;
            border-radius: 8px;
            display: block;
            outline: none; 
        }
        .textbox:focus {
            border: 2px solid #b5835a;
        }
        .form-group label {
            color: #121246;
            font-family: "Inter-Regular", sans-serif;
            font-size: 14px;
            font-weight: 400;
            position: absolute;
            left: 10px;
            top: -20px;
        }
        .component-2 {
            width: 160px;
            height: 49px;
            position: relative;
            margin: 20px auto 0;
        }
        .rectangle-62 {
            background: #b5835a;
            border-radius: 10px;
            width: 100%;
            height: 100%;
            position: absolute;
            transition: background 0.2s ease;
        }
        .create-btn {
            color: #121246;
            text-align: center;
            font-family: "Inter-Regular", sans-serif;
            font-size: 24px;
            font-weight: 400;
            width: 100%;
            height: 100%;
            position: relative; /* Changed from absolute for better layering */
            cursor: pointer;
            z-index: 1; /* Ensure button text is above rectangle */
        }
        .component-2:hover .rectangle-62 {
            background: rgba(181, 131, 90, 0.8); /* Hover effect on rectangle */
        }
        .login-signup {
            color: #121246;
            text-align: center;
            font-family: "Inter-Regular", sans-serif;
            font-size: 32px;
            font-weight: 600;
            margin: 20px 0; /* Static positioning */
        }
        .frame-rectangle-2 {
            width: 100%;
            height: 107px;
            position: absolute;
            top: 0;
            left: 0;
            border-bottom: 2px solid #b5835a;
            background: #ded9c3;
        }
        .grand-archives2 {
            color: #121246;
            text-align: left;
            font-family: "JacquesFrancoisShadow-Regular", sans-serif;
            font-size: 40px;
            font-weight: 400;
            position: absolute;
            left: 82px;
            top: 28px;
        }
        .login-link-container {
            width: 100px;
            height: 30px;
            margin: 20px auto; /* Static positioning */
        }
        .login-link {
            color: #121246;
            text-align: center;
            font-family: "Inter-Regular", sans-serif;
            font-size: 16px;
            font-weight: 400;
            width: 100%;
            height: 100%;
            display: block;
            cursor: pointer;
        }
        .login-link:hover {
            text-decoration: underline;
        }
        .error-message {
            color: #c22d2d;
            font-family: "Inter-Regular", sans-serif;
            font-size: 14px;
            position: absolute;
            left: 10px;
            bottom: -20px;
            width: 100%; /* Ensure it wraps properly */
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .frame-rectangle-3 {
                width: 90%;
                padding: 30px 15px;
            }
            .form-group {
                width: 100%;
            }
            .grand-archives2 {
                font-size: 32px;
                left: 20px;
            }
            .logo-1-removebg-preview-3 {
                max-width: 300px;
                bottom: 10px;
            }
        }

        @media (max-width: 480px) {
            .frame-rectangle-3 {
                width: 95%;
                padding: 20px 10px;
            }
            .form-group {
                width: 90%;
                margin-bottom: 30px; /* Extra space for errors */
            }
            .login-signup {
                font-size: 24px;
            }
            .create-btn {
                font-size: 20px;
            }
            .grand-archives2 {
                font-size: 24px;
                left: 10px;
            }
            .logo-1-removebg-preview-3 {
                max-width: 200px;
            }
        }
        .logo {
            position: absolute;
            left: 640px;
            top: 125px;
            width: 60px;
            height: auto;
            z-index: 3; /* Ensure it’s above other elements */
        }
    </style>
</head>
<body>
    <div class="sign-up-page">
        <div class="frame-rectangle-2"></div>
        <div class="grand-archives2">GRAND ARCHIVES</div>
        <div class="frame-rectangle-3">
            <div class="login-signup">SIGNUP</div>
            <form method="POST" action="{{ route('register') }}">
                @csrf
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" name="name" id="name" class="textbox" placeholder="Name" value="{{ old('name') }}" required>
                    @error('name')
                        <span revived-class="error-message">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" name="email" id="email" class="textbox" placeholder="Email" value="{{ old('email') }}" required>
                    @error('email')
                        <span revived-class="error-message">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password" class="textbox" placeholder="Password" required>
                    @error('password')
                        <span revived-class="error-message">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="password_confirmation">Confirm Password</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" class="textbox" placeholder="Confirm Password" required>
                    @error('password_confirmation')
                        <span revived-class="error-message">{{ $message }}</span>
                    @enderror
                </div>
                <div class="component-2">
                    <div class="rectangle-62"></div>
                    <button type="submit" class="create-btn">CREATE</button>
                </div>
            </form>
            <div class="login-link-container">
                <a href="{{ route('login') }}" class="login-link">Already have a Account?</a>
            </div>
        </div>
    </div>
</body>
</html>