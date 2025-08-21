<?php

namespace Modules\LOMBRISOFT\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Modules\LOMBRISOFT\Entities\WormBed;
use Illuminate\Support\Collection;

class AlertaCamaVencida extends Mailable
{
    use Queueable, SerializesModels;

    public $wormBed;
    public $activities;

    /**
     * Constructor del Mailable.
     *
     * @param WormBed $wormBed La cama de lombrices
     * @param Collection $activities Actividades vencidas
     */
    public function __construct(WormBed $wormBed, Collection $activities)
    {
        $this->wormBed = $wormBed;
        $this->activities = $activities;
    }

    /**
     * Construye el correo.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Alerta: Cama con actividades vencidas')
                    ->view('lombrisoft::emails.alerta_cama')
                    ->with([
                        'wormBed' => $this->wormBed,
                        'activities' => $this->activities,
                    ]);
    }
}
