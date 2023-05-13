<?php
require_once __DIR__.'/../Controllers/lib/PHPMailer/src/PHPMailer.php';
require_once __DIR__.'/DBconnector.php';
include(__DIR__.'/../Controllers/lib/TCPDF/tcpdf.php');

class Report{
    private $pdf;
    private $db;
    public function __construct(){
        $this->pdf = new TCPDF('P', 'mm', 'A4');
        $this->db = new DBConnector();
    }
    public function generateAdminPDF(Admin $admin){
        //remove deafault header and footer
        $this->pdf->setPrintFooter(false);
        $this->pdf->setPrintHeader(false);

        //Add 1 page
        $this->pdf->AddPage();
        // $this->pdf->Cell(190, 10, "this is a cell", 1, 1, 'C');
        
        $this->pdf->writeHTMLCell(190,1, '', '', '<h1 style="text-align: center;">ATMs Report</h1>',1, 1);
        $this->pdf->writeHTMLCell(31.66,0, '', '', '<h1 style="text-align: center;">ATM<br>ID</h1>',1, 0);
        $this->pdf->writeHTMLCell(31.66,0, '', '', '<h1 style="text-align: center;">ATM<br>City</h1>',1, 0);
        $this->pdf->writeHTMLCell(31.66,0, '', '', '<h1 style="text-align: center;">ATM<br>Street</h1>',1, 0);
        $this->pdf->writeHTMLCell(31.66,0, '', '', '<h1 style="text-align: center;">ATM<br>Area</h1>',1, 0);
        $this->pdf->writeHTMLCell(31.66,0, '', '', '<h1 style="text-align: center;">ATM Balance</h1>',1, 0);
        $this->pdf->writeHTMLCell(31.66,0, '', '', '<h1 style="text-align: center;">Need Service</h1>',1, 1);
        //Getting data from Database
        $result = $this->db->select("`ATM`","*");
        $columnsNames = array("ID", "City", "Street", "Area", "Balance");

        if(!$result){
            return false;
        }else{
            for($i=0; $i<sizeof($result); $i++){
                for($j=0; $j<sizeof($result[$i]); $j++){
                    $this->pdf->writeHTMLCell(31.66,20, '', '', '<h1 style="text-align: center;">'.$result[$i][$columnsNames[$j]].'</h1>',1, 0);
                }                
                if($result[$i]["Balance"] < 10000)
                    $this->pdf->writeHTMLCell(31.66,20, '', '', '<h1 style="text-align: center; color:red">Low Balance</h1>',1, 1);
                else
                    $this->pdf->writeHTMLCell(31.66,20, '', '', '<h1 style="text-align: center; color: green">Not Needed</h1>',1, 1);
            }
        }
        //Add content
        
        $this->pdf->Output();
    }

    public function generateTechPDF($atmID){
        //remove deafault header and footer
        $this->pdf->setPrintFooter(false);
        $this->pdf->setPrintHeader(false);

        //Add 1 page
        $this->pdf->AddPage();
        // $this->pdf->Cell(190, 10, "this is a cell", 1, 1, 'C');
        
        $this->pdf->writeHTMLCell(190,1, '', '', '<h1 style="text-align: center;">Technican Report</h1>',1, 1);
        $this->pdf->writeHTMLCell(21.11,15, '', '', '<h4 style="text-align: center;">Trans<br>ID</h4>',1, 0);
        $this->pdf->writeHTMLCell(21.11,15, '', '', '<h4 style="text-align: center;">Account<br>ID</h4>',1, 0);
        $this->pdf->writeHTMLCell(21.11,15, '', '', '<h4 style="text-align: center;">SSN</h4>',1, 0);
        $this->pdf->writeHTMLCell(21.11,15, '', '', '<h4 style="text-align: center;">ATM<br>ID</h4>',1, 0);
        $this->pdf->writeHTMLCell(21.11,15, '', '', '<h4 style="text-align: center;">Amount</h4>',1, 0);
        $this->pdf->writeHTMLCell(21.11,15, '', '', '<h4 style="text-align: center;">Date</h4>',1, 0);
        $this->pdf->writeHTMLCell(21.11,15, '', '', '<h4 style="text-align: center;">State</h4>',1, 0);
        $this->pdf->writeHTMLCell(21.11,15, '', '', '<h4 style="text-align: center;">Type</h4>',1, 0);
        $this->pdf->writeHTMLCell(21.11,15, '', '', '<h4 style="text-align: center;">Reciver<br>Id</h4>',1, 1);
        //Getting data from Database
        $result = $this->db->select("`Transaction`","*", "AtmID=?", array($atmID));
        $columnsNames = array("ID","AccountID", "SSN", "AtmID", "Amount", "Date", "State", "Type" , "receiverId" );

        if(!$result){
            return false;
        }else
        {
            for($i=0; $i<sizeof($result); $i++){
                for($j=0; $j<sizeof($result[$i])-1; $j++){
                    if($j == 6){//State
                        $color = '';
                        $result[$i][$columnsNames[$j]] == "Approved" ? $color = 'green' : $color = 'red';
                        $this->pdf->writeHTMLCell(21.11,15, '', '', '<h4 style="color:'.$color.'; text-align: center;">'.$result[$i][$columnsNames[$j]].'</h4>',1, 0);
                    }else{//Any thing else
                        $this->pdf->writeHTMLCell(21.11,15, '', '', '<h4 style="text-align: center;">'.$result[$i][$columnsNames[$j]].'</h4>',1, 0);
                    }
                }
                $this->pdf->writeHTMLCell(21.11,15, '', '', '<h4 style="text-align: center;">'.$result[$i]["receiverId"].'</h4>',1, 1);
            }                
        }
        //Add content
        $this->pdf->Output();
    }
}
