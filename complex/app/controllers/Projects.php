<?php
class Projects extends Controller {
    public function __construct() {
        $this->projectModel = $this->model('Project');
    }

    public function index() {
      	$third_data = [
              'pname' => '',
              'pnumber' => '',
              'plocation' => '',
              'dno' => '',
              'pnumberError' => '',
              'dnoError' => ''
         ];
      
      	// check if any post request has been submited from view
      	if($_SERVER['REQUEST_METHOD'] == 'POST'){
        	$_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
          	
          	// for removing data
          	if(isset($_POST['delete-btn'])) {
                $pnumber = $_POST['delete_id'];
              	// if succesfull redirect with no errors
              	$this->projectModel->removeProject($pnumber);
              	header("Location: https://jawaid11.myweb.cs.uwindsor.ca/complex/projects"); // redirect user to the department page
            }
          	// for downloading csv
          	else if(isset($_POST['exportCSV'])) {
              	header('Content-Type: text/csv; charset=utf-8');
              	header('Content-Disposition: attachment; filename=projectsData.csv');
                            
              	$output = fopen("php://output", "w");
              	fputcsv($output, array('Pname', 'Pnumber', 'Plocation', 'Dnum'));
              	
              	$projects = $this->projectModel->getAllProjectsFromDb();
              	$projects = json_decode(json_encode($projects), true);
              
              	foreach ($projects as $project) {
                  	$dataToPut = array($project['Pname'], $project['Pnumber'], $project['Plocation'], $project['Dnum']);
                 	fputcsv($output, $dataToPut); // add the data to the csv file
                }
              	fclose($output);
              	die();
            }
          	// for inserting works_on
          	else if(isset($_POST['insertWorksOn'])) {
              	$works_on_data = [
                	'essn' => $_POST['essn'],
                  	'p-number' => $_POST['p-number'],
                  	'hours' => $_POST['hours'],
                  	'essnError' => '',
                  	'p-numberError' => ''
                ];
              
            	// check if ssn exists, if not then set essnError the error message:
                if($this->projectModel->findSsn($works_on_data['essn'])) {
                 	$works_on_data['essnError'] = 'Error with the SSN. Try again!';
                }
              	
                // check if project number exists:
                if($this->projectModel->findProjectNumber($works_on_data['p-number']) == false) {
                	$works_on_data['p-numberError'] = 'Project number does not exist. Try again!';
                }
              	
              	// check if project hours is null
              	if(empty($works_on_data['hours'])) {
                	$works_on_data['hours'] = "NULL";
                }
              
              	// check if the errors are empty
              	if(empty($works_on_data['essnError']) && empty($works_on_data['p-numberError'])) {
                	// insert to work_on
                  	$this->projectModel->worksOn($works_on_data);
                  	header("Location: https://jawaid11.myweb.cs.uwindsor.ca/complex/projects");
                }
              	else {
                	$error = "?essnError=".$works_on_data['essnError']."&pnoError=".$works_on_data['p-numberError'];
                  	header("Location: https://jawaid11.myweb.cs.uwindsor.ca/complex/projects" . $error); 
                }
            }
          	// for inserting data
          	else {
            	$third_data = [
                    'pname' => $_POST['pname'],
                    'pnumber' => trim($_POST['pnumber']),
                    'plocation' => trim($_POST['plocation']),
                    'dno' => trim($_POST['dno']),
                    'pnumberError' => '',
                    'dnoError' => ''
               ];
             
              // check if project number already exists or not. If true THEN ERROR.
              if($this->projectModel->findProjectNumber($third_data['pnumber'])) {
                  $third_data['pnumberError'] = 'The project number already exists!';
              }
              
              // check if department number even exists or not
              if($this->projectModel->findDepartmentNumber($third_data['dno'])) {
                  $third_data['dnoError'] = 'The deparment number does not exist!';
              }
              
              // check if the project location is empty:
              if(empty($third_data['plocation'])) {
                  $third_data['plocation'] = "NULL";
              }
              
              if(empty($third_data['pnumberError']) && empty($third_data['dnoError'])) {
                  $this->projectModel->submitData($third_data);
                  header("Location: https://jawaid11.myweb.cs.uwindsor.ca/complex/projects"); // redirect user to the department page
              }
              else {
                  $error = "?pnumberError=".$third_data['pnumberError']."&dnoError=".$third_data['dnoError'];
                  header("Location: https://jawaid11.myweb.cs.uwindsor.ca/complex/projects" . $error); 
              }
           }
        }
      	// to get all total number of projects
      	$totalProjects = $this->projectModel->getTotalProjects();
      	$totalProjects = json_decode(json_encode($totalProjects), true); // OK
      
      	// to get all the projects and their data
      	$allProjectsInDB = $this->projectModel->getAllProjectsFromDb();
      	$allProjectsInDB = json_decode(json_encode($allProjectsInDB), true);
      	
      	// send data to view
      	$this->view('projects/index', $allProjectsInDB, $totalProjects);
    }
  
  	// when user clicks on a project number to get more information
  	public function currentProject() {
      	
      	if(isset($_POST['remove-btn'])) {
        	$essn = $_POST['essn_id'];
          	$pnoVar = $_POST['pno_id'];
          	print_r($_POST);
          	// remove employee from project
          	$this->projectModel->removeFromWorksOn($essn, $pnoVar);
          	// redirect to the same page with the same project number
          	header("Location: https://jawaid11.myweb.cs.uwindsor.ca/complex/projects/currentProject?Pnumber=" . $pnoVar); 
        }
      	else if(isset($_POST['updateHours'])) {
        	$updateSsn = $_POST['update_ssn_id'];
          	$updatePno = $_POST['update_pno_id'];
          	$updateHours = $_POST['hours_update'];
          
          	$this->projectModel->updateEmployeeProjectHours($updateSsn, $updatePno, $updateHours);
          	header("Location: https://jawaid11.myweb.cs.uwindsor.ca/complex/projects/currentProject?Pnumber=" . $updatePno); 
        }
        $pno = $_GET['Pnumber'];
          	
        $locations = $this->projectModel->getProjectLocations($pno);
        $locations = json_decode(json_encode($locations), true);
          
        $totalNumEmployees = $this->projectModel->getTotalNumEmployees($pno);
        $totalNumEmployees = json_decode(json_encode($totalNumEmployees), true);
          
        $projectName = $this->projectModel->getProjectName($pno);
        $projectName = json_decode(json_encode($projectName), true);
          	
        $data = [$locations, $totalNumEmployees, $projectName];
          
        $employeeProjectData = $this->projectModel->getEmployeeProjectWork($pno);
        $employeeProjectData = json_decode(json_encode($employeeProjectData), true);
          	          	
	    $this->view('projects/currentProject', $data, $employeeProjectData);
        
    }
}