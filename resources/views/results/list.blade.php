<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Résultats des Étudiants</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
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
            </ul>
            <ion-icon id="close-icon" name="close" class="text-3xl cursor-pointer absolute top-4 right-4 md:hidden hidden"></ion-icon>
        </div>
        <div class="flex items-center gap-6">
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
<body class="bg-gray-100 p-6">
    <div class="max-w-4xl mx-auto bg-white p-8 rounded-lg shadow-lg">
        <h1 class="text-2xl font-bold mb-4">Résultats des Étudiants - {{ $major->name }} - {{ $subject->name }}</h1>

        @if(session('success'))
            <div class="bg-green-200 text-green-800 p-4 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="bg-red-200 text-red-800 p-4 rounded mb-4">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('results.storeOrUpdate') }}" method="POST">
            @csrf

            <input type="hidden" name="subject_id" value="{{ $subject->id }}">

            <table class="min-w-full bg-white">
                <thead>
                    <tr>
                        <th class="py-2">Étudiant</th>
                        <th class="py-2">Note</th>
                        <th class="py-2">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                        <tr>
                            <td class="border px-4 py-2">{{ $user->name }}</td>
                            <td class="border px-4 py-2">
                                <input type="number" name="grades[{{ $user->id }}]" value="{{ $results->firstWhere('user_id', $user->id)->grade ?? '' }}" min="0" max="20" step="0.01" class="w-full border-gray-300 rounded-md shadow-sm">
                            </td>
                            <td class="border px-4 py-2">
                                <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded-md shadow hover:bg-green-600">Mettre à jour</button>
                                @if ($result = $results->firstWhere('user_id', $user->id))
                                    <form action="{{ route('results.destroy', $result->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded-md shadow hover:bg-red-600">Supprimer</button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </form>
    </div>
</body>
</html>


