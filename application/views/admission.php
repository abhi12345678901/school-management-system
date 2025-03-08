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
          <form action="<?php echo base_url('admission/create') ?>" method="post" id="createStudentForm" enctype="multipart/form-data">
            <div class="col-md-7">
              <fieldset>
                <legend>STUDENT'S PERSONAL DETAIL <span style="color:red;font-size:12px;"> ( * Fields are mendatory )</span></legend>
                <div class="form-group">
                  <label for="rollno"><span style="color:red;">*</span> Roll No.</label>
                  <input type="text" class="form-control" id="rollno" name="rollno" placeholder="Roll No" autocomplete="off">
                </div>
                <div class="form-group">
                  <label for="stname"><span style="color:red;">*</span> Name of the Student</label>
                  <input type="text" class="form-control" id="stname" name="stname" placeholder="Name of the Student" autocomplete="off">
                </div>

                <div class="form-group">
                  <label for="fname"><span style="color:red;">*</span> Father's Name</label>
                  <input type="text" class="form-control" id="fname" name="fname" placeholder="Father's Name" autocomplete="off">
                </div>
                <div class="form-group">
                  <label for="mname"><span style="color:red;">*</span> Mother's Name</label>
                  <input type="text" class="form-control" id="mname" name="mname" placeholder="Mother's Name" autocomplete="off">
                </div>
                <div class="form-group">
                  <label for="idesease">If suffering from any disease</label>
                  <input type="text" class="form-control" id="idesease" name="idesease" placeholder="If suffering from any disease" autocomplete="off">
                </div>
                <div class="form-group">
                  <label for="bloodgroup">Blood Group</label>
                  <select class="form-control" name="bloodgroup" id="bloodgroup">
                    <option value="">Select</option>
                    <option value="A+">A+</option>
                    <option value="A-">A-</option>
                    <option value="B+">B+</option>
                    <option value="B-">B-</option>
                    <option value="AB+">AB+</option>
                    <option value="AB-">AB-</option>
                    <option value="O+">O+</option>
                    <option value="O-">O-</option>
                  </select>
                </div>

                <div class="form-group">
                  <label for="paralysed">Whether paralysed</label>
                  <input type="text" class="form-control" id="paralysed" name="paralysed" placeholder="Whether paralysed" autocomplete="off">
                </div>

                <div class="form-group">
                  <label for="dcattatch"><span style="color:red;">*</span> Documents attatched at the time of admission </label>
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" name="dcattatch[]" id="adharcard" value="Adhar Card of Student">
                    <label class="form-check-label" for="adharcard">Adhar Card of Student</label>
                  </div>
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" name="dcattatch[]" id="ageproof" value="Age Proof">
                    <label class="form-check-label" for="ageproof">Age Proof</label>
                    <input type="text" class="form-control" name="ageproof" placeholder="Name of Document" autocomplete="off">
                  </div>
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" name="dcattatch[]" id="image" value="Photo">
                    <label class="form-check-label" for="image">Photo</label>
                  </div>
                </div>

                <div class="form-group">
                  <label for="idparents"><span style="color:red;">*</span> Identity of Parents</label>
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" name="idparents[]" id="voterid" value="Voter ID">
                    <label class="form-check-label" for="voterid">Voter ID</label>
                  </div>
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" name="idparents[]" id="parentsadhar" value="Adhar Card">
                    <label class="form-check-label" for="parentsadhar">Adhar Card</label>
                  </div>
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" name="idparents[]" id="drivinglicence" value="Driving Licence">
                    <label class="form-check-label" for="drivinglicence">Driving Licence</label>
                  </div>
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" name="idparents[]" id="rationcard" value="Ration Card">
                    <label class="form-check-label" for="rationcard">Ration Card</label>
                  </div>
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" name="idparents[]" id="electricitybill" value="Electricity Bill">
                    <label class="form-check-label" for="electricitybill">Electricity Bill</label>
                  </div>
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" name="idparents[]" id="gascard" value="Gas Card">
                    <label class="form-check-label" for="gascard">Gas Card</label>
                  </div>
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" name="idparents[]" id="bankpassbook" value="Bank Passbook">
                    <label class="form-check-label" for="bankpassbook">Bank Passbook</label>
                  </div>
                </div>

                <div class="form-group">
                  <label for="sthobby">Student Hobby</label>
                  <input type="text" class="form-control" id="sthobby" name="sthobby" placeholder="Student Hobby" autocomplete="off">
                </div>
                <div class="form-group">
                  <label for="stinterest">Student interested in</label>
                  <input type="text" class="form-control" id="stinterest" name="stinterest" placeholder="Student interested in" autocomplete="off">
                </div>
                <div class="form-group">
                  <label for="disease">Diseases</label>
                  <input type="text" class="form-control" id="disease" name="disease" placeholder="Diseases" autocomplete="off">
                </div>
                <div class="form-group">
                  <label for="exdetail">Extra Details of Students</label>
                  <input type="text" class="form-control" id="exdetail" name="exdetail" placeholder="Extra Details of Students" autocomplete="off">
                </div>

              </fieldset>


            </div>
            <!-- /col-md-6 -->

            <div class="col-md-5">

              <fieldset>
                <legend>ADMISSION FROM</legend>
                <div class="form-group">
                  <label for="className"> <span style="color:red;">*</span> Application for admission in Class</label>
                  <select class="form-control" name="className" id="className">
                    <option value="">Select</option>
                    <?php foreach ($classData as $key => $value) { ?>
                      <option value="<?php echo $value['class_id'] ?>"><?php echo $value['class_name'] ?></option>
                    <?php } // /forwach 
                    ?>
                  </select>
                </div>
                <div class="form-group">
                  <label for="sectionName"><span style="color:red;">*</span> Section</label>
                  <select class="form-control" name="sectionName" id="sectionName">
                    <option value="">Select Class</option>
                  </select>
                </div>

                <div class="form-group">
                  <label for="dob"> <span style="color:red;">*</span> Date of Birth</label>
                  <input type="text" class="form-control" id="dob" name="dob" placeholder="Date of Birth" autocomplete="off">
                </div>
                <div class="form-group">
                  <label for="sex"> <span style="color:red;">*</span> Sex</label>
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="sex" id="male" value="Male">
                    <label class="form-check-label" for="inlineRadio1">Male</label>
                  </div>
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="sex" id="female" value="Female">
                    <label class="form-check-label" for="inlineRadio2">Female</label>
                  </div>
                </div>
                <div class="form-group">
                  <label for="weight">Weight</label>
                  <input type="text" class="form-control" id="weight" name="weight" placeholder="Weight" autocomplete="off">
                </div>
                <div class="form-group">
                  <label for="height">Height</label>
                  <input type="text" class="form-control" id="height" name="height" placeholder="Height" autocomplete="off">
                </div>
                <div class="form-group">
                  <label for="religion"><span style="color:red;">*</span> Religion</label>
                  <!--<input type="text" class="form-control" id="religion" name="religion" placeholder="Religion" autocomplete="off">-->
                  <select id="religion" name="religion" class="form-control">
                    <option value="">Select</option>
                    <option value="Hindu">Hindu</option>
                    <option value="Muslim">Muslim</option>
                    <option value="Christians">Christians</option>
                    <option value="Buddhists">Buddhists</option>
                    <option value="Jains">Jains</option>
                    <option value="Others">Others</option>
                  </select>

                </div>
                <div class="form-group">
                  <label for="category"> <span style="color:red;">*</span> Category</label>
                  <!--  <input type="text" class="form-control" id="category" name="category" placeholder="Category" autocomplete="off">-->
                  <select id="category" name="category" class="form-control">
                    <option value="">Select</option>
                    <option value="General">General</option>
                    <option value="OBC">OBC</option>
                    <option value="SC">SC</option>
                    <option value="ST">ST</option>
                  </select>
                </div>
                <div class="form-group">
                  <label for="paddress"><span style="color:red;">*</span> Full Postal Address</label>
                  <input type="text" class="form-control" id="paddress" name="paddress" placeholder="Full Postal Address" autocomplete="off">
                </div>
                <div class="form-group">
                  <label for="fphone">Phone</label>
                  <input type="text" class="form-control" id="pphone" name="pphone" placeholder="1234 5678 90" autocomplete="off">
                </div>
                <div class="form-group">
                  <label for="faddress"> <span style="color:red;">*</span> Full Permanent Address</label>
                  <input type="text" class="form-control" id="faddress" name="faddress" placeholder="Full Permanent Address" autocomplete="off">
                </div>
                <div class="form-group">
                  <label for="fphone"><span style="color:red;">*</span>Phone</label>
                  <input type="text" class="form-control" id="fphone" name="fphone" placeholder="1234 5678 90" autocomplete="off">
                </div>
                <div class="form-group">
                  <label for="area"> <span style="color:red;">*</span> Area</label>
                  <input type="text" class="form-control" id="area" name="area" placeholder="area" autocomplete="off">
                </div>
                <div class="form-group">
                  <label for="foccupation">Father's Occupation</label>
                  <input type="text" class="form-control" id="foccupation" name="foccupation" placeholder="Father's Occupation" autocomplete="off">
                </div>
                <div class="form-group">
                  <label for="moccupation">Mother's Occupation</label>
                  <input type="text" class="form-control" id="moccupation" name="moccupation" placeholder="Mother's Occupation" autocomplete="off">
                </div>
                <div class="form-group">
                  <label for="bplno"> <span style="color:red;">*</span> BPL No. ( 0 if N/A )</label>
                  <input type="text" class="form-control" id="bplno" name="bplno" placeholder="BPL No." autocomplete="off">
                </div>
                <div class="form-group">
                  <label for="stadhar"><span style="color:red;">*</span> Adhar Card No. of Student</label>
                  <input type="text" class="form-control" id="stadhar" name="stadhar" placeholder="0000 0000 0000" autocomplete="off">
                </div>
                <div class="form-group">
                  <label for="parentsadharnumber"> <span style="color:red;">*</span> Adhar Card No. of Parents</label>
                  <input type="text" class="form-control" id="parentsadharnumber" name="parentsadharnumber" placeholder="Adhar Card No. of Parents" autocomplete="off">
                </div>
                <div class="form-group">
                  <label for="stbank"> <span style="color:red;">*</span> Bank Account No. of student</label>
                  <input type="text" class="form-control" id="stbank" name="stbank" placeholder="Bank Account No. of student" autocomplete="off">
                </div>
                <div class="form-group">
                  <label for="stifsc"> <span style="color:red;">*</span> IFSC Code</label>
                  <input type="text" class="form-control" id="stifsc" name="stifsc" placeholder="IFSC Code" autocomplete="off">
                </div>
                <div class="form-group">
                  <label for="email">Email ID</label>
                  <input type="text" class="form-control" id="email" name="email" placeholder="Email ID" autocomplete="off">
                </div>
                <div class="form-group">
                  <label for="language">Language spoken at home</label>
                  <input type="text" class="form-control" id="language" name="language" placeholder="Language spoken at home" autocomplete="off">
                </div>
                <div class="form-group">
                  <label for="prschool">Previous School</label>
                  <input type="text" class="form-control" id="prschool" name="prschool" placeholder="Previous School" autocomplete="off">
                </div>
                <div class="form-group">
                  <label for="gdname">Gaurdian's Full Name</label>
                  <input type="text" class="form-control" id="gdname" name="gdname" placeholder="Gaurdian's Full Name" autocomplete="off">
                </div>
                <!-- <div class="form-group">
                  <label for="admssionno"> <span style="color:red;">*</span> Admission No.</label>
                  <input type="text" class="form-control" id="admssionno" name="admssionno" placeholder="Admission No." autocomplete="off">
                </div> -->
                <div class="form-group">
                  <label for="admssionno"><span style="color:red;">*</span> Admission No.</label>
                  <select class="form-control" name="admssionno" id="admssionno">
                    <option value="">Select Class</option>
                  </select>
                </div>

                <div class="form-group">
                  <label for="registerDate"> <span style="color:red;">*</span> Admission Date</label>
                  <input type="text" class="form-control" id="" name="registerDate" value="<?php echo date("Y-m-d") ?>" placeholder="Admission Date" autocomplete="off" readonly>
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
      <div class="col-md-4">
        <div class="panel panel-default">

          <div class="panel-heading">
            Class
          </div>

          <div class="list-group">
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
      <div class="col-md-8">

        <div class="panel panel-default">
          <div class="panel-heading">Manage Student</div>
          <div class="panel-body">
            <div id="result"></div>

          </div>
          <!-- /panel-body -->
        </div>
        <!-- /panel -->
      </div>
      <!-- /.col-md-08 -->
    </div>
    <!-- /.row -->
  <?php
  } // /condition for manage student
  ?>

  <!-- edit student modal -->
  <div class="modal fade" tabindex="-1" role="dialog" id="editStudentModal">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title">Edit Student</h4>
        </div>

        <div class="modal-body edit-modal">

          <div id="edit-teacher-messages"></div>

          <!-- Nav tabs -->
          <ul class="nav nav-tabs" role="tablist">
            <li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab">Photo</a></li>
            <li role="presentation"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab">Personal Detail</a></li>
          </ul>

          <!-- Tab panes -->
          <div class="tab-content">
            <div role="tabpanel" class="tab-pane active" id="home">
              <br />

              <form class="form-horizontal" method="post" id="updateStudentPhotoForm" action="student/updatePhoto" enctype="multipart/form-data">

                <div class="row">
                  <div class="col-md-12">
                    <div id="edit-upload-image-message"></div>

                    <div class="col-md-6">
                      <center>
                        <img src="" id="student_photo" alt="Student Photo" class="img-thumbnail upload-photo" />
                      </center>
                    </div>

                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="editPhoto" class="col-sm-4 control-label">Photo: </label>
                        <div class="col-sm-8">
                          <!-- the avatar markup -->
                          <div id="kv-avatar-errors-1" class="center-block" style="max-width:500px;display:none"></div>
                          <div class="kv-avatar center-block" style="width:100%">
                            <input type="file" id="editPhoto" name="editPhoto" class="file-loading" />
                          </div>
                        </div>
                      </div>
                      <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                          <center>
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save Changes</button>
                          </center>
                        </div>
                      </div>

                    </div>
                    <!-- /col-md-6 -->
                  </div>
                  <!-- /col-md-12 -->
                </div>
                <!-- /row -->

              </form>
            </div>
            <!-- /tab panel of image -->

            <div role="tabpanel" class="tab-pane" id="profile">

              <br />
              <form class="form-horizontal" method="post" action="student/updateInfo" id="updateStudentInfoForm">
                <div class="row">

                  <div class="col-md-12">
                    <div id="edit-personal-student-message"></div>

                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="editFname" class="col-sm-4 control-label">First Name : </label>
                        <div class="col-sm-8">
                          <input type="text" class="form-control" id="editFname" name="editFname" placeholder="First Name" />
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="editLname" class="col-sm-4 control-label">Last Name : </label>
                        <div class="col-sm-8">
                          <input type="text" class="form-control" id="editLname" name="editLname" placeholder="Last Name" />
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="editDob" class="col-sm-4 control-label">DOB: </label>
                        <div class="col-sm-8">
                          <input type="text" class="form-control" id="editDob" name="editDob" placeholder="Date of Birth" />
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="editAge" class="col-sm-4 control-label">Age: </label>
                        <div class="col-sm-8">
                          <input type="text" class="form-control" id="editAge" name="editAge" placeholder="Age" />
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="editContact" class="col-sm-4 control-label">Contact: </label>
                        <div class="col-sm-8">
                          <input type="text" class="form-control" id="editContact" name="editContact" placeholder="Contact" />
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="editEmail" class="col-sm-4 control-label">Email: </label>
                        <div class="col-sm-8">
                          <input type="text" class="form-control" id="editEmail" name="editEmail" placeholder="Email" />
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="editAddress" class="col-sm-4 control-label">Address: </label>
                        <div class="col-sm-8">
                          <input type="text" class="form-control" id="editAddress" name="editAddress" placeholder="Address" />
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="editCity" class="col-sm-4 control-label">City: </label>
                        <div class="col-sm-8">
                          <input type="text" class="form-control" id="editCity" name="editCity" placeholder="City" />
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="editCountry" class="col-sm-4 control-label">Country: </label>
                        <div class="col-sm-8">
                          <input type="text" class="form-control" id="editCountry" name="editCountry" placeholder="Country" />
                        </div>
                      </div>

                    </div>
                    <!-- /col-md-6 -->

                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="editRegisterDate" class="col-sm-4 control-label">Register Date : </label>
                        <div class="col-sm-8">
                          <input type="text" class="form-control" id="editRegisterDate" name="editRegisterDate" placeholder="Register Date" />
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="editClassName" class="col-sm-4 control-label">Class</label>
                        <div class="col-sm-8">
                          <select class="form-control" name="editClassName" id="editClassName">
                            <option value="">Select</option>
                            <?php foreach ($classData as $key => $value) { ?>
                              <option value="<?php echo $value['class_id'] ?>"><?php echo $value['class_name'] ?></option>
                            <?php } // /forwach 
                            ?>
                          </select>
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="editSectionName" class="col-sm-4 control-label">Section</label>
                        <div class="col-sm-8">
                          <select class="form-control" name="editSectionName" id="editSectionName">
                            <option value="">Select Class</option>
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



<script type="text/javascript" src="<?php echo base_url('custom/js/student.js') ?>"></script>