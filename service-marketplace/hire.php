<?php
require 'db.php';
include 'header.php';
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'consumer') {
    header("Location: login.php");
    exit();
}

$consumer_id = $_SESSION['user_id'];

if (isset($_GET['id'])) {
    $provider_id = $_GET['id'];

    // Fetch provider details
    $stmt = $conn->prepare("SELECT name, service, price, location FROM users WHERE id = ? AND role = 'provider'");
    $stmt->bind_param("i", $provider_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $provider = $result->fetch_assoc();

    if (!$provider) {
        echo "<p>Invalid Service Provider.</p>";
        include 'footer.php';
        exit();
    }

    // Hire action
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $stmt = $conn->prepare("INSERT INTO hires (consumer_id, provider_id) VALUES (?, ?)");
        $stmt->bind_param("ii", $consumer_id, $provider_id);
        if ($stmt->execute()) {
            echo "<p>You have successfully hired <strong>" . htmlspecialchars($provider['name']) . "</strong> for the service: <strong>" . htmlspecialchars($provider['service']) . "</strong>.</p>";
        } else {
            echo "<p>Something went wrong. Please try again.</p>";
        }
        $stmt->close();
    }
} else {
    echo "<p>No service selected.</p>";
    include 'footer.php';
    exit();
}
?>

<div class="container">
    <h3>Hire Service</h3>
    <div class="service-card">
        <h4><?php echo htmlspecialchars($provider['name']); ?></h4>
        <p><strong>Service:</strong> <?php echo htmlspecialchars($provider['service']); ?></p>
        <p><strong>Price:</strong> ₹<?php echo htmlspecialchars($provider['price']); ?></p>
        <p><strong>Location:</strong> <?php echo htmlspecialchars($provider['location']); ?></p>

        <form method="post">
            <button class="btn">Confirm Hire</button>
        </form>
    </div>
</div>

<?php include 'footer.php'; ?>
