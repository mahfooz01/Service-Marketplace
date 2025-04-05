<?php 
require 'db.php'; 
include 'header.php';

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $pass = $_POST['password'];

    $stmt = $conn->prepare("SELECT id, name, password, role FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows == 1) {
        $stmt->bind_result($id, $name, $hashed_pass, $role);
        $stmt->fetch();
        if (password_verify($pass, $hashed_pass)) {
            $_SESSION['user_id'] = $id;
            $_SESSION['user_name'] = $name;
            $_SESSION['user_role'] = $role;
            header("Location: dashboard.php");
            exit();
        } else {
            echo "<p>Invalid password.</p>";
        }
    } else {
        echo "<p>User not found.</p>";
    }
    $stmt->close();
}
?>

<div class="container">
    <h3>Login</h3>
    <form method="post">
        <input name="email" type="email" placeholder="Email" required>
        <input name="password" type="password" placeholder="Password" required>
        <button class="btn">Login</button>
    </form>
</div>

<?php include 'footer.php'; ?>
