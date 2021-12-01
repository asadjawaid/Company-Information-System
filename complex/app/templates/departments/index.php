<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
	<!-- Font Awesome -->
	<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" rel="stylesheet"/>
    <!-- MDB -->
	<link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/3.6.0/mdb.min.css" rel="stylesheet"/>
    <title>Department</title>
  </head>
  <body>
    <header>
      <!-- Navbar -->
      <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
          <div class="container-fluid">
              <a class="navbar-brand">LOGISTICS CO.</a>
              <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                  <span class="navbar-toggler-icon"></span>
              </button>
              <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                  <div class="navbar-nav">
                    <a class="nav-link" aria-current="page" href="https://jawaid11.myweb.cs.uwindsor.ca/complex/">Home</a>
                    <a class="nav-link" href="https://jawaid11.myweb.cs.uwindsor.ca/complex/employees">Employees</a>
                    <a class="nav-link" href="https://jawaid11.myweb.cs.uwindsor.ca/complex/projects">Projects</a>
                    <a class="nav-link active" href="https://jawaid11.myweb.cs.uwindsor.ca/complex/departments">Departments</a>
                  </div>
              </div>
          </div>
      </nav>
    </header>
    
    <!-- Error if user enters an incorrect department number -->
   	<?php if(!empty($_GET['dnoError'])){?>
    	<div class="alert alert-danger alert-dismissible mb-0">
          <?php echo $_GET['dnoError']; ?>
        </div>
    <?php }?>
    
    <!-- Error if user enters an incorrect department number -->
   	<?php if(!empty($_GET['ssnError'])){?>
    	<div class="alert alert-danger alert-dismissible mb-0">
          <?php echo $_GET['ssnError']; ?>
        </div>
    <?php }?>
    
    <!-- Department Section -->
    <div class="jumbotron">
      <h1 class="display-4">DEPARTMENTS</h1>
      <hr class="my-4">
      <p>It uses utility classes for typography and spacing to space content out within the larger container.</p>
      <div class="d-md-flex justify-content-between align-items-center">
        <p class="lead bg-primary text-white p-2 mb-2 rounded">Total number of departments: <span style="color:#07F22D;"><?php echo $second_data[0]["COUNT(*)"]; ?></span></p>
        <button type="button" class="btn btn-outline-primary waves-effect" data-bs-toggle="modal" data-bs-target="#exampleModal"><i class="fas fa-plus pr-2" aria-hidden="true"></i>Add department</button>
        <form action="<?php echo URLROOT; ?>/departments/index" method="POST">
        	<input type="submit" class="btn btn-success" name="exportCSV" value="CSV Export"/>
        </form>
      </div>
      <div class="input-group rounded" style="margin-top: 20px;">
        <input type="search" class="form-control rounded" placeholder="Search a department" aria-label="Search"
        aria-describedby="search-addon" id="search-input"/>
        <span class="input-group-text border-0" id="search-addon">
          <i class="fas fa-search"></i>
        </span>
      </div>
    </div>
    
    <!-- Table data -->
    <div class="card">
      <div class="card-body">
        	<table class="table">
              <thead>
                <tr>
                  <th scope="col"><b>Department Number</b></th>
                  <th scope="col"><b>Department Name</b></th>
                  <th scope="col"><b>Manager Social Secruity Number</b></th>
                  <th scope="col"><b>Manager Start Date</b></th>
                  <th scope="col"><b>Remove</b></th>
                </tr>
              </thead>
              <tbody id="table-data">
                <?php foreach ($data as $row) { ?>
                <tr>
                  <td scope="row"><a href="<?php echo URLROOT; ?>/departments/currentDepartment?Dnumber=<?php echo $row['Dnumber'];?>"><?php echo $row['Dnumber'];?></a></td>
                  <td><?php echo $row['Dname'];?></td>
                  <td><?php echo $row['Mgr_ssn'];?></td>
                  <td><?php echo $row['Mgr_start_date'];?></td>
                  <td>
                    <button type="button" class="btn btn-danger delete-btn"><i class="far fa-trash-alt"></i></button>
                  </td>
                </tr>
              <?php }?>
              </tbody>
            </table>
      </div>
    </div>
    
    <!-- Modal to an add a department -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Enter department information</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <form action="<?php echo URLROOT; ?>/departments/index" method="POST">
    			<div class="form-group">
      				<label for="dname">Department Name:*</label>
      				<input type="text" class="form-control" id="dname" placeholder="Enter department name" name="dname" required onkeypress="return /[a-z]/i.test(event.key)">
    			</div>
              	<div class="form-group">
      				<label for="dnumber">Department Number:*</label>
      				<input type="number" class="form-control" id="dnumber" placeholder="Enter department number" name="dnumber" required min=1>
    			</div>
            	<div class="form-group">
      				<label for="mgr_ssn">Department Manager Ssn:*</label>
      				<input type="text" class="form-control" id="mgr_ssn" placeholder="Enter department manager SSN:" name="mgr_ssn" required>
    			</div>
              	<div class="modal-footer">
                  <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Close</button>
                  <button id="submit" type="submit" class="btn btn-primary" name="submit">Submit</button>
          		</div>
  			</form>
          </div>
        </div>
      </div>
    </div>
    
    <!-- Modal to an delete a department -->
    <div class="modal fade" id="deleteDepartmentModal" tabindex="-1" aria-labelledby="deleteDepartmentModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title" id="deleteDepartmentModalLabel">Delete department</h4>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <h5>Are you sure you want to delete?</h5>
            <form action="<?php echo URLROOT; ?>/departments/index" method="POST">
              	<div class="modal-footer">
                  <input type="hidden" name="delete_id" id="delete_id">
                  <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Close</button>
                  <button type="submit" class="btn btn-danger" name="delete-btn">Delete</button>
          		</div>
  			</form>
          </div>
        </div>
      </div>
    </div>
    
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    
    <script>
    	$(document).ready(function() {
        	$('.delete-btn').on('click', function() {
            	$('#deleteDepartmentModal').modal('show');
              
              	$tr = $(this).closest('tr');
              	
              	var data = $tr.children('td').map(function() {
                	return $(this).text();
                }).get();
              	console.log(data[0]);
              	$('#delete_id').val(data[0]);
            });
        });
      
      	$("#search-input").on('keyup', function() {
        	var value = $(this).val().toLowerCase();
          	//console.log(value);
          	
          	$("#table-data tr").filter(function() {
            	$(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
            }); 
        });
      
      	$("#exampleModal").modal({"backdrop": "static"});
    </script>
  </body>
</html>

