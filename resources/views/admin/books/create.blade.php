<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Add New Book</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <form method="POST" action="{{ route('admin.books.store') }}" enctype="multipart/form-data" class="bg-white p-6 rounded-lg shadow-sm">
                @csrf
                <div class="mb-4">
                    <label for="title" class="block text-gray-700">Title</label>
                    <input type="text" name="title" id="title" class="w-full border-gray-300 rounded-md" required>
                </div>
                <div class="mb-4">
                    <label for="author" class="block text-gray-700">Author</label>
                    <input type="text" name="author" id="author" class="w-full border-gray-300 rounded-md" required>
                </div>
                <div class="mb-4">
                    <label for="cover_image" class="block text-gray-700">Cover Image</label>
                    <input type="file" name="cover_image" id="cover_image" class="w-full" required>
                </div>
                <div class="mb-4">
                    <label for="genre_id" class="block text-gray-700">Genre</label>
                    <select name="genre_id" id="genre_id" class="w-full border-gray-300 rounded-md" required>
                        @foreach ($genres as $genre)
                            <option value="{{ $genre->id }}">{{ $genre->name }}</option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Save</button>
            </form>
        </div>
    </div>
</x-app-layout>