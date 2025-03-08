<?php

class PrintAdmissionSlip extends MY_Controller
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
		//load model admission
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

		$div = '<form class="form-horizontal" action="PrintAdmissionSlip/createIndividual" method="post" id="createIndividualForm">	    	
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
		    	<label for="studentName" class="col-sm-2 control-label">Name of the Student</label>
		    	<div class="col-sm-10">
		      		<select class="form-control" name="studentName" id="studentName">
		      			<option value="">Select Class & Section</option>
		      		</select>
		    	</div>
              </div>
              <div class="form-group">
		    	<label for="fatherName" class="col-sm-2 control-label">Father&#39;s Name</label>
		    	<div class="col-sm-10">
		      		<select class="form-control" name="fatherName" id="fatherName">
		      			<option value="">Select Class & Section</option>
		      		</select>
		    	</div>
              </div>
              <div class="form-group">
		    	<label for="gaurdianName" class="col-sm-2 control-label">Gaurdian&#39;s Name</label>
		    	<div class="col-sm-10">
		      		<select class="form-control" name="gaurdianName" id="gaurdianName">
		      			<option value="">Select Class & Section</option>
		      		</select>
		    	</div>
              </div>
              <div class="form-group">
		    	<label for="address" class="col-sm-2 control-label">Address</label>
		    	<div class="col-sm-10">
		      		<select class="form-control" name="address" id="address">
		      			<option value="">Select Class & Section</option>
		      		</select>
		    	</div>
		  	</div>
		  	<div class="form-group">
			  <label for="regNo" class="col-sm-2 control-label">Reg. No</label>
			  <div class="col-sm-10">
					<select class="form-control" name="regNo" id="regNo">
						<option value="">Select Class & Section</option>
					</select>
			  </div>
			</div>
              <div class="form-group">
		    	<label for="category" class="col-sm-2 control-label">Category</label>
		    	<div class="col-sm-10">
		      		<select class="form-control" name="category" id="category">
		      			<option value="">Select Class & Section</option>
		      		</select>
		    	</div>
              </div>
              <div class="form-group">
		    	<label for="session" class="col-sm-2 control-label">Session</label>
		    	<div class="col-sm-10">
		      		<select class="form-control" name="session" id="session">
		      			<option value="2021-2022">2021-2022</option>
		      			<option value="2022-2023">2022-2023</option>
		      		</select>
		    	</div>
			  </div>
			  <div class="form-group">
			  <label for="bplNo" class="col-sm-2 control-label">BPL No</label>
			  <div class="col-sm-10">
			  <select class="form-control" name="bplNo" id="bplNo">
			  <option value="">Select Student Name</option>
		      </select>
			  </div>
			</div>
              <div class="form-group">
		    	<label for="admissionFee" class="col-sm-2 control-label">Admission Fee</label>
		    	<div class="col-sm-10">
		      		<input type="text" class="form-control" id="admissionFee" name="admissionFee" value="1000" placeholder="1000" >
		    	</div>
			  </div>
			  <div class="form-group">
		    	<label for="transportFee" class="col-sm-2 control-label">Transport</label>
		    	<div class="col-sm-10">
		      		<input type="text" class="form-control" id="transportFee" name="transportFee" placeholder="Transport Fee">
		    	</div>
			  </div>
			  <div class="form-group">
		    	<label for="monthlyFee" class="col-sm-2 control-label">Monthly Fee</label>
		    	<div class="col-sm-10">
		      		<select class="form-control" name="monthlyFee" id="monthlyFee">
		      			<option type="text" value="">Select Student Name</option>
					  </select>	  
		    	</div>
		  	</div>
			  <div class="form-group">
			<label for="duration" class="col-sm-2 control-label"><span style="color:red;">*</span> Duration</label>
			<div class="col-sm-10">
				  <input type="number" class="form-control" id="duration" name="duration" placeholder="Duration" Autocomplete="off" min="1" max="12" required>
			</div>
		  </div>
			  <div class="form-group">
			  <label for="monthlyFeesStartDate" class="col-sm-2 control-label"><span style="color:red;">*</span> Monthly Fee From</label>
			  <div class="col-sm-10">
					<input type="date" class="form-control" id="startDate" name="monthlyFeesStartDate" placeholder="Start Date" Autocomplete="off">
			  </div>
			</div>
			
			<div class="form-group">
			  <label for="monthlyFeesEndDate" class="col-sm-2 control-label"><span style="color:red;">*</span> Monthly Fee To</label>
			  <div class="col-sm-10">
					<input type="date" class="form-control" id="endDate" name="monthlyFeesEndDate" placeholder="End Date" Autocomplete="off">
			  </div>
			</div>
			<div class="form-group">
		    	<label for="payableMonthlyFee" class="col-sm-2 control-label">Payable Monthly Fee</label>
		    	<div class="col-sm-10">
		      		<input type="text" class="form-control" id="payableMonthlyFee" name="payableMonthlyFee" value="" placeholder="Payable Monthly Fee" >
		    	</div>
			  </div>	
			  <div class="form-group">
		    	<label for="payableTransportFee" class="col-sm-2 control-label">Payable Transport Fee</label>
		    	<div class="col-sm-10">
		      		<input type="text" class="form-control" id="payableTransportFee" name="payableTransportFee" value="" placeholder="Payable Transport Fee" readonly>
		    	</div>
		  	</div>	
			  <div class="form-group">
			  <label for="monthlyFee" class="col-sm-2 control-label">Development Fee</label>
			  <div class="col-sm-10">
					<select class="form-control" name="developmentFee" id="developmentFee">
						<option type="text" value="">Select Student Name</option>
					</select>	  
			  </div>
			</div>
		<div class="form-group">
		  <label for="examFee" class="col-sm-2 control-label">Extra Activities</label>
		  <div class="col-sm-10">
				<select class="form-control" name="extraActivities" id="extraActivities">
					<option type="text" value="">Select Student Name</option>
				</select>	  
		  </div>
		</div>
		<div class="form-group">
		  <label for="tie" class="col-sm-2 control-label">Tie</label>
		  <div class="col-sm-10">
		  <input type="text" class="form-control" id="tie" name="tie" value="100" placeholder="100">	  
		  </div>
		</div>
		<div class="form-group">
		  <label for="belt" class="col-sm-2 control-label">Belt</label>
		  <div class="col-sm-10">
		  <input type="text" class="form-control" id="belt" name="belt" value="100" placeholder="100">	  
		  </div>
		</div>
		<div class="form-group">
		  <label for="diary" class="col-sm-2 control-label">Diary</label>
		  <div class="col-sm-10">
		  <input type="text" class="form-control" id="diary" name="diary" value="100" placeholder="100">	  	  
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
	public function fetchStudent($classId = null, $sectionId = null, $type = null)
	{
		if ($classId && $sectionId && $type) {

			$studentData = $this->Model_Student->fetchStudentByClassAndSection($classId, $sectionId);

			if ($type == 1 || $type == 2) {
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
			}
			echo $option;
		}
	}

	/*
	*------------------------------------------------
	* fetches the father info by class and section 
	*------------------------------------------------
	*/


	public function fetchStudentData($studentId = null, $classId = null, $sectionId = null, $type = null, $dataKey = null)
	{
		if ($studentId && $classId && $sectionId && $type && $dataKey) {

			$studentData = $this->Model_Student->fetchFatherByClassAndSection($studentId, $classId, $sectionId);

			if ($type == 1 || $type == 2) {
				// /.individual
				if ($studentData) {
					$option = '';
					foreach ($studentData as $key => $value) {
						$resultValue = $value[$dataKey];
						$option .= '<option value="' . $resultValue . '">' . $resultValue . '</option>';
					} // /foreach
				} else {
					$option = '<option value="">No Data</option>';
				} // /else empty section
			}
			echo $option;
		}
	}

	public function fetchRegNo($studentId = null, $classId = null, $sectionId = null, $type = null)
	{
		if ($studentId && $classId && $sectionId && $type) {

			$regNoData = $this->Model_Student->fetchFatherByClassAndSection($studentId, $classId, $sectionId);

			if ($type == 1 || $type == 2) {
				// /.individual
				if ($regNoData) {
					$option = '';
					foreach ($regNoData as $key => $value) {
						$regNo = $value['admssion_no'];
						$option .= '<option value="' . $regNo . '">PCA00' . $regNo . '</option>';
					} // /foreach
				} else {
					$option = '<option value="">No Data</option>';
				} // /else empty section
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

	/*
	*------------------------------------------------
	* fetches the bplno info by class and section 
	*------------------------------------------------
	*/


	public function fetchbplno($studentId = null, $classId = null, $sectionId = null, $type = null)
	{
		if ($studentId && $classId && $sectionId && $type) {
			$fatherData = $this->Model_Student->fetchFatherByClassAndSection($studentId, $classId, $sectionId);
			if ($type == 1 || $type == 2) {
				// /.individual
				if ($fatherData) {
					$option = '';
					foreach ($fatherData as $key => $value) {
						$fatherName = $value['bpl_no'];
						$option .= '<option value="' . $value['student_id'] . '">' . $fatherName . '</option>';
					} // /foreach
				} else {
					$option = '<option value="">No Data</option>';
				} // /else empty section
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
						$category = $value['class_monthly_fee'];

						$option .= '<option value="' . $value['class_monthly_fee'] . '">' . $category . '</option>
						            <option value="0">0</option>';
					} // /foreach
				} else {
					$option = '<option value="">No Data</option>';
				} // /else empty section
			} else if ($type == 2) {
				$option .= '';
			}

			echo $option;
		}
	}

	public function fetchFeeData($studentId = null, $classId = null, $sectionId = null, $type = null, $feeType = null)
	{
		if ($studentId && $classId && $sectionId && $type && $feeType) {

			$categoryData = $this->Model_Student->fetchMonthlyFeeByClassId($classId);

			if ($type == 1) {
				// /.individual
				if ($categoryData) {
					$option = '';
					foreach ($categoryData as $key => $value) {
						$feeData = $value[$feeType];

						$option .= '<option value="' . $feeData . '">' . $feeData . '</option>
						            <option value="0">0</option>';
					} // /foreach
				} else {
					$option = '<option value="">No Data</option>';
				} // /else empty section
			} else if ($type == 2) {
				$option .= '';
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
			),
			array(
				'field' => 'regNo',
				'label' => 'Reg. No',
				'rules' => 'required|is_unique[payment_name.reg_no]'
			),
			array(
				'field' => 'monthlyFeesStartDate',
				'label' => 'Monthly Fee From',
				'rules' => 'required'
			),
			array(
				'field' => 'monthlyFeesEndDate',
				'label' => 'Monthly Fee To',
				'rules' => 'required'
			),
			array(
				'field' => 'transportFee',
				'label' => 'Transport Fee',
				'rules' => 'numeric'
			)

		);

		$this->form_validation->set_message('required', '%s is required');
		$this->form_validation->set_message('is_unique', '%s must be unique');
		$this->form_validation->set_rules($validate_data);
		$this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>');

		if ($this->form_validation->run() === true) {
			$create = $this->Model_PrintAdmissionSlip->createIndividual();
			if ($create === true) {
				$validator['success'] = true;
				$studentInfo = $this->Model_Admission->fetchStudentData($this->input->post('studentName'));
				// if ($studentInfo) {
				// 	$message = 'Admission of ' . $studentInfo['student_name'] . ' has been successful. Warm regards bskd public';
				// 	$mobileno = $studentInfo['f_phone'];
				// 	$ch = curl_init('https://www.txtguru.in/imobile/api.php?');
				// 	curl_setopt($ch, CURLOPT_POST, 1);
				// 	curl_setopt($ch, CURLOPT_POSTFIELDS, "username=shubhamkumarsrt.rock&password=10007997&source=BSKD&dmobile=918409813443,91" . $mobileno . "&dlttempid=templated_id&message=" . $message . "");
				// 	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
				// 	$data = curl_exec($ch);
				// }
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
		$paymentData = $this->Model_PrintAdmissionSlip->fetchStudentPayData();

		$result = array('data' => array());
		foreach ($paymentData as $key => $value) {
			$classData = $this->Model_Classes->fetchClassData($value['class_id']);
			$sectionData = $this->Model_Section->fetchSectionByClassSection($value['class_id'], $value['section_id']);
			$studentData = $this->Model_Student->fetchStudentData($value['student_id']);
			$paymentNameData = $this->Model_PrintAdmissionSlip->fetchPaymentData($value['payment_name_id']);
			$paymentDataById = $this->Model_PrintAdmissionSlip->fetchStudentPayData($value['payment_id']);
			$convertStartDate = date("d-m-Y", strtotime($paymentNameData['start_date']));
			$convertEndDate = date("d-m-Y", strtotime($paymentNameData['end_date']));
			if ($studentData) {
				$studentName = $studentData['student_name'];
			} elseif (!$studentData) {
				$studentName = '';
			}
			$status = '';

			if ($value['status'] == 0) {
				$status = '<label class="label label-info">pending</label>';
			} else if ($value['status'] == 1) {
				$status = '<label class="label label-success">Paid</label>';
			} else if ($value['status'] == 2) {
				$status = '<label class="label label-danger">Unpaid</label>';
			}
			$userlevel = $this->session->userdata('user_level');
			if ($userlevel == 2) {
				if ($value['due_amount'] != 0) {
					$button = '
					<div class="btn-group">
					  <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						Action <span class="caret"></span>
					  </button>
					  <ul class="dropdown-menu">			  				  	
						<li><a href="#" data-toggle="modal" data-target="#updateStudentPayment" onclick="updateStudentPayment(' . $value['payment_id'] . ')">Edit Payment</a></li>
					  </ul>
					</div>';
				} else {
					$button = '';
				}
			} else if ($userlevel == 1) {
				$button = '
				<div class="btn-group">
				  <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					Action <span class="caret"></span>
				  </button>
				  <ul class="dropdown-menu">			  				  	
					<li><a href="#" data-toggle="modal" data-target="#updateStudentPayment" onclick="updateStudentPayment(' . $value['payment_id'] . ')">Edit Payment</a></li>
					<li><a href="#" data-toggle="modal" data-target="#updateStudentStatus" onclick="updateStudentStatus(' . $value['payment_id'] . ')">Student Status</a></li>
					<li><a href="#" data-toggle="modal" data-target="#removeStudentPay" onclick="removeStudentPay(' . $value['payment_name_id'] . ')">Remove</a></li>
					</ul>
				</div>';
			}

			$printbutton = '
			<div class="btn-group">
			<button class="btn btn-primary" data-toggle="modal" data-target="#editStudentPay" onclick="updateStudentPay(' . $value['payment_id'] . ')">Preview</button>
			</div>';

			//Student Status
			if ($value['st_status'] == 0) {
				$st_status = '<label class="label label-success">Yes</label>';
			} elseif ($value['st_status'] == 1) {
				$st_status = '<label class="label label-danger">No</label>';
			}

			$result['data'][$key] = array(
				$paymentNameData['name'],
				$studentName,
				$classData['class_name'],
				$sectionData['section_name'],
				$convertStartDate,
				$convertEndDate,
				$status,
				$st_status,
				$paymentDataById['due_amount'],
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
			$paymentData = $this->Model_PrintAdmissionSlip->fetchStudentPayData($paymentId);
			$paymentNameData = $this->Model_PrintAdmissionSlip->fetchPaymentData($paymentData['payment_name_id']);
			$classData = $this->Model_Classes->fetchClassData($paymentData['class_id']);
			$sectionData = $this->Model_Section->fetchSectionByClassSection($paymentData['class_id'], $paymentData['section_id']);
			$studentData = $this->Model_Student->fetchStudentData($paymentData['student_id']);
			$convertStartDate = date("d-m-Y", strtotime($paymentNameData['start_date']));
			$convertEndDate = date("d-m-Y", strtotime($paymentNameData['end_date']));
			if ($paymentData['paid_amount'] == '') {
				$totalPaid = 0;
			} else {
				$totalPaid = $paymentData['paid_amount'];
			}

			$div = '

			<div id="update-student-payment-message" class="wrapper"></div>

			<form class="form-horizontal" action="accounting/updateStudentPay" method="post" id="updateStudentPayForm">
			
			
			<img src="assets/images/admissionslip.png" style="margin-left:auto; margin-right:auto; display:block;"/>
			<h4 style=" text-align:center; font-weight:bold; margin-left:auto; margin-right:auto; box-sizing: content-box;  
			width: 150px;
			height: 20px;
			padding: 5px;  
			border: 1px solid black; border-radius:5px;">ADMISSION SLIP</h4>


			<div class="col-md-12">
				
			<table border="0"> 
		 
		 <tr> 
			 <td><b>Name of the Student </b>&nbsp;&nbsp;  ' . $studentData['student_name'] . '</td> 
			 <td ><b style="padding-left:50px;">Class </b>&nbsp;&nbsp;  ' . $classData['class_name'] . '</td> 
			 
		 </tr> 
		 <tr> 
		 <td><b>Father&#39;s Name </b>&nbsp;&nbsp;  ' . $studentData['father_name'] . '</td> 
		 <td><b style="margin-left:50px;">Reg. No. </b>&nbsp;&nbsp;  ' . $paymentNameData['reg_no'] . '</td> 
		 
	 </tr> 
	 <tr> 
	 <td><b>Gaurdian&#39;s Name  </b>&nbsp;&nbsp;  ' . $studentData['gd_name'] . '</td> 
	 <td><b style="margin-left:50px;">Category</b>&nbsp;&nbsp;  ' . $studentData['category'] . '</td> 
	 
 </tr> 
 <tr> 
 <td><b>Address </b>&nbsp;&nbsp;  ' . $studentData['p_address'] . '</td> 
 <td><b style="margin-left:50px;">Session</b>&nbsp;&nbsp;' . $paymentData['session'] . '</td> 
 
</tr>
	 </table> 
			    
	 <h5><u><b><i>Description</i></b></u></h5>
	 <h5><b>Admission Fee</b> Rs. ' . $paymentNameData['admission_fee'] . '</h5>
	 
 <h5><b>Monthly Fee for the month of </b>' . $convertStartDate . ' to ' . $convertEndDate . '</h5>
 <h5><b>Monthly Fee </b> Rs. ' . $paymentNameData['monthly_fee'] . ' &nbsp;&nbsp;&nbsp;&nbsp;<b> Payable Monthly Fee </b> Rs. ' . $paymentNameData['payablemonthlyfee'] . '</h5> 
 <h5><b>Transport Fee </b> Rs. ' . $paymentNameData['transport_fee'] . ' &nbsp;&nbsp;&nbsp;&nbsp; <b> Payable Transport Fee </b> Rs. ' . $paymentNameData['payabletransportfee'] . '</h5>
 <h5><b>Development Fee</b> Rs. ' . $paymentNameData['p_development_fee'] . '&nbsp;&nbsp;&nbsp;&nbsp; <b> Extra Activities </b> Rs. ' . $paymentNameData['p_extra_activites'] . '</h5>
 <h5><b>Tie</b> Rs. ' . $paymentNameData['p_tie'] . '&nbsp;&nbsp;&nbsp;&nbsp; <b> Belt </b> Rs. ' . $paymentNameData['p_belt'] . '&nbsp;&nbsp;&nbsp;&nbsp;<b>Diary</b> Rs. ' . $paymentNameData['p_diary'] . '</h5>
 <h4 style="border: 1px solid black; text-align:center;"><b><i>Grand Total</i></b> Rs. ' . $paymentNameData['total_payableamount'] . '</h4>
 <h5><b><i>Total Paid Amount</i></b> Rs. ' . $paymentData['paid_amount'] . '</h5>
 <h5><b>Current Paid Amount</b> Rs. ' . $paymentData['current_paid_amount'] . '</h5>
 <h5><b>Due Amount</b> Rs. ' . $paymentData['due_amount'] . '</h5>
				 
			  </div><!-- /div.col-md-6 -->
		
      			 
			  <div class="form-group">
			    
			  </div>
			
			</form>';

			echo $div;
		}
	}

	////fetch student information to update admission payment
	public function fetchStudentAdmissionPaymentInfo($paymentId = null)
	{
		if ($paymentId) {
			$paymentData = $this->Model_PrintAdmissionSlip->fetchStudentPayData($paymentId);
			$paymentNameData = $this->Model_PrintAdmissionSlip->fetchPaymentData($paymentData['payment_name_id']);
			// $accessoriesData = $this->Model_Accounting->fetchAccessoriesData($paymentData['payment_name_id']);
			$classData = $this->Model_Classes->fetchClassData($paymentData['class_id']);
			$sectionData = $this->Model_Section->fetchSectionByClassSection($paymentData['class_id'], $paymentData['section_id']);
			$studentData = $this->Model_Student->fetchStudentData($paymentData['student_id']);
			$convertStartDate = date("d-m-Y", strtotime($paymentNameData['start_date']));
			$convertEndDate = date("d-m-Y", strtotime($paymentNameData['end_date']));
			$currentDate = date("Y-m-d");
			if ($paymentData['paid_amount'] == '') {
				$totalPaid = 0;
			} else {
				$totalPaid = $paymentData['paid_amount'];
			}

			$div = '

			<div id="update-student-payment-message" class="wrapper"></div>

			<form class="form-horizontal" action="accounting/updateStudentPay" method="post" id="updateStudentPayForm">
			  <div class="col-md-6">
			  <div class="form-group">
				    <!--<label for="paymentNameId" class="col-sm-4 control-label">Payment ID: </label>-->
				    <div class="col-sm-8">
				      <input type="text" class="form-control" id="paymentNameId" name="paymentNameId"placeholder="Payment Name Id" value="' . $paymentNameData['id'] . '" style="display:none;"/>
				      <input type="text" class="form-control" id="studentId" name="studentId"placeholder="Payment Name Id" value="' . $studentData['student_id'] . '" style="display:none;"/>

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
				      <input type="text" class="form-control" id="startDate" placeholder="Start Date" disabled value="' . $paymentNameData['start_date'] . '"/>
				    </div>
				  </div>			  
				  <div class="form-group">
				    <label for="endDate" class="col-sm-4 control-label">End Date: </label>
				    <div class="col-sm-8">
				      <input type="text" class="form-control" id="endDate" placeholder="End Date" name="endDate" readonly value="' . $paymentNameData['end_date'] . '">
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
			  <label for="admissionFee" class="col-sm-4 control-label">Admission Fee: </label>
			  <div class="col-sm-8">
				<input type="text" class="form-control" id="admissionFee" name="admissionFee" placeholder="Admission Fee" value="' . $paymentNameData['admission_fee'] . '" readonly>
			  </div>
			</div>
			 <!-- <div class="form-group">
			  <label for="examinationFee" class="col-sm-4 control-label">Examination Fee: </label>
			  <div class="col-sm-8">-->
				<input type="hidden" class="form-control" id="examinationFee" name="examinationFee" placeholder="Examination Fee" value="0">
			 <!-- </div>
			</div>-->
			<div class="form-group">
			  <label for="transportFee" class="col-sm-4 control-label">Transport Fee: </label>
			  <div class="col-sm-8">
			  <input type="hidden" class="form-control" id="durationPayment" name="durationPayment" placeholder="Duration" value="' . $paymentNameData['duration'] . '" readonly>
			  <input type="hidden" class="form-control" id="basicTransportFee" name="basicTransportFee" placeholder="Transport Fee" value="' . $paymentNameData['transport_fee'] . '" readonly>
				<input type="text" class="form-control" id="transportFee" name="transportFee" placeholder="Transport Fee" value="' . $paymentNameData['payabletransportfee'] . '" readonly>
			  </div>
			</div>
			
			<!--<div class="form-group">
			  <label for="lateFine" class="col-sm-4 control-label">Late Fine: </label>
			  <div class="col-sm-8">-->
				<input type="hidden" class="form-control" id="lateFine" name="lateFine" placeholder="Late Fine" value="' . $paymentNameData['late_fine'] . '">
			  <!--</div>
			</div>-->
			<div class="form-group">
			  <label for="monthlyFee" class="col-sm-4 control-label">Tution Fee: </label>
			  <div class="col-sm-8">
			  	<input type="hidden" class="form-control" id="basicMonthlyFee" name="basicMonthlyFee" placeholder="Tution Fee" value="' . $paymentNameData['monthly_fee'] . '" readonly>
				<input type="text" class="form-control" id="monthlyFee" name="monthlyFee" placeholder="Tution Fee" value="' . $paymentNameData['payablemonthlyfee'] . '" readonly>
			  </div>
			</div>
			<div class="form-group">
			 <label for="developmentFee" class="col-sm-4 control-label">Development Fee: </label>
			 <div class="col-sm-8">
				<input type="text" class="form-control" id="developmentFee" name="developmentFee" placeholder="Development Fee" value="' . $paymentNameData['p_development_fee'] . '" readonly>
			  </div>
			</div>
			<div class="form-group">
			 <label for="extraActivities" class="col-sm-4 control-label">Extra Activities: </label>
			 <div class="col-sm-8">
				<input type="text" class="form-control" id="extraActivities" name="extraActivities" placeholder="Extra Activities" value="' . $paymentNameData['p_extra_activites'] . '" readonly>
			  </div>
			</div>
			<div class="form-group">
			 <label for="tie" class="col-sm-4 control-label">Tie: </label>
			 <div class="col-sm-8">
				<input type="text" class="form-control" id="tie" name="tie" placeholder="Tie" value="' . $paymentNameData['p_tie'] . '" readonly>
			  </div>
			</div>
			<div class="form-group">
			 <label for="belt" class="col-sm-4 control-label">Belt: </label>
			 <div class="col-sm-8">
				<input type="text" class="form-control" id="belt" name="belt" placeholder="Tie" value="' . $paymentNameData['p_belt'] . '" readonly>
			  </div>
			</div>
			<div class="form-group">
			 <label for="diary" class="col-sm-4 control-label">Diary: </label>
			 <div class="col-sm-8">
				<input type="text" class="form-control" id="diary" name="diary" placeholder="Diary" value="' . $paymentNameData['p_diary'] . '" readonly>
			  </div>
			</div>
				 
				 <!-- <div class="form-group">
				    <label for="studentPayDate" class="col-sm-4 control-label">Payment Date: </label>
				    <div class="col-sm-8">-->
				      <input type="hidden" class="form-control" id="studentPayDate" name="studentPayDate" placeholder="Payment Date" value="' . $currentDate . '" readonly>
				    <!--</div>
				  </div>-->
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

	public function fetchStudentStatusInfo($paymentId = null, $type = null)
	{
		if ($paymentId && $type) {
			if ($type == 1) {
				$paymentData = $this->Model_PrintAdmissionSlip->fetchStudentPayData($paymentId);
			} elseif ($type == 2) {
				$paymentData = $this->Model_Accounting->fetchStudentPayData($paymentId);
			}
			// $paymentNameData = $this->Model_PrintAdmissionSlip->fetchPaymentData($paymentData['payment_name_id']);
			$div = '

			<div id="update-student-status-message" class="wrapper"></div>

			<form class="form-horizontal" action="PrintAdmissionSlip/updateStudentStatus" method="post" id="updateStudentStatusForm">
			  <div class="col-md-12">
				  <div class="form-group">
				    <label for="inputPassword3" class="col-sm-1 control-label">Continue: </label>
				    <div class="col-sm-12">
					<select class="form-control" name="st_status" id="st_status">
					<option value="">Select</option>
					<option value="0" ';
			if ($paymentData['st_status'] == 0) {
				$div .= "selected";
			}
			$div .= '>Yes</option>
					<option value="1" ';
			if ($paymentData['st_status'] == 1) {
				$div .= "selected";
			}
			$div .= '>No</option>		
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

	public function updateStudentStatus($paymentId = null)
	{
		if ($paymentId) {
			$validator = array('success' => false, 'messages' => array());

			$validate_data = array(
				array(
					'field' => 'st_status',
					'label' => 'Continue',
					'rules' => 'required'
				),
			);

			$this->form_validation->set_rules($validate_data);
			$this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>');

			if ($this->form_validation->run() === true) {
				$create = $this->Model_PrintAdmissionSlip->updateStudentStatus($paymentId);
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

			$remove = $this->Model_Accounting->removePayment($paymentId);
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
			    <li><a href="#" data-toggle="modal" data-target="#removeExpensesModal" onclick="removeExpenses(' . $value['id'] . ')">Remove</a></li>    
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
	public function fetchIncomeData($id = null)
	{
		$fetchData = $this->Model_Accounting->fetchIncomeData();
		$result = array('data' => array());
		$x = 1;
		foreach ($fetchData as $key => $value) {
			$fetchPaymentNameData = $this->Model_Accounting->fetchPaymentData($value['payment_name_id']);

			$button = '<button class="btn btn-primary" data-toggle="modal" data-target="#viewIncomeModal" onclick="viewIncome(' . $value['payment_id'] . ')">View</button>';

			$result['data'][$key] = array(
				$x,
				$fetchPaymentNameData['name'],
				$fetchPaymentNameData['total_amount'],
				$value['paid_amount'],
				$button
			);

			$x++;
		}
		echo json_encode($result);
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
					<th>Paid Amount : </th>
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
					<td>' . $studentData['fname'] . ' ' . $studentData['lname'] . '</td>
				</tr>
			</tbody>
			</table>';
			echo $data;
		}
	}
}
