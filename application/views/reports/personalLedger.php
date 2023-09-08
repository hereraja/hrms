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
            '                                          table { border-collapse: collapse; }' +
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
<style>
  th {

text-align: center;
font-weight: 600 !important;
}
  </style>
<?php
    if($_SERVER['REQUEST_METHOD'] == "POST" ) {
           
?>  
      <div class="main-panel">
        <div class="content-wrapper">
          <div class="card">
            <div class="card-body" id='divToPrint'>
            <div class="row">
            <div class="col-1"><a href="javascript:void()"><img src="<?=base_url()?>assets/images/benfed.png" alt="logo"/></a></div>
            <div class="col-10">
                <div style="text-align:center;">
                        <h4><?=ORG_NAME?></h4>
                        <h4><?=ORG_ADDRESS?></h4>
                        <h4>Personal Leave Ledger For: <?php echo $empName.' / '.$empNo ; ?> </h4>
                </div>
            </div>    
            </div>
              <div class="row">
                <div class="col-12">
                  <div class="table-responsive">
                  <table class="table table-striped table-bordered" style="width: 100%;">
                    <!-- <caption>Opening Balance<hr></caption> -->
                    
                    <thead style = "text-align: center">
                        <tr>
                            <td>From Date</td>
                            <td>To Date</td>
                            <td>CL </td>  
                            <td>EL </td>
                            <td>ML </td>
                            <td>EDU </td>
                            <td>PE/ME </td>
                            <td>CL Enj</td>
                            <td>EL Enj</td>
                            <td>ML Enj</td>
                            <td>EDU Enj</td>
                            <td>PEME Enj</td>
                            <td>CL Bal</td>
                            <td>EL Bal</td>
                            <td>ML Bal</td>
                            <td>EDU Bal</td>
                            <td>PEME Bal</td>
                            <td>Remarks</td>
                             
                        </tr>
                    </thead>

                    <tbody style = "text-align: center">
					
					    <tr>
                              <?php $cl_opening = 0;  $el_opening = 0; $ml_opening = 0; $stu_opening = 0; $peme_opening = 0; $el_f = 0;$el_s =0;
							         $ml_f = 0;$ml_s =0;
                                    $cl_bla = 0;  $el_bal = 0; $ml_bal = 0; $od_bal = 0; $el_bla=0;$ml_bla=$stu_bla=$ptmt_bal=0;
                              
                              ?>
							<!-- <td><?php echo date("d-m-Y",strtotime($key1->trans_dt)); ?></td> -->
							<td colspan='2'> Opening Balance</td>
							<td><?php if(isset($opening_bal->cl_bal)) echo $opening_bal->cl_bal; $cl_opening +=0; ?></td>
							<td><?php if(isset($opening_bal->el_bal)) echo $opening_bal->el_bal; $el_opening +=$opening_bal->el_bal;?></td>
							<td><?php if(isset($opening_bal->ml_bal)) echo $opening_bal->ml_bal; $ml_opening +=$opening_bal->ml_bal;?></td>
							<td><?php if(isset($opening_bal->stu_bal)) echo $opening_bal->stu_bal;$stu_opening +=$opening_bal->stu_bal;?></td>
              <td><?php if(isset($opening_bal->eo_bal)) echo $opening_bal->eo_bal; $peme_opening +=$opening_bal->eo_bal;?></td>
                                
                         </tr>
                         <?php if($newleave)   { ?>
                         <tr>
                             
							
							<td colspan='2'>Allocated leave</td>
							<td><?php if(isset($newleave->cl_bal)) echo $newleave->cl_bal; $cl_opening +=$newleave->cl_bal; ?></td>
							<td><?php if(isset($newleave->el_bal)) echo $newleave->el_bal; 
												    $el_f = $el_opening +$newleave->el_bal;
												// if($el_f > 300){
												// 	$el_opening = 300;
												// }else{
													$el_opening +=$newleave->el_bal;
											//	}
								?></td>
							<td><?php if(isset($newleave->ml_bal)) echo $newleave->ml_bal; 
												$ml_f = $ml_opening + $newleave->ml_bal;
												// if($ml_f > 450){
												// 	$ml_opening = 450;
												// }else{
													$ml_opening +=$newleave->ml_bal;
												//}
								?></td>
							<td></td>
                         </tr>
                         <?php } ?>
                         <?php 
                        foreach($leavedtls as $key1)
                        {
                            
                        ?>
                            <tr>
                                <td><?php echo date("d-m-Y",strtotime($key1->from_dt)); ?></td>
                                <td><?php echo date("d-m-Y",strtotime($key1->to_dt)); ?></td>
                                <td><?php //echo $cl_opening; ?> </td>
                                <td><?php //echo $el_opening; ?></td>
                                <td><?php //echo $ml_opening; ?></td>
                                <td><?php //echo $od_opening; ?></td>
                                <td><?php //echo $od_opening; ?></td>
                                <td><?php echo($key1->CL_enj); ?></td>
                                <td><?php echo($key1->EL_enj); ?></td>
                                <td><?php echo($key1->ML_enj); ?></td>
                                <td><?php echo($key1->edu_enj); ?></td>
                                <td><?php echo($key1->peme_enj); ?></td>  
                                
                                <td><?php  if($key1->leave_type == 'CL'){
                                           $cl_bla = $cl_opening - $key1->CL_enj;
                                           $cl_opening = $cl_bla;
                                           }else{
                                            $cl_bla = $cl_opening;
                                           }
                                            echo $cl_bla;    ?>
                                </td>
                                <td><?php  if($key1->leave_type == 'EL'){
                                           $el_bla = $el_opening - $key1->EL_enj;
                                           $el_opening = $el_bla;
                                           }else{
                                            $el_bla = $el_opening;
                                           }
                                            echo $el_bla;    ?>
                                </td>
                                <td><?php  if($key1->leave_type == 'ML'){
                                           $ml_bla = $ml_opening - $key1->ML_enj;
                                           $ml_opening = $ml_bla;
                                           }else{
                                            $ml_bla = $ml_opening;
                                           }
                                            echo $ml_bla;    ?></td> 
                               <td><?php  if($key1->leave_type == 'ML'){
                                           $ml_bla = $ml_opening - $key1->ML_enj;
                                           $ml_opening = $ml_bla;
                                           }else{
                                            $ml_bla = $ml_opening;
                                           }
                                            echo $ml_bla;    ?></td> 
                                <td><?php  if($key1->leave_type == 'ML'){
                                           $ml_bla = $ml_opening - $key1->ML_enj;
                                           $ml_opening = $ml_bla;
                                           }else{
                                            $ml_bla = $ml_opening;
                                           }
                                            echo $ml_bla;    ?></td> 
                                <td><?php if(isset($key1->remarks)){ echo $key1->remarks; }else{ echo ''; } ?></td>
                                
                            </tr>

                    <?php
                        }
                        ?>
                     <?php if($newleaves)   { ?>
                         <tr>
                             
							
							<td colspan='2'>Allocated leave</td>
							<td><?php if(isset($newleaves->cl_bal)) echo $newleaves->cl_bal; $cl_opening +=$newleaves->cl_bal; ?></td>
							<td><?php if(isset($newleaves->el_bal)) echo $newleaves->el_bal; 
											 
											 $el_s = $el_opening +$newleaves->el_bal;
											 if($el_s > 300){
													$el_opening = 300;
												}else{
													$el_opening +=$newleaves->el_bal;
												}
								
								?></td>
							<td><?php if(isset($newleaves->ml_bal)) echo $newleaves->ml_bal; 
											 //$ml_opening +=$newleaves->ml_bal;
								
								$ml_s = $ml_opening + $newleaves->ml_bal;
												// if($ml_s > 450){
												// 	$ml_opening = 450;
												// }else{
													$ml_opening +=$newleaves->ml_bal;
										//		}
								
								?></td>
							<td><?php //if(isset($newleave->od_bal)) echo $newleave->od_bal; $od_opening +=$newleave->od_bal;?></td>
                                
                         </tr>
                         <?php } ?>

                         <?php //  }   ?> 
                         <?php 
                        foreach($leavedtlss as $key1)
                        {
                            
                        ?>
                            <tr>
                                <td><?php echo date("d-m-Y",strtotime($key1->from_dt)); ?></td>
                                <td><?php echo date("d-m-Y",strtotime($key1->to_dt)); ?></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td><?php //echo $od_opening; ?></td>
                                <td><?php //echo $od_opening; ?></td>
                                <td><?php echo($key1->CL_enj); ?></td>
                                <td><?php echo($key1->EL_enj); ?></td>
                                <td><?php echo($key1->ML_enj); ?></td> 
                                <td><?php echo($key1->STU_enj); ?></td> 
                                <td><?php echo($key1->EO_enj); ?></td> 
                                <td><?php  if($key1->leave_type == 'CL'){
                                           $cl_bla = $cl_opening - $key1->CL_enj;
                                           $cl_opening = $cl_bla;
                                           }else{
                                            $cl_bla = $cl_opening;
                                           }
                                            echo $cl_bla;    ?>
                                </td>
                                <td><?php  if($key1->leave_type == 'EL'){
                                           $el_bla = $el_opening - $key1->EL_enj;
                                           $el_opening = $el_bla;
                                           }else{
                                            $el_bla = $el_opening;
                                           }
                                            echo $el_bla;    ?>
                                </td>
                                <td><?php  if($key1->leave_type == 'ML'){
                                           $ml_bla = $ml_opening - $key1->ML_enj;
                                           $ml_opening = $ml_bla;
                                           }else{
                                            $ml_bla = $ml_opening;
                                           }
                                            echo $ml_bla;    ?></td> 
                                             <td><?php  if($key1->leave_type == 'STU'){
                                           $stu_bla = $stu_opening - $key1->STU_enj;
                                           $stu_opening = $stu_bla;
                                           }else{
                                            $stu_bla = $stu_opening;
                                           }
                                            echo $stu_bla;    ?></td>
                                             <td><?php  if($key1->leave_type == 'EO'){
                                           $ptmt_bal = $peme_opening - $key1->ML_enj;
                                           $peme_opening = $ml_bla;
                                           }else{
                                            $ptmt_bal = $peme_opening;
                                           }
                                            echo $ptmt_bal;    ?></td>
                                <td><?php if(isset($key1->remarks)){ echo $key1->remarks; }else{ echo ''; } ?></td>
                                
                            </tr>

                    <?php
                        }
                        ?>
						
                  <tr>
                      <td colspan="12">Closing Balance</td>
                      <td><?=$cl_bla?></td>
                      <td><?=$el_bla?></td>
                      <td><?=$ml_bla?></td>
                      <td><?=$stu_bla?></td>
                      <td><?=$ptmt_bal?></td>
                  </tr>
                  </tbody>
                </table>
                    <br>
                    <div>

                    </div>
            
                </div>
                </div>
              </div>
            </div>
            
          </div>
          <div class="row">
            <div class="col-md-12" style="text-align: center;"><button type="button" class='btn btn-primary' id='btn' value='Print' onclick='printDiv();'>Print</button></div>
           
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
              <h3>Leave Report</h3>
              <div class="row">
                <div class="col-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                        <form method="POST" id="form" action="<?php echo site_url("leave/personalLedger");?>" >
                            <div class="form-group">
                                <div class="row">
                                    
                                    <div class="col-6">
                                    <label for="exampleInputName1">Select Year:</label>
                                        <select class="form-control" name="year" id="year" aria-required="true" required>
                                            <option value="">Select</option>
                                            <option value="2022">2022</option>
                                            <option value="2023">2023</option>
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
      
