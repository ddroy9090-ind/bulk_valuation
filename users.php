<?php
require __DIR__ . '/includes/auth.php';
require_role('Admin');
require __DIR__ . '/includes/db.php';
include 'includes/common-header.php';


$successMessage = "";

// 🟢 Add or Update User
if (isset($_POST['register']) || isset($_POST['update'])) {
    $name = $_POST['name'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $role = $_POST['role'];

    // Update case
    if (isset($_POST['update'])) {
        $id = (int)$_POST['id'];
        $stmt = $pdo->prepare("UPDATE users SET name=?, username=?, email=?, role=? WHERE id=?");
        try {
            $stmt->execute([$name, $username, $email, $role, $id]);
            $successMessage = "User updated successfully!";
        } catch (PDOException $e) {
            $successMessage = "Error: " . $e->getMessage();
        }
    } else {
        // Register case
        $password = $_POST['password'];
        $confirm = $_POST['confirm_password'];

        if ($password !== $confirm) {
            $successMessage = "Passwords do not match!";
        } else {
            $hash = password_hash($password, PASSWORD_BCRYPT);
            $stmt = $pdo->prepare("INSERT INTO users (name, username, email, password, role) VALUES (?, ?, ?, ?, ?)");
            try {
                $stmt->execute([$name, $username, $email, $hash, $role]);
                $successMessage = "User registered successfully!";
            } catch (PDOException $e) {
                $successMessage = "Error: " . $e->getMessage();
            }
        }
    }
}

// 🟢 Delete User
if (isset($_GET['delete'])) {
    $id = (int) $_GET['delete'];
    $pdo->prepare("DELETE FROM users WHERE id=?")->execute([$id]);
    header("Location: users.php");
    exit;
}

// 🟢 Fetch Users
$stmt = $pdo->query("SELECT * FROM users ORDER BY id DESC");
$users = $stmt->fetchAll();
?>

<div class="container-fluid cms-layout">
    <div class="row h-100">

        <!-- Sidebar -->
        <?php include 'includes/sidebar.php' ?>

        <!-- Main Content -->
        <div class="col content" id="content">
            <?php include 'includes/topbar.php' ?>

            <div class="p-2">
                <div class="container py-5">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h2 class="mb-0">User List</h2>
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#userModal" onclick="openAddModal()">+ Register User</button>
                    </div>

                    <!-- Users Table -->
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <table class="table table-striped table-bordered mb-0">
                                <thead class="table-danger">
                                    <tr>
                                        <th>Name</th>
                                        <th>Username</th>
                                        <th>Email</th>
                                        <th>Role</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($users as $u): ?>
                                        <tr>
                                            <td><?= htmlspecialchars($u['name']) ?></td>
                                            <td><?= htmlspecialchars($u['username']) ?></td>
                                            <td><?= htmlspecialchars($u['email']) ?></td>
                                            <td><?= htmlspecialchars($u['role']) ?></td>
                                            <td>
                                                <button class="btn btn-sm btn-warning"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#userModal"
                                                        onclick="openEditModal(<?= $u['id'] ?>, '<?= htmlspecialchars($u['name']) ?>', '<?= htmlspecialchars($u['username']) ?>', '<?= htmlspecialchars($u['email']) ?>', '<?= htmlspecialchars($u['role']) ?>')">
                                                    Edit
                                                </button>
                                                <a href="users.php?delete=<?= $u['id'] ?>" class="btn btn-sm btn-danger"
                                                   onclick="return confirm('Delete this user?')">Delete</a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- User Modal -->
                <div class="modal fade" id="userModal" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header text-white" style="background-color: #d01f28;">
                                <h5 class="modal-title" id="modalTitle">Register User</h5>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <form method="post" id="userForm" action="users.php">
                                    <input type="hidden" name="id" id="userId">
                                    <div class="mb-3">
                                        <label class="form-label">Full Name</label>
                                        <input type="text" name="name" id="name" class="form-control" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Username</label>
                                        <input type="text" name="username" id="username" class="form-control" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Email</label>
                                        <input type="email" name="email" id="email" class="form-control" required>
                                    </div>
                                    <div class="mb-3 passwordFields">
                                        <label class="form-label">Password</label>
                                        <input type="password" name="password" id="password" class="form-control" required>
                                    </div>
                                    <div class="mb-3 passwordFields">
                                        <label class="form-label">Confirm Password</label>
                                        <input type="password" name="confirm_password" id="confirm_password" class="form-control" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Role</label>
                                        <select class="form-select" name="role" id="role" required>
                                            <option value="">Select role</option>
                                            <option>Admin</option>
                                            <option>Manager</option>
                                        </select>
                                    </div>
                                    <button type="submit" name="register" id="submitBtn" class="btn btn-success w-100">Register</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Bootstrap Toast -->
                <?php if (!empty($successMessage)): ?>
                <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 1050">
                    <div id="successToast" class="toast align-items-center text-bg-success border-0" role="alert" aria-live="assertive" aria-atomic="true">
                        <div class="d-flex">
                            <div class="toast-body">
                                <?= htmlspecialchars($successMessage) ?>
                            </div>
                            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
                        </div>
                    </div>
                </div>
                <?php endif; ?>

            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
function openAddModal() {
    document.getElementById('modalTitle').innerText = 'Register User';
    const submitBtn = document.getElementById('submitBtn');
    submitBtn.name = 'register';
    submitBtn.textContent = 'Register';
    document.getElementById('userForm').reset();
    document.querySelectorAll('.passwordFields').forEach(el => el.style.display = 'block');
    document.getElementById('password').required = true;
    document.getElementById('confirm_password').required = true;
}

function openEditModal(id, name, username, email, role) {
    document.getElementById('modalTitle').innerText = 'Edit User';
    const submitBtn = document.getElementById('submitBtn');
    submitBtn.name = 'update';
    submitBtn.textContent = 'Update';
    document.getElementById('userId').value = id;
    document.getElementById('name').value = name;
    document.getElementById('username').value = username;
    document.getElementById('email').value = email;
    document.getElementById('role').value = role;
    document.querySelectorAll('.passwordFields').forEach(el => el.style.display = 'none');
    document.getElementById('password').required = false;
    document.getElementById('confirm_password').required = false;
    document.getElementById('password').value = '';
    document.getElementById('confirm_password').value = '';
}

// Toast display
<?php if (!empty($successMessage)): ?>
    const toastEl = document.getElementById('successToast');
    const toast = new bootstrap.Toast(toastEl, { delay: 5000 });
    toast.show();
<?php endif; ?>
</script>

<?php include 'includes/common-footer.php' ?>
