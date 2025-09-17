<!DOCTYPE html>
<html>
<head>
    <title>Edit Student</title>
</head>
<body>
    <h2>Edit Student</h2>
    <form method="POST" action="/students/update/<?php echo $student['id']; ?>">
        <label>Last Name:</label>
        <input type="text" name="last_name" value="<?php echo $student['last_name']; ?>" required><br><br>

        <label>First Name:</label>
        <input type="text" name="first_name" value="<?php echo $student['first_name']; ?>" required><br><br>

        <label>Email:</label>
        <input type="email" name="email" value="<?php echo $student['email']; ?>" required><br><br>

        <button type="submit">Update</button>
    </form>
</body>
</html>
