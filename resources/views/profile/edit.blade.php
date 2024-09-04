<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@48,400,0,0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@3.0.0/dist/tailwind.min.css" rel="stylesheet">
    <title>ENT ENSA Tétouan</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-blue-900 font-sans">

<header class="bg-white">
    <nav class="flex justify-between items-center p-6 mx-auto relative">
        <div>
            <a href="{{ route('dashboard') }}"><img class="w-40" src="{{ URL('images/logo-ensa.png') }}" alt="ENSA Logo">
        </div>
        <div id="nav-links" class="nav-links fixed top-0 left-0 w-full h-full bg-white hidden flex-col justify-center items-center z-10 md:relative md:flex md:flex-row md:items-center md:gap-[4vw] md:bg-transparent md:h-auto md:w-auto">
            <ul class="flex flex-col md:flex-row md:items-center md:gap-[4vw] gap-8">
                <li>
                    <a href="{{ route('profile.edit') }}" class="hover:text-gray-500 {{ request()->routeIs('profile.edit') ? 'text-gray-500' : '' }}">
                        Profile
                    </a>
                </li>
                <li>
                    <a class="hover:text-gray-500">Mes resultats</a>
                </li>
                <li>
                    <a class="hover:text-gray-500" href="#">Contact us</a>
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

<main class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
        <!-- Profile Information Card -->
        <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
            <div class="max-w-xl mx-auto">
                <div class="text-center">
                    <h2 class="text-2xl font-bold mb-4">Profile Information</h2>
                </div>
                <div class="space-y-4">
                    <!-- User Photo -->
                    <div class="bg-gray-100 p-4 rounded-lg shadow-md text-center">
                        <img src="{{ $user->photo ? asset('storage/' . $user->photo) : 'https://via.placeholder.com/150' }}" alt="User Photo" class="w-32 h-32 rounded-full mx-auto mb-2 object-cover">
                    </div>

                    <!-- User Information -->
                    <div class="bg-gray-100 p-4 rounded-lg shadow-md">
                        <p class="text-lg font-semibold">Name</p>
                        <p class="text-gray-600">{{ $user->name }}</p>
                    </div>

                    <div class="bg-gray-100 p-4 rounded-lg shadow-md">
                        <p class="text-lg font-semibold">Email</p>
                        <p class="text-gray-600">{{ $user->email }}</p>
                    </div>

                    <div class="bg-gray-100 p-4 rounded-lg shadow-md">
                        <p class="text-lg font-semibold">Birthday</p>
                        <p class="text-gray-600">{{ $user->birthday ? $user->birthday : 'Not set' }}</p>
                    </div>

                    <div class="bg-gray-100 p-4 rounded-lg shadow-md">
                        <p class="text-lg font-semibold">Major</p>
                        <p class="text-gray-600">{{ $user->major ? $user->major->name : 'Not set' }}</p>

                    </div>
                </div>
            </div>
        </div>

        <!-- Update Password Form -->
        <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
            <div class="max-w-xl mx-auto">
                <form method="POST" action="/profile/update-password" class="space-y-6">
                    @csrf
                    @method('PATCH')

                    <div>
                        <label for="current_password" class="block text-sm font-medium text-gray-700">Current Password</label>
                        <input id="current_password" name="current_password" type="password" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        @error('current_password')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="new_password" class="block text-sm font-medium text-gray-700">New Password</label>
                        <input id="new_password" name="new_password" type="password" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        @error('new_password')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="new_password_confirmation" class="block text-sm font-medium text-gray-700">Confirm New Password</label>
                        <input id="new_password_confirmation" name="new_password_confirmation" type="password" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        @error('new_password_confirmation')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex items-center gap-4">
                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Update Password
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</main>
<footer class="bg-white text-blue-900 py-12">
    <div class="max-w-7xl mx-auto px-4">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="mb-8">
                <img src="{{ asset('images/logo-ensa.png') }}" alt="ENSA Logo" class="h-16 mb-4">
                <p class="text-lg leading-relaxed">Etudiant, enseignant ou personnel, vous pouvez accéder à tous vos services via cette plateforme. Il suffit d'activer votre compte en utilisant votre adresse institutionnelle, saisir un mot de passe.</p>
            </div>
            <div class="mb-8">
                <h3 class="text-lg font-semibold mb-4">Contact us</h3>
                <p>Avenue de la Palestine Mhanech I, TÉTOUAN</p>
                <p class="email">ensate@uae.ac.ma</p>
                <h4 class="text-lg mt-4">05396-88027</h4>
            </div>
            <div class="mb-8">
                <h3 class="text-lg font-semibold mb-4">Follow us</h3>
                <ul class="social-media flex space-x-4">
                    <li><a href="https://www.facebook.com/ensa.tetouan.officiel" class="social-icon"><i class="fa fa-facebook"></i></a></li>
                    <li><a href="https://www.instagram.com/ensa_tetouan_officiel/" class="social-icon"><i class="fa fa-instagram"></i></a></li>
                    <li><a href="https://www.linkedin.com/school/ensa-tetouan/" class="social-icon"><i class="fa fa-linkedin"></i></a></li>
                </ul>
            </div>
        </div>
    </div>
</footer>
</body>
</html>


