<div class="main-panel">
        <div class="content-wrapper">
        <div class="row">
        <div class="col-xl-6 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <p class="card-title">Leave Application</p>
                  <form method="POST" id="form" role="form" name="add_form" action="<?php echo site_url("leave/leaveApplyEntry");?>" onsubmit="return validate()" >
                  <input type="hidden" name="emp_name" id="emp_name" class="form-control" value="<?php echo $emp_name; ?>" readonly>
                      <div class="form-group">
                          <div class="row">
                              <div class="col-6">
                              <label for="exampleInputName1">Docket:<font color="red">*</font></label>
                              <input type="text" name="docket_no" class="form-control" required="" value="<?php echo date('Y')?>-<?php echo str_pad($docket_no,4,"0",STR_PAD_LEFT); ?>" readonly>
                              </div>
                              <div class="col-6">
                              <label for="exampleInputName1">Application Date:<font color="red">*</font></label>
                              <input type="date" name="docket_dt" id="docket_dt" class="form-control" value="<?=date('Y-m-d')?>" required="">
                              </div>
                              </div>
                      </div>
                              <div class="form-group">
                          <div class="row">
                              <div class="col-6">
                              <label for="exampleInputName1">Leave:<font color="red">*</font></label>
                              <select name="leave_type" id="leave_type" class= "form-control required" required>
                                <option value="">Select Leave</option>
                                <option value="CL">CL</option>
                                <option value="EL">EL</option>
                                <option value="ML">ML</option>
                                <!-- <option value="OD">Off Day</option> -->
                                <option value="STU">Study </option>
                                <option value="EO">Paternity/Maternity Leave</option>
                               </select>
                               <span id= "alert1"><font color="red">*Select Leave Type First</font></span>
                              </div>
                              <div class="col-6">
                              <label for="exampleInputName1">Mode:<font color="red">*</font></label>
                              <select name="leave_mode" id="leave_mode" class= "form-control" required>
                                  <option value="F">Full Leave</option>
                                  <option value="H">Half Leave</option>
                              </select>
                              </div>
                              </div>
                            </div>

                              <div class="form-group">
                          <div class="row">
                              <div class="col-6">
                              <label for="exampleInputName1">From:<font color="red">*</font></label>
                              <input type="date" name= "from_dt" id= "from_dt" class= "form-control dt_change" value= "" required placeholder='dd/mm/yyyy'>
                              </div>
                              <div class="col-6">
                              <label for="exampleInputName1">To:<font color="red">*</font></label>
                              <input type="date" name= "to_dt" id= "to_dt" class= "form-control dt_change" value= "" required>
                              </div>
                              </div>
                           </div>

                              <div class="form-group">
                          <div class="row">
                              <div class="col-6">
                              <label for="exampleInputName1">Total Days:</label>
                              <input type="text" name= "no_of_days" id= "no_of_days" class= "form-control required" value= "" readonly />
                              <span id= "balCheck_alert"><font color= "red">* Exceeds available balance</font></span>
                              </div>
                          </div>
                      </div>

                      <div class="form-group">
                          <div class="row">
                          <div class="col-12">
                              <label for="exampleInputName1">Remarks:</label>
                              <textarea name="remarks" id="remarks" class= "form-control" cols="30" rows="5" ></textarea>
                              </div>

                          </div>
                      </div>    
                      <input type="submit" class="btn btn-info" id="submit" value="Apply">
               </form>
                </div>
              </div>
            </div>


            <div class="col-xl-6 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <p class="card-title">Balance Table</p>
                  <div class="d-flex flex-wrap mb-4 mt-4 pb-4">
                  <table class="table table-bordered table-hover">

                    <thead>
                        <caption id= "infoCaption"></caption>
                        <tr>

                            <th>Leave</th>
                            <th>Balance</th>
                            <!-- <th>Current Balance</th> -->

                        </tr>

                    </thead>

                    <tbody id= "info_table" >

                    </tbody>

                    </table>

                  </div>
                  <!-- <canvas id="total-sales-chart"></canvas> -->
                  
                </div>
              </div>
            </div>

       </div>
          
  </div>

  <script>

    $(document).ready(function(){

        $('#alert1').hide();

        $('#leave_type').on('change', function(){

            let leaveType = $(this).val();
            $('#from_dt').val('');
            $('#to_dt').val('');
            $('#no_of_days').val('');
            
            if(leaveType != '')
            {
                $('#alert1').hide();
                $('#submit').prop('disabled', false);
                return true;
            }
            else if(leaveType == '')
            {
                $('#alert1').show();
                $('#submit').prop('disabled', true);
                return false;
            }

        })

        $('#from_dt').on('change', function(){

            let leaveType = $('#leave_type').val();
            if(leaveType != '')
            {
                $('#alert1').hide();
                $('#submit').prop('disabled', false);
                return true;
            }
            else if(leaveType == '')
            {
                $('#alert1').show();
                $('#submit').prop('disabled', true);
                return false;
            }

        })

    })

</script>


<!-- For half leave apply -->
<script>

    $(document).ready(function(){

        $('#to_dt').on('change', function(){

            var leaveType = $('#leave_type').val();
            var fromDt = $('#from_dt').val();
            var toDt    = $('#to_dt').val();
            var leave_mode    = $('#leave_mode').val();
           // var numberofdays    = ;
            if(fromDt != '' && toDt != ''  && leaveType != '' ){
                                 const date1     =   new Date(fromDt);
                const date2     =   new Date(toDt);
                const diffTime  =   Math.abs(date2.getTime() - date1.getTime());
                const diffDays  =   Math.ceil(diffTime / (1000 * 60 * 60 * 24));
                
				if(leave_mode == 'F'){
                var numberofdays = parseFloat(diffDays+1);
				}else{
					var numberofdays = parseFloat('.5');
				}
                if(leaveType == 'ML'){

                    numberofdays = numberofdays * 2;
                }else{

                    numberofdays = numberofdays;
                }


            if(leaveType != '' )
            {
                    $.get('<?php echo site_url("leave/js_get_apply_leaveBalance") ?>', {leaveType : leaveType })
                    .done(function(data){

                        var tableData = JSON.parse(data);
						       var value = tableData;
                            var name = value.emp_name;

                            if(leaveType == 'CL'){

                                if(numberofdays > value.cl_bal){
                                    alert('Casual leaved Exceed ');
                                    $('#submit').attr("type", "button");
                                }else{
                                    $('#submit').attr("type", "submit");
                                }
                            }
                            if(leaveType == 'EL'){

                            if(numberofdays > value.el_bal){
                                alert('Earn leaved Exceed ');
                                $('#submit').attr("type", "button");
                            }else{
                                $('#submit').attr("type", "submit");
                            }
                            }
                            if(leaveType == 'ML'){

                                if(numberofdays > value.ml_bal){
                                    alert('Medical leaved Exceed ');
                                    $('#submit').attr("type", "button");
                                }else{
                                    $('#submit').attr("type", "submit");
                                }
                            }
                            if(leaveType == 'STU'){

                                if(numberofdays > value.stu_bal){
                                    alert('Study leave Exceed ');
                                    $('#submit').attr("type", "button");
                                }else{
                                    $('#submit').attr("type", "submit");
                                }
                            }
                            if(leaveType == 'EO'){
                                
                                if(numberofdays > value.eo_bal){
                                    alert('PATERNITY/MATERNITY day leaved Exceed');
                                    $('#submit').attr("type", "button");
                                }else{
                                    $('#submit').attr("type", "submit");
                                }
                            }

                    })
            }

        }else{
            alert('Please select required fields properly');
        }
    })

        $('#from_dt').on('change', function(){

            var from_dt = $(this).val();
            var leave_mode = $('#leave_mode').val();

            if(leave_mode == 'H')
            {
                $('#to_dt').val(from_dt);
                $('#no_of_days').val('0.5');
                //var noOfDays = 0.5;
                var leaveType = $('#leave_type').val();

                $.get('<?php echo site_url("leave/js_get_apply_leaveBalance") ?>', {leaveType : leaveType })
                .done(function(data){

                    let checkBalData = JSON.parse(data);
                    for(var key in checkBalData)
                    {

                        let checkVal = checkBalData[key];
                        if(leaveType == 'CL')
                        {
                            if(parseFloat(checkVal.cl_bal) < 0.5)
                            {
                                $('#no_of_days').css('border-color', 'red');
                                $('#balCheck_alert').show();
                                $('#submit').prop('disabled', true);
                                return false;
                            }
                            else
                            {
                                $('#no_of_days').css('border-color', 'green');
                                $('#balCheck_alert').hide();
                                $('#submit').prop('disabled', false);
                                return true;
                            }
                        }
                        else if(leaveType == 'EL')
                        {
                            if(parseFloat(checkVal.el_bal) < 0.5)
                            {
                                $('#no_of_days').css('border-color', 'red');
                                $('#balCheck_alert').show();
                                $('#submit').prop('disabled', true);
                                return false;
                            }
                            else
                            {
                                $('#no_of_days').css('border-color', 'green');
                                $('#balCheck_alert').hide();
                                $('#submit').prop('disabled', false);
                                return true;
                            }
                        }
                        else if(leaveType == 'ML')
                        {
                            if(parseFloat(checkVal.ml_bal) < 0.5)
                            {
                                $('#no_of_days').css('border-color', 'red');
                                $('#balCheck_alert').show();
                                $('#submit').prop('disabled', true);
                                return false;
                            }
                            else
                            {
                                $('#no_of_days').css('border-color', 'green');
                                $('#balCheck_alert').hide();
                                $('#submit').prop('disabled', false);
                                return true;
                            }
                        }
                        else if(leaveType == 'OD')
                        {
                            if(parseFloat(checkVal.od_bal) < 0.5)
                            {
                                $('#no_of_days').css('border-color', 'red');
                                $('#balCheck_alert').show();
                                $('#submit').prop('disabled', true);
                                
                                return false;
                            }
                            else
                            {
                                $('#no_of_days').css('border-color', 'green');
                                $('#balCheck_alert').hide();
                                $('#submit').prop('disabled', false);
                                
                                return true;
                            }
                        }
                    }
                })
            }
        })
    })

</script>
<script>

    $(document).ready(function(){

        $('#leave_type').on("change", function(){

            var leaveType = $(this).val();
            var rowCount = $('#info_table tr').length;

            if(leaveType != '')
            {
                if(rowCount == 0)
                {
                    $.get('<?php echo site_url("leave/js_get_apply_leaveBalance") ?>', {leaveType : leaveType })
                    .done(function(data){

                        var tableData = JSON.parse(data);
                      //  for(var key in tableData)
                      //  {
                         //   var value = tableData[key];
						       var value = tableData;
                            var name = value.emp_name;
                            var caption = 'Employee Name: <strong>'+name+'</strong>';

                          

                            var bodyEliment = '<tr> <td> CL </td> <td id="cb">'+value.cl_bal+'</td></tr>'
                                                +'<tr> <td> EL </td> <td id="eb">'+value.el_bal+'</td></tr>'
                                                +'<tr> <td> ML </td> <td id="mb">'+value.ml_bal+'</td> </tr>'
                                                +'<tr> <td> STU </td> <td id="ob">'+value.stu_bal+'</td></tr>'
                                                +'<tr> <td> P/M Leave </td> <td id="ob">'+value.eo_bal+'</td></tr>'
                                                ;

                            $('#info_table').append($(bodyEliment));
                      //  }
                    })

                }
            }
        })
		
		$('#docket_no').on("change", function(){

            var docket_no = $(this).val();
            var doc_status = $('input[name="doc_status"]:checked').val();

            //if(doc_status == 'Y')
            //{
                    $.get('<?php echo site_url("leave/js_validate_docket_no") ?>', {docket_no : docket_no })
                    .done(function(data){
                        if(data == 0 ){
								alert('Invalid Docket No'); 
							    $('#docket_no').val('');
						}else if(data == 2){
                                alert('Docket already in use');
							    $('#docket_no').val('');
                        }
                    })
          //  }
        })
		
		//$('.doc_status').on("change", function(){
		$('input[type=radio][name=doc_status]').change(function() {
			var valll = $(this).val();
			if(valll == 'N'){
				$('#docket_no').val('N.A');
			    $('#docket_no').attr('readonly', true);
			}else{
				$('#docket_no').val('');
			    $('#docket_no').attr('readonly', false);
			}
        })
    })

</script> 

<!-- Calculating total no of days after from_dt and to_dt selection -->
<script>

    $(document).ready(function(){
		$('#leave_mode').on('change', function(){
		$('#from_dt').val("");$('#no_of_days').val("");
		})
        $('#balCheck_alert').hide();
        //$('#to_dt').on('change', function(){
		$('.dt_change').on('change', function(){
            var fromDt = $('#from_dt').val();
            var toDt = $(this).val() ? $(this).val(): $('#from_dt').val();

            if(toDt < fromDt)
            {
                alert('To date can not be less than from date');
                //$('#to_dt').css('border-color', 'red');
                $('#to_dt').val('');
                $('#submit').prop('disabled', true);
                return false;
            }
            else if(toDt >= fromDt)
            {
                //$('#to_dt').css('border-color', 'green');
                $('#submit').prop('disabled', false);
                $('#to_dt').css('border-color', '');
                // In Case of Half Leave Apply
                var leave_mode = $('#leave_mode').val();

                // calculating no of days as per date selection -- 
                const date1     =   new Date(fromDt);
                const date2     =   new Date(toDt);
                const diffTime  =   Math.abs(date2.getTime() - date1.getTime());
                const diffDays  =   Math.ceil(diffTime / (1000 * 60 * 60 * 24));
                
                var leaveType = $('#leave_type').val();
				if(leave_mode == 'F'){
                var noOfDays = parseFloat(diffDays+1);
				}else{
					var noOfDays = parseFloat('.5');
				}
                if(leaveType == 'ML'){

                    noOfDays = noOfDays * 2;
                }else{

                    noOfDays = noOfDays;
                }
               
                //console.log(noOfDays);
                $('#no_of_days').val(noOfDays);

                $.get('<?php echo site_url("leave/js_get_apply_leaveBalance") ?>', {leaveType : leaveType })
                .done(function(data){

                    let checkBalData = JSON.parse(data);
                    for(var key in checkBalData)
                    {

                        let checkVal = checkBalData[key];
                        if(leaveType == 'CL')
                        {   
                            $('#ccb').html(parseFloat(checkVal.cl_bal) - parseFloat(noOfDays));
                            if(parseFloat(checkVal.cl_bal) < parseFloat(noOfDays))
                            {
                                $('#no_of_days').css('border-color', 'red');
                                $('#balCheck_alert').show();
                                $('#submit').prop('disabled', true);
                                return false;
                            }
                            else
                            {
                                $('#no_of_days').css('border-color', 'green');
                                $('#balCheck_alert').hide();
                                $('#submit').prop('disabled', false);
                                return true;
                            }
                        }
                        else if(leaveType == 'EL')
                        {   
                            $('#ceb').html(parseFloat(checkVal.el_bal) - parseFloat(noOfDays));
                            if(parseFloat(checkVal.el_bal) < parseFloat(noOfDays))
                            {
                                $('#no_of_days').css('border-color', 'red');
                                $('#balCheck_alert').show();
                                $('#submit').prop('disabled', true);
                                return false;
                            }
                            else
                            {
                                $('#no_of_days').css('border-color', 'green');
                                $('#balCheck_alert').hide();
                                $('#submit').prop('disabled', false);
                                return true;
                            }
                        }
                        else if(leaveType == 'ML')
                        {   $('#cmb').html(parseFloat(checkVal.ml_bal) - parseFloat(noOfDays));
                            if(parseFloat(checkVal.ml_bal) < parseFloat(noOfDays))
                            {
                                $('#no_of_days').css('border-color', 'red');
                                $('#balCheck_alert').show();
                                $('#submit').prop('disabled', true);
                                return false;
                            }
                            else
                            {
                                $('#no_of_days').css('border-color', 'green');
                                $('#balCheck_alert').hide();
                                $('#submit').prop('disabled', false);
                                return true;
                            }
                        }
                        else if(leaveType == 'OD')
                        {
                            $('#cob').html(parseFloat(checkVal.od_bal) - parseFloat(noOfDays));
                            if(parseFloat(checkVal.od_bal) < parseFloat(noOfDays))
                            {
                                $('#no_of_days').css('border-color', 'red');
                                $('#balCheck_alert').show();
                                $('#submit').prop('disabled', true);
                                
                                return false;
                            }
                            else
                            {
                                $('#no_of_days').css('border-color', 'green');
                                $('#balCheck_alert').hide();
                                $('#submit').prop('disabled', false);
                                
                                return true;
                            }
                        }

                    }

                })
            }

        })

    })

</script>

<!-- To get infotable details as per Leave Type Selection selection -->

<script>

    $(document).ready(function(){

        $('#leave_mode').on('change', function(){
            var leave_mode = $(this).val();
            if(leave_mode == 'H')
            {
                $('#to_dt_label').hide();
                $('#to_dt').hide();
            }
            else if(leave_mode == 'F')
            {
                $('#to_dt_label').show();
                $('#to_dt').show();
            }
        })
    })

</script>