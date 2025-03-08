<?php 
if($this->input->get('opt') == '' || !$this->input->get('opt')) {
  show_404();
} else {
?>

<div id="request" class="div-hide"><?php echo $this->input->get('opt'); ?></div>

<ol class="breadcrumb">
  <li><a href="<?php echo base_url('dashboard') ?>">Home</a></li> 
  <?php   
  if($this->input->get('opt') == 'addst') {
    echo '<li class="active">Add Student</li>';
  } 
  else if ($this->input->get('opt') == 'bulkst') {
    echo '<li class="active">Add Bulk Student</li>';
  }
  else if ($this->input->get('opt') == 'mgst') {
    echo '<li class="active">Manage Student</li>';
  }
  else if ($this->input->get('opt') == 'mgscerti') {
    echo '<li class="active">Manage Student</li>';
  }
  ?>  

</ol>

<?php if($this->input->get('opt') == 'addst' || $this->input->get('opt') == 'bulkst') { ?>

<div class="panel panel-default">
  <div class="panel-heading">
    <?php   
    if($this->input->get('opt') == 'addst') {
      echo "Add Student";
    } 
    else if ($this->input->get('opt') == 'bulkst') {
      echo "Add Bulk Student";
    }
    ?>  
  	
  </div>
  <div class="panel-body">
  	 <div id="messages"></div>

      <?php   
      if($this->input->get('opt') == 'addst') {
        // echo "Add Student";
        ?>
        <form action="<?php echo base_url('student/create') ?>" method="post" id="createStudentForm" enctype="multipart/form-data">  
          <div class="col-md-7">
          <fieldset>
            <legend>Student Info</legend>

            <div class="form-group">
              <label for="fname">First Name</label>
              <input type="text" class="form-control" id="fname" name="fname" placeholder="First Name" autocomplete="off" >
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
                <?php } // /forwach ?>
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
                    <input type="file" id="photo" name="photo" class="file-loading"/>                       
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
            for($x = 1; $x < 4; $x++) { ?>
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
                      <?php } // /forwach ?>
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
else if($this->input->get('opt') == 'mgst') { ?>
  <div class="row">
          <div class="col-md-4">
            <div class="panel panel-default">

              <div class="panel-heading">
                Class
              </div>

              <div class="list-group">      
                <?php 
                if($classData) {
                  $x = 1;
                  foreach ($classData as $value) { 
                  ?>
                    <a class="list-group-item classSideBar <?php if($x == 1) { echo 'active'; } ?>" onclick="getClassSection(<?php echo $value['class_id'] ?>)" id="classId<?php echo $value['class_id'] ?>">
                        <?php echo $value['class_name']; ?>(<?php echo $value['numeric_name']; ?>)
                      </a>  
                  <?php 
                  $x++;
                  }
                } 
                else {
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
                        <input type="file" id="editPhoto" name="editPhoto" class="file-loading"/>                       
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
                <label for="rollNo" class="col-sm-4 control-label">Roll No : </label>
                  <div class="col-sm-8">
                    <input type="text" class="form-control" id="rollNo" name="rollNo" placeholder="Roll No" />
                  </div>
              </div>
                <div class="form-group">
                <label for="editStudentName" class="col-sm-4 control-label">Name of the Student : </label>
                  <div class="col-sm-8">
                    <input type="text" class="form-control" id="editStudentName" name="editStudentName" placeholder="Name of the Student" />
                  </div>
              </div>
              <div class="form-group">
                  <label for="fname" class="col-sm-4 control-label">Father's Name : </label>
                  <div class="col-sm-8">
                    <input type="text" class="form-control" id="fname" name="fname" placeholder="Father's Name"/>
                  </div>
              </div>
              <div class="form-group">
                  <label for="mname" class="col-sm-4 control-label">Mother's Name : </label>
                  <div class="col-sm-8">
                    <input type="text" class="form-control" id="mname" name="mname" placeholder="Mother's Name"/>
                  </div>
              </div>
              <div class="form-group">
                  <label for="idesease" class="col-sm-4 control-label">If suffering from any disease : </label>
                  <div class="col-sm-8">
                    <input type="text" class="form-control" id="idesease" name="idesease" placeholder="If suffering from any disease"/>
                  </div>
              </div>
              <div class="form-group">
                  <label for="bloodgroup" class="col-sm-4 control-label">Blood Group : </label>
                  <div class="col-sm-8">
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
              </div>
              <div class="form-group">
                  <label for="paralysed" class="col-sm-4 control-label">Whether paralysed : </label>
                  <div class="col-sm-8">
                    <input type="text" class="form-control" id="paralysed" name="paralysed" placeholder="Whether paralysed "/>
                  </div>
              </div>
              <div class="form-group">
                  <label for="dcattatch" class="col-sm-4 control-label">Documents attatched at the time of admission : </label>
                  <div class="col-sm-8">
                    <input type="text" class="form-control" id="dcattatch" name="dcattatch" placeholder="Documents attatched at the time of admission" readonly/>
                  </div>
              </div>
              <div class="form-group">
                  <label for="ageproof" class="col-sm-4 control-label">Age Proof : </label>
                  <div class="col-sm-8">
                    <input type="text" class="form-control" id="ageproof" name="ageproof" placeholder="Age Proof " readonly/>
                  </div>
              </div>
              <div class="form-group">
                  <label for="idparents" class="col-sm-4 control-label">Identity of Parents : </label>
                  <div class="col-sm-8">
                    <input type="text" class="form-control" id="idparents" name="idparents" placeholder="Identity of Parents" readonly/>
                  </div>
              </div>

              <div class="form-group">
                  <label for="sthobby" class="col-sm-4 control-label">Student Hobby : </label>
                  <div class="col-sm-8">
                    <input type="text" class="form-control" id="sthobby" name="sthobby" placeholder="Student Hobby"/>
                  </div>
              </div>
              <div class="form-group">
                  <label for="stinterest" class="col-sm-4 control-label">Student interested in : </label>
                  <div class="col-sm-8">
                    <input type="text" class="form-control" id="stinterest" name="stinterest" placeholder="Student interested in"/>
                  </div>
              </div>
              <div class="form-group">
                  <label for="disease" class="col-sm-4 control-label">Diseases : </label>
                  <div class="col-sm-8">
                    <input type="text" class="form-control" id="disease" name="disease" placeholder="Diseases"/>
                  </div>
              </div>
              <div class="form-group">
                  <label for="exdetail" class="col-sm-4 control-label">Extra Details of Students : </label>
                  <div class="col-sm-8">
                    <input type="text" class="form-control" id="exdetail" name="exdetail" placeholder="Extra Details of Students"/>
                  </div>
              </div>
             
            

              </div>
              <!-- /col-md-6 -->

              <div class="col-md-6">
                          
                <div class="form-group">
                  <label for="editClassName" class="col-sm-4 control-label">Class</label>
                  <div class="col-sm-8">
                    <select class="form-control" name="editClassName" id="editClassName">
                    <option value="" >Select</option>
                    <?php foreach ($classData as $key => $value) { ?>
                      <option value="<?php echo $value['class_id'] ?>" ><?php echo $value['class_name'] ?></option>
                    <?php } // /forwach ?>
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

              <div class="form-group">
                  <label for="editDob" class="col-sm-4 control-label">DOB: </label>
                  <div class="col-sm-8">
                      <input type="text" class="form-control" id="editDob" name="editDob" placeholder="Date of Birth" />
                  </div>
                </div>
                <div class="form-group">
                  <label for="editSex" class="col-sm-4 control-label">Sex: </label>
                  <div class="col-sm-8">
                  <input type="text" class="form-control" id="editSex" name="editSex" placeholder="Sex" readonly/>
            </div>
                </div>
              
                <div class="form-group">
                  <label for="weight" class="col-sm-4 control-label">Weight: </label>
                  <div class="col-sm-8">
                      <input type="text" class="form-control" id="weight" name="weight" placeholder="Weight" />
                  </div>
                </div>  
                <div class="form-group">
                  <label for="height" class="col-sm-4 control-label">Height: </label>
                  <div class="col-sm-8">
                      <input type="text" class="form-control" id="height" name="height" placeholder="Height" />
                  </div>
                </div>  
                <div class="form-group">
                  <label for="religion" class="col-sm-4 control-label">Religion: </label>
                  <div class="col-sm-8">
                      <input type="text" class="form-control" id="religion" name="religion" placeholder="Religion" />
                  </div>
                </div>


                <div class="form-group">
              <label for="category" class="col-sm-4 control-label">Category</label>
              <div class="col-sm-8">
                <input type="text" class="form-control" id="category" name="category" placeholder="Category" autocomplete="off">
            </div>
            </div> 
            <div class="form-group">
              <label for="paddress" class="col-sm-4 control-label">Full Postal Address</label>
              <div class="col-sm-8">
                <input type="text" class="form-control" id="paddress" name="paddress" placeholder="Full Postal Address" autocomplete="off">
            </div>
            </div> 
            <div class="form-group">
              <label for="pphone" class="col-sm-4 control-label">Phone</label>
              <div class="col-sm-8">
                <input type="text" class="form-control" id="pphone" name="pphone" placeholder="+91 1234 5678 90" autocomplete="off">
            </div>
            </div> 
            <div class="form-group">
              <label for="faddress" class="col-sm-4 control-label">Full Permanent Address</label>
              <div class="col-sm-8">
                <input type="text" class="form-control" id="faddress" name="faddress" placeholder="Full Permanent Address" autocomplete="off" readonly>
            </div>
            </div> 
            <div class="form-group">
              <label for="fphone" class="col-sm-4 control-label">Phone</label>
              <div class="col-sm-8">
                <input type="text" class="form-control" id="fphone" name="fphone" placeholder="+91 1234 5678 90" autocomplete="off">
            </div>
            </div> 
            <div class="form-group">
              <label for="foccupation" class="col-sm-4 control-label">Father's Occupation</label>
              <div class="col-sm-8">
                <input type="text" class="form-control" id="foccupation" name="foccupation" placeholder="Father's Occupation" autocomplete="off">
            </div>
            </div> 
            <div class="form-group">
              <label for="moccupation" class="col-sm-4 control-label">Mother's Occupation</label>
              <div class="col-sm-8">
                <input type="text" class="form-control" id="moccupation" name="moccupation" placeholder="Mother's Occupation" autocomplete="off">
            </div>
            </div> 
            <div class="form-group">
              <label for="bplno" class="col-sm-4 control-label">BPL No.</label>
              <div class="col-sm-8">
                <input type="text" class="form-control" id="bplno" name="bplno" placeholder="BPL No." autocomplete="off">
            </div>
            </div> 
            <div class="form-group">
              <label for="stadhar" class="col-sm-4 control-label">Adhar Card No. of Student</label>
              <div class="col-sm-8">
                <input type="text" class="form-control" id="stadhar" name="stadhar" placeholder="0000 0000 0000" autocomplete="off">
            </div>
            </div> 
            <div class="form-group">
              <label for="parentsadhar" class="col-sm-4 control-label">Adhar Card No. of Parents</label>
              <div class="col-sm-8">
                <input type="text" class="form-control" id="parentsadhar" name="parentsadhar" placeholder="Adhar Card No. of Parents" autocomplete="off">
            </div>
            </div> 
            <div class="form-group">
              <label for="stbank" class="col-sm-4 control-label">Bank Account No. of student</label>
              <div class="col-sm-8">
                <input type="text" class="form-control" id="stbank" name="stbank" placeholder="Bank Account No. of student" autocomplete="off">
            </div>
            </div> 
            <div class="form-group">
              <label for="stifsc" class="col-sm-4 control-label">IFSC Code</label>
              <div class="col-sm-8">
                <input type="text" class="form-control" id="stifsc" name="stifsc" placeholder="IFSC Code" autocomplete="off">
            </div>
            </div> 
            <div class="form-group">
              <label for="email" class="col-sm-4 control-label">Email ID</label>
              <div class="col-sm-8">
                <input type="text" class="form-control" id="email" name="email" placeholder="Email ID" autocomplete="off">
            </div>
            </div> 
            <div class="form-group">
              <label for="language" class="col-sm-4 control-label">Language spoken at home</label>
              <div class="col-sm-8">
                <input type="text" class="form-control" id="language" name="language" placeholder="Language spoken at home" autocomplete="off">
            </div>
            </div> 
            <div class="form-group">
              <label for="prschool" class="col-sm-4 control-label">Previous School</label>
              <div class="col-sm-8">
                <input type="text" class="form-control" id="prschool" name="prschool" placeholder="Previous School" autocomplete="off">
            </div>
            </div> 
            <div class="form-group">
              <label for="gdname" class="col-sm-4 control-label">Gaurdian's Full Name</label>
              <div class="col-sm-8">
                <input type="text" class="form-control" id="gdname" name="gdname" placeholder="Gaurdian's Full Name" autocomplete="off">
            </div>
            </div> 
            <div class="form-group">
              <label for="admssionno" class="col-sm-4 control-label">Admission No.</label>
              <div class="col-sm-8">
                <input type="text" class="form-control" id="admssionno" name="admssionno" placeholder="Admission No." autocomplete="off" >
            </div>
            </div> 

            <div class="form-group">
              <label for="admissionDate" class="col-sm-4 control-label">Admission Date</label>
              <div class="col-sm-8">
              <input type="date" class="form-control" id="admissionDate" name="admissionDate" placeholder="Admission Date" autocomplete="off">
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
