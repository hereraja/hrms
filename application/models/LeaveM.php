<?php

	defined('BASEPATH') OR exit('No direct script access allowed');

    class LeaveM extends CI_Model
    {
		public function f_get_particulars2($table_name, $select=NULL, $where=NULL, $flag=NULL) {

			 $db2 = $this->load->database('db2', TRUE);

			if(isset($select)) {

				$db2->select($select);

			}

			if(isset($where)) {

				$db2->where($where);

			}

			$result		=	$db2->get($table_name);

			if($flag == 1) {

				return $result->row();
				
			}else {

				return $result->result();

			}

		}
        public function f_get_particulars($table_name, $select=NULL, $where=NULL, $flag =NULL) {

            //$db2 = $this->load->database('db2', TRUE);

           if(isset($select)) {

               $this->db->select($select);

           }

           if(isset($where)) {

            $this->db->where($where);

           }

           $result		=	$this->db->get($table_name);

           if($flag == 1) {

               return $result->row();
               
           }else {

               return $result->result();

           }

       }
       public function f_edit($table_name, $data_array, $where) {

        $this->db->where($where);
        $this->db->update($table_name, $data_array);

        return ;

      }
        public function f_get_leaveType_table()
        {

            $sql = $this->db->query(" SELECT * FROM md_leave_allocation ");
            return $sql->result();

        }


        public function f_get_leaveType_max_slNo() // FOr md_leave_allocation table's sl_no
        {

            $sql = $this->db->query(" SELECT MAX(sl_no) AS sl_no FROM md_leave_allocation ");
            return $sql->row();

        }

        public function leaveTypeEntry($sl_no, $type, $start_month, $end_month, $amount, $credit_on, $created_by, $created_dt)
        {

            $value = array('sl_no' => $sl_no,
                            'type' => $type,
                            'start_month' => $start_month,
                            'end_month' => $end_month,
                            'amount' => $amount,
                            'credit_on' => $credit_on,
                            'created_by' =>  $created_by,
                            'created_dt' => $created_dt );

            $this->db->insert('md_leave_allocation', $value);

        }


        public function f_get_leaveType_editData($sl_no)
        {

            $sql = $this->db->query(" SELECT * FROM md_leave_allocation WHERE sl_no = $sl_no ");
            return $sql->result();

        }

        public function updateLeaveType($sl_no, $type, $start_month, $end_month, $amount, $credit_on, $modified_by, $modified_dt)
        {

            $value = array('sl_no' => $sl_no,
                            'type' => $type,
                            'start_month' => $start_month,
                            'end_month' => $end_month,
                            'amount' => $amount,
                            'credit_on' => $credit_on,
                            'modified_by' => $modified_by,
                            'modified_dt' => $modified_dt );

            $this->db->where('sl_no', $sl_no);
            $this->db->update('md_leave_allocation', $value);

        }


        public function deleteLeaveType($sl_no)
        {

            $sql = $this->db->query(" DELETE FROM md_leave_allocation WHERE sl_no = $sl_no ");

        }



        /////////////////////////////////////
        // for Leave Allocation table --
        /////////////////////////////////////

        public function f_get_leaveAlloaction_table()
        {

            $sql = $this->db->query(" SELECT * FROM td_leave_dtls WHERE trans_type = 'O'
                                    AND YEAR(trans_dt) = YEAR(CURDATE()) ");
            return $sql->result();

        }

        public function f_get_active_employees()
        {

            $sql = $this->db->query(" SELECT DISTINCT a.emp_no FROM td_leave_dtls a, md_employee b 
                                    WHERE a.emp_no = b.emp_code 
                                    AND a.emp_name = b.emp_name 
                                    AND b.emp_status = 'A'"
                                     );
                                     
            return $sql->result();

        }

        public function f_get_tableData_forAllocation($emp_no, $trans_dt, $trans_cd)
        {

            $sql = $this->db->query("SELECT emp_no, emp_name, cl_bal, el_bal, ml_bal, od_bal,eo_bal,stu_bal FROM td_leave_dtls 
                                    WHERE trans_type = 'A' ");

            return $sql->result();

        }

        public function f_get_employeeData()
        {

            $sql = $this->db->query(" SELECT emp_code, emp_name FROM md_employee where emp_status = 'A' ");
            return $sql->result();

        }

        public function f_get_maxTransDt_forAllocation($emp_cd)
        {

            $sql = $this->db->query(" SELECT MAX(trans_dt) AS trans_dt FROM td_leave_dtls WHERE emp_no = '$emp_cd' ");
            return $sql->row();

        }

        public function f_get_maxTransCd_forAllocation($emp_cd, $trans_dt)
        {

            $sql = $this->db->query(" SELECT MAX(trans_cd) AS trans_cd FROM td_leave_dtls WHERE emp_no = '$emp_cd' AND trans_dt = '$trans_dt' ");
            return $sql->row();

        }

        public function js_get_currentBal_forAllocation($emp_cd, $trans_dt, $trans_cd)
        {
            if($trans_cd){
                $sql = $this->db->query(" SELECT cl_bal, el_bal, ml_bal, od_bal FROM td_leave_dtls WHERE
                trans_dt = '$trans_dt' AND trans_cd = $trans_cd AND emp_no = '$emp_cd' ");
            }else{
                $sql = $this->db->query(" SELECT cl_bal, el_bal, ml_bal, od_bal FROM td_leave_dtls WHERE
                trans_dt = '$trans_dt' AND trans_cd = NULL AND emp_no = '$emp_cd' ");
            }
            
            return $sql->result();

        }

        public function f_get_allocation_transCd($trans_dt)
        {

            $sql = $this->db->query(" SELECT MAX(trans_cd) AS trans_cd FROM td_leave_dtls WHERE trans_dt = '$trans_dt' ");
            return $sql->row();

        }
        
        public function f_get_allocation_empName($emp_no)
        {

            $sql = $this->db->query(" SELECT emp_name FROM md_employee WHERE emp_code = $emp_no ");
            return $sql->row();

        }

        // for allocation entry --
        public function leaveAllocationEntry($trans_dt, $trans_cd, $trans_type, $emp_no, $emp_name, $docket_no,
                                                $leave_type, $leave_mode, $from_dt, $to_dt, $remarks, $approval_status,
                                                $approved_dt, $approved_by, $rollback_reason, $roll_dt, $roll_by, 
                                                $cl_bal, $el_bal, $ml_bal, $od_bal,$eo_bal,$stu_bal, $created_by, $created_dt)
        {
            $where = array('year' => date('Y'));
            $resuldk = $this->f_get_particulars('td_leave_dtls',array('IFNULL(MAX(trans_no),0) as trans_no'),$where,1);
			
            $trans_no = (int)($resuldk->trans_no) +1;

            $value = array('trans_dt' => $trans_dt,
                            'trans_cd' => $trans_cd,
                            'trans_type' => $trans_type,
                            'emp_no' => $emp_no,
                            'emp_name' => $emp_name,
                            'trans_no' =>$trans_no,
                            'year'   => date("Y"),
                            'docket_no' => $docket_no,
                            'leave_type' => $leave_type,
                            'leave_mode' => $leave_mode,
                            'from_dt' => '',
                            'to_dt' => '',
                            'remarks' => 'Leave Allocation',
                            'approval_status' => $approval_status,
                            'approved_dt' => $approved_dt,
                            'approved_by' => $approved_by,
                            'rollback_reason' => $rollback_reason,
                            'roll_dt' => $roll_dt,
                            'roll_by' => $roll_by,
                            'cl_bal' => $cl_bal,
                            'el_bal' => $el_bal,
                            'ml_bal' => $ml_bal,
                            'od_bal' => $od_bal,
                            'eo_bal' => $eo_bal,
                            'stu_bal' => $stu_bal,
                            'created_by' => $created_by,
                            'created_dt' => $created_dt );

            $this->db->insert('td_leave_dtls', $value);

        }

        public function f_get_allocation_editData($trans_cd, $trans_dt)
        {

            $sql = $this->db->query(" SELECT * FROM td_leave_dtls WHERE trans_dt = '$trans_dt' AND trans_cd = $trans_cd ");
            return $sql->result();

        }

        public function updateLeaveAllocation($trans_dt, $trans_cd, $emp_no, $cl_bal, $el_bal, $ml_bal, $modified_by, $modified_dt)
        {

            $value = array('emp_no' => $emp_no,
                            'cl_bal' => $cl_bal,
                            'el_bal' => $el_bal,
                            'ml_bal' => $ml_bal,
                            'modified_by' => $modified_by,
                            'modified_dt' => $modified_by );

            $this->db->where('trans_dt', $trans_dt);
            $this->db->where('trans_cd', $trans_cd);
            $this->db->update('td_leave_dtls', $value);

        }


        public function deleteLeaveAllocation($trans_dt, $trans_cd)
        {

            $sql = $this->db->query(" DELETE FROM td_leave_dtls WHERE trans_dt = '$trans_dt' AND trans_cd = $trans_cd ");

        }

        //////////////////////////////////
        // For Leave Applicaton --> 
        /////////////////////////////////
        public function f_get_leaveAppliedDtls($emp_cd)
        {

           // $sql = $this->db->query(" SELECT * FROM td_leave_dtls WHERE emp_no = $emp_cd AND YEAR(trans_dt) = YEAR(CURDATE()) AND trans_type = 'T' ");
            $sql = $this->db->query(" SELECT * FROM td_leave_dtls WHERE emp_no = $emp_cd AND trans_type = 'T' ");
            return $sql->result();

        }

        // For JS
        public function js_get_maxTransDt($emp_cd)
        {

            $sql = $this->db->query(" SELECT MAX(trans_dt) as trans_dt FROM td_leave_dtls WHERE emp_no = $emp_cd ");
            return $sql->row();

        }


        // for JS 
        public function js_get_apply_leaveBalance($leave_type, $emp_cd, $trans_dt)
        {

            $sql = $this->db->query(" SELECT emp_name, cl_bal, el_bal, ml_bal, od_bal FROM td_leave_dtls WHERE emp_no = '$emp_cd' AND 
                                    trans_dt = '$trans_dt'
                                    AND trans_cd = (SELECT MAX(trans_cd) FROM td_leave_dtls WHERE emp_no = '$emp_cd' AND trans_dt = '$trans_dt' ) ");
                                    
            
            return $sql->result();

        }

        public function f_get_leaveApply_employeeName($emp_no)
        {

            $sql = $this->db->query(" SELECT emp_name FROM md_employee WHERE emp_code = $emp_no ");
            return $sql->row();

        }

        public function f_get_leaveBal_on_maxTransaction($emp_no)
        {

            $sql = $this->db->query(" SELECT cl_bal, el_bal, ml_bal, od_bal FROM td_leave_dtls WHERE emp_no = $emp_no AND 
                                    trans_dt = (SELECT MAX(trans_dt) FROM td_leave_dtls WHERE emp_no = $emp_no)
                                    AND trans_cd = (SELECT trans_cd FROM td_leave_dtls WHERE emp_no = $emp_no 
                                    AND trans_dt = (SELECT MAX(trans_dt) FROM td_leave_dtls WHERE emp_no = $emp_no) ) ");
                                     
            return $sql->result();

        }

        public function leaveApplyEntry($trans_dt, $trans_cd, $trans_type, $emp_no, $emp_name,$trans_no,$year,$docket_no,$leave_type, 
                                        $from_dt, $to_dt, $no_of_days, $leave_mode, $approval_status,$letterfirstline,$remarks, $cl_bal, $el_bal, $ml_bal, $od_bal, $created_by, $created_dt )
        {

            $value = array('trans_dt' => $trans_dt,
                            'trans_cd' => $trans_cd,
                            'trans_type' => $trans_type,
                            'emp_no' => $emp_no,
                            'emp_name' => $emp_name,
                            'trans_no' => $trans_no,
                            'year'     => $year,
                            'docket_no' => $docket_no,
                            'leave_type' => $leave_type,
                            'from_dt' => $from_dt,
                            'to_dt' => $to_dt,
                            'no_of_days' => $no_of_days,
                            'leave_mode' => $leave_mode,
                            'approval_status' => $approval_status,
                           // 'letterfirstline' => $letterfirstline,
                            'remarks' => $remarks,
                            'cl_bal' => $cl_bal,
                            'el_bal' => $el_bal,
                            'ml_bal' => $ml_bal,
                            'od_bal' => $od_bal,
                            'created_by' => $created_by,
                            'created_dt' => $created_dt );

            $this->db->insert('td_leave_dtls', $value);

        }

        public function f_get_leaveApply_editData($trans_dt, $trans_cd)
        {

            $sql = $this->db->query(" SELECT * FROM td_leave_dtls WHERE trans_dt = '$trans_dt' AND trans_cd = $trans_cd ");
            return $sql->result();

        }
		
		public function f_get_leaveApply_notesheet($trans_dt, $trans_cd)
        {

            $sql = $this->db->query(" SELECT * FROM td_leave_dtls WHERE trans_dt = '$trans_dt' AND trans_cd = $trans_cd ");
            return $sql->row();

        }


        public function updateLeaveApplication($trans_dt, $trans_cd, $emp_no, $emp_name,$letterfirstline,$remarks, $modified_by, $modified_dt )
        {

            $value = array('emp_no' => $emp_no,
                            'emp_name' => $emp_name,
                        //    'leave_type' => $leave_type,
                        //    'from_dt' => $from_dt,
                        //    'to_dt' => $to_dt,
                        //    'no_of_days' => $no_of_days,
                            'letterfirstline'=>$letterfirstline,
                            'remarks' => $remarks,
                            'modified_by' => $modified_by,
                            'modified_dt' => $modified_dt );

            $this->db->where('trans_dt', $trans_dt);
            $this->db->where('trans_cd', $trans_cd);

            $this->db->update('td_leave_dtls', $value);

        }

        public function deleteLeaveApply($trans_dt, $trans_cd)
        {

            $sql = $this->db->query(" DELETE FROM td_leave_dtls WHERE trans_dt = '$trans_dt' AND trans_cd = $trans_cd ");

        }


        ////////////////////////////////////////////////////

        public function f_get_mat_leave_appliedDtls($emp_cd)
        {

            $sql = $this->db->query(" SELECT * FROM td_leave_mat WHERE emp_no = '$emp_cd' ");
            return $sql->result();

        }

        public function js_get_applied_matLeaveDtls($emp_cd)
        {

            $sql = $this->db->query(" SELECT trans_dt, no_of_days FROM td_leave_mat WHERE emp_no = '$emp_cd' ");
            return $sql->result();

        }


        public function f_get_matLeave_transCd($trans_dt)
        {

            $sql = $this->db->query(" SELECT MAX(trans_cd) AS trans_cd FROM td_leave_mat WHERE trans_dt = '$trans_dt' ");
            return $sql->row();

        }


        public function js_check_matLeave_entry($emp_cd)
        {

            $sql = $this->db->query(" SELECT COUNT(*) AS num_row FROM td_leave_mat WHERE emp_no = '$emp_cd' AND approval_status != 'R' ");
            return $sql->row();

        }

        public function matLeaveEntry($trans_dt, $trans_cd, $emp_no, $emp_name, $docket_no, $from_dt, $to_dt, $no_of_days,
        $approval_status, $remarks, $created_by, $created_dt )
        {

            $value = array('trans_dt' => $trans_dt,
                            'trans_cd' => $trans_cd,
                            'emp_no' => $emp_no,
                            'emp_name' => $emp_name,
                            'docket_no' => $docket_no,
                            'from_dt' => $from_dt,
                            'to_dt' => $to_dt,
                            'no_of_days' => $no_of_days,
                            'approval_status' => $approval_status,
                            'remarks' => $remarks,
                            'created_by' => $created_by,
                            'created_dt' => $created_dt );

            $this->db->insert('td_leave_mat', $value);

        }


        public function f_get_matLeave_editDtls($transCd, $transDt)
        {

            $sql = $this->db->query(" SELECT * FROM td_leave_mat WHERE trans_dt = '$transDt' AND trans_cd = '$transCd' ");
            return $sql->result();

        }


        public function f_update_matLeaveEntry($trans_dt, $trans_cd, $docket_no, $from_dt, $to_dt,
                                                $no_of_days, $approval_status, $remarks, $modified_by, $modified_dt )
        {

            $value = array('docket_no' => $docket_no,
                            'from_dt' => $from_dt,
                            'to_dt' => $to_dt,
                            'no_of_days' => $no_of_days,
                            'approval_status' => $approval_status,
                            'remarks' => $remarks,
                            'modified_by' => $modified_by,
                            'modified_dt' => $modified_dt );

            $this->db->where('trans_dt', $trans_dt);
            $this->db->where('trans_cd', $trans_cd);
            $this->db->update('td_leave_mat', $value);

        }

        public function f_delete_matLeave($trans_dt, $trans_cd)
        {

            $sql = $this->db->query(" DELETE FROM td_leave_mat WHERE trans_dt = '$trans_dt' AND trans_cd = '$trans_cd' ");

        }



        ///////////////////////////////////////////////////
        public function f_get_approval_tableData()
        {

            //$sql = $this->db->query(" SELECT * FROM td_leave_dtls WHERE YEAR(trans_dt) = YEAR(CURDATE()) AND trans_type = 'T' AND approval_status = 'U' ");
     //  $sql = $this->db->query(" SELECT * FROM td_leave_dtls WHERE trans_type = 'T' AND approve_lable1 = 'A' AND approval_status = 'U' ");
	   $sql = $this->db->query("SELECT * FROM td_leave_dtls WHERE trans_type = 'T' AND approve_lable1 = 'A' ");
            return $sql->result();

        }

        public function approveLeaveApplication($trans_dt, $trans_cd, $approval_status, $approved_by, $approved_dt,$no_of_days,$leave_type,$cl_bal,$el_bal,$ml_bal,$approve_remarks)
        {
            
        
		if ($leave_type == 'CL') {

			$value = array('approval_status' => $approval_status,
            'approve_remarks' => $approve_remarks,
			'approved_by' => $approved_by,
			'approved_dt' => $approved_dt,
			'cl_bal'=>  $cl_bal - $no_of_days);
		}
		if ($leave_type == 'ML') {
			$value = array('approval_status' => $approval_status,
            'approve_remarks' => $approve_remarks,
			'approved_by' => $approved_by,
			'approved_dt' => $approved_dt,
			'ml_bal'=>  $ml_bal - $no_of_days);  
		 
		} 
    
		if($leave_type == 'EL') {
			
			$value = array('approval_status' => $approval_status,
            'approve_remarks' => $approve_remarks,
		   'approved_by' => $approved_by,
		   'approved_dt' => $approved_dt,
		   'el_bal'=>  $el_bal - $no_of_days);  
			
        }
        if($leave_type == 'STU') {
			
			$value = array('approval_status' => $approval_status,
            'approve_remarks' => $approve_remarks,
		   'approved_by' => $approved_by,
		   'approved_dt' => $approved_dt);  
			
        }   
        if($leave_type == 'EO') {
			
			$value = array('approval_status' => $approval_status,
            'approve_remarks' => $approve_remarks,
		   'approved_by' => $approved_by,
		   'approved_dt' => $approved_dt);  
        }

        $this->db->where('trans_dt', $trans_dt);
        $this->db->where('trans_cd', $trans_cd);
        $this->db->where('leave_type', $leave_type);
        $this->db->update('td_leave_dtls', $value);
           
        }


        public function rejectLeaveApplication($trans_dt, $trans_cd, $approval_status, $approved_by, $approved_dt)
        {

            $value = array('approval_status' => $approval_status,
                            'approved_by' => $approved_by,
                            'approved_dt' => $approved_dt );

            $this->db->where('trans_dt', $trans_dt);
            $this->db->where('trans_cd', $trans_cd);

            $this->db->update('td_leave_dtls', $value);

        }


        ///////////////////////////////////////////
        // For Mat Leave Approval -- 

        public function f_get_matLeave_approval_tableData()
        {

            $sql = $this->db->query(" SELECT * FROM td_leave_mat WHERE approval_status = 'U' ORDER BY trans_dt ");
            return $sql->result();

        }

        public function f_get_matLeave_approval_view($trans_cd, $trans_dt)
        {

            $sql = $this->db->query(" SELECT * FROM td_leave_mat WHERE trans_dt = '$trans_dt' AND trans_cd = '$trans_cd' ");
            return $sql->result();

        }

        public function approveMatLeaveApplication($trans_dt, $trans_cd, $approval_status, $approved_by, $approved_dt)
        {

            $value = array('approval_status' => $approval_status,
                            'approved_by' => $approved_by,
                            'approved_dt' => $approved_dt );

            $this->db->where('trans_dt', $trans_dt);
            $this->db->where('trans_cd', $trans_cd);
            $this->db->update('td_leave_mat', $value);

        }

        /////////////////////////////////////////////////////////
        // For deduction --


        public function f_get_deduction_tableData()
        {

            $sql = $this->db->query(" SELECT * FROM td_leave_dtls WHERE approval_status = 'A' 
                                    AND YEAR(trans_dt) = YEAR(CURDATE()) ");
            return $sql->result();

        }

        public function f_get_leaveBal_for_adjustment($trans_dt, $trans_cd, $emp_no)
        {

            $sql = $this->db->query(" SELECT cl_bal, el_bal, ml_bal, od_bal FROM td_leave_dtls WHERE 
                                    trans_dt = '$trans_dt' AND trans_cd = $trans_cd AND emp_no = $emp_no ");
            
            return $sql->result();

        }


        public function adjustLeaveApplication($trans_dt, $trans_cd, $approval_status, $cl_bal, $el_bal, $ml_bal)
        {

            $value = array('approval_status' => $approval_status,
                            'cl_bal' => $cl_bal,
                            'el_bal' => $el_bal,
                            'ml_bal' => $ml_bal );

            $this->db->where('trans_dt', $trans_dt);
            $this->db->where('trans_cd', $trans_cd);

            $this->db->update('td_leave_dtls', $value);

        }


        ////////////////////////////////
        // For roll back
        public function js_get_applnDtls_for_rollback($docket)
        {

            $sql = $this->db->query(" SELECT * FROM td_leave_dtls WHERE docket_no = '$docket' AND trans_type = 'T' ");
            return $sql->result();

        }

        public function f_rollback_approvedLeave($rollBackValue, $docket_no, $emp_no)
        {

            $this->db->where('docket_no', $docket_no);
            $this->db->where('emp_no', $emp_no);
            $this->db->update('td_leave_dtls', $rollBackValue);

        }

        public function f_previous_leaveBal_for_rollBack($emp_no, $docket_no)
        {

            $sql = $this->db->query(" SELECT cl_bal, el_bal, ml_bal, od_bal FROM td_leave_dtls WHERE emp_no = $emp_no AND 
                                    trans_dt = (SELECT MAX(trans_dt) FROM td_leave_dtls WHERE emp_no = $emp_no AND docket_no != '$docket_no')
                                        AND trans_cd = (SELECT trans_cd FROM td_leave_dtls WHERE emp_no = $emp_no AND docket_no != '$docket_no'
                                        AND trans_dt = (SELECT MAX(trans_dt) FROM td_leave_dtls WHERE emp_no = $emp_no AND docket_no != '$docket_no') ) AND
                                    docket_no != '$docket_no' ");
                                     
            return $sql->result();

        }

        public function f_rollback_rejectLeave($docket_no, $emp_no, $array)
        {

            $this->db->where('docket_no', $docket_no);
            $this->db->where('emp_no', $emp_no);
            $this->db->update('td_leave_dtls', $array);

        }

        public function f_rollback_finalizedLeave($balanceArray, $docket_no, $emp_no)
        {

            $this->db->where('docket_no', $docket_no);
            $this->db->where('emp_no', $emp_no);
            $this->db->update('td_leave_dtls', $balanceArray);

        }


        /////////////////////////////////////////////
                    //For report section 
        ////////////////////////////////////////////
        public function f_get_report_openingBalance($emp_cd)
        {

            $sql = $this->db->query(" SELECT trans_dt, SUM(cl_bal) AS cl_bal, SUM(el_bal) AS el_bal, SUM(ml_bal) AS ml_bal, SUM(od_bal) AS od_bal FROM td_leave_dtls
                                    WHERE emp_no = $emp_cd AND trans_type = 'O'
                                    GROUP BY trans_dt, emp_no, trans_type order by trans_dt DESC");

            return $sql->row();

        }
		public function f_get_report_openingBalances($emp_cd,$year)
        {

            $sql = $this->db->query("SELECT trans_dt, SUM(cl_bal) AS cl_bal, SUM(el_bal) AS el_bal, SUM(ml_bal) AS ml_bal,SUM(stu_bal) AS stu_bal,SUM(eo_bal) AS eo_bal FROM td_leave_dtls
                                    WHERE emp_no = $emp_cd AND trans_type = 'O' AND YEAR(trans_dt) = $year
                                    GROUP BY trans_dt, emp_no, trans_type order by trans_dt DESC");

            return $sql->row();

        }

        public function f_get_report_transactionBalance($emp_cd)
        {

            $sql = $this->db->query(" SELECT trans_dt, docket_no, leave_type, no_of_days, from_dt, to_dt,
             cl_bal, el_bal, ml_bal, od_bal FROM td_leave_dtls
                                    WHERE emp_no = $emp_cd AND trans_type = 'T' /*AND YEAR(trans_dt) = YEAR(CURDATE())*/ AND approval_status = 'A' ");

            return $sql->result();

        }
public function f_get_report_leave_dtl()
{
    $sql = $this->db->query("SELECT  if(from_dt='',trans_dt,from_dt) as from_dt,if(to_dt='',trans_dt,to_dt) as to_dt, trans_dt, SUM(cl_bal) AS cl_ern, SUM(el_bal) AS el_ern, SUM(ml_bal) AS ml_ern, SUM(od_bal) AS od_ern 
                            , docket_no, 0 CL_enj,0 EL_enj,0 ML_enj, cl_bal, el_bal, ml_bal, od_bal
                            FROM td_leave_dtls
                            WHERE emp_no = 12 AND trans_type = 'O' 
                            GROUP BY trans_dt, emp_no, trans_type,docket_no, leave_type, no_of_days, from_dt, to_dt,od_bal
                            UNION
                            SELECT from_dt, to_dt,trans_dt, 0,0,0,0,docket_no, if(leave_type='EL', no_of_days,0)EL_enj,
                            if(leave_type='CL', no_of_days,0)CL_enj,if(leave_type='ML', no_of_days,0)ML_enj,
                            cl_bal, el_bal, ml_bal, od_bal FROM td_leave_dtls
                            WHERE emp_no = 12 AND trans_type = 'T'  AND approval_status = 'A'  order by trans_dt");
return $sql->result();
}
public function f_get_leavedtls($emp_cd,$year){
     $fr= $year.'-01-01';$to =$year.'-06-30';
    $sql = $this->db->query("SELECT from_dt, to_dt,trans_dt,docket_no,leave_type,remarks, if(leave_type='EL', no_of_days,0)EL_enj,
    if(leave_type='CL', no_of_days,0)CL_enj,if(leave_type='ML', no_of_days,0)ML_enj FROM td_leave_dtls
    WHERE emp_no = $emp_cd AND trans_type = 'T'  AND approval_status = 'A' AND from_dt >= '$fr' AND from_dt <= '$to'   order by trans_dt");
    return $sql->result();
}
public function f_get_leavedtlssecond($emp_cd,$year){
    $fr= $year.'-07-01';$to =$year.'-12-31';
    $sql = $this->db->query("SELECT from_dt, to_dt,trans_dt,docket_no,leave_type,remarks, if(leave_type='EL', no_of_days,0)EL_enj,
    if(leave_type='CL', no_of_days,0)CL_enj,if(leave_type='ML', no_of_days,0)ML_enj,if(leave_type='STU', no_of_days,0)STU_enj,if(leave_type='EO', no_of_days,0)EO_enj FROM td_leave_dtls
    WHERE emp_no = $emp_cd AND trans_type = 'T'  AND approval_status = 'A' AND from_dt >= '$fr' AND from_dt <= '$to'  order by trans_dt");
    return $sql->result();
}
public function f_get_report_leave_dtl_datewise($emp_cd,$from_dt,$to_dt)
{
    $sql = $this->db->query("SELECT  if(from_dt='',trans_dt,from_dt) as from_dt,if(to_dt='',trans_dt,to_dt) as to_dt, trans_dt, SUM(cl_bal) AS cl_ern, SUM(el_bal) AS el_ern, SUM(ml_bal) AS ml_ern, SUM(od_bal) AS od_ern 
                            , docket_no, 0 CL_enj,0 EL_enj,0 ML_enj, cl_bal, el_bal, ml_bal, od_bal
                            FROM td_leave_dtls
                            WHERE emp_no = $emp_cd and trans_dt between '$from_dt' and '$to_dt' AND trans_type = 'O' 
                            GROUP BY trans_dt, emp_no, trans_type,docket_no, leave_type, no_of_days, from_dt, to_dt,od_bal
                            UNION
                            SELECT from_dt, to_dt,trans_dt, 0,0,0,0,docket_no,if(leave_type='CL', no_of_days,0)CL_enj, if(leave_type='EL', no_of_days,0)EL_enj,if(leave_type='ML', no_of_days,0)ML_enj,
                            cl_bal, el_bal, ml_bal, od_bal FROM td_leave_dtls
                            WHERE emp_no = $emp_cd and trans_dt between '$from_dt' and '$to_dt' AND trans_type = 'T'  AND approval_status = 'A'  order by trans_dt");
return $sql->result();
}
/****************************************** */
public function f_get_monthly_leave_dtl($emp_cd,$from_dt,$to_dt)
{
    $sql = $this->db->query(" SELECT DATE_FORMAT( if(from_dt='',trans_dt,from_dt),'%d/%m/%Y') as from_dt,DATE_FORMAT(if(to_dt='',trans_dt,to_dt),'%d/%m/%Y') as to_dt,  SUM(cl_bal) AS cl_ern, SUM(el_bal) AS el_ern, SUM(ml_bal) AS ml_ern, SUM(od_bal) AS od_ern 
    , docket_no, 0 EL_enj,0 CL_enj,0 ML_enj, cl_bal, el_bal, ml_bal, od_bal
    FROM td_leave_dtls
    WHERE emp_no = $emp_cd AND trans_type = 'O' 
    GROUP BY  emp_no, trans_type,docket_no, leave_type, no_of_days, from_dt, to_dt,od_bal
    UNION
    SELECT concat('01/',if(CEILING(MONTH(trans_dt)/6)=1,'01','07'),'/',YEAR(trans_dt)),
    concat('01/',if(CEILING(MONTH(trans_dt)/6)=1,'06','12'),'/',YEAR(trans_dt)) , 0,0,0,0,
    sum(if(leave_type='EL', no_of_days,0))EL_enj,
    sum(if(leave_type='CL', no_of_days,0))CL_enj,sum(if(leave_type='ML', no_of_days,0))ML_enj,
    sum(cl_bal)cl_bal , sum(el_bal)el_bal, sum(ml_bal)ml_bal,sum(od_bal)od_bal ,YEAR(trans_dt)
    FROM td_leave_dtls
    WHERE emp_no =$emp_cd AND trans_type = 'T' AND approval_status = 'A'
    and trans_dt between '$from_dt' and '$to_dt'
   GROUP BY YEAR(trans_dt),CEILING(MONTH(trans_dt)/6)
    order by from_dt ");
    
   

   return $sql->result();

}

public function f_get_six_monthly_leave_dtl($emp_cd,$from_dt,$to_dt)
{
    $sql = $this->db->query(" SELECT DATE_FORMAT( if(from_dt='',trans_dt,from_dt),'%d/%m/%Y') as from_dt,DATE_FORMAT(if(to_dt='',trans_dt,to_dt),'%d/%m/%Y') as to_dt,  SUM(cl_bal) AS cl_ern, SUM(el_bal) AS el_ern, SUM(ml_bal) AS ml_ern, SUM(od_bal) AS od_ern 
    , docket_no, 0 EL_enj,0 CL_enj,0 ML_enj, cl_bal, el_bal, ml_bal, od_bal
    FROM td_leave_dtls
    WHERE emp_no = $emp_cd AND trans_type = 'O' 
    GROUP BY  emp_no, trans_type,docket_no, leave_type, no_of_days, from_dt, to_dt,od_bal
    UNION
    SELECT concat('01/',if(CEILING(MONTH(trans_dt)/6)=1,'01','07'),'/',YEAR(trans_dt)),
    concat(if(CEILING(MONTH(trans_dt)/6)=1,'30','31'),'/',if(CEILING(MONTH(trans_dt)/6)=1,'06','12'),'/',YEAR(trans_dt)) , 0,0,0,0,
    sum(if(leave_type='EL', no_of_days,0))EL_enj,
    sum(if(leave_type='CL', no_of_days,0))CL_enj,sum(if(leave_type='ML', no_of_days,0))ML_enj,
    sum(cl_bal)cl_bal , sum(el_bal)el_bal, sum(ml_bal)ml_bal,sum(od_bal)od_bal ,YEAR(trans_dt)
    FROM td_leave_dtls
    WHERE emp_no =$emp_cd AND trans_type = 'T' 
    and trans_dt between '$from_dt' and '$to_dt'
   GROUP BY YEAR(trans_dt),CEILING(MONTH(trans_dt)/6)
    order by from_dt DESC");

   return $sql->result();

}
public function f_get_employee_leave_opening($emp_cd,$year)
{
    $sql = $this->db->query('SELECT sum(cl_bal) as cl_bal,sum(el_bal) el_bal,sum(ml_bal) ml_bal FROM `td_leave_dtls`
      WHERE emp_no = '.$emp_cd.' AND trans_type = "O" AND trans_dt >= "'.$year.'" ');
    $result =  $sql->result();
    return $result;
}
public function f_get_firstsix_monthrecord($emp_cd,$from_dt,$to_dt)
{
    $sql = $this->db->query('SELECT sum(if(leave_type="CL", no_of_days,0)) cl_bal,sum(if(leave_type="EL", no_of_days,0)) el_bal,sum(if(leave_type="ML", no_of_days,0)) ml_bal FROM  `td_leave_dtls`
       WHERE emp_no = '.$emp_cd.' AND trans_type = "T" AND trans_dt >= "'.$from_dt.'" AND trans_dt <= "'.$to_dt.'" AND approval_status ="A" ');
    $result =  $sql->row();
    return $result;
}
       
/********************************************* */
public function f_get_latest_transDt($emp_cd)
        {

            $sql = $this->db->query(" SELECT MAX(trans_dt) AS trans_dt FROM td_leave_dtls WHERE emp_no = $emp_cd 
                                    AND YEAR(trans_dt) = YEAR(CURDATE()) ");

            return $sql->row();

        }


        public function f_get_latest_transDtId($maxTransDt, $emp_cd)
        {

            $sql = $this->db->query(" SELECT MAX(trans_cd) AS trans_cd FROM td_leave_dtls WHERE trans_dt = '$maxTransDt' AND emp_no = $emp_cd ");

            return $sql->row();

        }


        public function f_get_report_closingBalance($emp_cd, $maxTransDt, $maxTransId)
        {

            $sql = $this->db->query(" SELECT trans_dt, cl_bal, el_bal, ml_bal, od_bal FROM td_leave_dtls WHERE 
                                    emp_no = $emp_cd AND trans_dt = '$maxTransDt' AND trans_cd = '$maxTransId' ");

            return $sql->result();

        }

        public function f_get_leavenotesheet($emp_cd)
        {

            $sql = $this->db->query("SELECT a.*,b.emp_name FROM td_leave_dtls a,md_employee b WHERE a.emp_no = b.emp_code and YEAR(a.trans_dt) = YEAR(CURDATE()) AND a.trans_type = 'T' AND a.approval_status = 'U' ");
            return $sql->result();


        }












    }

?>
