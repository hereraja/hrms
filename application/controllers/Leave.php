<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Leave extends CI_Controller {

	public function __construct(){
		parent::__construct();
		if(!isset($this->session->userdata('loggedin')['user_id'])){
		
			redirect('Payroll_Login/login');

		}

		$this->load->model('LeaveM');
    }

	
	public function leaveType()
	{

		$this->load->view('post_login/main');

		$tableData['data'] = $this->LeaveM->f_get_leaveType_table();
		$this->load->view('type/leaveTable', $tableData);

		$this->load->view('post_login/footer');

	}


	// For leave type entry --
	public function addLeaveType()
	{

		$this->load->view('post_login/main');

		$this->load->view('type/addLeave');            

		$this->load->view('post_login/footer');

	}

	// For Leave type entry --
	public function leaveTypeEntry()
	{

		$slNo = $this->LeaveM->f_get_leaveType_max_slNo();
		$sl_no = $slNo->sl_no+1;
		
		if($this->session->userdata('loggedin'))
		{
			$created_by   =  $this->session->userdata('loggedin')['user_id']; 
		}

		$created_dt       =     date('y-m-d H:i:s');
		
		if($_SERVER['REQUEST_METHOD']=="POST")
		{

			$type           =       $_POST['type'];
			$start_month    =       $_POST['start_month'];
			$end_month      =       $_POST['end_month'];
			$amount         =       $_POST['amount'];
			$credit_on      =       $_POST['credit_on'];
			
			$this->LeaveM->leaveTypeEntry($sl_no, $type, $start_month, $end_month, $amount, $credit_on, $created_by, $created_dt);

			echo "<script> alert('Successfully Submitted');
			document.location= 'leaveType' </script>";

		}
		else
		{

			echo "<script> alert('Sorry! Select Again.');
			document.location= 'addLeaveType' </script>";

		}

	}


	// for edit screen of leave type--
	public function editLeaveType()
	{

		$sl_no = $this->input->get('slNo');

		$this->load->view('post_login/main');

		$edit_data['data'] = $this->LeaveM->f_get_leaveType_editData($sl_no);
		$this->load->view('type/editLeave', $edit_data);            

		$this->load->view('post_login/footer');

	}

	// for updating Leave Type --
	public function updateLeaveType()
	{

		if($this->session->userdata('loggedin'))
		{
			$modified_by   =  $this->session->userdata('loggedin')['user_id']; 
		}

		$modified_dt       =     date('y-m-d H:i:s');
		
		if($_SERVER['REQUEST_METHOD']=="POST")
		{

			$sl_no          =       $_POST['sl_no'];
			$type           =       $_POST['type'];
			$start_month    =       $_POST['start_month'];
			$end_month      =       $_POST['end_month'];
			$amount         =       $_POST['amount'];
			$credit_on      =       $_POST['credit_on'];
			
			$this->LeaveM->updateLeaveType($sl_no, $type, $start_month, $end_month, $amount, $credit_on, $modified_by, $modified_dt);

			echo "<script> alert('Successfully Updated');
			document.location= 'leaveType' </script>";

		}
		else
		{

			echo "<script> alert('Sorry! Try Again.');
			document.location= 'leaveType' </script>";

		}

	}

	// For deleting Leave type --
	public function deleteLeaveType()
	{

		$sl_no = $this->input->get('slNo');
		$this->LeaveM->deleteLeaveType($sl_no);
		$this->leaveType();

	}


	/////////////////////////////////////
	// for Leave Allocation table --
	/////////////////////////////////////
	
	public function leaveAllocation()
	{
		$employee = $this->LeaveM->f_get_active_employees();
		$tableData['data'] = array();

		// for($i=0; $i<count($employee); $i++)
		// {
		// 	$maxtransDt = $this->LeaveM->f_get_maxTransDt_forAllocation($employee[$i]->emp_no); 
		// 	$trans_dt = $maxtransDt->trans_dt;
		// 	$MaxTransCd = $this->LeaveM->f_get_maxTransCd_forAllocation($employee[$i]->emp_no, $trans_dt);
		// 	$trans_cd = $MaxTransCd->trans_cd;
		// 	$result = $this->LeaveM->f_get_tableData_forAllocation($employee[$i]->emp_no, $trans_dt, $trans_cd);
		// 	$tableData['data'][$i] = $result[0];
		// }
		$tableData['data'] = $this->LeaveM->f_get_particulars('td_leave_dtls',NULL,array('trans_type'=>'A'),0);
		$this->load->view('post_login/payroll_main');
		$this->load->view('allocation/table', $tableData);            
		$this->load->view('post_login/footer');

	}

	// For new leave allocation entry --
	public function newAllocation()
	{

		$this->load->view('post_login/payroll_main');
		$empData['data'] = $this->LeaveM->f_get_employeeData();
		$this->load->view('allocation/add', $empData);
		$this->load->view('post_login/footer');

	}

	public function js_get_currentBal_forAllocation() // for JS
	{

		$emp_cd = $this->input->get('emp_cd');
		$maxTransDt = $this->LeaveM->f_get_maxTransDt_forAllocation($emp_cd);
		$trans_dt = $maxTransDt->trans_dt;
		
		$maxTransCd = $this->LeaveM->f_get_maxTransCd_forAllocation($emp_cd, $trans_dt);
		$trans_cd = $maxTransCd->trans_cd;
		
		$result = $this->LeaveM->js_get_currentBal_forAllocation($emp_cd, $trans_dt, $trans_cd);
		echo json_encode($result);

	}

	// Allocation Entry -->
	public function leaveAllocationEntry()
	{

		$trans_dt = $_POST['trans_dt'];
		$transCd = $this->LeaveM->f_get_allocation_transCd($trans_dt);
		$trans_cd = $transCd->trans_cd+1;
		
		if($this->session->userdata('loggedin'))
		{
			$created_by   =  $this->session->userdata('loggedin')['user_id']; 
		}
		$created_dt       =     date('y-m-d H:i:s');

		 $this->form_validation->set_rules('trans_dt','Trans_dt','required');
		
		if($this->form_validation->run() == false){
			
			echo "<script> alert('Sorry! Try Again');
				document.location= 'newAllocation' </script>";
		}
		else{

			if($_SERVER["REQUEST_METHOD"] == "POST")
			{

				$emp_no             =        $_POST['emp_no'];
				$new_cl_bal         =        $_POST['cl_bal'];
				$new_el_bal         =        $_POST['el_bal'];
				$new_ml_bal         =        $_POST['ml_bal'];
				$new_od_bal         =        0;
				$cur_cl_bal         =        0;
				$cur_el_bal         =        0;
				$cur_ml_bal         =        0;
				$cur_od_bal         =        0;

				if($cur_cl_bal == '' & $cur_el_bal == '')
				{
					$cur_cl_bal         =        0;
					$cur_el_bal         =        0;
					$cur_ml_bal         =        0;
					$cur_od_bal         =        0;
				}

				// if($cur_el_bal>300.00)
				// {
				// 	$el_bal = 300.00+$new_el_bal;
				// }
				// elseif($cur_el_bal<=300.00)
				// {
				// 	$el_bal = $new_el_bal+$cur_el_bal;
				// }
				  $el_bal    =  $new_el_bal;
				  $cl_bal    =  $new_cl_bal;
				  $ml_bal    =  $new_ml_bal;
				  $od_bal    =  $new_od_bal;
				  $eo_bal    =  $this->input->post('eo_bal');
				  $stu_bal   =  $this->input->post('stu_bal');

				$employeeName = $this->LeaveM->f_get_allocation_empName($emp_no);
				$emp_name = $employeeName->emp_name;

				$trans_type = 'A';
				$docket_no = 'opening';
				$leave_type = '';
				$leave_mode = 'F';
				$from_dt = '';
				$to_dt = '';
				$remarks = '';
				$approval_status = '';
				$approved_dt = '';
				$approved_by = '';
				$rollback_reason = '';
				$roll_dt = '';
				$roll_by = '';
				

				$this->LeaveM->leaveAllocationEntry($trans_dt, $trans_cd, $trans_type, $emp_no, $emp_name, $docket_no,
													$leave_type, $leave_mode, $from_dt, $to_dt, $remarks, $approval_status,
													$approved_dt, $approved_by, $rollback_reason, $roll_dt, $roll_by, 
													$cl_bal, $el_bal, $ml_bal, $od_bal,$eo_bal,$stu_bal,$created_by, $created_dt );
		   
				echo "<script> alert('Successfully Added');document.location= 'leaveAllocation' </script>";

			}
			else
			{
				echo "<script> alert('Sorry! Try again');
					document.location= 'newAllocation' </script>";

			}
		}

	}


	// Editing leave allocation --
	public function editLeaveAllocation()
	{

		$trans_cd = $this->input->get('transCd');
		$trans_dt = $this->input->get('dt');

		$editData['data'] = $this->LeaveM->f_get_allocation_editData($trans_cd, $trans_dt);

		$this->load->view('post_login/main');

		$this->load->view('allocation/edit', $editData);

		$this->load->view('post_login/footer');

	}

	// Updating the record --
	public function updateLeaveAllocation()
	{

		if($this->session->userdata('loggedin'))
		{
			$modified_by   =  $this->session->userdata('loggedin')['user_id']; 
		}

		$modified_dt       =     date('y-m-d H:i:s');

		if($_SERVER["REQUEST_METHOD"] == "POST")
		{

			$emp_no        =        $_POST['emp_no'];
			$cl_bal        =        $_POST['cl_bal'];
			$el_bal        =        $_POST['el_bal'];
			$ml_bal        =        $_POST['ml_bal'];

			$trans_dt      =        $_POST['trans_dt'];
			$trans_cd      =        $_POST['trans_cd'];

			$this->LeaveM->updateLeaveAllocation($trans_dt, $trans_cd, $emp_no, $cl_bal, $el_bal, $ml_bal, $modified_by, $modified_dt);

			echo "<script> alert('Successfully Updated');
				document.location= 'leaveAllocation' </script>";

		}
		else
		{
			echo "<script> alert('Sorry! Try again.');
				document.location= 'leaveAllocation' </script>";
		}

	}

	public function deleteLeaveAllocation()
	{

		$trans_dt = $this->input->get('dt');
		$trans_cd = $this->input->get('transCd');

		$this->LeaveM->deleteLeaveAllocation($trans_dt, $trans_cd);
		$this->leaveAllocation();

	}


	///////////////////////////
	// For Leave Apply --
	//////////////////////////
	public function applyLeave()
	{
		$emp_cd = $this->session->userdata['loggedin']['emp_cd'];
		$tableData['data'] = $this->LeaveM->f_get_leaveAppliedDtls($emp_cd);
		$this->load->view('post_login/payroll_main');
		$this->load->view('leave/dashboard', $tableData);
		$this->load->view('post_login/footer');

	}
	
	 //For Leave Application Edit --> 
	public function Leavenotesheet()
	{
		$trans_dt = $this->input->get('dt');
		$trans_cd = $this->input->get('transCd');
		$Data['data'] = $this->LeaveM->f_get_leaveApply_notesheet($trans_dt, $trans_cd);
		$this->load->view('post_login/main');
		$this->load->view('apply/notesheet', $Data);
		$this->load->view('post_login/footer');

	}
	public function leavereceipt()
	{
		$trans_dt = $this->input->get('dt');
		$trans_cd = $this->input->get('transCd');
		$Data['data'] = $this->LeaveM->f_get_leaveApply_notesheet($trans_dt, $trans_cd);
		$this->load->view('post_login/main');
		$this->load->view('apply/receipt', $Data);
		$this->load->view('post_login/footer');


	}
	public function leaveletter()
	{
		$trans_dt = $this->input->get('dt');
		$trans_cd = $this->input->get('transCd');
		$Data['data'] = $this->LeaveM->f_get_leaveApply_notesheet($trans_dt, $trans_cd);
		$this->load->view('post_login/payroll_main');
		$this->load->view('leave/leave_letter', $Data);
		$this->load->view('post_login/footer');
	}

	// For leave apply Form --> 
	public function newLeaveApply()
	{   //$docket = 0;
		$emp_cd = $this->session->userdata['loggedin']['emp_cd'];
		$entryData['emp_cd'] = $emp_cd;
		$empName = $this->LeaveM->f_get_leaveApply_employeeName($emp_cd); // getting employee name(leave applicant)
		$entryData['emp_name'] = $empName->emp_name;
	
		$where = array('year' => date('Y'));
		$resuldk = $this->LeaveM->f_get_particulars('td_leave_dtls',array('IFNULL(MAX(trans_no),0) as trans_no'),$where,1);
		//$docket= ;
		$entryData['docket_no'] = (int)($resuldk->trans_no) +1;
		$this->load->view('post_login/payroll_main');
		$this->load->view('leave/add', $entryData);
		$this->load->view('post_login/footer');

	}

	// For JS / leave application -> getting leave balance of a selected type --> 
	public function js_get_apply_leaveBalance()
	{
		$year = date('Y');
		$leave_type = $this->input->get('leaveType');
		$emp_cd = $this->session->userdata['loggedin']['emp_cd'];
		$maxTransDt = $this->LeaveM->js_get_maxTransDt($emp_cd);
		$trans_dt = $maxTransDt->trans_dt;
		$where = array("trans_type"=> 'O','emp_no'=>$emp_cd, 'YEAR(trans_dt)' => $year);
		$resulto = $this->LeaveM->f_get_particulars('td_leave_dtls',array('sum(cl_bal) as cl_bal','sum(el_bal) as el_bal','sum(ml_bal) as ml_bal','sum(od_bal) as od_bal','sum(eo_bal) as eo_bal','sum(stu_bal) as stu_bal'),$where,1);
		$where = array("trans_type"=>'A','emp_no'=>$emp_cd, 'YEAR(trans_dt)' => $year);
		$resulta = $this->LeaveM->f_get_particulars('td_leave_dtls',array('sum(cl_bal) as cl_bal','sum(el_bal) as el_bal','sum(ml_bal) as ml_bal','sum(od_bal) as od_bal','sum(eo_bal) as eo_bal','sum(stu_bal) as stu_bal'),array("trans_type"=>'O','emp_no'=>$emp_cd, 'YEAR(trans_dt)' => $year),1);
		//echo $this->db->last_query();die();
		
		$sql1 = $this->db->query("select sum(EL_enj)EL_enj,sum(CL_enj)CL_enj,sum(ML_enj) ML_enj,sum(EO_enj) EO_enj,sum(STU_enj) STU_enj
									from(
									SELECT if(leave_type='EL',no_of_days,'0') EL_enj,if(leave_type='CL',no_of_days,'0')CL_enj,if(leave_type='ML', no_of_days,'0')ML_enj,if(leave_type='EO', no_of_days,'0')EO_enj,if(leave_type='STU', no_of_days,'0')STU_enj
									FROM td_leave_dtls
									WHERE emp_no = $emp_cd 
									AND trans_type = 'T' 
									AND approval_status = 'A'
									AND DATE_FORMAT(trans_dt,'%Y') = $year)a");
		$result1 = $sql1->row();
	    $data['cl_bal'] = ($resulta->cl_bal) - $result1->CL_enj;
	    $data['el_bal'] = ($resulta->el_bal+$resulto->el_bal) - $result1->EL_enj;
		$data['ml_bal'] = ($resulta->ml_bal+$resulto->ml_bal) - $result1->ML_enj;
		$data['od_bal'] = 0;
		$data['eo_bal'] = ($resulta->eo_bal+$resulto->eo_bal) - $result1->EO_enj;
		$data['stu_bal'] = ($resulta->stu_bal+$resulto->stu_bal) - $result1->STU_enj;
	   
		echo json_encode($data);

	}


	// For leave application entry --> 
	public function leaveApplyEntry()
	{

		if($this->session->userdata('loggedin'))
		{
			$created_by   =  $this->session->userdata('loggedin')['user_id']; 
		}

		$created_dt       =     date('y-m-d H:i:s');
		$trans_dt = $_POST['docket_dt'];
		
		//$date_arr = explode('/',$_POST['docket_dt']);
		//$trans_dt = date("Y-m-d", strtotime($date_arr[2].$date_arr[1].$date_arr[0]));
		//print_r($_POST);
		$transCd = $this->LeaveM->f_get_allocation_transCd($trans_dt); // getting trans_cd as per trans_dt 
		$trans_cd = $transCd->trans_cd+1; 

		$emp_no = $this->session->userdata['loggedin']['emp_cd'];
		$empName = $this->LeaveM->f_get_leaveApply_employeeName($emp_no);
		
		//$leaveBalance_maxDt['balanceData'] = $this->LeaveM->f_get_leaveBal_on_maxTransaction($emp_no);
		//$balanceData = $leaveBalance_maxDt['balanceData'][0];
	   
		//$clBal = $balanceData->cl_bal; 
		//$elBal = $balanceData->el_bal; 
		//$mlBal = $balanceData->ml_bal; 
		//$odBal = $balanceData->od_bal; 
		
		$clBal = 0; 
		$elBal = 0; 
		$mlBal = 0; 
		$odBal = 0; 
		
		// if($_POST['leave_type'] == 'CL'){
			// $clBal = $clBal-$_POST['no_of_days'];
		// }
		// elseif($_POST['leave_type'] == 'EL'){
			// $elBal = $elBal-$_POST['no_of_days'];
		// }
		// elseif($_POST['leave_type'] == 'ML'){
			// $mlBal = $mlBal-$_POST['no_of_days'];
		// }
		// elseif($_POST['leave_type'] == 'CL'){
			// $odBal = $odBal-$_POST['no_of_days'];
		// }
		$this->form_validation->set_rules('docket_dt','Docket_dt','required');
		
		if($_SERVER["REQUEST_METHOD"] == "POST")
		{
			if($this->form_validation->run() == false)
			{
				echo "<script> alert('Sorry! Try Again');
				document.location= 'newLeaveApply' </script>";
				
			}else{
			$where = array('year' => date('Y'));
			$resuldk = $this->LeaveM->f_get_particulars('td_leave_dtls',array('IFNULL(MAX(trans_no),0) as trans_no'),$where,1);
			
            $docket = (int)($resuldk->trans_no) +1;
			$trans_type         =       'T';
			$emp_name           =       $_POST['emp_name'];
			$trans_no           =       $docket;
			$year               =       date('Y');
			$docket_no          =       date('Y').'-'.str_pad($docket,4,"0",STR_PAD_LEFT);
			$leave_type         =       $_POST['leave_type'];
			$from_dt            =       $_POST['from_dt'];
			$to_dt              =       $_POST['to_dt'];
			$no_of_days         =       $_POST['no_of_days'];
			$leave_mode         =       $_POST['leave_mode'];
			$approval_status    =       'U';
			$letterfirstline    =       '';
			$remarks            =       $_POST['remarks'];
			$cl_bal             =       $clBal;
			$el_bal             =       $elBal;
			$ml_bal             =       $mlBal;
			$od_bal             =       $odBal;


			$this->LeaveM->leaveApplyEntry($trans_dt, $trans_cd, $trans_type, $emp_no, $emp_name,$trans_no,$year, $docket_no,$leave_type,$from_dt, $to_dt, $no_of_days, $leave_mode, $approval_status,$letterfirstline,$remarks, $cl_bal, $el_bal, $ml_bal, $od_bal, $created_by, $created_dt );

			echo "<script> alert('Successfully Added');document.location= 'applyLeave' </script>";

			}	

		}
		else
		{
			echo "<script> alert('Sorry! Try Again');
				document.location= 'newLeaveApply' </script>";
		}

	}


	//For Leave Application Edit --> 
	public function editLeaveApply()
	{

		$trans_dt = $this->input->get('dt');
		$trans_cd = $this->input->get('transCd');

		$editData['data'] = $this->LeaveM->f_get_leaveApply_editData($trans_dt, $trans_cd);

		$this->load->view('post_login/payroll_main');

		$this->load->view('leave/edit', $editData);

		$this->load->view('post_login/footer');


	}

	// For updating leave application --- 
	public function updateLeaveApplication()
	{

		if($this->session->userdata('loggedin'))
		{
			$modified_by   =  $this->session->userdata('loggedin')['user_id']; 
		}

		$modified_dt       =     date('y-m-d H:i:s');

		if($_SERVER["REQUEST_METHOD"] == "POST")
		{

			$trans_dt           =           $_POST['trans_dt'];
			$trans_cd           =           $_POST['trans_cd'];
			$emp_no             =           $_POST['emp_no'];
			$emp_name           =           $_POST['emp_name'];
			//$leave_type         =           $_POST['leave_type'];
			//$from_dt            =           $_POST['from_dt'];
			//$to_dt              =           $_POST['to_dt'];
			//$no_of_days         =           $_POST['no_of_days'];
			$letterfirstline    =           $_POST['letterfirstline'];
			$remarks            =           $_POST['remarks'];

			//$this->LeaveM->updateLeaveApplication($trans_dt,$trans_cd,$emp_no,$emp_name,$leave_type,$from_dt,$to_dt,$no_of_days,$letterfirstline,$remarks,$modified_by,$modified_dt);
			$this->LeaveM->updateLeaveApplication($trans_dt,$trans_cd,$emp_no,$emp_name,$letterfirstline,$remarks,$modified_by,$modified_dt);
			echo "<script> alert('Successfully Updated');
				document.location= 'applyLeave' </script>";

		}
		else
		{

			echo "<script> alert('Sorry! Try again');
				document.location= 'applyLeave' </script>";
		}


	}

	// For deleting leave application --
	public function deleteLeaveApply()
	{

		$trans_dt = $this->input->get('dt');
		$trans_cd = $this->input->get('transCd');

		$this->LeaveM->deleteLeaveApply($trans_dt, $trans_cd);
		redirect('leave/applyLeave');

	}


	///////////////////////////////////////
	// For Maternity Leave apply -- 
	/////////////////////////////////////
	public function applyMatLeave()
	{

		$this->load->view('post_login/main');

		$emp_cd = $this->session->userdata['loggedin']['emp_cd'];
		$tableData['data'] = $this->LeaveM->f_get_mat_leave_appliedDtls($emp_cd);
		
		$this->load->view('matApply/table', $tableData);

		$this->load->view('post_login/footer');

	}

	public function newMatLeaveApply()
	{

		$this->load->view('post_login/main');

		$emp_cd = $this->session->userdata['loggedin']['emp_cd'];

		$entryData['emp_cd'] = $emp_cd;
		$empName = $this->LeaveM->f_get_leaveApply_employeeName($emp_cd); // getting employee name(leave applicant)
		$entryData['emp_name'] = $empName->emp_name;

		$this->load->view('matApply/add', $entryData);

		$this->load->view('post_login/footer');

	}

	public function js_get_applied_matLeaveDtls()
	{

		$emp_cd = $this->session->userdata['loggedin']['emp_cd'];
		$infoTableDtls = $this->LeaveM->js_get_applied_matLeaveDtls($emp_cd);
		echo json_encode($infoTableDtls);

	}

	public function js_check_matLeave_entry()
	{

		$emp_cd = $this->session->userdata['loggedin']['emp_cd'];
		$result = $this->LeaveM->js_check_matLeave_entry($emp_cd);
		echo json_encode($result);

	}

	public function matLeaveEntry()
	{

		if($this->session->userdata('loggedin'))
		{
			$created_by   =  $this->session->userdata('loggedin')['user_id']; 
		}

		$created_dt       =     date('y-m-d H:i:s');

		$trans_dt = date('y-m-d');
		$transCd = $this->LeaveM->f_get_matLeave_transCd($trans_dt); // getting trans_cd as per trans_dt 
		$trans_cd = $transCd->trans_cd+1; 

		$emp_no = $this->session->userdata('loggedin')->emp_cd;
		$empName = $this->LeaveM->f_get_leaveApply_employeeName($emp_no);
		
		
		if($_SERVER["REQUEST_METHOD"] == "POST")
		{
		   
			$emp_name           =       $_POST['emp_name'];
			$docket_no          =       $_POST['docket_no'];
			$from_dt            =       $_POST['from_dt'];
			$to_dt              =       $_POST['to_dt'];
			$no_of_days         =       $_POST['no_of_days'];
			$approval_status    =       'U';
			$remarks            =       $_POST['remarks'];
			
			$this->LeaveM->matLeaveEntry($trans_dt, $trans_cd, $emp_no, $emp_name, $docket_no, $from_dt, $to_dt, $no_of_days,
											$approval_status, $remarks, $created_by, $created_dt );

			echo "<script> alert('Successfully Added');
				document.location= 'applyMatLeave' </script>";

		}
		else
		{
			echo "<script> alert('Sorry! Try Again');
				document.location= 'newMatLeaveApply' </script>";
		}


	}


	public function editMatLeave()
	{

		$transCd = $this->input->get('transCd');
		$transDt = $this->input->get('dt');

		$editData['data'] = $this->LeaveM->f_get_matLeave_editDtls($transCd, $transDt);

		$this->load->view('post_login/main');

		$this->load->view('matApply/edit', $editData);

		$this->load->view('post_login/footer');

	}

	public function updateMatLeave()
	{

		if($this->session->userdata('loggedin'))
		{
			$modified_by   =  $this->session->userdata('loggedin')['user_id']; 
		}

		$modified_dt       =     date('y-m-d H:i:s');

		if($_SERVER["REQUEST_METHOD"] == "POST")
		{

			$trans_dt           =       $_POST['trans_dt'];
			$trans_cd           =       $_POST['trans_cd'];
			// $emp_no             =       $_POST['emp_no'];
			//$emp_name           =       $_POST['emp_name'];
			$docket_no          =       $_POST['docket_no'];
			$from_dt            =       $_POST['from_dt'];
			$to_dt              =       $_POST['to_dt'];
			$no_of_days         =       $_POST['no_of_days'];
			$approval_status    =       'U';
			$remarks            =       $_POST['remarks'];

			$this->LeaveM->f_update_matLeaveEntry($trans_dt, $trans_cd, $docket_no, $from_dt, $to_dt,
												$no_of_days, $approval_status, $remarks, $modified_by, $modified_dt );

			echo "<script> alert('Successfully Updated');
			document.location= 'applyMatLeave' </script>";

		}
		else
		{
			echo "<script> alert('Sorry! Try Again.');
			document.location= 'applyMatLeave' </script>";

		}

	}

	public function deleteMatLeave()
	{

		$trans_dt = $this->input->get('dt');
		$trans_cd = $this->input->get('transCd');

		$this->LeaveM->f_delete_matLeave($trans_dt, $trans_cd);

		redirect('leave/applyMatLeave');

	}


	///////////////////////////////////////////
	// For Leave Approval -->
	//////////////////////////////////////////

    //  Leave Approve for Manager   // 
	public function managerApproval()
	{
		$this->load->view('post_login/payroll_main');
		$where = array('trans_type' => 'T','approve_lable1' => 'U');
		$tableData['data'] = $this->LeaveM->f_get_particulars('td_leave_dtls',NULL,$where,0);
		$this->load->view('approval/manager_table', $tableData);
		$this->load->view('post_login/footer');
	}
	// For Leave Application approval -- 
	public function managerapproveLeave()
	{

		$trans_dt = $this->input->get('dt');
		$trans_cd = $this->input->get('transCd');
		$approvalResult['data'] = $this->LeaveM->f_get_leaveApply_editData($trans_dt, $trans_cd); // getting all dtls
		$this->load->view('post_login/payroll_main');
		$this->load->view('approval/manager_form', $approvalResult);
		$this->load->view('post_login/footer');
	}

	// For Approval --> 
	public function managerapproveLeaveapp()
	{

		if($this->input->post('trans_dt') != '' && $this->input->post('trans_cd') != ''){

			$data_array= array('approve_lable1'=> 'A',
			                   'approve_label1_rmrk'=> $this->input->post('approve_label1_rmrk'),
						   'approve_lable1_by'=>$this->session->userdata('loggedin')['user_id'],
						   'approve_lable1_dt'=> date('Y-m-d H:i:s') );
						
			$where = array('trans_dt' => $this->input->post('trans_dt'),
							'trans_cd' => $this->input->post('trans_cd'),
							'leave_type' => $this->input->post('leave_type')
						);				   

		    $this->LeaveM->f_edit('td_leave_dtls', $data_array, $where);
			
		//redirect('leave/firstApproval');
			echo "<script> alert('Successfully Updated');
					document.location= 'managerApproval' </script>";
		}else{
			echo "<script> alert('Not Updated');
					document.location= 'managerApproval' </script>";
		}

	}

	public function firstApproval()
	{

		$this->load->view('post_login/payroll_main');
		$tableData['data'] = $this->LeaveM->f_get_approval_tableData();
		$this->load->view('approval/table', $tableData);
		$this->load->view('post_login/footer');

	}

	// For Leave Application approval -- 
	public function approveLeave()
	{

		$trans_dt = $this->input->get('dt');
		$trans_cd = $this->input->get('transCd');
		$approvalResult['data'] = $this->LeaveM->f_get_leaveApply_editData($trans_dt, $trans_cd); // getting all dtls
		$this->load->view('post_login/payroll_main');
		$this->load->view('approval/form', $approvalResult);
		$this->load->view('post_login/footer');
	}

	// For Approval --> 
	public function approveLeaveApplication()
	{

		$trans_dt           =   $_POST['trans_dt'];
		$trans_cd           =   $_POST['trans_cd'];
		$approval_status    =   $this->input->post('status');
		$no_of_days         =   $_POST['no_of_days'];
		$leave_type         =   $_POST['leave_type'];
		$cl_bal             =   $_POST['cl_bal'];
		$el_bal             =   $_POST['el_bal'];
		$ml_bal             =   $_POST['ml_bal'];
		
		$approved_by = $this->session->userdata('loggedin')['user_id'];
		$approved_dt = date('Y-m-d');
		$approve_remarks = $this->input->post('approve_remarks');
		$this->LeaveM->approveLeaveApplication($trans_dt, $trans_cd, $approval_status, $approved_by, $approved_dt,$no_of_days,$leave_type,$cl_bal,$el_bal,$ml_bal,$approve_remarks);
		//redirect('leave/firstApproval');
		echo "<script> alert('Successfully Updated');
				document.location= 'firstApproval' </script>";

	}

	// For Rejection of leave-- 
	public function rejectLeaveApplication()
	{

		$trans_dt           =       $_POST['trans_dt'];
		$trans_cd           =       $_POST['trans_cd'];
		$approval_status    =       'R';

		$approved_by = $this->session->userdata('loggedin')['user_id'];
		$approved_dt = date('Y-m-d');

		$this->LeaveM->rejectLeaveApplication($trans_dt, $trans_cd, $approval_status, $approved_by, $approved_dt);

		redirect('leave/firstApproval'); 

	}


	//////////////////////////////////////////
	// For MATERNITY LEAVE APPROVAl -- 
	/////////////////////////////////////////
	public function matLeaveApproval()
	{

		$this->load->view('post_login/main');

		$tableData['data'] = $this->LeaveM->f_get_matLeave_approval_tableData();
		$this->load->view('approval/matTable', $tableData);

		$this->load->view('post_login/footer');

	}

	public function approveMatLeave()
	{

		$trans_cd = $this->input->get('transCd');
		$trans_dt = $this->input->get('dt');

		$viewData['data'] = $this->LeaveM->f_get_matLeave_approval_view($trans_cd, $trans_dt);

		$this->load->view('post_login/main');
		$this->load->view('approval/matView', $viewData);
		$this->load->view('post_login/footer');

	}

	public function approveMatLeaveApplication()
	{

		$trans_dt           =       $_POST['trans_dt'];
		$trans_cd           =       $_POST['trans_cd'];
		$approval_status    =       'A';

		$approved_by = $this->session->userdata('loggedin')['user_id'];
		$approved_dt = date('Y-m-d');

		$this->LeaveM->approveMatLeaveApplication($trans_dt, $trans_cd, $approval_status, $approved_by, $approved_dt);

		//redirect('leave/firstApproval');
		echo "<script> alert('Successfully Approved');
				document.location= 'matLeaveApproval' </script>";

	}

	public function rejectMatLeaveApplication()
	{

		$trans_dt           =       $_POST['trans_dt'];
		$trans_cd           =       $_POST['trans_cd'];
		$approval_status    =       'R';

		$approved_by = $this->session->userdata('loggedin')['user_id'];
		$approved_dt = date('Y-m-d');

		$this->LeaveM->approveMatLeaveApplication($trans_dt, $trans_cd, $approval_status, $approved_by, $approved_dt);

		redirect('leave/matLeaveApproval');
		
	}

	/////////////////////////////////////////////
	// For Deduction --- 
	////////////////////////////////////////////
	public function deduction()
	{

		$this->load->view('post_login/main');

		$tableData['data'] = $this->LeaveM->f_get_deduction_tableData();
		$this->load->view('deduction/table', $tableData);

		$this->load->view('post_login/footer');

	}


	public function adjustLeave()
	{

		$trans_dt = $this->input->get('dt');
		$trans_cd = $this->input->get('transCd');

		$this->load->view('post_login/main');

		$tableData['data'] = $this->LeaveM->f_get_leaveApply_editData($trans_dt, $trans_cd);
		$this->load->view('deduction/show', $tableData);

		$this->load->view('post_login/footer');

	}

	// For leave adjustment--
	public function adjustLeaveApplication()
	{

		$trans_dt           =       $_POST['trans_dt'];
		$trans_cd           =       $_POST['trans_cd'];
		$emp_no             =       $_POST['emp_no'];
		$approval_status    =       'F';

		$leave_type         =       $_POST['leave_type'];
		$no_of_days         =       $_POST['no_of_days'];

		$leaveBalance = $this->LeaveM->f_get_leaveBal_for_adjustment($trans_dt, $trans_cd, $emp_no);
		
		$leaveBalanceArray = $leaveBalance[0];
		
		$clBal = $leaveBalanceArray->cl_bal; 
		$elBal = $leaveBalanceArray->el_bal; 
		$mlBal = $leaveBalanceArray->ml_bal;
		$odBal = $leaveBalanceArray->od_bal;

		if($leave_type == 'CL')
		{
			$cl_bal = ($clBal-$no_of_days);
			$el_bal = $elBal;
			$ml_bal = $mlBal;
			$od_bal = $odBal;
		}
		elseif($leave_type == 'EL')
		{
			$cl_bal = $clBal;
			$el_bal = ($elBal-$no_of_days);
			$ml_bal = $mlBal;
			$od_bal = $odBal;
		}
		elseif($leave_type == 'ML')
		{
			$cl_bal = $clBal;
			$el_bal = $elBal;
			$ml_bal = ($mlBal-($no_of_days)*2);
			$od_bal = $odBal;
		}
		elseif($leave_type == 'OD')
		{
			$cl_bal = $clBal;
			$el_bal = $elBal;
			$ml_bal = $mlBal;
			$od_bal = ($odBal-$no_of_days);
		}

		// $approved_by = $this->session->userdata('loggedin')['user_id'];
		// $approved_dt = date('Y-m-d');

		$this->LeaveM->adjustLeaveApplication($trans_dt, $trans_cd, $approval_status, $cl_bal, $el_bal, $ml_bal);

		//redirect('leave/deduction'); 
		echo "<script> alert('Successfully Adjusted');
				document.location= 'deduction' </script>";

	}


	///////////////////////////////////////////////
					// For Roll Back -- 
	public function rollBack()
	{

		$this->load->view('post_login/main');

		$this->load->view('deduction/rollBack');

		$this->load->view('post_login/footer');

	}


	public function js_get_applnDtls_for_rollback() // For JS
	{

		$docket = $this->input->get('docketNo');

		$result = $this->LeaveM->js_get_applnDtls_for_rollback($docket);
		echo json_encode($result);

	}

	public function rollBackEntry()
	{

		// if($this->session->userdata('loggedin'))
		// {
		//     $created_by   =  $this->session->userdata('loggedin')['user_id']; 
		// }

		// $created_dt       =     date('y-m-d H:i:s');

		if($_SERVER["REQUEST_METHOD"] == "POST")
		{

			$docket_no          =        $_POST['docket_no'];
			$status             =        $_POST['status'];
			$from_dt            =        $_POST['from_dt'];
			$to_dt              =        $_POST['to_dt'];
			$no_of_days         =        $_POST['no_of_days'];
			$leave_type         =        $_POST['leave_type'];
			$action             =        $_POST['action'];
			$rlb_message        =        $_POST['rlb_message'];
			$emp_name           =        $_POST['emp_name'];
			$emp_no             =        $_POST['emp_no'];
			$trans_dt           =        $_POST['trans_dt'];
			$trans_cd           =        $_POST['trans_cd'];

			if($status == 'Approved')
			{

				if($action == 'R')
				{
					$rollBackValue = array('from_dt' => $from_dt,
											'to_dt' => $to_dt,
											'no_of_days' => $no_of_days,
											'rollback_reason' => $rlb_message );

					$this->LeaveM->f_rollback_approvedLeave($rollBackValue, $docket_no, $emp_no);

					echo "<script> alert('Roll back done...');
						document.location= 'rollBack' </script>";

				}
				elseif($action == 'C')
				{

					$approval_status = 'R';
					$array = array('approval_status' => $approval_status,
									'rollback_reason' => $rlb_message );

					$this->LeaveM->f_rollback_rejectLeave($docket_no, $emp_no, $array);

					echo "<script> alert('Leave has been rejected...');
						document.location= 'rollBack' </script>";

				}

			}
			elseif($status == 'Finalized')
			{

				$leaveBalance['balanceData'] = $this->LeaveM->f_previous_leaveBal_for_rollBack($emp_no, $docket_no);

				$balanceData = $leaveBalance['balanceData'][0];

				$clBal = $balanceData->cl_bal; 
				$elBal = $balanceData->el_bal; 
				$mlBal = $balanceData->ml_bal; 
				$odBal = $balanceData->od_bal; 

				if($leave_type == 'CL')
				{
					$cl_bal = ($clBal-$no_of_days);
					$el_bal = $elBal;
					$ml_bal = $mlBal;
					$od_bal = $odBal;
				}
				elseif($leave_type == 'EL')
				{
					$cl_bal = $clBal;
					$el_bal = ($elBal-$no_of_days);
					$ml_bal = $mlBal;
					$od_bal = $odBal;
				}
				elseif($leave_type == 'ML')
				{
					$cl_bal = $clBal;
					$el_bal = $elBal;
					$ml_bal = ($mlBal-($no_of_days)*2);
					$od_bal = $odBal;
				}
				elseif($leave_type == 'OD')
				{
					$cl_bal = $clBal;
					$el_bal = $elBal;
					$ml_bal = $mlBal;
					$od_bal = ($odBal-$no_of_days);
				}

				$balanceArray = array('from_dt' => $from_dt,
									'to_dt' => $to_dt,
									'no_of_days' => $no_of_days,
									'cl_bal' => $cl_bal,
									'el_bal' =>$el_bal,
									'ml_bal' => $ml_bal,
									'od_bal' => $od_bal,
									'rollback_reason' => $rlb_message );


				$this->LeaveM->f_rollback_finalizedLeave($balanceArray, $docket_no, $emp_no);

				echo "<script> alert('Roll back done...');
						document.location= 'rollBack' </script>";

			}

		}

	}

	/////////////////////////////////////////////////////
	// For REPORT/ personalLedger --> 
	////////////////////////////////////////////////////
	public function personalLedger()
	{
		if($_SERVER['REQUEST_METHOD'] == "POST") {

		$emp_cd = $this->session->userdata['loggedin']['emp_cd'];
		$year = $this->input->post('year');
		$result['opening_bal'] = $this->LeaveM->f_get_report_openingBalances($emp_cd,$year);
		$result['leavedtls'] = $this->LeaveM->f_get_leavedtls($emp_cd,$year);
		$first_alloc = $year.'-06-30';
		$second_alloc = $year.'-07-01';
		
		$result['newleave']  = $this->LeaveM->f_get_particulars('td_leave_dtls',NULL,array('trans_type'=>'A','emp_no'=>$emp_cd,'trans_dt <='=>$first_alloc),1);
		$result['newleaves']  = $this->LeaveM->f_get_particulars('td_leave_dtls',NULL,array('trans_type'=>'A','emp_no'=>$emp_cd,'trans_dt >='=>$second_alloc),1);
		$result['leavedtlss'] = $this->LeaveM->f_get_leavedtlssecond($emp_cd,$year);
		
		$empName = $this->LeaveM->f_get_leaveApply_employeeName($emp_cd);
		$result['empName'] = $empName->emp_name;
		$result['empNo'] = $emp_cd;

		$this->load->view('post_login/payroll_main');
		$this->load->view('reports/personalLedger', $result);
		$this->load->view('post_login/footer');
		//$this->showPersonalLedgers($emp_cd,$year);
		}else{
			$this->load->view('post_login/payroll_main');
			$this->load->view('reports/personalLedger');
			$this->load->view('post_login/footer');
		}	

	}
	public function showPersonalLedgers($emp_cd,$year)
	{
		
		$result['opening_bal'] = $this->LeaveM->f_get_report_openingBalances($emp_cd,$year);
		$result['leavedtls'] = $this->LeaveM->f_get_leavedtls($emp_cd,$year);
		 $first_alloc = $year.'-06-30';
		 $second_alloc = $year.'-07-01';
		
		$result['newleave']  = $this->LeaveM->f_get_particulars('td_leave_dtls',NULL,array('trans_type'=>'A','emp_no'=>$emp_cd,'trans_dt <='=>$first_alloc),1);
		$result['newleaves']  = $this->LeaveM->f_get_particulars('td_leave_dtls',NULL,array('trans_type'=>'A','emp_no'=>$emp_cd,'trans_dt >='=>$second_alloc),1);
		$result['leavedtlss'] = $this->LeaveM->f_get_leavedtlssecond($emp_cd,$year);
		
		$empName = $this->LeaveM->f_get_leaveApply_employeeName($emp_cd);
		$result['empName'] = $empName->emp_name;
		$result['empNo'] = $emp_cd;

		$this->load->view('post_login/payroll_main');
		$this->load->view('reports/personalLedger', $result);
		$this->load->view('post_login/footer');
	}

	public function showPersonalLedger($emp_cd)
	{
		//$result['opening'] = $this->LeaveM->f_get_report_leave_dtl($emp_cd);
		$result['opening_bal'] = $this->LeaveM->f_get_report_openingBalance($emp_cd);
		$result['leavedtls'] = $this->LeaveM->f_get_leavedtls($emp_cd);
		//$where1 = array('trans_type'=>'T','emp_no'=>$emp_cd,'trans_dt >='=>'2022-01-01','trans_dt <='=>'2022-06-30');

		$result['newleave']  = $this->LeaveM->f_get_particulars('td_leave_dtls',NULL,array('trans_type'=>'A','emp_no'=>$emp_cd,'trans_dt <='=>'2022-06-30'),1);
		$result['newleaves']  = $this->LeaveM->f_get_particulars('td_leave_dtls',NULL,array('trans_type'=>'A','emp_no'=>$emp_cd,'trans_dt >='=>'2022-07-01'),1);
		$result['leavedtlss'] = $this->LeaveM->f_get_leavedtlssecond($emp_cd);
		
		$empName = $this->LeaveM->f_get_leaveApply_employeeName($emp_cd);
		$result['empName'] = $empName->emp_name;
		$result['empNo'] = $emp_cd;

		$this->load->view('post_login/main');
		$this->load->view('report/personalLedger', $result);
		$this->load->view('post_login/footer');

	}
	
	public function personalLedgertot()
	{
		if($_SERVER["REQUEST_METHOD"] == "POST")
		{
		$emp_cd = $this->session->userdata['loggedin']['emp_cd'];
		$from_dt    =   $_POST['from_date'];
		$to_dt      =   $_POST['to_date'];
		$this->showPersonalLedgertot($emp_cd,$from_dt,$to_dt);
		}else{
			
			$this->load->view('post_login/main');
			$this->load->view('report/inputPersonalledger');
			$this->load->view('post_login/footer');
			
		}

	}

	public function showPersonalLedgertot($emp_cd,$from_dt,$to_dt)
	{
		$result['opening'] = $this->LeaveM->f_get_report_leave_dtl_datewise($emp_cd,$from_dt,$to_dt);
		$result['opening_bal'] = $this->LeaveM->f_get_report_openingBalance($emp_cd);
		//$result['leavedtls'] = $this->LeaveM->f_get_leavedtls($emp_cd);
		
			 // $result['transaction'] = $this->LeaveM->f_get_report_transactionBalance($emp_cd);
			// $latestTransactionDt = $this->LeaveM->f_get_latest_transDt($emp_cd);
		   // $maxTransDt = $latestTransactionDt->trans_dt;
		  // $latestTransactionId = $this->LeaveM->f_get_latest_transDtId($maxTransDt, $emp_cd);
		 // $maxTransId = $latestTransactionId->trans_cd; 
		// $result['closing'] = $this->LeaveM->f_get_report_closingBalance($emp_cd, $maxTransDt, $maxTransId);
		
		$empName = $this->LeaveM->f_get_leaveApply_employeeName($emp_cd);
		$result['empName'] = $empName->emp_name;
		$result['empNo'] = $emp_cd;
		$result['from_dt'] = $from_dt;
		$result['to_dt']   = $to_dt;
		$this->load->view('post_login/main');
		$this->load->view('report/personalLedgeroutput', $result);
		$this->load->view('post_login/footer');

	}

	
	public function employeeLedger()
	{

		$empData['data'] = $this->LeaveM->f_get_employeeData();
		$this->load->view('post_login/payroll_main');
		$this->load->view('report/selectEmployee', $empData);
		$this->load->view('post_login/footer');

	}


	public function getleaveLedger($emp_cd,$from_dt,$to_dt)
	{
		$result['opening'] = $this->LeaveM->f_get_monthly_leave_dtl($emp_cd,$from_dt,$to_dt);
		//$result['opening'] = $this->LeaveM->f_get_six_monthly_leave_dtl($emp_cd,$from_dt,$to_dt);
		
			  // $result['opening'] = $this->LeaveM->f_get_report_openingBalance($emp_cd);
			 // $result['transaction'] = $this->LeaveM->f_get_report_transactionBalance($emp_cd);

			// $latestTransactionDt = $this->LeaveM->f_get_latest_transDt($emp_cd);
		   // $maxTransDt = $latestTransactionDt->trans_dt;
		  // $latestTransactionId = $this->LeaveM->f_get_latest_transDtId($maxTransDt, $emp_cd);
		 // $maxTransId = $latestTransactionId->trans_cd; 
		// $result['closing'] = $this->LeaveM->f_get_report_closingBalance($emp_cd, $maxTransDt, $maxTransId);
		
		$empName = $this->LeaveM->f_get_leaveApply_employeeName($emp_cd);
		$result['empName'] = $empName->emp_name;
		$result['empNo'] = $emp_cd;
		$result['from_dt'] = $from_dt;
		$result['to_dt'] = $to_dt;
		$this->load->view('post_login/main');

		$this->load->view('report/leaveLedger', $result);

		$this->load->view('post_login/footer');

	}
	
	public function showEmployeeLedger()
	{

		$emp_cd           =       $_POST['emp_no'];
		$from_dt    =   $_POST['from_date'];

		$to_dt      =   $_POST['to_date'];

		// $this->showPersonalLedger($emp_cd); // calling same function for this report
		$this->getleaveLedger($emp_cd,$from_dt,$to_dt );
		// echo $this->db->last_query();
		// die(); 
	}
	
	public function empLedgerSixmonthly()
	{

		$this->load->view('post_login/main');
		$empData['data'] = $this->LeaveM->f_get_employeeData();
		$this->load->view('report/selectEmployeeSixmonthly', $empData);
		$this->load->view('post_login/footer');

	}


	public function getleaveLedgerSixmonthly($emp_cd,$year,$semester)
	{
		//$result['opening'] = $this->LeaveM->f_get_six_monthly_leave_dtl($emp_cd,$year,$semester);
		$year      = $this->input->post('year');
		$semester  = $this->input->post('semester');
		
		if($semester == 2){
		   
			$year_check = explode('-',$year)[0];
			if($year_check % 4 == 0){
				$to_dt = date('Y-m-d', strtotime($year. ' + 181 days'));
				
			}else{
				$to_dt = date('Y-m-d', strtotime($year. ' + 180 days'));
			}
			   $rfrdate = $year_check.'-07-01';
			   $todate = $year_check.'-12-31';
			
			$result['sixmonthope'] = $this->LeaveM->f_get_firstsix_monthrecord($emp_cd,$year,$to_dt);
			$result['sixmonth']    = $this->LeaveM->f_get_firstsix_monthrecord($emp_cd,$rfrdate,$todate);
			$result['from_dt'] = $rfrdate;
			$result['to_dt'] = $todate;
		}else{

			$year_check = explode('-',$year)[0];
			if($year_check % 4 == 0){
				$to_dt = date('Y-m-d', strtotime($year. ' + 181 days'));
				
			}else{
				$to_dt = date('Y-m-d', strtotime($year. ' + 180 days'));
			}
		  
			$result['sixmonth']    = $this->LeaveM->f_get_firstsix_monthrecord($emp_cd,$year,$to_dt);
		 
			$result['from_dt'] = $year;
			$result['to_dt'] = $to_dt;
		}
		
		$result['opening'] = $this->LeaveM->f_get_employee_leave_opening($emp_cd,$year);
		$empName = $this->LeaveM->f_get_leaveApply_employeeName($emp_cd);
		$result['empName'] = $empName->emp_name;
		$result['empNo'] = $emp_cd;
		
		$this->load->view('post_login/main');

		$this->load->view('report/leaveLedgerSixmonthly', $result);

		$this->load->view('post_login/footer');

	}
	
	public function showEmpLedgerSixmonthly()
	{

		$emp_cd           =       $_POST['emp_no'];
		$year    =   $_POST['year'];

		$semester      =   $_POST['semester'];
		// $this->showPersonalLedger($emp_cd); // calling same function for this report
		$this->getleaveLedgerSixmonthly($emp_cd,$year,$semester); 
	}

	public function notesheetLeave()
	{
		$this->load->view('post_login/main');
		$emp_cd = $this->session->userdata['loggedin']['emp_cd'];
		$tableData['data'] = $this->LeaveM->f_get_leavenotesheet($emp_cd);
		$this->load->view('apply/notesheet_table', $tableData);
		$this->load->view('post_login/footer');
	}
	public function js_validate_docket_no(){
		$docket_no = trim($this->input->get('docket_no'));
		$result = $this->LeaveM->f_get_particulars2('td_docket_no',NULL,array('docket_no'=>$docket_no),1);
		$query1 = 
			$this->LeaveM->f_get_particulars2('td_file',array('ifnull(count(docket_no),0) cnt'),array('docket_no'=>$docket_no),1);
	
		 if ($query1->cnt == 0){
			  if($result){
				$query = $this->db->get_where('td_leave_dtls', array('docket_no =' => $docket_no))->result();
				if (count($query) == 0)
				{
					$status  = 1 ;
				}else{
					$status  = 2 ;
				}
			  
			 }else{
				$status  = 0 ;
			 }
		 }else{
					$status  = 2 ;
			}
		
		 echo $status;
	}
	
	//For Leave Application Edit --> 
	public function generatentsh()
	{
		$trans_dt = $this->input->get('dt');
		$trans_cd = $this->input->get('transCd');
		$editData['data'] = $this->LeaveM->f_get_leaveApply_editData($trans_dt, $trans_cd);
		$this->load->view('post_login/main');
		$this->load->view('apply/edit_ntst', $editData);
		$this->load->view('post_login/footer');
	}
	
   public function updateLeaventst()
	{

		if($this->session->userdata('loggedin'))
		{
			$modified_by   =  $this->session->userdata('loggedin')['user_id']; 
		}

		$modified_dt       =     date('y-m-d H:i:s');

		if($_SERVER["REQUEST_METHOD"] == "POST")
		{

			$trans_dt           =           $_POST['trans_dt'];
			$trans_cd           =           $_POST['trans_cd'];
			$emp_no             =           $_POST['emp_no'];
			$emp_name           =           $_POST['emp_name'];
			//$leave_type         =           $_POST['leave_type'];
			//$from_dt            =           $_POST['from_dt'];
			//$to_dt              =           $_POST['to_dt'];
			//$no_of_days         =           $_POST['no_of_days'];
			$letterfirstline    =           $_POST['letterfirstline'];
			$remarks            =           $_POST['remarks'];

			//$this->LeaveM->updateLeaveApplication($trans_dt,$trans_cd,$emp_no,$emp_name,$leave_type,$from_dt,$to_dt,$no_of_days,$letterfirstline,$remarks,$modified_by,$modified_dt);
			$this->LeaveM->updateLeaveApplication($trans_dt,$trans_cd,$emp_no,$emp_name,$letterfirstline,$remarks,$modified_by,$modified_dt);
			echo "<script> alert('Successfully Updated');
				document.location= 'notesheetLeave' </script>";

		}
		else
		{

			echo "<script> alert('Sorry! Try again');
				document.location= 'notesheetLeave' </script>";
		}


	}
}
