<?php 
	class Project {
    	private $db;
      	
      	public function __construct() {
        	$this->db = new Database; // instantiate the database class from libraries folder
        }
      
      	public function getTotalProjects() {
        	$this->db->query("SELECT COUNT(*) FROM PROJECT");
          	// store the result
          	$result = $this->db->resultSet();
          	return $result; // return the result
        }
      
      	public function getAllProjectsFromDb() {
        	$this->db->query("SELECT * FROM PROJECT");
          	$result = $this->db->resultSet();
          	return $result;
        }
      
      	// checks if a project number already exists in the project table
      	public function findProjectNumber($pnumber) {
        	$this->db->query("SELECT * FROM `PROJECT` WHERE Pnumber = " . $pnumber);
          	$this->db->execute();
          
          	if($this->db->rowCount() > 0) {
            	return true; // record return meaning the project number already exists!
            }
          	else {
            	return false; // no record returned
            }
        }
      
      	// checks if a department number exists in the department table
      	public function findDepartmentNumber($dno) {
        	$this->db->query("SELECT * FROM `DEPARTMENT` WHERE Dnumber = " . $dno);
          	$this->db->execute();
         
          	// checking the count of how many rows returned
          	if($this->db->rowCount() <= 0) {
            	return true; // record return. Error the dno dne
            }
          	else {
            	return false; // no record returned, good to go!
            }
        }
      
      	// submit data to the database
      	public function submitData($data) {
        	$pname = $data['pname'];
          	$pnumber = $data['pnumber'];
          	$plocation = $data['plocation'];
          	$dno = $data['dno'];
          
          	if($plocation != "NULL") {
            	$plocation = "'$plocation'";
            }
          	
          	$this->db->query("INSERT INTO `PROJECT`(`Pname`, `Pnumber`, `Plocation`, `Dnum`) VALUES ('$pname', $pnumber, $plocation, $dno)");
          	$this->db->execute();
        }
      
      	// method to delete a project
      	public function removeProject($pnumber) {
        	$query = "DELETE FROM PROJECT WHERE Pnumber = $pnumber";
          	$this->db->query($query);
          	$this->db->execute();
        }
      
      	// get project name
      	public function getProjectName($pno) {
        	$this->db->query("SELECT Pname FROM PROJECT WHERE Pnumber = $pno");
        	$result = $this->db->resultSet();
          	return $result;
        }
      
      	// get total employees working project $dno
      	public function getTotalNumEmployees($pno) {
        	$this->db->query("SELECT COUNT(*) FROM WORKS_ON WHERE Pno = $pno");
          	$result = $this->db->resultSet();
          	return $result;
        }
      
      	// get project locations
      	public function getProjectLocations($pno) {
        	$this->db->query("SELECT Plocation FROM PROJECT WHERE Pnumber = $pno;");
        	$result = $this->db->resultSet();
          	return $result;
        }
      
      	// find ssn method:
      	public function findSsn($essn) {
        	$this->db->query("SELECT * FROM EMPLOYEE WHERE Ssn = " . $essn);
          	$this->db->execute();
         
          	// checking the count of how many rows returned
          	if($this->db->rowCount() <= 0) {
            	return true; // record return. Error the ssn dne
            }
          	else {
            	return false; // no record returned, good to go!
            }
        }
      
      	// assign the employee to the project
      	public function worksOn($data) {
        	$essn = $data['essn'];
          	$pno = $data['p-number'];
          	$hours = $data['hours'];
          
          	if($hours != "NULL") {
            	$hours = "'$hours'";
            }
     
          	$this->db->query("INSERT INTO `WORKS_ON`(`Essn`, `Pno`, `Hours`) VALUES ('$essn', $pno, $hours)");
          	$this->db->execute();
        }
      
      	public function getEmployeeProjectWork($pno) {
        	$this->db->query("SELECT Essn, Hours, Fname, Lname FROM WORKS_ON JOIN EMPLOYEE ON Essn = Ssn WHERE Pno = " . $pno);
          	// store the result
          	$result = $this->db->resultSet();
          	return $result; // return the result
        }
      
      	// remove employee from works on table
      	public function removeFromWorksOn($essn, $pnoVar) {
        	$this->db->query("DELETE FROM WORKS_ON WHERE Essn = " . $essn . " AND Pno = " . $pnoVar);
          	$this->db->execute();
        }
      
      	// update project hours
      	public function updateEmployeeProjectHours($updateSsn, $updatePno, $updateHours) {
        	$this->db->query("UPDATE WORKS_ON SET Hours = $updateHours WHERE Essn = $updateSsn AND Pno = $updatePno");
          	$this->db->execute();
        }
    }
?>