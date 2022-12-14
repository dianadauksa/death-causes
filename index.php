<?php

require_once 'row.php';
require_once 'datacollection.php';
const DATA = 'causes-of-death.csv';
require_once 'allcauses.php';

$data = new DataCollection();
$index = 0;
if (($handle = fopen(DATA, "r")) !== false) {
    while (($row = fgetcsv($handle, 2000)) !== false) {
        if ($index == 0) {
            $data->addHeader(new Row($row[1], $row[2], $row[3], $row[4], $row[5]));
        } else {
            $data->addData(new Row($row[1], $row[2], $row[3], $row[4], $row[5]));
        }
        $index++;
    }
    fclose($handle);
}

$data->setAllCauses();
/*$searchFor = readline('Enter a type of death or death cause to search for >> ');
echo "Your search matched {$data->searchCause($searchFor)} records from {$data->getTotalDeathRecords()}." . PHP_EOL;
echo "This is approximately {$data->getPercentage($searchFor)}% of all deaths this year." . PHP_EOL;*/

echo "Total death records {$data->getTotalDeathRecords()}. Of those >> " . PHP_EOL;
foreach(CAUSES as $cause) {
    echo $cause . " was found in {$data->searchCause($cause)}" . PHP_EOL;
}

/* Prints a table of all data in the format => 2021-03: Vardarbīga nāve | Nelaimes gadījumi sadzīvē | Mehāniskie bojājumi;trulu priekšmetu iedarbības rezultāts
 echo str_replace("_", " ", $data->getHeader()->getHeaderRow());
 foreach ($data->getAllData() as $row) {
    echo $row->getRow();
}
*/

