<!-- resources/views/components/book-entry.blade.php -->
<div class="book-entry" style="background: #d9d9d9; border-radius: 12px; padding: 15px; margin-bottom: 15px; display: flex; justify-content: space-between; align-items: center;">
    <div class="book-info" style="color: #121246; font-family: 'Inter-Regular', sans-serif; font-size: 16px;">
        <div class="book-name">Book name: {{ $book->book->title }}</div>
        <div class="due-date">Due Date: {{ $book->due_date->format('Y-m-d') }}</div>
        @if($book->returned_at)
            <div class="returned-date">Returned On: {{ $book->returned_at->format('Y-m-d') }}</div>
        @endif
        @if($book->late_fee > 0 && !$book->returned_at)
            <div class="late-fee">Late Fee: ${{ number_format($book->late_fee, 2) }}</div>
        @endif
    </div>
    <div style="display: flex; align-items: center; gap: 10px;">
        <div class="status {{ $book->returned_at ? 'returned' : ($book->due_date < now() && !$book->returned_at ? 'due' : 'borrowed') }}"
             style="padding: 5px 15px; border-radius: 12px; color: #fff; font-size: 14px; text-align: center; {{ $book->returned_at ? 'background: #6aa933;' : ($book->due_date < now() && !$book->returned_at ? 'background: #c22d2d;' : 'background: #3498db;') }}">
            {{ $book->returned_at ? 'Returned' : ($book->due_date < now() && !$book->returned_at ? 'Due' : 'Borrowed') }}
        </div>
        @if($book->status == 'borrowed' && !$book->returned_at)
            <form action="{{ route('books.return', $book->id) }}" method="POST">
                @csrf
                <button type="submit" class="return-button">Return</button>
            </form>
        @endif
    </div>
</div>

<style>
    @media (max-width: 480px) {
        .book-entry {
            flex-direction: column;
            align-items: flex-start;
            gap: 10px;
        }
        .book-info {
            font-size: 14px;
        }
        .status, .return-button {
            font-size: 12px;
            padding: 5px 10px;
        }
    }
</style>