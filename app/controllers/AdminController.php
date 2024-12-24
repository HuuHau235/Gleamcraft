<!-- Xử lí cập nhập lại user -->
<?php
require_once('../../../config/db.php');  
require_once('../../models/Admin.php');

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $user_id = $_POST['user_id'] ?? null;
    $name = $_POST['name'] ?? null;
    $email = $_POST['email'] ?? null;
    $password = $_POST['password'] ?? null;
    $phone = $_POST['phone'] ?? null;
    $role = $_POST['role'] ?? null;
    if (!$user_id || !$name || !$email || !$password || !$phone || !$role) {
        echo "All fields are required.";
        exit;
    }
    $adminUser = new AdminUser($conn);
    $message = $adminUser->EditUser($user_id, $name, $email, $password, $phone, $role);
    echo $message;
    exit;
}
?>
<!-- Xử lí xóa user -->
<?php
require_once "../../../config/db.php";
// Xử lý xóa người dùng
if (isset($_GET['delete_user']) && isset($_GET['user_id'])) {
    $user_id = $_GET['user_id'];

    // Kiểm tra tính hợp lệ của user_id
    if (is_numeric($user_id)) {
        // Lệnh SQL để xóa người dùng
        $sqlDeleteUser = "DELETE FROM users WHERE user_id = ?";

        // Chuẩn bị câu lệnh SQL
        $stmt = $conn->prepare($sqlDeleteUser);
        if (!$stmt) {
            die("Error preparing the statement: " . $conn->error);
        }

        // Liên kết tham số với câu lệnh SQL
        $stmt->bind_param("i", $user_id);

        // Thực thi câu lệnh
        if ($stmt->execute()) {
            $stmt->close();
            echo "<script>alert('Đã xóa thành công');</script>";
        } else {
            echo "<script>alert('Xóa không thành công: " . $stmt->error . "');</script>";
        }

        // Chuyển hướng lại trang sau khi xóa
        header("Location: ../admin/index copy.php");
        exit;
    } else {
        echo "<script>alert('ID người dùng không hợp lệ.');</script>";
    }
}
?>

