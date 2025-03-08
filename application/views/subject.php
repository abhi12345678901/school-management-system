<ol class="breadcrumb">
  <li><a href="<?php echo base_url('dashboard') ?>">Home</a></li> 
  <li class="active">Manage Subject</li>
</ol>

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
	</div>
	<!-- /col-md-4 -->

	<div class="col-md-8">
		<div class="panel panel-default">
		  <!-- Default panel contents -->
		  <div class="panel-heading">Manage Subject</div>

		  <div class="panel-body">		  
		  	<div class="result"></div>
		  </div>			  
		</div>
	</div>
	<!-- /col-md-8 -->
</div>
<!-- /row -->

<!-- create section modal -->
<div class="modal fade" tabindex="-1" role="dialog" id="addSubjectModal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Add Subject</h4>
		<h4 class="modal-title"></h4>
      </div>
      <form action="subject/create" method="post" id="addSubjectForm">
      <div class="modal-body">
          <div id="add-subject-message"></div>

		  <div class="form-group">
		    <label for="sectionName">Subject Name</label>
		    <input type="text" class="form-control" id="subjectName" name="subjectName" placeholder="Subject Name">
		  </div>
		  <div class="form-group">
		    <label for="totalMark">Total Mark</label>
		    <input type="text" class="form-control" id="totalMark" name="totalMark" placeholder="Total Mark">
		  </div>
		  <div class="form-group">
		    <label for="teacherName">Teacher : </label>
		    <select class="form-control" name="teacherName" id="teacherName">
		    	<option value="">Select a Teacher</option>
		    	<?php 
		    	if($teacherData) { 
	    			foreach ($teacherData as $key => $value): ?>
			    		<option value="<?php echo $value['teacher_id'] ?>"><?php echo $value['fname'] . ' ' . $value['lname'] ?></option>
			    	<?php 
			    	endforeach 
			    	?>
	    		<?php
		    	} 
		    	else { ?>
		    		<option value="">No Data Available</option>
		    	<?php 
		    	}
		    	?>
		    </select>
		  </div>		  		 
		
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Save changes</button>
      </div>

      </form>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<!-- create additional subject modal -->
<div class="modal fade" tabindex="-1" role="dialog" id="addAdditionalSubjectModal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Add Additional Subject</h4>
      </div>
      <form action="subject/createAdditionalSubject" method="post" id="addAdditionalSubjectForm">
      <div class="modal-body">
          <div id="add-additional-subject-message"></div>

		  <div class="form-group">
		    <label for="aditionalSubjectName">Subject Name</label>
		    <input type="text" class="form-control" id="aditionalSubjectName" name="aditionalSubjectName" placeholder="Subject Name">
		  </div>
		  <div class="form-group">
		    <label for="aditionalSubjectTotalMark">Total Mark</label>
		    <input type="text" class="form-control" id="aditionalSubjectTotalMark" name="aditionalSubjectTotalMark" placeholder="Total Mark">
		  </div>
		  <div class="form-group">
		    <label for="aditionalSubjectTeacherName">Teacher : </label>
		    <select class="form-control" name="aditionalSubjectTeacherName" id="aditionalSubjectTeacherName">
		    	<option value="">Select a Teacher</option>
		    	<?php 
		    	if($teacherData) { 
	    			foreach ($teacherData as $key => $value): ?>
			    		<option value="<?php echo $value['teacher_id'] ?>"><?php echo $value['fname'] . ' ' . $value['lname'] ?></option>
			    	<?php 
			    	endforeach 
			    	?>
	    		<?php
		    	} 
		    	else { ?>
		    		<option value="">No Data Available</option>
		    	<?php 
		    	}
		    	?>
		    </select>
		  </div>		  		 
		
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Save changes</button>
      </div>

      </form>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<!-- update subject modal -->
<div class="modal fade" tabindex="-1" role="dialog" id="editSubjectModal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Edit Subject</h4>
      </div>
      <form action="subject/update" method="post" id="editSubjectForm">
      <div class="modal-body">
          <div id="edit-subject-messages"></div>

		  <div class="form-group">
		    <label for="editSubjectName">Subject Name</label>
		    <input type="text" class="form-control" id="editSubjectName" name="editSubjectName" placeholder="Subject Name">
		  </div>
		  <div class="form-group">
		    <label for="editTotalMark">Total Mark</label>
		    <input type="text" class="form-control" id="editTotalMark" name="editTotalMark" placeholder="Total Mark">
		  </div>
		  <div class="form-group">
		    <label for="editTeacherName">Teacher : </label>
		    <select class="form-control" name="editTeacherName" id="editTeacherName">
		    	<option value="">Select a Teacher</option>
		    	<?php 
		    	if($teacherData) { 
	    			foreach ($teacherData as $key => $value): ?>
			    		<option value="<?php echo $value['teacher_id'] ?>"><?php echo $value['fname'] . ' ' . $value['lname'] ?></option>
			    	<?php 
			    	endforeach 
			    	?>
	    		<?php
		    	} 
		    	else { ?>
		    		<option value="">No Data Available</option>
		    	<?php 
		    	}
		    	?>
		    </select>
		  </div>		  		 
		
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Save changes</button>
      </div>

      </form>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<!-- update additional subject modal -->
<div class="modal fade" tabindex="-1" role="dialog" id="editAdditionalSubjectModal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Edit Additional Subject</h4>
      </div>
      <form action="subject/updateAdditionalSubject" method="post" id="editAdditionalSubjectForm">
      <div class="modal-body">
          <div id="edit-additional-subject-messages"></div>

		  <div class="form-group">
		    <label for="editAdditionalSubjectName">Additional Subject Name</label>
		    <input type="text" class="form-control" id="editAdditionalSubjectName" name="editAdditionalSubjectName" placeholder="Additional Subject Name">
		  </div>
		  <div class="form-group">
		    <label for="editAdditionalTotalMark">Total Mark</label>
		    <input type="text" class="form-control" id="editAdditionalTotalMark" name="editAdditionalTotalMark" placeholder="Total Mark">
		  </div>
		  <div class="form-group">
		    <label for="editAdditionalTeacherName">Teacher : </label>
		    <select class="form-control" name="editAdditionalTeacherName" id="editAdditionalTeacherName">
		    	<option value="">Select a Teacher</option>
		    	<?php 
		    	if($teacherData) { 
	    			foreach ($teacherData as $key => $value): ?>
			    		<option value="<?php echo $value['teacher_id'] ?>"><?php echo $value['fname'] . ' ' . $value['lname'] ?></option>
			    	<?php 
			    	endforeach 
			    	?>
	    		<?php
		    	} 
		    	else { ?>
		    		<option value="">No Data Available</option>
		    	<?php 
		    	}
		    	?>
		    </select>
		  </div>		  		 
		
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Save changes</button>
      </div>

      </form>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- remove subject modal -->
<div class="modal fade" tabindex="-1" role="dialog" id="removeSubjectModal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Remove Subject</h4>
      </div>
      <div class="modal-body">
        <div id="remove-messages"></div>

        <p>Do you really want to remove ?</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="removeSubjectBtn">Save changes</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<!-- remove additional subject modal -->
<div class="modal fade" tabindex="-1" role="dialog" id="removeAdditionalSubjectModal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Remove Additional Subject</h4>
      </div>
      <div class="modal-body">
        <div id="remove-additional-subject-messages"></div>

        <p>Do you really want to remove ?</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="removeAdditioalSubjectBtn">Save changes</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<script type="text/javascript" src="<?php echo base_url('custom/js/subject.js') ?>"></script>