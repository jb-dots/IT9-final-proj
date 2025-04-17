<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Genre - Grand Archives</title>
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
            background: #121246;
            color: #fff;
        }

        .form-container {
            max-width: 600px;
            margin: 40px auto;
            padding: 20px;
            background: #1a1a4d;
            border-radius: 8px;
        }

        .form-container h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #d4a373;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
            color: #d4a373;
        }

        .form-group input {
            width: 100%;
            padding: 8px;
            border-radius: 4px;
            border: none;
            background: #d9d9d9;
            color: #121246;
        }

        .submit-btn {
            display: block;
            width: 100%;
            padding: 10px;
            background: #d4a373;
            color: #121246;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-weight: 500;
        }

        .submit-btn:hover {
            background: #b5835a;
        }

        .back-btn {
            display: inline-block;
            margin-bottom: 20px;
            padding: 8px 16px;
            background: #d4a373;
            color: #121246;
            border-radius: 4px;
            text-decoration: none;
        }

        .back-btn:hover {
            background: #b5835a;
        }

        .error {
            color: #ff6b6b;
            font-size: 14px;
            margin-top: 5px;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <a href="{{ route('admin.index') }}" class="back-btn">Back to Dashboard</a>
        <h2>Edit Genre</h2>
        <form action="{{ route('admin.genres.update', $genre) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="name">Genre Name</label>
                <input type="text" name="name" id="name" value="{{ old('name', $genre->name) }}">
                @error('name')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>
            <button type="submit" class="submit-btn">Update Genre</button>
        </form>
    </div>
</body>
</html>