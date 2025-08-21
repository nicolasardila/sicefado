<?php

namespace Modules\LOMBRISOFT\Emails;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Collection;

class PendingAlertsMail extends Mailable
{
    use Queueable, SerializesModels;

    public $alerts;
    public $totalAlerts;

    public function __construct(Collection $alerts)
    {
        $this->alerts = $alerts;
        $this->totalAlerts = $alerts->count();
    }

    public function build()
    {
        return $this->subject('🚨 ' . $this->totalAlerts . ' Alertas Vencidas - Requieren Atención Inmediata')
                    ->view('lombrisoft::emails.pending_alerts');
    }
}