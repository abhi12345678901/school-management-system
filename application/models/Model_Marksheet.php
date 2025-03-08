<?php 

class Model_Marksheet extends CI_Model 
{	

	public function __construct()
	{
		parent::__construct();

		// classes 
		$this->load->model('Model_Classes');
		// section
		$this->load->model('Model_Section');
		// student
		$this->load->model('Model_Student');
		// subject
		$this->load->model('Model_Subject');
	}

	/*
	*----------------------------------------------
	* fetches the class's marksheet table 
	*----------------------------------------------
	*/
	public function fetchMarksheetData($classId = null)
	{
		if($classId) {
			$sql = "SELECT * FROM marksheet WHERE class_id = ?";
			$query = $this->db->query($sql, array($classId));
			return $query->result_array();
		} // /if
	}

	/*
	*----------------------------------------------
	* fetches the class's marksheet data by 
	* markshet id 
	*----------------------------------------------
	*/
	public function fetchMarksheetDataByMarksheetId($marksheetId = null)
	{
		if($marksheetId) {
			$sql = "SELECT * FROM marksheet WHERE marksheet_id = ?";
			$query = $this->db->query($sql, array($marksheetId));
			return $query->row_array();
		} // /if
	}

	public function fetchSubjectDataBySubjectId($subjectId = null)
	{
		if($subjectId) {
			$sql = "SELECT * FROM subject WHERE subject_id = ?";
			$query = $this->db->query($sql, array($subjectId));
			return $query->row_array();
		} // /if
	}
	public function fetchAdditionalSubjectDataBySubjectId($subjectId = null)
	{
		if($subjectId) {
			$sql = "SELECT * FROM additional_subject WHERE subject_id = ?";
			$query = $this->db->query($sql, array($subjectId));
			return $query->row_array();
		} // /if
	}

	/*
	*---------------------------------------------------------------------------
	* creates the marksheet function
	* first enters the marksheet name, date and class id in the marksheet table
	* secondly enters the student_id, subject_id into the marksheet_student
	*---------------------------------------------------------------------------
	*/
	public function create($classId = null)
	{
		if($classId) {
			$sectionData = $this->Model_Section->fetchSectionDataByClass($classId);

			$marksheet_data = array(
				'marksheet_name' => $this->input->post('marksheetName'),
				'marksheet_date' => $this->input->post('date'),
				'class_id' 		 => $classId
			);

			$this->db->insert('marksheet', $marksheet_data);

			$marksheet_id = $this->db->insert_id();

			foreach ($sectionData as $key => $value) {

				$studentData = $this->Model_Student->fetchStudentByClassAndSection($classId, $value['section_id']);
				$subjectData = $this->Model_Subject->fetchSubjectDataByClass($classId);
				$additionalSubjectData = $this->Model_Subject->fetchAdditionalSubjectDataByClass($classId);

				foreach ($studentData as $student_key => $student_value) {					
					foreach ($subjectData as $subject_key => $subject_value) {
						$marksheet_student_data = array(
							'student_id' => $student_value['student_id'],
							'subject_id' => $subject_value['subject_id'],							
							'marksheet_id' => $marksheet_id,
							
							'class_id' => $classId,
							'section_id' => $value['section_id']
						);

						$this->db->insert('marksheet_student', $marksheet_student_data);				
					} // /.foreach for subject
					foreach ($additionalSubjectData as $subject_key => $subject_value) {
						$marksheet_student_data = array(
							'student_id' => $student_value['student_id'],
							'subject_id' => $subject_value['subject_id'],							
							'marksheet_id' => $marksheet_id,
							
							'class_id' => $classId,
							'section_id' => $value['section_id']
						);

						$this->db->insert('additional_subject__marksheet_student', $marksheet_student_data);				
					} // /.foreach for subject
				}  // /.foreach for student						

			} // /foreach for student

			return true;
		} // /.class id
		else {
			return false;
		}
	} // /.create marksheet function

	/*
	*-----------------------------------------------------------
	* update marksheet function
	*-----------------------------------------------------------
	*/
	public function update($marksheetId = null, $classId = null)
	{
		if($marksheetId && $classId) {

			$sectionData = $this->Model_Section->fetchSectionDataByClass($classId);

			$update_marksheet_data = array(
				'marksheet_name' => $this->input->post('editMarksheetName'),
				'marksheet_date' => $this->input->post('editDate'),
				'class_id' 		 => $classId
			);

			$this->db->where('marksheet_id', $marksheetId);
			$this->db->where('class_id', $classId);
			$this->db->update('marksheet', $update_marksheet_data);
			
			// remove the student data from the marksheet student table
			$this->db->where('marksheet_id', $marksheetId);
			$this->db->where('class_id', $classId);
			$this->db->delete('marksheet_student');
		
			foreach ($sectionData as $key => $value) {

				$studentData = $this->Model_Student->fetchStudentByClassAndSection($classId, $value['section_id']);
				$subjectData = $this->Model_Subject->fetchSubjectDataByClass($classId);

				foreach ($studentData as $student_key => $student_value) {					
					foreach ($subjectData as $subject_key => $subject_value) {
						$marksheet_student_data = array(
							'student_id' => $student_value['student_id'],
							'subject_id' => $subject_value['subject_id'],							
							'marksheet_id' => $marksheetId,
							'class_id' => $classId,
							'section_id' => $value['section_id']
						);

						$this->db->insert('marksheet_student', $marksheet_student_data);				
					} // /.foreach for subject
				}  // /.foreach for student						

			} // /foreach for student

			return true;
		} // /.class id
		else {
			return false;
		}
	}

	/*
	*-----------------------------------------------------------
	* remove marksheet function
	*-----------------------------------------------------------
	*/
	public function remove($marksheetId = null) 
	{
		if($marksheetId) {
			$this->db->where('marksheet_id', $marksheetId);
			$result = $this->db->delete('marksheet');

			$this->db->where('marksheet_id', $marksheetId);
			$marksheet_student_result = $this->db->delete('marksheet_student');

			return ($result === true && $marksheet_student_result === true ? true: false);
		}
	}
	public function fetchClassNumericName($classId = null)
	{
		if($classId) {
			$sql = "SELECT * FROM class WHERE class_id = ?";
			$query = $this->db->query($sql, array($classId));
			return $query->result_array();
		} // /.if
	}

	/*
	*----------------------------------------------------------
	* fetch the marksheet data via class id
	*----------------------------------------------------------
	*/
	public function fetchMarksheetDataByClass($classId = null)
	{
		if($classId) {
			$sql = "SELECT * FROM marksheet WHERE class_id = ?";
			$query = $this->db->query($sql, array($classId));
			return $query->result_array();
		} // /.if
	} // /.fetch marksheet data by class id function

	public function fetchSubjectDataByClass($classId = null)
	{
		if($classId) {
			$sql = "SELECT * FROM subject WHERE class_id = ?";
			$query = $this->db->query($sql, array($classId));
			return $query->result_array();
		} // /.if
	}
	public function fetchAdditionalSubjectDataByClass($classId = null)
	{
		if($classId) {
			$sql = "SELECT * FROM additional_subject WHERE class_id = ?";
			$query = $this->db->query($sql, array($classId));
			return $query->result_array();
		} // /.if
	}

	/*
	*----------------------------------------------------------
	* fetch the student marksheet data of the marksheet student
	*----------------------------------------------------------
	*/
	public function fetchStudentMarksheetData($studentId = null, $classId = null, $marksheetId = null)
	{
		if($studentId && $classId && $marksheetId) {
 			$sql = "SELECT * FROM marksheet_student WHERE student_id = ? AND class_id = ? AND marksheet_id = ?";
			$query = $this->db->query($sql, array($studentId, $classId, $marksheetId));
			return $query->result_array();
		}			
	}

	public function fetchStudentAdditionalMarksheetData($studentId = null, $classId = null, $marksheetId = null)
	{
		if($studentId && $classId && $marksheetId) {
 			$sql = "SELECT * FROM additional_subject__marksheet_student WHERE student_id = ? AND class_id = ? AND marksheet_id = ?";
			$query = $this->db->query($sql, array($studentId, $classId, $marksheetId));
			return $query->result_array();
		}			
	}

	/*
	*-----------------------------------
	* insert student's subjcet marks
	*-----------------------------------
	*/
	public function createStudentMarks()
	{				
		for($x = 1; $x <= count($this->input->post('studentMarks')); $x++) {			
			$update_data = array(				
				'obtain_mark' 		=> $this->input->post('studentMarks')[$x],
				'obtain_mark_sa' 		=> $this->input->post('studentMarksSA')[$x],
				'obtain_mark_pt_2' 		=> $this->input->post('studentMarksPT2')[$x],
				'obtain_mark_sa_2' 		=> $this->input->post('studentMarksSA2')[$x],				
			);
			
			$this->db->where('marksheet_student_id', $this->input->post('marksheetStudentId')[$x]);
			$this->db->update('marksheet_student', $update_data);						
		} // /for

		// return ($status == true ? true : false);			
	}

	public function createStudentMarksHigher()
	{				
		for($x = 1; $x <= count($this->input->post('studentMarks')); $x++) {			
			$update_data = array(				
				'obtain_mark' 		=> $this->input->post('studentMarks')[$x],
				'obtain_mark_sa' 		=> $this->input->post('studentMarksNBHY')[$x],
				'subject_enrichmenth' 		=> $this->input->post('studentMarksSEHY')[$x],
				'h_yrly' 		=> $this->input->post('studentMarksHY')[$x],
				'obtain_mark_pt_2' 		=> $this->input->post('studentMarksPT2')[$x],
				'obtain_mark_sa_2' 		=> $this->input->post('studentMarksNBY')[$x],	
				'subject_enrichmentf' 		=> $this->input->post('studentMarksSEY')[$x],
				'yrly' 		=> $this->input->post('studentMarksY')[$x],				
			);
			
			$this->db->where('marksheet_student_id', $this->input->post('marksheetStudentId')[$x]);
			$this->db->update('marksheet_student', $update_data);						
		}
		for($y = 1; $y <= count($this->input->post('studentMarksAD')); $y++) {			
			$update_ad_subject_data = array(				
				'obtain_mark' 		=> $this->input->post('studentMarksAD')[$y],
				'obtain_mark_sa' 		=> $this->input->post('studentMarksADNBHY')[$y],
				'subject_enrichmenth' 		=> $this->input->post('studentMarksADSEHY')[$y],
				'h_yrly' 		=> $this->input->post('studentMarksADHY')[$y],
				'obtain_mark_pt_2' 		=> $this->input->post('studentMarksADPT2')[$y],
				'obtain_mark_sa_2' 		=> $this->input->post('studentMarksADNBY')[$y],	
				'subject_enrichmentf' 		=> $this->input->post('studentMarksADSEY')[$y],
				'yrly' 		=> $this->input->post('studentMarksADY')[$y],				
			);
			
			$this->db->where('marksheet_student_id', $this->input->post('marksheetStudentId')[$y]);
			$this->db->update('additional_subject__marksheet_student', $update_ad_subject_data);							
		} // /for

		// return ($status == true ? true : false);			
	}

	/*
	*-----------------------------------
	* view student's subjcet marks
	*-----------------------------------
	*/
	public function viewStudentMarksheet($studentId = null, $classId = null, $marksheetId = null)
	{		
		if($studentId && $classId && $marksheetId) {			
			$sql = "SELECT * FROM marksheet_student WHERE student_id = ? AND class_id = ? AND marksheet_id = ?";
			$query = $this->db->query($sql, array($studentId, $classId, $marksheetId));			
			return $query->result_array();
		}
	}

	public function viewStudentAdditionalMarksheet($studentId = null, $classId = null, $marksheetId = null)
	{		
		if($studentId && $classId && $marksheetId) {			
			$sql = "SELECT * FROM additional_subject__marksheet_student WHERE student_id = ? AND class_id = ? AND marksheet_id = ?";
			$query = $this->db->query($sql, array($studentId, $classId, $marksheetId));			
			return $query->result_array();
		}
	}

	public function fetchStudentMarksByClassSectionStudent($classId = null, $sectionId = null, $studentId = null)
	{
		if($classId && $sectionId && $studentId) {			
			$sql = "SELECT * FROM marksheet_student WHERE class_id = ? AND section_id = ? AND student_id = ?";
			$query = $this->db->query($sql, array($classId, $sectionId, $studentId));		
			return $query->row_array();
		}
	}

	public function fetchStudentMarksByClassSectionStudentSubject($classId = null, $sectionId = null, $studentId = null, $marksheetsubjectId = null, $marksheetId = null)
	{
		if($classId && $sectionId && $studentId && $marksheetsubjectId && $marksheetId) {			
			$sql = "SELECT * FROM marksheet_student WHERE class_id = ? AND section_id = ? AND student_id = ? AND subject_id = ? AND marksheet_id = ?";
			$query = $this->db->query($sql, array($classId, $sectionId, $studentId, $marksheetsubjectId, $marksheetId));		
			return $query->row_array();
		}
	}

	public function fetchStudentAdditionalSubMarksByClassSectionStudentSubject($classId = null, $sectionId = null, $studentId = null, $marksheetsubjectId = null, $marksheetId = null)
	{
		if($classId && $sectionId && $studentId && $marksheetsubjectId && $marksheetId) {			
			$sql = "SELECT * FROM additional_subject__marksheet_student WHERE class_id = ? AND section_id = ? AND student_id = ? AND subject_id = ? AND marksheet_id = ?";
			$query = $this->db->query($sql, array($classId, $sectionId, $studentId, $marksheetsubjectId, $marksheetId));		
			return $query->row_array();
		}
	}


	/*
	*------------------------------------
	* count total marksheet information 
	*------------------------------------
	*/	
	public function countTotalMarksheet() 
	{
		$sql = "SELECT * FROM marksheet";
		$query = $this->db->query($sql);
		return $query->num_rows();
	}

}