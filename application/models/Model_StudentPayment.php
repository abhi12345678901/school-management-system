<?php

class Model_StudentPayment extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	/*
	*------------------------------------
	* inserts the student's information
	* into the database 
	*------------------------------------
	*/
	public function create($img_url)
	{
		if ($img_url == '') {
			$img_url = 'assets/images/default/default_avatar.png';
		}

		$insert_data = array(
			'register_date' => $this->input->post('registerDate'),
			'class_id' 		=> $this->input->post('className'),
			'section_id'	=> $this->input->post('sectionName'),
			'fname'			=> $this->input->post('fname'),
			'lname' 		=> $this->input->post('lname'),
			'image'			=> $img_url,
			'age'			=> $this->input->post('age'),
			'dob'			=> $this->input->post('dob'),
			'contact'		=> $this->input->post('contact'),
			'email'			=> $this->input->post('email'),
			'address'		=> $this->input->post('address'),
			'city'			=> $this->input->post('city'),
			'country'   	=> $this->input->post('country')
		);

		$status = $this->db->insert('admission', $insert_data);
		return ($status == true ? true : false);
	}

	/*
	*-----------------------------------
	* fetches the student inform
	*-----------------------------------
	*/
	public function fetchStudentData($studentId = null)
	{
		if ($studentId) {
			$sql = "select * from admission a inner join payment p on
            a.student_id = p.student_id inner join payment_name m on 
            p.payment_name_id = m.id inner join class c on  a.class_id = c.class_id inner join section s on  a.section_id = s.section_id WHERE p.payment_name_id = '$studentId';";
			$query = $this->db->query($sql, array($studentId));
			return $query->row_array();
		}
	}

	/*
	*--------------------------------------------------
	*fetches the student information via class id 
	*--------------------------------------------------
	*/
	public function fetchStudentDataByClass($classId = null)
	{
		if ($classId) {
			$sql = "select * from admission a inner join payment p on
            a.student_id = p.student_id inner join payment_name m on 
            p.payment_name_id = m.id WHERE a.class_id = '$classId'";
			$query = $this->db->query($sql, array($classId));
			return $query->result_array();
		} // /if
	}

	public function fetchStudentDataByClassforTC($classId = null)
	{
		if ($classId) {
			$sql = "select * from admission a inner join payment p on
            a.student_id = p.student_id inner join payment_name m on 
            p.payment_name_id = m.id WHERE a.class_id = '$classId' AND p.name = 'Admission Fee';";
			$query = $this->db->query($sql, array($classId));
			return $query->result_array();
		} // /if
	}



	/*
	*--------------------------------------------------
	* fetches the student infro via class and section id
	*--------------------------------------------------
	*/
	public function fetchStudentByClassAndSection($classId = null, $sectionId = null)
	{
		if ($classId && $sectionId) {
			$sql = "select * from admission a inner join payment p on
            a.student_id = p.student_id inner join payment_name m on 
            p.payment_name_id = m.id WHERE a.class_id = '$classId' AND a.section_id ='$sectionId';";
			$query = $this->db->query($sql, array($classId, $sectionId));
			return $query->result_array();
		} // /if
	}

	public function fetchStudentByClassAndSectionforTC($classId = null, $sectionId = null)
	{
		if ($classId && $sectionId) {
			$sql = "select * from admission a inner join payment p on
            a.student_id = p.student_id inner join payment_name m on 
            p.payment_name_id = m.id WHERE a.class_id = '$classId' AND a.section_id ='$sectionId' AND p.name = 'Admission Fee';";
			$query = $this->db->query($sql, array($classId, $sectionId));
			return $query->result_array();
		} // /if
	}


	/*
	*--------------------------------------------------
	* fetches the student infro via class and section id and roll no
	*--------------------------------------------------
	*/
	public function fetchStudentByRollNoClassAndSection($rollNo = null, $classId = null, $sectionId = null)
	{
		if ($rollNo && $classId && $sectionId) {
			$sql = "SELECT * FROM admission WHERE class_id = ? AND section_id = ? AND rollno = ?";
			$query = $this->db->query($sql, array($classId, $sectionId, $rollNo));
			return $query->result_array();
		} // /if
	}

	/*
	*--------------------------------------------------
	* fetches the rollno info via class and section id
	*--------------------------------------------------
	*/
	public function fetchRollNoByClassAndSection($classId = null, $sectionId = null)
	{
		if ($classId && $sectionId) {
			$sql = "SELECT * FROM admission WHERE class_id = ? AND section_id = ?";
			$query = $this->db->query($sql, array($classId, $sectionId));
			return $query->result_array();
		} // /if
	}



	/*
	*--------------------------------------------------
	* fetches the father info via class and section id
	*--------------------------------------------------
	*/
	public function fetchFatherByClassAndSection($studentId = null, $classId = null, $sectionId = null)
	{
		if ($studentId && $classId && $sectionId) {
			$sql = "SELECT * FROM admission WHERE 	student_id = ? AND class_id = ? AND section_id = ?";
			$query = $this->db->query($sql, array($studentId, $classId, $sectionId));
			return $query->result_array();
		} // /if
	}

	/*
	*--------------------------------------------------
	* fetches the father info via class and section id
	*--------------------------------------------------
	*/
	public function fetchMonthlyFeeByClassId($classId = null)
	{
		if ($classId) {
			$sql = "SELECT * FROM class WHERE class_id = ?";
			$query = $this->db->query($sql, array($classId));
			return $query->result_array();
		} // /if
	}

	/*
	*-----------------------------------
	* update the student's inform
	*-----------------------------------
	*/
	public function updateInfo($studentId = null)
	{
		if ($studentId) {
			$update_data = array(
				'session' => $this->input->post('session'),
				'payment_date' => $this->input->post('studentPayDate'),
				'paid_amount'  => $this->input->post('totalPaid'),
				'current_paid_amount'  => $this->input->post('paidAmount'),
				'due_amount'  => $this->input->post('dueAmount'),
				'payment_type' => $this->input->post('paymentType'),
				'status'       => $this->input->post('status')
			);

			$this->db->where('payment_name_id', $studentId);
			$query = $this->db->update('payment', $update_data);
			$payment_name_id = $this->input->post('paymentId');
			$updatepayment_data = array(
				'transport_fee' => $this->input->post('basicTransportFee'),
				'payabletransportfee' => $this->input->post('transportFee'),
				'monthly_fee' => $this->input->post('basicMonthlyFee'),
				'payablemonthlyfee' => $this->input->post('monthlyFee'),
				'total_amount' => $this->input->post('totalAmount'),
				'total_payableamount' => $this->input->post('totalPayableAmount'),
				'discount' => $this->input->post('discount'),
				'end_date' => $this->input->post('endDate'),
				'duration' => $this->input->post('durationPayment'),
				'p_examination_fee' => $this->input->post('examinationFee'),
				'p_development_fee' => $this->input->post('developmentFee'),
				'p_tie' => $this->input->post('tie'),
				'p_belt' => $this->input->post('belt'),
				'p_diary' => $this->input->post('diary'),
				'late_fine' => $this->input->post('lateFine'),
			);

			$this->db->where('id', $payment_name_id);
			$query = $this->db->update('payment_name', $updatepayment_data);
			$paymentdate_data = array(
				'paymentID' => $studentId,
				'paymentNameID' => $payment_name_id,
				'currentPaidAmount' => $this->input->post('paidAmount'),
				'currentPaidDate' => $this->input->post('studentPayDate'),
			);
			$query = $this->db->insert('paymentdaterecord', $paymentdate_data);

			return ($query === true ? true : false);
		}
	}

	/*
	*-----------------------------------
	* update the student's photo
	*-----------------------------------
	*/
	public function updatePhoto($studentId = null, $imageUrl = null)
	{
		if ($studentId && $imageUrl) {
			$update_data = array(
				'image' 	=> $imageUrl
			);

			$this->db->where('student_id', $studentId);
			$query = $this->db->update('admission', $update_data);

			return ($query === true ? true : false);
		}
	}

	/*
	*-----------------------------------
	* remove the student's info
	*-----------------------------------
	*/
	public function remove($studentId = null)
	{
		if ($studentId) {
			$this->db->where('student_id', $studentId);
			$result = $this->db->delete('admission');
			return ($result === true ? true : false);
		} // /if
	}

	/*
	*-----------------------------------
	* insert bulk student
	*-----------------------------------
	*/
	public function createBulk()
	{
		for ($x = 1; $x <= count($this->input->post('bulkstfname')); $x++) {
			$insert_data = array(
				'class_id' 		=> $this->input->post('bulkstclassName')[$x],
				'section_id'	=> $this->input->post('bulkstsectionName')[$x],
				'image'			=> 'assets/images/default/default_avatar.png',
				'fname'			=> $this->input->post('bulkstfname')[$x],
				'lname' 		=> $this->input->post('bulkstlname')[$x]
			);

			$status = $this->db->insert('admission', $insert_data);
		} // /for

		return ($status == true ? true : false);
	}

	/*
	*-------------------------------------------
	* count total student
	*-------------------------------------------
	*/
	public function countTotalStudent()
	{
		$sql = "SELECT * FROM admission";
		$query = $this->db->query($sql);
		return $query->num_rows();
	}
}
