<?php 
if($this->input->get('opt') == '' || !$this->input->get('opt')) {
  show_404();
} else {
?>
<div id="request" class="div-hide"><?php echo $this->input->get('opt'); ?></div>

<ol class="breadcrumb">
  <li><a href="<?php echo base_url('dashboard') ?>">Home</a></li> 
  <?php   
  if($this->input->get('opt') == 'mngms') {
    echo '<li class="active">Manage Marksheet</li>';
  } 
  else if ($this->input->get('opt') == 'mgmk') {
    echo '<li class="active">Manage Marks By Class</li>';
  }  
  else if ($this->input->get('opt') == 'mgmkk') {
    echo '<li class="active">Manage Marks By Class</li>';
  } 
  ?>  
</ol>

<?php if($this->input->get('opt') == 'mngms') {
// manage marksheet
?>
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
				} // /else		
				?>
			</div>

		</div>		
	</div>
	<!-- /col-md-4 -->

	<div class="col-md-8">
		<div class="panel panel-default">
		  <!-- Default panel contents -->
		  <div class="panel-heading">Manage Marksheet</div>
		  
		  <div class="panel-body">		  
		  	<div id="remove-message"></div>

		  	<div class="result"></div>
		  </div>			  
		</div>
	</div>
	<!-- /col-md-8 -->
</div>
<!-- /row -->
<?php
}  // /.manage marksheet
else if($this->input->get('opt') == 'mgmk') {
	// manage marks
?>
<script type="text/javascript">
$(document).on('keypress', 'input,select', function (e) {
    if (e.which == 13) {
        e.preventDefault();
        var $next = $('[tabIndex=' + (+this.tabIndex + 1) + ']');
        console.log($next.length);
        if (!$next.length) {
       $next = $('[tabIndex=1]');        }
        $next.focus() .click();
    }
});
</script>
<div class="panel panel-default">
  	<!-- Default panel contents -->
	<div class="panel-heading">Manage Marks</div>
	  
	<div class="panel-body">	
		<?php if ($this->session->flashdata('success')): ?>
        	<div class="alert alert-success"> <?php echo $this->session->flashdata('success'); ?> </div>
        <?php endif; ?>
        <?php if ($this->session->flashdata('error')): ?>
        	<div class="alert alert-error"> <?php echo $this->session->flashdata('error'); ?> </div>
        <?php endif; ?>
		<form method="post" action="marksheetsubject/fetchStudentMarksheet" class="form-horizontal" id="fetchStudentMarksheet">
		  	<div class="form-group">
		    	<label for="className" class="col-sm-2 control-label">Class</label>
		    	<div class="col-sm-10">
		    	  	<select class="form-control" name="className" id="className">
		      			<option value="">Select</option>
		      			<?php  
		      			foreach ($classData as $key => $value) {
		      				echo "<option value='".$value['class_id']."'>".$value['class_name']."</option>";
		      			} // /.foreach for class data
		      			?>
		      		</select>
		    	</div>
		  	</div>
			  
			  <div class="form-group">
		    	<label for="classNumericName" class="col-sm-2 control-label">Class Numeric Name</label>
		    	<div class="col-sm-10">
		      		<select class="form-control" name="classNumericName" id="classNumericName">
		      			<option value="">Select Class</option>
		      		</select>
		    	</div>
		  	</div>	  	
		  	<div class="form-group">
		    	<label for="marksheetName" class="col-sm-2 control-label">Marksheet</label>
		    	<div class="col-sm-10">
		      		<select class="form-control" name="marksheetName" id="marksheetName">
		      			<option value="">Select Class</option>
		      		</select>
		    	</div>
		  	</div>
			  <div class="form-group">
		    	<label for="subjectType" class="col-sm-2 control-label">Subject Type</label>
		    	<div class="col-sm-10">
		      		<select class="form-control" name="subjectType" id="subjectType">
					    <option value="">Select Class</option>
		      			
		      		</select>
		    	</div>
		  	</div>	
              <div class="form-group">
		    	<label for="marksheetSubject" class="col-sm-2 control-label">Subject</label>
		    	<div class="col-sm-10">
		      		<select class="form-control" name="marksheetSubject" id="marksheetSubject">
		      			<option value="">Select Class</option>
		      		</select>
		    	</div>
		  	</div>
			  <div class="form-group">
		    	<label for="marksheetSubjectCategory" class="col-sm-2 control-label">Subject (SubField)</label>
		    	<div class="col-sm-10">
				    <select class="form-control" name="marksheetSubjectCategory" id="marksheetSubjectCategory">
		      			<option value="">Select Class</option>
		      		</select>
		    	</div>
		  	</div>	  	
		  	<div class="form-group">
		    	<div class="col-sm-offset-2 col-sm-10">
		      		<button type="submit" class="btn btn-primary">Submit</button>
		    	</div>
		  	</div>
		</form>
	</div>			  
</div>

<form method="post" action="marksheetsubject/saveCustomMarks" class="form-horizontal" id="saveCustomMarks">
	<div id="marks-result"></div>
	<div class="form-group">
		<div id="saveCustomMarksData" style="display: none;" class="col-sm-offset-10 col-sm-10">
      		<button type="submit" class="btn btn-primary">Save</button>
    	</div>
	</div>
</form>
<?php
} // /.manage marks 

?>

<!-- create marksheet modal -->
<div class="modal fade" tabindex="-1" role="dialog" id="addMarksheetModal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Add Marksheet</h4>
      </div>
      <form action="marksheet/create" method="post" id="addMarksheetForm">
      <div class="modal-body">
          <div id="add-marksheet-message"></div>

		  <div class="form-group">
		    <label for="marksheetName">Marksheet Name</label>
		    <input type="text" class="form-control" id="marksheetName" name="marksheetName" placeholder="Marksheet Name" autocomplete="off">
		  </div>
		  <div class="form-group">
		    <label for="date">Exam Date: </label>		    
		    <input type="text" class="form-control" id="date" name="date" autocomplete="off" placeholder="Date" >
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

<!-- edit marksheet modal -->
<div class="modal fade" tabindex="-1" role="dialog" id="editMarksheetModal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Edit Marksheet</h4>
      </div>
      <form action="marksheet/update" method="post" id="editMarksheetForm">
      <div class="modal-body">
          <div id="edit-marksheet-message"></div>

		  <div class="form-group">
		    <label for="editMarksheetName">Marksheet Name</label>
		    <input type="text" class="form-control" id="editMarksheetName" name="editMarksheetName" placeholder="Marksheet Name" autocomplete="off">
		  </div>
		  <div class="form-group">
		    <label for="editDate">Exam Date: </label>		    
		    <input type="text" class="form-control" id="editDate" name="editDate" autocomplete="off" placeholder="Date" >
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

<!-- remove markshet modal -->
<div class="modal fade" tabindex="-1" role="dialog" id="removeMarksheetModal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Remove Marksheet</h4>
      </div>
      <div class="modal-body">
        <p>Do you really want to remove ?</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="removeMarksheetBtn">Save changes</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<!-- mark the stuent marks of the markshet modal -->
<div class="modal fade" tabindex="-1" role="dialog" id="editMarksModal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Edit Marksheet</h4>
      </div>
      <div class="modal-body">
      	<div id="edit-mark-message"></div>
        <div id="edit-mark-result"></div>
      </div>
      <!-- <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Save changes</button>
      </div> -->
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- view the stuent's marks of the markshet modal -->
<div class="modal fade" tabindex="-1" role="dialog" id="viewMarksModal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">View Marksheet</h4>
      </div>
      <div class="modal-body">      	
        <div id="view-mark-result"></div>
      </div>
      <!-- <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Save changes</button>
      </div> -->
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<script type="text/javascript" src="<?php echo base_url('custom/js/marksheetsubject.js') ?>"></script>

<?php 
} // .if to check for opt request
?>