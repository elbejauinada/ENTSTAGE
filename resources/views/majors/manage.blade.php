<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Majors and Subjects</title>
    <!-- Include Tailwind CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@^2.0/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
<header class="bg-white">
    <nav class="flex justify-between items-center p-6 mx-auto relative">
    <div>
           <a href="{{ route('admin.admin_dashboard') }}" ><img class="w-40" src="{{ URL('images/logo-ensa.png')}}" alt="ENSA Logo"></a>
        </div>
        <div id="nav-links" class="nav-links fixed top-0 left-0 w-full h-full bg-white hidden flex-col justify-center items-center z-10 md:relative md:flex md:flex-row md:items-center md:gap-[4vw] md:bg-transparent md:h-auto md:w-auto">
            <ul class="flex flex-col md:flex-row md:items-center md:gap-[4vw] gap-8">
                <li>
                    <a class="hover:text-gray-500" href="{{ route('results.select') }}">Ajouter les résultats</a>
                </li>
                <li>
                    <a class="hover:text-gray-500" href="{{ route('results.select') }}">Gestion des étudiants</a>
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
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">Manage Majors and Subjects</h1>

    <!-- Success Message -->
    @if(session('success'))
        <div class="bg-green-500 text-white p-4 mb-4 rounded">
            {{ session('success') }}
        </div>
    @endif

    <!-- Add Major Form -->
    <div class="bg-white p-4 mb-4 rounded shadow">
        <h2 class="text-xl font-semibold mb-2">Add New Major</h2>
        <form action="{{ route('majors.store') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label for="major_name" class="block text-gray-700">Major Name</label>
                <input type="text" id="major_name" name="name" class="border rounded p-2 w-full" required>
            </div>
            <button type="submit" class="bg-blue-500 text-white py-2 px-4 rounded">Add Major</button>
        </form>
    </div>

    <!-- Add Subject Form -->
    <div class="bg-white p-4 mb-4 rounded shadow">
        <h2 class="text-xl font-semibold mb-2">Add New Subject</h2>
        <form action="{{ route('subjects.store') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label for="subject_name" class="block text-gray-700">Subject Name</label>
                <input type="text" id="subject_name" name="name" class="border rounded p-2 w-full" required>
            </div>
            <div class="mb-4">
                <label for="major_id" class="block text-gray-700">Select Major</label>
                <select id="major_id" name="major_id" class="border rounded p-2 w-full" required>
                    <option value="">Choose...</option>
                    @foreach($majors as $major)
                        <option value="{{ $major->id }}">{{ $major->name }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="bg-blue-500 text-white py-2 px-4 rounded">Add Subject</button>
        </form>
    </div>

    <!-- List of Majors and Edit/Delete Options -->
    <div class="bg-white p-4 rounded shadow">
        <h2 class="text-xl font-semibold mb-2">Majors</h2>
        <table class="min-w-full bg-white border border-gray-200">
            <thead>
                <tr>
                    <th class="py-2 px-4 border-b">Name</th>
                    <th class="py-2 px-4 border-b">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($majors as $major)
                <tr>
                    <td class="py-2 px-4 border-b">{{ $major->name }}</td>
                    <td class="py-2 px-4 border-b">
                        <!-- Edit Major Form -->
                        <form action="{{ route('majors.update', $major->id) }}" method="POST" class="inline-block">
                            @csrf
                            @method('PUT')
                            <input type="text" name="name" value="{{ $major->name }}" class="border rounded p-1" required>
                            <button type="submit" class="bg-yellow-500 text-white py-1 px-2 rounded">Edit</button>
                        </form>
                        <!-- Delete Major Form -->
                        <form action="{{ route('majors.destroy', $major->id) }}" method="POST" class="inline-block ml-2">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-500 text-white py-1 px-2 rounded">Delete</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- List of Subjects and Edit/Delete Options -->
    <div class="bg-white p-4 rounded shadow mt-4">
        <h2 class="text-xl font-semibold mb-2">Subjects</h2>
        <table class="min-w-full bg-white border border-gray-200">
            <thead>
                <tr>
                    <th class="py-2 px-4 border-b">Name</th>
                    <th class="py-2 px-4 border-b">Major</th>
                    <th class="py-2 px-4 border-b">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($subjects as $subject)
                <tr>
                    <td class="py-2 px-4 border-b">{{ $subject->name }}</td>
                    <td class="py-2 px-4 border-b">{{ $subject->major->name }}</td>
                    <td class="py-2 px-4 border-b">
                        <!-- Edit Subject Form -->
                        <form action="{{ route('subjects.update', $subject->id) }}" method="POST" class="inline-block">
                            @csrf
                            @method('PUT')
                            <input type="text" name="name" value="{{ $subject->name }}" class="border rounded p-1" required>
                            <select name="major_id" class="border rounded p-1 ml-2" required>
                                @foreach($majors as $major)
                                    <option value="{{ $major->id }}" {{ $subject->major_id == $major->id ? 'selected' : '' }}>{{ $major->name }}</option>
                                @endforeach
                            </select>
                            <button type="submit" class="bg-yellow-500 text-white py-1 px-2 rounded ml-2">Edit</button>
                        </form>
                        <!-- Delete Subject Form -->
                        <form action="{{ route('subjects.destroy', $subject->id) }}" method="POST" class="inline-block ml-2">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-500 text-white py-1 px-2 rounded">Delete</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

</body>
</html>
