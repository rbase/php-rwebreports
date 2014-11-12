<?php

class RWebReportsCommand {

  private $dsn;
  private $path;
  private $command;
  private $variables = array();

  public function dsn($dsn) {
    $this->dsn = $dsn;
    return $this;
  }

  public function path($path) {
    $this->path = $path;
    return $this;
  }

  public function command($command) {
    $this->command = $command;
    return $this;
  }

  public function addVariable($name, $value) {
    $this->variables[$name] = $value;
    return $this;
  }

  public function execute() {
    assert(!is_null($this->dsn), 'Must specify dsn');
    assert(!is_null($this->path) xor !is_null($this->command),
      'Must specify either path or command');

    if (!is_null($this->path)) {
      return RWebReports::execute($this->getConfig($this->path));
    } else {
      $commandPath = tempnam('.', 'rwebreports-');
      file_put_contents($commandPath, $this->command);
      $result = RWebReports::execute($this->getConfig($commandPath));
      unlink($commandPath);
      return $result;
    }
  }

  private function getConfig($commandPath) {
    $dirname = dirname($commandPath);
    $basename = basename($commandPath);
    return "DSN $this->dsn\n"
      . "HOME_DIR $dirname\n"
      . "RUN $basename\n"
      . "IGNORE_REPORT_NAME\n"
      . "SHOW_WARNING_MESSAGES\n"
      . "SHOW_ERROR_MESSAGES\n"
      . $this->getVariablesConfig();
  }

  private function getVariablesConfig() {
    $config = '';
    foreach ($this->variables as $name => $value) {
      if (is_null($value)) {
        $config .= "VARIABLE $name|TEXT|NULL\n";
      } else if (is_int($value)) {
        $config .= "VARIABLE $name|INTEGER|$value\n";
      } else {
        $escapedValue = self::escapeValue($value);
        $config .= "VARIABLE $name|TEXT|'$escapedValue'\n";
      }
    }
    return $config;
  }

  private static function escapeValue($value) {
    return str_replace('\'', '\'\'', "$value");
  }

}
