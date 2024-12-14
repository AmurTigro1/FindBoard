<?php

namespace App\Mail;

use App\Models\Reservation;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ReservationNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $reservation;
    /**
     * Create a new message instance.
     */
    public function __construct(Reservation $reservation)
    {
        $this->reservation = $reservation;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Reservation Notification',
        );
    }

    /**
     * Get the message content definition.
     */
    public function build()
    {
        return $this->subject('New Reservation')
        ->view('emails.reservation_notification')
        ->with([
            'room' => $this->reservation->room,
            'name' => $this->reservation->name,
            'email' => $this->reservation->email,
            'phone' => $this->reservation->phone,
            'address' => $this->reservation->address,
            'visit_date' => $this->reservation->visit_date,
            'visit_time' => $this->reservation->visit_time, // Pass the visit time
        ]);
    }
    public function content(): Content
    {
        return new Content(
            view: 'emails.reservation_notification',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
