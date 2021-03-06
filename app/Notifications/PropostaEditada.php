<?php

namespace App\Notifications;

use App\Obra;
use App\Pessoa;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class PropostaEditada extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($proposta)
    {
      $this->proposta = $proposta;
      $this->obra = Obra::where('Proposta_cod_proposta', '=', $this->proposta->cod_proposta)->first();
      $this->propositor = Pessoa::join('Usuario', 'Usuario.Pessoa_cod_pessoa', '=', 'Pessoa.cod_pessoa')
                                ->join('Usuario_Propositor', 'Usuario_Propositor.Usuario_cod_usuario', '=', 'Usuario.cod_usuario')
                                ->where('Usuario_Propositor.cod_propositor', '=', $this->proposta->Usuario_Propositor_cod_propositor)
                                ->select('Pessoa.*')
                                ->first();
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
      $url = url('/admin/painel-administrador/'.$this->proposta->cod_proposta);
      return (new MailMessage)
                  ->subject('Proposta editada.')
                  ->greeting('Olá!')
                  ->line('A proposta "'.$this->obra->titulo.'" foi modificada.')
                  ->action('Acessar proposta', $url);
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
          'message_user' => 'A proposta de título "'.$this->obra->titulo.'" foi editada por '.$this->propositor->nome.' '.$this->propositor->sobrenome,
          'message_report'=>'Proposta editada por '.$this->propositor->nome.' '.$this->propositor->sobrenome,
          'cod_proposta' => $this->proposta->cod_proposta,
          'cod_propositor' => $this->proposta->Usuario_Propositor_cod_propositor,
        ];
    }
}
