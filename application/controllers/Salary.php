<?php

	class Salary extends CI_Controller{

		public function __construct(){
			parent::__construct();
            if(!isset($this->session->userdata('loggedin')['user_id'])){
            
                redirect('Payroll_Login/login');

            }

			$this->load->model('Login_Process');

			$this->load->model('Salary_Process');

            $this->load->model('Admin_Process');
	}
    
    public function earning() {                     //Dashboard

        $earning['earning_dtls']=$this->Salary_Process->f_get_earning();
        $this->load->view('post_login/payroll_main');
        $this->load->view("earning/dashboard", $earning);
        $this->load->view('post_login/footer');

    }

    public function earning_add() {                 //Add

        if($_SERVER['REQUEST_METHOD'] == "POST") {
            $query = null; //emptying in case
            $query = $this->db->get_where('td_income', array('emp_code' => trim($this->input->post('emp_code'))));
            $count = $query->num_rows(); //counting result from query
		
		    if ($count === 0) {
            
            $emp_cd     =   $this->input->post('emp_code');

            $category   =   $this->input->post('category');

            $basic      =   $this->input->post('basic');

            $da         =   $this->input->post('da');

            $hra        =   $this->input->post('hra');

            $ma         =   $this->input->post('ma');

            $oa         =   $this->input->post('oa');

            //For Current Date
            $sal_date   =   $_SESSION['sys_date'];
    
            $data_array  = array (

                    "effective_date" =>  $sal_date,

                    "emp_code"       =>  $emp_cd,

                    "basic_pay"      =>  $basic,

                    'grade_pay'      => trim($this->input->post('grade_pay')),

                    "da_amt"         =>  $da,

                    "hra_amt"        =>  $hra,

                    "med_allow"      =>  $ma,

                    "othr_allow"     =>  $oa,

                    "created_by"     =>  $this->session->userdata['loggedin']['user_id'],

                    "created_dt"     =>  date('Y-m-d h:i:s')

                );
            

            $this->Salary_Process->f_insert('td_income', $data_array);

            $this->session->set_flashdata('msg', 'Successfully Added!');

            redirect('slrydtl');
            }else{
               $this->session->set_flashdata('msg', 'Employee Exist');
                redirect('slrydtl');
            }

        }

        else {
            
            //For Current Date
            $earning['sys_date']   =   $_SESSION['sys_date'];

            //For Employee List
            unset($select);
            $select = array ("emp_code", "emp_name", "emp_catg","emp_dist");

            //Employee List
            $earning['emp_list']   =   $this->Salary_Process->f_get_particulars("md_employee", $select, array("emp_status" => 'A','1 order by emp_name'=>NULL), 0);

            //Category List
            $earning['category']   =   $this->Salary_Process->f_get_particulars("md_category", NULL, NULL, 0);

            $earning['dist']       =   $this->Salary_Process->f_get_particulars("md_district", NULL, NULL, 0);
            $earning['hra']        =   $this->Salary_Process->f_get_particulars("md_parameters", array('param_value'),array('sl_no'=>2),1);
            $earning['da']         =   $this->Salary_Process->f_get_particulars("md_parameters", array('param_value'),array('sl_no'=>1), 1);
            $earning['med']        =   $this->Salary_Process->f_get_particulars("md_parameters", array('param_value'),array('sl_no'=>3), 1);

            $this->load->view('post_login/payroll_main');
            $this->load->view("earning/add", $earning);
            $this->load->view('post_login/footer');
        }
    }

    public function f_sal_dtls(){                      //Salary earning amounts

        $emp_code = $this->input->get('emp_code');
    
        $data     = $this->Salary_Process->f_sal_dtls($emp_code);
   
        echo json_encode($data);
    }
    public function f_sal_ded_dtls(){                      //Salary earning amounts

        $emp_code = $this->input->get('emp_code');
    
        $data     = $this->Salary_Process->f_sal_ded_dtls($emp_code);
   
        echo json_encode($data);
    }

    public function f_emp_dtls(){                   //Employee Details 

        $emp_code = $this->input->get('emp_code');

        $select   = array(
            "a.emp_code","a.emp_name","a.emp_catg","b.district_name","c.category_type"
        );

        $where    = array(
            "a.emp_dist = b.district_code" => NULL,
            "a.emp_catg = c.category_code" => NULL,
            "a.emp_code" => $emp_code
        );

        $data = $this->Salary_Process->f_get_particulars("md_employee a,md_district b,md_category c",$select,$where,1);

        echo json_encode($data);
    }

    public function earning_edit(){                                         //Edit

        if($_SERVER['REQUEST_METHOD'] == "POST") {

            $sal_date   =   $this->input->post('sal_date');
            
            $emp_cd     =   $this->input->post('emp_code');

            $da         =   $this->input->post('da');

            $hra        =   $this->input->post('hra');

            $ma         =   $this->input->post('ma');

            $oa         =   $this->input->post('oa');

            $data_array = array (
                  
                   "basic_pay"      =>  trim($this->input->post('basic')),

                    'grade_pay'      => trim($this->input->post('grade_pay')),

                    "da_amt"         =>  $da,

                    "hra_amt"        =>  $hra,

                    "med_allow"      =>  $ma,

                    "othr_allow"     =>  $oa,

                    "modified_by"    => $this->session->userdata['loggedin']['user_id'],

                    "modified_dt"    =>  date('Y-m-d h:i:s')

            );

            $where = array(

                "emp_code"           =>  $emp_cd,

                "effective_date"     =>  $sal_date

            );
            
            $this->session->set_flashdata('msg', 'Successfully Updated!');

            $this->Salary_Process->f_edit('td_income', $data_array, $where);

            redirect('slrydtl');

        }

        else {

            $select = array(
                "a.*","b.*","c.*","d.*"
            );

            $where = array(
                "a.emp_code = b.emp_code"           =>  NULL,

                "a.emp_catg = c.category_code"      => NULL,

                "a.emp_dist = d.district_code"      => NULL,

                "b.effective_date"                  =>  $this->input->get('date'),

                "a.emp_code"                        =>  $this->input->get('emp_code')

            );

            $earning['earning_dtls']  = $this->Salary_Process->f_get_particulars("md_employee a,td_income b,md_category c,md_district d", NULL, $where, 1);
            $earning['hra']        =   $this->Salary_Process->f_get_particulars("md_parameters", array('param_value'),array('sl_no'=>2),1);
            $earning['da']         =   $this->Salary_Process->f_get_particulars("md_parameters", array('param_value'),array('sl_no'=>1), 1);
            $earning['med']        =   $this->Salary_Process->f_get_particulars("md_parameters", array('param_value'),array('sl_no'=>3), 1);
            $this->load->view('post_login/payroll_main');
            $this->load->view("earning/edit", $earning);
            $this->load->view('post_login/footer');

        }
    }

    public function earning_delete(){                      //Delete income

        $where = array(
            
            "emp_code"          =>  $this->input->get('emp_code'),

            "effective_date"    =>  $this->input->get('effective_date')
            
        );

        $this->session->set_flashdata('msg', 'Successfully Deleted!');

        $this->Salary_Process->f_delete('td_income', $where);

        redirect("slrydtl");   
    }

    public function deduction() {                       //Deduction Dashboard

        $select =   array(
            "a.*","b.*","c.district_name"
        );

        $where = array(
            "a.emp_code     = b.emp_cd" => NULL,
            "a.emp_dist     = c.district_code" => NULL,
            //"a.emp_status != 'R'"   => NULL,
            "(a.emp_status = 'A' OR a.emp_status = 'S')"=> NULL
        );

        $deduction['deduction_dtls']    =   $this->Salary_Process->f_get_particulars("md_employee a,td_deductions b,md_district c",$select,$where,0);

        $this->load->view('post_login/payroll_main');

        $this->load->view("deduction/dashboard", $deduction);

        $this->load->view('post_login/footer');
    }

    public function deduction_add() {                       //Add Dedcutions

        if($_SERVER['REQUEST_METHOD'] == "POST") {

            $query = null; //emptying in case
            $query = $this->db->get_where('td_deductions', array('emp_cd' => trim($this->input->post('emp_code'))));
            $count = $query->num_rows(); //counting result from query
		
		    if ($count === 0) {
            
            $data_array = array (
                "emp_cd"           =>  $this->input->post('emp_code'),
                // "ded_yr"           =>  $this->input->post('year'),
                // "ded_month"        =>  $this->input->post('month'),
                "insuarance"       =>  $this->input->post('sal_ins'),

                "ccs"              =>  $this->input->post('ccs'),

                "hbl"              =>  $this->input->post('hbl'),

                "telephone"        =>  $this->input->post('phone'),

                "med_adv"          =>  $this->input->post('med_adv'),

                "festival_adv"     =>  $this->input->post('fest_adv'),

                "tf"               =>  $this->input->post('tf'),

                "med_ins"          =>  $this->input->post('med_ins'),

                "comp_loan"        =>  $this->input->post('comp_loan'),

                "itax"             =>  $this->input->post('itax'),

                "gpf"              =>  $this->input->post('gpf'),

                "epf"              =>  $this->input->post('epf'),

                "other_deduction"  =>  $this->input->post('other_ded'),

                "ptax"             =>  $this->input->post('ptax'),

                "created_by"       =>  $this->session->userdata['loggedin']['user_id'],

                "created_dt"       =>  date('Y-m-d h:i:s')

            );  

            $this->Salary_Process->f_insert('td_deductions', $data_array);

            $this->session->set_flashdata('msg', 'Successfully Added!');

            redirect('slryded');
          }else{
             $this->session->set_flashdata('msg', 'Employee Exist!');
            redirect('slryded');
          }

        }

        else {
            
            $deduction['month_list'] =   $this->Salary_Process->f_get_particulars("md_month",NULL, NULL, 0);

            $deduction['sys_date']   =   $_SESSION['sys_date'];

            unset($select);
            $select = array ("emp_code", "emp_name", "emp_catg","emp_dist");

            $where  = array (

		    "emp_catg in (1,2)"  => null,
		     "emp_status"	   => 'A',
             '1 order by emp_name'=>NULL

            );
	
            $deduction['emp_list']   =   $this->Salary_Process->f_get_particulars("md_employee", $select, $where, 0);

	        $deduction['category']   =   $this->Salary_Process->f_get_particulars("md_category", NULL, NULL, 0);

            $this->load->view('post_login/payroll_main');

            $this->load->view("deduction/add", $deduction);

            $this->load->view('post_login/footer');

        }

    }

    public function deduction_edit(){                                     //Edit Deductions

        if($_SERVER['REQUEST_METHOD'] == "POST") {

            $emp_cd     =   $this->input->post('emp_code');

            $data_array = array (

                // "ded_yr"           =>  $this->input->post('year'),

                // "ded_month"        =>  $this->input->post('month'),

                "insuarance"       =>  $this->input->post('sal_ins'),

                "ccs"              =>  $this->input->post('ccs'),

                "hbl"              =>  $this->input->post('hbl'),

                "telephone"        =>  $this->input->post('phone'),

                "med_adv"          =>  $this->input->post('med_adv'),

                "festival_adv"     =>  $this->input->post('fest_adv'),

                "tf"               =>  $this->input->post('tf'),

                "med_ins"          =>  $this->input->post('med_ins'),

                "comp_loan"        =>  $this->input->post('comp_loan'),

                "itax"             =>  $this->input->post('itax'),

                "gpf"              =>  $this->input->post('gpf'),

                "epf"              =>  $this->input->post('epf'),

                "other_deduction"  =>  $this->input->post('other_ded'),

                "ptax"             =>  $this->input->post('ptax'),

                "modified_by"      =>  $this->session->userdata['loggedin']['user_id'],

                "modified_dt"      =>  date('Y-m-d h:i:s')

            );


            $where = array(

                "emp_cd"       =>  $emp_cd

            );
           // print_r($data_array);die();
            $this->session->set_flashdata('msg', 'Successfully Updated!');

            $this->Salary_Process->f_edit('td_deductions', $data_array, $where);

            redirect('slryded');

        }

        else {

            $emp_cd     =   $this->input->get('emp_cd');

            $select = array(

                "a.*","b.*","c.*","d.*"

            );

            $where = array(

                "a.emp_code = b.emp_cd"         => NULL,
                
                "a.emp_dist = c.district_code"  => NULL,

                "a.emp_catg = d.category_code"  => NULL,

                "b.emp_cd"                      =>  $emp_cd

            );

            $deduction['month_list']        =   $this->Salary_Process->f_get_particulars("md_month", NULL, NULL, 0);
			$deduction['epf_rate']        =   $this->Salary_Process->f_get_particulars("md_parameters", NULL, array('sl_no'=>4), 1);
            
            $deduction['deduction_dtls']    =   $this->Salary_Process->f_get_particulars("md_employee a,td_deductions b,md_district c,md_category d", NULL, $where, 1);

            $this->load->view('post_login/payroll_main');

            $this->load->view("deduction/edit", $deduction);

            $this->load->view('post_login/footer');

        }
    }

    public function deduction_delete(){                   //Delete

        $where = array(
            
            "emp_cd"    =>  $this->input->get('empcd')
            
        );

        $this->session->set_flashdata('msg', 'Successfully Deleted!');

        $this->Salary_Process->f_delete('td_deductions', $where);

        redirect("slryded");
        
    }


    public function generation_delete(){      //unapprove salary slip delete       

        $where = array(
            
            "trans_date"  =>  $this->input->get('date'),

            "trans_no"    =>  $this->input->get('trans_no'),

            "sal_month"   => $this->input->get('month'),

            "sal_year"    =>  $this->input->get('year')  ,
            
            "approval_status" =>'U'
        );

        $this->session->set_flashdata('msg', 'Successfully Deleted!');

        $this->Salary_Process->f_delete('td_salary', $where);

        $this->Salary_Process->f_delete('td_pay_slip', $where);
       
        redirect('genspl');
    }



    public function generate_slip() {                                //Payslip Generation

        //Generation Details
        $generation['generation_dtls']  =   $this->Salary_Process->f_get_particulars("td_salary", NULL, array("approval_status" => 'U'), 0);
        //Category List
        $generation['category']         =   $this->Salary_Process->f_get_particulars("md_category", NULL, NULL, 0);

        $this->load->view('post_login/payroll_main');

        $this->load->view("generation/dashboard", $generation);

        $this->load->view('post_login/footer');

    }
    public function get_required_yearmonth(){

        $category = $this->input->post('category');
        //$max_year =   $this->Salary_Process->f_get_particulars("td_salary", NULL, array( "approval_status" => 'A','catg_cd'=>$category,'1 order by sal_year,sal_month desc limit 1'=> NULL), 1);
        $max_year = $this->Salary_Process->f_get_generation();
        if($max_year->sal_month == 12){
            $data['year'] = ($max_year->sal_year)+1;
            $data['month'] = 1;
            $data['monthn'] = 'January';

        }else{
            $data['year'] = $max_year->sal_year;
            $data['month'] = ($max_year->sal_month)+1;
            $data['monthn'] = $this->Salary_Process->f_get_particulars("md_month", NULL, array('id'=>$data['month']), 1)->month_name;
        }

        echo  json_encode($data);
    }

    public function generation_add() {

        if($_SERVER['REQUEST_METHOD'] == "POST") {

            $trans_dt     =   $this->input->post('sal_date');

            $sal_month    =   $this->input->post('month');

            $year         =   $this->input->post('year');

            $category     =   $this->input->post('category');

            //Check given category exsit or not
            //for given month and date
            $select     =   array("catg_cd");

            $where      =   array(

                "catg_cd"       =>  $category,
                
                "sal_month"     =>  $sal_month,

                "sal_year"      =>  $year
            
            );

            $flag     =   $this->Salary_Process->f_get_particulars("td_salary", $select, $where, 1);

            if($flag) {

                $this->session->set_flashdata('msg', 'For this month and category Payslip already generated!');

            }

            else {

                if($category == 4){

                    $select     =   array("MAX(trans_no) trans_no");
                $where      =   array(
                    "trans_date"    =>  $trans_dt,
                    "sal_month"     =>  $sal_month,
                    "sal_year"      =>  $year
                );
                
                $trans_no     =   $this->Salary_Process->f_get_particulars("td_salary", $select, $where, 1);

                $data_array = array (
                    "trans_date"   =>  $trans_dt,
                    "trans_no"     =>  ($trans_no != NULL)? ($trans_no->trans_no + 1):'1',
                    "sal_month"    =>  $sal_month,
                    "sal_year"     =>  $year,
                    "catg_cd"      =>  $category,
                    "created_by"   =>  $this->session->userdata['loggedin']['user_id'],
                    "created_dt"   =>  date('Y-m-d h:i:s')
                );
                
                $this->Salary_Process->f_insert("td_salary", $data_array);
                //Retriving Employee list
                //$emp_dtls    =   $this->Payroll->f_get_particulars("md_doublesal", $select, $where, 0);
                $emp_dtls    =   $this->Salary_Process->f_get_particulars('md_employee',NULL,array('emp_catg'=> 4,'emp_status'=>'A'),0);
                $wages       =   $this->Salary_Process->f_get_particulars('md_parameters',array('param_value'),array('sl_no'=> 7),1);
                //If Present then employee(s) details will inserted in the td_pay_slip table
                if($emp_dtls) {

                    $tot_ded = 0; $tot_ear = 0 ;
                    foreach($emp_dtls as $e_list) {
                   
                        $salary_array  =   array(
                            "trans_date"     =>  $trans_dt,
                            "trans_no"       =>  ($trans_no != NULL)? ($trans_no->trans_no + 1):'1',
                            "sal_month"      =>  $sal_month,
                            "sal_year"       =>  $year,
                            "emp_no"         =>  $e_list->emp_code,
                            "no_of_days"     =>  $e_list->no_of_days,
                            "daily_wages"    =>  $wages->param_value,
                            "basic_pay"      =>  round($wages->param_value*$e_list->no_of_days),
                            "da_amt"         =>  0,
                            "hra_amt"        =>  0,
                            "med_allow"      =>  0,
                            "othr_allow"     =>  0,
                            "insuarance"     =>  0,
                            "ccs"            =>  0,
                            "hbl"            =>  0,
                            "telephone"      =>  0,
                            "med_adv"        =>  0,
                            "festival_adv"   =>  0,
                            "tf"             =>  0,
                            "med_ins"        =>  0,
                            "comp_loan"      =>  0,
                            "ptax"           =>  0,
                            "itax"           =>  0,
                            "gpf"            =>  0,
                            "epf"            =>  round((round($wages->param_value*$e_list->no_of_days)*12)/100),
                            "esi"             => round(((round($wages->param_value*$e_list->no_of_days)*75)/10000),2),
                            "other_deduction" => 0,
                            "tot_deduction"   => 0,
                            "net_amount"      => 0
                        );
                        $this->Salary_Process->f_insert("td_pay_slip", $salary_array);
                        $tot_ded = 0; $tot_ear = 0 ;
                    }
                }
                $this->session->set_flashdata('msg', 'Successfully generated!');

                }else{

                //Retrive max trans no
                $select     =   array("MAX(trans_no) trans_no");
                $where      =   array(
                    "trans_date"    =>  $trans_dt,
                    "sal_month"     =>  $sal_month,
                    "sal_year"      =>  $year
                );
                
                $trans_no     =   $this->Salary_Process->f_get_particulars("td_salary", $select, $where, 1);

                $data_array = array (
                    "trans_date"   =>  $trans_dt,
                    "trans_no"     =>  ($trans_no != NULL)? ($trans_no->trans_no + 1):'1',
                    "sal_month"    =>  $sal_month,
                    "sal_year"     =>  $year,
                    "catg_cd"      =>  $category,
                    "created_by"   =>  $this->session->userdata['loggedin']['user_id'],
                    "created_dt"   =>  date('Y-m-d h:i:s')
                );
                
                $this->Salary_Process->f_insert("td_salary", $data_array);
                //Retriving Employee list
                //$emp_dtls    =   $this->Payroll->f_get_particulars("md_doublesal", $select, $where, 0);
                $emp_dtls    =   $this->Salary_Process->get_emp_for_salary($category);
              
                //If Present then employee(s) details will inserted in the td_pay_slip table
                if($emp_dtls) {

                    unset($data_array);
                    $tot_ded = 0; $tot_ear = 0 ;
                    foreach($emp_dtls as $e_list) {
                    $tot_ded = round($e_list->ded_insuarance + $e_list->ded_ccs + $e_list->ded_hbl + $e_list->ded_telephone + $e_list->ded_med_adv + $e_list->ded_festival_adv + $e_list->ded_tf + $e_list->ded_med_ins + $e_list->ded_comp_loan + $e_list->ded_ptax + $e_list->ded_itax + $e_list->ded_gpf + $e_list->ded_epf + $e_list->ded_other_deduction);
                    $tot_ear = round($e_list->er_basic_pay+$e_list->er_grade_pay+$e_list->er_da+$e_list->er_hra+$e_list->er_med_allow +$e_list->er_othr_allow);
                        $salary_array  =   array(

                            "trans_date"     =>  $trans_dt,
                            "trans_no"       =>  ($trans_no != NULL)? ($trans_no->trans_no + 1):'1',
                            "sal_month"      =>  $sal_month,
                            "sal_year"       =>  $year,
                            "emp_no"         =>  $e_list->emp_code,
                            "basic_pay"      =>  round($e_list->er_basic_pay),
                            "grade_pay"      =>  round($e_list->er_grade_pay),
                            "da_amt"         =>  round($e_list->er_da),
                            "hra_amt"        =>  round($e_list->er_hra),
                            "med_allow"      =>  round($e_list->er_med_allow),
                            "othr_allow"     =>  round($e_list->er_othr_allow),
                            "insuarance"     =>  round($e_list->ded_insuarance),
                            "ccs"            =>  round($e_list->ded_ccs),
                            "hbl"            =>  round($e_list->ded_hbl),
                            "telephone"      =>  round($e_list->ded_telephone),
                            "med_adv"        =>  round($e_list->ded_med_adv),
                            "festival_adv"   =>  round($e_list->ded_festival_adv),
                            "tf"             =>  round($e_list->ded_tf),
                            "med_ins"        =>  round($e_list->ded_med_ins),
                            "comp_loan"      =>  round($e_list->ded_comp_loan),
                            "ptax"           =>  round($e_list->ded_ptax),
                            "itax"           =>  round($e_list->ded_itax),
                            "gpf"            =>  round($e_list->ded_gpf),
                            "epf"            =>  round($e_list->ded_epf),
                            "other_deduction" => round($e_list->ded_other_deduction),
                            "tot_deduction"   => round($tot_ded),
                            "net_amount"      => round($tot_ear -  $tot_ded)
                        );
                        $this->Salary_Process->f_insert("td_pay_slip", $salary_array);
                        $tot_ded = 0; $tot_ear = 0 ;
                    }
                }
                $this->session->set_flashdata('msg', 'Successfully generated!');
               }


            }

            redirect('genspl');


        }

        else {

            //Month List
            $generation['month_list'] =   $this->Salary_Process->f_get_particulars("md_month",NULL, NULL, 0);

            //For Current Date
            $generation['sys_date']   =   $_SESSION['sys_date'];

            //Last payslip generation date
            $generation['generation_dtls']    =   $this->Salary_Process->f_get_generation();

            //Category List
	        $generation['category']   =   $this->Salary_Process->f_get_particulars("md_category", NULL, NULL, 0);

            $this->load->view('post_login/payroll_main');

            $this->load->view("generation/add", $generation);

            $this->load->view('post_login/footer');

        }
        
    }


    


   
  /*************************REPORTS**************************/

    //For Categorywise Salary Report
    public function f_salary_report() {

        if($_SERVER['REQUEST_METHOD'] == "POST") {


            //Employee Ids for Salary List
            $select     =   array("emp_code");

            $where      =   array(

                "emp_catg"  =>  $this->input->post('category')

            );

            $emp_id     =   $this->Payroll->f_get_particulars("md_employee", $select, $where, 0);

            //Temp variable for emp_list
            $eid_list   =   [];

            for($i = 0; $i < count($emp_id); $i++) {

                array_push($eid_list, $emp_id[$i]->emp_code);

            }


            //List of Salary Category wise
            unset($where);
            $where = array (

                "sal_month"     =>  $this->input->post('sal_month'),

                "sal_year"      =>  $this->input->post('year')

            );

            $salary['list']               =   $this->Payroll->f_get_particulars_in("td_pay_slip", $eid_list, $where);

            $salary['attendance_dtls']    =   $this->Payroll->f_get_attendance();

            //Employee Group Count
            unset($select);
            unset($where);

            $select =   array(

                "emp_no", "emp_name", "COUNT(emp_name) count"

            );

            $where  =   array(

                "sal_month"     =>  $this->input->post('sal_month'),

                "sal_year = '".$this->input->post('year')."' GROUP BY emp_no, emp_name"      =>  NULL

            );

            $salary['count']              =   $this->Payroll->f_get_particulars("td_pay_slip", $select, $where, 0);

            $this->load->view('post_login/main');

            $this->load->view("reports/salary", $salary);

            $this->load->view('post_login/footer');

        }

        else {

            //Month List
            $salary['month_list'] =   $this->Payroll->f_get_particulars("md_month",NULL, NULL, 0);

            //For Current Date
            $salary['sys_date']   =   $_SESSION['sys_date'];

            //Category List
            $salary['category']   =   $this->Payroll->f_get_particulars("md_category", NULL, array('category_code IN (1,2,3)' => NULL), 0);

            $this->load->view('post_login/main');

            $this->load->view("reports/salary", $salary);

            $this->load->view('post_login/footer');

        }

    }
//////////////////////////////////////////////////////////////////////////
public function f_salaryold_report() {

    if($_SERVER['REQUEST_METHOD'] == "POST") {


        //Employee Ids for Salary List
        $select     =   array("emp_code");

        $where      =   array(

            "emp_catg"  =>  $this->input->post('category')

        );

        $emp_id     =   $this->Payroll->f_get_particulars("md_employee", $select, $where, 0);

        //Temp variable for emp_list
        $eid_list   =   [];

        for($i = 0; $i < count($emp_id); $i++) {

            array_push($eid_list, $emp_id[$i]->emp_code);

        }


        //List of Salary Category wise
        unset($where);
        $where = array (

            "sal_month"     =>  $this->input->post('sal_month'),

            "sal_year"      =>  $this->input->post('year')

        );

        $salary['list']               =   $this->Payroll->f_get_particulars_in("td_pay_slip_old ", $eid_list, $where);

        $salary['attendance_dtls']    =   $this->Payroll->f_get_attendance();

        //Employee Group Count
        unset($select);
        unset($where);

        $select =   array(

            "emp_no", "emp_name", "COUNT(emp_name) count"

        );

        $where  =   array(

            "sal_month"     =>  $this->input->post('sal_month'),

            "sal_year = '".$this->input->post('year')."' GROUP BY emp_no, emp_name"      =>  NULL

        );

        $salary['count']              =   $this->Payroll->f_get_particulars("td_pay_slip_old ", $select, $where, 0);

        $this->load->view('post_login/main');

        $this->load->view("reports/salaryold", $salary);

        $this->load->view('post_login/footer');

    }

    else {

        //Month List
        $salary['month_list'] =   $this->Payroll->f_get_particulars("md_month",NULL, NULL, 0);

        //For Current Date
        $salary['sys_date']   =   $_SESSION['sys_date'];

        //Category List
        $salary['category']   =   $this->Payroll->f_get_particulars("md_category", NULL, array('category_code IN (1,2,3)' => NULL), 0);

        $this->load->view('post_login/main');

        $this->load->view("reports/salaryold", $salary);

        $this->load->view('post_login/footer');

    }

}
//////////////////////////////////////////////////////////////////////////
    //For Payslip Report
    public function f_payslip_report() {

        if($_SERVER['REQUEST_METHOD'] == "POST") {

            //Payslip
            $where  =   array(

                "emp_no"            =>  $this->input->post('emp_cd'),

                "sal_month"         =>  $this->input->post('sal_month'),

                "sal_year"          =>  $this->input->post('year'),

                "approval_status"   =>  'A'

            );

            $payslip['emp_dtls']    =   $this->Payroll->f_get_particulars("md_employee", NULL, array("emp_code" =>  $this->input->post('emp_cd')), 1);

            $payslip['payslip_dtls']=   $this->Payroll->f_get_particulars("td_pay_slip", NULL, $where, 1);

            $this->load->view('post_login/main');

            $this->load->view("reports/payslip", $payslip);

            $this->load->view('post_login/footer');

        }
        
        else {

            //Month List
            $payslip['month_list'] =   $this->Payroll->f_get_particulars("md_month",NULL, NULL, 0);

            //For Current Date
            $payslip['sys_date']   =   $_SESSION['sys_date'];

            //Employee List
            unset($select);
            $select = array ("emp_code", "emp_name");

            $payslip['emp_list']   =   $this->Payroll->f_get_particulars("md_employee", $select, array("emp_catg IN (1,2,3)" => NULL), 0);

            $this->load->view('post_login/main');

            $this->load->view("reports/payslip", $payslip);

            $this->load->view('post_login/footer');
            
        }

    }

//////////////////////////////////////////////////////////////////

public function f_payslipold_report() {

    if($_SERVER['REQUEST_METHOD'] == "POST") {

        //Payslip
        $where  =   array(

            "emp_no"            =>  $this->input->post('emp_cd'),

            "sal_month"         =>  $this->input->post('sal_month'),

            "sal_year"          =>  $this->input->post('year'),

            "approval_status"   =>  'A'

        );

        $payslip['emp_dtls']    =   $this->Payroll->f_get_particulars("md_employee", NULL, array("emp_code" =>  $this->input->post('emp_cd')), 1);

        $payslip['payslip_dtls']=   $this->Payroll->f_get_particulars("td_pay_slip_old ", NULL, $where, 1);

        $this->load->view('post_login/main');

        $this->load->view("reports/payslipold", $payslip);

        $this->load->view('post_login/footer');

    }
    
    else {

        //Month List
        $payslip['month_list'] =   $this->Payroll->f_get_particulars("md_month",NULL, NULL, 0);

        //For Current Date
        $payslip['sys_date']   =   $_SESSION['sys_date'];

        //Employee List
        unset($select);
        $select = array ("emp_code", "emp_name");

        $payslip['emp_list']   =   $this->Payroll->f_get_particulars("md_employee", $select, array("emp_catg IN (1,2,3)" => NULL), 0);

        $this->load->view('post_login/main');

        $this->load->view("reports/payslipold", $payslip);

        $this->load->view('post_login/footer');
        
    }

}

    //For Salary Statement
    public function f_statement_report(){

        if($_SERVER['REQUEST_METHOD'] == 'POST') {

            //Employees salary statement
            $select = array(

                "m.emp_name", "m.bank_ac_no",
                
                "t.net_amount"

            );

            $where  = array(

                "m.emp_code = t.emp_no" =>  NULL,

                "t.sal_month"           =>  $this->input->post('sal_month'),

                "t.sal_year"            =>  $this->input->post('year'),

                "m.emp_catg"            =>  $this->input->post('category'),

                "m.emp_status"          =>  'A',

                "m.deduction_flag"      =>  'Y'

            );

            $statement['statement'] =   $this->Payroll->f_get_particulars("md_employee m, td_pay_slip t", $select, $where, 0);

            $this->load->view('post_login/main');

            $this->load->view("reports/statement", $statement);

            $this->load->view('post_login/footer');

        }

        else {

            //Month List
            $statement['month_list'] =   $this->Payroll->f_get_particulars("md_month",NULL, NULL, 0);

            //Category List
            $statement['category']   =   $this->Payroll->f_get_particulars("md_category", NULL, array('category_code IN (1,2,3)' => NULL), 0);

            $this->load->view('post_login/main');

            $this->load->view("reports/statement", $statement);

            $this->load->view('post_login/footer');

        }

    }
//////////////////////////////////////
public function f_statementold_report(){

    if($_SERVER['REQUEST_METHOD'] == 'POST') {

        //Employees salary statement
        $select = array(

            "m.emp_name", "m.bank_ac_no",
            
            "t.net_amount"

        );

        $where  = array(

            "m.emp_code = t.emp_no" =>  NULL,

            "t.sal_month"           =>  $this->input->post('sal_month'),

            "t.sal_year"            =>  $this->input->post('year'),

            "m.emp_catg"            =>  $this->input->post('category'),

            "m.emp_status"          =>  'A',

            "m.deduction_flag"      =>  'Y'

        );

        $statement['statement'] =   $this->Payroll->f_get_particulars("md_employee m, td_pay_slip t", $select, $where, 0);

        $this->load->view('post_login/main');

        $this->load->view("reports/statementold", $statement);

        $this->load->view('post_login/footer');

    }

    else {

        //Month List
        $statement['month_list'] =   $this->Payroll->f_get_particulars("md_month",NULL, NULL, 0);

        //Category List
        $statement['category']   =   $this->Payroll->f_get_particulars("md_category", NULL, array('category_code IN (1,2,3)' => NULL), 0);

        $this->load->view('post_login/main');

        $this->load->view("reports/statementold", $statement);

        $this->load->view('post_login/footer');

    }

}



////////////////////////////////////////

    //For Bonus Report
    public function f_bonus_report() {

        if($_SERVER['REQUEST_METHOD'] == 'POST') {

            //Employee Ids for Bonus
            $select     =   array("emp_code");

            $where      =   array(

                "emp_catg"  =>  $this->input->post('category')

            );

            $emp_id     =   $this->Payroll->f_get_particulars("md_employee", $select, $where, 0);

            //Temp variable for emp_list
            $eid_list   =   [];

            for($i = 0; $i < count($emp_id); $i++) {

                array_push($eid_list, $emp_id[$i]->emp_code);

            }


            //List of Bonus Category wise
            unset($where);
            $where = array (

                "month"     =>  $this->input->post('month'),

                "year"      =>  $this->input->post('year')

            );

            $bonus['list']          =   $this->Payroll->f_get_particulars_in("td_bonus", $eid_list, $where);

            $bonus['bonus_dtls']    =   $this->Payroll->f_get_attendance();

            //Bonus Salary Range
            $bonus['bonus_range']  =   $this->Payroll->f_get_particulars("md_parameters", array('param_value'), array('sl_no' => 14), 1);

            //Bonus Salary Year
            $bonus['bonus_year']  =   $this->Payroll->f_get_particulars("md_parameters", array('param_value'), array('sl_no' => 15), 1);

            $this->load->view('post_login/main');

            $this->load->view("reports/bonus", $bonus);

            $this->load->view('post_login/footer');

        }

        else {

            //Month List
            $bonus['month_list'] =   $this->Payroll->f_get_particulars("md_month",NULL, NULL, 0);

            //For Current Date
            $bonus['sys_date']   =   $_SESSION['sys_date'];

            //Category List
            $bonus['category']   =   $this->Payroll->f_get_particulars("md_category", NULL, NULL, 0);


            $this->load->view('post_login/main');

            $this->load->view("reports/bonus", $bonus);

            $this->load->view('post_login/footer');

        }

    }


    //For Incentive Report
    public function f_incentive_report() {

        if($_SERVER['REQUEST_METHOD'] == 'POST') {

            //Employee Ids for Incentive
            $select     =   array("emp_code");

            $where      =   array(

                "emp_catg"  =>  4

            );

            $emp_id     =   $this->Payroll->f_get_particulars("md_employee", $select, $where, 0);

            //Temp variable for emp_list
            $eid_list   =   [];

            for($i = 0; $i < count($emp_id); $i++) {

                array_push($eid_list, $emp_id[$i]->emp_code);

            }


            //List of Incentive Category wise
            unset($where);
            $where = array (

                "month"     =>  $this->input->post('month'),

                "year"      =>  $this->input->post('year')

            );

            //Incentive list
            $incentive['list']          =   $this->Payroll->f_get_particulars_in("td_incentive", $eid_list, $where);

            //Incentive Year
            $incentive['incentive_year']  =   $this->Payroll->f_get_particulars("md_parameters", array('param_value'), array('sl_no' => 15), 1);

            $this->load->view('post_login/main');

            $this->load->view("reports/incentive", $incentive);

            $this->load->view('post_login/footer');

        }

        else {

            //Month List
            $incentive['month_list'] =   $this->Payroll->f_get_particulars("md_month",NULL, NULL, 0);

            //For Current Date
            $incentive['sys_date']   =   $_SESSION['sys_date'];

            $this->load->view('post_login/main');

            $this->load->view("reports/incentive", $incentive);

            $this->load->view('post_login/footer');

        }

    }


    //Total Deduction Report

    public function f_totaldeduction_report () {

        if($_SERVER['REQUEST_METHOD'] == 'POST'){

            $totaldeduction['total_deduct'] =   $this->Payroll->f_get_totaldeduction($this->input->post('from_date'), $this->input->post('to_date'));

            //Current Year
            $totaldeduction['year']  =   $this->Payroll->f_get_particulars("md_parameters", array('param_value'), array('sl_no' => 15), 1);

            $this->load->view('post_login/main');

            $this->load->view("reports/totaldeduction", $totaldeduction);

            $this->load->view('post_login/footer');

        }

        else{

            //Month List
            $totaldeduction['month_list'] =   $this->Payroll->f_get_particulars("md_month",NULL, NULL, 0);

            //For Current Date
            $totaldeduction['sys_date']   =   $_SESSION['sys_date'];

            $this->load->view('post_login/main');

            $this->load->view("reports/totaldeduction", $totaldeduction);

            $this->load->view('post_login/footer');

        }

    }


    //PF Contribution Report
    public function f_pfcontribution_report () {

        if($_SERVER['REQUEST_METHOD'] == 'POST'){

            //Opening Balance Date
            $where  =   array(

                "emp_no"      => $this->input->post('emp_cd'),

                "trans_dt < " => $this->input->post("from_date")

            );

            //Max Transaction Date
            $max_trans_dt   =   $this->Payroll->f_get_particulars("tm_pf_dtls", array("MAX(trans_dt) trans_dt"), $where, 1);
            

            //temp variable
            $pfcontribution['pf_contribution']   =   NULL;

            if(!is_null($max_trans_dt->trans_dt)) {

                //Opening Balance
                $pfcontribution['opening_balance']   =   $this->Payroll->f_get_particulars("tm_pf_dtls", array("balance"), array("emp_no" => $this->input->post('emp_cd'),"trans_dt" => $max_trans_dt->trans_dt), 1);

            }

            else {

                //Opening Balance
                $pfcontribution['opening_balance']   =   0;

            }

            //PF Contribution List
            unset($where);
            $where  =   array(

                "emp_no"    => $this->input->post('emp_cd'),

                "trans_dt BETWEEN '".$this->input->post("from_date")."' AND '".$this->input->post('to_date')."'" => NULL

            );

            $pfcontribution['pf_contribution']   =   $this->Payroll->f_get_particulars("tm_pf_dtls", NULL, $where, 0);


            //Current Year
            $pfcontribution['year']  =   $this->Payroll->f_get_particulars("md_parameters", array('param_value'), array('sl_no' => 15), 1);

            //Employee Name
            $pfcontribution['emp_name']  =   $this->Payroll->f_get_particulars("md_employee", array('emp_name'), array('emp_code' => $this->input->post('emp_cd')), 1);

            $this->load->view('post_login/main');

            $this->load->view("reports/pfcontribution", $pfcontribution);

            $this->load->view('post_login/footer');

        }

        else{

            //Month List
            $pfcontribution['month_list'] =   $this->Payroll->f_get_particulars("md_month",NULL, NULL, 0);

            //For Current Date
            $pfcontribution['sys_date']   =   $_SESSION['sys_date'];

            //Employee List
            $select =   array ("emp_code", "emp_name");

            $where  =   array(

                "emp_catg IN (1,2,3)"      => NULL,

                "deduction_flag"           => "Y"
            );

            $pfcontribution['emp_list']   =   $this->Payroll->f_get_particulars("md_employee", $select, $where, 0);

            $this->load->view('post_login/main');

            $this->load->view("reports/pfcontribution", $pfcontribution);

            $this->load->view('post_login/footer');

        }

    }

}
    
?>
