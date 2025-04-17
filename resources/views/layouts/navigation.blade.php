<!-- resources/views/layouts/navigation.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Navigation - Grand Archives</title>

    <style>
        /* Reset styles */
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        /* Base navigation styles */
        .component-1 {
            width: 250px;
            height: 100vh; /* Ensure it takes full viewport height */
            background: #ded9c3;
            position: relative;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 20px 0;
        }

        .rectangle-3 {
            position: absolute;
            inset: 0;
            background: #ded9c3;
            z-index: 1;
        }

        /* Logo styling */
        .logo-1-removebg-preview-1 {
            width: 200px;
            height: 200px;
            object-fit: contain;
            margin-bottom: 20px;
            z-index: 2;
        }

        /* Title styling */
        .grand-archives {
            color: #121246;
            text-align: center;
            font-family: "JacquesFrancoisShadow-Regular", sans-serif;
            font-size: 36px;
            font-weight: 400;
            margin-bottom: 40px;
            z-index: 2;
        }

        /* Navigation items */
        .nav-item {
            width: 100%;
            height: 65px;
            position: relative;
            z-index: 2;
        }

        .nav-link {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 100%;
            height: 100%;
            color: #121246;
            font-family: "Inter-Regular", sans-serif;
            font-size: 20px;
            font-weight: 400;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .nav-link:hover {
            background-color: rgba(181, 131, 90, 0.2);
            color: #121246;
            transform: translateX(5px); /* Subtle movement on hover */
        }

        /* Active link styling */
        .nav-link.active {
            background-color: #b5835a;
            color: #121246;
        }

        /* Responsive adjustments */
        @media (max-height: 832px) {
            .component-1 {
                height: 100vh;
            }
            
            .logo-1-removebg-preview-1 {
                width: 150px;
                height: 150px;
            }
            
            .grand-archives {
                font-size: 28px;
                margin-bottom: 20px;
            }
            
            .nav-link {
                font-size: 18px;
                height: 50px;
            }
        }
    </style>
</head>
<body>
    <div class="component-1">
        <div class="rectangle-3"></div>
        <img src="{{ asset('images/logo1.png') }}" alt="Logo" class="logo-1-removebg-preview-1"/>
        <div class="grand-archives">GRAND ARCHIVES</div>
        <div class="nav-item">
            <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">Home</a>
        </div>
        <div class="nav-item">
            <a href="{{ route('catalogs') }}" class="nav-link {{ request()->routeIs('catalogs') ? 'active' : '' }}">Catalogs</a>
        </div>
        <div class="nav-item">
            <a href="{{ route('transaction') }}" class="nav-link {{ request()->routeIs('transaction') ? 'active' : '' }}">Borrowed Books</a>
        </div>
        <div class="nav-item">
            <a href="{{ route('favorites') }}" class="nav-link {{ request()->routeIs('favorites') ? 'active' : '' }}">Favorites</a>
        </div>
        <div class="nav-item">
            <a href="{{ route('user.profile') }}" class="nav-link {{ request()->routeIs('user.profile') ? 'active' : '' }}">Profile</a>
        </div>
    </div>
</body>
</html>