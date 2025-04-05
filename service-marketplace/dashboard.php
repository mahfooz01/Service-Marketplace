<?php 
require 'db.php'; 
include 'header.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$user_name = $_SESSION['user_name'];
$user_role = $_SESSION['user_role'];
?>

<div class="container">
    <h3>Welcome, <?php echo htmlspecialchars($user_name); ?></h3>

    <?php if ($user_role == 'provider'): ?>
        <h4>Set Your Service, Price & Location</h4>

        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $service = $_POST['service'];
            $price = $_POST['price'];
            $location = $_POST['location'];

            // Image upload
            $image = null;
            if (!empty($_FILES['image']['name'])) {
                $target_dir = "uploads/";
                if (!is_dir($target_dir)) {
                    mkdir($target_dir);
                }
                $image = $target_dir . time() . "_" . basename($_FILES["image"]["name"]);
                move_uploaded_file($_FILES["image"]["tmp_name"], $image);
            }

            if ($image) {
                $stmt = $conn->prepare("UPDATE users SET service = ?, price = ?, location = ?, image = ? WHERE id = ?");
                $stmt->bind_param("sissi", $service, $price, $location, $image, $user_id);
            } else {
                $stmt = $conn->prepare("UPDATE users SET service = ?, price = ?, location = ? WHERE id = ?");
                $stmt->bind_param("sisi", $service, $price, $location, $user_id);
            }
            if ($stmt->execute()) {
                echo "<p>Service details updated.</p>";
            }
            $stmt->close();
        }
        ?>

        <form method="post" enctype="multipart/form-data">
            <input name="service" placeholder="Service Name" required>
            <input name="price" type="number" placeholder="Fair Price (₹)" required>
            <input name="location" placeholder="Your City / Location" required>
            <input type="file" name="image" accept="image/*">
            <button class="btn">Update</button>
        </form>

    <?php else: ?>
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
    <?php endif; ?>
</div>

<?php include 'footer.php'; ?>
