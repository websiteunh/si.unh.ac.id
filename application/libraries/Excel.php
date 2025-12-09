<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
// Bridge to PhpSpreadsheet via Composer autoload
$autoload = realpath(APPPATH.'../vendor/autoload.php');
if ($autoload && file_exists($autoload)) {
    require_once $autoload;
}

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\IOFactory;

// Simple wrapper to preserve existing references to `Excel`
class Excel extends Spreadsheet {
    public function __construct() {
        parent::__construct();
    }
}