<?php
if (isset($_SESSION['user'])) {
    header("Location: index.php?page=home");
    exit;
}

$loginMessage = $pageNotice ?? null;

if(isset($_POST['login'])) {
    if (!$conn) {
        $loginMessage = 'Database belum terhubung. Pastikan MySQL Laragon sudah berjalan.';
    } else {
        $user = trim($_POST['username']);
        $pass = trim($_POST['password']);
        $res = mysqli_query($conn, "SELECT * FROM users WHERE username='$user' AND password='$pass'");

        if($res && mysqli_num_rows($res) > 0) {
            $data = mysqli_fetch_assoc($res);
            session_regenerate_id(true);
            $_SESSION['user'] = $data['username'];
            $_SESSION['role'] = $data['role'];
            header("Location: index.php?page=home");
            exit;
        }

        $loginMessage = 'Login gagal. Periksa kembali username dan password.';
    }
}
?>

<div class="row justify-content-center align-items-center login-shell">
    <div class="col-lg-8">
        <div class="card card-hover overflow-hidden">
            <div class="row g-0">
                <div class="col-md-5 text-white p-4 p-lg-5 login-panel">
                    <h4 class="fw-bold mb-3">Access Required</h4>
                    <p class="mb-4 opacity-75">Sign in to unlock CRUD management features. Your credentials enable access to premium portfolio tools.</p>
                    <div class="d-grid gap-3">
                        <div>
                            <div class="fw-600">Secure Session</div>
                            <div class="small opacity-75">Protected authentication</div>
                        </div>
                        <div>
                            <div class="fw-600">Data Management</div>
                            <div class="small opacity-75">CRUD for authenticated users</div>
                        </div>
                    </div>
                </div>
                <div class="col-md-7 p-4 p-lg-5">
                    <div class="section-label mb-2">Authentication</div>
                    <h4 class="fw-bold mb-4">Sign In</h4>

                    <?php if ($loginMessage): ?>
                        <div class="alert alert-warning border-0 mb-4"><?= e($loginMessage) ?></div>
                    <?php endif; ?>

                    <form method="POST">
                        <div class="mb-3">
                            <label class="form-label">Username</label>
                            <input type="text" name="username" class="form-control" placeholder="Enter username" required>
                            <small class="text-secondary">Demo: admin</small>
                        </div>
                        <div class="mb-4">
                            <label class="form-label">Password</label>
                            <input type="password" name="password" class="form-control" placeholder="Enter password" required>
                            <small class="text-secondary">Demo: admin123</small>
                        </div>
                        <button name="login" class="btn btn-dark w-100">Sign In</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>