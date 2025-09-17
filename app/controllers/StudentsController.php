<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

/**
 * Controller: StudentsController
 * 
 * Automatically generated via CLI.
 */
class StudentsController extends Controller {
    public function __construct()
    {
        parent::__construct();
       

    }

    public function get_all(): void
    {
        var_dump(value: $this-> StudentsModel->all()); 
    }

    function create(): void
    {
        $data= array(
            'last_name'=> 'Deliveio',
            'first_name' => 'Shirin',
            'email' => 'deliverio@gmail.com'
        );
        if($this->StudentsModel->insert($data)){
            echo 'Inserted';
        }
       
    }

    function update(): void
    {
        $data = $this->StudentsModel->update(1, [
            'last_name'=> 'Deliverio',
            'first_name' => 'Chisty'
            
            
        ]);

        if($data){
            echo 'Updated';
        }
    }

    function delete(): void 
    {
         
        if($this->StudentsModel->delete(1)){
            echo 'Deleted';
        }

       
    }
     public function show_form() {

        // DB Connection
        $conn = new mysqli("localhost", "root", "", "mockdata");
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Handle insert
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $last_name  = $_POST['last_name'] ?? '';
            $first_name = $_POST['first_name'] ?? '';
            $email      = $_POST['email'] ?? '';

            $stmt = $conn->prepare("INSERT INTO students (last_name, first_name, email) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $last_name, $first_name, $email);
            $stmt->execute();
            $stmt->close();
        }

        // Get all students
        $result = $conn->query("SELECT * FROM students");
        $students = $result->fetch_all(MYSQLI_ASSOC);
        $conn->close();

        require __DIR__ . '/../views/students_view.php';
    }

     public function update_student()
{
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $id = isset($_POST['id']) ? (int) $_POST['id'] : 0;
        $last_name = $_POST['last_name'] ?? '';
        $first_name = $_POST['first_name'] ?? '';
        $email = $_POST['email'] ?? '';

        $conn = new mysqli("localhost", "root", "", "mockdata");
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $stmt = $conn->prepare("UPDATE students SET last_name = ?, first_name = ?, email = ? WHERE id = ?");
        $stmt->bind_param("sssi", $last_name, $first_name, $email, $id);

        if ($stmt->execute()) {
            header("Location: /students"); 
            exit;
        } else {
            echo "Failed to update student.";
        }

        $stmt->close();
        $conn->close();
    } else {
        echo "Invalid Request";
    }
}


   public function delete_student() 
   {
    
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $id = isset($_POST['id']) ? (int) $_POST['id'] : 0;

        if ($id <= 0) {
            echo "❌ Invalid student ID.";
            exit;
        }

        $conn = new mysqli("localhost", "root", "", "mockdata");
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $stmt = $conn->prepare("DELETE FROM students WHERE id = ?");
        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            header("Location: /students");
            exit;
        } else {
            echo "❌ Failed to delete student: " . $stmt->error;
        }

        $stmt->close();
        $conn->close();
    } else {
        echo "Invalid Request (delete only accepts POST).";
    }
    }

}