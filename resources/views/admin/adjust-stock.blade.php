<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
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
            margin: 0 auto 40px auto;
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
        .history-section {
            max-width: 900px;
            margin: 0 auto 40px auto;
            background: #ded9c3;
            padding: 20px;
            border-radius: 8px;
        }
        .history-section h2 {
            text-align: center;
            margin-bottom: 15px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #b5835a;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #b5835a;
            color: white;
        }
    </style>
</head>
<body>
    <div class="header">Adjust Stock for {{ $book->title }}</div>

    <div style="text-align: center; margin-bottom: 20px;">
        <a href="{{ route('admin.index') }}" class="button" style="background: #6aa933; padding: 10px 20px; color: white; border-radius: 4px; text-decoration: none;">Back to Dashboard</a>
    </div>

    @if(session('success'))
        <div class="message success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="message error">{{ session('error') }}</div>
    @endif

    <div class="form-container">
        <h2>Stock In (Add Copies)</h2>
        <form action="{{ route('admin.stockIn', $book) }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="supplier_id">Supplier:</label>
                <select name="supplier_id" id="supplier_id" required>
                    <option value="">Select Supplier</option>
                    @foreach($suppliers as $supplier)
                        <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="quantity_in">Quantity:</label>
                <input type="number" name="quantity" id="quantity_in" value="1" min="1" required />
            </div>
            <button type="submit" class="button">Add Stock</button>
        </form>
    </div>

    <div class="form-container">
        <h2>Stock Out (Remove Copies)</h2>
        <form action="{{ route('admin.stockOut', $book) }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="quantity_out">Quantity:</label>
                <input type="number" name="quantity" id="quantity_out" value="1" min="1" required />
            </div>
            <button type="submit" class="button">Remove Stock</button>
        </form>
    </div>

    <div class="history-section">
        <h2>Stock In History</h2>
        @if($stockIns->isEmpty())
            <p>No stock in history available.</p>
        @else
            <table>
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Supplier</th>
                        <th>Quantity</th>
                        <th>Performed By</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($stockIns as $stockIn)
                        <tr>
                            <td>{{ $stockIn->created_at->format('Y-m-d H:i') }}</td>
                            <td>{{ $stockIn->supplier->name ?? 'N/A' }}</td>
                            <td>{{ $stockIn->quantity }}</td>
                            <td>{{ $stockIn->performed_by }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>

    <div class="history-section">
        <h2>Stock Out History</h2>
        @if($stockOuts->isEmpty())
            <p>No stock out history available.</p>
        @else
            <table>
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Quantity</th>
                        <th>Performed By</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($stockOuts as $stockOut)
                        <tr>
                            <td>{{ $stockOut->created_at->format('Y-m-d H:i') }}</td>
                            <td>{{ $stockOut->quantity }}</td>
                            <td>{{ $stockOut->performed_by }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
</body>
</html>
