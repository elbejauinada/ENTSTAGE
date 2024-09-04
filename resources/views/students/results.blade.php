<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Results</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@3.0.0/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 font-sans">

<header class="bg-blue-900 text-white p-4">
    <div class="container mx-auto flex justify-between items-center">
        <a href="{{ route('dashboard') }}" class="text-xl font-bold">Dashboard</a>
        <a href="{{ route('students.results') }}" class="text-lg">My Results</a>
    </div>
</header>

<main class="py-8">
    <div class="container mx-auto px-4">
        <h1 class="text-3xl font-bold mb-6">My Results</h1>

        @if($results->isEmpty())
            <p class="text-gray-600">You have no results yet.</p>
        @else
            <table class="min-w-full bg-white border border-gray-300">
                <thead>
                    <tr class="border-b">
                        <th class="py-2 px-4">Subject</th>
                        <th class="py-2 px-4">Grade</th>
                        <th class="py-2 px-4">Date</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($results as $result)
                        <tr>
                            <td class="py-2 px-4">{{ $result->subject->name }}</td>
                            <td class="py-2 px-4">{{ $result->grade }}</td>
                            <td class="py-2 px-4">{{ $result->created_at->format('F j, Y') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
</main>

</body>
</html>
