<?php 
	class Employee {
    	private $db;
      	
      	public function __construct() {
        	$this->db = new Database; // instantiate the database class from libraries folder
        }
      
      	// we can use $this->db to access the method such as  query, insert etc
      	// get the total number of employees
      	public function getTotalEmployees() {
        	$this->db->query("SELECT COUNT(*) FROM EMPLOYEE");
          	// store the result
          	$result = $this->db->resultSet(); // 9
          	return $result; // return the result
        }
      
      	public function getAllEmployeesFromDb() {
        	$this->db->query("SELECT Ssn, Fname, Lname, Address, Salary, Dno FROM EMPLOYEE");
          	$result = $this->db->resultSet();
          	return $result;
        }
      
      	// checks if a ssn exists or not
      	public function doesSsnExist($ssn) {
        	$this->db->query("SELECT * FROM EMPLOYEE WHERE Ssn = " . $ssn);
          	$this->db->execute();
          	
          	if($this->db->rowCount() > 0) {
            	return true; // meaning the ssn does not exist which is an error
            }
          	return false; // does not exist!
        }
      
      	// check if the dno exists in the department table
      	public function doesDnoExist($dno) {
        	$this->db->query("SELECT * FROM DEPARTMENT WHERE Dnumber = " . $dno);
          	$this->db->execute();
          	
          	if($this->db->rowCount() <= 0) {
            	return true; // meaning the department number does not exist (error)
            }
          	return false; // exists! Good to go..
        }
      
      	public function submitData($data) {
        	$ssn = $data['ssn'];
          	$fname = $data['fname'];
          	$minit = $data['m-initial'];
          	$lname = $data['lname'];
            $bdate = $data['bdate'];
            $address = $data['address'];
            $salary = $data['salary'];
            $sex = $data['sex'];
            $super_ssn = $data['super_ssn'];
            $dno = $data['dno'];
            
          	if($sex != "NULL") {
            	$sex = "'$sex'";
            }
          
          	if($super_ssn != "NULL") {
            	$super_ssn = "'$super_ssn'";
            }
          
          	if($minit != "NULL") {
            	$minit = "'$minit'";
            }
          
          	if($bdate != "NULL") {
            	$bdate = "'$bdate'";
            }
			//echo $bdate;
          	$this->db->query("INSERT INTO `EMPLOYEE` (Fname, Minit, Lname, Ssn, Bdate, Address, Sex, Salary, Super_ssn, Dno) VALUES ('$fname', $minit, '$lname', '$ssn', $bdate, '$address', $sex, $salary, $super_ssn, $dno)");
          	$this->db->execute();
        }
      
      	// method to delete an existing employee
      	public function deleteEmployee($ssn) {
        	$query = "DELETE FROM EMPLOYEE WHERE Ssn = $ssn";
          	$this->db->query($query);
          	$this->db->execute();
        }
      
      	// get all employee data
      	public function getAllEmployeeData($ssn) {
        	$this->db->query("SELECT * FROM EMPLOYEE WHERE Ssn = $ssn");
          	$result = $this->db->resultSet();
          	return $result;
        }
    }
?>