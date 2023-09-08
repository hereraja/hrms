<style>
    table {
        border-collapse: collapse;
    }

    table, td, th {
        border: 1px solid #dddddd;

        padding: 6px 5px;

        font-size: 11px;
    }

    th {

        text-align: center;

    }

    tr:hover {background-color: #f5f5f5;}

</style>

<script>
  function printDiv() {
    var divToPrint = document.getElementById('divToPrint');

        var WindowObject = window.open('', 'Print-Window');
        WindowObject.document.open();
        WindowObject.document.writeln('<!DOCTYPE html>');
        WindowObject.document.writeln('<html><head><title></title><style type="text/css">');


        WindowObject.document.writeln('@media print { .center { text-align: center;}' +
        'body{margin:0 0 50px 0; padding:0; background-color:red !important;}'+
        '.inline { display: inline; }' +
        '.underline { text-decoration: underline; }' +
        '.printHeaderNew{padding: 20px;}'+
        '.left { margin-left: 315px;} ' +
        '.right { margin-right: 375px; display: inline; }' +
        'table { border-collapse: collapse; font-size: 12px; margin:0 0 25px 0; background:red;}' +
        'th, td { border: 0px solid black; border-collapse: collapse; padding: 4px;}' +
        'th, td { }' + 'p { font-size: 18px; }' + 
        '.logoCustom{float:left; width:30%; text-align: left;} ' +
        '.logoTextSecRight{float:right; width:70%; text-align: center;}'+
        '.logoTextSecRight h2{font-size:14px; line-height:18px; padding:0 0 6px 0;margin: 0;}'+
        '.logoTextSecRight h2 span{font-size:12px; line-height:14px; display:block; padding:0;margin: 0; color:#333;}'+
        '.printHeaderNew{padding:0 0 10px 0;margin: 0; display:inline-block; width:100%;}'+
        '.logoTextSecRight h3{font-size:12px; line-height:16px; padding:0;margin: 0; color:#333;}'+
        '.contant-wraper table thead {background:red;}'+
        '.contant-wraper table thead tr th{border: 0px solid #dddddd; position: inherit; top: 0;}'+
        '.border { border: 0px solid black; } ' +
        '.bottom {width: 100%; position: relative;}'+
            '}</style>');
        WindowObject.document.writeln('</head><body onload="window.print()">');
        WindowObject.document.writeln(divToPrint.innerHTML);
        WindowObject.document.writeln('</body></html>');
        WindowObject.document.close();
        setTimeout(function () {
            WindowObject.close();
        }, 150);

    }

</script>
  <div class="main-panel">
        <div class="content-wrapper">
          <div class="card">
            <div class="card-body">
             <div class="row">
             <div class="col-lg-12 container contant-wraper">
                
                <div class="printHeaderNew"  id="divToPrint">
                
                <?php $leave = '';
      if($data->leave_type == 'CL'){ $leave = 'Casual Leave/leaves';}
    else if($data->leave_type == 'ML'){ $leave = 'Medical Leave/leaves';}
    else if($data->leave_type == 'EL'){ $leave = 'Earned Leave/leaves';}
    else if($data->leave_type == 'STU'){ $leave = 'Study Leave/leaves';}
    else if($data->leave_type == 'EO'){ $leave = 'Paternity/Maternity Leave/leaves';}
    ?>
               <br><br>
					<div class="col-sm-12" style="text-align:right">Date:<?php echo date("d/m/Y",strtotime($data->trans_dt));  ?></div>
               <div class="col-sm-12">
               <p style="margin-bottom:25px"><b>To</b></br>The Chief Executive Officer</br>Barrackpore Central Zone W/S CCS Ltd.</br>Madhupandit Road, Talpukur
                 </br>North 24 Parganas, Kolkata-700123</p>
                <p style="margin-bottom:15px"><b>Through,</b></br>The Manager Act.<br>Barrackpore Central Zone W/S CCS Ltd.</p>
               <p ><b>Sub:</b> Prayer for sanctionning leave/leaves.</p>
               <p > Sir,</p> 
               <p> &nbsp; &nbsp; &nbsp; &nbsp; Respectfully, it is stated that I, <?php echo $data->emp_name; ?>, employee of your esteemed Society, would
like to bring to your kind notice that I would like to avail my leave/leaves due to <?php echo $data->remarks; ?> for <?=round($data->no_of_days)?> day/days. 
             
                from <?php echo date("d/m/y",strtotime($data->from_dt)); ?> To <?php echo date("d/m/y",strtotime($data->to_dt));  ?>.
               </p></br>
               <p>&nbsp; &nbsp; &nbsp; &nbsp;Therefore, I shall be very grateful to you if you kindly approve my
 <?=$leave?>  for the said matter/issue/reason.</p>
               <br>
               <p>&nbsp; &nbsp; &nbsp; &nbsp;This is placed for your kind approval and taking necessary action.</p>
 
               <p style="text-align:right">Yours faithfully <br><?php echo $data->emp_name; ?> </p>

<p style="margin-bottom:55px"><b>Manager Note :</b> &nbsp;<?=$data->approve_label1_rmrk?></p>
 <p><b>CEO Note :</b> &nbsp;<?=$data->approve_remarks?></p>
              
                    </div>        
         
                
                
                <!-- <div  class="bottom">
                <p style="text-align:right">Date: &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; </p>
                <p style="text-align:right">Place: &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; </p><br>
                Enclo: Doctors's prescription and fit certificate in case of medical leave.
                </div> -->

            </div>   
            
            <div style="text-align: center;">

                <button class="btn btn-primary" type="button" onclick="printDiv();">Print</button>

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