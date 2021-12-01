<?php
// https://www.youtube.com/watch?v=e1oMBaWjye8 important video. Stamp: 41:50
class Departments extends Controller {
    public function __construct() {
        $this->departmentModel = $this->model('Department');
    }

    public function index() {
        
      	$third_data = [
              'dname' => '',
              'dnumber' => '',
              'mgr_ssn' => '',
              'dnumberError' => '',
              'mgr_ssn_Error' => ''
         ];
      
      	// check if any post request has been submited from view
      	if($_SERVER['REQUEST_METHOD'] == 'POST'){
          	
          	// santize post data
          	$_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
          
          	// for removing data
          	if(isset($_POST['delete-btn'])) {
            	$dnumber = $_POST['delete_id'];
              	$this->departmentModel->removeDepartment($dnumber);
              	header("Location: https://jawaid11.myweb.cs.uwindsor.ca/complex/departments"); // redirect user to the department page
            }
          	// for downloading csv
          	else if(isset($_POST['exportCSV'])) {
              	header('Content-Type: text/csv; charset=utf-8');
              	header('Content-Disposition: attachment; filename=departmentsData.csv');
                            
              	$output = fopen("php://output", "w");
              	fputcsv($output, array('Dname', 'Dnumber', 'Mgr_ssn', 'Mgr_start_date'));
              	
              	$departments = $this->departmentModel->getAllDepartmentsFromDb();
              	$departments = json_decode(json_encode($departments), true);
              
              	foreach ($departments as $department) {
                  	$dataToPut = array($department['Dname'], $department['Dnumber'], $department['Mgr_ssn'], $department['Mgr_start_date']);
                 	fputcsv($output, $dataToPut); // add the data to the csv file
                }
              	fclose($output);
              	die();
            }
          	else {
              $third_data = [
                  'dname' => trim($_POST['dname']),
                  'dnumber' => trim($_POST['dnumber']),
                  'mgr_ssn' => trim($_POST['mgr_ssn']),
                  'dnumberError' => '',
                  'mgr_ssn_Error' => ''
              ];

              // check if the dnumber already exists in the database. If theres already one in the db then give error otherwise continue!
              if($this->departmentModel->findDepartmentByDnum($third_data['dnumber'])) {
                  $third_data['dnumberError'] = 'The department number already exits!';
              }

              // validate manager ssn. Check if it exists in the Employee table...
              if($this->departmentModel->findMgrSsn($third_data['mgr_ssn'])) {
                  $third_data['mgr_ssn_Error'] = 'The ssn does not exists! Please enter a valid ssn!';
              } 

              // if there are no errors present then submit the data to the database otherwise redirect!
              if(empty($third_data['dnumberError']) && empty($third_data['mgr_ssn_Error'])) {
                  $this->departmentModel->submitData($third_data);
                  header("Location: https://jawaid11.myweb.cs.uwindsor.ca/complex/departments"); // redirect user to the department page
              }
              else {
                 $error = "?dnoError=".$third_data['dnumberError']."&ssnError=".$third_data['mgr_ssn_Error'];
                 header("Location: https://jawaid11.myweb.cs.uwindsor.ca/complex/departments" . $error); 
              }
            }
        } // end if
      
      	$totalNumDepartments = $this->departmentModel->getTotalDepartments();
      	$totalNumDepartments = json_decode(json_encode($totalNumDepartments), true); // OK
      
      	$allDepartments = $this->departmentModel->getAllDepartmentsFromDb();
      	$allDepartments = json_decode(json_encode($allDepartments), true);
      	
        $this->view('departments/index', $allDepartments, $totalNumDepartments, $third_data);
    }
  
  	// when user clicks on a department number to get more information
  	public function currentDepartment() {
      
    	if(isset($_GET['Dnumber'])) {
          	$dno = $_GET['Dnumber'];
          	// get locations
          	$locations = $this->departmentModel->getLocations($dno);
          	$locations = json_decode(json_encode($locations), true);
          	
          	// get total num of employees in this department
          	$totalNumEmployees = $this->departmentModel->getTotalNumEmployees($dno);
          	$totalNumEmployees = json_decode(json_encode($totalNumEmployees), true);
          	
          	// get department name
          	$departmentName = $this->departmentModel->getDepartmentName($dno);
          	$departmentName = json_decode(json_encode($departmentName), true);
          	          	
          	$data = [$locations, $totalNumEmployees, $departmentName];
          	
	       	$this->view('departments/currentDepartment', $data);
        }
      else {
      	echo "NO IT IS NOT SET";
      }
    }
}
?>