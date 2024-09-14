<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@3.0.0/dist/tailwind.min.css" rel="stylesheet">
    @vite('resources/css/app.css')
    <title>User Profile</title>
</head>
<body class="bg-gray-100 font-sans">
<header class="bg-white">
    <nav class="flex justify-between items-center p-6 mx-auto relative max-w-7xl">
        <div>
            <a href="{{ route('dashboard') }}">
                <img class="w-40" src="{{ URL('images/logo-ensa.png') }}" alt="ENSA Logo">
            </a>
        </div>
        <div id="nav-links" class="nav-links fixed top-0 left-0 w-full h-full bg-white hidden flex-col justify-center items-center z-10 md:relative md:flex md:flex-row md:items-center md:gap-[4vw] md:bg-transparent md:h-auto md:w-auto">
            <ul class="flex flex-col md:flex-row md:items-center md:gap-[4vw] gap-8">
                <li>
                    <a href="{{ route('profile.show') }}" class="hover:text-gray-500 {{ request()->routeIs('profile.show') ? 'text-gray-500' : '' }}">
                        {{ __('Profile') }}
                    </a>
                </li>
                <li>
                    <a class="hover:text-gray-500" href="{{ route('students.results') }}">Mes resultats</a>
                </li>
                <li>
                    <a class="hover:text-gray-500" href="#">Contact Us</a>
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

<main class="py-12">
    <div class="max-w-3xl mx-auto">
        <!-- Profile Information Section -->
        <div class="bg-white p-6 border  rounded-lg shadow-lg mb-8">
            <h1 class="text-3xl font-bold mb-6 text-center">Profile Information</h1>
            

            <div class="mb-4 text-center">
                <h2 class="text-xl font-semibold mb-2">Name</h2>
                <p class="text-gray-700">{{ $user->name }}</p>
            </div>

            <div class="mb-4 text-center">
                <h2 class="text-xl font-semibold mb-2">Email</h2>
                <p class="text-gray-700">{{ $user->email }}</p>
            </div>

            <div class="mb-4 text-center">
                <h2 class="text-xl font-semibold mb-2">Birthday</h2>
                <p class="text-gray-700">{{ $user->birthday ? $user->birthday : 'Not set' }}</p>
            </div>

            <div class="mb-4 text-center">
                <h2 class="text-xl font-semibold mb-2">Major</h2>
                @if($user->major_id)
                    <p class="text-gray-700">{{ $majors->firstWhere('id', $user->major_id)->name ?? 'Not set' }}</p>
                @else
                    <p class="text-gray-700">Not set</p>
                @endif
            </div>
        </div>

        <!-- Password Update Section -->
        <div  class="max-w-3xl mx-auto">
         <div class="bg-white p-6 border  rounded-lg shadow-lg mb-8">
            <h2 class="text-2xl font-bold mb-6 text-center">Update Password</h2>

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

                <div class="flex items-center justify-center gap-4">
                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Update Password
                    </button>
                </div>
            </form>
            </div>
        </div>
    </div>
</main>

<footer class="bg-blue-900 text-white py-12">
    <div class="max-w-6xl mx-auto px-4">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="mb-8 text-center">
                <img src="{{ asset('images/logo-ensa-white.png') }}" alt="ENSA Logo" class="h-16 mb-4 mx-auto">
                <p class="text-lg leading-relaxed">Etudiant, enseignant ou personnel, vous pouvez accéder à tous vos services via cette plateforme. Il suffit d'activer votre compte en utilisant votre adresse institutionnelle, saisir un mot de passe.</p>
            </div>
            <div class="mb-8 text-center">
                <h3 class="text-lg font-semibold mb-4">Contact Us</h3>
                <p>Avenue de la Palestine Mhanech I, TÉTOUAN</p>
                <p class="email">ensate@uae.ac.ma</p>
                <h4 class="text-lg mt-4">05396-88027</h4>
            </div>
            <div class="mb-8 text-center">
                <h3 class="text-lg font-semibold mb-4">Follow Us</h3>
                <ul class="social-media flex justify-center space-x-4">
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
