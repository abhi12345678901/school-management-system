<?php

class Marksheet extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();

		$this->isNotLoggedIn();

		// loading the section model class
		$this->load->model('Model_Section');
		// loading the classes model class
		$this->load->model('Model_Classes');
		// loading the marksheet model class
		$this->load->model('Model_Marksheet');
		// loading the subject model class
		$this->load->model('Model_Subject');
		// loading the student model class
		$this->load->model('Model_Student');

		// load the form validation library
		$this->load->library('form_validation');
	}

	/*
	*----------------------------------------------
	* fetches the class's marksheet table 
	*----------------------------------------------
	*/
	public function fetchMarksheetTable($classId = null)
	{
		if ($classId) {
			$classData = $this->Model_Classes->fetchClassData($classId);
			$marksheetData = $this->Model_Marksheet->fetchMarksheetData($classId);

			$table = '

			<div class="well">
				Class Name : ' . $classData['class_name'] . '
			</div>

			<div id="messages"></div>

			<div class="pull pull-right">
	  			<button class="btn btn-default" data-toggle="modal" data-target="#addMarksheetModal" onclick="addMarksheet(' . $classId . ')">Add Marksheet</button>	
		  	</div>
		  		
		  	<br /> <br />

		  	<!-- Table -->
		  	<table class="table table-bordered" id="manageMarksheetTable">
			    <thead>	
			    	<tr>			    		
			    		<th> Marksheet Name  </th>
			    		<th> Date </th>
			    		<th> Action </th>
			    	</tr>
			    </thead>
			    <tbody>';
			if ($marksheetData) {
				foreach ($marksheetData as $key => $value) {

					$button = '<div class="btn-group">
							  <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							    Action <span class="caret"></span>
							  </button>
							  <ul class="dropdown-menu">
							    <li><a type="button" data-toggle="modal" data-target="#editMarksheetModal" onclick="editMarksheet(' . $value['marksheet_id'] . ',' . $value['class_id'] . ')"> <i class="glyphicon glyphicon-edit"></i> Edit</a></li>
							    <li><a type="button" data-toggle="modal" data-target="#removeMarksheetModal" onclick="removeMarksheet(' . $value['marksheet_id'] . ',' . $value['class_id'] . ')"> <i class="glyphicon glyphicon-trash"></i> Remove</a></li>		    
							  </ul>
							</div>';

					$table .= '<tr>
				    			<td>' . $value['marksheet_name'] . '</td>
				    			<td>' . $value['marksheet_date'] . '</td>
				    			<td>' . $button . '</td>
				    		</tr>
				    		';
				} // /foreach				    	
			} else {
				$table .= '<tr>
			    			<td colspan="3"><center>No Data Available</center></td>
			    		</tr>';
			} // /else
			$table .= '</tbody>
			</table>
			';
			echo $table;
		} // /check class id
	}

	/*
	*----------------------------------------------
	* fetch the marksheet data
	*----------------------------------------------
	*/
	public function fetchMarksheetDataByMarksheetId($marksheetId = null)
	{
		$data = $this->Model_Marksheet->fetchMarksheetDataByMarksheetId($marksheetId);
		echo json_encode($data);
	}

	/*
	*----------------------------------------------
	* create marksheet funciton
	*----------------------------------------------
	*/
	public function create($classId = null)
	{
		if ($classId) {
			$validator = array('success' => false, 'messages' => array());

			$validate_data = array(
				array(
					'field' => 'marksheetName',
					'label' => 'Marksheet Name',
					'rules' => 'required'
				),
				array(
					'field' => 'date',
					'label' => 'Exam Date',
					'rules' => 'required'
				)
			);

			$this->form_validation->set_rules($validate_data);
			$this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>');

			if ($this->form_validation->run() === true) {
				$create = $this->Model_Marksheet->create($classId);
				if ($create == true) {
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
		}
		echo json_encode($validator);
	}

	/*
	*----------------------------------------------
	* fetches the update marksheet table
	*----------------------------------------------
	*/
	public function fetchUpdateMarksheetTable($classId = null)
	{
		if ($classId) {
			$classData = $this->Model_Classes->fetchClassData($classId);
			$marksheetData = $this->Model_Marksheet->fetchMarksheetData($classId);

			$table = '<thead>	
			    	<tr>			    		
			    		<th> Marksheet Name  </th>
			    		<th> Date </th>
			    		<th> Action </th>
			    	</tr>
			    </thead>

			    <tbody>';
			if ($marksheetData) {
				foreach ($marksheetData as $key => $value) {

					$button = '<div class="btn-group">
					  <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					    Action <span class="caret"></span>
					  </button>
					  <ul class="dropdown-menu">
					    <li><a type="button" data-toggle="modal" data-target="#editMarksheetModal" onclick="editMarksheet(' . $value['marksheet_id'] . ',' . $value['class_id'] . ')"> <i class="glyphicon glyphicon-edit"></i> Edit</a></li>
					    <li><a type="button" data-toggle="modal" data-target="#removeMarksheetModal" onclick="removeMarksheet(' . $value['marksheet_id'] . ',' . $value['class_id'] . ')"> <i class="glyphicon glyphicon-trash"></i> Remove</a></li>		    
					  </ul>
					</div>';

					$table .= '<tr>
		    			<td>' . $value['marksheet_name'] . '</td>
		    			<td>' . $value['marksheet_date'] . '</td>
		    			<td>' . $button . '</td>
		    		</tr>
		    		';
				} // /foreach				    	
			} else {
				$table .= '<tr>
	    			<td colspan="3"><center>No Data Available</center></td>
	    		</tr>';
			} // /else

			$table .= '</tbody>';

			echo $table;
		} // /.classid
	}

	/*
	*----------------------------------------------
	* update marksheet funciton
	*----------------------------------------------
	*/
	public function update($marksheetId = null, $classId = null)
	{
		if ($marksheetId && $classId) {
			$validator = array('success' => false, 'messages' => array());

			$validate_data = array(
				array(
					'field' => 'editMarksheetName',
					'label' => 'Marksheet Name',
					'rules' => 'required'
				),
				array(
					'field' => 'editDate',
					'label' => 'Exam Date',
					'rules' => 'required'
				)
			);

			$this->form_validation->set_rules($validate_data);
			$this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>');

			if ($this->form_validation->run() === true) {
				$update = $this->Model_Marksheet->update($marksheetId, $classId);
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
		}
		echo json_encode($validator);
	}

	/*
	*----------------------------------------------
	* remove marksheet function
	*----------------------------------------------
	*/
	public function remove($marksheetId = null)
	{
		if ($marksheetId) {
			$remove = $this->Model_Marksheet->remove($marksheetId);
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

	/*
	*----------------------------------------------
	* fetch marksheet info by class id function
	*----------------------------------------------
	*/
	public function fetchMarksheetDataByClass($classId = null)
	{
		if ($classId) {
			$marksheetData = $this->Model_Marksheet->fetchMarksheetDataByClass($classId);
			if ($marksheetData) {
				foreach ($marksheetData as $key => $value) {
					$option .= '<option value="' . $value['marksheet_id'] . '">' . $value['marksheet_name'] . '</option>';
				} // /foreach
			} else {
				$option = '<option value="">No Data</option>';
			} // /else empty section
			echo $option;
		}
	}

	public function fetchSubjectDataByClass($classId = null)
	{
		if ($classId) {
			$subjectData = $this->Model_Marksheet->fetchSubjectDataByClass($classId);
			if ($subjectData) {
				foreach ($subjectData as $key => $value) {
					$option .= '<option value="' . $value['subject_id'] . '">' . $value['name'] . '</option>';
				} // /foreach
			} else {
				$option = '<option value="">No Data</option>';
			}

			echo $option;
		}
	}

	/*
	*----------------------------------------------
	* fetch the student info via marksheet
	*----------------------------------------------
	*/
	public function fetchStudentMarksheet()
	{

		$validator = array('success' => false, 'messages' => array(), 'html' => '');

		$validate_data = array(
			array(
				'field' => 'className',
				'label' => 'Class',
				'rules' => 'required'
			),
			array(
				'field' => 'marksheetName',
				'label' => 'Marksheet',
				'rules' => 'required'
			)
		);

		$this->form_validation->set_rules($validate_data);
		$this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>');

		if ($this->form_validation->run() === true) {

			$validator['success'] = true;
			$validator['messages'] = "Successfully added";

			$classData = $this->Model_Classes->fetchClassData($this->input->post('className'));
			$marksheetNameData = $this->Model_Marksheet->fetchMarksheetDataByMarksheetId($this->input->post('marksheetName'));
			$sectionData = $this->Model_Section->fetchSectionDataByClass($this->input->post('className'));
			$validator['sectionData'] = $sectionData;

			$validator['html'] = '<div class="panel panel-default">		  	
				<div class="panel-heading">Student Info</div>
				  
				<div class="panel-body">		  
					<div class="well well-sm">
						Class : ' . $classData['class_name'] . ' <br />
						Marksheet Name : ' . $marksheetNameData['marksheet_name'] . ' <br />
						<input type="hidden" id="marksheet_id" value="' . $this->input->post('marksheetName') . '" />
					</div>		

					<br /> 	
					<div>
						<!-- Nav tabs -->
					  	<ul class="nav nav-tabs" role="tablist">
					    	<li role="presentation" class="active"><a href="#classStudent" aria-controls="classStudent" role="tab" data-toggle="tab">All Student</a></li>';
			$x = 1;
			foreach ($sectionData as $key => $value) {
				$validator['html'] .= '<li role="presentation"><a href="#countSection' . $x . '" aria-controls="countSection" role="tab" data-toggle="tab"> Section (' . $value['section_name'] . ')</a></li>';
				$x++;
			} // /foreach    					    	

			$validator['html'] .= '</ul>

					  	<!-- Tab panes -->
					  	<div class="tab-content">
					    	<div role="tabpanel" class="tab-pane active" id="classStudent">
              	
				              	<br /> <br />

				                <table class="table table-bordered" id="manageStudentTable">
				                  <thead>
				                    <tr>
				                      <th>#</th>
				                      <th>Name</th>
				                      <th>Class</th>
				                      <th>Section</th>				                      
				                      <th>Action</th>
				                    </tr>
				                  </thead>
				                </table>  

				              </div>
					    	<!--/.all student-->
					    	';
			$x = 1;
			foreach ($sectionData as $key => $value) {
				$validator['html'] .= '<div role="tabpanel" class="tab-pane" id="countSection' . $x . '">									

									<br /> <br />

									<table class="table table-bordered classSectionStudentTable" id="manageStudentTable' . $x . '" style="width:100%;">
					                  <thead>
					                    <tr>
					                      <th>#</th>
					                      <th>Name</th>
					                      <th>Class</th>
					                      <th>Section</th>
					                      <th>Action</th>
					                    </tr>
					                  </thead>
					                </table>  

					             </div>';
				$x++;
			} // /foreach                                     

			$validator['html'] .= '
					    	<!--/.section student-->
					  	</div>
					</div>			
				

			</div>';
		} else {
			$validator['success'] = false;
			foreach ($_POST as $key => $value) {
				$validator['messages'][$key] = form_error($key);
			}
		} // /else

		echo json_encode($validator);
	}


	/**
	 * fetch student data and subject
	 */


	public function fetchStudentByClass($classId = null)
	{
		if ($classId) {
			$result = array('data' => array());
			$studentData = $this->Model_Student->fetchStudentDataByClass($classId);
			foreach ($studentData as $key => $value) {

				if ($studentData) {
					$img = '<img src="' . base_url() . $value['image'] . '" class="img-circle candidate-photo" alt="Student Image" />';
					$studentName = $value['student_name'];
				} elseif (!$studentData) {
					$img = '';
					$studentName = '';
				}

				$classData = $this->Model_Classes->fetchClassData($value['class_id']);
				$sectionData = $this->Model_Section->fetchSectionByClassSection($value['class_id'], $value['section_id']);
				if ($classData) {
					$className = $classData['class_name'];
				} elseif (!$classData) {
					$className = '';
				}
				if ($sectionData) {
					$sectionName = $sectionData['section_name'];
				} elseif (!$sectionData) {
					$sectionName = '';
				}

				$studentMarksheetData = $this->Model_Marksheet->fetchStudentMarksByClassSectionStudent($value['class_id'], $value['section_id'], $value['student_id']);
				// $marksheetId = $studentMarksheetData['marksheet_id'];
				$button = '<div class="btn-group">
				  <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="modal" data-target="#viewMarksModal" onclick="viewMarks(' . $value['student_id'] . ',' . $classId . ')">
					  View
					  </button>
				  <ul class="dropdown-menu">			  	
				    <li><a href="#" data-toggle="modal" data-target="#editMarksModal" onclick="editMarks(' . $value['student_id'] . ',' . $classId . ')">Edit Marks</a></li>
				    <li><a href="#" data-toggle="modal" data-target="#viewMarksModal" onclick="viewMarks(' . $value['student_id'] . ',' . $classId . ')">View</a></li>			    
				  </ul>
				</div>';



				$result['data'][$key] = array(
					$img,
					$studentName,
					$classData['class_name'],
					$className,
					$button
				);
			} // /foreach	
			echo json_encode($result);
		}
	}
	// to fetch student marks by class
	public function fetchStudentMarksByClass($classId = null)
	{
		if ($classId) {
			$result = array('data' => array());
			$studentData = $this->Model_Student->fetchStudentDataByClass($classId);
			foreach ($studentData as $key => $value) {
				$img = '<img src="' . base_url() . $value['image'] . '" class="img-circle candidate-photo" alt="Student Image" />';

				$classData = $this->Model_Classes->fetchClassData($value['class_id']);
				$sectionData = $this->Model_Section->fetchSectionByClassSection($value['class_id'], $value['section_id']);

				$studentMarksheetData = $this->Model_Marksheet->fetchStudentMarksByClassSectionStudentSubject($value['class_id'], $value['section_id'], $value['student_id'], $subjectId);
				$marksheetId = $studentMarksheetData['marksheet_id'];

				$button = '<div class="btn-group">
				  <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
				    Action <span class="caret"></span>
				  </button>
				  <ul class="dropdown-menu">			  	
				    <li><a href="#" data-toggle="modal" data-target="#editMarksModal" onclick="editMarks(' . $value['student_id'] . ',' . $classId . ')">Edit Marks</a></li>
				    <li><a href="#" data-toggle="modal" data-target="#viewMarksModal" onclick="viewMarks(' . $value['student_id'] . ',' . $classId . ')">View</a></li>			    
				  </ul>
				</div>';
				$obtainmark = '
				<input type="text" value=' . $studentMarksheetData['obtain_mark'] . ' >
				';

				$result['data'][$key] = array(
					$img,
					$value['student_name'],
					$classData['class_name'],
					$sectionData['section_name'],
					$button,
					$button,
					$button,
					$button,
					$button
				);
			} // /foreach	
			echo json_encode($result);
		}
	}

	/*
	*------------------------------------
	* fetch student's data thorugh
	* class id and section id
	*------------------------------------
	*/
	public function fetchStudentByClassAndSection($classId = null, $sectionId = null)
	{
		if ($classId && $sectionId) {
			$studentData = $this->Model_Student->fetchStudentByClassAndSection($classId, $sectionId);
			$result = array('data' => array());
			foreach ($studentData as $key => $value) {
				$img = '<img src="' . base_url() . $value['image'] . '" class="img-circle candidate-photo" alt="Student Image" />';

				$classData = $this->Model_Classes->fetchClassData($value['class_id']);
				$sectionData = $this->Model_Section->fetchSectionByClassSection($value['class_id'], $value['section_id']);

				$studentMarksheetData = $this->Model_Marksheet->fetchStudentMarksByClassSectionStudent($value['class_id'], $value['section_id'], $value['student_id']);
				// $marksheetId = $studentMarksheetData['marksheet_id'];

				$button = '<div class="btn-group">
				  <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
				    Action <span class="caret"></span>
				  </button>
				  <ul class="dropdown-menu">			  	
				    <li><a href="#" data-toggle="modal" data-target="#editMarksModal" onclick="editMarks(' . $value['student_id'] . ',' . $classId . ')">Edit Marks</a></li>
				    <li><a href="#" data-toggle="modal" data-target="#viewMarksModal" onclick="viewMarks(' . $value['student_id'] . ',' . $classId . ')">View</a></li>			    
				  </ul>
				</div>';

				$result['data'][$key] = array(
					$img,
					$value['student_name'],
					$classData['class_name'],
					$sectionData['section_name'],
					$button
				);
			} // /froeach			
			echo json_encode($result);
		} // /if		
	}

	/*
	*------------------------------------------------------
	* fetch the student marksheet data function
	*------------------------------------------------------
	*/
	public function studentMarksheetData($studentId = null, $classId = null, $marksheetId = null)
	{
		if ($studentId && $classId && $marksheetId) {
			$marksheetName = $this->Model_Marksheet->fetchMarksheetDataByMarksheetId($marksheetId);
			$marksheetStudentData = $this->Model_Marksheet->fetchStudentMarksheetData($studentId, $classId, $marksheetId);
			$additionalMarksheetStudentData = $this->Model_Marksheet->fetchStudentAdditionalMarksheetData($studentId, $classId, $marksheetId);
			$classData = $this->Model_Classes->fetchClassData($classId);

			if ($classData['numeric_name'] < 1) {
				$form = '

			<form class="form-horizontal" action="marksheet/createStudentMarks" method="post" id="createStudentMarksForm">
			  <div class="form-group">
			    <label class="col-sm-2 control-label">Name</label>
			    <div class="col-sm-10">
			      <label class="form-control">' . $marksheetName['marksheet_name'] . '</label>
			    </div>
			  </div>';
				$x = 1;
				$grand_total_1 = 0;
				$grand_total_2 = 0;
				foreach ($marksheetStudentData as $key => $value) {
					$obtainMark_1 = 0;
					$obtainMark_2 = 0;


					$subjectData = $this->Model_Subject->fetchSubjectByClassSection($value['class_id'], $value['subject_id']);
					$total_term_1 = $value['obtain_mark'] + $value['obtain_mark_sa'];
					$total_term_2 = $value['obtain_mark_pt_2'] + $value['obtain_mark_sa_2'];

					$form .= '<div class="form-group">
				  <table class="table table-bordered">
				  <tr>
			    <th><label for="inputPassword3">' . $subjectData['name'] . ' (PT 1)</label></th>
			    <th><label for="inputPassword3">' . $subjectData['name'] . ' (SA 1)</label></th>
				
				<th><label for="inputPassword3">' . $subjectData['name'] . ' (PT 2)</label></th>
				<th><label for="inputPassword3">' . $subjectData['name'] . ' (SA 2)</label></th>
				
				</tr>
				<tr>
				<div class="col-sm-10">			      
			    	<td><input type="text" class="form-control" name="studentMarks[' . $x . ']" id="studentMarks' . $x . '" value="' . $value['obtain_mark'] . '" /></td>			    	
			    	<input type="hidden" name="marksheetStudentId[' . $x . ']" value="' . $value['marksheet_student_id'] . '" />			    	
			    </div>
				
				<div class="col-sm-10">			      
				 <td><input type="text" class="form-control" name="studentMarksSA[' . $x . ']" id="studentMarksSA' . $x . '" value="' . $value['obtain_mark_sa'] . '" />	</td>		    	
			    	<input type="hidden" name="marksheetStudentId[' . $x . ']" value="' . $value['marksheet_student_id'] . '" />			    	
			    </div>
				<div class="col-sm-10">			      
				 <td><input type="text" class="form-control" name="studentMarksPT2[' . $x . ']" id="studentMarksPT2' . $x . '" value="' . $value['obtain_mark_pt_2'] . '" />	</td>		    	
			    	<input type="hidden" name="marksheetStudentId[' . $x . ']" value="' . $value['marksheet_student_id'] . '" />			    	
			    </div>
				<div class="col-sm-10">			      
				 <td><input type="text" class="form-control" name="studentMarksSA2[' . $x . ']" id="studentMarksSA2' . $x . '" value="' . $value['obtain_mark_sa_2'] . '" />	</td>		    	
			    	<input type="hidden" name="marksheetStudentId[' . $x . ']" value="' . $value['marksheet_student_id'] . '" />			    	
			    </div>
				
				</tr>
				</table>
				

			  </div>';

					// echo $grand_total_2 += $total_term_2;
					// echo  $total_term = $total_term + $total_term_1;
					/*$grand_total_1 += $total_term_1;
			 $grand_total_2 += $total_term_2;
			 $form .= '
				<div class="col-sm-10">			      
				    <input type="text" class="form-control" name="grandTotal1['.$x.']" id="grandTotal1'.$x.'" value="'.$grand_total_1.'" />	</td>		    	
			    	<input type="" name="marksheetStudentId['.$x.']" value="'.$value['marksheet_student_id'].'" />			    	
			    </div>
				<div class="col-sm-10">			      
				    <input type="text" class="form-control" name="grandTotal2['.$x.']" id="grandTotal2'.$x.'" value="'.$grand_total_2.'" />	</td>		    	
			    	<input type="" name="marksheetStudentId['.$x.']" value="'.$value['marksheet_student_id'].'" />			    	
			    </div>
				';
			  */
					$x++;
					// echo $grand_total_1;

				}

				//echo $grand_total_2;
				//echo $x = 1;	



				$form .= '				 
			  
			  <div class="form-group">
			  
			    <div class="col-sm-offset-2 col-sm-10">			    	
			    	<button type="submit" class="btn btn-primary">Save Changes</button>
			    </div>
			  </div>
			</form>';
			} else {
				$form = '

			<form class="form-horizontal" action="marksheet/createStudentMarksHigher" method="post" id="createStudentMarksForm">
			  <div class="form-group">
			    <label class="col-sm-2 control-label">Name</label>
			    <div class="col-sm-10">
			      <label class="form-control">' . $marksheetName['marksheet_name'] . '</label>
			    </div>
			  </div>';
				$x = 1;
				$y = 1;
				$grand_total_1 = 0;
				$grand_total_2 = 0;
				foreach ($marksheetStudentData as $key => $value) {
					$obtainMark_1 = 0;
					$obtainMark_2 = 0;


					$subjectData = $this->Model_Subject->fetchSubjectByClassSection($value['class_id'], $value['subject_id']);
					$additionalSubjectData = $this->Model_Subject->fetchAdditionalSubjectByClassSection($value['class_id'], $value['subject_id']);
					$total_term_1 = $value['obtain_mark'] + $value['obtain_mark_sa'];
					$total_term_2 = $value['obtain_mark_pt_2'] + $value['obtain_mark_sa_2'];

					$form .= '<div class="form-group">
				  <table class="table table-bordered">
				  <tr>
				 <th colspan="4"> Term - 1</th> 
				 <th colspan="4"> Term - 2</th> 
				  </tr>
				  <tr>
				  <th colspan="4"> ' . $subjectData['name'] . '</th> 
				  <th colspan="4"> ' . $subjectData['name'] . '</th> 
				   </tr>
				  <tr>
			    <th><label for="inputPassword3"> Per Test</label></th>
			    <th><label for="inputPassword3"> Note Book</label></th>
				<th><label for="inputPassword3"> Subject Enrichment</label></th>
				<th><label for="inputPassword3"> Half Yrly Exams</label></th>
				
				<th><label for="inputPassword3">Per Test</label></th>
			    <th><label for="inputPassword3"> Note Book</label></th>
				<th><label for="inputPassword3"> Subject Enrichment</label></th>
				<th><label for="inputPassword3"> Yearly Exams</label></th>
				
				</tr>
				<tr>
				<div class="col-sm-10">			      
			    	<td><input type="text" class="form-control" name="studentMarks[' . $x . ']" id="studentMarks' . $x . '" value="' . $value['obtain_mark'] . '" /></td>			    	
			    	<input type="hidden" name="marksheetStudentId[' . $x . ']" value="' . $value['marksheet_student_id'] . '" />			    	
			    </div>
				
				<div class="col-sm-10">			      
				 <td><input type="text" class="form-control" name="studentMarksNBHY[' . $x . ']" id="studentMarksNBY' . $x . '" value="' . $value['obtain_mark_sa'] . '" />	</td>		    	
			    	<input type="hidden" name="marksheetStudentId[' . $x . ']" value="' . $value['marksheet_student_id'] . '" />			    	
			    </div>
				<td><input type="text" class="form-control" name="studentMarksSEHY[' . $x . ']" id="studentMarksSEHY' . $x . '" value="' . $value['subject_enrichmenth'] . '" />	</td>		    	
				<input type="hidden" name="marksheetStudentId[' . $x . ']" value="' . $value['marksheet_student_id'] . '" />			    	
				</div>
				<td><input type="text" class="form-control" name="studentMarksHY[' . $x . ']" id="studentMarksHY' . $x . '" value="' . $value['h_yrly'] . '" />	</td>		    	
				<input type="hidden" name="marksheetStudentId[' . $x . ']" value="' . $value['marksheet_student_id'] . '" />			    	
			    </div>

				<div class="col-sm-10">			      
				 <td><input type="text" class="form-control" name="studentMarksPT2[' . $x . ']" id="studentMarksPT2' . $x . '" value="' . $value['obtain_mark_pt_2'] . '" />	</td>		    	
			    	<input type="hidden" name="marksheetStudentId[' . $x . ']" value="' . $value['marksheet_student_id'] . '" />			    	
			    </div>
				<div class="col-sm-10">			      
				 <td><input type="text" class="form-control" name="studentMarksNBY[' . $x . ']" id="studentMarksNBY' . $x . '" value="' . $value['obtain_mark_sa_2'] . '" />	</td>		    	
			    	<input type="hidden" name="marksheetStudentId[' . $x . ']" value="' . $value['marksheet_student_id'] . '" />			    	
			    </div>
				<div class="col-sm-10">			      
				 <td><input type="text" class="form-control" name="studentMarksSEY[' . $x . ']" id="studentMarksSEY' . $x . '" value="' . $value['subject_enrichmentf'] . '" />	</td>		    	
			    	<input type="hidden" name="marksheetStudentId[' . $x . ']" value="' . $value['marksheet_student_id'] . '" />			    	
			    </div>
				<div class="col-sm-10">			      
				 <td><input type="text" class="form-control" name="studentMarksY[' . $x . ']" id="studentMarksY' . $x . '" value="' . $value['yrly'] . '" />	</td>		    	
			    	<input type="hidden" name="marksheetStudentId[' . $x . ']" value="' . $value['marksheet_student_id'] . '" />			    	
			    </div>
				
				</tr>
				</table>
				

			  </div>';

					// echo $grand_total_2 += $total_term_2;
					// echo  $total_term = $total_term + $total_term_1;
					/*$grand_total_1 += $total_term_1;
			 $grand_total_2 += $total_term_2;
			 $form .= '
				<div class="col-sm-10">			      
				    <input type="text" class="form-control" name="grandTotal1['.$x.']" id="grandTotal1'.$x.'" value="'.$grand_total_1.'" />	</td>		    	
			    	<input type="" name="marksheetStudentId['.$x.']" value="'.$value['marksheet_student_id'].'" />			    	
			    </div>
				<div class="col-sm-10">			      
				    <input type="text" class="form-control" name="grandTotal2['.$x.']" id="grandTotal2'.$x.'" value="'.$grand_total_2.'" />	</td>		    	
			    	<input type="" name="marksheetStudentId['.$x.']" value="'.$value['marksheet_student_id'].'" />			    	
			    </div>
				';
			  */
					$x++;
					// echo $grand_total_1;

				}

				foreach ($additionalMarksheetStudentData as $key => $value) {
					$obtainMark_1 = 0;
					$obtainMark_2 = 0;


					$subjectData = $this->Model_Subject->fetchSubjectByClassSection($value['class_id'], $value['subject_id']);
					$additionalSubjectData = $this->Model_Subject->fetchAdditionalSubjectByClassSection($value['class_id'], $value['subject_id']);
					$total_term_1 = $value['obtain_mark'] + $value['obtain_mark_sa'];
					$total_term_2 = $value['obtain_mark_pt_2'] + $value['obtain_mark_sa_2'];

					$form .= '<div class="form-group">
				  <table class="table table-bordered">
				  <tr>
				 <th colspan="4"> Term - 1</th> 
				 <th colspan="4"> Term - 2</th> 
				  </tr>
				  <tr>
				  <th colspan="4"> ' . $additionalSubjectData['name'] . '</th> 
				  <th colspan="4"> ' . $additionalSubjectData['name'] . '</th> 
				   </tr>
				  <tr>
			    <th><label for="inputPassword3"> Per Test</label></th>
			    <th><label for="inputPassword3"> Note Book</label></th>
				<th><label for="inputPassword3"> Subject Enrichment</label></th>
				<th><label for="inputPassword3"> Half Yrly Exams</label></th>
				
				<th><label for="inputPassword3">Per Test</label></th>
			    <th><label for="inputPassword3"> Note Book</label></th>
				<th><label for="inputPassword3"> Subject Enrichment</label></th>
				<th><label for="inputPassword3"> Yearly Exams</label></th>
				
				</tr>
				<tr>
				<div class="col-sm-10">			      
			    	<td><input type="text" class="form-control" name="studentMarksAD[' . $y . ']" id="studentMarksAD' . $y . '" value="' . $value['obtain_mark'] . '" /></td>			    	
			    	<input type="hidden" name="marksheetStudentId[' . $y . ']" value="' . $value['marksheet_student_id'] . '" />			    	
			    </div>
				
				<div class="col-sm-10">			      
				 <td><input type="text" class="form-control" name="studentMarksADNBHY[' . $y . ']" id="studentMarksADNBHY' . $y . '" value="' . $value['obtain_mark_sa'] . '" />	</td>		    	
			    	<input type="hidden" name="marksheetStudentId[' . $y . ']" value="' . $value['marksheet_student_id'] . '" />			    	
			    </div>
				<td><input type="text" class="form-control" name="studentMarksADSEHY[' . $y . ']" id="studentMarksADSEHY' . $y . '" value="' . $value['subject_enrichmenth'] . '" />	</td>		    	
				<input type="hidden" name="marksheetStudentId[' . $y . ']" value="' . $value['marksheet_student_id'] . '" />			    	
				</div>
				<td><input type="text" class="form-control" name="studentMarksADHY[' . $y . ']" id="studentMarksADHY' . $y . '" value="' . $value['h_yrly'] . '" />	</td>		    	
				<input type="hidden" name="marksheetStudentId[' . $y . ']" value="' . $value['marksheet_student_id'] . '" />			    	
			    </div>

				<div class="col-sm-10">			      
				 <td><input type="text" class="form-control" name="studentMarksADPT2[' . $y . ']" id="studentMarksADPT2' . $y . '" value="' . $value['obtain_mark_pt_2'] . '" />	</td>		    	
			    	<input type="hidden" name="marksheetStudentId[' . $y . ']" value="' . $value['marksheet_student_id'] . '" />			    	
			    </div>
				<div class="col-sm-10">			      
				 <td><input type="text" class="form-control" name="studentMarksADNBY[' . $y . ']" id="studentMarksADNBY' . $y . '" value="' . $value['obtain_mark_sa_2'] . '" />	</td>		    	
			    	<input type="hidden" name="marksheetStudentId[' . $y . ']" value="' . $value['marksheet_student_id'] . '" />			    	
			    </div>
				<div class="col-sm-10">			      
				 <td><input type="text" class="form-control" name="studentMarksADSEY[' . $y . ']" id="studentMarksADSEY' . $y . '" value="' . $value['subject_enrichmentf'] . '" />	</td>		    	
			    	<input type="hidden" name="marksheetStudentId[' . $y . ']" value="' . $value['marksheet_student_id'] . '" />			    	
			    </div>
				<div class="col-sm-10">			      
				 <td><input type="text" class="form-control" name="studentMarksADY[' . $y . ']" id="studentMarksADY' . $y . '" value="' . $value['yrly'] . '" />	</td>		    	
			    	<input type="hidden" name="marksheetStudentId[' . $y . ']" value="' . $value['marksheet_student_id'] . '" />			    	
			    </div>
				
				</tr>
				</table>
				

			  </div>';

					// echo $grand_total_2 += $total_term_2;
					// echo  $total_term = $total_term + $total_term_1;
					/*$grand_total_1 += $total_term_1;
			 $grand_total_2 += $total_term_2;
			 $form .= '
				<div class="col-sm-10">			      
				    <input type="text" class="form-control" name="grandTotal1['.$x.']" id="grandTotal1'.$x.'" value="'.$grand_total_1.'" />	</td>		    	
			    	<input type="" name="marksheetStudentId['.$x.']" value="'.$value['marksheet_student_id'].'" />			    	
			    </div>
				<div class="col-sm-10">			      
				    <input type="text" class="form-control" name="grandTotal2['.$x.']" id="grandTotal2'.$x.'" value="'.$grand_total_2.'" />	</td>		    	
			    	<input type="" name="marksheetStudentId['.$x.']" value="'.$value['marksheet_student_id'].'" />			    	
			    </div>
				';
			  */
					$y++;
					// echo $grand_total_1;

				}

				//echo $grand_total_2;
				//echo $x = 1;	



				$form .= '				 
			  
			  <div class="form-group">
			  
			    <div class="col-sm-offset-2 col-sm-10">			    	
			    	<button type="submit" class="btn btn-primary">Save Changes</button>
			    </div>
			  </div>
			</form>';
			}

			echo $form;
		} // /.if
	}

	/*
	*-----------------------------------
	* insert student's subjcet marks
	*-----------------------------------
	*/
	public function createStudentMarks()
	{

		$studentMarks = $this->input->post('studentMarks');
		if (!empty($studentMarks)) {
			foreach ($studentMarks as $key => $value) {
				$this->form_validation->set_rules('studentMarks[' . $key . ']', 'Marks', 'numeric');
			}
		}

		$this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>');

		if ($this->form_validation->run()) {
			$this->Model_Marksheet->createStudentMarks();

			$validator['success'] = true;
			$validator['messages'] = "Successfully added";
		} else {
			$validator['success'] = false;
			foreach ($_POST as $key => $value) {
				if ($key == 'studentMarks') {
					foreach ($value as $number => $data) {
						$validator['messages']['studentMarks' . $number] = form_error('studentMarks[' . $number . ']');
					}
				}
			} // /foreach		
		} // /else

		echo json_encode($validator);
	}

	public function createStudentMarksHigher()
	{

		$studentMarks = $this->input->post('studentMarks');
		if (!empty($studentMarks)) {
			foreach ($studentMarks as $key => $value) {
				$this->form_validation->set_rules('studentMarks[' . $key . ']', 'Marks', 'numeric');
			}
		}

		$this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>');

		if ($this->form_validation->run()) {
			$this->Model_Marksheet->createStudentMarksHigher();

			$validator['success'] = true;
			$validator['messages'] = "Successfully added";
		} else {
			$validator['success'] = false;
			foreach ($_POST as $key => $value) {
				if ($key == 'studentMarks') {
					foreach ($value as $number => $data) {
						$validator['messages']['studentMarks' . $number] = form_error('studentMarks[' . $number . ']');
					}
				}
			} // /foreach		
		} // /else

		echo json_encode($validator);
	}

	/*
	*-----------------------------------
	* views student's subjcet marks
	*-----------------------------------
	*/
	public function viewStudentMarksheet($studentId = null, $classId = null, $marksheetId = null)
	{
		if ($studentId && $classId && $marksheetId) {
			$studentMarksheetData = $this->Model_Marksheet->fetchMarksheetDataByMarksheetId($marksheetId);
			$studentMarkData = $this->Model_Marksheet->viewStudentMarksheet($studentId, $classId, $marksheetId);
			$studentAdditionalMarkData = $this->Model_Marksheet->viewStudentAdditionalMarksheet($studentId, $classId, $marksheetId);
			$studentData = $this->Model_Student->fetchStudentData($studentId);
			$classData = $this->Model_Classes->fetchClassData($classId);
			$sectionId = $studentData['section_id'];
			$sectionData = $this->Model_Section->fetchSectionByClassSection($classId, $sectionId);

			if ($classData['numeric_name'] < 1) {
				$div = '
			<div>
			<h3 style="text-align:center;font-weight:bold;">Progressive Children Academy</h3>
			<h5 style="text-align:center;font-weight:bold;">Rehla Palmau Jharkhand - 822124</h5>
			<img src="' . base_url() . 'assets/images/logo _black.png" style="display:block;margin-left:auto;margin-right:auto;">
			<h5 style="text-align:center;font-weight:bold;"></h5>
			<h4 style="text-align:center;font-weight:bold;margin-left:auto;margin-right:auto; box-sizing: content-box;  
			width: 200px;
			height: 20px;
			padding: 5px;  
			border: 1px solid black; border-radius:5px;">Progress Report Card</h4>
			<h5 style="text-align:center;font-weight:bold;">Session - ' . $studentMarksheetData['marksheet_name'] . '</h5>
			<table style="border:none;">
			<tr>
			<td><b>Student&#39;s Name : </b>' . $studentData['student_name'] . '</td>
			<td><b>Class :</b> ' . $classData['class_name'] . '</td>
			</tr>
			<tr>
			<td><b>Father&#39;s Name : </b>' . $studentData['father_name'] . '</td>
			<td><b>Section :</b> ' . $sectionData['section_name'] . '</td>
			</tr>
			<tr>
			<td><b>Mother&#39;s Name : </b>' . $studentData['mother_name'] . '</td>
			<td><b>Date of Birth :</b> ' . $studentData['dob'] . '</td>
			</tr>
			<tr>
			<td><b>Mobile Number : </b>' . $studentData['p_phone'] . '</td>
			<td><b>Admission No. :</b> ' . $studentData['admssion_no'] . '</td>
			</tr>
			</table>
			
			<h3 style="color:red;text-align:center;">MY ACADEMIC ASSESSMENT</h3>
			<table class="table table-bordered">
			<tr>
			<th rowspan="2">Subjects</th>
			<th colspan="3" style="text-align:center;">Term - I</th>
			<th colspan="3" style="text-align:center;">Term - II</th>
			</tr>
				<tr>
				
				<th>PT 1(20)</th>
				<th>SA 1(80)</th>
				<th>TOTAL(100)</th>
				<th>PT 2(20)</th>
				<th>SA 2(80)</</th>
				<th>TOTAL(100)</th>
				</tr>';

				$totalMark = 0;
				$obtainMark_1 = 0;
				$obtainMark_2 = 0;
				$percentage_1 = 0;
				$percentage_2 = 0;

				foreach ($studentMarkData as $key => $value) {
					$subjectData = $this->Model_Subject->fetchSubjectByClassSection($value['class_id'], $value['subject_id']);
					$total_term_1 = (float)$value['obtain_mark'] + (float)$value['obtain_mark_sa'];
					$total_term_2 = (float)$value['obtain_mark_pt_2'] + (float)$value['obtain_mark_sa_2'];
					$div .= '<tr>					
					<td>' . $subjectData['name'] . '</td>
					<td>' . $value['obtain_mark'] . '</td>
					<td>' . $value['obtain_mark_sa'] . '</td>
					<td>' . $total_term_1 . '</td>
					<td>' . $value['obtain_mark_pt_2'] . '</td>
					<td>' . $value['obtain_mark_sa_2'] . '</td>
					<td>' . $total_term_2 . '</td>
					
					
				</tr>';

					$totalMark += $subjectData['total_mark'];
					$obtainMark_1 += $total_term_1;
					$obtainMark_2 += $total_term_2;

					$percentage_1 = ($obtainMark_1 / $totalMark) * 100;
					$percentage_2 = ($obtainMark_2 / $totalMark) * 100;
				}

				$div .= '
			<tr>
			<th>Grand Total</th>
			<td></td>
			<td></td>
			<td>' . $obtainMark_1 . '</td>
			<td></td>
			<td></td>
			<td>' . $obtainMark_2 . '</td>
			</tr>
			<tr>
			<th>Percentage</th>
			<td></td>
			<td></td>
			<td>' . round($percentage_1, 2) . ' %</td>
			<td></td>
			<td></td>
			<td>' . round($percentage_2, 2) . ' %</td>
			</tr>
			<tr>
			<th>Rank</th>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			</tr>
			</table>
			</div><br/><br/>
			<style>
* {
  box-sizing: border-box;
}

.row {
  margin-left:-5px;
  margin-right:-5px;
}
  
.column {
  float: left;
  width: 50%;
  padding: 5px;
}

/* Clearfix (clear floats) */
.row::after {
  content: "";
  clear: both;
  display: table;
}

table {
  border-collapse: collapse;
  border-spacing: 0;
  width: 100%;
  border: 1px solid #ddd;
}

th, td {
  text-align: left;
  padding: 16px;
}

</style>
<div class="row">
  <div class="column">
  <h4 style="text-align:center;font-weight:bold;">MY SKILL DEVELOPMENT</h4>
    <table class="table table-bordered" style="font-size:10px;">
      <tr>
        <th></th>
        <th>I</th>
        <th>II</th>
      </tr>
      <tr>
        <td>Conversation</td>
        <td></td>
        <td></td>
      </tr>
      <tr>
        <td>Clarity of Speech</td>
        <td></td>
        <td></td>
      </tr>
      <tr>
        <td>Pronounciation</td>
        <td></td>
        <td></td>
      </tr>
	  <tr>
        <td>Recitation</td>
        <td></td>
        <td></td>
      </tr>
	  <tr>
        <td>Vocabulary</td>
        <td></td>
        <td></td>
      </tr>
	  <tr>
	  <td>Narrative Skills</td>
	  <td></td>
	  <td></td>
	 </tr>
	<tr>
	<td>Identification of Objects</td>
	<td></td>
	<td></td>
    </tr>
    </table>
	<h4 style="text-align:center;font-weight:bold;">MY SOCIAL & PHYSCIAL DEVELOPMENT REPORT</h4>
    <table class="table table-bordered" style="font-size:10px;">
      <tr>
        <th></th>
        <th>I</th>
        <th>II</th>
      </tr>
      <tr>
        <td>Enjoys Working</td>
        <td></td>
        <td></td>
      </tr>
      <tr>
        <td>Is Friendly</td>
        <td></td>
        <td></td>
      </tr>
      <tr>
        <td>Is Active During Play Time</td>
        <td></td>
        <td></td>
      </tr>
	  <tr>
        <td>Follows Instructions</td>
        <td></td>
        <td></td>
      </tr>
	  <tr>
        <td>Likes to sing / dance</td>
        <td></td>
        <td></td>
      </tr>
	  <tr>
	  <td>Can work independently</td>
	  <td></td>
	  <td></td>
	 </tr>
	<tr>
	<td>Can work with others</td>
	<td></td>
	<td></td>
    </tr>
	<tr>
	<td>Likes to share</td>
	<td></td>
	<td></td>
    </tr>
	<tr>
	<td>Is alternative in class</td>
	<td></td>
	<td></td>
    </tr>
	<tr>
	<td>Is courteous</td>
	<td></td>
	<td></td>
    </tr>
	<tr>
	<td>Is neat & clean</td>
	<td></td>
	<td></td>
    </tr>
	<tr>
	<td>Is punctual & regular</td>
	<td></td>
	<td></td>
    </tr>
    </table>
	<h6 style="text-align:center;font-weight:bold;">MY SPECIAL ACHIEVEMENTS<br/>(If Any)</h6>
	<p>1....................................</p>
	<p>2....................................</p>
  </div>

  <div class="column">
  <h4 style="text-align:center;font-weight:bold;">MY CLASS ACTIVITIES</h4>
  <h4 style="text-align:center;font-weight:bold;">(Grade A, B, C)</h4>
    <table class="table table-bordered" style="font-size:10px;">
      <tr>
        <th></th>
        <th>I</th>
        <th>II</th>
      </tr>
      <tr>
        <td>Rhymes</td>
        <td></td>
        <td></td>
      </tr>
      <tr>
        <td>Singing</td>
        <td></td>
        <td></td>
      </tr>
      <tr>
        <td>Stories</td>
        <td></td>
        <td></td>
      </tr>
	  <tr>
        <td>Craft Work</td>
        <td></td>
        <td></td>
      </tr>
	  <tr>
        <td>Indoor Outdoor Play</td>
        <td></td>
        <td></td>
      </tr>
    </table>
	<h4 style="text-align:center;font-weight:bold;">MY CLASS COMPETITIONS</h4>
    <p>1. Colouring ..............</p>
	<p>2. Singing ..............</p>
	<p>3. Recitation ..............</p>
	<p>4. Dancing ..............</p>
  </div>
  <div class="column" style="font-size:10px;">
  <h4 style="text-align:center;font-weight:bold;">MY TEACHER&#39;S REMARKS</h4>
    <p>1st Term .........................................</p>
	<p>..................................................</p>
	<p>..................................................</p><br/<br/>
	<p>........................ &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  ........................</p>
	<p>Teacher &#39;s Signature   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;     Principal&#39;s Signature</p>
	<p>Date: </p>
  </div>
  <div class="column" style="font-size:10px;">
    <p>2nd Term .........................................</p>
	<p>..................................................</p>
	<p>..................................................</p><br/<br/>
	<p>........................ &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  ........................</p>
	<p>Teacher &#39;s Signature   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;     Principal&#39;s Signature</p>
	<p>Date: </p>
	<h5 style="font-weight:bold;color:red;">Promoted to Class...............</h5>
	<p>.............</p>
	<p>Principal&#39;s Signature</p>
	<p>School Reported On ...........</p>
	</div>
  
</div>

			';
			} else {
				$div = '
	<div>
			<h3 style="text-align:center;font-weight:bold;">Progressive Children Academy</h3>
			<h5 style="text-align:center;font-weight:bold;">Rehla Palmau Jharkhand - 822124</h5>
			<img src="' . base_url() . 'assets/images/logo _black.png" style="display:block;margin-left:auto;margin-right:auto;">
			<h5 style="text-align:center;font-weight:bold;"></h5>
			<h4 style="text-align:center;font-weight:bold;margin-left:auto;margin-right:auto; box-sizing: content-box;  
			width: 200px;
			height: 20px;
			padding: 5px;  
			border: 1px solid black; border-radius:5px;">Progress Report Card</h4>
			<h5 style="text-align:center;font-weight:bold;">Session - ' . $studentMarksheetData['marksheet_name'] . '</h5>
			<table style="border:none;">
			<tr>
			<td><b>Student&#39;s Name : </b>' . $studentData['student_name'] . '</td>
			<td><b>Class :</b> ' . $classData['class_name'] . '</td>
			</tr>
			<tr>
			<td><b>Father&#39;s Name : </b>' . $studentData['father_name'] . '</td>
			<td><b>Section :</b> ' . $sectionData['section_name'] . '</td>
			</tr>
			<tr>
			<td><b>Mother&#39;s Name : </b>' . $studentData['mother_name'] . '</td>
			<td><b>Date of Birth :</b> ' . $studentData['dob'] . '</td>
			</tr>
			<tr>
			<td><b>Mobile Number : </b>' . $studentData['p_phone'] . '</td>
			<td><b>Admission No. :</b> ' . $studentData['admssion_no'] . '</td>
			</tr>
			</table><br/>
		<table class="table table-bordered">
	<tr style="font-size:12px;">
	<th>Scholastic Areas</th>
	<th colspan="6" style="text-align:center;">Term - 1 (100 Marks)</th>
	</tr>
	<tr style="font-size:12px;">
	<th>Sub Name</th>
	<th>Per Test(10)</th>
	<th>Note Books(5)</th>
	<th>Subject Enrichment(5)</th>
	<th>Half Yrly Exams(80)</th>
	<th>Marks Obtained(100)</th>
	<th>GR</th>
	</tr>';
				$totalMark = 0;
				$obtainMark_1 = 0;
				$obtainMark_2 = 0;
				$percentage_1 = 0;
				$percentage_2 = 0;
				$grade1 = '';

				foreach ($studentMarkData as $key => $value) {
					$subjectData = $this->Model_Subject->fetchSubjectByClassSection($value['class_id'], $value['subject_id']);
					$total_term_1 = (float)$value['obtain_mark'] + (float)$value['obtain_mark_sa'] + (float)$value['subject_enrichmenth'] + (float)$value['h_yrly'];
					//$total_term_2 = $value['obtain_mark_pt_2'] + $value['obtain_mark_sa_2'];
					if ($total_term_1 >= 91 && $total_term_1 <= 100) {
						$grade1 = 'A1';
					} elseif ($total_term_1 >= 81 && $total_term_1 <= 90) {
						$grade1 = 'A2';
					} elseif ($total_term_1 >= 71 && $total_term_1 <= 80) {
						$grade1 = 'B1';
					} elseif ($total_term_1 >= 61 && $total_term_1 <= 70) {
						$grade1 = 'B2';
					} elseif ($total_term_1 >= 51 && $total_term_1 <= 60) {
						$grade1 = 'C1';
					} elseif ($total_term_1 >= 41 && $total_term_1 <= 50) {
						$grade1 = 'C2';
					} elseif ($total_term_1 >= 33 && $total_term_1 <= 40) {
						$grade1 = 'D';
					} elseif ($total_term_1 < 32) {
						$grade1 = 'NI';
					}
					$div .= '<tr style="font-size:12px;">					
					<td>' . $subjectData['name'] . '</td>
					<td>' . $value['obtain_mark'] . '</td>
					<td>' . $value['obtain_mark_sa'] . '</td>
					<td>' . $value['subject_enrichmenth'] . '</td>
					<td>' . $value['h_yrly'] . '</td>
					<td>' . $total_term_1 . '</td>
					<td>' . $grade1 . '</td>
					
					
				</tr>';

					$totalMark += $subjectData['total_mark'];
					$obtainMark_1 += $total_term_1;
					//$obtainMark_2 += $total_term_2;

					$percentage_1 = ($obtainMark_1 / $totalMark) * 100;
					//$percentage_2 = ($obtainMark_2 / $totalMark) * 100;

				}
				$div .= '
	</table>
	<table class="table table-bordered">
	<tr style="font-size:12px;">
	<th>Scholastic Areas</th>
	<th colspan="6" style="text-align:center;">Term - 2 (100 Marks)</th>
	</tr>
	<tr style="font-size:12px;">
	<th>Sub Name</th>
	<th>Per Test(10)</th>
	<th>Note Books(5)</th>
	<th>Subject Enrichment(5)</th>
	<th>Yearly Exams(80)</th>
	<th>Marks Obtained(100)</th>
	<th>GR</th>
	</tr>';
				$totalMark = 0;
				$obtainMark_1 = 0;
				$obtainMark_2 = 0;
				$percentage_1 = 0;
				$percentage_2 = 0;
				$grade2 = '';

				foreach ($studentMarkData as $key => $value) {
					$subjectData = $this->Model_Subject->fetchSubjectByClassSection($value['class_id'], $value['subject_id']);
					//$total_term_1 = $value['obtain_mark'] + $value['obtain_mark_sa'];
					$total_term_2 = (float)$value['obtain_mark_pt_2'] + (float)$value['obtain_mark_sa_2'] + (float)$value['subject_enrichmentf'] + (float)$value['yrly'];
					if ($total_term_2 >= 91 && $total_term_2 <= 100) {
						$grade2 = 'A1';
					} elseif ($total_term_2 >= 81 && $total_term_2 <= 90) {
						$grade2 = 'A2';
					} elseif ($total_term_2 >= 71 && $total_term_2 <= 80) {
						$grade2 = 'B1';
					} elseif ($total_term_2 >= 61 && $total_term_2 <= 70) {
						$grade2 = 'B2';
					} elseif ($total_term_2 >= 51 && $total_term_2 <= 60) {
						$grade2 = 'C1';
					} elseif ($total_term_2 >= 41 && $total_term_2 <= 50) {
						$grade2 = 'C2';
					} elseif ($total_term_2 >= 33 && $total_term_2 <= 40) {
						$grade2 = 'D';
					} elseif ($total_term_2 < 32) {
						$grade2 = 'NI';
					}
					$div .= '<tr style="font-size:12px;">					
		<td>' . $subjectData['name'] . '</td>
		<td>' . $value['obtain_mark_pt_2'] . '</td>
		<td>' . $value['obtain_mark_sa_2'] . '</td>
		<td>' . $value['subject_enrichmentf'] . '</td>
		<td>' . $value['yrly'] . '</td>
		<td>' . $total_term_2 . '</td>
		<td>' . $grade2 . '</td>
		
		
	</tr>';

					$totalMark += $subjectData['total_mark'];
					//$obtainMark_1 += $total_term_1;
					$obtainMark_2 += $total_term_2;

					//$percentage_1 = ($obtainMark_1 / $totalMark) * 100;
					$percentage_2 = ($obtainMark_2 / $totalMark) * 100;
				}
				$div .= '
	</table>
	<style>
	* {
	  box-sizing: border-box;
	}
	
	.row {
	  margin-left:-5px;
	  margin-right:-5px;
	}
	  
	.column {
	  float: left;
	  width: 50%;
	  padding: 5px;
	}
	
	/* Clearfix (clear floats) */
	.row::after {
	  content: "";
	  clear: both;
	  display: table;
	}
	
	table {
	  border-collapse: collapse;
	  border-spacing: 0;
	  width: 100%;
	  border: 1px solid #ddd;
	}
	
	
	
	</style>
	<div class="row">
	<div class="column">
	<table class="table table-bordered">
	<tr>
	<th>Additional Sub:</th>
	<th>Term I</th>
	<th>Term II</th>
	</tr>';
				$totalMark = 0;
				$obtainMark_1 = 0;
				$obtainMark_2 = 0;
				$percentage_1 = 0;
				$percentage_2 = 0;
				$grade4 = '';
				$grade5 = '';

				foreach ($studentAdditionalMarkData as $key => $value) {
					$addsubjectData = $this->Model_Subject->fetchAdditionalSubjectByClassSection($value['class_id'], $value['subject_id']);
					$div .= '<tr>					
					<td>' . $addsubjectData['name'] . '</td>
					<td>' . $value['obtain_mark'] . '</td>
					<td>' . $value['obtain_mark_sa'] . '</td>
					
				</tr>';
				}
				foreach ($studentMarkData as $key => $value) {
					//$addsubjectData = $this->Model_Subject->fetchAdditionalSubjectByClassSection($value['class_id'], $value['subject_id']);
					$subjectData = $this->Model_Subject->fetchSubjectByClassSection($value['class_id'], $value['subject_id']);
					$total_term_1 = (float)$value['obtain_mark'] + (float)$value['obtain_mark_sa'] + (float)$value['subject_enrichmenth'] + (float)$value['h_yrly'];
					$total_term_2 = (float)$value['obtain_mark_pt_2'] + (float)$value['obtain_mark_sa_2'] + (float)$value['subject_enrichmentf'] + (float)$value['yrly'];


					$totalMark += $subjectData['total_mark'];
					$obtainMark_1 += $total_term_1;
					$obtainMark_2 += $total_term_2;

					$percentage_1 = ($obtainMark_1 / $totalMark) * 100;
					$percentage_2 = ($obtainMark_2 / $totalMark) * 100;
					if ($percentage_1 >= 91 && $percentage_1 <= 100) {
						$grade4 = 'A1';
					} elseif ($percentage_1 >= 81 && $percentage_1 <= 90) {
						$grade4 = 'A2';
					} elseif ($percentage_1 >= 71 && $percentage_1 <= 80) {
						$grade4 = 'B1';
					} elseif ($percentage_1 >= 61 && $percentage_1 <= 70) {
						$grade4 = 'B2';
					} elseif ($percentage_1 >= 51 && $percentage_1 <= 60) {
						$grade4 = 'C1';
					} elseif ($percentage_1 >= 41 && $percentage_1 <= 50) {
						$grade4 = 'C2';
					} elseif ($percentage_1 >= 33 && $percentage_1 <= 40) {
						$grade4 = 'D';
					} elseif ($percentage_1 < 32) {
						$grade4 = 'NI';
					}
					if ($percentage_2 >= 91 && $percentage_2 <= 100) {
						$grade5 = 'A1';
					} elseif ($percentage_2 >= 81 && $percentage_2 <= 90) {
						$grade5 = 'A2';
					} elseif ($percentage_2 >= 71 && $percentage_2 <= 80) {
						$grade5 = 'B1';
					} elseif ($percentage_2 >= 61 && $percentage_2 <= 70) {
						$grade5 = 'B2';
					} elseif ($percentage_2 >= 51 && $percentage_2 <= 60) {
						$grade5 = 'C1';
					} elseif ($percentage_2 >= 41 && $percentage_2 <= 50) {
						$grade5 = 'C2';
					} elseif ($percentage_2 >= 33 && $percentage_2 <= 40) {
						$grade5 = 'D';
					} elseif ($percentage_2 < 32) {
						$grade5 = 'NI';
					}
				}

				$div .= '
	</table>
	</div>
	<div class="column">
	<table class="table table-bordered">
	<tr>
	<th>Attendance:</th>
	<th>Term I</th>
	<th>Term II</th>
	</tr>
	<tr>
	<td>No. of Working Days</td>
	<td></td>
	<td></td>
	</tr>
	<tr>
	<td>No. of Days Present</td>
	<td></td>
	<td></td>
	</tr>
	<tr>
	<td>Percentage</td>
	<td>' . round($percentage_1, 2) . '%</td>
	<td>' . round($percentage_2, 2) . '%</td>
	</tr>
	<tr>
	<td>Grade</td>
	<td>' . $grade4 . '</td>
	<td>' . $grade5 . '</td>
	</tr>
	</table>
	</div>
	</div>
	<hr/>
	<h6>Class Teacher&#39;s Remark ........................................</h6>
	<h6>Promoted Detained to Class ........................................</h6>
	<h6 style="font-weight:bold;">Grading Scale for scholastic areas: grades are awarded on a 8-point grading scale as follows</h6>
	
	<table class="table table-bordered">
	<tr>
	<th>Marks Range</th>
	<th>91-100</th>
	<th>81-90</th>
	<th>71-80</th>
	<th>61-70</th>
	<th>51-60</th>
	<th>41-50</th>
	<th>33-39</th>
	<th>32 & below</th>
	</tr>
	<tr>
	<td>Grade</td>
	<td>A1</td>
	<td>A2</td>
	<td>B1</td>
	<td>B2</td>
	<td>C1</td>
	<td>C2</td>
	<td>D</td>
	<td>Needs Improvement</td>
	</tr>
	</table>
	<div class="row">
	<div class="column">
	<h5>Over All Marks</h5>
	<table class="table table-bordered">
	<tr>
	<th rowspan="2">Sub Name</th>
	<th colspan="2">Term-1 (50 Marks) + Term-2 (50 Marks)</th>
	</tr>
	<tr>
	<th>Grand Total</th>
	<th>Grade</th>
	</tr>';
				$totalMark = 0;
				$obtainMark_1 = 0;
				$obtainMark_2 = 0;
				$percentage_1 = 0;
				$percentage_2 = 0;
				$overAllMark = 0;
				$grade3 = '';
				$grade6 = '';
				$overAllPercentage = '';

				foreach ($studentMarkData as $key => $value) {
					$subjectData = $this->Model_Subject->fetchSubjectByClassSection($value['class_id'], $value['subject_id']);
					$total_term_1 = (float)$value['obtain_mark'] + (float)$value['obtain_mark_sa'] + (float)$value['subject_enrichmenth'] + (float)$value['h_yrly'];
					$total_term_2 = (float)$value['obtain_mark_pt_2'] + (float)$value['obtain_mark_sa_2'] + (float)$value['subject_enrichmentf'] + (float)$value['yrly'];
					$overAllMark = ($total_term_1 / 2) + ($total_term_2 / 2);
					if ($overAllMark >= 91 && $overAllMark <= 100) {
						$grade3 = 'A1';
					} elseif ($overAllMark >= 81 && $overAllMark <= 90) {
						$grade3 = 'A2';
					} elseif ($overAllMark >= 71 && $overAllMark <= 80) {
						$grade3 = 'B1';
					} elseif ($overAllMark >= 61 && $overAllMark <= 70) {
						$grade3 = 'B2';
					} elseif ($overAllMark >= 51 && $overAllMark <= 60) {
						$grade3 = 'C1';
					} elseif ($overAllMark >= 41 && $overAllMark <= 50) {
						$grade3 = 'C2';
					} elseif ($overAllMark >= 33 && $overAllMark <= 40) {
						$grade3 = 'D';
					} elseif ($overAllMark < 32) {
						$grade3 = 'NI';
					}
					$div .= '<tr>					
		<td>' . $subjectData['name'] . '</td>
		<td>' . $overAllMark . '</td>
		<td>' . $grade3 . '</td>
		
		
	</tr>';

					$totalMark += $subjectData['total_mark'];
					$obtainMark_1 += $overAllMark;
					//$obtainMark_2 += $total_term_2;

					$overAllPercentage = ($obtainMark_1 / $totalMark) * 100;
					if ($overAllPercentage >= 91 && $overAllPercentage <= 100) {
						$grade6 = 'A1';
					} elseif ($overAllPercentage >= 81 && $overAllPercentage <= 90) {
						$grade6 = 'A2';
					} elseif ($overAllPercentage >= 71 && $overAllPercentage <= 80) {
						$grade6 = 'B1';
					} elseif ($overAllPercentage >= 61 && $overAllPercentage <= 70) {
						$grade6 = 'B2';
					} elseif ($overAllPercentage >= 51 && $overAllPercentage <= 60) {
						$grade6 = 'C1';
					} elseif ($overAllPercentage >= 41 && $overAllPercentage <= 50) {
						$grade6 = 'C2';
					} elseif ($overAllPercentage >= 33 && $overAllPercentage <= 40) {
						$grade6 = 'D';
					} elseif ($overAllPercentage < 32) {
						$grade6 = 'NI';
					}
					//$percentage_2 = ($obtainMark_2 / $totalMark) * 100;

				}
				$div .= '
	</table>
	</div>
	<div class="column">
	<br/><br/>
	<table class="table table-bordered">
	<tr>
	<th colspan="2">Over All Performance</th>
	</tr>
	<tr>
	<td>Grade</td>
	<td>' . $grade6 . '</td>
	</tr>
	<tr>
	<td>Percentage</td>
	<td>' . round($overAllPercentage, 2) . '%</td>
	</tr>
	<tr>
	<td>Rank</td>
	<td></td>
	</tr>
	</table>
	</div>
	</div>
	<h5>Term I</h5>
    <h5>Date..............  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Signature of Class Teacher&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Signature of Principal</h5>
	<h5>Term II</h5>
	<h5>Date..............  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Signature of Class Teacher&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Signature of Principal</h5>
	
	
	';
			}

			echo $div;
		} // /if
	}
}
