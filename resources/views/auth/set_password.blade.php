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
<header class="bg-white">
    <nav class="flex justify-between items-center p-6 mx-auto relative">
        <div>
            <img class="w-40" src="{{ URL('images/logo-ensa.png')}}" alt="ENSA Logo">
        </div>
        <div id="nav-links" class="nav-links fixed top-0 left-0 w-full h-full bg-white hidden flex-col justify-center items-center z-10 md:relative md:flex md:flex-row md:items-center md:gap-[4vw] md:bg-transparent md:h-auto md:w-auto">
            <ul class="flex flex-col md:flex-row md:items-center md:gap-[4vw] gap-8">
                <li>
                    <a class="hover:text-gray-500" href="">Home</a>
                </li>
                <li>
                    <a class="hover:text-gray-500" href="#">ENSATe</a>
                </li>
                <li>
                    <a class="hover:text-gray-500" href="#">Contact us</a>
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
<section class="min-h-screen border-4 border-gray-900 flex box-border justify-center items-center">
    <div class="bg-[#dfa674] border-4 border-gray-900 rounded-2xl flex flex-col md:flex-row max-w-3xl p-8 items-center shadow-lg">
        <div class="md:w-1/2 px-8">
            <h2 class="font-bold text-3xl text-[#002D74]">Set Your Password</h2>
            <p class="text-sm mt-4 text-[#002D74]">Create a new password to activate your account.</p>

            <form method="POST" action="{{ route('activate.set_password', ['token' => request()->route('token')]) }}" class="flex flex-col gap-4 mt-6">
                @csrf

                <div>
                    <label for="password" class="block font-medium text-sm text-gray-700">{{ __('Password') }}</label>
                    <input id="password" class="p-2 mt-2 rounded-xl border w-full" type="password" name="password" required autofocus placeholder="New Password" />
                    @error('password')
                        <span class="text-red-600 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label for="password_confirmation" class="block font-medium text-sm text-gray-700">{{ __('Confirm Password') }}</label>
                    <input id="password_confirmation" class="p-2 mt-2 rounded-xl border w-full" type="password" name="password_confirmation" required placeholder="Confirm Password" />
                </div>

                <div class="flex items-center justify-end mt-4">
                    <button class="bg-blue-500 text-white py-2 px-4 rounded-xl hover:scale-105 duration-300 hover:bg-blue-600 font-medium" type="submit">
                        {{ __('Set Password') }}
                    </button>
                </div>
            </form>
        </div>

        <div class="md:w-1/2 hidden md:block">
            <img class="rounded-2xl max-h-[1600px]" src="https://images.unsplash.com/photo-1552010099-5dc86fcfaa38?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w0NzEyNjZ8MHwxfHNlYXJjaHwxfHxmcmVzaHxlbnwwfDF8fHwxNzEyMTU4MDk0fDA&ixlib=rb-4.0.3&q=80&w=1080" alt="password form image">
        </div>
    </div>
</section>


        </div>
    </div>
