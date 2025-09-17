<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

/**
 * Controller: StudentsController
 * 
 * Automatically generated via CLI.
 */
class StudentsController extends Controller {
    // NOTE: If your 'create' action is not found, make sure:
    // 1. Your routes.php file has a line like:
    //    $router->post('/students/create', 'StudentsController@create');
    // 2. Your form in students_view.php uses:
    //    <form action="/students/create" method="POST">
    // 3. The method is public function create() in this controller.
    private $conn; // ✅ this is required

    public function __construct()
    {
        parent::__construct();
        // Initialize DB connection once per request using PDO
        try {
            $this->conn = new PDO(
                'mysql:host=sql12.freesqldatabase.com;dbname=sql12798929;charset=utf8',
                'sql12798929',
                'akhlCbceII'
            );
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Connection failed: " . $e->getMessage());
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
        // PDO closes automatically, but you can unset for clarity
        if ($this->conn) {
            $this->conn = null;
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
            $stmt->execute([$last_name, $first_name, $email]);
        }

        $stmt = $this->conn->query("SELECT * FROM students");
        $students = $stmt->fetchAll(PDO::FETCH_ASSOC);

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
            $success = $stmt->execute([$last_name, $first_name, $email, $id]);

            if ($success) {
                header("Location: /students");
                exit;
            } else {
                $errorInfo = $stmt->errorInfo();
                echo "Failed to update student: " . $errorInfo[2];
            }
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
            $success = $stmt->execute([$id]);

            if ($success) {
                header("Location: /students");
                exit;
            } else {
                $errorInfo = $stmt->errorInfo();
                echo "❌ Failed to delete student: " . $errorInfo[2];
            }
        } else {
            echo "Invalid Request (delete only accepts POST).";
        }
    }

}