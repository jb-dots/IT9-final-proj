<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Grand Archives</title>

    <style>
        /* Reset and base styles (unchanged) */
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

        /* Login page styles */
        .log-in-page,
        .log-in-page * {
            box-sizing: border-box;
        }
        .log-in-page {
            background: #f0f0e4;
            height: 1024px;
            position: relative;
            overflow: hidden;
        }
        .frame-rectangle-3 {
            width: 430px;
            height: 470px;
            position: absolute;
            left: 818px;
            top: 298px;
            border: 2px solid #b5835a;
            border-radius: var(--corner-medium, 0px);
            background: #ded9c3;
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
        .email-textbox {
            left: 881px;
            top: 444px;
        }
        .password-textbox {
            left: 881px;
            top: 517px;
        }
        .component-2 {
            width: 160px;
            height: 49px;
            position: absolute;
            left: 960px;
            top: 625px;
        }
        .rectangle-6 {
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
        .log-in-btn {
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
        .create-account {
            width: 219px;
            height: 30px;
            position: absolute;
            left: 930px;
            top: 738px;
        }
        .create-account2 {
            color: hsl(240, 59%, 17%);
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
        }
        .frame-rectangle-2 {
            width: 1441px;
            height: 107px;
            position: absolute;
            left: 0px;
            top: -6px;
            border: 2px solid #b5835a;  
            background: #ded9c3; 
            overflow: visible;
            z-index: 1;
        }
        .grand-archives2 {
            color: #121246;
            text-align: left;
            font-family: "JacquesFrancoisShadow-Regular", sans-serif;
            font-size: 40px;
            font-weight: 400;
            position: absolute;
            left: 62px;
            top: 18px;
            width: 455px;
            height: 49px;
            z-index: 2;
        }
        /* New styles for remember me checkbox */
        .remember-me-container {
            position: absolute;
            left: 881px;
            top: 570px;
            display: flex;
            align-items: center;
            width: 304px;
        }
        .remember-me-checkbox {
            width: 20px;
            height: 20px;
            margin-right: 10px;
            cursor: pointer;
        }
        .remember-me-label {
            color: #121246;
            font-family: "Inter-Regular", sans-serif;
            font-size: 16px;
            font-weight: 400;
        }
        /* New logo class */
        .logo {
            position: absolute;
            left: 150px;
            top: 315px;
            width: 450px;
            height: auto;
            z-index: 3; /* Ensure it’s above other elements */
        }
    </style>
</head>
<body>  
    <div class="log-in-page">
        <div class="frame-rectangle-3"></div>
        <img src="{{ asset('images/logo1.png') }}" alt="Logo" class="logo"/>
        <form method="POST" action="{{ route('login') }}">
            @csrf
            <input type="email" name="email" class="textbox email-textbox" placeholder="Email" required>
            <input type="password" name="password" class="textbox password-textbox" placeholder="Password" required>
            <div class="remember-me-container">
                <input type="checkbox" name="remember" id="remember" class="remember-me-checkbox">
                <label for="remember" class="remember-me-label">Remember me</label>
            </div>
            <div class="component-2">
                <div class="rectangle-6"></div>
                <button type="submit" class="log-in-btn">LOG-IN</button>
            </div>
        </form>
        <div class="login-signup">LOGIN - SIGNUP</div>
        <div class="create-account">
            <a href="{{ route('register') }}" class="create-account2">Don't Have a Account?</a>  
        </div>
        <div class="grand-archives2">GRAND ARCHIVES</div>
        <div class="frame-rectangle-2"></div> 
    </div>
</body>
</html>