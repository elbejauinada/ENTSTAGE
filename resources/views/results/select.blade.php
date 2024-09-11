<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Select Major and Subject</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
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
<div class="max-w-4xl mx-auto my-4 bg-white p-8 rounded-lg shadow-lg">
    <h1 class="text-2xl font-bold mb-4">Select Major and Subject</h1>

    @if(session('success'))
        <div class="bg-green-200 text-green-800 p-4 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('results.select') }}" method="GET" class="mb-6">
        <div class="mb-4">
            <label for="major" class="block text-gray-700">Select Major:</label>
            <select name="major_id" id="major" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" onchange="this.form.submit()">
                <option value="">Choose a Major</option>
                @foreach($majors as $major)
                    <option value="{{ $major->id }}" {{ request('major_id') == $major->id ? 'selected' : '' }}>{{ $major->name }}</option>
                @endforeach
            </select>
        </div>

        @if(!empty($subjects))
            <div class="mb-4">
                <label for="subject" class="block text-gray-700">Select Subject:</label>
                <select name="subject_id" id="subject" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" onchange="this.form.submit()">
                    <option value="">Choose a Subject</option>
                    @foreach($subjects as $subject)
                        <option value="{{ $subject->id }}" {{ request('subject_id') == $subject->id ? 'selected' : '' }}>{{ $subject->name }}</option>
                    @endforeach
                </select>
            </div>
        @endif
    </form>

    @if(!empty($students))
        <h2 class="text-xl font-bold mb-4">Students List</h2>
        <div class="flex flex-col">
            <div class="-m-1.5 overflow-x-auto">
                <div class="p-1.5 min-w-full inline-block align-middle">
                    <div class="overflow-hidden">
                        <table class="min-w-full divide-y divide-gray-200 bg-white">
                            <thead class="bg-blue-200 text-white">
                                <tr>
                                    <th class="px-6 py-3 text-start text-xs font-medium text-blue-500 uppercase">Name</th>
                                    <th class="px-6 py-3 text-start text-xs font-medium text-blue-500 uppercase">Email</th>
                                    <th class="px-6 py-3 text-start text-xs font-medium text-blue-500 uppercase">Grade</th>
                                    <th class="px-6 py-3 text-end text-xs font-medium text-blue-500 uppercase">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @foreach($students as $student)
                                    <tr class="hover:bg-gray-100">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800">{{ $student->name }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">{{ $student->email }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">
                                            <form action="{{ route('results.update', $student->id) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="major_id" value="{{ request('major_id') }}">
                                                <input type="hidden" name="subject_id" value="{{ request('subject_id') }}">
                                                <input type="text" name="grade" value="{{ $student->results->first()->grade ?? '' }}" class="border rounded px-2 py-1 w-full">
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-end text-sm font-medium">
                                            <button type="submit" class="py-3 px-4 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-blue-100 text-blue-800 hover:bg-blue-200 focus:outline-none focus:bg-blue-200 active:bg-blue-200 disabled:opacity-50 disabled:pointer-events-none dark:text-blue-400 dark:hover:bg-blue-900 dark:focus:bg-blue-900 dark:active:bg-blue-900">Save</button>
                                            </form>
                                            @if($student->results->first())
                                                <form action="{{ route('results.destroy', $student->id) }}" method="POST" class="inline-block mt-2">
                                                    @csrf
                                                    @method('DELETE')
                                                    <input type="hidden" name="major_id" value="{{ request('major_id') }}">
                                                    <input type="hidden" name="subject_id" value="{{ request('subject_id') }}">
                                                    <button type="submit" class="py-3 px-4 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-red-100 text-red-800 hover:bg-red-200 focus:outline-none focus:bg-red-200 active:bg-red-200 disabled:opacity-50 disabled:pointer-events-none dark:text-red-400 dark:hover:bg-red-900 dark:focus:bg-red-900 dark:active:bg-red-900">Delete</button>
                                                </form>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
</body>
</html>
