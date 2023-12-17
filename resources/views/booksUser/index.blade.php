<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.15/dist/tailwind.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <title>Book Library</title>
    <style>
    body {
        font-family: 'Poppins', sans-serif;
        background-color: #111827;
        color: #fff; /* Цвет текста */
    }

    .container {
        max-width: 800px;
        margin: 0 auto;
    }

    .table {
        width: 100%;
        margin-bottom: 1rem;
        color: #ccc; /* Цвет текста в таблице */
    }

    .table th,
    .table td {
        padding: 1rem;
        text-align: left;
        border-bottom: 1px solid #444; /* Цвет границ в таблице */
    }

    .table th {
        background-color: #007bff;
        color: #fff; /* Цвет текста заголовка таблицы */
    }

    .modal-content {
        border: none;
        border-radius: 0.5rem;
        background-color: #1f2937; /* Цвет фона модального окна */
        color: #ccc; /* Цвет текста в модальном окне */
    }

    .modal-header {
        background-color: #007bff;
        color: #fff; /* Цвет текста заголовка модального окна */
        border-bottom: none;
    }

    .modal-footer {
        border-top: none;
    }

    .btn-primary {
        background-color: #007bff;
        border-color: #007bff;
    }

    .btn-primary:hover {
        background-color: #0056b3;
        border-color: #0056b3;
    }

    .btn-secondary {
        background-color: #6c757d;
        border-color: #6c757d;
    }

    .btn-secondary:hover {
        background-color: #545b62;
        border-color: #4e555b;
    }

    .btn-disabled {
        background-color: #444;
        border-color: #444;
        cursor: not-allowed;
    }

    .btn-disabled:hover {
        background-color: #444;
        border-color: #444;
    }
</style>

</head>

<body class="bg-gray-900 text-white">
    <x-app-layout>
        <section class="container mx-auto p-6">
            <form action="{{ route('books.index') }}" method="GET" class="mb-4">
                <div class="flex items-center">
                    <label for="title" class="mr-2 text-gray-300">Search by Title:</label>
                    <input type="text" name="title" id="title" class="p-2 border rounded-md bg-gray-800 text-gray-300"
                        value="{{ request('title') }}">
                    <button type="submit"
                        class="bg-blue-500 text-gray-300 transition p-2 rounded-md hover:bg-blue-600 hover:text-white ml-2">Search</button>
                </div>
            </form>
            <table class="bg-gray-800 shadow-md rounded-md">
                <thead class="bg-gray-600">
                    <tr>
                        <th class="px-4 py-2 text-gray-300">Title</th>
                        <th class="px-4 py-2 text-gray-300">Author</th>
                        <th class="px-4 py-2 text-gray-300">Genre</th>
                        <th class="px-4 py-2 text-gray-300">Date of Publication</th>
                        <th class="px-4 py-2 text-gray-300">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($books as $book)
                    <tr class="hover:bg-gray-700 transition rounded-lg">
                        <td class="px-4 py-2 text-gray-300">{{ $book->title }}</td>
                        <td class="px-4 py-2 text-gray-300">{{ $book->author }}</td>
                        <td class="px-4 py-2 text-gray-300">{{ $book->genre }}</td>
                        <td class="px-4 py-2 text-gray-300">{{ $book->dateOfPublication }}</td>
                        <td class="px-4 py-2 flex gap-4 items-center">
                            <a href="{{ route('books.show', $book) }}"
                                class="text-blue-500 hover:underline">View book</a>
                            <a href="#"
                                class="{{ $book->duration > 0 ? 'bg-gray-400 cursor-not-allowed p-2 rounded-lg' : 'bg-blue-500 text-white p-2 rounded-lg hover:bg-blue-600' }}"
                                data-toggle="modal" data-target="#bookModal_{{ $book->id }}"
                                data-book-id="{{ $book->id }}" data-title="{{ $book->title }}">
                                {{ isset($book->duration) ? '' : 'Get the book' }}
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center text-gray-300">No books found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </section>
    </x-app-layout>
</body>



    <!-- Modals for each book -->
        @foreach($books as $book)
    <div class="modal fade" id="bookModal_{{ $book->id }}" tabindex="-1" role="dialog"
        aria-labelledby="bookModalLabel_{{ $book->id }}" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content bg-gray-900 text-white">
                <div class="modal-header bg-gray-800">
                    <h5 class="modal-title" id="bookModalLabel_{{ $book->id }}">Book Details</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('books.save-duration', ['book' => $book->id]) }}" method="POST">
                        @csrf
                        <label for="duration" class="block mb-2 text-gray-300">Select Duration (1-7 days):</label>
                        <input type="range" name="duration" min="1" max="7" value="1"
                            class="form-control-range duration appearance-none w-full bg-gray-500 h-1 rounded-md"
                            oninput="updateDuration(this)">
                        <span class="selectedDuration block mb-4 text-gray-300">1 day</span>
                        <input type="hidden" name="bookId" value="{{ $book->id }}">
                        <!-- Other details or fields related to the book can be added here -->
                        <form action="/checkout" method="POST">
                        <input type="hiden" name="_token" value="{{csrf_token()}}">

                        <div class="modal-footer border-t border-gray-700">
                            <button type="button" class="btn btn-secondary text-black" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary text-black">Save Duration</button>
                            <button type="submit">Pay</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @endforeach


    <!-- JavaScript to update the selected duration text and show countdown timer -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        $(document).ready(function () {
            $('.saveDurationBtn').on('click', function () {
                var selectedValue = $(this).closest('.modal-content').find('.duration').val();
                var bookId = $(this).closest('.modal-content').find('.bookId').val();

                jQuery.ajax({
                    type: 'POST',
                    url: '{{ route("books.save-duration", ["book" => ":bookId"]) }}'.replace(':bookId', bookId),
                    data: {
                        _token: '{{ csrf_token() }}',
                        duration: selectedValue,
                    },
                    success: function (response) {
                        alert(response.message);

                        // Calculate the end time based on the selected duration
                        var now = new Date();
                        var endTime = new Date(now.getTime() + selectedValue * 24 * 60 * 60 * 1000);

                        // Start the countdown timer
                        startCountdownTimer(endTime);

                        $(this).closest('.modal').modal('hide');
                    },
                    error: function (error) {
                        console.error('Error saving duration:', error);
                    },
                });
            });

            // Update selected duration text based on the range input value
            $('.duration').on('input', function () {
                var selectedValue = $(this).val();
                var durationText = selectedValue == 1 ? 'day' : 'days';
                $(this).closest('.modal-content').find('.selectedDuration').text(selectedValue + ' ' + durationText);
            });

            function updateDuration(input) {
                // Get the selected value from the range input
                var selectedValue = input.value;

                // Update the span element with the selected duration
                $(input).closest('.modal-content').find('.selectedDuration').text(selectedValue + (selectedValue == 1 ? ' day' : ' days'));
            }

            function startCountdownTimer(endTime) {
                // Update the timer every second
                var timerInterval = setInterval(function () {
                    var now = new Date();
                    var timeLeft = endTime - now;

                    // Check if the duration has expired
                    if (timeLeft <= 0) {
                        clearInterval(timerInterval);
                        $('.selectedDuration').text('Duration expired');
                    } else {
                        // Format the time left as HH:MM:SS
                        var hours = Math.floor(timeLeft / (60 * 60 * 1000));
                        var minutes = Math.floor((timeLeft % (60 * 60 * 1000)) / (60 * 1000));
                        var seconds = Math.floor((timeLeft % (60 * 1000)) / 1000);

                        // Display the formatted time
                        $('.selectedDuration').text(hours + 'h ' + minutes + 'm ' + seconds + 's');
                    }
                }, 1000);
            }
        });
    </script>
</body>

</html>
