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
    <title>Employee</title>
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
                    <a class="nav-link active" href="https://jawaid11.myweb.cs.uwindsor.ca/complex/employees">Employees</a>
                    <a class="nav-link" href="https://jawaid11.myweb.cs.uwindsor.ca/complex/projects">Projects</a>
                    <a class="nav-link" href="https://jawaid11.myweb.cs.uwindsor.ca/complex/departments">Departments</a>
                  </div>
              </div>
          </div>
      </nav>
    </header>
    
    <!-- Error if user enters an incorrect ssn -->
   	<?php if(!empty($_GET['ssnE'])){?>
    	<div class="alert alert-danger alert-dismissible mb-0">
          <?php echo $_GET['ssnE']; ?>
        </div>
    <?php }?>
     
    <!-- Error if user enters an incorrect dno -->
   	<?php if(!empty($_GET['dnoE'])){?>
    	<div class="alert alert-danger alert-dismissible mb-0">
          <?php echo $_GET['dnoE']; ?>
        </div>
    <?php }?>
    
    <!-- Error if user enters an incorrect super ssn -->
   	<?php if(!empty($_GET['superSE'])){?>
    	<div class="alert alert-danger alert-dismissible mb-0">
          <?php echo $_GET['superSE']; ?>
        </div>
    <?php }?>
    
    <!-- Employee Section -->
    <div class="jumbotron">
      <h1 class="display-4">EMPLOYEES</h1>
      <hr class="my-4">
      <p>It uses utility classes for typography and spacing to space content out within the larger container.</p>
      <div class="d-md-flex justify-content-between align-items-center">
        <!-- Get total number of employees -->
        <p class="lead bg-primary text-white p-2 mb-2 rounded">Total number of employees: <span style="color:#07F22D;"><?php echo $second_data['totalEmployees'][0]["COUNT(*)"]; ?></span></p>
        <!-- Add an employee button -->
        <button type="button" class="btn btn-outline-primary waves-effect" data-bs-toggle="modal" data-bs-target="#exampleModal"><i class="fas fa-plus pr-2" aria-hidden="true"></i>Add Employee</button>
        <!-- CSV export feature -->
        <form action="<?php echo URLROOT; ?>/employees/index" method="POST">
        	<input type="submit" class="btn btn-success" name="exportCSV" value="CSV Export"/>
        </form>
      </div>
      <!-- search an employee -->
      <div class="input-group rounded" style="margin-top: 20px;">
        <input type="search" class="form-control rounded" placeholder="Search an employee" aria-label="Search"
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
                  <th scope="col"><b>Social Security Number</b></th>
                  <th scope="col"><b>First name</b></th>
                  <th scope="col"><b>Last name</b></th>
                  <th scope="col"><b>Address</b></th>
                  <th scope="col"><b>Salary</b></th>
                  <th scope="col"><b>Department Number</b></th>
                  <th scope="col"><b>Remove</b></th>
                </tr>
              </thead>
              <tbody id="table-data">
                <?php foreach ($data as $row) { ?>
                <tr>
                  <td scope="row"><a href="<?php echo URLROOT; ?>/employees/currentEmployee?Ssn=<?php echo $row['Ssn'];?>"><?php echo $row['Ssn'];?></a></td>
                  <td><?php echo $row['Fname'];?></td>
                  <td><?php echo $row['Lname'];?></td>
                  <td><?php echo $row['Address'];?></td>
                  <td><?php echo $row['Salary'];?></td>
                  <td><?php echo $row['Dno'];?></td>
                  <td>
                    <button type="button" class="btn btn-danger delete-btn"><i class="far fa-trash-alt"></i></button>
                  </td>
                </tr>
              <?php }?>
              </tbody>
            </table>
      </div>
    </div>
    
    <!-- Modal to an add employee -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Enter employee information</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <form action="<?php echo URLROOT; ?>/employees/index" method="POST">
    			<div class="form-group">
      				<label for="ssn">Social Security Number:*</label>
      				<input type="text" class="form-control" id="ssn" placeholder="Enter social security sumber" name="ssn" minlength="9" maxlength="9">
    			</div>
              	<div class="form-group">
      				<label for="fname">First name:*</label>
      				<input type="text" class="form-control" id="fname" placeholder="Enter first name" name="fname" onkeypress="return /[a-z]/i.test(event.key)" required>
    			</div>
            	<div class="form-group">
      				<label for="m-initial">Middle initials:</label>
      				<input type="text" class="form-control" id="m-initial" placeholder="Enter middle initials" name="m-initial">
    			</div>
              <div class="form-group">
      				<label for="lname">Last name:*</label>
      				<input type="text" class="form-control" id="lname" placeholder="Enter last name" name="lname" onkeypress="return /[a-z]/i.test(event.key)" required>
    		  </div>
              <div class="form-group">
      				<label for="bdate">Birthday:</label>
      				<input type="date" class="form-control" id="bdate" placeholder="Enter birthdate" name="bdate">
    		  </div>
              <div class="form-group">
      				<label for="address">Address:*</label>
      				<input type="text" class="form-control" id="address" placeholder="Enter address" name="address" required>
    		  </div>
              <div class="form-group">
      				<label for="salary">Salary:*</label>
      				<input type="number" class="form-control" id="salary" placeholder="Enter salary" name="salary" min="1000" required>
    		  </div>
              <div class="form-group">
      				<label for="sex">Sex:</label>
      				<input type="text" class="form-control" id="sex" placeholder="Enter sex" name="sex">
    		  </div>
              <div class="form-group">
      				<label for="super_ssn">Super SSN:</label>
      				<input type="text" class="form-control" id="super_ssn" placeholder="Enter super ssn" name="super_ssn" minlength="9" maxlength="9">
    		  </div>
              <div class="form-group">
      				<label for="dno">Department Number:*</label>
      				<input type="number" class="form-control" id="dno" placeholder="Enter department number" name="dno" required>
    		  </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary" name="insertEmployee">Submit</button>
          		</div>
  			</form>
          </div>
        </div>
      </div>
    </div>
    
    <!-- Modal to an remove employee -->
    <div class="modal fade" id="deleteEmployeeModal" tabindex="-1" aria-labelledby="deleteEmployeeModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title" id="deleteEmployeeModallLabel">Delete employee</h4>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <h5>Are you sure you want to delete?</h5>
            <form action="<?php echo URLROOT; ?>/employees/index" method="POST">
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
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    
    <script>
      	// to make sure ssn is only numbers and length of 9
    	$("#ssn").keyup(function() {
   	 		$("#ssn").val(this.value.match(/[0-9]*/));
		});
      
      	$("#super_ssn").keyup(function() {
   	 		$("#super_ssn").val(this.value.match(/[0-9]*/));
		});
      
      	$(document).ready(function() {
        	$('.delete-btn').on('click', function() {
            	$('#deleteEmployeeModal').modal('show');
              
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
    </script>
  </body>
</html>

