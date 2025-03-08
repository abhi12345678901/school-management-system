<?php 

class Marksheetsubject extends MY_Controller 
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
		if($classId) {			
			$classData = $this->Model_Classes->fetchClassData($classId);
			$marksheetData = $this->Model_Marksheet->fetchMarksheetData($classId);
			
			$table = '

			<div class="well">
				Class Name : '.$classData['class_name'].'
			</div>

			<div id="messages"></div>

			<div class="pull pull-right">
	  			<button class="btn btn-default" data-toggle="modal" data-target="#addMarksheetModal" onclick="addMarksheet('.$classId.')">Add Marksheet</button>	
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
			    	if($marksheetData) {
			    		foreach ($marksheetData as $key => $value) {			    			

			    			$button = '<div class="btn-group">
							  <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							    Action <span class="caret"></span>
							  </button>
							  <ul class="dropdown-menu">
							    <li><a type="button" data-toggle="modal" data-target="#editMarksheetModal" onclick="editMarksheet('.$value['marksheet_id'].','.$value['class_id'].')"> <i class="glyphicon glyphicon-edit"></i> Edit</a></li>
							    <li><a type="button" data-toggle="modal" data-target="#removeMarksheetModal" onclick="removeMarksheet('.$value['marksheet_id'].','.$value['class_id'].')"> <i class="glyphicon glyphicon-trash"></i> Remove</a></li>		    
							  </ul>
							</div>';

				    		$table .= '<tr>
				    			<td>'.$value['marksheet_name'].'</td>
				    			<td>'.$value['marksheet_date'].'</td>
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
		if($classId) {
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
			$this->form_validation->set_error_delimiters('<p class="text-danger">','</p>');

			if($this->form_validation->run() === true) {	
				$create = $this->Model_Marksheet->create($classId);					
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
		if($classId) {
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
			if($marksheetData) {
	    		foreach ($marksheetData as $key => $value) {			    			

	    			$button = '<div class="btn-group">
					  <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					    Action <span class="caret"></span>
					  </button>
					  <ul class="dropdown-menu">
					    <li><a type="button" data-toggle="modal" data-target="#editMarksheetModal" onclick="editMarksheet('.$value['marksheet_id'].','.$value['class_id'].')"> <i class="glyphicon glyphicon-edit"></i> Edit</a></li>
					    <li><a type="button" data-toggle="modal" data-target="#removeMarksheetModal" onclick="removeMarksheet('.$value['marksheet_id'].','.$value['class_id'].')"> <i class="glyphicon glyphicon-trash"></i> Remove</a></li>		    
					  </ul>
					</div>';

		    		$table .= '<tr>
		    			<td>'.$value['marksheet_name'].'</td>
		    			<td>'.$value['marksheet_date'].'</td>
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
		} // /.classid
	}

	/*
	*----------------------------------------------
	* update marksheet funciton
	*----------------------------------------------
	*/
	public function update($marksheetId = null, $classId = null)
	{
		if($marksheetId && $classId) {
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
			$this->form_validation->set_error_delimiters('<p class="text-danger">','</p>');

			if($this->form_validation->run() === true) {	
				$update = $this->Model_Marksheet->update($marksheetId, $classId);					
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
		if($marksheetId) {
			$remove = $this->Model_Marksheet->remove($marksheetId);
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

	public function fetchClassNumericName($classId = null)
	{
		if($classId) {
			$marksheetData = $this->Model_Marksheet->fetchClassNumericName($classId);
			if($marksheetData) {
				foreach ($marksheetData as $key => $value) {
					$option .= '<option value="'.$value['numeric_name'].'">'.$value['numeric_name'].'</option>';
				} // /foreach
			}
			else {
				$option = '<option value="">No Data</option>';
			} // /else empty section
			echo $option;
		}
	}

	public function fetchLowerSubjectSubCategory($classId = null)
	{
		if($classId) {
					
		$option .= '<option value="PT_1">PT(1)</option>
		            <option value="SA_1">SA(1)</option>
		            <option value="PT_2">PT(2)</option>
		            <option value="SA_2">SA(2)</option>';
				 // /foreach
			
			// /else empty section
			echo $option;
		}
	}

	public function fetchHigherSubjectSubCategory($classId = null)
	{
		if($classId) {
					
		$option .= '<option value="PT_1">PT(Term-1)</option>
		<option value="SA_1">Note Book(Term-1)</option>
		<option value="SE_1">Subject Enrichment(Term-1)</option>
		<option value="HY">Half Yearly(Term-1)</option>
		<option value="PT_2">PT(Term-2)</option>
		<option value="SA_2">Note Book(Term-2)</option>
		<option value="SE_2">Subject Enrichment(Term-2)</option>
		<option value="Yearly">Yearly(Term-2)</option>';
				 // /foreach
			
			// /else empty section
			echo $option;
		}
	}
	public function fetchHigherAdditionalSubjectSubCategory($classId = null)
	{
		if($classId) {
					
		$option .= '<option value="PT_1">Term I </option>
		            <option value="SA_1">Term II</option>';
				 // /foreach
			
			// /else empty section
			echo $option;
		}
	}


	public function fetchSubjectType()
	{
		
					
		$option .= '<option value="">Select</option>
		<option value="regularSub">Regular Subject</option>
		<option value="additionalSub">Additional Subject</option>';
				 // /foreach
			
			// /else empty section
			echo $option;
		
	}

	public function fetchMarksheetSubject()
	{
		
					
		$option .= '<option value="">Select</option>';
				 // /foreach
			
			// /else empty section
			echo $option;
		
	}

	/*
	*----------------------------------------------
	* fetch marksheet info by class id function
	*----------------------------------------------
	*/
	public function fetchMarksheetDataByClass($classId = null)
	{
		if($classId) {
			$marksheetData = $this->Model_Marksheet->fetchMarksheetDataByClass($classId);
			if($marksheetData) {
				foreach ($marksheetData as $key => $value) {
					$option .= '<option value="'.$value['marksheet_id'].'">'.$value['marksheet_name'].'</option>';
				} // /foreach
			}
			else {
				$option = '<option value="">No Data</option>';
			} // /else empty section
			echo $option;
		}
	}

	public function fetchSubjectDataByClass($classId = null)
	{
		if($classId) {
			$subjectData = $this->Model_Marksheet->fetchSubjectDataByClass($classId);
			if($subjectData) {
				foreach ($subjectData as $key => $value) {
					$option .= '<option value="'.$value['subject_id'].'">'.$value['name'].'</option>';
				} // /foreach
			}
			else {
				$option = '<option value="">No Data</option>';
			} 

			echo $option;
		}
	}
	public function fetchAdditionalSubjectDataByClass($classId = null)
	{
		if($classId) {
			$subjectData = $this->Model_Marksheet->fetchAdditionalSubjectDataByClass($classId);
			if($subjectData) {
				foreach ($subjectData as $key => $value) {
					$option .= '<option value="'.$value['subject_id'].'">'.$value['name'].'</option>';
				} // /foreach
			}
			else {
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
			),
			array(
				'field' => 'subjectType',
				'label' => 'Subject Type',
				'rules' => 'required'
			),
			array(
				'field' => 'marksheetSubject',
				'label' => 'Marksheet Subject',
				'rules' => 'required'
			),
			array(
				'field' => 'marksheetSubjectCategory',
				'label' => 'Subject (SubField)',
				'rules' => 'required'
			)
		);

		$this->form_validation->set_rules($validate_data);
		$this->form_validation->set_error_delimiters('<p class="text-danger">','</p>');

		if($this->form_validation->run() === true) {	
					
			$validator['success'] = true;
			$validator['messages'] = "Successfully added";

			$subjectSubField = $this->input->post('marksheetSubjectCategory');
			$classData = $this->Model_Classes->fetchClassData($this->input->post('className'));
			$marksheetNameData = $this->Model_Marksheet->fetchMarksheetDataByMarksheetId($this->input->post('marksheetName'));
			if ($this->input->post('subjectType') == 'regularSub') {
				$marksheetSubjectData = $this->Model_Marksheet->fetchSubjectDataBySubjectId($this->input->post('marksheetSubject'));
			} elseif ($this->input->post('subjectType') == 'additionalSub') {
				$marksheetSubjectData = $this->Model_Marksheet->fetchAdditionalSubjectDataBySubjectId($this->input->post('marksheetSubject'));
			}
			$sectionData = $this->Model_Section->fetchSectionDataByClass($this->input->post('className'));
			$validator['sectionData'] = $sectionData;
             if ($classData['numeric_name'] > 1) {
				if ($subjectSubField == 'SA_1') {
					$subjectSubField = 'NB_1';
				}
				if ($subjectSubField == 'SA_2') {
					$subjectSubField = 'NB_2';
				}
			}
			$validator['html'] = '<div class="panel panel-default">		  	
				<div class="panel-heading">Student Info</div>
				  
				<div class="panel-body">		  
					<div class="well well-sm">
						Class : '.$classData['class_name'].' <br />
						Marksheet Name : '.$marksheetNameData['marksheet_name'].' <br />
						Marksheet Name : '.$marksheetSubjectData['name'].' <br />
						<input type="hidden" id="subject_id" value="'.$this->input->post('marksheetSubject').'" />
						<input type="hidden" id="marksheet_id" value="'.$this->input->post('marksheetName').'" />
					</div>		

					<br /> 	
					<div>
						<!-- Nav tabs -->
					  	<ul class="nav nav-tabs" role="tablist">
					    	<li role="presentation" class="active"><a href="#classStudent" aria-controls="classStudent" role="tab" data-toggle="tab">All Student</a></li>';					   
					    	$x = 1;
			            	foreach ($sectionData as $key => $value) {            	
								$validator['html'] .= '<li role="presentation"><a href="#countSection'.$x.'" aria-controls="countSection" role="tab" data-toggle="tab"> Section ('.$value['section_name'].')</a></li>';
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
									  <th>'.$subjectSubField.'</th>                 
				                      <th>Action</th>
				                    </tr>
				                  </thead>
				                </table>  

				              </div>
					    	<!--/.all student-->
					    	'; 
			              	$x = 1;
							foreach ($sectionData as $key => $value) {
								$validator['html'] .= '<div role="tabpanel" class="tab-pane" id="countSection'.$x.'">									

									<br /> <br />

									<table class="table table-bordered classSectionStudentTable" id="manageStudentTable'.$x.'" style="width:100%;">
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

		} 	
		else {
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


public function fetchStudentByClassSubject($classId = null, $sbmarksheetId = null, $subType = null, $marksheetsubjectId = null, $marksheetsubjectSubId = null) {
		if($classId && $subType && $marksheetsubjectId && $marksheetsubjectSubId) {
			$result = array('data' => array());
			$studentData = $this->Model_Student->fetchStudentDataByClass($classId);
			$j = 0;
			foreach ($studentData as $key => $value) {
			    if($studentData){
			        $img = '<img src="'. base_url() . $value['image'].'" class="img-circle candidate-photo" alt="Student Image" />';
			        $studentName = $value['student_name'];
			    }elseif(!$studentData){
			        $img = '';
			        $studentName = '';
			    }
				

				$classData = $this->Model_Classes->fetchClassData($value['class_id']);
				$sectionData = $this->Model_Section->fetchSectionByClassSection($value['class_id'], $value['section_id']);
				if($subType == 'regularSub'){
					$subjectData = $this->Model_Marksheet->fetchSubjectDataBySubjectId($marksheetsubjectId);
					$studentMarksheetData = $this->Model_Marksheet->fetchStudentMarksByClassSectionStudentSubject($value['class_id'], $value['section_id'], $value['student_id'], $subjectData['subject_id'], $sbmarksheetId);			
					
					if($studentMarksheetData){
					    $marksheetId = $studentMarksheetData['marksheet_id'];
					    $obtain_mark = $studentMarksheetData['obtain_mark'];
					    $obtainmarksa = $studentMarksheetData['obtain_mark_sa'];
					    $ubjectenrichment = $studentMarksheetData['subject_enrichmenth'];
					    $halefyearly = $studentMarksheetData['h_yrly'];
					    $obtainmarkpt2 = $studentMarksheetData['obtain_mark_pt_2'];
					    $obtainmarksa2 = $studentMarksheetData['obtain_mark_sa_2'];
					    $subjectenrichmentf = $studentMarksheetData['subject_enrichmentf'];
					    $yearly = $studentMarksheetData['yrly'];
					}elseif(!$studentMarksheetData){
					    $marksheetId = '';	
					    $obtain_mark = '';
					    $obtainmarksa = '';
					    $ubjectenrichment= '';
					    $halefyearly = '';
					    $obtainmarkpt2 = '';
					    $obtainmarksa2 = '';
					    $subjectenrichmentf = '';
					    $yearly = '';
					}
					
	
					$button = '<div class="btn-group">
					  <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						Action <span class="caret"></span>
					  </button>
					  <ul class="dropdown-menu">			  	
						<!--<li><a href="#" data-toggle="modal" data-target="#editMarksModal" onclick="editMarks('.$value['student_id'].','.$classId.')">Edit Marks</a></li>-->
						<li><a href="#" data-toggle="modal" data-target="#viewMarksModal" onclick="viewMarks('.$value['student_id'].','.$classId.')">View</a></li>			    
					  </ul>
					</div>';
	                $PT1 = 'PT1';
					$SA1 = 'SA1';
					$SE1 = 'SE1';
					$HY = 'HY';
					
					$PT2 = 'PT2';
					$SA2 = 'SA2';
					$SE2 = 'SE2';
					$Yearly = 'YY';

					$tblName = 'marksheetstudent';
					$j++;
					$customMarksInputPT1 = "<input type='text' id='inputCustomMarks' class='customMarksStudent' name='data_". $value['student_id'] . '_' . $marksheetsubjectId . '_' . $marksheetId .'_'.$PT1.'_'.$tblName."' value='".$obtain_mark."' onkeypress='moveToNextInput()' tabIndex='".$j."'/>"; 
					$customMarksInputSA1 = "<input type='text' id='inputCustomMarks' class='customMarksStudent' name='data_". $value['student_id'] . '_' . $marksheetsubjectId . '_' . $marksheetId .'_'.$SA1.'_'.$tblName."' value='".$obtainmarksa."' onkeypress='moveToNextInput()' tabIndex='".$j."'/>";
					$customMarksInputSE1 = "<input type='text' id='inputCustomMarks' class='customMarksStudent' name='data_". $value['student_id'] . '_' . $marksheetsubjectId . '_' . $marksheetId .'_'.$SE1.'_'.$tblName."' value='".$ubjectenrichment."' onkeypress='moveToNextInput()' tabIndex='".$j."'/>"; 
					$customMarksInputHY = "<input type='text' id='inputCustomMarks' class='customMarksStudent' name='data_". $value['student_id'] . '_' . $marksheetsubjectId . '_' . $marksheetId .'_'.$HY.'_'.$tblName."' value='".$halefyearly."' onkeypress='moveToNextInput()' tabIndex='".$j."'/>";
					
					$customMarksInputPT2 = "<input type='text' id='inputCustomMarks' class='customMarksStudent' name='data_". $value['student_id'] . '_' . $marksheetsubjectId . '_' . $marksheetId .'_'.$PT2.'_'.$tblName."' value='".$obtainmarkpt2."' onkeypress='moveToNextInput()' tabIndex='".$j."'/>"; 
					$customMarksInputSA2 = "<input type='text' id='inputCustomMarks' class='customMarksStudent' name='data_". $value['student_id'] . '_' . $marksheetsubjectId . '_' . $marksheetId .'_'.$SA2.'_'.$tblName."' value='".$obtainmarksa2."' onkeypress='moveToNextInput()' tabIndex='".$j."'/>";  
					$customMarksInputSE2 = "<input type='text' id='inputCustomMarks' class='customMarksStudent' name='data_". $value['student_id'] . '_' . $marksheetsubjectId . '_' . $marksheetId .'_'.$SE2.'_'.$tblName."' value='".$subjectenrichmentf."' onkeypress='moveToNextInput()' tabIndex='".$j."'/>"; 
					$customMarksInputYearly = "<input type='text' id='inputCustomMarks' class='customMarksStudent' name='data_". $value['student_id'] . '_' . $marksheetsubjectId . '_' . $marksheetId .'_'.$Yearly.'_'.$tblName."' value='".$yearly."' onkeypress='moveToNextInput()' tabIndex='".$j."'/>";  
					
					if($marksheetsubjectSubId == 'PT_1'){
					$result['data'][$key] = array(
									$img,
									$studentName,
									$classData['class_name'],
									$sectionData['section_name'],
									// $studentMarksheetData['obtain_mark'],
									$customMarksInputPT1,
									$button
					);
				  }
				
				  
				  elseif($marksheetsubjectSubId == 'SA_1'){
					$result['data'][$key] = array(
						$img,
						$studentName,
						$classData['class_name'],
						$sectionData['section_name'],
						// $studentMarksheetData['obtain_mark_sa'],
						$customMarksInputSA1,
						$button
					);
				  }

				  elseif($marksheetsubjectSubId == 'SE_1'){
					$result['data'][$key] = array(
						$img,
						$studentName,
						$classData['class_name'],
						$sectionData['section_name'],
						// $studentMarksheetData['obtain_mark_sa'],
						$customMarksInputSE1,
						$button
					);
				  }

				  elseif($marksheetsubjectSubId == 'HY'){
					$result['data'][$key] = array(
						$img,
						$studentName,
						$classData['class_name'],
						$sectionData['section_name'],
						// $studentMarksheetData['obtain_mark_sa'],
						$customMarksInputHY,
						$button
					);
				  }

				  elseif($marksheetsubjectSubId == 'PT_2'){
					$result['data'][$key] = array(
						$img,
						$studentName,
						$classData['class_name'],
						$sectionData['section_name'],
						// $studentMarksheetData['obtain_mark_pt_2'],
						$customMarksInputPT2,
						$button
					);
				  }
				  elseif($marksheetsubjectSubId == 'SA_2'){
					$result['data'][$key] = array(
						$img,
						$studentName,
						$classData['class_name'],
						$sectionData['section_name'],
						// $studentMarksheetData['obtain_mark_sa_2'],
						$customMarksInputSA2,
						$button
					);
				  }

				  elseif($marksheetsubjectSubId == 'SE_2'){
					$result['data'][$key] = array(
						$img,
						$studentName,
						$classData['class_name'],
						$sectionData['section_name'],
						// $studentMarksheetData['obtain_mark_sa_2'],
						$customMarksInputSE2,
						$button
					);
				  }

				  elseif($marksheetsubjectSubId == 'Yearly'){
					$result['data'][$key] = array(
						$img,
						$studentName,
						$classData['class_name'],
						$sectionData['section_name'],
						// $studentMarksheetData['obtain_mark_sa_2'],
						$customMarksInputYearly,
						$button
					);
				  }
				}
				if($subType == 'additionalSub'){
					$subjectData = $this->Model_Marksheet->fetchAdditionalSubjectDataBySubjectId($marksheetsubjectId);
					 $studentMarksheetData = $this->Model_Marksheet->fetchStudentAdditionalSubMarksByClassSectionStudentSubject($value['class_id'], $value['section_id'], $value['student_id'], $subjectData['subject_id'], $sbmarksheetId);
					 if($studentMarksheetData){
					     $marksheetId = $studentMarksheetData['marksheet_id'];
					     $obtainmark = $studentMarksheetData['obtain_mark'];
					     $obtainmarksa = $studentMarksheetData['obtain_mark_sa'];
					     $subjectenrichmenth = $studentMarksheetData['subject_enrichmenth'];
					     $hyrly = $studentMarksheetData['h_yrly'];
					     $obtainmarkpt2 = $studentMarksheetData['obtain_mark_pt_2'];
					     $obtainmarksa2 = $studentMarksheetData['obtain_mark_sa_2'];
					     $subjectenrichmentf = $studentMarksheetData['subject_enrichmentf'];
					     $yrly = $studentMarksheetData['yrly'];
					 }elseif(!$studentMarksheetData){
					     $marksheetId = '';	
					     $obtainmark = '';
					     $obtainmarksa = '';
					     $subjectenrichmenth = '';
					     $hyrly = '';
					     $obtainmarkpt2 = '';
					     $obtainmarksa2 = '';
					     $subjectenrichmentf = '';
					     $yrly = '';
					 }
	
					$button = '<div class="btn-group">
					  <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						Action <span class="caret"></span>
					  </button>
					  <ul class="dropdown-menu">			  	
						<!--<li><a href="#" data-toggle="modal" data-target="#editMarksModal" onclick="editMarks('.$value['student_id'].','.$classId.')">Edit Marks</a></li>-->
						<li><a href="#" data-toggle="modal" data-target="#viewMarksModal" onclick="viewMarks('.$value['student_id'].','.$classId.')">View</a></li>			    
					  </ul>
					</div>';
	                $PT1 = 'PT1';
					$SA1 = 'SA1';
					$SE1 = 'SE1';
					$HY = 'HY';
					
					$PT2 = 'PT2';
					$SA2 = 'SA2';
					$SE2 = 'SE2';
					$Yearly = 'YY';

					$tblName = 'marksheetaddsubject';
					$j++;
					$customMarksInputPT1 = "<input type='text' id='inputCustomMarks' class='customMarksStudent' name='data_". $value['student_id'] . '_' . $marksheetsubjectId . '_' . $marksheetId .'_'.$PT1.'_'.$tblName."' value='".$obtainmark."' onkeypress='moveToNextInput()' tabIndex='".$j."'/>"; 
					$customMarksInputSA1 = "<input type='text' id='inputCustomMarks' class='customMarksStudent' name='data_". $value['student_id'] . '_' . $marksheetsubjectId . '_' . $marksheetId .'_'.$SA1.'_'.$tblName."' value='".$obtainmarksa."' onkeypress='moveToNextInput()' tabIndex='".$j."'/>";
					$customMarksInputSE1 = "<input type='text' id='inputCustomMarks' class='customMarksStudent' name='data_". $value['student_id'] . '_' . $marksheetsubjectId . '_' . $marksheetId .'_'.$SE1.'_'.$tblName."' value='".$subjectenrichmenth."' onkeypress='moveToNextInput()' tabIndex='".$j."'/>"; 
					$customMarksInputHY = "<input type='text' id='inputCustomMarks' class='customMarksStudent' name='data_". $value['student_id'] . '_' . $marksheetsubjectId . '_' . $marksheetId .'_'.$HY.'_'.$tblName."' value='".$hyrly."' onkeypress='moveToNextInput()' tabIndex='".$j."'/>";
					
					$customMarksInputPT2 = "<input type='text' id='inputCustomMarks' class='customMarksStudent' name='data_". $value['student_id'] . '_' . $marksheetsubjectId . '_' . $marksheetId .'_'.$PT2.'_'.$tblName."' value='".$obtainmarkpt2."' onkeypress='moveToNextInput()' tabIndex='".$j."'/>"; 
					$customMarksInputSA2 = "<input type='text' id='inputCustomMarks' class='customMarksStudent' name='data_". $value['student_id'] . '_' . $marksheetsubjectId . '_' . $marksheetId .'_'.$SA2.'_'.$tblName."' value='".$obtainmarksa2."' onkeypress='moveToNextInput()' tabIndex='".$j."'/>";  
					$customMarksInputSE2 = "<input type='text' id='inputCustomMarks' class='customMarksStudent' name='data_". $value['student_id'] . '_' . $marksheetsubjectId . '_' . $marksheetId .'_'.$SE2.'_'.$tblName."' value='".$subjectenrichmentf."' onkeypress='moveToNextInput()' tabIndex='".$j."'/>"; 
					$customMarksInputYearly = "<input type='text' id='inputCustomMarks' class='customMarksStudent' name='data_". $value['student_id'] . '_' . $marksheetsubjectId . '_' . $marksheetId .'_'.$Yearly.'_'.$tblName."' value='".$yrly."' onkeypress='moveToNextInput()' tabIndex='".$j."'/>";  
					
					if($marksheetsubjectSubId == 'PT_1'){
					$result['data'][$key] = array(
									$img,
									$studentName,
									$classData['class_name'],
									$sectionData['section_name'],
									// $studentMarksheetData['obtain_mark'],
									$customMarksInputPT1,
									$button
					);
				  }
				
				  
				  elseif($marksheetsubjectSubId == 'SA_1'){
					$result['data'][$key] = array(
						$img,
						$studentName,
						$classData['class_name'],
						$sectionData['section_name'],
						// $studentMarksheetData['obtain_mark_sa'],
						$customMarksInputSA1,
						$button
					);
				  }

				  elseif($marksheetsubjectSubId == 'SE_1'){
					$result['data'][$key] = array(
						$img,
						$studentName,
						$classData['class_name'],
						$sectionData['section_name'],
						// $studentMarksheetData['obtain_mark_sa'],
						$customMarksInputSE1,
						$button
					);
				  }

				  elseif($marksheetsubjectSubId == 'HY'){
					$result['data'][$key] = array(
						$img,
						$studentName,
						$classData['class_name'],
						$sectionData['section_name'],
						// $studentMarksheetData['obtain_mark_sa'],
						$customMarksInputHY,
						$button
					);
				  }

				  elseif($marksheetsubjectSubId == 'PT_2'){
					$result['data'][$key] = array(
						$img,
						$studentName,
						$classData['class_name'],
						$sectionData['section_name'],
						// $studentMarksheetData['obtain_mark_pt_2'],
						$customMarksInputPT2,
						$button
					);
				  }
				  elseif($marksheetsubjectSubId == 'SA_2'){
					$result['data'][$key] = array(
						$img,
						$studentName,
						$classData['class_name'],
						$sectionData['section_name'],
						// $studentMarksheetData['obtain_mark_sa_2'],
						$customMarksInputSA2,
						$button
					);
				  }

				  elseif($marksheetsubjectSubId == 'SE_2'){
					$result['data'][$key] = array(
						$img,
						$studentName,
						$classData['class_name'],
						$sectionData['section_name'],
						// $studentMarksheetData['obtain_mark_sa_2'],
						$customMarksInputSE2,
						$button
					);
				  }

				  elseif($marksheetsubjectSubId == 'Yearly'){
					$result['data'][$key] = array(
						$img,
						$studentName,
						$classData['class_name'],
						$sectionData['section_name'],
						// $studentMarksheetData['obtain_mark_sa_2'],
						$customMarksInputYearly,
						$button
					);
				  }
				}
			} // /foreach	
			echo json_encode($result);
		}
	}
    // to fetch student marks by class
	public function fetchStudentMarksByClass($classId = null) {
		if($classId) {
			$result = array('data' => array());
			$studentData = $this->Model_Student->fetchStudentDataByClass($classId);
			foreach ($studentData as $key => $value) {
				$img = '<img src="'. base_url() . $value['image'].'" class="img-circle candidate-photo" alt="Student Image" />';

				$classData = $this->Model_Classes->fetchClassData($value['class_id']);
				$sectionData = $this->Model_Section->fetchSectionByClassSection($value['class_id'], $value['section_id']);			

				$studentMarksheetData = $this->Model_Marksheet->fetchStudentMarksByClassSectionStudentSubject($value['class_id'], $value['section_id'], $value['student_id'], $subjectId);
				$marksheetId = $studentMarksheetData['marksheet_id'];	

				$button = '<div class="btn-group">
				  <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
				    Action <span class="caret"></span>
				  </button>
				  <ul class="dropdown-menu">			  	
				    <li><a href="#" data-toggle="modal" data-target="#editMarksModal" onclick="editMarks('.$value['student_id'].','.$classId.')">Edit Marks</a></li>
				    <li><a href="#" data-toggle="modal" data-target="#viewMarksModal" onclick="viewMarks('.$value['student_id'].','.$classId.')">View</a></li>			    
				  </ul>
				</div>';
				$obtainmark='
				<input type="text" value='.$studentMarksheetData['obtain_mark'].' >
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
		if($classId && $sectionId) {
			$studentData = $this->Model_Student->fetchStudentByClassAndSection($classId, $sectionId);
			$result = array('data'=>array());
			foreach ($studentData as $key => $value) {
				$img = '<img src="'. base_url() . $value['image'].'" class="img-circle candidate-photo" alt="Student Image" />';

				$classData = $this->Model_Classes->fetchClassData($value['class_id']);
				$sectionData = $this->Model_Section->fetchSectionByClassSection($value['class_id'], $value['section_id']);

				$studentMarksheetData = $this->Model_Marksheet->fetchStudentMarksByClassSectionStudent($value['class_id'], $value['section_id'], $value['student_id']);
				// $marksheetId = $studentMarksheetData['marksheet_id'];

				$button = '<div class="btn-group">
				  <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
				    Action <span class="caret"></span>
				  </button>
				  <ul class="dropdown-menu">			  	
				    <!--<li><a href="#" data-toggle="modal" data-target="#editMarksModal" onclick="editMarks('.$value['student_id'].','.$classId.')">Edit Marks</a></li>-->
				    <li><a href="#" data-toggle="modal" data-target="#viewMarksModal" onclick="viewMarks('.$value['student_id'].','.$classId.')">View</a></li>			    
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
		if($studentId && $classId && $marksheetId) {
			$marksheetName = $this->Model_Marksheet->fetchMarksheetDataByMarksheetId($marksheetId);
			$marksheetStudentData = $this->Model_Marksheet->fetchStudentMarksheetData($studentId, $classId, $marksheetId);

			$form = '

			<form class="form-horizontal" action="marksheet/createStudentMarks" method="post" id="createStudentMarksForm">
			  <div class="form-group">
			    <label class="col-sm-2 control-label">Name</label>
			    <div class="col-sm-10">
			      <label class="form-control">'.$marksheetName['marksheet_name'].'</label>
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
			    <th><label for="inputPassword3">'.$subjectData['name'].' (PT 1)</label></th>
			    <th><label for="inputPassword3">'.$subjectData['name'].' (SA 1)</label></th>
				<th><label for="inputPassword3">TOTAL</label></th>
				<th><label for="inputPassword3">'.$subjectData['name'].' (PT 2)</label></th>
				<th><label for="inputPassword3">'.$subjectData['name'].' (SA 2)</label></th>
				<th><label for="inputPassword3">TOTAL</label></th>
				</tr>
				<tr>
				<div class="col-sm-10">			      
			    	<td><input type="text" class="form-control" name="studentMarks['.$x.']" id="studentMarks'.$x.'" value="'.$value['obtain_mark'].'" /></td>			    	
			    	<input type="hidden" name="marksheetStudentId['.$x.']" value="'.$value['marksheet_student_id'].'" />			    	
			    </div>
				
				<div class="col-sm-10">			      
				 <td><input type="text" class="form-control" name="studentMarksSA['.$x.']" id="studentMarksSA'.$x.'" value="'.$value['obtain_mark_sa'].'" />	</td>		    	
			    	<input type="hidden" name="marksheetStudentId['.$x.']" value="'.$value['marksheet_student_id'].'" />			    	
			    </div>
				<div class="col-sm-10">			      
				 <td><input type="text" class="form-control" name="grandTotal1['.$x.']" id="grandTotal1'.$x.'" value="'.$total_term_1.'" />	</td>		    	
			    	<input type="hidden" name="marksheetStudentId['.$x.']" value="'.$value['marksheet_student_id'].'" />			    	
			    </div>
				<div class="col-sm-10">			      
				 <td><input type="text" class="form-control" name="studentMarksPT2['.$x.']" id="studentMarksPT2'.$x.'" value="'.$value['obtain_mark_pt_2'].'" />	</td>		    	
			    	<input type="hidden" name="marksheetStudentId['.$x.']" value="'.$value['marksheet_student_id'].'" />			    	
			    </div>
				<div class="col-sm-10">			      
				 <td><input type="text" class="form-control" name="studentMarksSA2['.$x.']" id="studentMarksSA2'.$x.'" value="'.$value['obtain_mark_sa_2'].'" />	</td>		    	
			    	<input type="hidden" name="marksheetStudentId['.$x.']" value="'.$value['marksheet_student_id'].'" />			    	
			    </div>
				<div class="col-sm-10">			      
				 <td><input type="text" class="form-control" name="grandTotal2['.$x.']" id="grandTotal2'.$x.'" value="'.$total_term_2.'" />	</td>		    	
			    	<input type="hidden" name="marksheetStudentId['.$x.']" value="'.$value['marksheet_student_id'].'" />			    	
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
			  echo $grand_total_1;
			 
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
		if(!empty($studentMarks)) {			
			foreach ($studentMarks as $key => $value) {
				$this->form_validation->set_rules('studentMarks['.$key.']', 'Marks','required');	
			}
		}
				
		$this->form_validation->set_error_delimiters('<p class="text-danger">','</p>');		

		if($this->form_validation->run()) {			
			$this->Model_Marksheet->createStudentMarks();			
				
			$validator['success'] = true;
			$validator['messages'] = "Successfully added";			
		} else {			
			$validator['success'] = false;								
			foreach ($_POST as $key => $value) {					
				if($key == 'studentMarks') {
					foreach ($value as $number => $data) {
						$validator['messages']['studentMarks'.$number] = form_error('studentMarks['.$number.']');
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
		if($studentId && $classId && $marksheetId) {			
			$studentMarkData = $this->Model_Marksheet->viewStudentMarksheet($studentId, $classId, $marksheetId);
			$div = '
			<h3 style="color:red;text-align:center;">MY FACT FILE</h3>
			<h6><b>My Name is</b> </h6>
			<h6><b>My Class and Section is</b> </h6>
			<h6><b>My Birthday is on</b> </h6>
			<h6><b>My Mother&#39;s Name is</b> </h6>
			<h6><b>My Father&#39;s Name is</b> </h6>
			<h6><b>Residentail Address and Phone No.</b> </h6>
			<h6><b>At School, I enjoy</b> </h6>
			<h6><b>My Class Teacher&#39;s Name is</b> </h6>
			<h6><b>My attendance in the 1st Term</b> </h6>
			<h6><b>My attendance in the 2nd Term</b> </h6><br/><br/>
			<h6><b>My parent&#39;s Signature &nbsp; .............................(Mother)&nbsp;&nbsp;.............................(Father)</b> </h6><br/><br/>
			<h3 style="color:red;text-align:center;">MY ACADEMIC ASSESSMENT (Term - 1)</h3>
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
					$total_term_1 = $value['obtain_mark'] + $value['obtain_mark_sa'];
					$total_term_2 = $value['obtain_mark_pt_2'] + $value['obtain_mark_sa_2'];
					$div .= '<tr>					
					<td>'.$subjectData['name'].'</td>
					<td>'.$value['obtain_mark'].'</td>
					<td>'.$value['obtain_mark_sa'].'</td>
					<td>'.$total_term_1.'</td>
					<td>'.$value['obtain_mark_pt_2'].'</td>
					<td>'.$value['obtain_mark_sa_2'].'</td>
					<td>'.$total_term_2.'</td>
					
					
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
			<td>'.$obtainMark_1.'</td>
			<td></td>
			<td></td>
			<td>'.$obtainMark_2.'</td>
			</tr>
			<tr>
			<th>Percentage</th>
			<td></td>
			<td></td>
			<td>'.$percentage_1.' %</td>
			<td></td>
			<td></td>
			<td>'.$percentage_2.' %</td>
			</tr>
			<tr>
			<th>Rank</th>
			<td></td>
			<td></td>
			<td>'.$value['grandtotal_1'].'</td>
			<td></td>
			<td></td>
			<td>'.$value['grandtotal_2'].'</td>
			</tr>

			</table>
			
			';

			echo $div;
		} // /if
	}

	public function saveCustomMarks()
	{
		if(!empty($this->input->post())){
			echo "<pre>";
			$dataArray = array();
			foreach ($this->input->post() as $key => $value) {
				if (strpos($key, 'data') !== false) {
					$dataArray[$key] = $value;
				}
			}
			$this->load->library('user_agent');

			foreach ($dataArray as $key => $value) {
				
				$keyArr = explode('_', $key);

				$student_id = $keyArr[1];
				$subject_id = $keyArr[2];
				$marksheet_id = $keyArr[3];
				$savetoCol = $keyArr[4];
				$tableName = $keyArr[5];

				// echo "Student ID :".$student_id .'<br/>';
				// echo "Subject ID :".$subject_id .'<br/>';
				// echo "Marksheet ID :".$marksheet_id .'<br/>';
				//echo "table name :".$tableName .'<br/>';
				//exit();

				$dataWhere = array(
					'student_id' => $student_id,
					'subject_id' => $subject_id,
					'marksheet_id' => $marksheet_id,
				);

				if($savetoCol == "PT1"){
				$dataToSave = array(
					'obtain_mark' => $value
				);
			    }
				elseif($savetoCol == "SA1"){
					$dataToSave = array(
						'obtain_mark_sa' => $value
					);
				}
				elseif($savetoCol == "SE1"){
					$dataToSave = array(
						'subject_enrichmenth' => $value
					);
				}
				elseif($savetoCol == "HY"){
					$dataToSave = array(
						'h_yrly' => $value
					);
				}
				elseif($savetoCol == "PT2"){
					$dataToSave = array(
						'obtain_mark_pt_2' => $value
					);
				}
				elseif($savetoCol == "SA2"){
					$dataToSave = array(
						'obtain_mark_sa_2' => $value
					);
				}
				elseif($savetoCol == "SE2"){
					$dataToSave = array(
						'subject_enrichmentf' => $value
					);
				}
				elseif($savetoCol == "YY"){
					$dataToSave = array(
						'yrly' => $value
					);
				}

				try {
					
                   if($tableName == "marksheetstudent"){
					$this->db->trans_start();
					$this->db->where('student_id', $dataWhere['student_id']);
					$this->db->where('subject_id', $dataWhere['subject_id']);
					$this->db->where('marksheet_id', $dataWhere['marksheet_id']);
					$this->db->update('marksheet_student', $dataToSave);
					$this->db->trans_complete();
					$trans_status = $this->db->trans_status();
				   }
				   elseif($tableName == "marksheetaddsubject"){
					$this->db->trans_start();
					$this->db->where('student_id', $dataWhere['student_id']);
					$this->db->where('subject_id', $dataWhere['subject_id']);
					$this->db->where('marksheet_id', $dataWhere['marksheet_id']);
					$this->db->update('additional_subject__marksheet_student', $dataToSave);
					$this->db->trans_complete();
					$trans_status = $this->db->trans_status();
				   }
					

					

					if ($trans_status == FALSE) {
					    $this->db->trans_rollback();
						$validator['success'] = false;
						$validator['messages'] = "Couldn't save marksheet. Please try again.";
						$this->session->set_flashdata('error', $validator['messages']); 
					} else {
					    $this->db->trans_commit();
						$validator['success'] = true;
						$validator['messages'] = "Marksheet saved successfully.";
						$this->session->set_flashdata('success', $validator['messages']); 
					}

					header('Location: '.$_SERVER['HTTP_REFERER']);
					
				} catch (Exception $e) {
					$this->db->trans_rollback();
					$validator['success'] = false;
					$validator['messages'] = "Couldn't save marksheet. Please try again.";
					$this->session->set_flashdata('error', $validator['messages']);

					// print_r($e->getMessage());
					header('Location: '.$_SERVER['HTTP_REFERER']);
				}

			}
		}
	}

}