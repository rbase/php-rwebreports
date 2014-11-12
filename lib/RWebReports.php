<?php

class RWebReports {

  public static function newReport() {
    return new RWebReportsReport();
  }

  public static function execute($config) {
    $rwebreportsPath = getenv('RWEBREPORTS_PATH');
    if (!$rwebreportsPath) {
      throw new Exception('RWEBREPORTS_PATH not set');
    }

    $configPath = tempnam('.', 'rwebreports-');
    file_put_contents($configPath, $config);

    $output = shell_exec("$rwebreportsPath $configPath");
    $success = strpos($output, 'OK') === 0;
    unlink($configPath);
    return new RWebReportsResult($success, $output, $config);
  }

}
