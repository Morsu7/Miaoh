<?php

class Product
{
    private int $id;
    private string $nome;
    private string $descrizione;
    private int $quantita;
    private float $prezzo;
    private float $sconto;
    private string $fineSconto;
    private string $img1;
    private ?string $img2;
    private int $tipoProdottoId;

    // Costruttore
    public function __construct(
        int $id,
        string $nome,
        string $descrizione,
        int $quantita,
        float $prezzo,
        float $sconto,
        string $fineSconto,
        string $img1,
        ?string $img2,
        int $tipoProdottoId
    ) {
        $this->id = $id;
        $this->nome = $nome;
        $this->descrizione = $descrizione;
        $this->quantita = $quantita;
        $this->prezzo = $prezzo;
        $this->sconto = $sconto;
        $this->fineSconto = $fineSconto;
        $this->img1 = $img1;
        $this->img2 = $img2;
        $this->tipoProdottoId = $tipoProdottoId;
    }

    // Getter e Setter
    public function getId(): int
    {
        return $this->id;
    }

    public function getNome(): string
    {
        return $this->nome;
    }

    public function setNome(string $nome): void
    {
        $this->nome = $nome;
    }

    public function getDescrizione(): string
    {
        return $this->descrizione;
    }

    public function setDescrizione(string $descrizione): void
    {
        $this->descrizione = $descrizione;
    }

    public function getQuantita(): int
    {
        return $this->quantita;
    }

    public function setQuantita(int $quantita): void
    {
        $this->quantita = $quantita;
    }

    public function getPrezzo(): float
    {
        return $this->prezzo;
    }

    public function setPrezzo(float $prezzo): void
    {
        $this->prezzo = $prezzo;
    }

    public function getSconto(): float
    {
        return $this->sconto;
    }

    public function setSconto(float $sconto): void
    {
        $this->sconto = $sconto;
    }

    public function getFineSconto(): string
    {
        return $this->fineSconto;
    }

    public function setFineSconto(string $fineSconto): void
    {
        $this->fineSconto = $fineSconto;
    }

    public function getImg1(): string
    {
        return $this->img1;
    }

    public function setImg1(string $img1): void
    {
        $this->img1 = $img1;
    }

    public function getImg2(): ?string
    {
        return $this->img2;
    }

    public function setImg2(?string $img2): void
    {
        $this->img2 = $img2;
    }

    public function getTipoProdottoId(): int
    {
        return $this->tipoProdottoId;
    }

    public function setTipoProdottoId(int $tipoProdottoId): void
    {
        $this->tipoProdottoId = $tipoProdottoId;
    }

    // Metodo per verificare se lo sconto è ancora valido
    public function isScontoValido(): bool
    {
        $oggi = date('Y-m-d');
        return $oggi <= $this->fineSconto;
    }

    public function getPrezzoScontato(): float
    {
        if ($this->isScontoValido()) {
            return round($this->prezzo - ($this->prezzo * $this->sconto / 100),2);
        } else {
            return $this->prezzo;
        }
    }

    // Metodo per ottenere una descrizione dettagliata del prodotto
    public function getDettagli(): string
    {
        return "Prodotto: {$this->nome}\n" .
               "Descrizione: {$this->descrizione}\n" .
               "Prezzo: {$this->prezzo} EUR\n" .
               "Sconto: {$this->sconto}%\n" .
               "Prezzo Scontato: " . number_format($this->calcolaPrezzoScontato(), 2) . " EUR\n" .
               "Quantità Disponibile: {$this->quantita}";
    }
}