<?php
if(!isset($_SESSION['user'])) {
    header("Location: index.php?page=login");
    exit;
}

if (!$conn) {
    echo "<div class='alert alert-warning border-0 mb-4'>Database connection required. Please enable MySQL in Laragon.</div>";
    return;
}

// Insert
if(isset($_POST['save'])) {
    $nama = trim($_POST['nama']);
    if($nama) {
        mysqli_query($conn, "INSERT INTO level (nama) VALUES ('$nama')");
    }
}

// Update
if(isset($_POST['update_level'])){
    $lid = intval($_POST['level_id']);
    $lname = trim($_POST['nama']);
    if($lid>0 && $lname!==''){
        mysqli_query($conn, "UPDATE level SET nama = '$lname' WHERE id = $lid");
        header('Location: index.php?page=level');
        exit;
    }
}

// Delete
if(isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    mysqli_query($conn, "DELETE FROM level WHERE id=$id");
}

$levels = mysqli_query($conn, "SELECT * FROM level ORDER BY id DESC");
?>

<div class="mb-4">
    <div class="section-label mb-2">Data Management</div>
    <h2>Education Levels</h2>
    <p class="text-secondary">Add and manage education level categories.</p>
</div>

<div class="card mb-4">
    <div class="card-body">
        <form method="POST" class="row g-2 align-items-end">
            <div class="col-md-9">
                <label class="form-label fw-600">New Level</label>
                <input type="text" name="nama" class="form-control" placeholder="e.g., Kindergarten, Elementary School" required>
            </div>
            <div class="col-md-3 d-grid">
                <button name="save" class="btn btn-dark">Add Level</button>
            </div>
        </form>
    </div>
</div>

<div class="table-responsive">
    <table class="table table-hover align-middle">
        <thead class="table-light">
            <tr>
                <th style="width: 80px;">ID</th>
                <th>Name</th>
                <th style="width: 120px;">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($levels && mysqli_num_rows($levels) > 0): ?>
                <?php while($row = mysqli_fetch_assoc($levels)): ?>
                <tr>
                    <td><span class="badge bg-light text-dark"><?= e($row['id']) ?></span></td>
                    <td><?= e($row['nama']) ?></td>
                    <td>
                        <a href="index.php?page=level&edit=<?= e($row['id']) ?>" class="btn btn-sm btn-outline-secondary">Edit</a>
                        <a href="index.php?page=level&delete=<?= e($row['id']) ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete this level?')">Delete</a>
                    </td>
                </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr><td colspan="3" class="text-center text-secondary py-4">No levels yet.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php if(isset($_GET['edit'])):
    $edit_id = intval($_GET['edit']);
    $res = mysqli_query($conn, "SELECT * FROM level WHERE id = $edit_id LIMIT 1");
    if($res && mysqli_num_rows($res)>0):
        $lev = mysqli_fetch_assoc($res);
?>
<div class="modal fade" id="editLevelModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <form class="modal-content" method="POST">
            <div class="modal-header">
                <h5 class="modal-title">Edit Level</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="level_id" value="<?= e($lev['id']) ?>">
                <label class="form-label fw-600">Name</label>
                <input type="text" name="nama" class="form-control" value="<?= e($lev['nama']) ?>" required>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-dark" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" name="update_level" class="btn btn-dark">Update</button>
            </div>
        </form>
    </div>
</div>
<script>
document.addEventListener('DOMContentLoaded', function(){
    var m = document.getElementById('editLevelModal');
    if(m && m.parentNode !== document.body) document.body.appendChild(m);
    var modal = new bootstrap.Modal(document.getElementById('editLevelModal'));
    modal.show();
});
</script>
<?php endif; endif; ?>