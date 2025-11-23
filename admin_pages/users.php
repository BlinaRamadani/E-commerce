<?php
include '../connection.php';
$users = mysqli_query($conn, "SELECT * FROM users ORDER BY id DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Users</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

    
    <style>
        body {
            background-color: #f8f9fa;
            font-family: "Poppins", sans-serif;
        }

        h3 {
            font-weight: 600;
            color: #333;
            text-align: center;
            margin-bottom: 30px;
        }

        .btn {
            border-radius: 8px !important;
            transition: 0.2s ease;
            font-weight: 500;
        }

        .btn-success {
            background-color: #28a745;
            border: none;
        }
        .btn-success:hover {
            background-color: #218838;
        }

        .btn-primary {
            background-color: #007bff;
            border: none;
        }
        .btn-primary:hover {
            background-color: #0069d9;
        }

        .btn-danger {
            background-color: #dc3545;
            border: none;
        }
        .btn-danger:hover {
            background-color: #c82333;
        }

        .table {
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0,0,0,0.08);
            background-color: white;
        }

        .table th {
            background-color: #343a40 !important;
            color: #fff;
            text-align: center;
            vertical-align: middle;
        }

        .table td {
            vertical-align: middle;
            text-align: center;
            color: #555;
        }

        .table-hover tbody tr:hover {
            background-color: #f1f1f1;
        }

        .table-responsive {
            border-radius: 10px;
            overflow-x: auto;
        }

        .modal-content {
            border-radius: 12px;
            border: none;
            box-shadow: 0 4px 25px rgba(0,0,0,0.1);
        }

        .modal-header {
            border-bottom: none;
        }

        .modal-title {
            font-weight: 600;
        }

        .form-label {
            font-weight: 500;
            color: #333;
        }

        .form-control, .form-select {
            border-radius: 8px;
            border: 1px solid #ccc;
            transition: 0.2s ease;
        }

        .form-control:focus, .form-select:focus {
            border-color: #007bff;
            box-shadow: 0 0 0 0.2rem rgba(0,123,255,.25);
        }

        .modal .btn {
            border-radius: 10px;
            padding: 10px 0;
            font-size: 16px;
        }

        .text-end {
            margin-bottom: 20px;
        }

        tr {
            transition: background-color 0.3s ease;
        }
    </style>
</head>
<body class="p-4">

<h3 class="mb-4">Manage Users</h3>

<div class="mb-3 text-end">
    <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addUserModal">
        <i class="fas fa-user-plus me-1"></i> Add User
    </button>
</div>


<div class="table-responsive">
    <table class="table table-striped table-hover align-middle">
        <thead class="table-dark">
            <tr>
                <th>ID</th><th>Name</th><th>Email</th><th>Role</th><th>Actions</th>
            </tr>
        </thead>
        <tbody id="userTableBody">
            <?php while($user = mysqli_fetch_assoc($users)) { ?>
            <tr id="user-<?= $user['id'] ?>">
                <td><?= $user['id'] ?></td>
                <td><?= htmlspecialchars($user['name']) ?></td>
                <td><?= htmlspecialchars($user['email']) ?></td>
                <td><?= $user['role'] ?? 'User' ?></td>
                <td>
                    <button class="btn btn-sm btn-primary editUserBtn"
                            data-id="<?= $user['id'] ?>"
                            data-name="<?= htmlspecialchars($user['name']) ?>"
                            data-email="<?= htmlspecialchars($user['email']) ?>"
                            data-role="<?= $user['role'] ?? 'User' ?>"
                            data-bs-toggle="modal" data-bs-target="#editUserModal">
                        <i class="fas fa-edit"></i> Edit
                    </button>
                    <button class="btn btn-sm btn-danger deleteUserBtn"
                            data-id="<?= $user['id'] ?>">
                        <i class="fas fa-trash"></i> Delete
                    </button>
                </td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
</div>


<div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg-success text-white">
        <h5 class="modal-title" id="addUserModalLabel">Add New User</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="addUserForm">
            <div class="mb-3">
                <label class="form-label">Name</label>
                <input type="text" name="name" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Password</label>
                <input type="password" name="password" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Role</label>
                <select name="role" class="form-select">
                    <option value="User">User</option>
                    <option value="Admin">Admin</option>
                </select>
            </div>
            <button type="submit" class="btn btn-success w-100">Add User</button>
        </form>
      </div>
    </div>
  </div>
</div>


<div class="modal fade" id="editUserModal" tabindex="-1" aria-labelledby="editUserModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title" id="editUserModalLabel">Edit User</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="editUserForm">
            <input type="hidden" name="id" id="editUserId">
            <div class="mb-3">
                <label class="form-label">Name</label>
                <input type="text" name="name" id="editUserName" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" name="email" id="editUserEmail" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Role</label>
                <select name="role" id="editUserRole" class="form-select">
                    <option value="User">User</option>
                    <option value="Admin">Admin</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary w-100">Save Changes</button>
        </form>
      </div>
    </div>
  </div>
</div>

<script>
/
document.getElementById('addUserForm').addEventListener('submit', async e => {
    e.preventDefault();
    const formData = new FormData(e.target);
    formData.append('action', 'add');
    const response = await fetch('user_actions.php', { method: 'POST', body: formData });
    const result = await response.text();
    alert(result);
    location.reload();
});


document.querySelectorAll('.editUserBtn').forEach(btn => {
    btn.addEventListener('click', () => {
        document.getElementById('editUserId').value = btn.dataset.id;
        document.getElementById('editUserName').value = btn.dataset.name;
        document.getElementById('editUserEmail').value = btn.dataset.email;
        document.getElementById('editUserRole').value = btn.dataset.role;
    });
});


document.getElementById('editUserForm').addEventListener('submit', async e => {
    e.preventDefault();
    const formData = new FormData(e.target);
    formData.append('action', 'edit');
    const response = await fetch('user_actions.php', { method: 'POST', body: formData });
    const result = await response.text();
    alert(result);
    location.reload();
});


document.querySelectorAll('.deleteUserBtn').forEach(btn => {
    btn.addEventListener('click', async () => {
        if (confirm('Are you sure you want to delete this user?')) {
            const id = btn.dataset.id;
            const formData = new FormData();
            formData.append('action', 'delete');
            formData.append('id', id);
            const response = await fetch('user_actions.php', { method: 'POST', body: formData });
            const result = await response.text();
            alert(result);
            location.reload();
        }
    });
});
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
