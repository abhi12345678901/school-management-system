<?php 	

class Model_Subject extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}

		/*
	*----------------------------------------------
	* fetches the subject data by Subject Id 
	*----------------------------------------------
	*/
	public function fetchSubjectDataBySubjectId($subjectId = null)
	{
		if($subjectId) {
			$sql = "SELECT * FROM subject WHERE subject_id = ?";
			$query = $this->db->query($sql, array($subjectId));
			return $query->result_array();
		}
	}

	/*
	*----------------------------------------------
	* fetches the class's subject data 
	*----------------------------------------------
	*/
	public function fetchSubjectDataByClass($classId = null)
	{
		if($classId) {
			$sql = "SELECT * FROM subject WHERE class_id = ?";
			$query = $this->db->query($sql, array($classId));
			return $query->result_array();
		}
	}

		/*
	*----------------------------------------------
	* fetches the class's additional subject data 
	*----------------------------------------------
	*/
	public function fetchAdditionalSubjectDataByClass($classId = null)
	{
		if($classId) {
			$sql = "SELECT * FROM additional_subject WHERE class_id = ?";
			$query = $this->db->query($sql, array($classId));
			return $query->result_array();
		}
	}

	/*
	*----------------------------------------------
	* fetches the class's subject information
	* through class_id and section_id 
	*----------------------------------------------
	*/
	public function fetchSubjectByClassSection($classId = null, $subjectId = null)
	{
		if($classId && $subjectId) {
			$sql = "SELECT * FROM subject WHERE class_id = ? AND subject_id = ?";
			$query = $this->db->query($sql, array($classId, $subjectId));
			$result = $query->row_array();
			return $result;
		}		
	}

		/*
	*----------------------------------------------
	* fetches the class's additional subject information
	* through class_id and section_id 
	*----------------------------------------------
	*/
	public function fetchAdditionalSubjectByClassSection($classId = null, $subjectId = null)
	{
		if($classId && $subjectId) {
			$sql = "SELECT * FROM additional_subject WHERE class_id = ? AND subject_id = ?";
			$query = $this->db->query($sql, array($classId, $subjectId));
			$result = $query->row_array();
			return $result;
		}		
	}


	/*
	*----------------------------------------------
	* insert the subject info function
	*----------------------------------------------
	*/
	public function create($classId = null)
	{
		if($classId) {
			$insert_data = array(
				'name' => $this->input->post('subjectName'),
				'total_mark' => $this->input->post('totalMark'),
				'class_id' 	   => $classId,
				'teacher_id'   => $this->input->post('teacherName')
			);

			$query = $this->db->insert('subject', $insert_data);
			return ($query == true ? true : false);
		}
	}

		/*
	*----------------------------------------------
	* insert the additional subject info function
	*----------------------------------------------
	*/
	public function createAdditionalSubject($classId = null)
	{
		if($classId) {
			$insert_additional_data = array(
				'name' => $this->input->post('aditionalSubjectName'),
				'total_mark' => $this->input->post('aditionalSubjectTotalMark'),
				'class_id' 	   => $classId,
				'teacher_id'   => $this->input->post('aditionalSubjectTeacherName')
			);

			$query = $this->db->insert('additional_subject', $insert_additional_data);
			return ($query == true ? true : false);
		}
	}
	/*
	*----------------------------------------------
	* update the subject info function
	*----------------------------------------------
	*/
	public function update($classId = null, $subjectId = null)
	{
		if($classId && $subjectId) {
			$update_data = array(
				'name' => $this->input->post('editSubjectName'),
				'total_mark' => $this->input->post('editTotalMark'),
				'class_id' 	   => $classId,
				'teacher_id'   => $this->input->post('editTeacherName')
			);

			$this->db->where('class_id', $classId);
			$this->db->where('subject_id', $subjectId);
			$query = $this->db->update('subject', $update_data);
			return ($query == true ? true : false);
		}
	}

	/*
	*----------------------------------------------
	* update the additional subject info function
	*----------------------------------------------
	*/
	public function updateAdditionalSubject($classId = null, $subjectId = null)
	{
		if($classId && $subjectId) {
			$update_data = array(
				'name' => $this->input->post('editAdditionalSubjectName'),
				'total_mark' => $this->input->post('editAdditionalTotalMark'),
				'class_id' 	   => $classId,
				'teacher_id'   => $this->input->post('editAdditionalTeacherName')
			);

			$this->db->where('class_id', $classId);
			$this->db->where('subject_id', $subjectId);
			$query = $this->db->update('additional_subject', $update_data);
			return ($query == true ? true : false);
		}
	}

	/*
	*----------------------------------------
	* remove the class's subject information
	*----------------------------------------
	*/
	public function remove($subjectId = null)
	{
		if($subjectId) {
			$this->db->where('subject_id', $subjectId);
			$result = $this->db->delete('subject');
			return ($result === true ? true: false); 
		}
	}

	/*
	*----------------------------------------
	* remove the class's additional subject information
	*----------------------------------------
	*/
	public function removeAdditionalSubject($subjectId = null)
	{
		if($subjectId) {
			$this->db->where('subject_id', $subjectId);
			$result = $this->db->delete('additional_subject');
			return ($result === true ? true: false); 
		}
	}

}