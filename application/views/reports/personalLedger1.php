<script>

    function printDiv() {
        var divToPrint=document.getElementById('divToPrint');

        var WindowObject=window.open('','Print-Window');
        WindowObject.document.open();
        WindowObject.document.writeln('<!DOCTYPE html>');
        WindowObject.document.writeln('<html><head><title></title><style type="text/css">');


        WindowObject.document.writeln('@media print { .center { text-align: center;}' +
            '                                         .inline { display: inline; }' +
            '                                         .underline { text-decoration: underline; }' +
            '                                         .left { margin-left: 315px;} ' +
            '                                         .right { margin-right: 375px; display: inline; }' +
            '                                          table, th, td { border: 1px solid black; border-collapse: collapse; }' +
            '                                           th, td { padding: 5px; }' +
            '                                         .border { border: 1px solid black; } ' +
            '                                         .bottom { bottom: 5px; width: 100%; position: fixed; ' +
            '                                       ' +
            '                                   } } </style>');
        // WindowObject.document.writeln('<style type="text/css">@media print{p { color: blue; }}');
        WindowObject.document.writeln('</head><body onload="window.print()">');
        WindowObject.document.writeln(divToPrint.innerHTML);
        WindowObject.document.writeln('</body></html>');
        WindowObject.document.close();
        setTimeout(function(){ WindowObject.close();},10);

    }

</script>


<?php if($_SERVER['REQUEST_METHOD'] == "POST") {   ?>
<div id="divToPrint">

    <div class="wraper"> 

        <div class="col-lg-12 container contant-wraper">

            <div class="panel-heading">

                <div class="item_body">
                
                    <div style="text-align:center;">

                        <h3>WEST BENGAL STATE MULTIPURPOSE CONSUMERS' CO-OPERATIVE FEDERATION LTD.</h3>

                        <h3>P-1, Hide Lane, Akbar Mansion, 3rd Floor, Kolkata-700073</h3>

                        <h4>Personal Leave Ledger For: <?php echo $empName.' / '.$empNo ; ?> </h4>
                        
                    </div>

                </div>

            </div>

            <br>
            
            <div>

                <table class="table table-striped table-bordered" style="width: 100%;">
                    <!-- <caption>Opening Balance<hr></caption> -->
                    
                    <thead style = "text-align: center">
                        <tr>
                             
                            <td>From Date</td>
                            <td>To Date</td>
                            <td>CL Earned</td>  
                            <td>EL Earned</td>
                            <td>ML Earned</td>
                            <td>OD Earned</td>
                            <td>CL Enjoyed</td>
                            <td>EL Enjoyed</td>
                            <td>ML Enjoyed</td>
                            <td>CL Balance</td>
                            <td>EL Balance</td>
                            <td>ML Balance</td>
                            <td>Remarks</td>
                             
                        </tr>
                    </thead>

                    <tbody style = "text-align: center">
					
					    <tr>
                              <?php $cl_opening = 0;  $el_opening = 0; $ml_opening = 0; $od_opening = 0; $el_f = 0;$el_s =0;
							         $ml_f = 0;$ml_s =0;
                                    $cl_bla = 0;  $el_bal = 0; $ml_bal = 0; $od_bal = 0; $el_bla=0;$ml_bla=0;
                              
                              ?>
							<!-- <td><?php echo date("d-m-Y",strtotime($key1->trans_dt)); ?></td> -->
							<td colspan='2'> Opening Balance</td>
							<td><?php if(isset($opening_bal->cl_bal)) echo $opening_bal->cl_bal; $cl_opening +=0; ?></td>
							<td><?php if(isset($opening_bal->el_bal)) echo $opening_bal->el_bal; $el_opening +=$opening_bal->el_bal;?></td>
							<td><?php if(isset($opening_bal->ml_bal)) echo $opening_bal->ml_bal; $ml_opening +=$opening_bal->ml_bal;?></td>
							<td><?php if(isset($opening_bal->od_bal)) echo $opening_bal->od_bal; $od_opening +=$opening_bal->od_bal;?></td>
                                
                         </tr>
                         <?php if($newleave)   { ?>
                         <tr>
                             
							
							<td colspan='2'>Allocated leave</td>
							<td><?php if(isset($newleave->cl_bal)) echo $newleave->cl_bal; $cl_opening +=$newleave->cl_bal; ?></td>
							<td><?php if(isset($newleave->el_bal)) echo $newleave->el_bal; 
												    $el_f = $el_opening +$newleave->el_bal;
												if($el_f > 300){
													$el_opening = 300;
												}else{
													$el_opening +=$newleave->el_bal;
												}
								?></td>
							<td><?php if(isset($newleave->ml_bal)) echo $newleave->ml_bal; 
												$ml_f = $ml_opening + $newleave->ml_bal;
												if($ml_f > 450){
													$ml_opening = 450;
												}else{
													$ml_opening +=$newleave->ml_bal;
												}
								
								
								?></td>
							<td><?php //if(isset($newleave->od_bal)) echo $newleave->od_bal; $od_opening +=$newleave->od_bal;?></td>
                                
                         </tr>
                         <?php } ?>
                   <?php //foreach($opening as $key1){     ?>
                        <!--      <tr>
                                <td><?php //echo date("d-m-Y",strtotime($key1->from_dt)); ?></td>
                                <td><?php //echo date("d-m-Y",strtotime($key1->to_dt)); ?></td>
                                <td><?php //echo($key1->cl_ern); ?></td>
                                <td><?php //echo($key1->el_ern); ?></td>
                                <td><?php //echo($key1->ml_ern); ?></td>
                                <td><?php //echo($key1->od_ern); ?></td>
                                <td><?php //echo($key1->CL_enj); ?></td>
                                <td><?php //echo($key1->EL_enj); ?></td>
                                <td><?php //echo($key1->ML_enj); ?></td> 
                                <td><?php //echo($key1->cl_bal); ?></td>
                                <td><?php //echo($key1->el_bal); ?></td>
                                <td><?php //echo($key1->ml_bal); ?></td> 
                                <td></td>
                            </tr> -->
                    <?php //  }   ?> 
                         <?php 
                        foreach($leavedtls as $key1)
                        {
                            
                        ?>
                            <tr>
                                <td><?php echo date("d-m-Y",strtotime($key1->from_dt)); ?></td>
                                <td><?php echo date("d-m-Y",strtotime($key1->to_dt)); ?></td>
                                <td><?php //echo $cl_opening; ?>-- </td>
                                <td><?php //echo $el_opening; ?>--</td>
                                <td><?php //echo $ml_opening; ?>--</td>
                                <td><?php //echo $od_opening; ?>--</td>
                                <td><?php echo($key1->CL_enj); ?></td>
                                <td><?php echo($key1->EL_enj); ?></td>
                                <td><?php echo($key1->ML_enj); ?></td> 
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
												if($ml_s > 450){
													$ml_opening = 450;
												}else{
													$ml_opening +=$newleaves->ml_bal;
												}
								
								
								
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
                                <td><?php //echo $cl_opening; ?>-- </td>
                                <td><?php //echo $el_opening; ?>--</td>
                                <td><?php //echo $ml_opening; ?>--</td>
                                <td><?php //echo $od_opening; ?>--</td>
                                <td><?php echo($key1->CL_enj); ?></td>
                                <td><?php echo($key1->EL_enj); ?></td>
                                <td><?php echo($key1->ML_enj); ?></td> 
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
                                <td><?php if(isset($key1->remarks)){ echo $key1->remarks; }else{ echo ''; } ?></td>
                                
                            </tr>

                    <?php
                        }
                        ?>
						
						<tr>
						    <td colspan="9">Closing Balance</td>
							
							<td><?=$cl_bla?></td>
							<td><?=$el_bla?></td>
							<?php if($empNo == 106) { ?>
							<td>0</td>
							<?php }else { ?>
							<td><?=$ml_bla?></td>
							<?php } ?>
						</tr>
                    </tbody>

                </table>

            </div>

            <br>
            <div>

               
            </div>

        </div>
    
    </div>

</div>


<div class="modal-footer">

    <button class="btn btn-primary" type="button" onclick="location.href='<?php echo base_url('index.php/User_Login/main');?>'">Back</button>

    <button class="btn btn-primary" type="button" onclick="printDiv();">Print</button>

</div>
<?php }else { ?>
       <div class="wraper"> 

        <div class="col-md-6 container form-wraper">
          <form method="POST" id="form" action="<?=base_url()?>index.php/leave/personalLedger" novalidate="novalidate">
				<div class="form-header">

						<h4>Leave Report</h4>

			   </div>
				<div class="form-group row">
						<label for="emp_catg" class="control-lebel col-sm-2 col-form-label">Select Year:</label>
							<div class="col-sm-10">
                            <select class="form-control" name="year" id="year" aria-required="true" required>
                                <option value="">Select</option>
                                <option value="2022">2022</option>
								<option value="2023">2023</option>
                            </select>   
                        </div>
                </div>
			   <div class="form-group row">
                    <div class="col-sm-10">
                        <input type="submit" class="btn btn-info" value="Save">
                    </div>
                </div>
			</form>
		 </div>
		 </div>

<?php } ?>
