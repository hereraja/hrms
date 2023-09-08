<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Approves extends CI_Controller{

    public function __construct(){
        parent::__construct();

        $this->load->model('Login_Process');

        $this->load->model('Salary_Process');
        $this->load->model('Admin_Process');
        $this->load->model('ApiVoucher');
        $this->load->helper('pdf_helper');

        $this->load->library('email');
     
        
        //For User's Authentication
        // if(!isset($this->session->userdata('loggedin')->user_id)){
            
        //     redirect('User_Login/login');

        // }
        
    }


    /**********************For Approve Screen**********************/

    public function payapprove() {

        if($this->input->get('trans_no')){ 

            $data_array     =   array(

                "approval_status"   => 'A',

                "approved_by"       =>$this->session->userdata['loggedin']['user_id'],

                "approved_dt"       => date('Y-m-d')

            );
            $month   = $this->input->get('month');
            $trans_no = $this->input->get('trans_no');
            $year = $this->input->get('year');
            $catg_cd = $this->input->get('catg_cd');
            
           
            $approve['unapprove_tot_dtls'] = [];
            $approve['unapprove_dtls']     =  (array) $this->Salary_Process->f_get_particulars("td_salary a,md_month b",array("a.trans_date", "a.trans_no", "a.sal_month", "a.sal_year", "a.catg_cd","b.month_name"),array("a.sal_month = b.id"=>NULL,"approval_status"=>'U'), 0);
            $rmrks = "Salary for the month of ".$approve['unapprove_dtls']['0']->month_name." ".$approve['unapprove_dtls']['0']->sal_year ;
            $select     =   array( "SUM(tot_deduction) gross","SUM(net_amount) net_amount");

            for($i = 0; $i < count($approve['unapprove_dtls']); $i++){

                $where  =   array(

                "trans_date"    =>  $approve['unapprove_dtls'][$i]->trans_date,

                "trans_no"      =>  $approve['unapprove_dtls'][$i]->trans_no,

                );

                $data_array     =   (array) $this->Salary_Process->f_get_particulars("td_pay_slip", $select, $where, 1);

                array_push($approve['unapprove_tot_dtls'], (object) array_merge((array) $approve['unapprove_dtls'][$i], (array) $data_array));

            }        
           
            $bank_head_code = $this->Salary_Process->f_get_particulars("md_parameters",array("param_value"),array("sl_no"=>6), 1);
         
            $api_data = array('trans_dt'=>date('Y-m-d'),
                              'br_cd' => 342,
                              'acc_cr_code' => $bank_head_code->param_value,
                              'net_amt'=> $approve['unapprove_tot_dtls'][0]->net_amount,
                              'created_dt'=>date('Y-m-d'),
                              'created_by'=>$this->session->userdata['loggedin']['user_id'],
                              'rem' => $rmrks
                             );
                         //    print_r($api_data);
            $this->ApiVoucher->f_salary_jouranl($api_data);
            $salseduction = $this->Salary_Process->f_get_tot_deduction($trans_no,$month,$year);

            $api_ded_data = array('trans_dt'=>date('Y-m-d'),
            'br_cd' => 342,
            'created_dt'=>date('Y-m-d'),
            'created_by'=>$this->session->userdata['loggedin']['user_id'],
            'rem' => $rmrks,
            'insuarance' => $salseduction->ded_insuarance,
			'ccs'=>$salseduction->ded_ccs,
            'hbl'=>$salseduction->ded_hbl,
			'telephone'=>$salseduction->ded_telephone,
			'med_adv'=>$salseduction->ded_med_adv,
			'festival_adv'=>$salseduction->ded_festival_adv,
			'tf'=>$salseduction->ded_tf,
			'med_ins'=>$salseduction->ded_med_ins,
			'comp_loan'=>$salseduction->ded_comp_loan,
			'itax'=>$salseduction->ded_itax,
			'gpf'=>$salseduction->ded_gpf,
			 'epf'=>$salseduction->ded_epf,
			'ptax'=>$salseduction->ded_ptax,
			'other_deduction'=>$salseduction->ded_other_deduction,
			'tot_deduction'=>$salseduction->tot_deduction
             );
            $this->ApiVoucher->f_sal_dedct_jrnl($api_ded_data);

            $this->Salary_Process->f_edit("td_salary",array("approval_status"   => 'A',"approved_by"=>$this->session->userdata['loggedin']['user_id'],"approved_dt"=> date('Y-m-d')),
             array("trans_no" => $this->input->get('trans_no'),'catg_cd'=>$catg_cd,'sal_month'=>$month,'sal_year'=>$year,"trans_date" => $this->input->get('trans_date')));
            

            $this->Salary_Process->f_edit("td_pay_slip", array("approval_status" => 'A'), array("sal_month" => $this->input->get('month')));
            
            $select = array(

                "t.trans_date","t.trans_no","t.sal_month",
                "t.sal_year","t.emp_no","m.emp_name","m.emp_catg",
                "m.email", "m.pan_no", "m.designation",
                "t.basic_pay","t.da_amt","t.othr_allow","t.hra_amt","t.med_allow", "m.pf_ac_no",
                "t.insuarance","t.ccs", "t.hbl", "t.telephone",
                "t.festival_adv", "t.med_adv",  "t.ptax", "t.itax","t.tf","t.gpf","t.epf","t.med_ins",
                "t.comp_loan","t.tot_deduction", "t.net_amount"
            );

            $where  = array(

                "m.emp_code = t.emp_no" => NULL,

                "m.emp_status"          => 'A',

                "t.trans_date"          => $this->input->get('trans_date'),

                "t.trans_no"            => $this->input->get('trans_no'),

                "m.emp_catg"            => $this->input->get('catg_cd')

            );

            $salary_dtls = $this->Salary_Process->f_get_particulars("md_employee m,td_pay_slip t", $select, $where, 0);

           
            $this->session->set_flashdata('msg', 'Successfully Approved!');

            // redirect('payroll/approve');
            redirect('payapprv');
        }

        //Unapprove List of Salary
        $select =   array(

            "trans_date", "trans_no", "sal_month", 

            "sal_year", "catg_cd"

        );
        
        $where  =   array(

            "approval_status"       =>  'U'

        );

        $approve['unapprove_dtls']     =  (array) $this->Salary_Process->f_get_particulars("td_salary", $select, $where, 0);

        unset($select);
        unset($where);

        //Temp Variable
        $approve['unapprove_tot_dtls'] = [];


        $select     =   array( "SUM(tot_deduction) gross",
                               "SUM(net_amount) net_amount");
        
        
        for($i = 0; $i < count($approve['unapprove_dtls']); $i++){

            unset($where);

            $where  =   array(

                "trans_date"    =>  $approve['unapprove_dtls'][$i]->trans_date,

                "trans_no"      =>  $approve['unapprove_dtls'][$i]->trans_no,
                
            );

            $data_array     =   (array) $this->Salary_Process->f_get_particulars("td_pay_slip", $select, $where, 1);

            array_push($approve['unapprove_tot_dtls'], (object) array_merge((array) $approve['unapprove_dtls'][$i], (array) $data_array));

        }                               

        //Bank List
        // $approve['bank']	         =   $this->Salary_Process->f_get_particulars("md_bank", NULL, NULL, 0);			
        
        //Category List
        $approve['category']         =   $this->Salary_Process->f_get_particulars("md_category", NULL, NULL, 0);

        $this->load->view('post_login/payroll_main');

        $this->load->view("approve/dashboard", $approve);
        
        $this->load->view('post_login/footer');

    }

    //Creating individual payslip PDF
    public function f_pdf($emp_dtls=NULL) {
        
        $data['payslip_dtls'] = $emp_dtls;

        $this->load->view('reports/pdfreport', $data);

        $file_name  = $emp_dtls->emp_no.$emp_dtls->sal_year.$emp_dtls->sal_month;
        
        $email_addr = $emp_dtls->email;

        chmod(FCPATH."payslip/".$file_name.".pdf", 0766);

    }

    //Send Mail to the invidual email account
    public function f_email($file_name, $email_addr){

        $this->email->clear(TRUE);
        $this->email->from('confedwb.org@gmail.com', 'Payslip');
        
        $this->email->to($email_addr);

        $this->email->subject('Payslip for the month of '.date("F", strtotime(date('Y-m-d'))));
        $this->email->message('');
        $this->email->attach(FCPATH.'payslip/'.$file_name.'.pdf');
        $this->email->send();

        unlink(FCPATH.'payslip/'.$file_name.'.pdf');

    }

}