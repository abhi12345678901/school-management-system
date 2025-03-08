<?php

class Model_Student extends CI_Model
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
			$sql = "SELECT * FROM admission WHERE student_id = ? ORDER BY rollno ASC";
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
			$sql = "SELECT * FROM admission WHERE class_id = ? ORDER BY rollno ASC";
			$query = $this->db->query($sql, array($classId));
			return $query->result_array();
		} // /if
	}

	public function fetachLastStudent()
	{

		$sql = "SELECT * FROM `admission` ORDER By student_id DESC LIMIT 1";
		$query = $this->db->query($sql);
		return $query->row_array();
	}



	/*
	*--------------------------------------------------
	* fetches the student infro via class and section id
	*--------------------------------------------------
	*/
	public function fetchStudentByClassAndSection($classId = null, $sectionId = null)
	{
		if ($classId && $sectionId) {
			$sql = "SELECT * FROM admission WHERE class_id = ? AND section_id = ? ORDER BY rollno ASC";
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
				'rollno' => $this->input->post('rollNo'),
				'student_name' => $this->input->post('editStudentName'),
				'father_name' => $this->input->post('fname'),
				'mother_name' => $this->input->post('mname'),
				'i_disease' => $this->input->post('idesease'),
				'blood_group' => $this->input->post('bloodgroup'),
				'paralysed' => $this->input->post('paralysed'),
				'dcattatch' => $this->input->post('dcattatch'),
				'age_proof' => $this->input->post('ageproof'),
				'idparents' => $this->input->post('idparents'),
				'st_hobby' => $this->input->post('sthobby'),
				'st_interest' => $this->input->post('stinterest'),
				'disease' => $this->input->post('disease'),
				'ex_detail' => $this->input->post('exdetail'),
				'class_id' => $this->input->post('editClassName'),
				'section_id' => $this->input->post('editSectionName'),
				'dob' => $this->input->post('editDob'),
				'sex' => $this->input->post('editSex'),
				'weight' => $this->input->post('weight'),
				'height' => $this->input->post('height'),
				'religion' => $this->input->post('religion'),
				'category' => $this->input->post('category'),
				'p_address' => $this->input->post('paddress'),
				'p_phone' => $this->input->post('pphone'),
				'f_address' => $this->input->post('faddress'),
				'f_phone' => $this->input->post('fphone'),
				'f_occupation' => $this->input->post('foccupation'),
				'm_occupation' => $this->input->post('moccupation'),
				'bpl_no' => $this->input->post('bplno'),
				'st_adhar' => $this->input->post('stadhar'),
				'parents_adhar' => $this->input->post('parentsadhar'),
				'st_bank' => $this->input->post('stbank'),
				'st_ifsc' => $this->input->post('stifsc'),
				'email' => $this->input->post('email'),
				'language' => $this->input->post('language'),
				'pr_school' => $this->input->post('prschool'),
				'gd_name' => $this->input->post('gdname'),
				'admssion_no' => $this->input->post('admssionno'),
				'registerDate' => $this->input->post('admissionDate')
			);

			$this->db->where('student_id', $studentId);
			$query = $this->db->update('admission', $update_data);

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
