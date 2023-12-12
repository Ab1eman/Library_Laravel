<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.15/dist/tailwind.min.css">
    <title>Create a Book</title>
</head>
<body class="bg-gray-900 text-white">
    <div class="flex items-center justify-center h-screen">
        <div class="max-w-md w-full">
            <h1 class="text-3xl font-bold mb-4 text-center">Create a Book</h1>
            <form action="{{ route('books.store') }}" method="post" class="bg-gray-800 p-4 shadow-md rounded-md">
                @csrf
                <div class="mb-4">
                    <label for="title" class="text-gray-300 block">Title</label>
                    <input type="text" name="title" required class="w-full p-2 border rounded-md bg-gray-700 text-white">
                </div>
                <div class="mb-4">
                    <label for="author" class="text-gray-300 block">Author</label>
                    <input type="text" name="author" required class="w-full p-2 border rounded-md bg-gray-700 text-white">
                </div>
                <div class="mb-4">
                    <label for="genre" class="text-gray-300 block">Genre</label>
                    <input type="text" name="genre" required class="w-full p-2 border rounded-md bg-gray-700 text-white">
                </div>
                <div class="mb-4">
                    <label for="dateOfPublication" class="text-gray-300 block">Date Of Publication</label>
                    <input type="date" name="dateOfPublication" required class="w-full p-2 border rounded-md bg-gray-700 text-white">
                </div>
                <div class="mb-4">
                    <label for="isAvailable" class="text-gray-300 block">Is Available</label>
                    <input type="checkbox" name="isAvailable" checked class="p-2 rounded-md bg-gray-700 text-white">
                </div>
                <button type="submit" class="bg-blue-500 p-2 rounded-md hover:bg-blue-600 w-full">Create</button>
            </form>
        </div>
    </div>
</body>
</html>
