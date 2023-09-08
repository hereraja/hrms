  <div class="main-panel">
        <div class="content-wrapper">
          <div class="card">
            <div class="card-body">
             <div class="row">
                <div class="col-10">
                  <h3>Leave Allocation</h3>
                </div>
                <div class="col-2 addBtnSec">
                <small><a href="<?php echo site_url("leave/newAllocation");?>" class="btn btn-primary">Add</a></small>
                </div>
             </div>
             <br>
              <div class="row">
                <div class="col-12">
                  <div class="table-responsive">
                    <table id="order-listing" class="table">
                      <thead>
                          <tr>
                            <th>Emp No.</th>
                            <th>Emp Name</th>
                            <th>CL Balance</th>
                            <th>EL Balance</th>
                            <th>ML Balance</th>
                            <th>OD Balance</th>
                            <th>Extra ordinary Balance</th>
                            <th>Study Balance</th>
                          </tr>
                      </thead>
                      <tbody>
                       <?php 
                    
                    if($data) {  $i =0 ;
                            foreach($data as $key) {
                    ?>
                         <tr>

                         <td><?php echo $key->emp_no; ?></td>
                        <td><?php echo $key->emp_name; ?></td>
                        <td><?php echo $key->cl_bal; ?></td>
                        <td><?php echo $key->el_bal; ?></td>
                        <td><?php echo $key->ml_bal; ?></td>
                        <td><?php echo $key->od_bal; ?></td>
                        <td><?php echo $key->eo_bal; ?></td>
                        <td><?php echo $key->stu_bal; ?></td>

                        <!-- <td><a href="<?php echo site_url('leave/editLeaveAllocation?transCd='.$key->trans_cd.'&dt='.$key->trans_dt); ?>"><i class="fa fa-edit fa-fw fa-2x"></i></a></td>
                        <td><a href="<?php echo site_url('leave/deleteLeaveAllocation?transCd='.$key->trans_cd.'&dt='.$key->trans_dt); ?>" onclick="return confirm('Are you sure you want to delete this item?');"><i class="fa fa-trash fa-fw fa-2x"></i></a></td> -->

                                  </tr>
                       
                    <?php
                            }

                        }
                        else {
                            echo "<tr><td colspan='10' style='text-align: center;'>No data Found</td></tr>";
                        }
                    ?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
    </div>   
        <script>
        $(document).ready( function (){

          $('.delete').click(function () {
              var id = $(this).attr('id');
              var result = confirm("Do you really want to delete this record?");
              if(result) {
                  window.location = "<?php echo site_url('dstf?empcd="+id+"');?>";
              }
          });
        });
   
    $(document).ready(function() {

        $('.confirm-div').hide();
        <?php if($this->session->flashdata('msg')){ ?>

        $('.confirm-div').html('<?php echo $this->session->flashdata('msg'); ?>').show();

        <?php } ?>

    });
    
</script>