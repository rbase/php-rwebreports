<?php

require_once 'vendor/autoload.php';

$filename = 'test.pdf';

$result = RWebReports::newTask()
  ->dsn('RRBYW18')
  ->reportName('Customers')
  ->whereClause("OPTION PDF | FILENAME $filename")
  ->execute();

assert($result->isSuccess(), 'Expected success');
assert(file_exists($filename), 'Expected file to exist');

unlink($filename);
