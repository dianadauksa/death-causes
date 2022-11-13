<?php

class Row {
    private string $date;
    private string $typeOfDeath;
    private string $nonViolentCause;
    private string $violentType;
    private string $violentCause;

    public function __construct(string $date, string $typeOfDeath, string $nonViolentCause, string $violentType, string $violentCause) {
        $this->date = $date;
        $this->typeOfDeath = $typeOfDeath;
        $this->nonViolentCause = $nonViolentCause;
        $this->violentType = $violentType;
        $this->violentCause = $violentCause;
    }

    public function removeDuplicates(string $deathType): string {
        return implode(";", array_unique(explode(";", $deathType)));
    }

    public function getDate(): string {
        return $this->date;
    }

    public function getTypeOfDeath(): string {
        return $this->typeOfDeath;
    }

    public function getNonViolentCause(): ?string {
        if (strlen($this->nonViolentCause) == 0) {
            return null;
        }
        return $this->nonViolentCause;
    }

    public function getViolentType(): ?string {
        if (strlen($this->violentType) == 0) {
            return null;
        }
        return $this->removeDuplicates($this->violentType);
    }

    public function getViolentCause(): ?string {
        if (strlen($this->violentCause) == 0) {
            return null;
        }
        return $this->violentCause;
    }

    public function getRow(): string {
        if($this->typeOfDeath === "Nāves cēlonis nav noteikts") {
            return "$this->date: $this->typeOfDeath" . PHP_EOL;
        }
        if($this->typeOfDeath === "Nevardarbīga nāve") {
            return "$this->date: $this->typeOfDeath | $this->nonViolentCause" . PHP_EOL;
        }
        return "$this->date: $this->typeOfDeath | ". $this->removeDuplicates($this->violentType) . " | $this->violentCause" . PHP_EOL;
    }

    public function getHeaderRow(): string {
            return "$this->date: $this->typeOfDeath | $this->nonViolentCause | $this->violentType | $this->violentCause" . PHP_EOL;
    }
}
