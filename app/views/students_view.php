<!DOCTYPE html>
<html>
<head>
    <title>Students</title>
    <style>
        /* Background and font */
        body {
            background: #ffe6f0;
            font-family: 'Comic Sans MS', cursive, sans-serif;
            color: #b30059;
            margin: 20px;
            padding: 20px;
        }

        h1, h2 {
            text-align: center;
            color: #ff3399;
            text-shadow: 1px 1px 2px #cc0066;
        }

        /* Form styling */
        form {
            max-width: 400px;
            margin: 0 auto 30px auto;
            background: #ffccdd;
            padding: 20px;
            border-radius: 15px;
            box-shadow: 0 4px 8px rgba(255, 51, 153, 0.3);
        }

        form input[type="text"],
        form input[type="email"] {
            width: calc(100% - 22px);
            padding: 10px;
            margin-bottom: 15px;
            border: 2px solid #ff66b2;
            border-radius: 10px;
            font-size: 16px;
            transition: border-color 0.3s ease;
        }

        form input[type="text"]:focus,
        form input[type="email"]:focus {
            border-color: #ff3399;
            outline: none;
        }

        form button {
            width: 100%;
            background: #ff66b2;
            border: none;
            padding: 12px;
            border-radius: 15px;
            color: white;
            font-weight: bold;
            font-size: 18px;
            cursor: pointer;
            box-shadow: 0 4px 6px #ff3399;
            transition: background 0.3s ease;
        }

        form button:hover {
            background: #ff3399;
        }

        /* Table styling */
        table {
            width: 90%;
            margin: 0 auto;
            border-collapse: separate;
            border-spacing: 0 10px;
            background: #fff0f6;
            border-radius: 15px;
            box-shadow: 0 4px 10px rgba(255, 51, 153, 0.2);
        }

        th, td {
            padding: 12px 15px;
            text-align: center;
            color: #b30059;
        }

        th {
            background: #ff99cc;
            border-top-left-radius: 15px;
            border-top-right-radius: 15px;
            font-size: 18px;
            letter-spacing: 1px;
        }

        tr {
            background: #ffd6e8;
            border-radius: 15px;
            transition: background 0.3s ease;
        }

        tr:hover {
            background: #ffb3d9;
        }

        td a {
            color: #ff3399;
            text-decoration: none;
            font-weight: bold;
            margin: 0 5px;
            padding: 5px 10px;
            border-radius: 12px;
            background: #ffe6f0;
            box-shadow: 0 2px 5px rgba(255, 51, 153, 0.2);
            transition: background 0.3s ease, color 0.3s ease;
        }

        td a:hover {
            background: #ff3399;
            color: white;
        }

        /* Remove default table border and use our styling */
        table, th, td {
            border: none;
        }
    </style>
</head>
<body>
    <h1>🎀 Student List 🎀</h1>

    <form method="POST" action="/students">
    <input type="text" name="last_name" placeholder="Last Name" required>
    <input type="text" name="first_name" placeholder="First Name" required>
    <input type="email" name="email" placeholder="Email" required>
    <button type="submit">✨ Create Student ✨</button>
</form>

<h2>🌸 All Students 🌸</h2>
<table>
    <tr>
        <th>ID</th><th>Last Name</th><th>First Name</th><th>Email</th><th>Actions</th>
    </tr>
    <?php foreach ($students as $student): ?>
    <tr>
        <td><?= $student['id']; ?></td>
        <td><?= $student['last_name']; ?></td>
        <td><?= $student['first_name']; ?></td>
        <td><?= $student['email']; ?></td>
        <td>
            <!-- Update Form -->
            <form method="POST" action="/students/update" style="display:inline-block;">
                <input type="hidden" name="id" value="<?= $student['id']; ?>">
                <input type="text" name="last_name" value="<?= $student['last_name']; ?>">
                <input type="text" name="first_name" value="<?= $student['first_name']; ?>">
                <input type="email" name="email" value="<?= $student['email']; ?>">
                <button type="submit">Update</button>
            </form>

            <!-- Delete Form -->
            <form method="POST" action="/students/delete/" style="display:inline-block;" 
                  onsubmit="return confirm('Delete this student?')">
                <input type="hidden" name="id" value="<?= $student['id']; ?>">
                <button type="submit">Delete</button>
            </form>
        </td>
    </tr>
    <?php endforeach; ?>
</table>
</body>
</html>

