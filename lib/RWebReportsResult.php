<?php

class RWebReportsResult {

  private $success;
  private $output;
  private $config;

  public function __construct($success, $output, $config) {
    $this->success = $success;
    $this->output = $output;
    $this->config = $config;
  }

  public function isSuccess() {
    return $this->success;
  }

  public function getOutput() {
    return $this->output;
  }

  public function getConfig() {
    return $this->config;
  }

}
