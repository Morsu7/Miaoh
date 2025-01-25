<?php
class Order
{
    private int $id_utente;
    private int $id_acquisto;
    private string $timestamp;
    private string $stato_acquisto;
    private float $spesa;

    /**
     * Costruttore della classe Order
     */
    public function __construct(int $id_utente, int $id_acquisto, string $timestamp, string $stato_acquisto, float $spesa)
    {
        $this->id_utente = $id_utente;
        $this->id_acquisto = $id_acquisto;
        $this->timestamp = $timestamp;
        $this->stato_acquisto = $stato_acquisto;
        $this->spesa = $spesa;
    }

    // Getter e setter per ogni proprietà

    public function getIdUtente(): int
    {
        return $this->id_utente;
    }

    public function getIdAcquisto(): int
    {
        return $this->id_acquisto;
    }

    public function getTimestamp(): string
    {
        return $this->timestamp;
    }

    public function getStatoAcquisto(): string
    {
        return $this->stato_acquisto;
    }

    public function getSpesa(): float
    {
        return $this->spesa;
    }

    public function getStatoAcquistoFormatted() {
        switch ($this->stato_acquisto) {
            case 'da_spedire':
                return '<span class="badge bg-warning text-dark">Da Spedire</span>';
            case 'spedito':
                return '<span class="badge bg-info text-white">Spedito</span>';
            case 'consegnato':
                return '<span class="badge bg-success text-white">Consegnato</span>';
            default:
                return '<span class="badge bg-secondary text-white">Stato sconosciuto</span>';
        }
    }
}

?>
