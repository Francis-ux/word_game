<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Admin - Manage Words</title>
        <script src="https://cdn.tailwindcss.com"></script>
    </head>

    <body class="bg-gray-100 p-6">
        <div class="max-w-2xl mx-auto bg-white p-6 rounded-lg shadow-lg">
            <h1 class="text-2xl font-bold mb-4">Manage Words</h1>
            @if (session('success'))
                <div class="bg-green-100 text-green-700 p-2 mb-4 rounded">{{ session('success') }}</div>
            @endif
            <form action="{{ route('admin.words.store') }}" method="POST" class="mb-6">
                @csrf
                <input type="text" name="word" class="border p-2 w-full mb-2" placeholder="Add new word" required>
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Add Word</button>
            </form>
            <h2 class="text-xl font-bold mb-2">Word List</h2>
            <ul class="list-disc pl-5">
                @foreach ($words as $word)
                    <li class="flex justify-between items-center mb-2">
                        {{ $word->word }}
                        <form action="{{ route('admin.words.destroy', $word->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-500">Delete</button>
                        </form>
                    </li>
                @endforeach
            </ul>
        </div>
    </body>

</html>
