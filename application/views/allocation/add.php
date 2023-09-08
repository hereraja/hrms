    <div class="main-panel">
        <div class="content-wrapper">
          <div class="card">
            <div class="card-body">
              <h3>Department Add</h3>
              <div class="row">
                <div class="col-10 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                        <form method="POST" id="form" action="<?php echo site_url("leave/leaveAllocationEntry");?>" >
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-2"></div>
                                    <div class="col-4">
                                    <label for="exampleInputName1">Allocate To:</label>
                                    <select name="emp_no" id="emp_no" class= "form-control required" required>
                                        <option value="">Select Employee</option>
                                        <?php foreach($data as $key){ ?>
                                            <option value="<?php echo $key->emp_code; ?>"><?php echo $key->emp_name; ?></option>
                                        <?php } ?>
                                        
                                    </select>
                                    </div>
                                    <div class="col-sm-3">
                                       <label for="exampleInputName1">Date:<font color="red">*</font></label>
                                       <input type="date" name="trans_dt" id="trans_dt" class= "form-control"  value="" required>
                                    </div>  
                                </div>
                            </div>
                            <div class="form-group">
                            <div class="row">
                            <div class="col-12">

                            <table class="table table-striped table-bordered table-hover">
                        <thead>
                            <tr>
                                <th style= "text-align: center;">CL</th>
                                <th style= "text-align: center;">EL</th>
                                <th style= "text-align: center;">ML</th>
                                <!-- <th style= "text-align: center;">Off Day</th> -->
                                
                                <th style= "text-align: center;">Study Leave</th>
                                <th style= "text-align: center;">Paternity/Maternity Leave</th>
                            </tr>
                        </thead>
                        <tbody id= "intro">
                            
                            <tr>
                                <td>
                                    <input type="text" name= "cl_bal" id= "cl_bal" class= "form-control" value="0.0" />
                                </td>
                                
                                <td>                                 
                                    <input type="text" name="el_bal" class="form-control" id="el_bal" value="0.0" />                                       
                                </td>

                                <td>
                                    <input type="text" name="ml_bal" class="form-control" id="ml_bal" value="0.0" />
                                </td>

                                <!-- <td>
                                    <input type="text" name="od_bal" class="form-control" id="od_bal" />
                                </td>
                                 -->
                                <td>
                                    <input type="text" name="stu_bal" class="form-control" id="stu_bal" value="0.0"/>
                                </td>
                                <td>
                                    <input type="text" name="eo_bal" class="form-control" id="eo_bal" value="0.0" />
                                </td>
                            </tr>

                        </tbody>   

                    </table>
                                        
                            </div>  
                            </div>  
                            </div> 



                            <button type="submit" class="btn btn-primary mr-2">Submit</button>
                            <button class="btn btn-light">Cancel</button>
                        </form>
                        </div>
                    </div>
                </div>
              </div>
            </div>
          </div>
    </div>

    <script>

    $(document).ready(function(){

        $('#emp_no').on('change', function(){

            var empId = $(this).val();
            
            $.get('<?php echo site_url("Leave/js_get_currentBal_forAllocation"); ?>', {emp_cd:empId})
            .done(function(data){

                var result = JSON.parse(data);
                if(result.length == 0)
                {
                    var cur_cl_bal = 0.0;
                    var cur_el_bal = 0.0;
                    var cur_ml_bal = 0.0;
                    var cur_od_bal = 0.0;
                }
                else
                {
                    var cur_cl_bal = result[0].cl_bal;
                    var cur_el_bal = result[0].el_bal;
                    var cur_ml_bal = result[0].ml_bal;
                    var cur_od_bal = result[0].od_bal;
                }

                $('#cur_cl_bal').val(cur_cl_bal);
                $('#cur_el_bal').val(cur_el_bal);
                $('#cur_ml_bal').val(cur_ml_bal);
                $('#cur_od_bal').val(cur_od_bal);

            })

        })

    })

</script>