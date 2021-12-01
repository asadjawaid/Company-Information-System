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
    <title>Current Project</title>
  </head>
  <body>
    <header>
      <!-- Navbar -->
      <nav class="navbar navbar-expand-lg navbar-dark bg-dark" style="">
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
                    <a class="nav-link" href="https://jawaid11.myweb.cs.uwindsor.ca/complex/departments">Departments</a>
                  </div>
              </div>
          </div>
      </nav>
    </header>
   
     <div class="jumbotron" style="padding: 1rem;">
        <h1 style="text-align:center;" class="display-5" id="header-pno">PROJECT: <?php echo $_GET['Pnumber'];?></h1>
        <hr class="my-4">
        <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.
         It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum</p>
    </div>
    
    <div class="container">
      <div class="p-5">
       <div class="col-md-20">
          <div class="card">
            <div class="card-header">Project Information</div>
             <div class="card-body">
               	<h4 class="card-title"><b><?php echo $data[2][0]['Pname']; ?></b></h4>
                <p class="card-text">Vivamus pellentesque, felis in aliquam ullamcorper, lorem tortor porttitor erat, hendrerit porta nunc tellus eu lectus. Ut vel imperdiet est. Pellentesque condimentum, dui et blandit laoreet, quam nisi tincidunt tortor</p>
                <div class="card-text mb-3">
                   <p><b>Project Number:</b> <?php echo $_GET['Pnumber'];?></p>
                   <p><b>Total number of employees under this project:</b> <?php echo $data[1][0]['COUNT(*)']?></p>
                   <p>
                     <b>Locations:</b>
                     <?php 
  						$locations = $data[0];
                     	foreach($locations as $location) {
            				echo $location['Plocation'] . " ";
						}
                     ?>
                  </p>
                </div>
                <a class="btn btn-primary" href="https://jawaid11.myweb.cs.uwindsor.ca/complex/projects">All Projects</a>
             </div>
          </div>
       </div>
      </div>
    </div>
    
    <!-- Container that generates cards based on how many employees work on the specfic project. If employees work for this project then we display and h1 -->
    <div class="container">
        <div class="row">
          	<!-- first -->
          	<?php if(!empty($second_data)) { ?>
              <?php foreach ($second_data as $val) { ?>
              <div class="col-lg-6 mb-4">
                  <div class="card">  
                      <div class="card-body">
                          <h5 class="card-title"><b><?php echo $val['Fname'] . " " . $val['Lname']; ?></b></h5>
                          <hr>	
                          <p class="card-text" id="essn"><b>SSN: </b><?php echo $val['Essn']; ?></p>
                          <p class="card-text" id="hours"><b>Hours Worked: </b><?php if(!empty($val['Hours'])) { echo $val['Hours']; } else { echo "0"; } ?></p>
                          <form action="<?php echo URLROOT; ?>/projects/currentProject" method="POST" style="display: inline;">
                              <input type="hidden" name="essn_id" class="essn_id">
                           	  <input type="hidden" name="pno_id" class="pno_id"> 	
                              <button type="submit" class="btn btn-danger btn-md mr-3 remove-btn" name="remove-btn">Remove</button>
                          </form>
                          <button type="submit" class="btn btn-success btn-md update-hours-btn" name="update-hours-btn">Update Hours</button>
                      </div>
                  </div>
              </div>
              <?php } ?>
          	<?php } else { ?>
          	<h1 style="text-align:center; text-transform: uppercase;">No employees work on <em>project <?php echo $_GET['Pnumber'];?></em></h1>
          	<?php } ?>
        </div>
    </div>
    
    <!-- Modal to an update an employees hours -->
    <div class="modal fade" id="updateModal" tabindex="-1" aria-labelledby="updateModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="updateModalLabel">Enter the information</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
             <form action="<?php echo URLROOT; ?>/projects/currentProject" method="POST">
              	<div class="form-group">
      				<label for="hours">Hours worked:</label>
      				<input type="number" class="form-control" id="hours-update" placeholder="Enter the number of hour(s)" name="hours_update" min="0" step="any">
    			</div>
              	<div class="modal-footer">
                  <input type="hidden" name="update_ssn_id" id="update_ssn_id">
                  <input type="hidden" name="update_pno_id" id="update_pno_id">
                  <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Close</button>
                  <button type="submit" class="btn btn-primary" name="updateHours">Update Hours</button>
          		</div>
  			</form>
          </div>
        </div>
      </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    
    <script>
      	
    	$(document).ready(function() {
        	$('.update-hours-btn').on('click', function() {
            	$('#updateModal').modal('show');
              	
              	$anch = $(this).closest('.card-body');
              	const pno = document.getElementById('header-pno').textContent.substring(9).trim(); // select h1 to get the pnumber
                
              	var ssnArr = $anch.children('#essn').map(function() { // #essn
                    return $(this).text();
                }).get();
              
              	var finalSsn = ssnArr[0].substring(5).trim();
              	console.log(pno);
              	$('#update_ssn_id').val(finalSsn);
                $('#update_pno_id').val(pno);
            });
        });
      
      	$(document).ready(function() {
            $('.remove-btn').click(function() {
                $anch = $(this).closest('.card-body'); // to get ssn

                const pno = document.getElementById('header-pno').textContent.substring(9).trim(); // select h1 to get the pnumber

                var ssnArr = $anch.children('#essn').map(function() { // #essn
                    return $(this).text();
                }).get();

                var finalSsn = ssnArr[0].substring(5).trim();
                console.log(finalSsn);
                $('.essn_id').val(finalSsn);
                $('.pno_id').val(pno);
            });
        });  
    </script>
  </body>
</html>