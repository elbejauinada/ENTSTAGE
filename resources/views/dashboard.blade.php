<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@48,400,0,0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    @vite('resources/css/app.css')
    <title>ENT ENSA Tétouan</title>
</head>
<body class="bg-blue-900 font-sans">
<header class="bg-white">
    <nav class="flex justify-between items-center p-6 mx-auto relative">
        <div>
            <a href="{{ route('dashboard') }}"><img class="w-40" src="{{ URL('images/logo-ensa.png') }}" alt="ENSA Logo"></a>
        </div>
        <div id="nav-links" class="nav-links fixed top-0 left-0 w-full h-full bg-white hidden flex-col justify-center items-center z-10 md:relative md:flex md:flex-row md:items-center md:gap-[4vw] md:bg-transparent md:h-auto md:w-auto">
            <ul class="flex flex-col md:flex-row md:items-center md:gap-[4vw] gap-8">
                <li>
                    <a href="{{ route('profile.show') }}" class="hover:text-gray-500 {{ request()->routeIs('profile.show') ? 'text-gray-500' : '' }}">
                        {{ __('Profile') }}
                    </a>
                </li>
                <li>
                    <a class="hover:text-gray-500" href="{{ route('students.results') }}" >Mes resultats</a>
                </li>
                <li>
                    <a class="hover:text-gray-500" href="#">Contact us</a>
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
<footer class="bg-blue-900 text-white py-12">
    <div class="max-w-7xl mx-auto px-4">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="mb-8">
                <img src="{{ asset('images/logo-ensa-white.png') }}" alt="ENSA Logo" class="h-16 mb-4">
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