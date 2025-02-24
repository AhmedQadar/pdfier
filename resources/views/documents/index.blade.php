<!DOCTYPE html>
<html>
<head>
    <title>PDF Generator</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 p-8">
    <div class="max-w-4xl mx-auto">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold">Document Templates</h1>
            <a href="{{ route('documents.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded">Upload New Template</a>
        </div>

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-white shadow rounded-lg">
            <table class="min-w-full">
                <thead>
                    <tr class="bg-gray-50">
                        <th class="px-6 py-3 text-left">Name</th>
                        <th class="px-6 py-3 text-left">Status</th>
                        <th class="px-6 py-3 text-left">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($documents as $document)
                    <tr class="border-t">
                        <td class="px-6 py-4">{{ $document->name }}</td>
                        <td class="px-6 py-4">{{ $document->status }}</td>
                        <td>
                            <a href="{{ route('documents.fill', $document->id) }}" class="bg-blue-500 text-white px-4 py-2 rounded">Fill Template</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Generate PDF Modal -->
    <div id="generateModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <form id="generateForm" method="POST" class="space-y-4">
                @csrf
                <h3 class="text-lg font-bold mb-4">Generate PDF</h3>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700">Name</label>
                    <input type="text" name="name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Date</label>
                    <input type="date" name="date" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Email</label>
                    <input type="email" name="email" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                </div>

                <div class="flex justify-end space-x-2">
                    <button type="button" onclick="closeGenerateModal()" class="bg-gray-200 px-4 py-2 rounded">Cancel</button>
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Generate</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function showGenerateForm(documentId) {
            const modal = document.getElementById('generateModal');
            const form = document.getElementById('generateForm');
            form.action = `/documents/${documentId}/generate`;
            modal.classList.remove('hidden');
        }

        function closeGenerateModal() {
            document.getElementById('generateModal').classList.add('hidden');
        }
    </script>
</body>
</html>
