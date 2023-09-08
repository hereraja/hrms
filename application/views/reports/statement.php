<style>
    
body {
  font-family:Arial, Tahoma, Verdana;
  font-size: 14px;
  color: #000000;
  background: #fff;
  margin: 0;
  padding: 0;
  line-height: normal; font-weight: 400;
min-height: 100%;
display: flex;
flex-direction: column;
}
.wrapper{box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2); max-width: 1000px; width: 100%; margin: 0 auto; font-family:Arial, Tahoma, Verdana; }

.billPrintWrapper{padding: 15px; color: #333;}

p {color: #000000; font-family:Arial, Tahoma, Verdana; font-size: 15px; margin: 0 auto; padding:0 0 7px 0; line-height:19px;}

h2{color: #000000; font-family:Arial, Tahoma, Verdana; font-size: 18px; margin: 0 0 8px 0; padding: 0;}
.td_a{position: relative;}
.logo{position: absolute; max-width: 56px; height: auto; left: 0;}
.textBold{font-weight:700; font-size: 18px;}
.text_contact{font-weight:700; font-size: 15px;}

.headSec{border-bottom: #000 solid 2px; margin-bottom: 12px; padding-bottom:6px;}
.bodySec{min-height: 750px;}

.topText{width: 100%;}
.topTextLeft{float: left; font-size: 16px; color: #000000; font-weight: 600;}
.topTextRight{float: right; font-size: 16px; color: #000000; max-width:185px; width: 100%; font-weight: 600;}

.billPrintWrapper .printBottom{margin:80px 0 0 0; padding: 0 15px; width: 100%; display: inline-block;}
.billPrintWrapper .printBottom .col-md-3{width: 100%; max-width: 25%; padding: 0 0; float: left; box-sizing: border-box;}

.blueText{color: #0427F3; padding: 0 15px;}
</style>    


<script>
 //   function printDiv() {
//         var divToPrint = document.getElementById('divToPrint');
//         var WindowObject = window.open('', 'Print-Window');
//         WindowObject.document.open();
//         WindowObject.document.writeln('<!DOCTYPE html>');
//         WindowObject.document.writeln('<html><head><title></title><style type="text/css">');
//         WindowObject.document.writeln('@media print { .center { text-align: center;}' +
//             '                                         .inline { display: inline; }' +
//             '                                         .underline { text-decoration: underline; }' +
//             '                                         .left { margin-left: 315px;} ' +
//             '                                         .right { margin-right: 375px; display: inline; }' +
//             '                                          table { border-collapse: collapse; width: 100%;}' +
//             '                                          th, td { border: 1px solid black; border-collapse: collapse; padding: 10px;}' +
//             '                                           th, td { }' +
//             '                                         .border { border: 1px solid black; } ' +
//             '                                         .bottom { bottom: 5px; width: 100%; position: fixed ' +
//             '                                       ' +
//             '                                   } } </style>');
//         WindowObject.document.writeln('</head><body onload="window.print()">');
//         WindowObject.document.writeln(divToPrint.innerHTML);
//         WindowObject.document.writeln('</body></html>');
//         WindowObject.document.close();
//         setTimeout(function () {
//             WindowObject.close();
//         }, 10);
//   }
	
	function printDiv() {

var divToPrint = document.getElementById('divToPrint');

var WindowObject = window.open('', 'Print-Window');
WindowObject.document.open();
WindowObject.document.writeln('<!DOCTYPE html>');
WindowObject.document.writeln('<html><head><title>Test Print</title><style type="text/css">');

//	  	WindowObject.document.writeln('');
WindowObject.document.writeln('@media print { .center { text-align: center;}' +
'body{font-family:Arial, Tahoma, Verdana;font-size: 14px;color: #000;}' +
'.wrapper{box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2); max-width: 900px; width: 100%; margin: 0 auto; font-family:Arial, Tahoma, Verdana; }' +
'.billPrintWrapper{padding: 15px; color: #333;}' +
'p{color: #000000; font-family:Arial, Tahoma, Verdana; font-size: 14px; margin: 0 auto; padding:0 0 7px 0; line-height:19px;}' +
'h2{color: #000000; font-family:Arial, Tahoma, Verdana; font-size: 16px; margin: 0 0 8px 0; padding: 0; max-width:500px; margin: 0 auto;}'+
'.td_a{position: relative;}'+
'.logo{position: absolute; max-width: 56px; height: auto; left: 0;}'+
'.textBold{font-weight:700; font-size: 14px;}'+
'.text_contact{font-weight:700; font-size: 15px;}'+
'.headSec{border-bottom: #000 solid 2px; margin-bottom: 12px; padding-bottom:6px;}'+
'.bodySec{min-height: 750px;}'+
'.topText{width: 100%;}'+
'.topTextLeft{float: left; font-size: 14px; color: #000000; font-weight: 600;}'+
'.topTextRight{float: right; font-size: 14px; color: #000000; max-width:185px; width: 100%; font-weight: 600;}'+
'.billPrintWrapper .printBottom{margin:80px 0 0 0; padding: 0 15px; width: 100%; display: inline-block;}'+
'.billPrintWrapper .printBottom .col-md-3{width: 100%; max-width: 25%; padding: 0 0; float: left; box-sizing: border-box;}'+
'.blueText{color: #0427F3; padding: 0 8px;}'+
'.billPrintWrapper .printBottom{margin:80px 0 0 0; padding: 0 15px; width: 100%; display: inline-block;}' +
'.billPrintWrapper .printBottom .col-md-3{width: 100%; max-width: 25%; padding: 0 0; float: left; box-sizing: border-box;}' +
'} </style>');
WindowObject.document.writeln('</head><body onload="window.print()">');
WindowObject.document.writeln(divToPrint.innerHTML);
WindowObject.document.writeln('</body></html>');
WindowObject.document.close();
setTimeout(function () {
    WindowObject.close();
}, 10);

}
</script>
<style>
  th {

text-align: center;
font-weight: 600 !important;
}
  </style>
<?php
    if($_SERVER['REQUEST_METHOD'] == "POST" ) {
            // function getIndianCurrency($number)
            // {
            //     $decimal = round($number - ($no = floor($number)), 2) * 100;
            //     $hundred = null;
            //     $digits_length = strlen($no);
            //     $i = 0;
            //     $str = array();
            //     $words = array(0 => '', 1 => 'One', 2 => 'Two',
            //         3 => 'Three', 4 => 'Four', 5 => 'Five', 6 => 'Six',
            //         7 => 'Seven', 8 => 'Eight', 9 => 'Nine',
            //         10 => 'Ten', 11 => 'Eleven', 12 => 'Twelve',
            //         13 => 'Thirteen', 14 => 'Fourteen', 15 => 'Fifteen',
            //         16 => 'Sixteen', 17 => 'Seventeen', 18 => 'Eighteen',
            //         19 => 'Nineteen', 20 => 'Twenty', 30 => 'Thirty',
            //         40 => 'Forty', 50 => 'Fifty', 60 => 'Sixty',
            //         70 => 'Seventy', 80 => 'Eighty', 90 => 'Ninety');
            //     $digits = array('', 'Hundred','Thousand','Lakh', 'Crore');
            //     while( $i < $digits_length ) {
            //         $divider = ($i == 2) ? 10 : 100;
            //         $number = floor($no % $divider);
            //         $no = floor($no / $divider);
            //         $i += $divider == 10 ? 1 : 2;
            //         if ($number) {
            //             $plural = (($counter = count($str)) && $number > 9) ? 's' : null;
            //             $hundred = ($counter == 1 && $str[0]) ? ' and ' : null;
            //             $str [] = ($number < 21) ? $words[$number].' '. $digits[$counter]. $plural.' '.$hundred:$words[floor($number / 10) * 10].' '.$words[$number % 10]. ' '.$digits[$counter].$plural.' '.$hundred;
            //         } else $str[] = null;
            //     }
            //     $Rupees = implode('', array_reverse($str));
            //     $paise = ($decimal) ? "and " . ($words[$decimal / 10] . " " . $words[$decimal % 10]) . ' Paise' : '';
            //     return ($Rupees ? $Rupees . 'Rupees ' : '') . $paise .' Only.';
            // }
?>  
      <div class="main-panel">
        <div class="content-wrapper">
          <div class="card">
            <div class="card-body" id='divToPrint'>
				     <div class="headSec">
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tbody>
            <tr>
            <td align="center" valign="top" class="td_a"><h2><img src="<?=base_url()?>assets/images/smb.jpg" width="88" height="84" class="logo" alt=""/>BARRACKPORE CENTRAL ZONE WHOLESALE CONSUMERS’ CO-OPERATIVE SOCIETY LTD.</h2>
                <p>Regd.No.316/24 Parganas, Date: 12-03-64, GSTIN: 19AAAJB0157H1ZJ</p>
                <p class="textBold">35/Madhupandit Road, Talpukur, Barrackpore, North 24 Parganas, WB: 700123</p></td>
            </tr>
            <tr>
            <td align="center" valign="top" class="td_b"><p class="text_contact">Contact: 033 7148 2290 <span class="blueText">★</span> Email : bkpczwccsltd@yahoo.com <span class="blueText">★</span> brkpczwccsltd@gmail.com</p></td>
            </tr>
           
        </tbody>
        </table>
		</div>
            <div class="row" style="min-height:300px;margin-left:0px !important;">
				<div class="col-md-12">
             To<br>
The Branch Manager<br>
The ICICI Bank Ltd.<br>
Barrackpore<br>
				</div>
				
				
				<br>		<br>
				Sub: Salary Transfer Request for the month of ..............- 2023
				<br>		<br>
				Sir,<br>
It is hereby request to you to kindly process the Salary of below list of Employees for the month of
........,2023 from the Current Account (A/C 330605000045), debiting Cheque No- ............... Date:
................ of ICICI Bank.
            </div>

              <div class="row">
                <div class="col-12">
                  <div class="table-responsive">
                    <table id="Record" class="table" style="width: 100%;">
                        <thead>
                        <tr>
                            <th>Sl No.</th>
                            <th>Name</th>
                            <th>Account No</th>
                            <th>Net Amount</th>
                        </tr>
                            </thead>
                            <tbody> 

                            <?php 
                            
                        if($statement) {

                            $i  =   1;
                            $tot_net = 0;
                            foreach($statement as $s_list) {

                                $tot_net += round($s_list->net_amount);

                            ?>
                                <tr>
                                    <td><?php echo $i++; ?></td>
                                    <td style=""><?php echo $s_list->emp_name; ?></td>
                                    <td style="text-align: center;"><?php echo $s_list->bank_ac_no; ?></td>
                                    <td style="text-align: center;"><?php echo round($s_list->net_amount); ?></td>
                                </tr>

                        <?php
                                    
                                }

                        ?>


                                <tr style='font-weight: bold;'>

                                    <td colspan="3">Total Amount</td>

                                    <td style="text-align: right;"> Rs. <?php echo round($tot_net); ?></td>

                                </tr>

                        <?php        
                                
                            }

                            else {

                                echo "<tr><td colspan='4' style='text-align:center;'>No Data Found</td></tr>";
                            }
                        ?>

                        </tbody>
                    </table>
                    <br>
                    <div>

                       <p>Amount: <?php echo round(@$tot_net).' ('.getIndianCurrency(round(@$tot_net)).').';?></p> 
                       <br><br><br>
                    </div>
                    
                    <div  class="bottom">

                        <p style="display: inline; margin-left: 8%;">Manager</p>

                        <p style="display: inline; margin-left: 8%;">Inspector of co-operative Societies</p>

                        <p style="display: inline; margin-left: 8%;">Chief Executive officer</p>

                    </div>
            
                </div>
                </div>
              </div>
            </div>
            
          </div>
          <div class="row">
            <div class="col-md-4" ></div>
            <div class="col-md-2" style="text-align: center;"><button type="button" class='btn btn-primary' id='btn' value='Print' onclick='printDiv();'>Print</button></div>
            <div class="col-md-2" style="text-align: center;"><button type="button" class='btn btn-primary' id='btnbtn' value='Print' >Export to Excel</button></div>
            </div>
         
        </div>



<?php
    }

    else if($_SERVER['REQUEST_METHOD'] == 'GET') {

?>
      <div class="main-panel">
        <div class="content-wrapper">
          <div class="card">
            <div class="card-body">
              <h3>Salary Statement Report</h3>
              <div class="row">
                <div class="col-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                        <form method="POST" id="form" action="<?php echo site_url("reports/paystatementreport");?>" >
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-6">
                                    <label for="exampleInputName1">From Date:</label>
                                    <input type="date"
                                name="from_date"
                                class="form-control required"
                                id="from_date"
                                value="<?php echo $this->session->userdata('sys_date');?>"
                             />
                                    </div>
                                    <div class="col-6">
                                    <label for="exampleInputName1">Select Month:</label>
                                    <select class="form-control" name="sal_month" id="sal_month" required>
                                <option value="">Select Month</option>
                                <?php foreach($month_list as $m_list) {?>

                                    <option value="<?php echo $m_list->id ?>" ><?php echo $m_list->month_name; ?></option>

                                <?php
                                }
                                ?>

                            </select>   

                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-6">
                                    <label for="exampleInputName1">Input Year:</label>
                                     <input type="text" class="form-control" name="year" id="year" required
                                     value="<?php echo date('Y');?>" />
                  </div>
                    <div class="col-6">
                        <label for="exampleInputName1">Category:</label>
                        <select class="form-control required" name="category" id="category" required>

                            <option value="">Select Category</option>

                            <?php foreach($category as $c_list) {?>

                                <option value="<?php echo $c_list->category_code; ?>" ><?php echo $c_list->category_type; ?></option>

                            <?php
                            }
                            ?>

                        </select>  
                        </div>
                        </div>
                    </div>
                    <input type="submit" class="btn btn-info" value="Proceed" />
                            <button class="btn btn-light">Cancel</button>
                        </form>
                        </div>
                    </div>
                </div>
              </div>
            </div>

          </div>
        </div>
        <?php

}
else {

    echo "<h1 style='text-align: center;'>No Data Found</h1>";

}

?>
      
 <script>
 
    </script>