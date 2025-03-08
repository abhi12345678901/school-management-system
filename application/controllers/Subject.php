<?php 	

class Subject extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();

		$this->isNotLoggedIn();

		// loading the section model
		$this->load->model('Model_Subject');
		// loading the classes model
		$this->load->model('Model_Classes');
		// loading the teacher model
		$this->load->model('Model_Teacher');

		// loading the form validation library
		$this->load->library('form_validation');		
	}

	/*
	*----------------------------------------------
	* fetches the class's section table 
	*----------------------------------------------
	*/
	public function fetchSubjectTable($classId = null)
	{
		if($classId) {
			$subjectData = $this->Model_Subject->fetchSubjectDataByClass($classId);
			$additionalSubjectData = $this->Model_Subject->fetchAdditionalSubjectDataByClass($classId);
			$classData = $this->Model_Classes->fetchClassData($classId);
			
			$table = '

			<div class="well">
				Class Name : '.$classData['class_name'].'
			</div>

			<div id="messages"></div>

			<div class="pull pull-right">
	  			<button class="btn btn-default" data-toggle="modal" data-target="#addSubjectModal" onclick="addSubject('.$classId.')">Add Subject</button>	
		  	</div>

			<div class="pull pull-right">
			  <button class="btn btn-default" data-toggle="modal" data-target="#addAdditionalSubjectModal" onclick="addadditionalSubject('.$classId.')">Add Additional Subject</button>	
		  </div>
		  		
		  	<br /> <br />

		  	<!-- Table Subject-->
		  	<table class="table table-bordered" id="manageSubjectTable">
			    <thead>	
			    	<tr>
			    		<th> Subject Name </th>			    		
			    		<th> Teacher Name  </th>
			    		<th> Action </th>
			    	</tr>
			    </thead>
			    <tbody>';
			    	if($subjectData) {
			    		foreach ($subjectData as $key => $value) {

			    			$teacherData = $this->Model_Teacher->fetchTeacherData($value['teacher_id']);

			    			$button = '<div class="btn-group">
							  <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							    Action <span class="caret"></span>
							  </button>
							  <ul class="dropdown-menu">
							    <li><a type="button" data-toggle="modal" data-target="#editSubjectModal" onclick="editSubject('.$value['subject_id'].','.$value['class_id'].')"> <i class="glyphicon glyphicon-edit"></i> Edit</a></li>
							    
							    <li><a type="button" data-toggle="modal" data-target="#removeSubjectModal" onclick="removeSubject('.$value['subject_id'].','.$value['class_id'].')"> <i class="glyphicon glyphicon-trash"></i> Remove</a></li>		    
							  </ul>
							</div>';

				    		$table .= '<tr>
				    			<td>'.$value['name'].'</td>				    			
				    			<td>'.$teacherData['fname'].' '.$teacherData['lname'].'</td>
				    			<td>'.$button.'</td>
				    		</tr>
				    		';
				    	} // /foreach				    	
			    	} 
			    	else {
			    		$table .= '<tr>
			    			<td colspan="3"><center>No Data Available</center></td>
			    		</tr>';
			    	} // /else
			    $table .= '</tbody>
			</table>
			
			<!-- Table Additional Subject-->
			<table class="table table-bordered" id="manageAdditionalSubjectTable">
			    <thead>	
			    	<tr>
			    		<th> Additional Subject Name </th>			    		
			    		<th> Teacher Name  </th>
			    		<th> Action </th>
			    	</tr>
			    </thead>
			    <tbody>';
			    	if($additionalSubjectData) {
			    		foreach ($additionalSubjectData as $key => $value) {

			    			$teacherData = $this->Model_Teacher->fetchTeacherData($value['teacher_id']);

			    			$button = '<div class="btn-group">
							  <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							    Action <span class="caret"></span>
							  </button>
							  <ul class="dropdown-menu">
							    <li><a type="button" data-toggle="modal" data-target="#editAdditionalSubjectModal" onclick="editAdditionalSubject('.$value['subject_id'].','.$value['class_id'].')"> <i class="glyphicon glyphicon-edit"></i> Edit</a></li>
							    
							    <li><a type="button" data-toggle="modal" data-target="#removeAdditionalSubjectModal" onclick="removeAdditionalSubject('.$value['subject_id'].','.$value['class_id'].')"> <i class="glyphicon glyphicon-trash"></i> Remove</a></li>		    
							  </ul>
							</div>';

				    		$table .= '<tr>
				    			<td>'.$value['name'].'</td>				    			
				    			<td>'.$teacherData['fname'].' '.$teacherData['lname'].'</td>
				    			<td>'.$button.'</td>
				    		</tr>
				    		';
				    	} // /foreach				    	
			    	} 
			    	else {
			    		$table .= '<tr>
			    			<td colspan="3"><center>No Data Available</center></td>
			    		</tr>';
			    	} // /else
			    $table .= '</tbody>
			</table>
			';
			echo $table;
		}
	}

	/*
	*----------------------------------------------
	* fetches the class's section information
	* through class_id and section_id 
	*----------------------------------------------
	*/
	public function fetchSubjectByClassSection($classId = null, $subjectId = null)
	{
		if($classId && $subjectId) {
			$subjectData = $this->Model_Subject->fetchSubjectByClassSection($classId, $subjectId);		
			
			echo json_encode($subjectData);
		} // /if
 	}

	 public function fetchAdditionalSubjectByClassSection($classId = null, $subjectId = null)
	{
		if($classId && $subjectId) {
			$subjectData = $this->Model_Subject->fetchAdditionalSubjectByClassSection($classId, $subjectId);		
			
			echo json_encode($subjectData);
		} // /if
 	}


	/*
	*----------------------------------------------
	* create the section  
	*----------------------------------------------
	*/
	public function create($classId = null) 
	{
		$validator = array('success' => false, 'messages' => array());

		$validate_data = array(
			array(
				'field' => 'subjectName',
				'label' => 'Subject Name',
				'rules' => 'required'
			),
			array(
				'field' => 'totalMark',
				'label' => 'Total Mark',
				'rules' => 'required|integer'
			),
			array(
				'field' => 'teacherName',
				'label' => 'Teacher Name',
				'rules' => 'required'
			)
		);

		$this->form_validation->set_rules($validate_data);
		$this->form_validation->set_error_delimiters('<p class="text-danger">','</p>');
		$this->form_validation->set_message('integer', 'The {field} should be number');

		if($this->form_validation->run() === true) {							
			$create = $this->Model_Subject->create($classId);					
			if($create == true) {
				$validator['success'] = true;
				$validator['messages'] = "Successfully added";
			}
			else {
				$validator['success'] = false;
				$validator['messages'] = "Error while inserting the information into the database";
			}			
		} 	
		else {
			$validator['success'] = false;
			foreach ($_POST as $key => $value) {
				$validator['messages'][$key] = form_error($key);
			}			
		} // /else

		echo json_encode($validator);
	}

	/*
	*----------------------------------------------
	* create the section  
	*----------------------------------------------
	*/
	public function createAdditionalSubject($classId = null) 
	{
		$validator = array('success' => false, 'messages' => array());

		$validate_data = array(
			array(
				'field' => 'aditionalSubjectName',
				'label' => 'Subject Name',
				'rules' => 'required'
			),
			array(
				'field' => 'aditionalSubjectTotalMark',
				'label' => 'Total Mark',
				'rules' => 'required|integer'
			),
			array(
				'field' => 'aditionalSubjectTeacherName',
				'label' => 'Teacher Name',
				'rules' => 'required'
			)
		);
		

		$this->form_validation->set_rules($validate_data);
		$this->form_validation->set_error_delimiters('<p class="text-danger">','</p>');
		$this->form_validation->set_message('integer', 'The {field} should be number');

		if($this->form_validation->run() === true) {
									
			$create = $this->Model_Subject->createAdditionalSubject($classId);
							
			if($create == true) {
				$validator['success'] = true;
				$validator['messages'] = "Successfully added";
			}
			else {
				$validator['success'] = false;
				$validator['messages'] = "Error while inserting the information into the database";
			}			
		} 	
		else {
			$validator['success'] = false;
			foreach ($_POST as $key => $value) {
				$validator['messages'][$key] = form_error($key);
			}			
		} // /else

		echo json_encode($validator);
	}

	/*
	*----------------------------------------------
	* update the section  
	*----------------------------------------------
	*/
	public function update($classId = null, $subjectId = null)
	{
		if($classId && $subjectId) {
			$validator = array('success' => false, 'messages' => array());

			$validate_data = array(
				array(
					'field' => 'editSubjectName',
					'label' => 'Subject Name',
					'rules' => 'required'
				),
				array(
					'field' => 'editTotalMark',
					'label' => 'Total Mark',
					'rules' => 'required|integer'
				),
				array(
					'field' => 'editTeacherName',
					'label' => 'Teacher Name',
					'rules' => 'required'
				)
			);

			$this->form_validation->set_rules($validate_data);
			$this->form_validation->set_error_delimiters('<p class="text-danger">','</p>');
			$this->form_validation->set_message('integer', 'The {field} should be number');

			if($this->form_validation->run() === true) {							
				$update = $this->Model_Subject->update($classId, $subjectId);					
				if($update == true) {
					$validator['success'] = true;
					$validator['messages'] = "Successfully added";
				}
				else {
					$validator['success'] = false;
					$validator['messages'] = "Error while inserting the information into the database";
				}			
			} 	
			else {
				$validator['success'] = false;
				foreach ($_POST as $key => $value) {
					$validator['messages'][$key] = form_error($key);
				}			
			} // /else

			echo json_encode($validator);
		}
	}

	/*
	*----------------------------------------------
	* update the section  
	*----------------------------------------------
	*/
	public function updateAdditionalSubject($classId = null, $subjectId = null)
	{
		if($classId && $subjectId) {
			$validator = array('success' => false, 'messages' => array());

			$validate_data = array(
				array(
					'field' => 'editAdditionalSubjectName',
					'label' => 'Additional Subject Name',
					'rules' => 'required'
				),
				array(
					'field' => 'editAdditionalTotalMark',
					'label' => 'Total Mark',
					'rules' => 'required|integer'
				),
				array(
					'field' => 'editAdditionalTeacherName',
					'label' => 'Teacher Name',
					'rules' => 'required'
				)
			);

			$this->form_validation->set_rules($validate_data);
			$this->form_validation->set_error_delimiters('<p class="text-danger">','</p>');
			$this->form_validation->set_message('integer', 'The {field} should be number');

			if($this->form_validation->run() === true) {							
				$update = $this->Model_Subject->updateAdditionalSubject($classId, $subjectId);					
				if($update == true) {
					$validator['success'] = true;
					$validator['messages'] = "Successfully added";
				}
				else {
					$validator['success'] = false;
					$validator['messages'] = "Error while inserting the information into the database";
				}			
			} 	
			else {
				$validator['success'] = false;
				foreach ($_POST as $key => $value) {
					$validator['messages'][$key] = form_error($key);
				}			
			} // /else

			echo json_encode($validator);
		}
	}


	/*
	*----------------------------------------------
	* update the manage table function
	*----------------------------------------------
	*/
	public function fetchUpdateSubjectTable($classId = null)
	{
		if($classId) {
			$subjectData = $this->Model_Subject->fetchSubjectDataByClass($classId);
			$table = '<thead>	
			    	<tr>
			    		<th> Subject Name </th>
			    		<th> Teacher Name  </th>
			    		<th> Action </th>
			    	</tr>
			    </thead>
			    <tbody>';
			    	if($subjectData) {
			    		foreach ($subjectData as $key => $value) {

			    			$teacherData = $this->Model_Teacher->fetchTeacherData($value['teacher_id']);

			    			$button = '<div class="btn-group">
							  <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							    Action <span class="caret"></span>
							  </button>
							  <ul class="dropdown-menu">
							    <li><a type="button" data-toggle="modal" data-target="#editSubjectModal" onclick="editSubject('.$value['subject_id'].','.$value['class_id'].')"> <i class="glyphicon glyphicon-edit"></i> Edit</a></li>
							    <li><a type="button" data-toggle="modal" data-target="#removeSubjectModal" onclick="removeSubject('.$value['subject_id'].','.$value['class_id'].')"> <i class="glyphicon glyphicon-trash"></i> Remove</a></li>		    
							  </ul>
							</div>';

				    		$table .= '<tr>
				    			<td>'.$value['name'].'</td>
				    			<td>'.$teacherData['fname'].' '.$teacherData['lname'].'</td>
				    			<td>'.$button.'</td>
				    		</tr>
				    		';
				    	} // /foreach				    	
			    	} 
			    	else {
			    		$table .= '<tr>
			    			<td colspan="3"><center>No Data Available</center></td>
			    		</tr>';
			    	} // /else
			    $table .= '</tbody>';
			    echo $table;					
		} // /if
	}

	/*
	*----------------------------------------------
	* update the manage additional table function
	*----------------------------------------------
	*/
	public function fetchUpdateAdditionalSubjectTable($classId = null)
	{
		if($classId) {
			$additionalSubjectData = $this->Model_Subject->fetchAdditionalSubjectDataByClass($classId);
			$table = '<thead>	
			    	<tr>
			    		<th> Additional Subject Name </th>
			    		<th> Teacher Name  </th>
			    		<th> Action </th>
			    	</tr>
			    </thead>
			    <tbody>';
			    	if($additionalSubjectData) {
			    		foreach ($additionalSubjectData as $key => $value) {

			    			$teacherData = $this->Model_Teacher->fetchTeacherData($value['teacher_id']);

			    			$button = '<div class="btn-group">
							  <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							    Action <span class="caret"></span>
							  </button>
							  <ul class="dropdown-menu">
							    <li><a type="button" data-toggle="modal" data-target="#editAdditionalSubjectModal" onclick="editAdditionalSubject('.$value['subject_id'].','.$value['class_id'].')"> <i class="glyphicon glyphicon-edit"></i> Edit</a></li>
							    <li><a type="button" data-toggle="modal" data-target="#removeAdditionalSubjectModal" onclick="removeAdditionalSubject('.$value['subject_id'].','.$value['class_id'].')"> <i class="glyphicon glyphicon-trash"></i> Remove</a></li>		    
							  </ul>
							</div>';

				    		$table .= '<tr>
				    			<td>'.$value['name'].'</td>
				    			<td>'.$teacherData['fname'].' '.$teacherData['lname'].'</td>
				    			<td>'.$button.'</td>
				    		</tr>
				    		';
				    	} // /foreach				    	
			    	} 
			    	else {
			    		$table .= '<tr>
			    			<td colspan="3"><center>No Data Available</center></td>
			    		</tr>';
			    	} // /else
			    $table .= '</tbody>';
			    echo $table;					
		} // /if
	}

	/*
	*----------------------------------------------
	* remove class's section function
	*----------------------------------------------
	*/	
	public function remove($subjectId = null)
	{
		if($subjectId) {
			$remove = $this->Model_Subject->remove($subjectId);
			if($remove === true) {
				$validator['success'] = true;
				$validator['messages'] = "Successfully Removed";
			} 
			else{
				$validator['success'] = false;
				$validator['messages'] = "Error while removing the information";
			}
			echo json_encode($validator);
		}
	}

	/*
	*----------------------------------------------
	* remove class's section function
	*----------------------------------------------
	*/	
	public function removeAdditionalSubject($subjectId = null)
	{
		if($subjectId) {
			$remove = $this->Model_Subject->removeAdditionalSubject($subjectId);
			if($remove === true) {
				$validator['success'] = true;
				$validator['messages'] = "Successfully Removed";
			} 
			else{
				$validator['success'] = false;
				$validator['messages'] = "Error while removing the information";
			}
			echo json_encode($validator);
		}
	}

}