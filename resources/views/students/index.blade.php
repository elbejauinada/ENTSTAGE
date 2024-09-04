<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <title>Manage Students</title>
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
        <h1 class="text-2xl font-bold mb-4">Manage Students</h1>

        <!-- Button to Add a New Student -->
        <a href="{{ route('students.create') }}" class="bg-green-500 text-white px-4 py-2 rounded mb-6 inline-block">Add Student</a>

        <!-- Form to Select Major -->
        <form action="{{ route('students.index') }}" method="GET" class="mb-6">
            <div class="mb-4">
                <label for="major" class="block text-gray-700">Select Major:</label>
                <select name="major_id" id="major" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                    <option value="">Choose a Major</option>
                    @foreach($majors as $major)
                        <option value="{{ $major->id }}" {{ request('major_id') == $major->id ? 'selected' : '' }}>{{ $major->name }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">List Students</button>
        </form>

        <!-- Display Students if a Major is Selected -->
        @if(request('major_id'))
            @if(!empty($students))
                <div class="mt-6">
                    <h2 class="text-xl font-bold mb-4">
                        Students in {{ optional($majors->firstWhere('id', request('major_id')))->name ?? 'Unknown Major' }}
                    </h2>

                    <table class="min-w-full bg-white border border-gray-200">
                        <thead>
                            <tr>
                                <th class="py-2 px-4 border-b">Name</th>
                                <th class="py-2 px-4 border-b">Email</th>
                                <th class="py-2 px-4 border-b">Birthday</th>
                                <th class="py-2 px-4 border-b">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($students as $student)
                                <tr>
                                    <td class="py-2 px-4 border-b">{{ $student->name }}</td>
                                    <td class="py-2 px-4 border-b">{{ $student->email }}</td>
                                    <td class="py-2 px-4 border-b">{{ $student->birthday }}</td>
                                    <td class="py-2 px-4 border-b">
                                        <a href="{{ route('students.edit', $student->id) }}" class="bg-yellow-500 text-white px-4 py-1 rounded">Edit</a>
                                        <form action="{{ route('students.destroy', $student->id) }}" method="POST" class="inline-block">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="bg-red-500 text-white px-4 py-1 rounded">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p class="mt-6">No students found for the selected major.</p>
            @endif
        @endif
    </div>
</body>
</html>
