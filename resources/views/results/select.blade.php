<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sélectionner une Filière et une Matière</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 p-6">
    <div class="max-w-4xl mx-auto bg-white p-8 rounded-lg shadow-lg">
        <h1 class="text-2xl font-bold mb-4">Sélectionner une Filière et une Matière</h1>

        @if(session('success'))
            <div class="bg-green-200 text-green-800 p-4 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('results.list') }}" method="GET">
            @csrf

            <div class="mb-4">
                <label for="major_id" class="block text-gray-700">Filière</label>
                <select id="major_id" name="major_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                    <option value="">Sélectionner une filière</option>
                    @foreach($majors as $major)
                        <option value="{{ $major->id }}">{{ $major->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-4">
                <label for="subject_id" class="block text-gray-700">Matière</label>
                <select id="subject_id" name="subject_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                    <option value="">Sélectionner une matière</option>
                </select>
            </div>

            <div>
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md shadow hover:bg-blue-600">Soumettre</button>
            </div>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const subjects = @json($subjects);

            const majorSelect = document.getElementById('major_id');
            const subjectSelect = document.getElementById('subject_id');

            majorSelect.addEventListener('change', function () {
                const majorId = this.value;

                // Filtrer les matières en fonction de la filière sélectionnée
                const filteredSubjects = subjects.filter(subject => subject.major_id == majorId);

                // Vider et remplir le menu déroulant des matières
                subjectSelect.innerHTML = '<option value="">Sélectionner une matière</option>';
                filteredSubjects.forEach(subject => {
                    const option = document.createElement('option');
                    option.value = subject.id;
                    option.textContent = subject.name;
                    subjectSelect.appendChild(option);
                });
            });
        });
    </script>
</body>
</html>

