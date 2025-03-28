<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up - Grand Archives</title>

    <style>
        /* Reset and base styles */
        a, button, input, select, h1, h2, h3, h4, h5, * {
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
        .sign-up-page,
        .sign-up-page * {
            box-sizing: border-box;
        }
        .sign-up-page {
            background: #121246;
            height: 1024px;
            position: relative;
            overflow: hidden;
        }
        .frame-rectangle-3 {
            width: 430px;
            height: 572px;
            position: absolute;
            left: 810px;
            top: 297px;
            border: 2px solid #b5835a;
            border-radius: var(--corner-medium, 0px);
            background: rgba(255, 255, 255, 0.1);
            overflow: visible;
        }
        .textbox {
            background: #d9d9d9;
            width: 304px;
            height: 43px;
            position: absolute;
            padding: 10px;
            font-family: "Inter-Regular", sans-serif;
            font-size: 16px;
            color: #121246;
        }
        .name-textbox {
            left: 881px;
            top: 444px;
        }
        .email-textbox {
            left: 881px;
            top: 512px;
        }
        .password-textbox {
            left: 881px;
            top: 580px;
        }
        .password-confirm-textbox {
            left: 881px;
            top: 648px;
        }
        .component-2 {
            width: 160px;
            height: 49px;
            position: absolute;
            left: 953px;
            top: 751px;
        }
        .rectangle-62 {
            background: #b5835a;
            border-radius: 10px;
            width: 100%;
            height: 100%;
            position: absolute;
            right: 0%;
            left: 0%;
            bottom: 0%;
            top: 0%;
        }
        .create-btn {
            color: #121246;
            text-align: center;
            font-family: "Inter-Regular", sans-serif;
            font-size: 24px;
            font-weight: 400;
            position: absolute;
            right: 7.52%;
            left: 7.8%;
            width: 84.68%;
            bottom: 20.27%;
            top: 20.27%;
            height: 59.46%;
            background: transparent;
            cursor: pointer;
        }
        .frame {
            width: 15.79%;
            height: 47.06%;
            position: absolute;
            right: 78.29%;
            left: 5.92%;
            bottom: 27.45%;
            top: 25.49%;
            overflow: visible;
        }
        .login-signup {
            color: #121246;
            text-align: center;
            font-family: "Inter-Regular", sans-serif;
            font-size: 32px;
            font-weight: 400;
            position: absolute;
            left: 881px;
            top: 348px;
            width: 304px;
            height: 47px;
        }
        .grand-archives {
            color: #341c1c;
            text-align: left;
            font-family: "Inter-Regular", sans-serif;
            font-size: 40px;
            font-weight: 400;
            position: absolute;
            left: 160px;
            top: 28px;
            width: 455px;
            height: 49px;
        }
        .frame2 {
            width: 24px;
            height: 24px;
            position: absolute;
            left: 887px;
            top: 526px;
            overflow: visible;
        }
        .frame3 {
            width: 24px;
            height: 24px;
            position: absolute;
            left: 886px;
            top: 453px;
            overflow: visible;
        }
        .frame-rectangle-2 {
            width: 1441px;
            height: 107px;
            position: absolute;
            left: 0px;
            top: -6px;
            border: 2px solid #b5835a;
            background: rgba(255, 255, 255, 0.1);
            overflow: visible;
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
            width: 455px;
            height: 49px;
        }
        .logo-1-removebg-preview-3 {
            width: 706px;
            height: 706px;
            position: absolute;
            left: 35px;
            top: 180px;
            object-fit: cover;
            aspect-ratio: 1;
        }
        .login-link-container {
            width: 100px; /* Adjusted to fit "Log In" text */
            height: 30px;
            position: absolute;
            left: 983px; /* Centered below CREATE button */
            top: 820px; /* Below the CREATE button */
        }
        .login-link {
            color: #121246; /* Matches the button color for visibility */
            text-align: center;
            font-family: "Inter-Regular", sans-serif;
            font-size: 16px;
            font-weight: 400;
            position: absolute;
            right: 0%;
            left: 0%;
            width: 100%;
            bottom: 0%;
            top: 0%;
            height: 100%;
            cursor: pointer;
        }
        .login-link:hover {
            text-decoration: underline; /* Hover effect to indicate interactivity */
        }
    </style>
</head>
<body>
    <div class="sign-up-page">
        <div class="frame-rectangle-3"></div>
        <form method="POST" action="{{ route('register') }}">
            @csrf
            <input type="text" name="name" class="textbox name-textbox" placeholder="Name" required>
            <input type="email" name="email" class="textbox email-textbox" placeholder="Email" required>
            <input type="password" name="password" class="textbox password-textbox" placeholder="Password" required>
            <input type="password" name="password_confirmation" class="textbox password-confirm-textbox" placeholder="Confirm Password" required>
            <div class="component-2">
                <div class="rectangle-62"></div>
                <button type="submit" class="create-btn">CREATE</button>
            </div>
        </form>
        <div class="login-signup">SIGNUP</div>
        <div class="login-link-container">
            <a href="{{ route('login') }}" class="login-link">Log In</a>
        </div>
        <div class="frame-rectangle-2"></div>
        <div class="grand-archives2">GRAND ARCHIVES</div>
        <img class="logo-1-removebg-preview-3" src="{{ asset('images/logo-1-removebg-preview-30.png') }}" alt="Logo 3" />
    </div>
</body>
</html>