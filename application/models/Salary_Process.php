<?php
	defined('BASEPATH') OR exit('No direct script access allowed');

	class Salary_Process extends CI_Model{

		public function f_get_particulars($table_name, $select=NULL, $where=NULL, $flag=NULL) {

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

		//For inserting row
		public function f_insert($table_name, $data_array) {

			$this->db->insert($table_name, $data_array);

			return;

		}

		//For Editing row
		public function f_edit($table_name, $data_array, $where) {

			$this->db->where($where);
			$this->db->update($table_name, $data_array);

			return;

		}

		//For Deliting row

		public function f_delete($table_name, $where) {

			$this->db->delete($table_name, $where);

			return;

		}

		public function f_sal_dtls($emp_code) 										//Calculate Earnings
        {

            $sql = $this->db->query("SELECT a.basic_pay,
										    basic_pay * (select param_value from md_parameters where sl_no=1)/100 as da,
									        basic_pay * (select param_value from md_parameters where sl_no=2)/100 as hra,
											(select param_value from md_parameters where sl_no=4)epf, 
										    (select param_value from md_parameters where sl_no=3) ma
									FROM md_employee a 
								    WHERE a.emp_code ='$emp_code'");
            return $sql->row();

		}
		public function f_sal_ded_dtls($emp_code) 										//Calculate Earnings
        {

            $sql = $this->db->query("SELECT basic_pay,ifnull(grade_pay,0) grade_pay,
										    ifnull(da_amt,0) as da,
									        ifnull(hra_amt,0) as hra,
											(select param_value from md_parameters where sl_no=4)epf, 
										    (select param_value from md_parameters where sl_no=3) ma
									FROM td_income
								    WHERE emp_code ='$emp_code'");
            return $sql->row();

		}

		public function f_get_earning() {											//Retrieve Earnings for Dashboard
			$data = $this->db->query( "SELECT a.emp_code as emp_code, 
											  b.emp_name as emp_name,
											  b.emp_dist as emp_dist,
											  c.district_name as district_name,
											  MAX(a.effective_date) as effective_date
									    FROM td_income a ,md_employee b,md_district c
										WHERE a.emp_code = b.emp_code
										AND   b.emp_dist = c.district_code
										AND   (b.emp_status = 'A' OR b.emp_status = 'S')
									    GROUP BY a.emp_code, b.emp_name,c.district_name");
												
			return $data->result();
		}


		//Retive Deduction List
		/*public function f_get_deduction() {

			$sql = "SELECT emp_cd, MAX(cast(created_dt As DATE)) sal_date FROM td_deductions
														  GROUP BY emp_cd";
												  
			$result		=	$this->db->query($sql);	
			
			if($result->num_rows() > 0){

				foreach($result->result() as $row) {

					$where = array(
	
						"emp_cd"			=>	$row->emp_cd,
	
						"created_dt"		=>	$row->sal_date
	
					);
	
					$data[] = $this->f_get_particulars("td_deductions", NULL, $where, 1);

				}

				return $data;

			}
			
			else{

				return false;
				
			}

		}*/


		//Retive Attendance List
		/*public function f_get_attendance() {

			$sql = "SELECT emp_cd, MAX(trans_dt) trans_dt FROM td_attendance
				GROUP BY emp_cd";
												  
			$result		=	$this->db->query($sql);	
			
			if($result->num_rows() > 0){

				foreach($result->result() as $row) {

					$where = array(
	
						"emp_cd"	=>	$row->emp_cd,
	
						"trans_dt"	=>	$row->trans_dt
	
					);
	
					$data[] = $this->f_get_particulars("td_attendance", NULL, $where, 1);

				}

				return $data;

			}
			
			else{
				return false;
			}

		}*/


		//Retive Bonus List
		/*public function f_get_bonus() {

			$sql = "SELECT emp_no, MAX(trans_dt) trans_dt FROM td_bonus
														  GROUP BY emp_no";
												  
			$result		=	$this->db->query($sql);	
			
			if($result->num_rows() > 0){

				foreach($result->result() as $row) {

					$where = array(
	
						"emp_no"	=>	$row->emp_no,
	
						"trans_dt"	=>	$row->trans_dt
	
					);
	
					$data[] = $this->f_get_particulars("td_bonus", NULL, $where, 1);

				}

				return $data;

			}
			
			else{

				return false;

			}

		}*/


		//Retive Incentive List
		/*public function f_get_incentive() {

			$sql = "SELECT emp_no, MAX(trans_dt) trans_dt FROM td_incentive
														  GROUP BY emp_no";
												  
			$result		=	$this->db->query($sql);	
			
			if($result->num_rows() > 0){

				foreach($result->result() as $row) {

					$where = array(
	
						"emp_no"	=>	$row->emp_no,
	
						"trans_dt"	=>	$row->trans_dt
	
					);
	
					$data[] = $this->f_get_particulars("td_incentive", NULL, $where, 1);

				}

				return $data;

			}
			
			else{

				return false;
				
			}

		}*/

		//For Periodic Increment
		/*public function f_get_increment() {

			$sql = "SELECT emp_cd, MAX(effective_dt) trans_dt FROM md_basic_pay
														      GROUP BY emp_cd";
												  
			$result		=	$this->db->query($sql);	
			
			if($result->num_rows() > 0){

				foreach($result->result() as $row) {

					$where = array(
	
						"emp_cd"	    =>	$row->emp_cd,
	
						"effective_dt"	=>	$row->trans_dt
	
					);
	
					$data[] = $this->f_get_particulars("md_basic_pay", NULL, $where, 1);

				}

				return $data;

			}
			
			else{

				return false;
				
			}

		}*/

		//For Salary slip generation
		public function f_get_generation() {

			// $sql = "SELECT sal_month, sal_year, 
			// 			   MAX(trans_date) trans_date
			// 		FROM   td_salary 
			// 		GROUP BY sal_month, 
			// 				 sal_year LIMIT 1";
				$sql = " SELECT max(sal_month) sal_month,max(`sal_year`) sal_year FROM `td_salary`
				where sal_year=(select max(sal_year) from  td_salary) AND approval_status ='A'";
			$result	=	$this->db->query($sql);

			return $result->row();
			
		}

		//For Where in Clause for employees
		public function f_get_particulars_in($table_name, $where_in=NULL, $where=NULL) {

			if(isset($where)){

				$this->db->where($where);

			}

			if(isset($where_in)){

				$this->db->where_in('emp_no', $where_in);

			}
			
			$result	=	$this->db->get($table_name);

			return $result->result();

		}


		//For Total Deduction
		public function f_get_totaldeduction($from_date, $to_date) {

			$sql	=	"SELECT emp_no,
								emp_name,
								SUM(gen_adv) gen_adv,
								SUM(gen_intt) gen_intt,
								SUM(festival_adv) festival_adv,
								SUM(lic) lic,
								SUM(pf) pf,
								SUM(ptax) ptax,
								SUM(itax) itax FROM td_pay_slip 
											   WHERE trans_date BETWEEN '$from_date' AND '$to_date'
											   GROUP BY emp_no, emp_name
						";
			
			$result = $this->db->query($sql);

			return $result->result();

		}


		//For last Arear(Stopped) Salary for employee(s)
		public function f_get_stopsalary() {

			$sql = "SELECT emp_no, MAX(trans_dt) trans_dt FROM td_stop_salary
														  GROUP BY emp_no";
												  
			$result		=	$this->db->query($sql);	
			
			if($result->num_rows() > 0){

				foreach($result->result() as $row) {

					$where = array(
	
						"emp_no"	    =>	$row->emp_no,
	
						"trans_dt"   	=>	$row->trans_dt
	
					);
	
					$data[] = $this->f_get_particulars("td_stop_salary", NULL, $where, 1);

				}

				return $data;

			}
			
			else{

				return false;
				
			}

		}
		public function get_emp_for_salary($category){

              $sql = "SELECT  emp.emp_code,emp.emp_catg,IFNULL(er.basic_pay,0)er_basic_pay,IFNULL(er.grade_pay,0)er_grade_pay,IFNULL(da_amt,0)er_da,IFNULL(hra_amt,0)er_hra,
			  IFNULL(othr_allow,0)er_othr_allow,IFNULL(med_allow,0)er_med_allow,
			  IFNULL(insuarance,0)ded_insuarance,
				  IFNULL(ccs,0)ded_ccs,IFNULL(hbl,0)ded_hbl,
				  IFNULL(telephone,0)ded_telephone,
				  IFNULL(med_adv,0)ded_med_adv,
				  IFNULL(festival_adv,0)ded_festival_adv,
				  IFNULL(tf,0)ded_tf,
				  IFNULL(med_ins,0)ded_med_ins,
				  IFNULL(comp_loan,0)ded_comp_loan,
				  IFNULL(itax,0)ded_itax,
				  IFNULL(gpf,0)ded_gpf,
				  IFNULL(epf,0)ded_epf,
				  IFNULL(ptax,0)ded_ptax,
				  IFNULL(other_deduction,0)ded_other_deduction
				  FROM   td_income er ,td_deductions ded,md_employee emp
				  where  emp.emp_code=er.emp_code
				  and emp.emp_status in('A','S')
				  and  er.emp_code=ded.emp_cd
				  and emp.emp_catg  =  $category"  ;

            $result = $this->db->query($sql);

			return $result->result();
		}

		public function f_get_tot_deduction($trans_no,$month,$year)
		{
			$sql = "SELECT  IFNULL(sum(insuarance),0) ded_insuarance,
					IFNULL(sum(ccs),0)ded_ccs, IFNULL(sum(hbl),0)ded_hbl,
				    IFNULL( sum(telephone),0)ded_telephone,
				    IFNULL( sum(med_adv),0)ded_med_adv,
					IFNULL(sum(festival_adv),0)ded_festival_adv,
				    IFNULL( sum(tf),0)ded_tf,
					IFNULL(sum(med_ins),0)ded_med_ins,
					IFNULL(sum(comp_loan),0)ded_comp_loan,
					IFNULL(sum(itax),0)ded_itax,
				    IFNULL( sum(gpf),0)ded_gpf,
					IFNULL(sum(epf),0)ded_epf,
					IFNULL(sum(ptax),0)ded_ptax,
				    IFNULL( sum(other_deduction),0)ded_other_deduction,
					IFNULL(sum(tot_deduction),0) tot_deduction
				    FROM   td_pay_slip
				    where trans_no  =  $trans_no
				   and  sal_month  =  $month
				   and sal_year  =  $year"  ;

			$result = $this->db->query($sql);

			return $result->row();
		}

	}
	

?>
