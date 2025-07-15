<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Anak;
use App\Models\User;

class TambahNotifikasi extends Notification
{
    use Queueable;

    protected $anak;
    protected $kader;
    /**
     * Create a new notification instance.
     */
    public function __construct(Anak $anak, User $kader)
    {
        $this->anak = $anak;
        $this->kader = $kader;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'title' => "Kader {$this->kader->name}",
            'message' => " Berhasil menambahkan data anak bernama {$this->anak->nama}.",
            'kader_id' => $this->kader->id,
            'anak_id' => $this->anak->id,
            'posyandu_id' => $this->anak->posyandu_id,
        ];
    }
}
