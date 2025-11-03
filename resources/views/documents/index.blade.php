<!DOCTYPE html>
<html>
<head>
    <title>PDF Generator - Home</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 p-8">
    <div class="max-w-4xl mx-auto">
        <div class="mb-6">
            <h1 class="text-2xl font-bold">Document Templates</h1>
        </div>

        <!-- Display total number of templates -->
        <div class="bg-white p-4 rounded-lg shadow mb-6">
            <h2 class="text-lg font-semibold">Total Templates: {{ count($templates) }}</h2>
        </div>

        <!-- Template List -->
        <div class="bg-white shadow rounded-lg p-6">
            <table class="min-w-full">
                <thead>
                    <tr class="bg-gray-50">
                        <th class="px-6 py-3 text-left">Template Name</th>
                        <th class="px-6 py-3 text-left">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($templates as $index => $template)
                    <tr class="border-t">
                        <td class="px-6 py-4">{{ basename($template) }}</td>
                        <td class="px-6 py-4">
                            <a href="{{ route('documents.fill', ['id' => $index]) }}" 
                               class="bg-blue-500 text-white px-4 py-2 rounded">
                               Fill Template
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
