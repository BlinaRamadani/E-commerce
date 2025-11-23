<?php
include '../connection.php';
$orders = mysqli_query($conn, "SELECT * FROM `order` ORDER BY id DESC");
?>

<h3 class="mb-4">Manage Orders</h3>


<button class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#addOrderModal">
    <i class="fas fa-plus"></i> Add New Order
</button>

<div class="table-responsive">
    <table class="table table-striped table-hover align-middle">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>User ID</th>
                <th>Name</th>
                <th>Number</th>
                <th>Email</th>
                <th>Method</th>
                <th>Address</th>
                <th>Total Products</th>
                <th>Total Price</th>
                <th>Placed On</th>
                <th>Payment Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while($order = mysqli_fetch_assoc($orders)) { ?>
            <tr id="order-<?= $order['id'] ?>">
                <td><?= $order['id'] ?></td>
                <td><?= $order['user_id'] ?></td>
                <td><?= htmlspecialchars($order['name']) ?></td>
                <td><?= htmlspecialchars($order['number']) ?></td>
                <td><?= htmlspecialchars($order['email']) ?></td>
                <td><?= htmlspecialchars($order['method']) ?></td>
                <td><?= htmlspecialchars($order['address']) ?></td>
                <td><?= htmlspecialchars($order['total_products']) ?></td>
                <td>$<?= number_format($order['total_price'], 2) ?></td>
                <td><?= htmlspecialchars($order['placed_on']) ?></td>
                <td>
                    <span class="badge bg-<?php 
                        echo ($order['payment_status'] === 'pending' ? 'warning' : 
                             ($order['payment_status'] === 'completed' ? 'success' : 'secondary')); 
                    ?>">
                        <?= htmlspecialchars($order['payment_status']) ?>
                    </span>
                </td>
                <td>
                    <button class="btn btn-sm btn-primary editOrderBtn"
                            data-id="<?= $order['id'] ?>"
                            data-status="<?= htmlspecialchars($order['payment_status']) ?>"
                            data-bs-toggle="modal" data-bs-target="#editOrderModal">
                        <i class="fas fa-edit"></i> Edit
                    </button>
                    <button class="btn btn-sm btn-danger deleteOrderBtn"
                            data-id="<?= $order['id'] ?>">
                        <i class="fas fa-trash"></i> Delete
                    </button>
                </td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
</div>


<div class="modal fade" id="addOrderModal" tabindex="-1" aria-labelledby="addOrderModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header bg-success text-white">
        <h5 class="modal-title" id="addOrderModalLabel">Add New Order</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <form id="addOrderForm">
          <div class="row">
            <div class="col-md-6 mb-3">
              <label class="form-label">User ID</label>
              <input type="number" name="user_id" class="form-control" required>
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label">Name</label>
              <input type="text" name="name" class="form-control" required>
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label">Number</label>
              <input type="text" name="number" class="form-control" required>
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label">Email</label>
              <input type="email" name="email" class="form-control" required>
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label">Method</label>
              <input type="text" name="method" class="form-control" required>
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label">Address</label>
              <input type="text" name="address" class="form-control" required>
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label">Total Products</label>
              <input type="text" name="total_products" class="form-control" required>
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label">Total Price</label>
              <input type="number" step="0.01" name="total_price" class="form-control" required>
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label">Placed On</label>
              <input type="date" name="placed_on" class="form-control" required>
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label">Payment Status</label>
              <select name="payment_status" class="form-select">
                <option value="pending">Pending</option>
                <option value="completed">Completed</option>
                <option value="cancelled">Cancelled</option>
              </select>
            </div>
          </div>
          <button type="submit" class="btn btn-success w-100">Add Order</button>
        </form>
      </div>
    </div>
  </div>
</div>


<div class="modal fade" id="editOrderModal" tabindex="-1" aria-labelledby="editOrderModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title" id="editOrderModalLabel">Edit Payment Status</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <form id="editOrderForm">
            <input type="hidden" name="id" id="editOrderId">
            <div class="mb-3">
                <label class="form-label">Payment Status</label>
                <select name="payment_status" id="editPaymentStatus" class="form-select">
                    <option value="pending">Pending</option>
                    <option value="completed">Completed</option>
                    <option value="cancelled">Cancelled</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary w-100">Save Changes</button>
        </form>
      </div>
    </div>
  </div>
</div>

<script>

document.querySelectorAll('.editOrderBtn').forEach(btn => {
    btn.addEventListener('click', () => {
        document.getElementById('editOrderId').value = btn.dataset.id;
        document.getElementById('editPaymentStatus').value = btn.dataset.status;
    });
});


document.getElementById('editOrderForm').addEventListener('submit', async e => {
    e.preventDefault();
    const formData = new FormData(e.target);
    formData.append('action', 'update');
    const res = await fetch('order_actions.php', { method: 'POST', body: formData });
    const text = await res.text();
    alert(text);
    location.reload();
});


document.querySelectorAll('.deleteOrderBtn').forEach(btn => {
    btn.addEventListener('click', async () => {
        if (confirm('Are you sure you want to delete this order?')) {
            const id = btn.dataset.id;
            const formData = new FormData();
            formData.append('action', 'delete');
            formData.append('id', id);
            const res = await fetch('order_actions.php', { method: 'POST', body: formData });
            const text = await res.text();
            alert(text);
            location.reload();
        }
    });
});


document.getElementById('addOrderForm').addEventListener('submit', async e => {
    e.preventDefault();
    const formData = new FormData(e.target);
    formData.append('action', 'add');
    const res = await fetch('order_actions.php', { method: 'POST', body: formData });
    const text = await res.text();
    alert(text);
    location.reload();
});
</script>
