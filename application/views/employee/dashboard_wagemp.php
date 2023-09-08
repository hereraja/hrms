  <div class="main-panel">
        <div class="content-wrapper">
          <div class="card">
            <div class="card-body">
             <div class="row">
                <div class="col-10">
                  <h3>Wages Employee List </h3>
                  <?php if($this->session->flashdata('msg')){ ?>
                <div class="alert alert-danger" role="alert">
                <?php echo $this->session->flashdata('msg'); ?>
               </div>
               <?php } ?>
               <?php if($this->session->flashdata('success')){ ?>
                <div class="alert alert-success" role="alert">
                <?php echo $this->session->flashdata('success'); ?>
               </div>
               <?php } ?>
                </div>
              
                <div class="col-1 addBtnSec">
              
                </div>
             </div>
             <br>
              <div class="row">
                <div class="col-12">
                  <div class="table-responsive" id='ajaxl'>
                    <table id="order-listing" class="table">
                      <thead>
                        <tr>
                            <th>Emp code</th>
                            <th>Name</th>
                            <th>Category</th>
                            <th>Department</th>
                            <th>District</th>
                            <th>Edit</th>
                        </tr>
                      </thead>
                      <tbody>
                       <?php 
                    
                    if($employee_dtls) {

                        
                            foreach($employee_dtls as $e_dtls) {

                    ?>
                         <tr>

                                <td><?php echo $e_dtls->emp_code; ?></td>
                                <td><?php echo $e_dtls->emp_name; ?></td>
                                <td><?php 
                                
                                    foreach($category_dtls as $c_list) {

                                        if($e_dtls->emp_catg == $c_list->category_code) {
                                            
                                            echo $c_list->category_type;

                                        }

                                    }
                                ?>
                                </td>
                                <td><?php echo $e_dtls->dept_name; ?></td>
                                <td><?php echo $e_dtls->district_name; ?></td>
                                <td>
                                <a href="westem?emp_code=<?php echo $e_dtls->emp_code; ?>" 
                                    data-toggle="tooltip"
                                    data-placement="bottom" 
                                    title="Edit">
                                    <i class="fa fa-edit fa-2x" style="color: #007bff"></i>
                                      </a>
                                </td>

                               
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

    //$("#active_status").change(function(){
    $('input[type=radio][name=active_status]').on('change', function(e){ 
      $('#ajaxl').html('');
      $.ajax({url: "<?=base_url()?>index.php/admin/ajaxemplist",
         type: "POST",
         data: {active_status : $(this).val()},
         success: function(result){
          $('#ajaxl').html(result);
          $('#order-listing').DataTable({ 
                      "destroy": true, //use for reinitialize datatable
                   });
         }
         });
    });
    
</script>