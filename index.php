<?php
namespace Acme;

require 'vendor/autoload.php';

use Acme\Helpers\CustomValidate as CustomValidate;

$validate = new CustomValidate();
$spreadsheet = $validate->process(__DIR__ . '/excel/Type_A.xlsx', 'xlsx');

if($validate->isValid()) {
    print_r("Yes Valid");
} else {
    $msg = $validate->getMessage();
    print_r($msg);
}
