<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.15/dist/tailwind.min.css">
    <title>Book Details</title>
</head>
<body class="bg-gray-800 text-gray-200">

    <x-app-layout>
        <div class="flex justify-center items-center h-screen">
            <div class="bg-gray-900 p-8 rounded shadow-md w-full md:w-2/3 lg:w-1/2 border border-gray-700">
                <h1 class="text-4xl font-bold mb-6 text-center border-b-2 border-gray-700 pb-2">{{ $book->title }}</h1>
                <div class="grid grid-cols-2 gap-4">
                    <div class="text-gray-400 border-b border-gray-700 pb-2">Author:</div>
                    <div class="text-gray-200 border-b border-gray-700 pb-2">{{ $book->author }}</div>
                    <div class="text-gray-400 border-b border-gray-700 pb-2">Genre:</div>
                    <div class="text-gray-200 border-b border-gray-700 pb-2">{{ $book->genre }}</div>
                    <div class="text-gray-400 border-b border-gray-700 pb-2">Date Of Publication:</div>
                    <div class="text-gray-200 border-b border-gray-700 pb-2">{{ $book->dateOfPublication }}</div>
                </div>
                <div class="flex items-center mt-4">
                    <span class="text-gray-400">Available:</span>
                    <span class="ml-2 {{ $book->isAvailable ? 'text-green-400' : 'text-red-400' }}">
                        {{ $book->isAvailable ? 'Yes' : 'No' }}
                    </span>
                </div>
                @if(isset($book->duration))
                    <div class="flex items-center">
                        <span class="text-gray-400">Duration:</span>
                        <span class="ml-2 text-gray-200">{{ $book->duration }} {{ $book->duration == 1 ? 'day' : 'days' }}</span>
                    </div>
                @else
                    <p class="text-gray-400">Duration: Not Set</p>
                @endif
                <!-- Кнопка редактирования книги -->
                <div class="mt-8">
                    <a href="{{ route('books.edit', $book) }}" class="text-blue-400 hover:underline">Edit</a>
                </div>
            </div>
        </div>
    </x-app-layout>

</body>
</html>
