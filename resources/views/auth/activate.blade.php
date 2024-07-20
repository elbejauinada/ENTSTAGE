<!DOCTYPE html>
<html>
<head>
    <title>Activate Account</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
    <div class="min-h-screen flex flex-col items-center pt-6 sm:pt-0">
        <div>
            <a href="/">
            </a>
        </div>
        <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
            <form method="POST" action="{{ route('activate.email') }}">
                @csrf

                <div>
                    <label for="email" class="block font-medium text-sm text-gray-700">{{ __('Email') }}</label>
                    <input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />
                    @error('email')
                        <span class="text-red-600 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div class="flex items-center justify-end mt-4">
                    <button class="ml-4 btn btn-primary">
                        {{ __('Send Activation Email') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
