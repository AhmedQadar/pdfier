<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fill the Loading Order</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        .template-container {
            position: relative;
            width: 100%;
            max-width: 900px;
            margin: auto;
        }

        .template-container img {
            width: 100%;
            height: auto;
        }

        .input-field {
            position: absolute;
            width: 150px; /* Adjust width as needed */
            padding: 5px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        /* Positioning input fields (Adjust these based on image layout) */
        .order-number { top: 50px; left: 50px; }
        .lpo-number { top: 50px; left: 300px; }
        .date { top: 90px; left: 50px; }
        .loading-location { top: 90px; left: 300px; }
        .quantity { top: 130px; left: 50px; }
        .product { top: 130px; left: 300px; }
        .customername { top: 170px; left: 50px; }
        .paymentterms { top: 170px; left: 300px; }
        .adress { top: 210px; left: 50px; }
        .destination { top: 210px; left: 300px; }
        .registration { top: 250px; left: 50px; }
        .transporter { top: 250px; left: 300px; }
        .kraentryno { top: 290px; left: 50px; }
        .bookingno { top: 290px; left: 300px; }

        /* Compartment Inputs */
        .comp1 { top: 340px; left: 50px; }
        .comp2 { top: 370px; left: 50px; }
        .comp3 { top: 400px; left: 50px; }
        .comp4 { top: 430px; left: 50px; }
        .comp5 { top: 460px; left: 50px; }
        .comp6 { top: 490px; left: 50px; }
    </style>
</head>
<body>

<div class="container mt-5">
    <h2 class="mb-4 text-center">Fill the Loading Order</h2>

    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <form action="{{ route('documents.generate', $document->id) }}" method="POST">
        @csrf

        <div class="template-container">
            <img src="{{ asset('images/loading_order.png') }}" class="img-fluid" alt="Loading Order Template">

            <input type="text" name="orderNo" class="input-field order-number" placeholder="Order No" required>
            <input type="text" name="LPOno" class="input-field lpo-number" placeholder="L.P.O No" required>
            <input type="date" name="date" class="input-field date" required>
            <input type="text" name="LoadLoc" class="input-field loading-location" placeholder="Loading Location" required>
            <input type="text" name="quantity" class="input-field quantity" placeholder="Quantity" required>
            <input type="text" name="product" class="input-field product" placeholder="Product" required>
            <input type="text" name="customername" class="input-field customername" placeholder="Customer Name" required>
            <input type="text" name="paymentterms" class="input-field paymentterms" placeholder="Payment Terms" required>
            <input type="text" name="adress" class="input-field adress" placeholder="Address" required>
            <input type="text" name="destination" class="input-field destination" placeholder="Destination" required>
            <input type="text" name="registration" class="input-field registration" placeholder="Truck Reg No" required>
            <input type="text" name="transporter" class="input-field transporter" placeholder="Transporter" required>
            <input type="text" name="kraentryno" class="input-field kraentryno" placeholder="KRA Entry No" required>
            <input type="text" name="bookingno" class="input-field bookingno" placeholder="Booking Number" required>

            <!-- Compartment Fields -->
            <input type="text" name="comp1" class="input-field comp1" placeholder="Compartment 1">
            <input type="text" name="comp2" class="input-field comp2" placeholder="Compartment 2">
            <input type="text" name="comp3" class="input-field comp3" placeholder="Compartment 3">
            <input type="text" name="comp4" class="input-field comp4" placeholder="Compartment 4">
            <input type="text" name="comp5" class="input-field comp5" placeholder="Compartment 5">
            <input type="text" name="comp6" class="input-field comp6" placeholder="Compartment 6">
        </div>

        <button type="submit" class="btn btn-primary mt-4">Generate Document</button>
    </form>
</div>

</body>
</html>
