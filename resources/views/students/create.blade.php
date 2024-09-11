<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <title>Add Student</title>
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
                    <a class="hover:text-gray-500" href="{{ route('students.index') }}">Gestion des étudiants</a>
                </li>
                <li>
                    <a class="hover:text-gray-500" href="{{ route('majors.manage') }}">Gestion des modules</a>
                </li>
            </ul>
            <ion-icon id="close-icon" name="close" class="text-3xl cursor-pointer absolute top-4 right-4 md:hidden hidden"></ion-icon>
        </div>
        <div class="flex items-center gap-6">
    <!-- Logout Button -->
    <form method="POST" action="{{ route('logout') }}" class="inline">
        @csrf
        <button type="submit" class="auth-btn bg-blue-900 text-white px-8 py-3 rounded-lg hover:bg-blue-800">
            Logout
        </button>
    </form>

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
        <h1 class="text-2xl font-bold mb-4">Add New Student</h1>

        <!-- Success Message -->
        @if(session('success'))
            <div class="bg-green-500 text-white p-4 rounded mb-4">{{ session('success') }}</div>
        @endif

        <!-- Form to Add New Student -->
        <form action="{{ route('students.store') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label for="name" class="block text-gray-700">Name:</label>
                <input type="text" id="name" name="name" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
            </div>

            <div class="mb-4">
                <label for="email" class="block text-gray-700">Email:</label>
                <input type="email" id="email" name="email" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
            </div>

            <div class="mb-4">
                <label for="birthday" class="block text-gray-700">Birthday:</label>
                <input type="date" id="birthday" name="birthday" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
            </div>

            <div class="mb-4">
                <label for="major_id" class="block text-gray-700">Select Major:</label>
                <select id="major_id" name="major_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                    <option value="">Choose a Major</option>
                    @foreach($majors as $major)
                        <option value="{{ $major->id }}">{{ $major->name }}</option>
                    @endforeach
                </select>
            </div>

            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Add Student</button>
        </form>

        <!-- Back to List Button -->
        <a href="{{ route('students.index') }}" class="block mt-6 bg-gray-500 text-white px-4 py-2 rounded">Back to List</a>
    </div>
</body>
</html>
