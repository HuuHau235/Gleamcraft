<?php
require_once('C:\xampp\htdocs\GleamCraft_MVC\app\models\UserModel.php');
require_once('C:\xampp\htdocs\GleamCraft_MVC\app\core\Controller.php');

class UserController extends Controller {
    protected $userModel;
    
    public function __construct() {
        $this->userModel = new UserModel();
    }
    
    public function index() {
        // Kiểm tra nếu người dùng đã đăng nhập
        if (isset($_SESSION['user_logged_in']) && $_SESSION['user_logged_in'] === true) {
            header("Location: /homepage");  // Điều hướng đến homepage nếu đã đăng nhập
            exit();
        }
        $this->view("user/login");  // Hiển thị trang login
    }

    public function login() {
        $email = isset($_POST['email']) ? $_POST['email'] : '';
        $password = isset($_POST['password']) ? $_POST['password'] : '';
        
        // Kiểm tra nếu email và password không rỗng
        if ($email != '' && $password != '') {
            $result = $this->userModel->login($email, $password);  // Kiểm tra đăng nhập
            if ($result) {
                $_SESSION['user_logged_in'] = true;  // Lưu session đăng nhập
                
                // Lấy vai trò người dùng sau khi đăng nhập thành công
                $userRole = $this->userModel->getUserRoleByEmail($email); // Giả sử phương thức này trả về 'admin' hoặc 'user'
                
                // Điều hướng dựa trên vai trò người dùng
                if ($userRole == 'admin') {
                    header("Location: /Admin/");  // Điều hướng đến trang admin
                } else {
                    header("Location: /homepage");  // Điều hướng đến trang homepage
                }
                exit();
            } else {
                // Nếu đăng nhập không thành công (email hoặc mật khẩu không đúng)
                $_SESSION['login_error'] = 'Email hoặc mật khẩu không đúng. Vui lòng kiểm tra lại.';
                header("Location: /User");  // Quay lại trang login
                exit();
            }
        } else {
            // Nếu email hoặc password để trống
            $_SESSION['login_error'] = 'Vui lòng nhập đầy đủ email và mật khẩu.';
            header("Location: /User");  // Quay lại trang login
            exit();
        }
    }
    
    
}
?>
