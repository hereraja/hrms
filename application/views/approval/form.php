    <div class="main-panel">
        <div class="content-wrapper">
          <div class="card">
            <div class="card-body">
              <h3>Approve Leave</h3>
              <div class="row">
                <div class="col-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                        <form method="POST" id="form" role="form" name="add_form" action="<?php echo site_url("leave/approveLeaveApplication");?>" >
                        <?php foreach($data as $key){ ?>

<input type="hidden" name= "trans_dt" id= "trans_dt" class= "form-control required" value= "<?php echo $key->trans_dt; ?>" readonly/>
<input type="hidden" name= "trans_cd" id= "trans_cd" class= "form-control required" value= "<?php echo $key->trans_cd; ?>" readonly/>

                            <div class="form-group">
                                <div class="row">
                                    <div class="col-4">
                                    <label for="docket_no" class="col-form-label">Docket:<font color="red">*</font></label>
                                    <input type="text" name= "docket_no" value= "<?php echo $key->docket_no; ?>" id= "docket_no" class= "form-control required" readonly>
                                    </div>
                                    <div class="col-4">
                                    <label for="docket_no" class="col-form-label">Leave:<font color="red">*</font></label>
                                    <input type="text" name= "leave_type" value= "<?php echo $key->leave_type; ?>" id= "leave_type" class= "form-control required" readonly>
                                    </div>
                                    <div class="col-4">
                                    <label for="docket_no" class="col-form-label">From<font color="red">*</font></label>
                                    <input type="date" name= "from_dt" id= "from_dt" value= "<?php echo $key->from_dt; ?>" class= "form-control required" value= "" readonly>
                                    </div>
                                    
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-4">
                                    <label for="docket_no" class="col-form-label">To:<font color="red">*</font></label>
                                    <input type="date" name= "to_dt" id= "to_dt" value= "<?php echo $key->to_dt; ?>" class= "form-control required" value= "" readonly>
                                    </div>
                                    <div class="col-4">
                                    <label for="docket_no" class="col-form-label">Total Days:<font color="red">*</font></label>
                                    <input type="text" name= "no_of_days" id= "no_of_days" value= "<?php echo $key->no_of_days; ?>" class="form-control required" value= "" readonly />
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                <div class="col-12">
                                    <label for="docket_no" class="col-form-label">Remarks:<font color="red">*</font></label>
                                    <textarea name="remarks" id="remarks" class= "form-control required" cols="30" rows="2" readonly><?php echo $key->remarks; ?></textarea>
                                    </div>
                                </div>
                            </div>
                            
<input type="hidden" name= "cl_bal" id= "cl_bal" value= "<?php echo $key->cl_bal; ?>" class= "form-control required" value= "" readonly />

<input type="hidden" name= "ml_bal" id= "ml_bal" value= "<?php echo $key->ml_bal; ?>" class= "form-control required" value= "" readonly />

<input type="hidden" name= "el_bal" id= "el_bal" value= "<?php echo $key->el_bal; ?>" class= "form-control required" value= "" readonly />

                     <?php   }    ?>
                     <div class="form-group">
                        <div class="row">
                            <div class="col-6">
                            <label for="docket_no" class="col-form-label">Manager Remarks</label>
                            <textarea name="approve_label1_rmrk" id="approve_label1_rmrk" class="form-control" required cols="30" rows="2" readonly><?=$key->approve_label1_rmrk?></textarea>
                            </div>
                            <div class="col-6">
                            <label for="docket_no" class="col-form-label"> Remarks</label>
                            <textarea name="approve_remarks" id="approve_remarks" class="form-control" cols="30" rows="2"></textarea>
                            </div>
                        </div>
                     </div>   
                     <div class="form-group">
                        <div class="row">
                            <div class="col-4">
                                <select class="form-control" name="status" required>
                                    <option value="">Please Select Status</option>
                                    <option value="A">Approve</option>
                                    <option value="R">Reject</option>
                                </select>
                            </div> 
                            <div class="col-4">
                                <input type="submit" class="btn btn-primary" value="Submit" >
                            </div> 
                        </div>   

                        </div> 
                        </form>
                        </div>
                    </div>
                </div>
              </div>
            </div>
          </div>
    </div>