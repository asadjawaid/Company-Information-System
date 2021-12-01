<?php
class Employees extends Controller {
    public function __construct() {
        $this->employeeModel = $this->model('Employee'); // call the method model inside the Controller.php file to make a connnection to the database
    }

    public function index() {
      	$third_data = [
          'ssn' => '',
          'fname' => '',
          'm-initial' => '',
          'lname' => '',
          'bdate' => '',
          'address' => '',
          'salary' => '',
          'sex' => '',
          'super_ssn' => '',
          'dno' => '',
          'ssnError' => '',
          'fnameError' => '',
          'lnameError' => '',
          'dnoError' => '',
          'super_ssn_error' => ''
         ];
      	
      	// check if any post request has been submitted from the employee/index view
      	if($_SERVER['REQUEST_METHOD'] == 'POST') {
        	// santize post data
          	$_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
          	
          	// for deleting an employee
          	if(isset($_POST['delete-btn'])) {
            	$ssn = $_POST['delete_id'];
              	$this->employeeModel->deleteEmployee($ssn);
              	 header("Location: https://jawaid11.myweb.cs.uwindsor.ca/complex/employees"); // redirect the page
            }
          	// for exporting employee data as a csv format
          	else if(isset($_POST['exportCSV'])) {
              	header('Content-Type: text/csv; charset=utf-8');
              	header('Content-Disposition: attachment; filename=employeesData.csv');
                            
              	$output = fopen("php://output", "w");
              	fputcsv($output, array('Fname', 'Minit', 'Lname', 'Ssn', 'Bdate', 'Address', 'Sex', 'Salary', 'Super_ssn', 'Dno'));
              	
              	$employees = $this->employeeModel->getAllEmployeesFromDb();
              	$employees = json_decode(json_encode($employees), true);
              
              	foreach ($employees as $employee) {
                  	$dataToPut = array($employee['Fname'], $employee['Minit'], $employee['Lname'], $employee['Ssn'], $employee['Bdate'], $employee['Address'], $employee['Sex'], $employee['Salary'], $employee['Super_ssn'], $employee['Dno']);
                 	fputcsv($output, $dataToPut); // add the data to the csv file
                }
              	fclose($output);
              	die();
            }
          	// for inserting an employee
          	else {
              $third_data = [
                'ssn' => trim($_POST['ssn']),
                'fname' => trim($_POST['fname']),
                'm-initial' => trim($_POST['m-initial']),
                'lname' => trim($_POST['lname']),
                'bdate' => $_POST['bdate'],
                'address' => trim($_POST['address']),
                'salary' => trim($_POST['salary']),
                'sex' => trim($_POST['sex']),
                'super_ssn' => trim($_POST['super_ssn']),
                'dno' => trim($_POST['dno']),
                'ssnError' => '',
                'fnameError' => '',
                'lnameError' => '',
                'dnoError' => '',
                'super_ssn_error' => ''
               ];

              // CHECK FOR NULL VALUES: MINIT, BDATE, ADDRESS, SEX, SALARY, SUPER_SSN CAN BE NULL
              // IF MINIT IS EMPTY THEN SET IT AS NULL
              if(empty($third_data['m-initial'])) {
                  $third_data['m-initial'] = "NULL";
              }
              // IF BDATE IS EMPTY THEN SET IT AS NULL
              if(empty($third_data['bdate'])) {
                  $third_data['bdate'] = "NULL";
              }
              // convert to date format to insert sucessfully into database.
              else {
                  $third_data['bdate'] = date("Y-m-d", strtotime($third_data['bdate']));
              }
              // IF SEX IS EMPTY THEN SET IT AS NULL
              if(empty($third_data['sex'])) {
                  $third_data['sex'] = "NULL";
              }
              // IF SUPER_SSN IS EMPTY THEN SET IT AS NULL
              if(empty($third_data['super_ssn'])) {
                  $third_data['super_ssn'] = "NULL";
              }
              else {
                  // super_ssn must be nine characters only otherwise error
                  if(strlen($third_data['super_ssn']) != 9) {
                      $third_data['super_ssn_error'] = "Super SSN must be 9 characters!";
                  }
              }         	    	
              // ssn validation: MUST be 9 characters and should not already exist in the database
              if(strlen($third_data['ssn']) != 9) {
                  $third_data['ssnError'] = "SSN must be 9 characters!";
                  echo $third_data['ssnError'];
              }
              // check if the ssn already exists in the employee or not.
              if($this->employeeModel->doesSsnExist($third_data['ssn'])) {
                   $third_data['ssnError'] = "SSN already exists! Try again!";
                   echo $third_data['ssnError'];
              }

              // check if the dno exists in the department table
              if($this->employeeModel->doesDnoExist($third_data['dno'])) {
                  $third_data['dnoError'] = "The department number does not exist!";
                  echo $third_data['dnoError'];
              }

              // check if any of the errors contain any value. If they display the error and tell admin to check inputs.
              if(empty($third_data['ssnError']) && empty($third_data['dnoError']) && empty($third_data['super_ssn_error'])) {
                  // after successfully validating the data redirect the user to the employees page.
                  $this->employeeModel->submitData($third_data);
                  header("Location: https://jawaid11.myweb.cs.uwindsor.ca/complex/employees"); // redirect the page
              }
              else {
                  $err = "?ssnE=".$third_data['ssnError']."&dnoE=".$third_data['dnoError']."&superSE=".$third_data['super_ssn_error'];
                  header("Location: https://jawaid11.myweb.cs.uwindsor.ca/complex/employees" . $err); 
              }
           }
        }
      
      	$totalEmployees = $this->employeeModel->getTotalEmployees();// e.g should return 9
      	$totalEmployees = json_decode(json_encode($totalEmployees), true);
      	
      	$allEmployessInDB = $this->employeeModel->getAllEmployeesFromDb();
      	$allEmployessInDB = json_decode(json_encode($allEmployessInDB), true);
      
      	$totalNumEmployee = [
        	'totalEmployees' => $totalEmployees
        ];
      	
        $this->view('employees/index', $allEmployessInDB, $totalNumEmployee);
    }
  
  	public function currentEmployee() {
    	if(isset($_GET['Ssn'])) {
          	$ssn = $_GET['Ssn'];
			$allData = $this->employeeModel->getAllEmployeeData($ssn);
          	$allData = json_decode(json_encode($allData), true);
          
          	$data = $allData[0];
          	
	       	$this->view('employees/currentEmployee', $data);
        }
      else {
      	echo "NO IT IS NOT SET";
      }
    }
}

?>