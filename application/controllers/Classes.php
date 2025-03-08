<?php

class Classes extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();

		$this->isNotLoggedIn();

		// loading the classes model
		$this->load->model('Model_Classes');

		// loading the form validation library
		$this->load->library('form_validation');
	}

	/*
	*-----------------------------------------
	* validates the class name field and 
	* insert the class info into the database
	* by calling the create function of the  
	* the model_users class
	*-----------------------------------------
	*/
	public function create()
	{
		$validator = array('success' => false, 'messages' => array());

		$validate_data = array(
			array(
				'field' => 'className',
				'label' => 'Class Name',
				'rules' => 'required|callback_validate_classname'
			),
			array(
				'field' => 'numericName',
				'label' => 'Numeric Name',
				'rules' => 'required|numeric|callback_validate_numericname'
			),
			array(
				'field' => 'monthlyFee',
				'label' => 'Monthly Fee',
				'rules' => 'required|numeric'
			),
			array(
				'field' => 'developmentFee',
				'label' => 'Development Fee',
				'rules' => 'required|numeric'
			),
			array(
				'field' => 'examFee',
				'label' => 'Exam Fee',
				'rules' => 'required|numeric'
			),
			array(
				'field' => 'extraActivities',
				'label' => 'Extra Activities',
				'rules' => 'required|numeric'
			),
		);

		$this->form_validation->set_rules($validate_data);
		$this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>');

		if ($this->form_validation->run() === true) {
			$create = $this->Model_Classes->create();
			if ($create === true) {
				$validator['success'] = true;
				$validator['messages'] = "Successfully added";
			} else {
				$validator['success'] = false;
				$validator['messages'] = "Error while inserting the information into the database";
			}
		} else {
			$validator['success'] = false;
			foreach ($_POST as $key => $value) {
				$validator['messages'][$key] = form_error($key);
			}
		} // /else

		echo json_encode($validator);
	}

	/*
	*-----------------------------------------
	* validates the class name 
	* checks the class name value 
	* from the validate_classname function in 
	* the model_users class
	*-----------------------------------------
	*/
	public function validate_classname()
	{
		$validate = $this->Model_Classes->validate_classname();

		if ($validate === true) {
			$this->form_validation->set_message('validate_classname', 'The {field} already exists');
			return false;
		} else {
			return true;
		}
	}

	/*
	*-----------------------------------------
	* validates the class numeric  
	* checks the class numeric value 
	* from the validate_numericname function in 
	* the model_users class
	*----------------------------------------
	*/
	public function validate_numericname()
	{
		$validate = $this->Model_Classes->validate_numericname();

		if ($validate === true) {
			$this->form_validation->set_message('validate_numericname', 'The {field} already exists');
			return false;
		} else {
			return true;
		}
	}


	/*
	*------------------------------------
	* retrieve class name 
	*------------------------------------
	*/
	public function fetchClassData($classId = null)
	{
		if ($classId) {
			$classData = $this->Model_Classes->fetchClassData($classId);
			echo json_encode($classData);
		} else {
			$classData = $this->Model_Classes->fetchClassData();
			$result = array('data' => array());

			$x = 1;
			foreach ($classData as $key => $value) {

				$button = '<!-- Single button -->
				<div class="btn-group">
				  <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
				    Action <span class="caret"></span>
				  </button>
				  <ul class="dropdown-menu">
				    <li><a type="button" data-toggle="modal" data-target="#editClassModal" onclick="editClass(' . $value['class_id'] . ')"> <i class="glyphicon glyphicon-edit"></i> Edit</a></li>
				    <li><a type="button" data-toggle="modal" data-target="#removeClassModal" onclick="removeClass(' . $value['class_id'] . ')"> <i class="glyphicon glyphicon-trash"></i> Remove</a></li>		    
				  </ul>
				</div>';

				$result['data'][$key] = array(
					$x,
					$value['class_name'],
					$value['numeric_name'],
					$value['class_monthly_fee'],
					$value['development_fee'],
					$value['exam_fee'],
					$value['extra_activities'],
					$button
				);
				$x++;
			} // /froeach

			echo json_encode($result);
		} // /else		
	}

	/*
	*------------------------------------
	* edit class information 
	*------------------------------------
	*/
	public function update($classId = null)
	{
		if ($classId) {
			$validator = array('success' => false, 'messages' => array());

			$validate_data = array(
				array(
					'field' => 'editClassName',
					'label' => 'Class Name',
					'rules' => 'required|callback_validate_editclassname'
				),
				array(
					'field' => 'editNumericName',
					'label' => 'Numeric Name',
					'rules' => 'required|numeric|callback_validate_editnumericname'
				),
				array(
					'field' => 'editMonthlyFee',
					'label' => 'Monthly Fee',
					'rules' => 'required|numeric'
				),
				array(
					'field' => 'editDevelopmentFee',
					'label' => 'Development Fee',
					'rules' => 'required|numeric'
				),
				array(
					'field' => 'editExamFee',
					'label' => 'Exam Fee',
					'rules' => 'required|numeric'
				),
				array(
					'field' => 'editExtraActivities',
					'label' => 'Extra Activities',
					'rules' => 'required|numeric'
				),
			);

			$this->form_validation->set_rules($validate_data);
			$this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>');

			if ($this->form_validation->run() === true) {
				$update = $this->Model_Classes->update();
				if ($update == true) {
					$validator['success'] = true;
					$validator['messages'] = "Successfully added";
				} else {
					$validator['success'] = false;
					$validator['messages'] = "Error while inserting the information into the database";
				}
			} else {
				$validator['success'] = false;
				foreach ($_POST as $key => $value) {
					$validator['messages'][$key] = form_error($key);
				}
			} // /else

			echo json_encode($validator);
		}
	}

	/*
	*-----------------------------------------
	* validates the class name 
	* checks the class name which is not 
	* equal to class_id
	*-----------------------------------------
	*/
	public function validate_editclassname()
	{
		$validate = $this->Model_Classes->validate_editclassname();

		if ($validate === true) {
			$this->form_validation->set_message('validate_editclassname', 'The {field} already exists');
			return false;
		} else {
			return true;
		}
	}

	/*
	*-----------------------------------------
	* validates the class numeric  
	* checks the class numeric value
	* which is not equal to class_id
	*----------------------------------------
	*/
	public function validate_editnumericname()
	{
		$validate = $this->Model_Classes->validate_editnumericname();

		if ($validate === true) {
			$this->form_validation->set_message('validate_editnumericname', 'The {field} already exists');
			return false;
		} else {
			return true;
		}
	}

	/*
	*----------------------------------------
	* remove the class information from 
	* the database
	*----------------------------------------
	*/
	public function remove($classId = null)
	{
		if ($classId) {
			$remove = $this->Model_Classes->remove($classId);
			if ($remove === true) {
				$validator['success'] = true;
				$validator['messages'] = "Successfully Removed";
			} else {
				$validator['success'] = false;
				$validator['messages'] = "Error while removing the information";
			}
			echo json_encode($validator);
		}
	}
}
