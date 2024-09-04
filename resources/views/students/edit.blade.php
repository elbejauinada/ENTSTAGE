<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <title>Edit Student</title>
</head>
<body class="bg-gray-100">
<header class="bg-white">
    <nav class="flex justify-between items-center p-6 mx-auto relative">
        <div>
            <img class="w-40" src="{{ URL('images/logo-ensa.png')}}" alt="ENSA Logo">
        </div>
        <div id="nav-links" class="nav-links fixed top-0 left-0 w-full h-full bg-white hidden flex-col justify-center items-center z-10 md:relative md:flex md:flex-row md:items-center md:gap-[4vw] md:bg-transparent md:h-auto md:w-auto">
            <ul class="flex flex-col md:flex-row md:items-center md:gap-[4vw] gap-8">
                <li>
                    <a class="hover:text-gray-500" href="{{ route('results.select') }}">Ajouter les résultats</a>
                </li>
                <li>
                    <a class="hover:text-gray-500" href="{{ route('students.index') }}">Gestion des étudiants</a>
                </li>
                <li>
                    <a class="hover:text-gray-500" href="{{ route('majors.manage') }}">Gestion des modules</a>
                </li>
            </ul>
            <ion-icon id="close-icon" name="close" class="text-3xl cursor-pointer absolute top-4 right-4 md:hidden hidden"></ion-icon>
        </div>
        <div class="flex items-center gap-6">
            <ion-icon id="menu-icon" onclick="onToggleMenu()" name="menu" class="text-3xl cursor-pointer md:hidden"></ion-icon>
        </div>
    </nav>
</header>

<script>
    function onToggleMenu() {
        const navLinks = document.getElementById('nav-links');
        const menuIcon = document.getElementById('menu-icon');
        const closeIcon = document.getElementById('close-icon');

        if (menuIcon.name === 'menu') {
            menuIcon.name = 'close';
            navLinks.classList.remove('hidden');
            navLinks.classList.add('flex');
            closeIcon.classList.remove('hidden');
        } else {
            menuIcon.name = 'menu';
            navLinks.classList.add('hidden');
            navLinks.classList.remove('flex');
            closeIcon.classList.add('hidden');
        }
    }

    document.getElementById('close-icon').addEventListener('click', onToggleMenu);
</script>

    <div class="container mx-auto p-8">
        <h1 class="text-2xl font-bold mb-4">Edit Student</h1>

        <!-- Edit Student Form -->
        <form action="{{ route('students.update', $student->id) }}" method="POST" class="bg-white p-6 rounded shadow-md">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label for="name" class="block text-gray-700">Name:</label>
                <input type="text" name="name" id="name" value="{{ old('name', $student->name) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
            </div>

            <div class="mb-4">
                <label for="email" class="block text-gray-700">Email:</label>
                <input type="email" name="email" id="email" value="{{ old('email', $student->email) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
            </div>

            <div class="mb-4">
                <label for="birthday" class="block text-gray-700">Birthday:</label>
                <input type="date" name="birthday" id="birthday" value="{{ old('birthday', $student->birthday) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
            </div>

            <div class="mb-4">
                <label for="major_id" class="block text-gray-700">Major:</label>
                <select name="major_id" id="major_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                    @foreach($majors as $major)
                        <option value="{{ $major->id }}" {{ $student->major_id == $major->id ? 'selected' : '' }}>{{ $major->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="flex justify-end">
                <a href="{{ route('students.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded mr-4">Cancel</a>
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Update</button>
            </div>
        </form>
    </div>
</body>
</html>
