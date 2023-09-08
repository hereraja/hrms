<div class="main-panel">
        <div class="content-wrapper">
          <div class="card">
            <div class="card-body">
              <h3>Employee Edit</h3>
              <div class="row">
                <div class="col-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                        <form method="POST" id="myform" action="<?php echo site_url("westem");?>" >
                            <div class="form-group">
                                <div class="row">
                        
                                    <div class="col-6">
                                    <label for="exampleInputName1">Employee Code:<span class="requiredfield">*</span></label>
                                    <input type="text" name="emp_code" class="form-control" id="emp_code" value="<?php echo $employee_dtls->emp_code; ?>" readonly/>
                                    </div>
                                    <div class="col-6">
                                    <label for="exampleInputName1">Employee Name:<span class="requiredfield">*</span></label>
                                    <input type="text" name="emp_name" class="form-control required" id="emp_name" value="<?php echo $employee_dtls->emp_name; ?>" readonly/>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-6">
                                    <label for="exampleInputName1">Category:<span class="requiredfield">*</span></label>
                                    <select
                        class="form-control"
                        name="emp_catg" disabled
                        id="emp_catg"
                    >

                                    <option value="">Select Category</option>

                                    <?php foreach($category_dtls as $c_list) {

                                    ?>
                                        <option value="<?php echo $c_list->category_code ?>" 
                                                <?php echo ($employee_dtls->emp_catg == $c_list->category_code)? 'selected':'';?>>
                                                <?php echo $c_list->category_type; ?>
                                        </option>

                                    <?php

                                    }

                                    ?>

                                </select> 
                  </div>
                                    <div class="col-6">
                                    <label for="exampleInputName1">District:</label>
                                         <select
                                class="form-control" disabled
                                name="emp_dist"
                                id="emp_dist"
                               >

                            <option value="">Select District</option>

                            <?php foreach($dist_dtls as $dist) {
                            ?>
                                <option value="<?php echo $dist->district_code ?>" 
                                        <?php echo ($employee_dtls->emp_dist == $dist->district_code)? 'selected':'';?>>
                                        <?php echo $dist->district_name; ?>
                                </option>

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
                        <label for="exampleInputName1">Date of Birth:<span class="requiredfield">*</span></label>
                            <input type="date" class="form-control" name="dob" id="dob" disabled
                                value="<?php if(isset($employee_dtls->dob)) { 
                                                echo $employee_dtls->dob;
                                            }
                                        ?>"
                                />
                    </div>
                    <div class="col-6">
                        <label for="exampleInputName1">Joining Date:<span class="requiredfield">*</span></label>
                            <input type="date" class="form-control" name="join_dt" id="join_dt" disabled
                                    value="<?php if(isset($employee_dtls->join_dt)) { 
                                        echo $employee_dtls->join_dt;
                                    }
                                ?>"
                            />
                    </div>
                </div>
            </div>
            
            <div class="form-group">
                <div class="row">
                    <div class="col-6">
                        <label for="exampleInputName1">Phone No.<span class="requiredfield">*</span></label>
                        <input type="text" class= "form-control" name = "phn_no" disabled
                        id   = "phn_no" value="<?php echo $employee_dtls->phn_no; ?>"/>
                    </div>
                    <div class="col-6">
                        <label for="exampleInputName1">Designation:</label>
                        <input type="text" class= "form-control required" name = "designation" id   = "designation" disabled
                         value="<?php echo $employee_dtls->designation; ?>" />
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <div class="col-6">
                        <label for="exampleInputName1">Department:</label>
                         <select class="form-control" name="department" id="department" disabled>
                            <option value="">Select Department</option>
                            <?php foreach($dept as $dep) { ?>
                                <option value="<?php echo $dep->id; ?>" <?php if( $dep->id == $employee_dtls->department) echo 'selected'; ?>  >
                                        <?php echo $dep->name; ?>
                                </option>
                            <?php } ?>
                            </select>
                    </div>
                    <div class="col-6">
                        <label for="exampleInputName1">Address:</label>
                        <textarea type="text"
                    class= "form-control required"
                    name = "emp_addr" disabled
                    id   = "emp_addr"
                ><?php echo $employee_dtls->emp_addr; ?></textarea>
                    </div>
                </div>
            </div>
               
                <div class="form-group">
                    <div class="row">
                        <div class="col-6">
                            <label for="exampleInputName1">Number of Days:</label>
                            <input type="number" class= "form-control" name = "no_of_days"  requrired
                         value="<?php echo $employee_dtls->no_of_days; ?>" />
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

    <script type="text/javascript">
     <?php  if($employee_dtls->emp_status == 'R' OR $employee_dtls->emp_status == 'RG' ){ ?> 
      $(document).ready(function(){
        $("#myform :input").prop("disabled", true);
      });
      <?php } ?>
    </script>