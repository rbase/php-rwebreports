<?php

class RWebReportsTask {

  private $dsn;
  private $reportName;
  private $whereClause;

  public function dsn($dsn) {
    $this->dsn = $dsn;
    return $this;
  }

  public function reportName($reportName) {
    $this->reportName = $reportName;
    return $this;
  }

  public function whereClause($whereClause) {
    $this->whereClause = $whereClause;
    return $this;
  }

  public function execute() {
    assert(!is_null($this->dsn), 'Must specify dsn');
    assert(!is_null($this->reportName), 'Must specify reportName');
    assert(!is_null($this->whereClause), 'Must specify whereClause');
    return RWebReports::execute($this->getConfig());
  }

  private function getConfig() {
    return "DSN $this->dsn\n"
      . "REPORT_NAME $this->reportName\n"
      . "WHERE_CLAUSE $this->whereClause\n";
  }

}
