<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Add Supplier - Grand Archives</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #121246;
            color: #121246;
            margin: 0;
            padding: 20px;
        }
        .header {
            background: #ded9c3;
            padding: 20px;
            text-align: center;
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 20px;
        }
        .form-container {
            background: #ded9c3;
            padding: 20px;
            border-radius: 8px;
            max-width: 400px;
            margin: 0 auto;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
        }
        .form-group input {
            width: 100%;
            padding: 8px;
            border: 1px solid #b5835a;
            border-radius: 4px;
        }
        .button {
            background: #b5835a;
            padding: 10px 20px;
            border: none;
            cursor: pointer;
            color: #fff;
            border-radius: 4px;
            width: 100%;
        }
        .message {
            text-align: center;
            padding: 10px;
            margin-bottom: 20px;
        }
        .message.success {
            background: #6aa933;
            color: #fff;
        }
        .message.error {
            background: #ff3333;
            color: #fff;
        }
        .back-link {
            display: block;
            text-align: center;
            margin-top: 15px;
            color: #6aa933;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div class="header">Add Supplier</div>

    @if(session('success'))
        <div class="message success">{{ session('success') }}</div>
    @endif
    @if($errors->any())
        <div class="message error">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="form-container">
        <form action="{{ route('admin.suppliers.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="name">Supplier Name:</label>
                <input type="text" id="name" name="name" value="{{ old('name') }}" required />
            </div>
            <div class="form-group">
                <label for="address">Address:</label>
                <input type="text" id="address" name="address" value="{{ old('address') }}" />
            </div>
            <div class="form-group">
                <label for="contact_number">Contact Number:</label>
                <input type="text" id="contact_number" name="contact_number" value="{{ old('contact_number') }}" />
            </div>
            <button type="submit" class="button">Add Supplier</button>
        </form>
        <a href="{{ route('admin.index') }}" class="back-link">Back to Admin Dashboard</a>
    </div>
</body>
</html>
