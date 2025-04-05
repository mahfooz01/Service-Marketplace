<?php
require 'db.php';
include 'header.php';
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'provider') {
    header("Location: login.php");
    exit();
}

$provider_id = $_SESSION['user_id'];
?>

<div class="container">
    <h3>Your Hire Requests</h3>
    <div class="service-list">
        <?php
        $stmt = $conn->prepare("SELECT u.name, u.email, h.hire_date 
                                FROM hires h
                                JOIN users u ON h.consumer_id = u.id
                                WHERE h.provider_id = ?");
        $stmt->bind_param("i", $provider_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0):
            while ($row = $result->fetch_assoc()):
        ?>
            <div class="service-card">
                <h4><?php echo htmlspecialchars($row['name']); ?></h4>
                <p><strong>Email:</strong> <?php echo htmlspecialchars($row['email']); ?></p>
                <p><strong>Hired On:</strong> <?php echo htmlspecialchars($row['hire_date']); ?></p>
            </div>
        <?php
            endwhile;
        else:
            echo "<p>No one has hired you yet.</p>";
        endif;
        $stmt->close();
        ?>
    </div>
</div>

<?php include 'footer.php'; ?>
