<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Admin - Manage Books</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <a href="{{ route('admin.books.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded">Add Book</a>
                    <table class="min-w-full mt-4">
                        <thead>
                            <tr>
                                <th class="px-4 py-2">Title</th>
                                <th class="px-4 py-2">Author</th>
                                <th class="px-4 py-2">Genre</th>
                                <th class="px-4 py-2">Cover</th>
                                <th class="px-4 py-2">Status</th>
                                <th class="px-4 py-2">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($books as $book)
                                <tr>
                                    <td class="border px-4 py-2">{{ $book->title }}</td>
                                    <td class="border px-4 py-2">{{ $book->author ?? 'N/A' }}</td>
                                    <td class="border px-4 py-2">{{ $book->genre->name ?? 'Unknown' }}</td>
                                    <td class="border px-4 py-2"><img src="{{ asset('storage/' . $book->cover_image) }}" alt="Cover" class="h-16 w-16 object-cover"></td>
                                    <td class="border px-4 py-2">{{ $book->is_borrowed ? 'Borrowed' : 'Available' }}</td>
                                    <td class="border px-4 py-2">
                                        <a href="{{ route('admin.books.edit', $book) }}" class="text-blue-500">Edit</a>
                                        <form action="{{ route('admin.books.toggle', $book) }}" method="POST" class="inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="text-green-500">{{ $book->is_borrowed ? 'Mark Available' : 'Mark Borrowed' }}</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>