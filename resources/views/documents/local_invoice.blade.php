<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fill the {{ $filename }}</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gradient-to-br from-blue-50 to-blue-100 min-h-screen flex items-center justify-center">
<div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-3xl border-l-4 border-blue-600">
    <h2 class="text-xl font-bold text-center text-blue-700 mb-4">
        Fill the <span class="underline">{{ $filename }}</span>
    </h2>

    <form action="{{ route('documents.generate', ['id' => $id]) }}" method="POST" class="grid grid-cols-1 md:grid-cols-2 gap-3">
        @csrf

        @foreach([
            'Invoice Number' => 'invoiceNo', 
            'Invoice Date' => 'date', 
            'Order Number' => 'orderNo', 
            'Truck' => 'truck', 
            'Transporter' => 'transporter', 
            'Buyer' => 'buyer', 
        ] as $label => $name)
        <div>
            <label class="block text-sm text-blue-700 mb-1">{{ $label }}</label>
            <input type="text" name="{{ $name }}" placeholder="{{ $label }}"
                   class="w-full p-2 text-sm border border-blue-300 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none" value="{{ old($name) }}">
        </div>
        @endforeach

        @foreach([1, 2] as $index)
        <div>
            <label class="block text-sm text-blue-700 mb-1">Item {{ $index }}</label>
            <select name="item{{ $index }}" class="w-full p-2 text-sm border border-blue-300 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none">
                <option value="">Select Item</option>
                <option value="AGO" {{ old('item'.$index) == 'AGO' ? 'selected' : '' }}>AGO</option>
                <option value="PMS" {{ old('item'.$index) == 'PMS' ? 'selected' : '' }}>PMS</option>
            </select>
        </div>
        <div>
            <label class="block text-sm text-blue-700 mb-1">Volume {{ $index }}</label>
            <input type="number" name="vol{{ $index }}" placeholder="Volume" step="any"
                   class="w-full p-2 text-sm border border-blue-300 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none" value="{{ old('vol'.$index) }}">
        </div>
        <div>
            <label class="block text-sm text-blue-700 mb-1">Rate {{ $index }}</label>
            <input type="text" name="rate{{ $index }}" placeholder="Rate" readonly
                   class="w-full p-2 text-sm border border-blue-300 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none" value="{{ old('rate'.$index) }}">
        </div>
        <div>
            <label class="block text-sm text-blue-700 mb-1">Amount {{ $index }}</label>
            <input type="text" name="amount{{ $index }}" placeholder="Amount" readonly
                   class="w-full p-2 text-sm border border-blue-300 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none" value="{{ old('amount'.$index) }}">
        </div>
        @endforeach

        <div class="col-span-1 md:col-span-2">
            <label class="block text-sm text-blue-700 mb-1">Total</label>
            <input type="text" name="total" placeholder="Total" readonly
                   class="w-full p-2 text-sm border border-blue-300 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none" value="{{ old('total') }}">
        </div>
        <div class="col-span-1 md:col-span-2">
            <label class="block text-sm text-blue-700 mb-1">Total in Words</label>
            <input type="text" name="total_in_words" placeholder="Total in Words" readonly
                   class="w-full p-2 text-sm border border-blue-300 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none" value="{{ old('total_in_words') }}">
        </div>

        <div class="col-span-1 md:col-span-2 flex justify-center mt-4">
            <button type="submit" class="bg-blue-600 text-white text-sm py-2 px-4 rounded-lg hover:bg-blue-700 transition">
                Generate Document
            </button>
        </div>
    </form>
</div>

@if (session('success'))
<div class="fixed bottom-5 right-5 bg-green-500 text-white px-3 py-1 rounded-lg shadow-lg text-sm">
    {{ session('success') }}
</div>
@endif

@if (session('error'))
<div class="fixed bottom-5 right-5 bg-red-500 text-white px-3 py-1 rounded-lg shadow-lg text-sm">
    {{ session('error') }}
</div>
@endif
</body>
</html>
