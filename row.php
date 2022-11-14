<?php

class Row {
    private string $date;
    private string $typeOfDeath;
    private string $nonViolentCause;
    private string $violentType;
    private string $violentCause;
    public array $allCauses = [];

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

    public function addToAllCauses(): void {
        $this->allCauses [] = strtolower($this->typeOfDeath);
        $this->allCauses = array_merge(explode(";", strtolower($this->nonViolentCause)), $this->allCauses);
        $this->allCauses [] = strtolower($this->removeDuplicates($this->violentType));
        $this->allCauses = array_merge(explode(";", strtolower($this->violentCause)), $this->allCauses);
    }

    public function getAllCauses(): array {
        return $this->allCauses;
    }
}
