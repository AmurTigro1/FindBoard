<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Receipt - Reservation #{{ $reservation->id }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 20px;
        }
        .header {
            text-align: center;
            font-size: 24px;
            margin-bottom: 20px;
        }
        .details {
            margin-bottom: 10px;
        }
        .details strong {
            display: inline-block;
            width: 150px;
        }
        .footer {
            margin-top: 20px;
            text-align: center;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Receipt</h1>
        <p>Reservation #{{ $reservation->id }}</p>
    </div>

    <div class="details">
        <p><strong>Guest Name:</strong> {{ $guest->name }}</p>
        <p><strong>Room Number:</strong> {{ $room->number }}</p>
        <p><strong>Status:</strong> {{ $reservation->status }}</p>
        <p><strong>Visit Date:</strong> {{ $reservation->visit_date }}</p>
        <p><strong>Visit Time:</strong> {{ $reservation->visit_time }}</p>
    </div>

    <div class="details">
        <h3>Charges:</h3>
        <p><strong>Room Price:</strong> ${{ $room->price }}</p>
        <p><strong>Amenities Fee:</strong> ${{ $reservation->amenities_fee }}</p>
        <p><strong>Other Charges:</strong> ${{ $reservation->other_charges }}</p>
        <p><strong>Total Amount:</strong> ${{ $totalAmount }}</p>
    </div>

    <div class="details">
        <h3>Payment Information:</h3>
        <p><strong>Payment Method:</strong> {{ $paymentMethod }}</p>
        <p><strong>Payment Status:</strong> {{ $paymentStatus }}</p>
    </div>

    <div class="footer">
        <p>Thank you for choosing our service!</p>
    </div>
</body>
</html>
