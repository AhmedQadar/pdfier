<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fill the {{ $filename }}</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gradient-to-br from-blue-50 to-blue-100 min-h-screen flex items-center justify-center">
<div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-2xl border-l-4 border-blue-600">
    <h2 class="text-xl font-bold text-center text-blue-700 mb-6">
        Fill the <span class="underline">{{ $filename }}</span>
    </h2>

    <form action="{{ route('documents.generate', ['id' => $id]) }}" method="POST" class="grid grid-cols-1 md:grid-cols-2 gap-4">
        @csrf

        @foreach(['Order No' => 'orderNo', 'L.P.O No' => 'LPOno', 'Date' => 'date', 
                  'Loading Location' => 'LoadLoc', 'Quantity' => 'quantity', 'Product' => 'product', 
                  'Customer Name' => 'customername', 'Payment Terms' => 'paymentterms', 
                  'Address' => 'adress', 'Destination' => 'destination', 
                  'Truck Reg No' => 'registration', 'Transporter' => 'transporter', 
                  'Driver Name' => 'driver_name', 'Driver ID' => 'driver_id', 
                  'KRA Entry No' => 'kraentryno', 'Booking No' => 'bookingno'] as $label => $name)

        <div>
            <label class="block text-sm text-blue-700 mb-1">{{ $label }}</label>
            <input type="{{ $name == 'date' ? 'date' : 'text' }}" name="{{ $name }}" placeholder="{{ $label }}"
                   class="w-full p-2 text-sm border border-blue-300 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none">
        </div>

        @endforeach

        <div class="col-span-1 md:col-span-2">
            <h3 class="text-sm font-semibold text-blue-600 mb-2">Compartment Details</h3>
            <div class="grid grid-cols-3 gap-2">
                @for($i = 1; $i <= 6; $i++)
                <div>
                    <label class="block text-xs text-blue-700 mb-1">Comp {{ $i }} Volume (Ltr)</label>
                    <input type="text" name="comp{{ $i }}" placeholder="Volume (Ltr)"
                           class="w-full p-2 text-sm border border-blue-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                </div>
                @endfor
            </div>
        </div>

        <div class="col-span-1 md:col-span-2 flex justify-center mt-6">
            <button type="submit" class="bg-blue-600 text-white text-sm py-2 px-6 rounded-lg hover:bg-blue-700 transition">
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
