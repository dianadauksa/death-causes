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

    public function setAllCauses(): void {
        foreach ($this->data as $row) {
            $row->addToAllCauses();
        }
    }

    public function searchCause(string $cause): int {
        $count = 0;
        foreach ($this->data as $row) {
            if (in_array(strtolower($cause), $row->getAllCauses())) {
                $count++;
            }
        }
        return $count;
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

    public function getPercentage(string $deathCause): int {
        return round(($this->searchCause($deathCause) / $this->getTotalDeathRecords()) * 100);
    }
}

