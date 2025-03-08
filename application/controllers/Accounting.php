<?php

class Accounting extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();

		$this->isNotLoggedIn();

		// loading the teacher model
		$this->load->model('Model_Student');
		// loading the classes model		
		$this->load->model('Model_Classes');
		// loading the section model
		$this->load->model('Model_Section');
		// accounting
		$this->load->model('Model_Accounting');
		// load model printadmissionslip
		$this->load->model('Model_PrintAdmissionSlip');
		// load model admission
		$this->load->model('Model_Admission');

		// loading the form validation library
		$this->load->library('form_validation');
	}


	/*
	* CREATE PAYMENT
	*---------------------------------------------------------------
	*/

	public function fetchType($type = 1)
	{


		$classData = $this->Model_Classes->fetchClassData();

		$div = '<form class="form-horizontal" action="accounting/createIndividual" method="post" id="createIndividualForm">	    	
			<div class="form-group">
			  <label for="className" class="col-sm-2 control-label">Class Name</label>
			  <div class="col-sm-10">
					<select class="form-control" name="className" id="className">
						<option value="">Select Class</option>';
		foreach ($classData as $key => $value) {
			$div .= '<option value="' . $value['class_id'] . '">' . $value['class_name'] . '</option>';
		} // .foreach
		$div .= '</select>
			  </div>
			</div>
			<div class="form-group">
			  <label for="sectionName" class="col-sm-2 control-label">Section Name</label>
			  <div class="col-sm-10">
					<select class="form-control" name="sectionName" id="sectionName">
						<option value="">Select Class</option>
					</select>
			  </div>
			</div>
			<div class="form-group">
			  <label for="rollNo" class="col-sm-2 control-label">Roll No.</label>
			  <div class="col-sm-10">
					<select class="form-control" name="rollNo" id="rollNo">
						<option value="">Select Class & Section</option>
					</select>
			  </div>
			</div>		  				 		  
			<div class="form-group">
			  <label for="studentName" class="col-sm-2 control-label">Name of Student</label>
			  <div class="col-sm-10">
					<select class="form-control" name="studentName" id="studentName">
						<option value="">Select Class & Section</option>
					</select>
			  </div>
			</div>
			
			<div class="form-group">
			<label for="examinationFee" class="col-sm-2 control-label">Examination Fee</label>
			<div class="col-sm-10">
				  <input type="text" class="form-control" id="examinationFee" name="examinationFee" placeholder="Examination Fee">
			</div>
		  </div>
		  <div class="form-group">
		  <label for="developmentFee" class="col-sm-2 control-label">Development Fee</label>
		  <div class="col-sm-10">
				<input type="text" class="form-control" id="developmentFee" name="developmentFee" placeholder="Development Fee">
		  </div>
		</div>
			<div class="form-group">
			  <label for="transportFee" class="col-sm-2 control-label">Transport Fee</label>
			  <div class="col-sm-10">
					<input type="text" class="form-control" id="transportFee" name="transportFee" placeholder="Transport Fee">
			  </div>
			</div>

		  <div class="form-group">
		  <label for="lateFine" class="col-sm-2 control-label">Late Fine</label>
		  <div class="col-sm-10">
				<input type="text" class="form-control" id="lateFine" name="lateFine" placeholder="Late Fine">
		  </div>
		</div>
			<div class="form-group">
			<label for="duration" class="col-sm-2 control-label">Duration</label>
			<div class="col-sm-10">
				  <input type="number" class="form-control" id="duration" name="duration" placeholder="Duration" Autocomplete="off" min="1" max="12">
			</div>
		  </div>
			<div class="form-group">
			  <label for="startDate" class="col-sm-2 control-label">Start Date</label>
			  <div class="col-sm-10">
					<input type="date" class="form-control" id="startDate" name="monthlyFeesStartDate" placeholder="Start Date" Autocomplete="off">
			  </div>
			</div>
			<div class="form-group">
			  <label for="endDate" class="col-sm-2 control-label">End Date</label>
			  <div class="col-sm-10">
					<input type="date" class="form-control" id="endDate" name="monthlyFeesEndDate" placeholder="End Date" Autocomplete="off">
			  </div>
			</div>
			<div class="form-group">
			  <label for="monthlyFee" class="col-sm-2 control-label">Tuition Fee</label>
			  <div class="col-sm-10">
					<select class="form-control" name="monthlyFee" id="monthlyFee">
						<option value="">Select Class</option>
					</select>
			  </div>
			</div>
			<div class="form-group">
			  <label for="total" class="col-sm-2 control-label">Total</label>
			  <div class="col-sm-10">
					<input type="text" class="form-control" id="total" name="total" value="" placeholder="Total" readonly>
			  </div>
			</div>
		  <div class="form-group">
			  <div class="col-sm-offset-2 col-sm-10">
				<button type="submit" class="btn btn-primary">Create</button>
			  </div>
		  </div>
	  </form>';
		// /.individual
		/*** else if($type == 2) {
			$classData = $this->Model_Classes->fetchClassData();			

			$div = '<form class="form-horizontal" action="accounting/createBulk" method="post" id="createBulkForm">	    	

			<div class="col-sm-6">
				<div class="form-group">
			    	<label for="className" class="col-sm-2 control-label">Class Name</label>
			    	<div class="col-sm-10">
			      		<select class="form-control" name="className" id="className">
			      			<option value="">Select Class</option>';
			      			foreach ($classData as $key => $value) {		      				
			      				$div .= '<option value="'.$value['class_id'].'">'.$value['class_name'].'</option>';
			      			} // .foreach
			      		$div .= '</select>
			    	</div>
			  	</div>
			  	<div class="form-group">
			    	<label for="sectionName" class="col-sm-2 control-label">Section Name</label>
			    	<div class="col-sm-10">
			      		<select class="form-control" name="sectionName" id="sectionName">
			      			<option value="">First Select Class</option>
			      		</select>
			    	</div>
			  	</div>		  				 		  		  	
			  	<div class="form-group">
			    	<label for="paymentName" class="col-sm-2 control-label">Payment Name</label>
			    	<div class="col-sm-10">
			      		<input type="text" class="form-control" id="paymentName" name="paymentName" placeholder="Payment Name">
			    	</div>
			  	</div>
			  	<div class="form-group">
			    	<label for="startDate" class="col-sm-2 control-label">Start Date</label>
			    	<div class="col-sm-10">
			      		<input type="text" class="form-control" id="startDate" name="startDate" placeholder="Start Date">
			    	</div>
			  	</div>
			  	<div class="form-group">
			    	<label for="endDate" class="col-sm-2 control-label">End Date</label>
			    	<div class="col-sm-10">
			      		<input type="text" class="form-control" id="endDate" name="endDate" placeholder="End Date">
			    	</div>
			  	</div>
			  	<div class="form-group">
			    	<label for="totalAmount" class="col-sm-2 control-label">Total Amount</label>
			    	<div class="col-sm-10">
			      		<input type="text" class="form-control" id="totalAmount" name="totalAmount" placeholder="Total Amount">
			    	</div>
			  	</div>
			</div>
			<!--/.col-sm-6--> 

			<div class="col-sm-6">
				<div class="page-header">
					<h3>Student Information</h3>
				</div>

				<table id="studentName" class="table table-bordered">
					<thead>
						<tr>
							<th>#</th>							
							<th>Name</th>							
						</tr>						
					</thead>
					<tbody>
						<tr>
							<td colspan="2"><center>First Select Class and Section</center></td>	
						</tr>
					</tbody>
				</table>
			</div>
			  	
			<div class="form-group">
			    <div class="col-sm-offset-1 col-sm-10">
			      <button type="submit" class="btn btn-primary">Create Payment</button>
			    </div>
			</div>
		</form>';
		} // /.bulk***/

		echo $div;
	}

	/*
	*------------------------------------------------
	* fetches the class's section info	
	*------------------------------------------------
	*/
	public function fetchClassSection($classId = null)
	{
		if ($classId) {
			$sectionData = $this->Model_Section->fetchSectionDataByClass($classId);
			$option = '<option value="">Select Section</option>';
			if ($sectionData) {
				foreach ($sectionData as $key => $value) {
					$option .= '<option value="' . $value['section_id'] . '">' . $value['section_name'] . '</option>';
				} // /foreach
			} else {
				$option = '<option value="">No Data</option>';
			} // /else empty section

			echo $option;
		}
	}

	/*
	*------------------------------------------------
	* fetches the student info by class and section 
	*------------------------------------------------
	*/
	public function fetchStudent($rollNo = null, $classId = null, $sectionId = null, $type = null)
	{
		if ($rollNo && $classId && $sectionId && $type) {

			$studentData = $this->Model_Student->fetchStudentByRollNoClassAndSection($rollNo, $classId, $sectionId);

			if ($type == 1) {
				// /.individual
				if ($studentData) {
					$option = '<option value="">Select Student Name</option>';
					foreach ($studentData as $key => $value) {
						$studentName = $value['student_name'];
						$option .= '<option value="' . $value['student_id'] . '">' . $studentName . '</option>';
					} // /foreach
				} else {
					$option = '<option value="">No Data</option>';
				} // /else empty section
			} else if ($type == 2) {

				if ($studentData) {
					$option = '<thead>
						<tr>
							<th>#</th>							
							<th>Name</th>							
						</tr>						
					</thead>
					<tbody>';
					$x = 1;
					foreach ($studentData as $key => $value) {
						$option .= '<tr>
								<td><input type="checkbox" name="studentId[' . $x . ']" value="' . $value['student_id'] . '" class="form-control" /> </td>
								<td>' . $value['fname'] . ' ' . $value['lname'] . '</td>
							</tr>';
						$x++;
					}
					$option .= '</tbody>';
				} else {
					$option = '<thead>
						<tr>
							<th>#</th>							
							<th>Name</th>							
						</tr>						
					</thead>
					<tbody>
						<tr>
							<td colspan="2"><center>No Data Available</center></td>	
						</tr>
					</tbody>';
				}
			}

			echo $option;
		}
	}

	/*
	*------------------------------------------------
	* fetches the rollno info by class and section 
	*------------------------------------------------
	*/


	public function fetchRollNo($classId = null, $sectionId = null, $type = null)
	{
		if ($classId && $sectionId && $type) {

			$rollNoData = $this->Model_Student->fetchRollNoByClassAndSection($classId, $sectionId);

			if ($type == 1) {
				// /.individual
				if ($rollNoData) {
					$option = '';
					foreach ($rollNoData as $key => $value) {
						$rollNo = $value['rollno'];
						$option .= '<option value="' . $value['rollno'] . '">' . $rollNo . '</option>';
					} // /foreach
				} else {
					$option = '<option value="">No Data</option>';
				} // /else empty section
			} else if ($type == 2) {

				if ($rollNoData) {
					$option = '<thead>
						<tr>
							<th>#</th>							
							<th>Name</th>							
						</tr>						
					</thead>
					<tbody>';
					$x = 1;
					foreach ($studentData as $key => $value) {
						$option .= '<tr>
								<td><input type="checkbox" name="studentId[' . $x . ']" value="' . $value['student_id'] . '" class="form-control" /> </td>
								<td>' . $value['fname'] . ' ' . $value['lname'] . '</td>
							</tr>';
						$x++;
					}
					$option .= '</tbody>';
				} else {
					$option = '<thead>
						<tr>
							<th>#</th>							
							<th>Name</th>							
						</tr>						
					</thead>
					<tbody>
						<tr>
							<td colspan="2"><center>No Data Available</center></td>	
						</tr>
					</tbody>';
				}
			}

			echo $option;
		}
	}

	/*
	*------------------------------------------------
	* fetches the father info by class and section 
	*------------------------------------------------
	*/


	public function fetchFather($studentId = null, $classId = null, $sectionId = null, $type = null)
	{
		if ($studentId && $classId && $sectionId && $type) {

			$fatherData = $this->Model_Student->fetchFatherByClassAndSection($studentId, $classId, $sectionId);

			if ($type == 1) {
				// /.individual
				if ($fatherData) {
					$option = '';
					foreach ($fatherData as $key => $value) {
						$fatherName = $value['father_name'];
						$option .= '<option value="' . $value['student_id'] . '">' . $fatherName . '</option>';
					} // /foreach
				} else {
					$option = '<option value="">No Data</option>';
				} // /else empty section
			} else if ($type == 2) {

				if ($studentData) {
					$option = '<thead>
						<tr>
							<th>#</th>							
							<th>Name</th>							
						</tr>						
					</thead>
					<tbody>';
					$x = 1;
					foreach ($studentData as $key => $value) {
						$option .= '<tr>
								<td><input type="checkbox" name="studentId[' . $x . ']" value="' . $value['student_id'] . '" class="form-control" /> </td>
								<td>' . $value['fname'] . ' ' . $value['lname'] . '</td>
							</tr>';
						$x++;
					}
					$option .= '</tbody>';
				} else {
					$option = '<thead>
						<tr>
							<th>#</th>							
							<th>Name</th>							
						</tr>						
					</thead>
					<tbody>
						<tr>
							<td colspan="2"><center>No Data Available</center></td>	
						</tr>
					</tbody>';
				}
			}

			echo $option;
		}
	}

	/*
	*------------------------------------------------
	* fetches the gaurdian info by class and section 
	*------------------------------------------------
	*/


	public function fetchGaurdian($studentId = null, $classId = null, $sectionId = null, $type = null)
	{
		if ($studentId && $classId && $sectionId && $type) {

			$gaurdianData = $this->Model_Student->fetchFatherByClassAndSection($studentId, $classId, $sectionId);

			if ($type == 1) {
				// /.individual
				if ($gaurdianData) {
					$option = '';
					foreach ($gaurdianData as $key => $value) {
						$gaurdianName = $value['gd_name'];
						$option .= '<option value="' . $value['student_id'] . '">' . $gaurdianName . '</option>';
					} // /foreach
				} else {
					$option = '<option value="">No Data</option>';
				} // /else empty section
			} else if ($type == 2) {

				if ($studentData) {
					$option = '<thead>
						<tr>
							<th>#</th>							
							<th>Name</th>							
						</tr>						
					</thead>
					<tbody>';
					$x = 1;
					foreach ($studentData as $key => $value) {
						$option .= '<tr>
								<td><input type="checkbox" name="studentId[' . $x . ']" value="' . $value['student_id'] . '" class="form-control" /> </td>
								<td>' . $value['fname'] . ' ' . $value['lname'] . '</td>
							</tr>';
						$x++;
					}
					$option .= '</tbody>';
				} else {
					$option = '<thead>
						<tr>
							<th>#</th>							
							<th>Name</th>							
						</tr>						
					</thead>
					<tbody>
						<tr>
							<td colspan="2"><center>No Data Available</center></td>	
						</tr>
					</tbody>';
				}
			}

			echo $option;
		}
	}

	/*
	*------------------------------------------------
	* fetches the address info by class and section 
	*------------------------------------------------
	*/


	public function fetchAddress($studentId = null, $classId = null, $sectionId = null, $type = null)
	{
		if ($studentId && $classId && $sectionId && $type) {

			$addressData = $this->Model_Student->fetchFatherByClassAndSection($studentId, $classId, $sectionId);

			if ($type == 1) {
				// /.individual
				if ($addressData) {
					$option = '';
					foreach ($addressData as $key => $value) {
						$address = $value['p_address'];
						$option .= '<option value="' . $value['student_id'] . '">' . $address . '</option>';
					} // /foreach
				} else {
					$option = '<option value="">No Data</option>';
				} // /else empty section
			} else if ($type == 2) {

				if ($studentData) {
					$option = '<thead>
						<tr>
							<th>#</th>							
							<th>Name</th>							
						</tr>						
					</thead>
					<tbody>';
					$x = 1;
					foreach ($studentData as $key => $value) {
						$option .= '<tr>
								<td><input type="checkbox" name="studentId[' . $x . ']" value="' . $value['student_id'] . '" class="form-control" /> </td>
								<td>' . $value['fname'] . ' ' . $value['lname'] . '</td>
							</tr>';
						$x++;
					}
					$option .= '</tbody>';
				} else {
					$option = '<thead>
						<tr>
							<th>#</th>							
							<th>Name</th>							
						</tr>						
					</thead>
					<tbody>
						<tr>
							<td colspan="2"><center>No Data Available</center></td>	
						</tr>
					</tbody>';
				}
			}

			echo $option;
		}
	}

	/*
	*------------------------------------------------
	* fetches the category info by class and section 
	*------------------------------------------------
	*/


	public function fetchCategory($studentId = null, $classId = null, $sectionId = null, $type = null)
	{
		if ($studentId && $classId && $sectionId && $type) {

			$categoryData = $this->Model_Student->fetchFatherByClassAndSection($studentId, $classId, $sectionId);

			if ($type == 1) {
				// /.individual
				if ($categoryData) {
					$option = '';
					foreach ($categoryData as $key => $value) {
						$category = $value['category'];
						$option .= '<option value="' . $value['student_id'] . '">' . $category . '</option>';
					} // /foreach
				} else {
					$option = '<option value="">No Data</option>';
				} // /else empty section
			} else if ($type == 2) {

				if ($studentData) {
					$option = '<thead>
						<tr>
							<th>#</th>							
							<th>Name</th>							
						</tr>						
					</thead>
					<tbody>';
					$x = 1;
					foreach ($studentData as $key => $value) {
						$option .= '<tr>
								<td><input type="checkbox" name="studentId[' . $x . ']" value="' . $value['student_id'] . '" class="form-control" /> </td>
								<td>' . $value['fname'] . ' ' . $value['lname'] . '</td>
							</tr>';
						$x++;
					}
					$option .= '</tbody>';
				} else {
					$option = '<thead>
						<tr>
							<th>#</th>							
							<th>Name</th>							
						</tr>						
					</thead>
					<tbody>
						<tr>
							<td colspan="2"><center>No Data Available</center></td>	
						</tr>
					</tbody>';
				}
			}

			echo $option;
		}
	}


	/*
	*---------------------------------------------------------
	* fetches the student info for update by class and section 
	*----------------------------------------------------------
	*/
	public function fetchEditStudent($classId = null, $sectionId = null, $type = null)
	{
		if ($classId && $sectionId && $type) {

			$studentData = $this->Model_Student->fetchStudentByClassAndSection($classId, $sectionId);

			if ($type == 1) {
				// /.individual
				if ($studentData) {
					foreach ($studentData as $key => $value) {
						$studentName = $value['fname'] . ' ' . $value['lname'];
						$option .= '<option value="' . $value['student_id'] . '">' . $studentName . '</option>';
					} // /foreach
				} else {
					$option = '<option value="">No Data</option>';
				} // /else empty section
			} else if ($type == 2) {

				if ($studentData) {
					$option = '<thead>
						<tr>
							<th>#</th>							
							<th>Name</th>							
						</tr>						
					</thead>
					<tbody>';
					$x = 1;
					foreach ($studentData as $key => $value) {
						$option .= '<tr>
								<td><input type="checkbox" name="editStudentId[' . $x . ']" value="' . $value['student_id'] . '" class="form-control" /> </td>
								<td>' . $value['fname'] . ' ' . $value['lname'] . '</td>
							</tr>';
						$x++;
					}
					$option .= '</tbody>';
				} else {
					$option = '<thead>
						<tr>
							<th>#</th>							
							<th>Name</th>							
						</tr>						
					</thead>
					<tbody>
						<tr>
							<td colspan="2"><center>No Data Available</center></td>	
						</tr>
					</tbody>';
				}
			}

			echo $option;
		}
	}

	public function fetchMonthlyFee($studentId = null, $classId = null, $sectionId = null, $type = null)
	{
		if ($studentId && $classId && $sectionId && $type) {

			$categoryData = $this->Model_Student->fetchMonthlyFeeByClassId($classId);

			if ($type == 1) {
				// /.individual
				if ($categoryData) {
					$option = '';
					foreach ($categoryData as $key => $value) {
						$category = $value['monthly_fee'];
						$option .= '<option value="' . $value['monthly_fee'] . '">' . $category . '</option>';
					} // /foreach
				} else {
					$option = '<option value="">No Data</option>';
				} // /else empty section
			} else if ($type == 2) {

				if ($studentData) {
					$option = '<thead>
						<tr>
							<th>#</th>							
							<th>Name</th>							
						</tr>						
					</thead>
					<tbody>';
					$x = 1;
					foreach ($studentData as $key => $value) {
						$option .= '<tr>
								<td><input type="checkbox" name="studentId[' . $x . ']" value="' . $value['student_id'] . '" class="form-control" /> </td>
								<td>' . $value['fname'] . ' ' . $value['lname'] . '</td>
							</tr>';
						$x++;
					}
					$option .= '</tbody>';
				} else {
					$option = '<thead>
						<tr>
							<th>#</th>							
							<th>Name</th>							
						</tr>						
					</thead>
					<tbody>
						<tr>
							<td colspan="2"><center>No Data Available</center></td>	
						</tr>
					</tbody>';
				}
			}

			echo $option;
		}
	}

	/*
	*------------------------------------------------
	* creates the individual student's payment
	*------------------------------------------------
	*/
	public function createIndividual()
	{
		$validator = array('success' => false, 'messages' => array());

		$validate_data = array(
			array(
				'field' => 'className',
				'label' => 'Class Name',
				'rules' => 'required'
			)

		);

		$this->form_validation->set_message('required', '%s is required');
		$this->form_validation->set_rules($validate_data);
		$this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>');

		if ($this->form_validation->run() === true) {
			$create = $this->Model_Accounting->createIndividual();
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
	*------------------------------------------------
	* creates the bulk student's payment
	*------------------------------------------------
	*/
	public function createBulk()
	{
		$validator = array('success' => false, 'messages' => array());

		$validate_data = array(
			array(
				'field' => 'className',
				'label' => 'Class Name',
				'rules' => 'required'
			),
			array(
				'field' => 'sectionName',
				'label' => 'Section Name',
				'rules' => 'required'
			),
			array(
				'field' => 'paymentName',
				'label' => 'Payment Name',
				'rules' => 'required'
			),
			array(
				'field' => 'startDate',
				'label' => 'Start Date',
				'rules' => 'required'
			),
			array(
				'field' => 'endDate',
				'label' => 'End Date',
				'rules' => 'required'
			),
			array(
				'field' => 'totalAmount',
				'label' => 'Total Amount',
				'rules' => 'required'
			)
		);

		$this->form_validation->set_rules($validate_data);
		$this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>');

		if ($this->form_validation->run() === true) {
			$create = $this->Model_Accounting->createBulk();
			if ($create === true) {
				$validator['success'] = true;
				$validator['messages'] = "Successfully added";
			} else {
				$validator['success'] = false;
				$validator['messages'] = "Select at least one student";
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
	* /. END OF CREATE PAYMENT SECTION
	*---------------------------------------------------------------
	*/

	/*
	*---------------------------------------------------------------
	* fetch payments' information from the database
	*---------------------------------------------------------------
	*/
	public function fetchPaymentData()
	{
		$paymentData = $this->Model_Accounting->fetchPaymentData();

		$result = array('data' => array());
		foreach ($paymentData as $key => $value) {

			$button = '
			<div class="btn-group">
			  <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
			    Action <span class="caret"></span>
			  </button>
			  <ul class="dropdown-menu">
			    <li><a href="#" data-toggle="modal" data-target="#editPayment" onclick="updatePayment(' . $value['id'] . ',' . $value['type'] . ')">Edit</a></li>
			   <li><a href="#" data-toggle="modal" data-target="#removePayment" onclick="removePayment(' . $value['id'] . ')">Remove</a></li>    
			  </ul>
			</div>';

			$result['data'][$key] = array(
				$value['name'],
				$value['start_date'],
				$value['end_date'],
				$button
			);
		}

		echo json_encode($result);
	}

	/*
	*---------------------------------------------------------------
	* fetch students' payment information from the database
	*---------------------------------------------------------------
	*/
	public function fetchManageStudentPayData()
	{
		$paymentData = $this->Model_Accounting->fetchStudentPayData();

		$result = array('data' => array());
		foreach ($paymentData as $key => $value) {
			$classData = $this->Model_Classes->fetchClassData($value['class_id']);
			$sectionData = $this->Model_Section->fetchSectionByClassSection($value['class_id'], $value['section_id']);
			$studentData = $this->Model_Student->fetchStudentData($value['student_id']);
			$paymentData = $this->Model_Accounting->fetchStudentPayData($value['payment_id']);
			$paymentNameData = $this->Model_Accounting->fetchPaymentData($value['payment_name_id']);
			$convertStartDate = date("d-m-Y", strtotime($paymentNameData['start_date']));
			$convertEndDate = date("d-m-Y", strtotime($paymentNameData['end_date']));
			if ($studentData) {
				$studentName = $studentData['student_name'];
				$studentArea = $studentData['area'];
			} elseif (!$studentData) {
				$studentName = '';
				$studentArea = '';
			}
			$status = '';
			$dueAmount = $paymentData['due_amount'];
			//$dueAmount = (int)$dueAmount;

			if ($value['status'] == 0) {
				$status = '<label class="label label-info">pending</label>';
			} else if ($value['status'] == 1) {
				$status = '<label class="label label-success">Paid</label>';
			} else if ($value['status'] == 2) {
				$status = '<label class="label label-danger">Unpaid</label>';
			}
			$userlevel = $this->session->userdata('user_level');

			if ($userlevel == 2) {
				if ($paymentData['name'] == 'Monthly Fee') {
					if ($value['due_amount'] != 0) {
						$button = '
			<div class="btn-group">
			  <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
			    Action <span class="caret"></span>
			  </button>
			  <ul class="dropdown-menu">			  				  	
			    <li><a href="#" data-toggle="modal" data-target="#editStudentPay" onclick="updateStudentPay(' . $value['payment_id'] . ')">Edit Payment</a></li>
			  </ul>
			</div>';
					} elseif ($value['due_amount'] == 0) {
						$button = '';
					}
				} else if ($paymentData['name'] == 'Admission Fee') {
					$button = '';
				}
			} elseif ($userlevel == 1) {
				if ($paymentData['name'] == 'Monthly Fee') {
					// if ($value['due_amount'] != 0) {
					$button = '
			<div class="btn-group">
			  <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
			    Action <span class="caret"></span>
			  </button>
			  <ul class="dropdown-menu">			  				  	
			    <li><a href="#" data-toggle="modal" data-target="#editStudentPay" onclick="updateStudentPay(' . $value['payment_id'] . ')">Edit Payment</a></li>
			    <li><a href="#" data-toggle="modal" data-target="#updateStudentStatus" onclick="updateStudentStatus(' . $value['payment_id'] . ')">Student Status</a></li>
				<li><a href="#" data-toggle="modal" data-target="#removeStudentPay" onclick="removeStudentPay(' . $value['payment_name_id'] . ')">Remove</a></li>
			  </ul>
			</div>';
					// } elseif ($value['due_amount'] == 0) {
					// 	$button = '';
					// }
				} else if ($paymentData['name'] == 'Admission Fee') {
					$button = '';
				}
			}

			if ($paymentData['name'] == 'Monthly Fee') {
				$printbutton = '
			<div class="btn-group">
			<button class="btn btn-primary" data-toggle="modal" data-target="#printStudentPay" onclick="printStudentPay(' . $value['payment_id'] . ')">Preview</button>
			</div>';
			} else if ($paymentData['name'] == 'Admission Fee') {
				$printbutton = '';
			}
			//Student Status
			if ($value['st_status'] == 0) {
				$st_status = '<label class="label label-success">Yes</label>';
			} elseif ($value['st_status'] == 1) {
				$st_status = '<label class="label label-danger">No</label>';
			}

			$result['data'][$key] = array(
				$studentArea,
				$paymentNameData['name'],
				$studentName,
				$classData['class_name'],
				$sectionData['section_name'],
				$convertStartDate,
				$convertEndDate,
				$status,
				$st_status,
				$dueAmount,
				$printbutton,
				$button
			);
		}

		echo json_encode($result);
	}

	/*
	*---------------------------------------------------------------
	* checks payment type id and retreives the form group
	* type = `1` individual student
	* type = `2` bulk student
	*---------------------------------------------------------------
	*/
	public function fetchUpdatePaymentForm($type = null)
	{
		$classData = $this->Model_Classes->fetchClassData();

		if ($type == 1) {
			$option = '<form class="form-horizontal" action="accounting/updatePayment" method="post" id="updatePaymentFrom">	    	
		  	<div class="form-group">
		    	<label for="editClassName" class="col-sm-2 control-label">Class Name</label>
		    	<div class="col-sm-10">
		      		<select class="form-control" name="editClassName" id="editClassName">
		      			<option value="">Select Class</option>';
			foreach ($classData as $key => $value) {
				$option .= '<option value="' . $value['class_id'] . '">' . $value['class_name'] . '</option>';
			} // .foreach
			$option .= '</select>
		    	</div>
		  	</div>
		  	<div class="form-group">
		    	<label for="editSectionName" class="col-sm-2 control-label">Section Name</label>
		    	<div class="col-sm-10">
		      		<select class="form-control" name="editSectionName" id="editSectionName">
		      			<option value="">Select Class</option>
		      		</select>
		    	</div>
		  	</div>		  				 		  
		  	<div class="form-group">
		    	<label for="studentData" class="col-sm-2 control-label">Student</label>
		    	<div class="col-sm-10">
		      		<select class="form-control" name="studentData" id="studentData">
		      			<option value="">Select Class & Section</option>
		      		</select>
		    	</div>
		  	</div>
		  	<div class="form-group">
		    	<label for="editPaymentName" class="col-sm-2 control-label">Payment Name</label>
		    	<div class="col-sm-10">
		      		<input type="text" class="form-control" id="editPaymentName" name="editPaymentName" placeholder="Payment Name">
		    	</div>
		  	</div> 
		  	<div class="form-group">
		    	<label for="editStartDate" class="col-sm-2 control-label">Start Date</label>
		    	<div class="col-sm-10">
		      		<input type="text" class="form-control" id="editStartDate" name="editStartDate" placeholder="Start Date">
		    	</div>
		  	</div>
		  	<div class="form-group">
		    	<label for="editEndDate" class="col-sm-2 control-label">End Date</label>
		    	<div class="col-sm-10">
		      		<input type="text" class="form-control" id="editEndDate" name="editEndDate" placeholder="End Date">
		    	</div>
		  	</div>
		  	<div class="form-group">
		    	<label for="editTotalAmount" class="col-sm-2 control-label">Total Amount</label>
		    	<div class="col-sm-10">
		      		<input type="text" class="form-control" id="editTotalAmount" name="editTotalAmount" placeholder="Total Amount">
		    	</div>
		  	</div>
			<div class="form-group">
			    <div class="col-sm-offset-2 col-sm-10">
			    	<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			      	<button type="submit" class="btn btn-primary">Update</button>
			    </div>
			</div>
		</form>';
		} else if ($type == 2) {

			$option = '<form class="form-horizontal" action="accounting/updatePayment" method="POST" id="updatePaymentFrom">
	      	
	      	<div class="row">
	      	
	      	<div class="col-md-6">

				<div class="form-group">
			    	<label for="editClassName" class="col-sm-4 control-label">Class Name</label>
			    	<div class="col-sm-8">
			      		<select class="form-control" name="editClassName" id="editClassName">      	
			      			<option value="">Select Class</option>';
			foreach ($classData as $key => $value) {
				$option .= '<option value="' . $value['class_id'] . '">' . $value['class_name'] . '</option>';
			}
			$option .= '</select>
			    	</div>
			  	</div>	
			  	<div class="form-group">
			    	<label for="editSectionName" class="col-sm-4 control-label">Section Name</label>
			    	<div class="col-sm-8">
			      		<select class="form-control" name="editSectionName" id="editSectionName">
			      			<option value="">First Select Class</option>
			      		</select>
			    	</div>
			  	</div>	
			  	<div class="form-group">
			    	<label for="editPaymentName" class="col-sm-4 control-label">Payment Name</label>
			    	<div class="col-sm-8">
			      		<input type="text" name="editPaymentName" id="editPaymentName" placeholder="Payment Name" class="form-control" />
			    	</div>
			  	</div>	
			  	<div class="form-group">
			    	<label for="editStartDate" class="col-sm-4 control-label">Start Date</label>
			    	<div class="col-sm-8">
			      		<input type="text" name="editStartDate" id="editStartDate" placeholder="Start Date" class="form-control" />
			    	</div>
			  	</div>	
			  	<div class="form-group">
			    	<label for="editEndDate" class="col-sm-4 control-label">End Date</label>
			    	<div class="col-sm-8">
			      		<input type="text" name="editEndDate" id="editEndDate" placeholder="End Date" class="form-control" />
			    	</div>
			  	</div>	
			  	<div class="form-group">
			    	<label for="sectionName" class="col-sm-4 control-label">Total Amount</label>
			    	<div class="col-sm-8">
			      		<input type="text" name="editTotalAmount" id="editTotalAmount" class="form-control" placeholder="Total Amount"/>
			    	</div>
			  	</div>	

			  	<div class="form-group">
			  		<div class="col-sm-offset-2 col-sm-10">
			  			<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			        	<button type="submit" class="btn btn-primary">Save changes</button>
			        </div>	
			  	</div>
				  	
			</div>
			<!-- /.col-md-6 -->


			<div class="col-md-6">
				<table class="table table-bordered" id="studentData">
					<thead>
						<tr>
							<th>#</th>
							<th>Name</th>
						</tr>
					</thead>
					
				</table>
			</div>
			<!-- /.col-md-6 -->

	      	</div>
	      	<!-- /.row -->
		   		
      		</form>';
		} else {
			$option = '';
		}

		echo $option;
	}

	/*
	*---------------------------------------------------------------
	* fetches the section data by the class id 	
	*---------------------------------------------------------------
	*/
	public function fetchSectionClassForBulkStudent($classId = null)
	{
		if ($classId) {
			$sectionData = $this->Model_Section->fetchSectionDataByClass($classId);

			if ($sectionData) {
				$option = '';
				foreach ($sectionData as $key => $value) {
					$option .= '<option value="' . $value['section_id'] . '">' . $value['section_name'] . '</option>';
				}
			} else {
				$option = '<option value="">No Data</option>';
			}
		} else {
			$option = '<option value="">First Select Class</option>';
		}

		echo $option;
	}

	/*
	*---------------------------------------------------------------
	* fetch payment' information by payment id from the datatable
	* `$id` = payment_name table's id
	*---------------------------------------------------------------
	*/
	public function fetchPaymentById($id = null)
	{
		if ($id) {
			$result['name'] = $this->Model_Accounting->fetchPaymentData($id);
			$result['payment'] = $this->Model_Accounting->fetchStudentPaymentById($id);

			echo json_encode($result);
		}
	}

	/*
	*---------------------------------------------------------------
	* fetch student data for payment update
	*---------------------------------------------------------------
	*/
	public function fetchStudentForPaymentUpdate($classId = null, $sectionId = null)
	{
		$studentData = $this->Model_Student->fetchStudentByClassAndSection($classId, $sectionId);

		if ($studentData) {
			$option = '<thead>
				<tr>
					<th>#</th>							
					<th>Name</th>							
				</tr>						
			</thead>
			<tbody>';
			$x = 1;
			foreach ($studentData as $key => $value) {
				$option .= '<tr>
						<td><input type="checkbox" name="editStudentId[' . $x . ']" value="' . $value['student_id'] . '" id="editStudentId' . $value['student_id'] . '" class="form-control" /> </td>
						<td>' . $value['fname'] . ' ' . $value['lname'] . '</td>
					</tr>';
				$x++;
			}
			$option .= '</tbody>';
		} else {
			$option = '<thead>
				<tr>
					<th>#</th>							
					<th>Name</th>							
				</tr>						
			</thead>
			<tbody>
				<tr>
					<td colspan="2"><center>No Data Available</center></td>	
				</tr>
			</tbody>';
		}
		echo $option;
	}

	/*
	*---------------------------------------------------------------
	* fetch the manage payment information table function
	*---------------------------------------------------------------
	*/
	public function fetchManagePaymentTable()
	{
		$div = '
		<div class="panel panel-default">
			<div class="panel-heading">
				Manage Payment
			</div>
			<div class="panel-body">						
				<div id="remove-payment-message"></div>
					<table id="managePaymentTable" class="table table-bordered">
						<thead>
							<tr>
								<th>Name</th>
								<th>Start Date</th>
								<th>End Date</th>
								<th>Options</th>
							</tr>
						</thead>				
					</table>
			</div><!-- /.panel-body -->
		</div><!-- /.panel -->
		';

		echo $div;
	}

	/*
	*---------------------------------------------------------------
	* fetch the manage student's payment information table function
	*---------------------------------------------------------------
	*/
	public function fetchManageStudentPayTable()
	{
		$div = '
		<div class="panel panel-default">
			<div class="panel-heading">
				Manage Student Payment
			</div>
			<div class="panel-body">						
				<div id="remove-stu-payment-message"></div>
				<table id="manageStudentPayTable" class="table table-bordered">
					<thead>
						<tr>
						    <th>Area</th>
							<th>Payment Name</th>
							<th>Student Name</th>
							<th>Class</th>
							<th>Section</th>
							<th>Start Date</th>
							<th>End Date</th>
							<th>Status</th>
							<th>Student Status</th>
							<th>Due Amount</th>
							<th>Print</th>
							<th>Action</th>
						</tr>
					</thead>				
				</table>
			</div><!-- /.panel-body -->
		</div><!-- /.panel -->
		';

		echo $div;
	}


	/*
	*---------------------------------------------------------------
	* update the payment information
	* id = `payment_name` table's id primary key
	* type = `1` individual student
	* type = `2` bulk student
	*---------------------------------------------------------------
	*/
	public function updatePayment($id = null, $type = null)
	{
		if ($id && $type) {
			$validator = array('success' => false, 'messages' => array());
			if ($type == 1) {
				// individual update
				$validate_data = array(
					array(
						'field' => 'editClassName',
						'label' => 'Class Name',
						'rules' => 'required'
					),
					array(
						'field' => 'editSectionName',
						'label' => 'Section Name',
						'rules' => 'required'
					),
					array(
						'field' => 'studentData',
						'label' => 'Student Name',
						'rules' => 'required'
					),
					array(
						'field' => 'editPaymentName',
						'label' => 'Payment Name',
						'rules' => 'required'
					),
					array(
						'field' => 'editStartDate',
						'label' => 'Start Date',
						'rules' => 'required'
					),
					array(
						'field' => 'editEndDate',
						'label' => 'End Date',
						'rules' => 'required'
					),
					array(
						'field' => 'editTotalAmount',
						'label' => 'Total Amount',
						'rules' => 'required'
					)
				);

				$this->form_validation->set_rules($validate_data);
				$this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>');

				if ($this->form_validation->run() === true) {
					$create = $this->Model_Accounting->updatePayment($id, $type);
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
			} else if ($type == 2) {
				// bulk update
				$validate_data = array(
					array(
						'field' => 'editClassName',
						'label' => 'Class Name',
						'rules' => 'required'
					),
					array(
						'field' => 'editSectionName',
						'label' => 'Section Name',
						'rules' => 'required'
					),
					array(
						'field' => 'editPaymentName',
						'label' => 'Payment Name',
						'rules' => 'required'
					),
					array(
						'field' => 'editStartDate',
						'label' => 'Start Date',
						'rules' => 'required'
					),
					array(
						'field' => 'editEndDate',
						'label' => 'End Date',
						'rules' => 'required'
					),
					array(
						'field' => 'editTotalAmount',
						'label' => 'Total Amount',
						'rules' => 'required'
					)
				);

				$this->form_validation->set_rules($validate_data);
				$this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>');

				$this->form_validation->set_rules($validate_data);
				$this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>');

				if ($this->form_validation->run() === true) {
					$create = $this->Model_Accounting->updatePayment($id, $type);
					if ($create === true) {
						$validator['success'] = true;
						$validator['messages'] = "Successfully added";
					} else {
						$validator['success'] = false;
						$validator['messages'] = "Select at least one student";
					}
				} else {
					$validator['success'] = false;
					foreach ($_POST as $key => $value) {
						$validator['messages'][$key] = form_error($key);
					}
				} // /else

				echo json_encode($validator);
			} // /.if
		} // /.if id && type
	}

	/*
	*---------------------------------------------------------------
	* remove the payment info from the database
	*---------------------------------------------------------------
	*/
	public function removePayment($id = null)
	{
		if ($id) {
			$validator = array('success' => false, 'messages' => array());

			$remove = $this->Model_Accounting->removePayment($id);
			if ($remove === true) {
				$validator['success'] = true;
				$validator['messages'] = 'Successfully Removed';
			} else {
				$validator['success'] = false;
				$validator['messages'] = 'Error while removing';
			}

			echo json_encode($validator);
		}
	}

	/*
	*---------------------------------------------------------------
	* Manage student's payment functions section
	* paymentId is for `payment` table
	* not for `payment_name` table
	* the paymentId will get the data from the `payment` table
	* through the `payment` table data, the function will fetch the 
	* data from the `payment_name` table  
	*---------------------------------------------------------------
	*/
	public function fetchStudentPaymentInfo($paymentId = null)
	{
		if ($paymentId) {
			$paymentData = $this->Model_Accounting->fetchStudentPayData($paymentId);
			$paymentNameData = $this->Model_Accounting->fetchPaymentData($paymentData['payment_name_id']);
			$classData = $this->Model_Classes->fetchClassData($paymentData['class_id']);
			$sectionData = $this->Model_Section->fetchSectionByClassSection($paymentData['class_id'], $paymentData['section_id']);
			$studentData = $this->Model_Student->fetchStudentData($paymentData['student_id']);
			$convertStartDate = date("d-m-Y", strtotime($paymentNameData['start_date']));
			$convertEndDate = date("d-m-Y", strtotime($paymentNameData['end_date']));
			$currentDate = date('Y-m-d');
			if ($paymentData['paid_amount'] == '') {
				$totalPaid = 0;
			} else {
				$totalPaid = $paymentData['paid_amount'];
			}
			$userlevel = $this->session->userdata('user_level');

			$div = '
			<div id="update-student-payment-message"></div>

			<form class="form-horizontal" action="accounting/updateStudentPay" method="post" id="updateStudentPayForm">
			  <div class="col-md-6">
			  <div class="form-group">
				    <!--<label for="paymentNameId" class="col-sm-4 control-label">Payment ID: </label>-->
				    <div class="col-sm-8">
				      <input type="text" class="form-control" id="paymentNameId" name="paymentNameId"placeholder="Payment Name Id" value="' . $paymentNameData['id'] . '" style="display:none;"/>
				      <input type="text" class="form-control" id="userlevel" placeholder="User Level" value="' . $userlevel . '" style="display:none;"/>

				    </div>
				  </div>
      			<div class="form-group">
				    <label for="paymentName" class="col-sm-4 control-label">Payment Name: </label>
				    <div class="col-sm-8">
				      <input type="email" class="form-control" id="paymentName" placeholder="Payment Name" disabled value="' . $paymentNameData['name'] . '"/>
				    </div>
				  </div>				  
				  <div class="form-group">
				    <label for="startDate" class="col-sm-4 control-label">Start Date: </label>
				    <div class="col-sm-8">
				      <input type="text" class="form-control" id="startDate" placeholder="Start Date" readonly value="' . $paymentNameData['start_date'] . '"/>
				    </div>
				  </div>	
				  <div class="form-group">
				  <label for="durationPayment" class="col-sm-4 control-label">Duration: </label>
				  <div class="col-sm-8">
					<input type="number" class="form-control" id="durationPayment" name="durationPayment" placeholder="Duration" value="' . $paymentNameData['duration'] . '" max="12" min="' . $paymentNameData['duration'] . '"/>
				  </div>
				</div>		  
				  <div class="form-group">
				    <label for="endDate" class="col-sm-4 control-label">End Date: </label>
				    <div class="col-sm-8">
				      <input type="text" class="form-control" id="endDate" name="endDate" placeholder="End Date" readonly value="' . $paymentNameData['end_date'] . '">
				    </div>
			  	  </div>
			  	  <div class="form-group">
				    <label for="className" class="col-sm-4 control-label">Class: </label>
				    <div class="col-sm-8">
				      <input type="text" class="form-control" id="className" placeholder="Class" disabled value="' . $classData['class_name'] . '">
				    </div>
			  	  </div>
			  	  <div class="form-group">
				    <label for="section" class="col-sm-4 control-label">Section: </label>
				    <div class="col-sm-8">
				      <input type="text" class="form-control" id="section" placeholder="Section" disabled value="' . $sectionData['section_name'] . '">
				    </div>
					</div>
					<div class="form-group">
				    <label for="rollNo" class="col-sm-4 control-label">Roll No: </label>
				    <div class="col-sm-8">
				      <input type="text" class="form-control" id="rollNo" placeholder="Roll No" disabled value="' . $studentData['rollno'] . '">
				    </div>
					</div>
					<div class="form-group">
				    <label for="studentName" class="col-sm-4 control-label">Student Name: </label>
				    <div class="col-sm-8">
				      <input type="text" class="form-control" id="studentName" placeholder="Student Name" disabled value="' . $studentData['student_name'] . '">
				      				      <input type="hidden" class="form-control" placeholder="Student Name" readonly name="studentId" value="' . $studentData['student_id'] . '">
				    </div>
				  </div>
				  <div class="form-group">
				  <label for="totalAmount" class="col-sm-4 control-label">Total Amount: </label>
				  <div class="col-sm-8">
					<input type="text" class="form-control" id="totalAmount" name="totalAmount" placeholder="Total Amounts" readonly value="' . $paymentNameData['total_amount'] . '">
				  </div>
				</div>
				<div class="form-group">
				  <label for="totalPayableAmount" class="col-sm-4 control-label">Total Payable Amount: </label>
				  <div class="col-sm-8">
					<input type="text" class="form-control" id="totalPayableAmount" name="totalPayableAmount" placeholder="Total Payable Amount" readonly value="' . $paymentNameData['total_payableamount'] . '">
				  </div>
				</div>
				
				
				<div class="form-group">
				  <label for="totalPaid" class="col-sm-4 control-label">Total Paid: </label>
				  <div class="col-sm-8">
					<input type="text" class="form-control" id="totalPaid" name="totalPaid" placeholder="Total Amount" value="" readonly>
				  </div>
				</div>
				<div class="form-group">
				  <label for="previousPaid" class="col-sm-4 control-label">Previous Paid: </label>
				  <div class="col-sm-8">
					<input type="text" class="form-control" id="previousPaid" name="previousPaid" placeholder="Previous Amount" value="' . $paymentData['paid_amount'] . '" readonly>
				  </div>
				</div>
      		</div><!-- /div.col-md-6 -->

      		<div class="col-md-6">
			  <div class="form-group">
			  <label for="examinationFee" class="col-sm-4 control-label">Examination Fee: </label>
			  <div class="col-sm-8">
				<input type="text" class="form-control" id="examinationFee" name="examinationFee" placeholder="Examination Fee" value="' . $paymentNameData['p_examination_fee'] . '">
			  </div>
			</div>
			<!--<div class="form-group">
			  <label for="developmentFee" class="col-sm-4 control-label">Development Fee: </label>
			  <div class="col-sm-8">-->
				<input type="hidden" class="form-control" id="developmentFee" name="developmentFee" placeholder="Development Fee" value="' . $paymentNameData['p_development_fee'] . '">
			 <!--</div>
			</div>-->
			<div class="form-group">
			  <label for="tie" class="col-sm-4 control-label">Tie: </label>
			  <div class="col-sm-8">
				<input type="text" class="form-control" id="tie" name="tie" placeholder="Tie" value="' . $paymentNameData['p_tie'] . '">
			 </div>
			</div>
			<div class="form-group">
			  <label for="belt" class="col-sm-4 control-label">Belt: </label>
			  <div class="col-sm-8">
				<input type="text" class="form-control" id="belt" name="belt" placeholder="Belt" value="' . $paymentNameData['p_belt'] . '">
			 </div>
			</div>
			<div class="form-group">
			  <label for="belt" class="col-sm-4 control-label">Diary: </label>
			  <div class="col-sm-8">
				<input type="text" class="form-control" id="diary" name="diary" placeholder="Diary" value="' . $paymentNameData['p_diary'] . '">
			 </div>
			</div>
			<div class="form-group">
			  <label for="basicTransportFee" class="col-sm-4 control-label">Transport Fee: </label>
			  <div class="col-sm-8">
				<input type="text" class="form-control" id="basicTransportFee" name="basicTransportFee" placeholder="Transport Fee" value="' . $paymentNameData['transport_fee'] . '" readonly>
			  </div>
			</div>
			<div class="form-group">
			  <label for="transportFee" class="col-sm-4 control-label">Payable Transport Fee: </label>
			  <div class="col-sm-8">
				<input type="text" class="form-control" id="transportFee" name="transportFee" placeholder="Transport Fee" value="' . $paymentNameData['payabletransportfee'] . '" readonly>
			  </div>
			</div>
			
			<div class="form-group">
			  <label for="lateFine" class="col-sm-4 control-label">Late Fine: </label>
			  <div class="col-sm-8">
				<input type="text" class="form-control" id="lateFine" name="lateFine" placeholder="Late Fine" value="' . $paymentNameData['late_fine'] . '">
			  </div>
			</div>
			<div class="form-group">
			  <label for="basicMonthlyFee" class="col-sm-4 control-label">Tution Fee: </label>
			  <div class="col-sm-8">
				<input type="text" class="form-control" id="basicMonthlyFee" name="basicMonthlyFee" placeholder="Tution Fee" value="' . $paymentNameData['monthly_fee'] . '" readonly>
			  </div>
			</div>
			<div class="form-group">
			  <label for="monthlyFee" class="col-sm-4 control-label">Payable Tution Fee: </label>
			  <div class="col-sm-8">
				<input type="text" class="form-control" id="monthlyFee" name="monthlyFee" placeholder="Tution Fee" value="' . $paymentNameData['payablemonthlyfee'] . '" readonly>
			  </div>
			</div>
				 
				 <div class="form-group">
				    <label for="studentPayDate" class="col-sm-4 control-label">Payment Date: </label>
				    <div class="col-sm-8">
				      <input type="date" class="form-control" id="" name="studentPayDate" placeholder="Payment Date" value="' . $currentDate . '" readonly>
				   </div>
				  </div>
				  <div class="form-group">
				    <label for="paidAmount" class="col-sm-4 control-label">Paid Amount: </label>
				    <div class="col-sm-8">
				      <input type="text" class="form-control" id="paidAmount" name="paidAmount" placeholder="Paid Amount">
				    </div>
				  </div>
				  <div class="form-group">
				    <label for="dueAmount" class="col-sm-4 control-label">Due Amount: </label>
				    <div class="col-sm-8">
				      <input type="number" class="form-control" id="dueAmount" name="dueAmount" placeholder="Due Amount" value="' . $paymentData['due_amount'] . '" min="0"  readonly>
				    </div>
				  </div>
				  <div class="form-group">
				  <label for="discount" class="col-sm-4 control-label">Discount: </label>
				  <div class="col-sm-8">
					<input type="number" class="form-control" id="discount" name="discount" placeholder="Discount" value="' . $paymentNameData['discount'] . '" min="0">
				  </div>
				</div>
				<div class="form-group">
				    <label for="inputPassword3" class="col-sm-4 control-label">Session: </label>
				    <div class="col-sm-8">
				      <select class="form-control" name="session" id="session">
				      	<option value="2021-2022" ';
			if ($paymentData['session'] == "2021-2022") {
				$div .= "selected";
			}
			$div .= '>2021-2022</option>
				      	<option value="2022-2023" ';
			if ($paymentData['session'] == "2022-2023") {
				$div .= "selected";
			}
			$div .= '>2022-2023</option>
				      </select>
				    </div>				    
			  	  </div>			  
				  <div class="form-group">
				    <label for="inputPassword3" class="col-sm-4 control-label">Payment Type: </label>
				    <div class="col-sm-8">
				      <select class="form-control" name="paymentType" id="paymentType">
				      	<option value="" ';
			if ($paymentData['status'] == 0) {
				$div .= "selected";
			}
			$div .= '>Select</option>
				      	<option value="1" ';
			if ($paymentData['status'] == 1) {
				$div .= "selected";
			}
			$div .= '>Full Payment</option>
				      	<option value="2" ';
			if ($paymentData['status'] == 2) {
				$div .= "selected";
			}
			$div .= '>Installment</option>
				      </select>
				    </div>				    
			  	  </div>			  	  
			  	  <div class="form-group">
				    <label for="inputPassword3" class="col-sm-4 control-label">Status: </label>
				    <div class="col-sm-8">
				      <select class="form-control" name="status" id="status">
				      	<option value="">Select</option>
				      	<option value="0" ';
			if ($paymentData['status'] == 0) {
				$div .= "selected";
			}
			$div .= '>Pending</option>
				      	<option value="1" ';
			if ($paymentData['status'] == 1) {
				$div .= "selected";
			}
			$div .= '>Paid</option>
			<option value="2" ';
			if ($paymentData['status'] == 2) {
				$div .= "selected";
			}
			$div .= '>Unpaid</option>
				      	
				      </select>
				    </div>				    
			  	  </div>
      		</div><!-- /div.col-md-6 -->
      			 
			  <div class="form-group">
			    <div class="col-sm-12">
			    	<center>
			      		<button type="submit" class="btn btn-primary">Save Changes</button>
			      		<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			      	</center>
			    </div>
			  </div>
			</form>';

			echo $div;
		}
	}


	/*
	*---------------------------------------------------------------
	* Manage student's payment functions section
	* paymentId is for `payment` table
	* not for `payment_name` table
	* the paymentId will get the data from the `payment` table
	* through the `payment` table data, the function will fetch the 
	* data from the `payment_name` table  
	*---------------------------------------------------------------
	*/
	public function printStudentPaymentInfo($paymentId = null)
	{
		if ($paymentId) {
			$paymentData = $this->Model_Accounting->fetchStudentPayData($paymentId);
			$paymentNameData = $this->Model_Accounting->fetchPaymentData($paymentData['payment_name_id']);
			$classData = $this->Model_Classes->fetchClassData($paymentData['class_id']);
			$sectionData = $this->Model_Section->fetchSectionByClassSection($paymentData['class_id'], $paymentData['section_id']);
			$studentData = $this->Model_Student->fetchStudentData($paymentData['student_id']);
			$convertStartDate = date("d-m-Y", strtotime($paymentNameData['start_date']));
			$convertEndDate = date("d-m-Y", strtotime($paymentNameData['end_date']));
			$paymentDate = date("d-m-Y", strtotime($paymentData['payment_date']));

			if ($paymentData['paid_amount'] == '') {
				$totalPaid = 0;
			} else {
				$totalPaid = $paymentData['paid_amount'];
			}

			$div = '

			<div id="update-student-payment-message" class="wrapper"></div>

			<form class="form-horizontal" action="accounting/updateStudentPay" method="post" id="updateStudentPayForm">
			
			
			<img src="assets/images/admissionslip.png" style="display: block;margin-left: auto;margin-right: auto;"/>
			<h4 style=" text-align:center; font-weight:bold; margin-left:320px; box-sizing: content-box;  
			width: 150px;
			height: 20px;
			padding: 5px;  
			border: 1px solid black; border-radius:5px;">MONTHLY FEE</h4>


			<div class="col-md-12">
				
			<table border="0"> 
			<tr> 
			<td></td> 
			<td ><b style="padding-left:150px;">Date </b>&nbsp;&nbsp;  ' . $paymentDate . '</td> 
			
		</tr> 
		 <tr> 
			 <td><b>Name of the Student </b>&nbsp;&nbsp;  ' . $studentData['student_name'] . '</td> 
			 <td><b style="margin-left:150px;">Father&#39;s Name </b>&nbsp;&nbsp;  ' . $studentData['father_name'] . '</td> 
			 
		 </tr> 
		 <tr> 
		 <td><b>Class </b>&nbsp;&nbsp;  ' . $classData['class_name'] . '</td> 
		 <td><b style="margin-left:150px;">Roll No </b>&nbsp;&nbsp;  ' . $studentData['rollno'] . '</td> 
		 
	 </tr> 
	 <tr> 
	 <td><b>For the month of </b>&nbsp;&nbsp; ' . $convertStartDate . ' to ' . $convertEndDate . '</td> 
	 <td></td> 
	 
 </tr> 

	 </table> 
		<br/>	    
	 <table border="2"> 
	 <tr> 
	 <th style="text-align:center;padding:0px 100px;">Description of Fees</th>
	 <th style="text-align:center;padding:0px 150px;">Amount</th> 	 
 </tr>
	 <tr> 
	 <td > <b>&nbsp; &#9830; Tutition Fee</b></td> 
	 <td style="text-align:center;"> Rs. ' . $paymentNameData['monthly_fee'] . ' </td> 
	 
 </tr>
<tr>
<td> <b>&nbsp; &#9830; Transport Fee</b></td> 
<td style="text-align:center;"> Rs. ' . $paymentNameData['transport_fee'] . ' </td> 
</tr> 
<tr> 
<td > <b>&nbsp; &#9830; Late Fine</b></td> 
<td style="text-align:center;"> Rs.' . $paymentNameData['late_fine'] . ' </td> 
</tr> 
<tr>';

			if ($paymentNameData['p_examination_fee'] != 0) {
				$div .= '<td > <b>&nbsp; &#9830; Examination Fee</b></td> 
				<td style="text-align:center;"> Rs.' . $paymentNameData['p_examination_fee'] . ' </td> 
				</tr>';
			}
			if ($paymentNameData['p_tie'] != 0) {
				$div .= '<tr> 
				<td > <b>&nbsp; &#9830; Tie</b></td> 
				<td style="text-align:center;"> Rs.' . $paymentNameData['p_tie'] . ' </td> 
				</tr> ';
			}
			if ($paymentNameData['p_belt'] != 0) {
				$div .= '<tr> 
				<td > <b>&nbsp; &#9830; Belt</b></td> 
				<td style="text-align:center;"> Rs.' . $paymentNameData['p_belt'] . ' </td> 
			    </tr>';
			}
			if ($paymentNameData['p_belt'] != 0) {
				$div .= '<tr> 
				<td > <b>&nbsp; &#9830; Diary</b></td> 
				<td style="text-align:center;"> Rs.' . $paymentNameData['p_diary'] . ' </td> 
				</tr> ';
			}
			$div .= '</table>
			<br/>
			<table border="0"> 
			<tr> 
			<td><b>Total Payable Amount</b>&nbsp;&nbsp; Rs.' . $paymentNameData['total_payableamount'] . '</td>
			<td></td>
			</tr> 
			<tr> 
			<td><b>Total Paid Amount</b>&nbsp;&nbsp; Rs.' . $paymentData['paid_amount'] . '</td>
			</tr> 
			<tr> 
			<td><b>Current Paid Amount</b>&nbsp;&nbsp; Rs.' . $paymentData['current_paid_amount'] . '</td>
			</tr> 
			<tr> 
			<td><b>Due Amount</b>&nbsp;&nbsp; Rs.' . $paymentData['due_amount'] . '</td>
			<td ><b style="margin-left:300px;">Signature</b></td>
			</tr>
			</table>
			</div><!-- /div.col-md-6 -->	 
			  <div class="form-group">   
			  </div>
			</form>';
			echo $div;
		}
	}


	/*
	*---------------------------------------------------------------
	* update student's payment info section
	* paymentId for `payment` table
	*---------------------------------------------------------------
	*/
	public function updateStudentPay($paymentId = null)
	{
		if ($paymentId) {
			$validator = array('success' => false, 'messages' => array());

			$validate_data = array(
				array(
					'field' => 'studentPayDate',
					'label' => 'Payment Date',
					'rules' => 'required'
				),
				array(
					'field' => 'paidAmount',
					'label' => 'Paid Amount',
					'rules' => 'required'
				),
				array(
					'field' => 'paymentType',
					'label' => 'Payment Type',
					'rules' => 'required'
				),
				array(
					'field' => 'status',
					'label' => 'Status',
					'rules' => 'required'
				)
			);

			$this->form_validation->set_rules($validate_data);
			$this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>');

			if ($this->form_validation->run() === true) {
				$create = $this->Model_Accounting->updateStudentPay($paymentId);
				if ($create === true) {
					$validator['success'] = true;
					$studentInfo = $this->Model_Admission->fetchStudentData($this->input->post('studentId'));
					// 	if ($studentInfo['f_phone']) {
					// 		$message = 'Hello, Fee for ' . $studentInfo['student_name'] . ' Rs. ' . $this->input->post('paidAmount') . ' has been submitted. Warm regards bskd public';
					// 		$mobileno = $studentInfo['f_phone'];
					// 		$ch = curl_init('https://www.txtguru.in/imobile/api.php?');
					// 		curl_setopt($ch, CURLOPT_POST, 1);
					// 		curl_setopt($ch, CURLOPT_POSTFIELDS, "username=shubhamkumarsrt.rock&password=10007997&source=BSKD&dmobile=918409813443,91" . $mobileno . "&dlttempid=templated_id&message=" . $message . "");
					// 		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
					// 		$data = curl_exec($ch);
					// 	}
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
	*---------------------------------------------------------------
	* update student's payment info section
	* paymentId for `payment` table
	*---------------------------------------------------------------
	*/
	public function printStudentPay($paymentId = null)
	{
		if ($paymentId) {
			$validator = array('success' => false, 'messages' => array());

			$validate_data = array(
				array(
					'field' => 'studentPayDate',
					'label' => 'Payment Date',
					'rules' => 'required'
				),
				array(
					'field' => 'paidAmount',
					'label' => 'Paid Amount',
					'rules' => 'required'
				),
				array(
					'field' => 'paymentType',
					'label' => 'Payment Type',
					'rules' => 'required'
				),
				array(
					'field' => 'status',
					'label' => 'Status',
					'rules' => 'required'
				)
			);

			$this->form_validation->set_rules($validate_data);
			$this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>');

			if ($this->form_validation->run() === true) {
				$create = $this->Model_Accounting->printStudentPay($paymentId);
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
	}

	/*
	*---------------------------------------------------------------	
	* paymentId is for `payment` table 
	*---------------------------------------------------------------
	*/
	public function removeStudentPay($paymentId = null)
	{
		if ($paymentId) {
			$validator = array('success' => false, 'messages' => array());

			$remove = $this->Model_Accounting->removeStudentPay($paymentId);
			if ($remove === true) {
				$validator['success'] = true;
				$validator['messages'] = 'Successfully Removed';
			} else {
				$validator['success'] = false;
				$validator['messages'] = 'Error while removing';
			}

			echo json_encode($validator);
		}
	}



	/*
	*---------------------------------------------------------------	
	* MANAGE EXPENSES FUNCTION
	*---------------------------------------------------------------
	*/

	/*
	*---------------------------------------------------------------	
	* add expenses function
	*---------------------------------------------------------------
	*/
	public function createExpenses()
	{
		$validator = array('success' => false, 'messages' => array());

		$expname = $this->input->post('subExpensesName');
		if (!empty($expname)) {
			foreach ($expname as $key => $value) {
				$this->form_validation->set_rules('subExpensesName[' . $key . ']', 'Expenses Name', 'required');
			}
		}

		$expamount = $this->input->post('subExpensesAmount');
		if (!empty($expamount)) {
			foreach ($expamount as $key => $value) {
				$this->form_validation->set_rules('subExpensesAmount[' . $key . ']', 'Total Amount', 'required');
			}
		}

		$validate_data = array(
			array(
				'field' => 'expensesDate',
				'label' => 'Expenses Date',
				'rules' => 'required'
			),
			array(
				'field' => 'expensesName',
				'label' => 'Expenses Name',
				'rules' => 'required'
			)
		);

		$this->form_validation->set_rules($validate_data);
		$this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>');

		if ($this->form_validation->run() === true) {
			$create = $this->Model_Accounting->createExpenses();
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
				if ($key == 'subExpensesName') {
					foreach ($value as $number => $data) {
						$validator['messages']['subExpensesName' . $number] = form_error('subExpensesName[' . $number . ']');
					} // /.foreach 
				} // /.if
				else if ($key == 'subExpensesAmount') {
					foreach ($value as $number => $data) {
						$validator['messages']['subExpensesAmount' . $number] = form_error('subExpensesAmount[' . $number . ']');
					} // /.foreach
				} else {
					$validator['messages'][$key] = form_error($key);
				} // /.				
			} // /.foreach			
		} // /else

		echo json_encode($validator);
	}

	/*
	*---------------------------------------------------------------	
	* fetches the expenses data from the `expenses_name` and 
	* `expenses` table function
	*---------------------------------------------------------------
	*/
	public function fetchExpensesData()
	{
		$expensesData = $this->Model_Accounting->fetchExpensesNameData();


		$result = array('data' => array());
		foreach ($expensesData as $key => $value) {

			$totalExpensesItem = $this->Model_Accounting->countTotalExpensesItem($value['id']);

			$button = '
			<div class="btn-group">
			  <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
			    Action <span class="caret"></span>
			  </button>
			  <ul class="dropdown-menu">
			    <li><a href="#" data-toggle="modal" data-target="#edit-expenses-modal" onclick="updateExpenses(' . $value['id'] . ')">Edit</a></li>
			    <!--<li><a href="#" data-toggle="modal" data-target="#removeExpensesModal" onclick="removeExpenses(' . $value['id'] . ')">Remove</a></li>  -->
			  </ul>
			</div>';

			$result['data'][$key] = array(
				$value['name'],
				$value['date'],
				$totalExpensesItem,
				$value['total_amount'],
				$button
			);
		}

		echo json_encode($result);
	}

	/*
	*---------------------------------------------------------------
	* fetches the expenses data from the database function
	*---------------------------------------------------------------
	*/
	public function fetchExpensesDataForUpdate($id = null)
	{
		if ($id) {

			$expenseNameData = $this->Model_Accounting->fetchExpensesNameData($id);
			$expensesItemData = $this->Model_Accounting->fetchExpensesItemData($id);

			$table = '<div class="form-group">
          <label for="editExpensesDate" class="col-sm-3 control-label">Expenses Date:</label>
          <div class="col-sm-9">
            <input type="text" class="form-control" id="editExpensesDate" name="editExpensesDate" placeholder="Expenses Date" value="' . $expenseNameData['date'] . '" />
          </div>
        </div>
        <div class="form-group">
          <label for="editExpensesName" class="col-sm-3 control-label">Expenses Name:</label>
          <div class="col-sm-9">
            <input type="text" class="form-control" id="editExpensesName" name="editExpensesName" placeholder="Expenses Name" value="' . $expenseNameData['name'] . '" />
          </div>
        </div>
        <div class="form-group">
          <label for="editTotalAmount" class="col-sm-3 control-label">Total Amount:</label>
          <div class="col-sm-9">
            <input type="text" class="form-control" id="editTotalAmount" name="editTotalAmount" placeholder="Total Amount"  value="' . $expenseNameData['total_amount'] . '"/>
            <input type="hidden" class="form-control" id="editTotalAmountValue" name="editTotalAmountValue" value="' . $expenseNameData['total_amount'] . '" />
          </div>
        </div>
        <table class="table table-bordered" id="editSubExpensesTable">
        <thead>
          <tr>
            <th>Name</th>
            <th>Amount</th>
            <th style="width:10%;">Action</th>
          </tr>
        </thead>
        <tbody>';
			$x = 1;
			foreach ($expensesItemData as $key => $value) {
				$table .= '<tr id="row' . $x . '">
		            <td class="form-group">
		            <input type="text" class="form-control" name="editSubExpensesName[' . $x . ']" id="editSubExpensesName' . $x . '" placeholder="Expenses Name" value="' . $value['expenses_name'] . '"/>
		            </td>
		            <td class="form-group">
		            <input type="text" class="form-control" name="editSubExpensesAmount[' . $x . ']" id="editSubExpensesAmount' . $x . '" onkeyup="editCalculateTotalAmount()" placeholder="Expenses Amount" value="' . $value['expenses_amount'] . '" />
		            </td>
		            <td>
		            <button type="button" class="btn btn-default" onclick="removeEditExpensesRow(' . $x . ')"><i class="glyphicon glyphicon-remove"></i></button>
		            </td>
		          </tr>';
				$x++;
			} // /.foreach          
			$table .= '</tbody>
	    </table>';

			echo $table;
		}
	}

	/*
	*---------------------------------------------------------------
	* update the expenses function
	*---------------------------------------------------------------
	*/
	public function updateExpenses($id = null)
	{
		if ($id) {

			$validator = array('success' => false, 'messages' => array());

			$expname = $this->input->post('editSubExpensesName');
			if (!empty($expname)) {
				foreach ($expname as $key => $value) {
					$this->form_validation->set_rules('editSubExpensesName[' . $key . ']', 'Expenses Name', 'required');
				}
			}

			$expamount = $this->input->post('editSubExpensesAmount');
			if (!empty($expamount)) {
				foreach ($expamount as $key => $value) {
					$this->form_validation->set_rules('editSubExpensesAmount[' . $key . ']', 'Total Amount', 'required');
				}
			}

			$validate_data = array(
				array(
					'field' => 'editExpensesDate',
					'label' => 'Expenses Date',
					'rules' => 'required'
				),
				array(
					'field' => 'editExpensesName',
					'label' => 'Expenses Name',
					'rules' => 'required'
				)
			);

			$this->form_validation->set_rules($validate_data);
			$this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>');

			if ($this->form_validation->run() === true) {
				$create = $this->Model_Accounting->updateExpenses($id);
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
					if ($key == 'editSubExpensesName') {
						foreach ($value as $number => $data) {
							$validator['messages']['editSubExpensesName' . $number] = form_error('editSubExpensesName[' . $number . ']');
						} // /.foreach 
					} // /.if
					else if ($key == 'editSubExpensesAmount') {
						foreach ($value as $number => $data) {
							$validator['messages']['editSubExpensesAmount' . $number] = form_error('editSubExpensesAmount[' . $number . ']');
						} // /.foreach
					} else {
						$validator['messages'][$key] = form_error($key);
					} // /.				
				} // /.foreach			
			} // /else

			echo json_encode($validator);
		}
	}


	/*
	*---------------------------------------------------------------
	* remove the expenses info from the database
	*---------------------------------------------------------------
	*/
	public function removeExpenses($id = null)
	{
		if ($id) {
			$validator = array('success' => false, 'messages' => array());

			$remove = $this->Model_Accounting->removeExpenses($id);
			if ($remove === true) {
				$validator['success'] = true;
				$validator['messages'] = 'Successfully Removed';
			} else {
				$validator['success'] = false;
				$validator['messages'] = 'Error while removing';
			}

			echo json_encode($validator);
		}
	}



	/*
	*------------------------------------------------------------------
	* fetch the income data for datatables  
	*------------------------------------------------------------------
	*/
	public function fetchIncomeData($date = null)
	{
		$fetchData = $this->Model_Accounting->fetchIncomeData($date);
		$result = array('data' => array());
		$x = 1;
		foreach ($fetchData as $key => $value) {
			$paymentData = $this->Model_Accounting->fetchStudentPayDataByPaymentNameId($value['paymentNameID']);
			$fetchPaymentNameData = $this->Model_Accounting->fetchPaymentData($paymentData['payment_name_id']);
			$classData = $this->Model_Classes->fetchClassData($paymentData['class_id']);
			$sectionData = $this->Model_Section->fetchSectionByClassSection($paymentData['class_id'], $paymentData['section_id']);
			$studentData = $this->Model_Student->fetchStudentData($paymentData['student_id']);
			if ($studentData) {
				$studentName = $studentData['student_name'];
			} elseif (!$studentData) {
				$studentName = '';
			}

			$button = '<button class="btn btn-primary" data-toggle="modal" data-target="#viewIncomeModal" onclick="viewIncome(' . $paymentData['payment_id'] . ')">View</button>';

			$result['data'][$key] = array(
				$x,
				$fetchPaymentNameData['name'],
				$studentName,
				$classData['class_name'],
				$sectionData['section_name'],
				$fetchPaymentNameData['total_amount'],
				$value['currentPaidAmount'],
				$value['currentPaidDate'],
				$button
			);

			$x++;
		}
		echo json_encode($result);
	}

	public function fetchTotalByDate($date = null)
	{
		$total = $this->Model_Accounting->totalIncomeByDate($date);
		echo ($total);
	}

	/*
	*------------------------------------------------------------------
	* view the payment information function
	* `payment_id` is from `payment` table
	* not from `payment_name` table 
	*------------------------------------------------------------------
	*/
	public function viewIncomeDetail($paymentId = null)
	{
		if ($paymentId) {
			$paymentData = $this->Model_Accounting->fetchStudentPayData($paymentId);
			$paymentNameData = $this->Model_Accounting->fetchPaymentData($paymentData['payment_name_id']);
			$classData = $this->Model_Classes->fetchClassData($paymentData['class_id']);
			$sectionData = $this->Model_Section->fetchSectionByClassSection($paymentData['class_id'], $paymentData['section_id']);
			$studentData = $this->Model_Student->fetchStudentData($paymentData['student_id']);

			$data = '<table class="table table-bordered table-responsive table-striped">
			<tbody>
				<tr>
					<th>Payment Name : </th>
					<td>' . $paymentNameData['name'] . '</td>
				</tr>
				<tr>
					<th>Total Amount : </th>
					<td>' . $paymentNameData['total_amount'] . '</td>
				</tr>
				<tr>
					<th>Total Paid Amount : </th>
					<td>' . $paymentData['paid_amount'] . '</td>
				</tr>
				<tr>
					<th>Payment Date : </th>
					<td>' . $paymentData['payment_date'] . '</td>
				</tr>
				<tr>
					<th>Class : </th>
					<td>' . $classData['class_name'] . '</td>
				</tr>
				<tr>
					<th>Section Date : </th>
					<td>' . $sectionData['section_name'] . '</td>
				</tr>
				<tr>
					<th>Student Name : </th>
					<td>' . $studentData['student_name'] . '</td>
				</tr>
				<tr>
					<th>Father&#39;s Name : </th>
					<td>' . $studentData['father_name'] . '</td>
				</tr>
				<tr>
					<th>Mother&#39;s Name : </th>
					<td>' . $studentData['mother_name'] . '</td>
				</tr>
			</tbody>
			</table>';
			echo $data;
		}
	}
}
