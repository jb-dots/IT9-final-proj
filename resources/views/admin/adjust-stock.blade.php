<!-- resources/views/admin/adjust-stock.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adjust Stock - Grand Archives</title>
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
            max-width: 500px;
            margin: 0 auto;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
        }
        .form-group input, .form-group select {
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
    </style>
</head>
<body>
    <div class="header">Adjust Stock for {{ $book->title }}</div>

    @if(session('success'))
        <div class="message success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="message error">{{ session('error') }}</div>
    @endif

    <div class="form-container">
        <form action="{{ route('admin.updateStock', $book) }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="quantity_change">Quantity to Adjust:</label>
                <input type="number" name="quantity_change" id="quantity_change" value="1" min="1" required>
            </div>
            <div class="form-group">
                <label for="action">Action:</label>
                <select name="action" id="action" required>
                    <option value="stock_in">Stock In (Add Copies)</option>
                    <option value="stock_out">Stock Out (Remove Copies)</option>
                </select>
            </div>
            <button type="submit" class="button">Update Stock</button>
        </form>
    </div>
</body>
</html>