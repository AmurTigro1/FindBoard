<!-- resources/views/emails/reservation_notification.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservation Confirmation</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6;">
    <h1 style="color: #333;">Reservation Confirmation</h1>
    <p>Dear {{ $reservation->name }},</p>

    <p>Thank you for your reservation! Here are the details:</p>
    <ul>
        <li><strong>Room ID:</strong> {{ $reservation->room_id }}</li>
        <li><strong>Name:</strong> {{ $reservation->name }}</li>
        <li><strong>Email:</strong> {{ $reservation->email }}</li>
        <li><strong>Phone:</strong> {{ $reservation->phone }}</li>
        <li><strong>Address:</strong> {{ $reservation->address }}</li>
        <li><strong>Visit Date:</strong> {{ $reservation->visit_date }}</li>
        <p><strong>Visit Time:</strong> {{ $visit_time }}</p>

    </ul>

    <p>If you have any questions, feel free to contact us.</p>

    <p>Best regards,</p>
    <p>FindBoard</p>
</body>
</html>
