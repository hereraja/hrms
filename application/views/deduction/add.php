      <div class="main-panel">
        <div class="content-wrapper">
          <div class="card">
            <div class="card-body">
              <h3>Add Deductions</h3>
              <div class="row">
                <div class="col-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                        <form method="POST" id="form" action="<?php echo site_url("slrydedad");?>" >
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-6">
                                    <label for="exampleInputName1">Name:</label>
                                    <select
                                class="form-control required"
                                name="emp_code"
                                id="emp_code"
                        >

                        <option value="">Select Employee</option>

                        <?php  

                        if($emp_list) {

                            foreach ($emp_list as $e_list) {

                                foreach ($category  as $catg) {

                                    if($e_list->emp_catg == $catg->category_code) {

                        ?>        
                                <!--<option value='{"empid":"<?php echo $e_list->emp_code ?>","empname":"<?php echo $e_list->emp_name; ?>"}'

                                catg="<?php echo $catg->category_type; ?>"            
                                ><?php echo $e_list->emp_name; ?></option>-->

                                <option value="<?php echo $e_list->emp_code ?>"
                                catg="<?php echo $catg->category_type; ?>"            
                                ><?php echo $e_list->emp_name; ?></option>

                        <?php
                                    }

                                }    

                            }

                        }

                        ?>
                            
                        </select>
                                    </div>
                                    <div class="col-6">
                                    <label for="exampleInputName1">Category:</label>
                                    <input type = "text"
                            class= "form-control"
                            name = "category"
                            id   = "category"
                            readonly required
                        />

                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-4">
                                    <label for="exampleInputName1">District:</label>
                                    <input type = "text"
                            class= "form-control"
                            name = "dist"
                            id   = "dist"
                            readonly required
                        />

                  </div>
                  <div class="col-4">
                                    <label for="exampleInputName1">Basic + Grade Pay:</label>
                                    <input type = "text"
                            class= "form-control"
                            name = ""
                            id   = "basic"
                            readonly 
                        />

                  </div>
                  
                  <div class="col-4">
                        <label for="exampleInputName1">Salary Linked Insurance:</label>
                        <input type="text"
                            class= "form-control ded"
                            name = "sal_ins"
                            id   = "sal_ins"
                            value = 0.00	
                        />
                    </div>
                 
                    </div>
            </div>
            <!-- <div class="form-group">
                <div class="row">
                     div class="col-6">
                        <label for="exampleInputName1">Year:</label>
                        <input type="text" class="form-control" name="year" id="year" 
				                    value="<?php //echo date('Y');?>" readonly/>
                    </div> 
                </div>
            </div> -->
            <div class="form-group">
                <div class="row">
                    <div class="col-6">
                        <label for="exampleInputName1">Employee's Credit Co-operative Society:</label>
                        <input type = "text"
                            class= "form-control ded"
                            name = "ccs"
                            id   = "ccs"
                            value = 0.00 
                        />

                    </div>
                    <div class="col-6">
                        <label for="exampleInputName1">House Building Loan:</label>
                        <input type = "text"
                                class= "form-control ded"
                                name = "hbl"
                                id   = "hbl"
                                value = 0.00 
                            />
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <div class="col-6">
                        <label for="exampleInputName1">Telephone:</label>
                        <input type = "text"
                            class= "form-control ded"
                            name = "phone"
                            id   = "phone"
                            value = 0.00
                        />
                    </div>
                    <div class="col-6">
                        <label for="exampleInputName1">Medical Advance::</label>
                        <input type = "text"
                            class= "form-control ded"
                            name = "med_adv"
                            id   = "med_adv"
                            value = 0.00
                        />
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <div class="col-6">
                        <label for="exampleInputName1">Festival Advance:</label>
                        <input type = "text"
                            class= "form-control ded"
                            name = "fest_adv"
                            id   = "fest_adv"
                            value = 0.00
                        />
                    </div>
                    <div class="col-6">
                        <label for="exampleInputName1">Staff Welfare Advance:</label>
                        <input type = "text"
                            class= "form-control ded"
                            name = "tf"
                            id   = "tf"
                            value = 0.00
                        />
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <div class="col-6">
                        <label for="exampleInputName1">ESI/Medical Insurance:</label>
                        <input type = "text"
                            class= "form-control ded"
                            name = "med_ins"
                            id   = "med_ins"
                            value = 0.00
                        />
                    </div>
                    <div class="col-6">
                        <label for="exampleInputName1">Staff Welfare A/C:</label>
                           <input type = "text"
                                class= "form-control ded"
                                name = "comp_loan"
                                id   = "comp_loan"
                                value = 0.00
                            />

                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <div class="col-6">
                        <label for="exampleInputName1">Itax:</label>
                        <input type = "text"
                            class= "form-control ded"
                            name = "itax"
                            id   = "itax"
                            value = 0.00
                        />
                    </div>
                    <div class="col-6">
                        <label for="exampleInputName1">Office Advance</label>
                        <input type = "text"
                            class= "form-control ded"
                            name = "gpf"
                            id   = "gpf"
                            value = 0.00
                        />
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <div class="col-4">
                        <label for="exampleInputName1">EPF:</label>
                        <input type = "text"
                            class= "form-control ded"
                            name = "epf"
                            id   = "epf"
                            value = 0.00
                        />
                    </div>
                    <div class="col-4">
                        <label for="exampleInputName1">Other Deductions:</label>
                        <input type = "text"
                            class= "form-control ded"
                            name = "other_ded"
                            id   = "other_ded"
                            value = 0.00
                        />
                    </div>
                    <div class="col-4">
                        <label for="exampleInputName1">PTax:</label>
                        <input type = "text"
                            class= "form-control ded"
                            name = "ptax"
                            id   = "ptax"
                            value = 0.00
                        />
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                     <div class="col-4">
                        <label for="exampleInputName1">Total deduction:</label>
                        <input type = "text"
                            class= "form-control"
                            name = "" id = "tdud"  readonly
                            value = ""/>
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

    // $("#form").validate({
    //     rules: {
    //         sal_yr: "required",
    //     },
    //     messages: {
    //         sal_yr: "Please enter valid input"
    //     }
        
    // });


</script>

<script>

    $(document).ready(function(){

        $('#emp_code').change(function(){

            $('#category').val($(this).find(':selected').attr('catg'));

            $.get(
                '<?php echo site_url("Salary/f_emp_dtls"); ?>',
                {
                    emp_code: $(this).val() 
                }
            )

            .done(function(data){
                var parseData = JSON.parse(data);
                console.log(parseData );
                $('#dist').val(parseData.district_name) 

            });

        });


        $('.ded').change(function(){
            var sum = 0;
            $('.ded').each(function() {
                sum += parseFloat($(this).val());
            });
            //alert(sum);
            $('#tdud').val();
            $('#tdud').val(sum.toFixed());
        })

    });
    
</script>


<script>
	
	$(document).ready(function(){
	
	
		var basic  = 0.00;
        var netsal = 0.00;
        var basic_da = 0.00;
        var sum = 0.00;
		
		$('#emp_code').change(function(){
	
			$.get( 
	
				'<?php echo site_url("Salary/f_sal_ded_dtls");?>',
				{ 
	
					emp_code: $(this).val()
                    // rbt_add =$('#rbt_add').val() 	
				}
	
			)
			.done(function(data){
				var parseData = JSON.parse(data);
				
                $('#basic').val(parseFloat(parseData.basic_pay)+parseFloat(parseData.grade_pay)) 
                $('#da').val(parseData.da) 
                $('#hra').val(parseData.hra) 
                $('#ma').val(parseData.ma);
               
                var epfrate = "<?php echo epfrate() ?>";
                
                netsal = parseFloat(parseData.basic_pay)+parseFloat(parseData.grade_pay)+parseFloat(parseData.da)+parseFloat(parseData.hra)+parseFloat(parseData.ma); 
                basic_da = parseFloat(parseData.basic_pay)+parseFloat(parseData.da)+parseFloat(parseData.grade_pay);
              //alert(basic_da);
				//alert(epfrate);
                $('#epf').val(parseFloat((basic_da)*epfrate).toFixed());
           
                $('#med_ins').val(parseFloat(netsal*.0075).toFixed());
                if(netsal >= 10000 && netsal <= 15000){
                    $('#ptax').val(110);
                
                }else if(netsal >= 15001 && netsal <= 25000){
                    $('#ptax').val(130);
               
                }else if(netsal >= 25001 && netsal <= 40000){
                    $('#ptax').val(150);
                
                }else if(netsal >= 40001){
             
                    $('#ptax').val(200);
                }

                $('.ded').each(function() {
                sum += parseFloat($(this).val());
                    });
                   
                    $('#tdud').val();
                    $('#tdud').val(sum.toFixed());

                    });
            
	
		});
	
	});
	
</script>
