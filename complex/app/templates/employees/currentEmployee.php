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
    <title>Current Employee</title>
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
        <h1 style="text-align:center;" class="display-5">EMPLOYEE: <?php echo $_GET['Ssn'];?></h1>
        <hr class="my-4">
        <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.
         It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum</p>
    </div>
    
    <div class="container">
      <div class="p-5">
       <div class="col-md-20">
          <div class="card">
            <div class="card-header">Employee Information</div>
             <div class="card-body">
               	<h4 class="card-title"><b><?php echo $data['Fname'] . " " . $data['Lname']; ?></b></h4>
                <p class="card-text">Vivamus pellentesque, felis in aliquam ullamcorper, lorem tortor porttitor erat, hendrerit porta nunc tellus eu lectus. Ut vel imperdiet est. Pellentesque condimentum, dui et blandit laoreet, quam nisi tincidunt tortor</p>
                <div class="card-text mb-3">
                  <p><b>First Name:</b> <?php echo $data['Fname']; ?></p>
                  <p><b>Middle Initials:</b> <?php echo $data['Minit']; ?></p>
                  <p><b>Last Name:</b> <?php echo $data['Lname']; ?></p>
                  <p><b>Social Security Number:</b> <?php echo $data['Ssn']; ?></p>
                  <p><b>Birthdate:</b> <?php echo $data['Bdate']; ?></p>
                  <p><b>Address:</b> <?php echo $data['Address']; ?></p>
                  <p><b>Sex:</b> <?php echo $data['Sex']; ?></p>
                  <p><b>Salary:</b> <?php echo $data['Salary']; ?></p>
                  <p><b>Super Social Secruity Number:</b> <?php echo $data['Super_ssn']; ?></p>
                  <p><b>Department Number:</b> <?php echo $data['Dno']; ?></p>
                </div>
                <a class="btn btn-primary" href="https://jawaid11.myweb.cs.uwindsor.ca/complex/employees">All Employees</a>
             </div>
          </div>
       </div>
      </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  </body>
</html>


