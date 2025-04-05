<?php 
require 'db.php';
include 'header.php';
session_start();
?>

<div class="container">
    <h2>Welcome to Service Marketplace</h2>

    <h4>Available Service Providers</h4>
    <div class="service-list">
        <?php
        $stmt = $conn->prepare("SELECT id, name, service, price, image, location FROM users WHERE role = 'provider' AND service IS NOT NULL");
        $stmt->execute();
        $result = $stmt->get_result();
        while ($row = $result->fetch_assoc()):
        ?>
            <div class="service-card">
                <?php if (!empty($row['image'])): ?>
                    <img src="<?php echo htmlspecialchars($row['image']); ?>" alt="Service Image" class="service-img">
                <?php endif; ?>
                <h4><?php echo htmlspecialchars($row['name']); ?></h4>
                <p><strong>Service:</strong> <?php echo htmlspecialchars($row['service']); ?></p>
                <p><strong>Price:</strong> ₹<?php echo htmlspecialchars($row['price']); ?></p>
                <p><strong>Location:</strong> <?php echo htmlspecialchars($row['location']); ?></p>
                <?php if (isset($_SESSION['user_id']) && $_SESSION['user_role'] == 'consumer'): ?>
                    <a class="btn" href="hire.php?id=<?php echo $row['id']; ?>">Hire Now</a>
                <?php else: ?>
                    <a class="btn" href="login.php">Login to Hire</a>
                <?php endif; ?>
            </div>
        <?php endwhile; ?>
    </div>
</div>

<?php include 'footer.php'; ?>
