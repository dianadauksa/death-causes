<?php
require_once('row.php');

class DataCollection {
    private Row $header;
    private array $data = [];

    public function addData(Row $row): void {
        $this->data [] = $row;
    }

    public function addHeader(Row $headerRow): void {
        $this->header = $headerRow;
    }

    public function getHeader(): Row {
        return $this->header;
    }

    public function getAllData(): array {
        return $this->data;
    }

    public function getTotalDeathRecords(): int {
        return count($this->data);
    }

    private function formatText(string $text): string {
        return strtolower($text);
    }

    public function searchDeathCause(string $deathCause): array {
        $deathCause = trim($deathCause);
        $deathCause = " " . $deathCause;
        return array_filter($this->data, function (Row $row) use ($deathCause) {
            $deathCauseList = "  ";
            $deathCauseList .= $row->getTypeOfDeath();
            $deathCauseList .= $row->getNonViolentCause();
            $deathCauseList .= $row->getViolentType();
            $deathCauseList .= $row->getViolentCause();
            $deathCauseList = str_replace(';', ' ', $deathCauseList);
            return strpos($this->formatText($deathCauseList), $this->formatText($deathCause));
        });
    }

    public function getDeathRecord(string $deathCause): int {
        return count($this->searchDeathCause($deathCause));
    }

    public function getPercentage(string $deathCause): int {
        return round(($this->getDeathRecord($deathCause) / $this->getTotalDeathRecords()) * 100);
    }
}

