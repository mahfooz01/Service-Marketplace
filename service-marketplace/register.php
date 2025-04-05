<?php 
require 'db.php'; 
include 'header.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $pass = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role = $_POST['role'];

    $stmt = $conn->prepare("INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $name, $email, $pass, $role);
    
    if ($stmt->execute()) {
        echo "<p>Registered successfully. <a href='login.php'>Login here</a>.</p>";
    } else {
        echo "<p>Error: " . $stmt->error . "</p>";
    }
    $stmt->close();
}
?>

<div class="container">
    <h3>Register</h3>
    <form method="post">
        <input name="name" placeholder="Full Name" required>
        <input name="email" type="email" placeholder="Email" required>
        <input name="password" type="password" placeholder="Password" required>
        <select name="role" required>
            <option value="">Select Role</option>
            <option value="provider">Service Provider</option>
            <option value="consumer">Consumer</option>
        </select>
        <button class="btn">Register</button>
    </form>
</div>

<?php include 'footer.php'; ?>
