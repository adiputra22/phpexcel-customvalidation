<?php
namespace Acme\Helpers;

use Acme\Helpers\IProcessor;

class CustomValidate implements IProcessor {

    private $message = [];

    public function process($file, $fileType) {
        
        if($fileType == 'xls') {
            $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xls();
        } else if($fileType == 'xlsx') {
            $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
        }

        $spreadsheet = $reader->load($file);
        
        $this->_retrive($spreadsheet);

        return $spreadsheet;
    }

    private function _retrive($spreadsheet) {
        $sheetArray = $spreadsheet->getActiveSheet()->toArray();
        $header = $sheetArray[0];
        
        $i=0;
        $detail_msg = [];
        foreach($sheetArray as $row=>$sheet) {
            
            if($i==0) {
                
            } else {
                $msg = "";
                foreach($sheet as $key=>$item) {
                    $curr_msg = $this->_check($header[$key], $item, $row);
                    $msg = $msg . $curr_msg;
                }

                if($msg!="") {
                    $row_msg = "Row " . $row;
                    array_push( $this->message, $row_msg . ". " . $msg );
                }
                
            }

            $i++;
        }
    }

    private function _check($header, $item, $row) {
        $msg = "";

        if( strpos($header, '*') !== false ) {
            if($item == "") {
                $msg = "Missing value in " . $header . ". ";
            }
        }
        
        if( strpos($header, '#') !== false ) {
            if(preg_match('/\s/',$item)) {
                $msg = $header . " should not contain any space. ";
            }
        }

        return $msg;
    }

    public function isValid() {
        if(count($this->message) > 0) {
            return false;
        } else {
            return true;
        }
    }

    public function getMessage() {
        return $this->message;
    }
    
}