<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adjust Stock - Grand Archives</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #121246;
            color: #121246;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
        }
        .header {
            background: #ded9c3;
            padding: 20px;
            text-align: center;
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 20px;
            border-radius: 8px;
        }
        .card {
            background: #ded9c3;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 20px;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
            color: #121246;
        }
        .form-group input, .form-group select {
            width: 100%;
            padding: 8px;
            border: 1px solid #b5835a;
            border-radius: 4px;
            box-sizing: border-box;
        }
        .button, .cancel-button {
            padding: 10px 20px;
            border: none;
            cursor: pointer;
            color: #fff;
            border-radius: 4px;
            text-align: center;
            display: inline-block;
        }
        .button {
            background: #b5835a;
        }
        .button:hover {
            background: #a3724e;
        }
        .cancel-button {
            background: #666;
        }
        .cancel-button:hover {
            background: #555;
        }
        .message {
            text-align: center;
            padding: 10px;
            margin-bottom: 20px;
            border-radius: 4px;
        }
        .message.success {
            background: #6aa933;
            color: #fff;
        }
        .message.error {
            background: #ff3333;
            color: #fff;
        }
        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        .table th, .table td {
            border: 1px solid #b5835a;
            padding: 8px;
            text-align: left;
            vertical-align: middle;
        }
        .table th {
            background: #b5835a;
            color: #fff;
        }
        .table tbody tr:nth-child(even) {
            background: #f5f0e1;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">Adjust Stock for {{ $book->title }}</div>

        <!-- Success/Error Messages -->
        @if (session('success'))
            <div class="message success">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="message error">{{ session('error') }}</div>
        @endif

        <!-- Current Stock -->
        <div class="card">
            <h2 class="text-2xl font-semibold mb-4">Current Stock</h2>
            <p class="text-gray-600">Current Quantity: {{ $book->quantity }}</p>
        </div>

        <!-- Adjust Stock Form -->
        <div class="card">
            <h2 class="text-2xl font-semibold mb-4">Adjust Stock</h2>
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
                <div class="form-group" id="supplier-group" style="display:none;">
                    <label for="supplier_id">Supplier:</label>
                    <select name="supplier_id" id="supplier_id">
                        <option value="">Select Supplier</option>
                        @foreach($suppliers as $supplier)
                            <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="button">Update Stock</button>
                <a href="{{ route('admin.index') }}" class="cancel-button">Cancel</a>
            </form>
            <script>
                document.getElementById('action').addEventListener('change', function() {
                    var supplierGroup = document.getElementById('supplier-group');
                    if (this.value === 'stock_in') {
                        supplierGroup.style.display = 'block';
                        document.getElementById('supplier_id').setAttribute('required', 'required');
                    } else {
                        supplierGroup.style.display = 'none';
                        document.getElementById('supplier_id').removeAttribute('required');
                    }
                });
                // Trigger change event on page load to set initial state
                document.getElementById('action').dispatchEvent(new Event('change'));
            </script>
        </div>

        <!-- Stock History -->
        <div class="card">
            <h2 class="text-2xl font-semibold mb-4">Stock History</h2>
            @if ($stockHistories->isEmpty())
                <p class="text-gray-600">No stock history available for this book.</p>
            @else
                <table class="table">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Action</th>
                            <th>Quantity Change</th>
                            <th>Performed By</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($stockHistories as $history)
                            <tr>
                                <td>{{ $history->created_at->format('Y-m-d H:i:s') }}</td>
                                <td>{{ ucfirst(str_replace('_', ' ', $history->action)) }}</td>
                                <td>{{ $history->quantity_change > 0 ? '+' : '' }}{{ $history->quantity_change }}</td>
                                <td>{{ $history->performed_by }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>
</body>
</html>