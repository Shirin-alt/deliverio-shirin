<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

/**
 * Controller: StudentsController
 * 
 * Automatically generated via CLI.
 */
class StudentsController extends Controller {
    private $conn; // ✅ this is required

    public function __construct()
    {
        parent::__construct();
        // Initialize DB connection once per request
        $this->conn = new mysqli("sql12.freesqldatabase.com", "sql12798929", "akhlCbceII", "mockdata");
        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
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
      

    // ...existing code...

    // Close connection when object is destroyed
    public function __destruct()
    {
        if ($this->conn) {
            $this->conn->close();
        }
    }

    // Show students and handle new inserts
    public function show_form()
    {
        // Use the existing connection property, do not create a new one
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $last_name  = $_POST['last_name'] ?? '';
            $first_name = $_POST['first_name'] ?? '';
            $email      = $_POST['email'] ?? '';

            $stmt = $this->conn->prepare(
                "INSERT INTO students (last_name, first_name, email) VALUES (?, ?, ?)"
            );
            $stmt->bind_param("sss", $last_name, $first_name, $email);
            $stmt->execute();
            $stmt->close();
        }

        $result = $this->conn->query("SELECT * FROM students");
        $students = $result->fetch_all(MYSQLI_ASSOC);

        require __DIR__ . '/../views/students_view.php';
    }

    // Update existing student
    public function update_student()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id         = isset($_POST['id']) ? (int) $_POST['id'] : 0;
            $last_name  = $_POST['last_name'] ?? '';
            $first_name = $_POST['first_name'] ?? '';
            $email      = $_POST['email'] ?? '';

            $stmt = $this->conn->prepare(
                "UPDATE students SET last_name = ?, first_name = ?, email = ? WHERE id = ?"
            );
            $stmt->bind_param("sssi", $last_name, $first_name, $email, $id);

            if ($stmt->execute()) {
                header("Location: /students");
                exit;
            } else {
                echo "Failed to update student: " . $stmt->error;
            }

            $stmt->close();
        } else {
            echo "Invalid Request";
        }
    }

    // Delete student
    public function delete_student()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = isset($_POST['id']) ? (int) $_POST['id'] : 0;

            if ($id <= 0) {
                echo "❌ Invalid student ID.";
                exit;
            }

            $stmt = $this->conn->prepare("DELETE FROM students WHERE id = ?");
            $stmt->bind_param("i", $id);

            if ($stmt->execute()) {
                header("Location: /students");
                exit;
            } else {
                echo "❌ Failed to delete student: " . $stmt->error;
            }

            $stmt->close();
        } else {
            echo "Invalid Request (delete only accepts POST).";
        }
    }

}