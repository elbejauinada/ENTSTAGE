<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100">
    <header class="bg-blue-900 text-white p-4">
        <h1 class="text-xl">Admin Dashboard</h1>
        <a href="{{ route('logout') }}" class="text-white hover:text-gray-300">Logout</a>
    </header>

    <main class="p-6">
        @if(session('success'))
            <div class="bg-green-500 text-white p-3 rounded">
                {{ session('success') }}
            </div>
        @endif

        <h2 class="text-2xl font-bold mb-4">Add Student Result</h2>
        <form method="POST" action="{{ route('admin.add.result') }}">
            @csrf
            <div class="mb-4">
                <label for="student_id" class="block text-sm font-medium text-gray-700">Student ID</label>
                <input id="student_id" name="student_id" type="text" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
            </div>
            <div class="mb-4">
                <label for="subject" class="block text-sm font-medium text-gray-700">Subject</label>
                <input id="subject" name="subject" type="text" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
            </div>
            <div class="mb-4">
                <label for="score" class="block text-sm font-medium text-gray-700">Score</label>
                <input id="score" name="score" type="number" min="0" max="100" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
            </div>
            <button type="submit" class="bg-blue-500 text-white py-2 px-4 rounded">Add Result</button>
        </form>

        <h2 class="text-2xl font-bold mt-8 mb-4">Student Results</h2>
        <table class="min-w-full bg-white border border-gray-200">
            <thead>
                <tr>
                    <th class="border px-4 py-2">Student ID</th>
                    <th class="border px-4 py-2">Subject</th>
                    <th class="border px-4 py-2">Score</th>
                </tr>
            </thead>
            <tbody>
                @foreach($results as $result)
                    <tr>
                        <td class="border px-4 py-2">{{ $result->student_id }}</td>
                        <td class="border px-4 py-2">{{ $result->subject }}</td>
                        <td class="border px-4 py-2">{{ $result->score }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </main>
</body>
</html>
