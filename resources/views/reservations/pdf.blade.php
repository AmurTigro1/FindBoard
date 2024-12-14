<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Reservation Details</title>
</head>
<body>
    <h1>Reservation #{{ $reservation->id }}</h1>
    <p><strong>Room Number:</strong> {{ $reservation->room->number }}</p>
    <p><strong>Images:</strong></p>
    @foreach ($reservation->room->images as $image)
        <img src="{{ asset('storage/' . $image->path) }}" alt="Room Image" width="150" height="150">
    @endforeach
    <p><strong>Status:</strong> {{ $reservation->status }}</p>
    <p><strong>Visit Date:</strong> {{ $reservation->visit_date }}</p>
    <p><strong>Visit Time:</strong> {{ $reservation->visit_time }}</p>
    <p><strong>Other Details:</strong> {{ $reservation->details }}</p>
</body>
</html>
