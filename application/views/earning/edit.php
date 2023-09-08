      <div class="main-panel">
        <div class="content-wrapper">
          <div class="card">
            <div class="card-body">
              <h3>Edit Earning</h3>
              <div class="row">
                <div class="col-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                        <form method="POST" action="<?php echo site_url("slryed");?>" >
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-6">
                                    <label for="exampleInputName1">Date:</label>
                                    <input type="date"
                                name="sal_date"
                                class="form-control required"
                                id="sal_date"
                                value="<?php echo $earning_dtls->effective_date;?>"
                                readonly
                        />
                                    </div>
                                    <div class="col-6">
                                    <label for="exampleInputName1">Employee code:</label>
                                    <input type="text"
                                name="emp_code"
                                class="form-control required"
                                id="emp_code"
                                value="<?php echo $earning_dtls->emp_code;?>"
                                readonly
                        />

                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-6">
                                    <label for="exampleInputName1">Name:</label>
                                    <input type="text"
                                name="empname"
                                class="form-control required"
                                id="empname"
                                value="<?php echo $earning_dtls->emp_name;?>"
                                readonly
                        >
                  </div>
                                    <div class="col-6">
                                    <label for="exampleInputName1">Category:</label>
                                    <input type = "text"
                            class= "form-control"
                            name = "category"
                            id   = "category"
                            value="<?php echo $earning_dtls->category_type;?>"
                            readonly
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
                            value="<?php echo $earning_dtls->district_name;?>"
                            readonly required
                        />
                    </div>
                    <div class="col-4">
                        <label for="exampleInputName1">Basic Pay:</label>
                        <input type = "text"
                            class="form-control ded"
                            name = "basic"
                            id   = "basic"
                            value="<?php echo $earning_dtls->basic_pay;?>"
                            
                        />
                    </div>
                    <div class="col-4">
                        <label for="exampleInputName1">Garde Pay:</label>
                        <input type = "text"
                            class="form-control ded"
                            name = "grade_pay"
                            id   = "grade_pay"
                            value="<?php echo $earning_dtls->grade_pay;?>"
                            />
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <div class="col-6">
                        <label for="exampleInputName1">DA:</label>
                        <input type = "text"
                            class="form-control ded"
                            name = "da"
                            id   = "da"
                            value="<?php echo round((($earning_dtls->grade_pay+$earning_dtls->basic_pay)*$da->param_value)/100);?>"
                        />
                    </div>
                    <div class="col-6">
                        <label for="exampleInputName1">HRA:</label>
                        <input type = "text"
                            class="form-control ded"
                            name = "hra"
                            id   = "hra"
                            value="<?php echo $earning_dtls->hra_amt;?>"
                        />
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <div class="col-6">
                        <label for="exampleInputName1">Medical Allowance:</label>
                        <input type = "text"
                            class="form-control ded"
                            name = "ma"
                            id   = "ma"
                            value="<?php echo $earning_dtls->med_allow;?>"
                        />
                    </div>
                    <div class="col-6">
                        <label for="exampleInputName1">Other Allownce:</label>
                        <input type = "text"
                            class="form-control ded"
                            name = "oa"
                            id   = "oa"
                            value="<?php echo $earning_dtls->othr_allow;?>"
                        />
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                     <div class="col-4">
                        <label for="exampleInputName1">Total Earning:</label>
                        <input type = "text"
                            class= "form-control"
                            name = "" id = "tdud"  readonly
                            value = "<?php echo round($earning_dtls->basic_pay+$earning_dtls->grade_pay+$earning_dtls->da_amt+$earning_dtls->hra_amt+$earning_dtls->med_allow+$earning_dtls->othr_allow); ?>"/>
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
            $('#grade_pay').change(function(){
                    var tot_basic = 0;
                    var basic = parseFloat($('#basic').val());
                    var grade_pay = parseFloat($(this).val());
                    var har_per = '<?=$hra->param_value?>';
                    var da_per = '<?=$da->param_value?>';
                    tot_basic = parseFloat(basic+grade_pay);
                    var hra= parseFloat(tot_basic*har_per)/100;
                    var da =  parseFloat(tot_basic*da_per)/100;
                    
                    $('#hra').val(hra.toFixed()); 
                    $('#da').val(da.toFixed()); 
                
                    var sum = 0;
                        $('.ded').each(function() {
                            sum += parseFloat($(this).val());
                        });
                        //alert(sum);
                        $('#tdud').val();
                        $('#tdud').val(sum.toFixed());


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
        </script>