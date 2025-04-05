<?php
require 'db.php';
include 'header.php';
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'consumer') {
    header("Location: login.php");
    exit();
}

$consumer_id = $_SESSION['user_id'];
?>

<div class="container">
    <h3>Your Hire History</h3>
    <div class="service-list">
        <?php
        $stmt = $conn->prepare("SELECT u.name, u.service, u.price, u.location, h.hire_date 
                                FROM hires h
                                JOIN users u ON h.provider_id = u.id
                                WHERE h.consumer_id = ?");
        $stmt->bind_param("i", $consumer_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0):
            while ($row = $result->fetch_assoc()):
        ?>
            <div class="service-card">
                <h4><?php echo htmlspecialchars($row['name']); ?></h4>
                <p><strong>Service:</strong> <?php echo htmlspecialchars($row['service']); ?></p>
                <p><strong>Price:</strong> ₹<?php echo htmlspecialchars($row['price']); ?></p>
                <p><strong>Location:</strong> <?php echo htmlspecialchars($row['location']); ?></p>
                <p><strong>Hired On:</strong> <?php echo htmlspecialchars($row['hire_date']); ?></p>
            </div>
        <?php
            endwhile;
        else:
            echo "<p>You have not hired anyone yet.</p>";
        endif;
        $stmt->close();
        ?>
    </div>
</div>

<?php include 'footer.php'; ?>
