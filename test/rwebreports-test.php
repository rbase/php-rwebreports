<?php

require_once 'vendor/autoload.php';

$filename = 'test.pdf';

$result = RWebReports::newReport()
  ->dsn('RRBYW18')
  ->reportName('Customers')
  ->whereClause("OPTION PDF | FILENAME $filename")
  ->execute();

assert($result->isSuccess(), 'Expected success');
assert(file_exists($filename), 'Expected file to exist');

unlink($filename);

$result = RWebReports::newCommand()
  ->dsn('RRBYW18')
  ->command('PRINT Customers OPTION PDF | FILENAME &vFileName')
  ->addVariable('vFileName', $filename)
  ->execute();

assert($result->isSuccess(), 'Expected success');
assert(file_exists($filename), 'Expected file to exist');

unlink($filename);
