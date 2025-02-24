<!DOCTYPE html>
<html>
<head>
    <title>Upload Template - PDF Generator</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 p-8">
    <div class="max-w-4xl mx-auto">
        <div class="mb-6">
            <h1 class="text-2xl font-bold">Upload New Template</h1>
        </div>

        <div class="bg-white shadow rounded-lg p-6">
            <form action="{{ route('documents.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf
                
                <div>
                    <label class="block text-sm font-medium text-gray-700">Template Name</label>
                    <input type="text" name="name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Word Template</label>
                    <input type="file" name="template" accept=".docx" class="mt-1 block w-full">
                </div>

                <div class="flex justify-end space-x-2">
                    <a href="{{ route('documents.index') }}" class="bg-gray-200 px-4 py-2 rounded">Cancel</a>
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Upload</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>