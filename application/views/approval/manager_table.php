  <div class="main-panel">
        <div class="content-wrapper">
          <div class="card">
            <div class="card-body">
             <div class="row">
                <div class="col-10">
                  <h3>Leave Approval</h3>
                </div>
                <div class="col-2 addBtnSec">
                <small><a href="<?php echo base_url();?>index.php/adept" class="btn btn-primary">Add</a></small>
                </div>
             </div>
             <br>
              <div class="row">
                <div class="col-12">
                  <div class="table-responsive">
                    <table id="order-listing" class="table">
                    <thead>

                      <tr>
                          <th>Docket No</th>
                          <th>Employee Name</th>
                          <th>Type</th>
                          <th>Days</th>
                          <th>View</th>
                      </tr>

                      </thead>

                      <tbody>

                      <?php
                          foreach($data as $key)
                          {
                      ?>
                          <tr>

                              <td><?php echo $key->docket_no; ?></td>
                              <td><?php echo $key->emp_name; ?></td>
                              <td><?php echo $key->leave_type; ?></td>
                              <td><?php echo $key->no_of_days; ?></td>
                              
                              <td><a href="<?php echo site_url('leave/managerapproveLeave?transCd='.$key->trans_cd.'&dt='.$key->trans_dt); ?>"><i class="fa fa-eye fa-fw fa-2x"></i></a></td>
                              
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