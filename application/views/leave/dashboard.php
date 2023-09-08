  <div class="main-panel">
        <div class="content-wrapper">
          <div class="card">
            <div class="card-body">
             <div class="row">
                <div class="col-10">
                  <h3>Leave List</h3>
                </div>
                <div class="col-2 addBtnSec">
                <small><a href="<?php echo base_url();?>index.php/leave/newLeaveApply" class="btn btn-primary">Add</a></small>
                </div>
             </div>
             <br>
              <div class="row">
                <div class="col-12">
                  <div class="table-responsive">
                    <table id="order-listing" class="table">
                      <thead>
                      <tr>
                    <th>Applied On</th>
                    <th>Docket No</th>
                    <th>Type</th>
                    <th>From Dt</th>
                    <th>To Dt</th>
                    <th>Days</th>
                    <th>Remarks</th>
                    <th>Status</th>
                    <th>Delete</th>
                    <th>Letter</th>
                    </tr>
                    </thead>
                <tbody>
                  <?php
                      foreach($data as $key)
                      {
                  ?>
              <tr>
                  <td><?php echo date("d-m-Y",strtotime($key->trans_dt)); ?></td>
                  <td><?php echo $key->docket_no; ?></td>
                  <td><?php if($key->leave_type == 'EO') { echo 'PT/MT '; }else{ echo $key->leave_type; } ?></td>
                  <td><?php echo $key->from_dt; ?></td>
                  <td><?php echo $key->to_dt; ?></td>
                  <td><?php echo $key->no_of_days;  ?></td>
                  <td><?php echo $key->remarks;  ?></td>
                  <td><?php if($key->approval_status == 'A'){ ?>
                    <span class= "badge badge-success">Approved</span>
                    <?php }elseif($key->approval_status == 'U'){ ?>
                      <span class= "badge badge-danger">Unapprove</span>
                      <?php }elseif($key->approval_status == 'R'){ ?>
                      <span class= "badge badge-danger">Rejected</span>
                      <?php }?>
                  </td>
           <td>
            <!-- <a href="<?php //echo site_url('leave/editLeaveApply?transCd='.$key->trans_cd.'&dt='.$key->trans_dt); ?>"><i class="fa fa-edit fa-fw fa-2x"></i></a>  -->
           <?php if($key->approval_status == 'U'){ ?>
           <a href="<?php echo site_url('leave/deleteLeaveApply?transCd='.$key->trans_cd.'&dt='.$key->trans_dt); ?>" onclick="return confirm('Are you sure you want to delete this item?');"><i class="fa fa-trash fa-fw fa-2x"></i></a>
           <?php } ?>
          </td>
           <td><a href="<?php echo site_url('leave/leaveletter?transCd='.$key->trans_cd.'&dt='.$key->trans_dt); ?>"target="_blank"><span class= "badge badge-success">Letter</span></a></td>
        </tr>

        <?php
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