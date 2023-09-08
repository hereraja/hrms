<style>
    table {
        border-collapse: collapse;
    }

    .table{
        width: 236%;
        max-width: 250%;
        margin-bottom: 20px;
    }

    table, td, th {
        border: 1px solid #dddddd;

        padding: 6px;
        font-size: 14px;
        text-transform:capitalize !important;
    }

    th {
        font-weight:bold !important;
        text-align: center;

    }

    tr:hover {background-color: #f5f5f5;}

</style>
<script>
  function printDiv() {

        var divToPrint = document.getElementById('divToPrint');

        var WindowObject = window.open('', 'Print-Window');
        WindowObject.document.open();
        WindowObject.document.writeln('<!DOCTYPE html>');
        WindowObject.document.writeln('<html><head><title></title><style type="text/css">');


        WindowObject.document.writeln('@media print { .center { text-align: center;}' +
            '                                         .inline { display: inline; }' +
            '                                         .underline { text-decoration: underline; }' +
            '                                         .left { margin-left: 315px;} ' +
            '                                         .right { margin-right: 375px; display: inline; }' +
            '                                          .table{ width: 236%; max-width: 250%; margin-bottom: 20px; } table { border-collapse: collapse; font-size: 14px;}' +
            '                                          th, td { border: 1px solid black; border-collapse: collapse; padding: 10px;}' +
            '                                           th, td { }' +
            '                                         .border { border: 1px solid black; } ' +
            '                                         .bottom { bottom: 5px; width: 100%; position: fixed ' +
            '                                       ' +
            '                                   } } </style>');
        WindowObject.document.writeln('</head><body onload="window.print()">');
        WindowObject.document.writeln(divToPrint.innerHTML);
        WindowObject.document.writeln('</body></html>');
        WindowObject.document.close();
        setTimeout(function () {
            WindowObject.close();
        }, 10);

  }
</script>

<?php
    if($_SERVER['REQUEST_METHOD'] == "POST" ) {

        $bp = $gp =  $gross = $pf =$ptax = $tot_deduct = $net =$tf=$gpf=$epf=$comploan=
        
        $basic = $da  =  $ir = $hra = $ma = $oa = $ccs = $ins = $tf=$hbl=$tel=$med_adv=$med_ins=

       $oth_ded= $comp_loan= $fa = $lic  =  $itx = $pa = 0;$tot_earning = 0;$earning  = 0;   $deduction = 0; 
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
        <div class="card-body" id="divToPrint">
        <div class="row">
            <div class="col-1"><a href="javascript:void()"><img src="<?=base_url()?>assets/images/benfed.png" alt="logo"/></a></div>
            <div class="col-10"> 
                <div style="text-align:center;">
                    <h4><?=ORG_NAME?></h4>
                    <h5><?=ORG_ADDRESS?></h5>
                    <h5>Wages FOR THE MONTH OF <?php echo MONTHS[$this->input->post('sal_month')].' '.$this->input->post('year') ; ?> FOR EXTRA TEMPORARY HELPING HANDS</h5>
                </div>
            </div>
        </div>
              <div class="row">
                <div class="col-12">
                  <div class="table-responsive">
                  <table class="table table-bordered table-hover" style="width: 100%;">

<thead>

    <?php 

        if($this->input->post('category') == 0 ) {
        
    ?>
      

    </thead>

    <tbody> 

        <?php 
        
        if($list ) {
            

         ?>
     

        <?php
            
        }

     
    }

else {

?>
    
    <tr style="">
        
        <th width="15px">Sl No.</th>
        <th width="200px">Emplyee Name</th>
        <th width="200px">NO OF DAYS</th>
        <th width="200px">WAGES PER DAYS</th>
        <th width="15px">AMOUNT(RS.)</th>
        <th width="15px">EPF 12% DEDUCTION</th>
        <th width="15px">ESI 0.75% DEDUCTION</th>
        <th width="15px">AMOUNT PAYBLE</th>
        <th width="15px">CHEQUE NO</th>
        <th width="15px">SIGNATURE</th>
    </tr>

</thead>

<tbody> 

    <?php 
            $temp_var = 0;
            $tempCount = 0;
            $esi = 0;
            $i = 1;
            $tot_payble = 0;
        if($list) {

            
        foreach($list as $s_list) {

            $basic       +=  $s_list->basic_pay;
            $epf         +=  $s_list->epf;
            $gpf         +=  $s_list->gpf;
            $esi         += $s_list->esi;
           

    ?>        

    <tr <?php echo ($tempCount == 20)? 'class="breakAfter"':'';  ?>>

        <td><?=$i++?></td>
        <td><?=$s_list->emp_name?></td>
        <td><?=$s_list->no_of_days?></td>
        <td><?=$s_list->daily_wages?></td>
        <td><?php echo $s_list->basic_pay; ?></td>
        <td><?php echo $s_list->epf; ?></td>
        <td><?php echo $s_list->esi; ?></td>
        <td><?php echo round($s_list->basic_pay-$s_list->epf-$s_list->esi); $tot_payble +=round($s_list->basic_pay-$s_list->epf-$s_list->esi); ?></td>
        <td><?php //echo $s_list->tot_deduction;?></td>
        <td></td>
     
       
    </tr>
<?php
            $tempCount++;$earning=0;$deduction=0;
        }

        ?>
            <tr style="font-weight:700">
                
                <td colspan="4">Total</td>
                <td><?php echo $basic; ?></td>
                <td><?php echo $epf; ?></td>
                <td><?php echo $esi; ?></td>
                <td><?php echo $tot_payble; ?></td>
                <td></td>
                <td></td>
                <!-- <td></td> -->
             
                
            </tr>

        <?php    

        
        }
        else {

            echo "<tr><td colspan='22' style='text-align:center;'>No data Found</td></tr>";

        }
    }

    
?>

</tbody>

</table>
                    <br>
                    <div>

                       <p>Amount:<?php echo getIndianCurrency($tot_payble); ?></p> 

                    </div>
                    
                    <!-- <div  class="bottom">
                
                        <p style="display: inline;">Prepared By</p>

                        <p style="display: inline; margin-left: 8%;">Establishment, Sr. Asstt.</p>

                        <p style="display: inline; margin-left: 8%;">Assistant Manager-II</p>

                        <p style="display: inline; margin-left: 8%;"></p>

                        <p style="display: inline; margin-left: 8%;">Chief Executive Officer</p>

                    </div> -->

            
                  </div>
                  
                </div>
                
              </div>
              
            </div>
            <div class="row">
            <div class="col-md-12" style="text-align: center;"><button type="button" class="btn btn-primary" id="btn" value="Print" onclick="printDiv();">Print</button></div>
            </div>
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
              <h3>Category wise Salary Report</h3>
              <div class="row">
                <div class="col-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                        <form method="POST" id="form" action="<?php echo site_url("reports/salarycatgreport");?>" >
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-6">
                                    <label for="exampleInputName1">Transaction Date:</label>
                                    <input type="date"
                                            name="trans_dt"
                                            class="form-control"
                                            id="trans_dt"
                                            value="<?php echo $sys_date;?>"
                                            readonly />
                                    </div>
                                    <div class="col-6">
                                    <label for="exampleInputName1">Select Month:</label>
                                    <select
                                class="form-control required"
                                name="sal_month"
                                id="sal_month"
                                >

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
                                     <input type="text" class="form-control" name="year" id="year"
                                     value="<?php echo date('Y');?>" />
                  </div>
                    <div class="col-6">
                        <label for="exampleInputName1">Category:</label>
                        <select
                            class="form-control required"
                            name="category"
                            id="category"
                            >

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
      
