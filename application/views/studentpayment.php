<?php
if ($this->input->get('opt') == '' || !$this->input->get('opt')) {
  show_404();
} else {
?>

  <div id="request" class="div-hide"><?php echo $this->input->get('opt'); ?></div>

  <ol class="breadcrumb">
    <li><a href="<?php echo base_url('dashboard') ?>">Home</a></li>
    <?php
    if ($this->input->get('opt') == 'addst') {
      echo '<li class="active">Add Student</li>';
    } else if ($this->input->get('opt') == 'bulkst') {
      echo '<li class="active">Add Bulk Student</li>';
    } else if ($this->input->get('opt') == 'mgst') {
      echo '<li class="active">Manage Student</li>';
    } else if ($this->input->get('opt') == 'mgscerti') {
      echo '<li class="active">Manage Student</li>';
    }
    ?>

  </ol>

  <?php if ($this->input->get('opt') == 'addst' || $this->input->get('opt') == 'bulkst') { ?>

    <div class="panel panel-default">
      <div class="panel-heading">
        <?php
        if ($this->input->get('opt') == 'addst') {
          echo "Add Student";
        } else if ($this->input->get('opt') == 'bulkst') {
          echo "Add Bulk Student";
        }
        ?>

      </div>
      <div class="panel-body">
        <div id="messages"></div>

        <?php
        if ($this->input->get('opt') == 'addst') {
          // echo "Add Student";
        ?>
          <form action="<?php echo base_url('student/create') ?>" method="post" id="createStudentForm" enctype="multipart/form-data">
            <div class="col-md-7">
              <fieldset>
                <legend>Student Info</legend>

                <div class="form-group">
                  <label for="fname">First Name</label>
                  <input type="text" class="form-control" id="fname" name="fname" placeholder="First Name" autocomplete="off">
                </div>
                <div class="form-group">
                  <label for="lname">Last Name</label>
                  <input type="text" class="form-control" id="lname" name="lname" placeholder="Last Name" autocomplete="off">
                </div>
                <div class="form-group">
                  <label for="dob">Date of Birth</label>
                  <input type="text" class="form-control" id="dob" name="dob" placeholder="Date of Birth" autocomplete="off">
                </div>
                <div class="form-group">
                  <label for="age">Age</label>
                  <input type="text" class="form-control" id="age" name="age" placeholder="Age" autocomplete="off">
                </div>
                <div class="form-group">
                  <label for="contact">Contact</label>
                  <input type="text" class="form-control" id="contact" name="contact" placeholder="Contact" autocomplete="off">
                </div>
                <div class="form-group">
                  <label for="email">Email</label>
                  <input type="text" class="form-control" id="email" name="email" placeholder="Email" autocomplete="off">
                </div>

              </fieldset>

              <fieldset>
                <legend>Address Info</legend>

                <div class="form-group">
                  <label for="address">Address</label>
                  <input type="text" class="form-control" id="address" name="address" placeholder="Address" autocomplete="off">
                </div>
                <div class="form-group">
                  <label for="city">City</label>
                  <input type="text" class="form-control" id="city" name="city" placeholder="City" autocomplete="off">
                </div>
                <div class="form-group">
                  <label for="country">Country</label>
                  <input type="text" class="form-control" id="country" name="country" placeholder="Country" autocomplete="off">
                </div>
              </fieldset>

            </div>
            <!-- /col-md-6 -->

            <div class="col-md-5">

              <fieldset>
                <legend>Registration Info</legend>

                <div class="form-group">
                  <label for="registerDate">Register Date</label>
                  <input type="text" class="form-control" id="registerDate" name="registerDate" placeholder="Register Date" autocomplete="off">
                </div>
                <div class="form-group">
                  <label for="className">Class</label>
                  <select class="form-control" name="className" id="className">
                    <option value="">Select</option>
                    <?php foreach ($classData as $key => $value) { ?>
                      <option value="<?php echo $value['class_id'] ?>"><?php echo $value['class_name'] ?></option>
                    <?php } // /forwach 
                    ?>
                  </select>
                </div>
                <div class="form-group">
                  <label for="sectionName">Section</label>
                  <select class="form-control" name="sectionName" id="sectionName">
                    <option value="">Select Class</option>
                  </select>
                </div>
              </fieldset>

              <fieldset>
                <legend>Photo</legend>

                <div class="form-group">
                  <label for="photo">Photo</label>
                  <!-- the avatar markup -->
                  <div id="kv-avatar-errors-1" class="center-block" style="max-width:500px;display:none"></div>
                  <div class="kv-avatar center-block" style="width:100%">
                    <input type="file" id="photo" name="photo" class="file-loading" />
                  </div>
                </div>

              </fieldset>


            </div>
            <!-- /col-md-6 -->

            <div class="col-md-12">

              <br /> <br />
              <center>
                <button type="submit" class="btn btn-primary">Save Changes</button>
                <button type="button" class="btn btn-default">Reset</button>
              </center>
            </div>


          </form>

        <?php
        } // /add student
        else if ($this->input->get('opt') == 'bulkst') {
          // echo "Add Bulk Student";        
        ?>
          <form action="student/createBulk" method="post" id="createBulkForm">

            <center>
              <button type="button" class="btn btn-default" onclick="addRow()">Add Row</button>
              <button type="submit" class="btn btn-primary">Save Changes</button>
            </center>
            <br /> <br />

            <table class="table" id="addBulkStudentTable">
              <thead>
                <tr>
                  <th style="width: 20%;">First Name</th>
                  <th style="width: 20%;">Last Name</th>
                  <th style="width: 20%;">Class</th>
                  <th style="width: 20%;">Section</th>
                  <th style="width: 2%;">Action</th>
                </tr>
              </thead>
              <tbody>
                <?php
                for ($x = 1; $x < 4; $x++) { ?>
                  <tr id="row<?php echo $x; ?>">
                    <td>
                      <div class="form-group">
                        <input type="text" class="form-control" id="bulkstfname<?php echo $x; ?>" name="bulkstfname[<?php echo $x; ?>]" placeholder="First Name" autocomplete="off">
                      </div>
                    </td>
                    <td>
                      <div class="form-group">
                        <input type="text" class="form-control" id="bulkstlname<?php echo $x; ?>" name="bulkstlname[<?php echo $x; ?>]" placeholder="Last Name" autocomplete="off">
                      </div>
                    </td>
                    <td>
                      <div class="form-group">
                        <select class="form-control" name="bulkstclassName[<?php echo $x; ?>]" id="bulkstclassName<?php echo $x; ?>" onchange="getSelectClassSection(<?php echo $x; ?>)">
                          <option value="">Select</option>
                          <?php foreach ($classData as $key => $value) { ?>
                            <option value="<?php echo $value['class_id'] ?>"><?php echo $value['class_name'] ?></option>
                          <?php } // /forwach 
                          ?>
                        </select>
                      </div>
                    </td>
                    <td>
                      <div class="form-group">
                        <select class="form-control" name="bulkstsectionName[<?php echo $x; ?>]" id="bulkstsectionName<?php echo $x; ?>">
                          <option value="">Select Class</option>
                        </select>
                      </div>
                    </td>
                    <td>
                      <button type="button" class="btn btn-default" onclick="removeRow(<?php echo $x; ?>)"><i class="glyphicon glyphicon-trash"></i></button>
                    </td>
                  </tr>
                <?php
                } // /for
                ?>

              </tbody>
            </table>
            <!-- /.form -->

          </form>
          <!-- /.form -->

        <?php
        } // /add bulk student      
        ?>



      </div>
      <!-- /panle-bdy -->
    </div>
    <!-- /.panel -->

  <?php
  } // /checking condition for add student and bulk student 
  else if ($this->input->get('opt') == 'mgst') { ?>
    <div class="row">
      <div class="col-md-2">
        <div class="panel panel-default">

          <div class="panel-heading">
            Manage Section
          </div>

          <div class="list-group">
            <a type="button" class="list-group-item" href="javascript:void(0);" id="printpayment_button">Print Student Payment List</a>
            <a type="button" class="list-group-item" href="<?php echo base_url('accounting?opt=mgpay') ?>">Manage Student Payment</a>
            <a type="button" class="list-group-item" href="<?php echo base_url('studentpayment?opt=mgst') ?>">Student Payment by Class</a>
            <?php
            if ($classData) {
              $x = 1;
              foreach ($classData as $value) {
            ?>
                <a class="list-group-item classSideBar <?php if ($x == 1) {
                                                          echo 'active';
                                                        } ?>" onclick="getClassSection(<?php echo $value['class_id'] ?>)" id="classId<?php echo $value['class_id'] ?>">
                  <?php echo $value['class_name']; ?>(<?php echo $value['numeric_name']; ?>)
                </a>
              <?php
                $x++;
              }
            } else {
              ?>
              <a class="list-group-item">No Data</a>
            <?php
            }
            ?>
          </div>

        </div>
        <!-- /.panel -->
      </div>
      <!-- /.col-md-4 -->
      <div class="col-md-10">

        <div class="panel panel-default">
          <div class="panel-heading">Student Payment by Class</div>
          <div class="panel-body">
            <div id="result" class="payment"></div>

          </div>
          <!-- /panel-body -->
        </div>
        <!-- /panel -->
      </div>
      <!-- /.col-md-08 -->
    </div>
    <!-- /.row -->
    <script>
      $(document).ready(function() {
        $("#printpayment_button").click(function() {
          var mode = 'iframe'; // popup
          var close = mode == "popup";
          var options = {
            mode: mode,
            popClose: close
          };
          $("div.payment").printArea(options);
        });
      });
    </script>
  <?php
  } // /condition for manage student
  ?>

  <!-- edit student modal -->
  <div class="modal fade" tabindex="-1" role="dialog" id="editStudentModal">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title">Edit Student Payment</h4>
        </div>

        <div class="modal-body edit-modal">

          <div id="edit-teacher-messages"></div>

          <!-- Nav tabs -->

          <!-- Tab panes -->
          <div class="tab-content">
            <!-- /tab panel of image -->

            <div role="tabpanel" class="tab-pane active" id="profile">

              <br />
              <form class="form-horizontal" method="post" action="StudentPayment/updateInfo" id="updateStudentInfoForm">

                <div class="row">

                  <div class="col-md-12">
                    <div id="edit-personal-student-message"></div>

                    <div class="col-md-6">
                      <div class="form-group">
                        <!-- <label for="paymentId" class="col-sm-4 control-label">Payment ID: </label>-->
                        <div class="col-sm-8">
                          <input type="text" class="form-control" id="paymentId" name="paymentId" value="" placeholder="Payment ID" style="display:none;" />
                          <?php $userlevel = $this->session->userdata('user_level'); ?>
                          <input type="text" class="form-control" id="userlevel" value="<?php echo $userlevel ?>" placeholder="User Level" style="display:none;" />
                        </div>
                      </div>

                      <div class="form-group">
                        <label for="paymentName" class="col-sm-4 control-label">Payment Name: </label>
                        <div class="col-sm-8">
                          <input type="email" class="form-control" id="paymentName" placeholder="Payment Name" disabled value="" />
                        </div>
                      </div>

                      <div class="form-group">
                        <label for="startDate" class="col-sm-4 control-label">Start Date: </label>
                        <div class="col-sm-8">
                          <input type="text" class="form-control" id="startDate" placeholder="Start Date" disabled value="" />
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="durationPayment" class="col-sm-4 control-label">Duration: </label>
                        <div class="col-sm-8">
                          <input type="number" class="form-control" id="durationPayment" name="durationPayment" placeholder="Duration" value="" max="12" min="" />
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="endDate" class="col-sm-4 control-label">End Date: </label>
                        <div class="col-sm-8">
                          <input type="text" class="form-control" id="endDate" name="endDate" placeholder="End Date" readonly value="">
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="className" class="col-sm-4 control-label">Class: </label>
                        <div class="col-sm-8">
                          <input type="text" class="form-control" id="className" placeholder="Class" readonly value="">
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="section" class="col-sm-4 control-label">Section: </label>
                        <div class="col-sm-8">
                          <input type="text" class="form-control" id="section" placeholder="Section" readonly value="">
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="rollNo" class="col-sm-4 control-label">Roll No: </label>
                        <div class="col-sm-8">
                          <input type="text" class="form-control" id="rollNo" placeholder="Roll No" readonly value="">
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="studentName" class="col-sm-4 control-label">Student Name: </label>
                        <div class="col-sm-8">
                          <input type="text" class="form-control" id="studentName" placeholder="Student Name" readonly value="">
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="totalAmount" class="col-sm-4 control-label">Total Amount: </label>
                        <div class="col-sm-8">
                          <input type="text" class="form-control" id="totalAmount" name="totalAmount" placeholder="Total Amounts" readonly value="">
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="totalPayableAmount" class="col-sm-4 control-label">Total Payable Amount: </label>
                        <div class="col-sm-8">
                          <input type="text" class="form-control" id="totalPayableAmount" name="totalPayableAmount" placeholder="Total Payable Amount" readonly value="">
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
                          <input type="text" class="form-control" id="previousPaid" name="previousPaid" placeholder="Previous Amount" value="" readonly>
                        </div>
                      </div>


                    </div>
                    <!-- /col-md-6 -->

                    <div class="col-md-6">

                      <div class="form-group">
                        <label for="examinationFee" class="col-sm-4 control-label">Examination Fee: </label>
                        <div class="col-sm-8">
                          <input type="text" class="form-control" id="examinationFee" name="examinationFee" placeholder="Examination Fee" value="">
                        </div>
                      </div>
                      <!--<div class="form-group">
                        <label for="developmentFee" class="col-sm-4 control-label">Development Fee: </label>
                        <div class="col-sm-8">-->
                      <input type="hidden" class="form-control" id="developmentFee" name="developmentFee" placeholder="Development Fee" value="">
                      <!-- </div>
                      </div>-->
                      <div class="form-group">
                        <label for="tie" class="col-sm-4 control-label">Tie: </label>
                        <div class="col-sm-8">
                          <input type="text" class="form-control" id="tie" name="tie" placeholder="Tie" value="">
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="belt" class="col-sm-4 control-label">Belt: </label>
                        <div class="col-sm-8">
                          <input type="text" class="form-control" id="belt" name="belt" placeholder="Belt" value="">
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="belt" class="col-sm-4 control-label">Diary: </label>
                        <div class="col-sm-8">
                          <input type="text" class="form-control" id="diary" name="diary" placeholder="Diary" value="">
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="basicTransportFee" class="col-sm-4 control-label">Transport Fee: </label>
                        <div class="col-sm-8">
                          <input type="text" class="form-control" id="basicTransportFee" name="basicTransportFee" placeholder="Transport Fee" value="" readonly>
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="transportFee" class="col-sm-4 control-label">Payable Transport Fee: </label>
                        <div class="col-sm-8">
                          <input type="text" class="form-control" id="transportFee" name="transportFee" placeholder="Transport Fee" value="" readonly>
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="lateFine" class="col-sm-4 control-label">Late Fine: </label>
                        <div class="col-sm-8">
                          <input type="text" class="form-control" id="lateFine" name="lateFine" placeholder="Late Fine" value="">
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="basicMonthlyFee" class="col-sm-4 control-label">Tution Fee: </label>
                        <div class="col-sm-8">
                          <input type="text" class="form-control" id="basicMonthlyFee" name="basicMonthlyFee" placeholder="Tution Fee" value="" readonly>
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="monthlyFee" class="col-sm-4 control-label">Payable Tution Fee: </label>
                        <div class="col-sm-8">
                          <input type="text" class="form-control" id="monthlyFee" name="monthlyFee" placeholder="Tution Fee" value="" readonly>
                        </div>
                      </div>

                      <div class="form-group">
                        <label for="studentPayDate" class="col-sm-4 control-label">Payment Date: </label>
                        <div class="col-sm-8">
                          <input type="date" class="form-control" id="studentPayDate" name="studentPayDate" placeholder="Payment Date" value="<?php echo date('Y-m-d'); ?>" readonly>
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="paidAmount" class="col-sm-4 control-label">Paid Amount: </label>
                        <div class="col-sm-8">
                          <input type="text" class="form-control" id="paidAmount" name="paidAmount" placeholder="Paid Amount" value="">
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="dueAmount" class="col-sm-4 control-label">Due Amount: </label>
                        <div class="col-sm-8">
                          <input type="number" class="form-control" id="dueAmount" name="dueAmount" placeholder="Due Amount" value="" min="0" readonly>
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="discount" class="col-sm-4 control-label">Discount: </label>
                        <div class="col-sm-8">
                          <input type="number" class="form-control" id="discount" name="discount" placeholder="Discount" value="" min="0">
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="paymentType" class="col-sm-4 control-label">Session: </label>
                        <div class="col-sm-8">
                          <select class="form-control" name="session" id="session">
                            <option value="2021-2022">2021-2022</option>
                            <option value="2022-2023">2022-2023</option>
                          </select>
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="paymentType" class="col-sm-4 control-label">Payment Type: </label>
                        <div class="col-sm-8">
                          <select class="form-control" name="paymentType" id="paymentType">
                            <option value="">Select</option>
                            <option value="1">Full Payment</option>
                            <option value="2">Installment</option>
                          </select>
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="inputPassword3" class="col-sm-4 control-label">Status: </label>
                        <div class="col-sm-8">
                          <select class="form-control" name="status" id="status">
                            <option value="">Select</option>
                            <option value="0">Pending</option>
                            <option value="1">Paid</option>
                            <option value="2">Unpaid</option>
                          </select>
                        </div>
                      </div>
                    </div>
                    <!-- /col-md-4 -->

                    <div class="form-group">
                      <div class="col-sm-12">
                        <center>
                          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                          <button type="submit" class="btn btn-primary">Save Changes</button>
                        </center>
                      </div>
                    </div>
                  </div>
                  <!-- /col-md-12 -->

                </div>
                <!-- /row -->
              </form>

            </div>
            <!-- /tab-panel of teacher information -->
          </div>


        </div>
        <!-- /modal-body -->

      </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
  </div><!-- /.modal -->

  <!-- /.update student's payment -->
  <div class="modal fade" tabindex="-1" role="dialog" id="printStudentPay">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title">Print Monthly Fee Slip</h4>
          <a href="javascript:void(0);" id="print_button">Print</a>
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>

        <div class="modal-body">
          <div id="print-student-result" class="content"></div>
        </div>
        <!-- /.modal body -->

      </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
  </div><!-- /.modal -->
  <!-- update student status -->
  <div class="modal fade" tabindex="-1" role="dialog" id="updateStudentStatus">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title">Edit Student Status</h4>
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

        </div>


        <div class="modal-body">
          <div id="edit-student-status-result" class=""></div>
        </div>
        <!-- /.modal body -->

      </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
  </div><!-- /.modal -->
  <!-- update student status -->
  <script type="text/javascript" src="<?php echo base_url('custom/js/jquery.min.js') ?>"></script>
  <script type="text/javascript" src="<?php echo base_url('custom/js/jquery.PrintArea.js') ?>"></script>
  <script>
    $(document).ready(function() {
      $("#print_button").click(function() {
        var mode = 'iframe'; // popup
        var close = mode == "popup";
        var options = {
          mode: mode,
          popClose: close
        };
        $("div.content").printArea(options);
      });
    });
  </script>

  <!-- /.remove student payment -->
  <div class="modal fade" tabindex="-1" role="dialog" id="removeStudentPay">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title">Remove Payment</h4>
        </div>
        <div class="modal-body">
          <p>Do you really want to remove ? </p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary" id="removeStudentPayBtn">Save changes</button>
        </div>
      </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
  </div><!-- /.modal -->
  <!-- remove studet modal -->
  <div class="modal fade" tabindex="-1" role="dialog" id="removeStudentModal">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title">Remove Student</h4>
        </div>
        <div class="modal-body">
          <p>Do you really want to remove ?</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary" id="removeStudentBtn">Save changes</button>
        </div>
      </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
  </div><!-- /.modal -->

<?php

} // /else show_404() 

?>



<script type="text/javascript" src="<?php echo base_url('custom/js/studentpayment.js') ?>"></script>