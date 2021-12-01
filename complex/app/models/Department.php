<?php 
	class Department {
    	private $db;
      	
      	public function __construct() {
        	$this->db = new Database; // instantiate the database class from libraries folder
        }
      
      	public function getTotalDepartments() {
        	$this->db->query("SELECT COUNT(*) FROM DEPARTMENT");
          	// store the result
          	$result = $this->db->resultSet();
          	return $result; // return the result
        }
      
      	public function getAllDepartmentsFromDb() {
        	$this->db->query("SELECT * FROM DEPARTMENT");
          	$result = $this->db->resultSet();
          	return $result;
        }
      
      	// used to check if a department exists
      	public function findDepartmentByDnum($dnumber) {
          	$this->db->query("SELECT * FROM `DEPARTMENT` WHERE Dnumber = " . $dnumber);
          	//$this->db->bind(':dnumber', $dnumber); // used to bind with the variable $dnumber
          	$this->db->execute();
         
          	// checking the count of how many rows returned
          	if($this->db->rowCount() > 0) {
            	return true; // record return
            }
          	else {
            	return false; // no record returned
            }
        }
      
      	// used to check if the entered ssn exists in the employee table. Return true if it dne otherwise false.
      	public function findMgrSsn($mgr_ssn) {
        	$this->db->query("SELECT * FROM EMPLOYEE WHERE Ssn = " . $mgr_ssn);
          	$this->db->execute();
          	          	
          	if($this->db->rowCount() <= 0) {
            	return true; // meaning the ssn does not exists which is an error
            }
          	else {
            	return false;
            }
        }
      
      	// used to submit data from form
      	public function submitData($data) {
        	$dname = $data['dname'];
          	$dnum = $data['dnumber'];
          	$mgrSsn = $data['mgr_ssn'];
          	
          	$this->db->query("INSERT INTO `DEPARTMENT` (Dname, Dnumber, Mgr_ssn) VALUES ('$dname', $dnum, '$mgrSsn')");
          	$this->db->execute();
          	
        }
      
      	// delete department
      	public function removeDepartment($dnumber) {
          	$query = "DELETE FROM DEPARTMENT WHERE Dnumber = $dnumber";
          	$this->db->query($query);
          	$this->db->execute();
        }
     
      public function getLocations($dno) {
     		$this->db->query("SELECT Dlocation FROM DEPT_LOCATIONS WHERE Dnumber = $dno;");
        	$result = $this->db->resultSet();
          	return $result;
      }
      
      public function getTotalNumEmployees($dno) {
      		$this->db->query("SELECT COUNT(*) FROM EMPLOYEE WHERE Dno = $dno");
        	$result = $this->db->resultSet();
          	return $result;
      }
      
      // get name
      public function getDepartmentName($dno) {
      		$this->db->query("SELECT Dname FROM DEPARTMENT WHERE Dnumber = $dno");
        	$result = $this->db->resultSet();
          	return $result;
      }
    }
?>