<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter des Résultats</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body class="bg-gray-100 p-6">
    <div class="max-w-4xl mx-auto bg-white p-8 rounded-lg shadow-lg">
        <h1 class="text-2xl font-bold mb-4">Ajouter des Résultats</h1>

        @if(session('success'))
            <div class="bg-green-200 text-green-800 p-4 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <!-- Add result form -->
        <form action="{{ route('store_results') }}" method="POST">
            @csrf

            <!-- Major Selection -->
            <div class="mb-4">
                <label for="major_id" class="block text-gray-700">Filère</label>
                <select id="major_id" name="major_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                    <option value="">Sélectionner une filière</option>
                    @foreach($majors as $major)
                        <option value="{{ $major->id }}">{{ $major->name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Subject Selection -->
            <div class="mb-4">
                <label for="subject_id" class="block text-gray-700">Matière</label>
                <select id="subject_id" name="subject_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                    <option value="">Sélectionner une matière</option>
                    <!-- Subjects will be populated by JavaScript based on selected major -->
                </select>
            </div>

            <!-- Student Selection -->
            <div class="mb-4">
                <label for="student_id" class="block text-gray-700">Étudiant</label>
                <select id="student_id" name="student_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                    <option value="">Sélectionner un étudiant</option>
                    <!-- Students will be populated by JavaScript based on selected major -->
                </select>
            </div>

            <div class="mb-4">
                <label for="grade" class="block text-gray-700">Note</label>
                <input type="number" id="grade" name="grade" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required min="0" max="20" step="0.01">
            </div>

            <div>
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md shadow hover:bg-blue-600">Ajouter Résultat</button>
            </div>
        </form>
    </div>

    <script>
        $(document).ready(function() {
            const subjects = @json($subjects);
            const students = @json($students);

            // Event handler for major selection
            $('#major_id').on('change', function() {
                const majorId = $(this).val();

                // Filter subjects based on selected major
                const filteredSubjects = subjects.filter(subject => subject.major_id == majorId);
                const filteredStudents = students.filter(student => student.major_id == majorId);

                // Populate subject dropdown
                $('#subject_id').empty();
                $('#subject_id').append('<option value="">Sélectionner une matière</option>');
                filteredSubjects.forEach(subject => {
                    $('#subject_id').append(`<option value="${subject.id}">${subject.name}</option>`);
                });

                // Populate student dropdown
                $('#student_id').empty();
                $('#student_id').append('<option value="">Sélectionner un étudiant</option>');
                filteredStudents.forEach(student => {
                    $('#student_id').append(`<option value="${student.id}">${student.name}</option>`);
                });
            });
        });
    </script>
</body>
</html>
