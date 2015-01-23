#!/usr/bin/php
<?php
$sourceXML = 'http://www.cbu.uz/section/rates/widget/xml';
$outFilePath = "../app/data/currency.json";

$out = [
    'date' => null,
    'currency' => [],
];
if (!$source = (array) simplexml_load_string(file_get_contents($sourceXML)))
    exit('Source data is not a valid XML');

$out['date'] = date('d.m.Y');

foreach ($source['symbol'] as $pos => $symbol) {
    if (in_array($symbol, ['USD', 'EUR', 'RUB'])) {
        $out['currency'][$symbol] = $source['rate'][$pos];
    }
}

file_put_contents($outFilePath, json_encode($out));

?>
