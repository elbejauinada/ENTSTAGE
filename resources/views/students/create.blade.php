<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un Étudiant</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 p-6">
    <div class="max-w-4xl mx-auto bg-white p-8 rounded-lg shadow-lg">
        <h1 class="text-2xl font-bold mb-4">Ajouter un Étudiant</h1>

        <form action="{{ route('students.store') }}" method="POST">
            @csrf

            <div class="mb-4">
                <label for="name" class="block text-gray-700">Nom</label>
                <input type="text" id="name" name="name" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
            </div>

            <div class="mb-4">
                <label for="email" class="block text-gray-700">Email</label>
                <input type="email" id="email" name="email" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
            </div>

            <div class="mb-4">
    <label for="major_id" class="block text-gray-700">Filière</label>
    <select id="major_id" name="major_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
        <option value="">Sélectionner une filière</option>
        @foreach($majors as $major)
            <option value="{{ $major->id }}">{{ $major->name }}</option>
        @endforeach
    </select>
</div>

<div class="mb-4">
    <label for="anniversary" class="block text-gray-700">Date d'anniversaire</label>
    <input type="date" id="anniversary" name="anniversary" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
</div>
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md shadow hover:bg-blue-600">Ajouter</button>
        </form>
    </div>
</body>
</html>
