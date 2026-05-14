<?php
if(!isset($_SESSION['user'])) {
    header("Location: index.php?page=login");
    exit;
}

if (!$conn) {
    echo "<div class='alert alert-warning border-0 mb-4'>Database connection required. Please enable MySQL in Laragon.</div>";
    return;
}

if(isset($_POST['save_study'])) {
    $nama = trim($_POST['nama']);
    $lvl = intval($_POST['idlevel']);
    $ket = trim($_POST['keterangan']);
    $thn = intval($_POST['tahun']);
    if($nama && $lvl) {
        mysqli_query($conn, "INSERT INTO studies (nama, idlevel, keterangan, tahun_lulus) VALUES ('$nama', $lvl, '$ket', $thn)");
    }
}

// Handle delete action (POST)
if(isset($_POST['delete_study'])){
    $del_id = intval($_POST['study_id']);
    if($del_id>0){
        mysqli_query($conn, "DELETE FROM studies WHERE id = $del_id LIMIT 1");
    }
}

// Handle update action
if(isset($_POST['update_study'])){
    $sid = intval($_POST['study_id']);
    $sname = trim($_POST['nama']);
    $slvl = intval($_POST['idlevel']);
    $sket = trim($_POST['keterangan']);
    $sthn = intval($_POST['tahun']);
    if($sid>0 && $sname && $slvl){
        mysqli_query($conn, "UPDATE studies SET nama='$sname', idlevel=$slvl, keterangan='$sket', tahun_lulus=$sthn WHERE id=$sid LIMIT 1");
        header('Location: index.php?page=studies');
        exit;
    }
}

$studies = mysqli_query($conn, "SELECT studies.*, level.nama as lvl_nama FROM studies JOIN level ON studies.idlevel = level.id ORDER BY studies.id DESC");
$lvls = mysqli_query($conn, "SELECT * FROM level");
?>

<div class="mb-4 d-flex justify-content-between align-items-start">
    <div>
        <div class="section-label mb-2">Data Management</div>
        <h2>Educational Background</h2>

    <?php if(isset($_GET['edit'])):
        $edit_id = intval($_GET['edit']);
        $resS = mysqli_query($conn, "SELECT studies.*, level.nama as lvl_nama FROM studies JOIN level ON studies.idlevel = level.id WHERE studies.id = $edit_id LIMIT 1");
        if($resS && mysqli_num_rows($resS)>0):
            $s = mysqli_fetch_assoc($resS);
            $lvls_edit = mysqli_query($conn, "SELECT * FROM level");
    ?>
    <div class="modal fade" id="editStudyModal" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <form class="modal-content" method="POST">
                <div class="modal-header border-0">
                    <h5 class="modal-title fw-bold">Edit Educational Record</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="study_id" value="<?= e($s['id']) ?>">
                    <div class="mb-3">
                        <label class="form-label fw-600">Institution Name</label>
                        <input type="text" name="nama" class="form-control" value="<?= e($s['nama']) ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-600">Education Level</label>
                        <select name="idlevel" class="form-select" required>
                            <option value="">-- Select Level --</option>
                            <?php if ($lvls_edit && mysqli_num_rows($lvls_edit) > 0): ?>
                                <?php while($lv = mysqli_fetch_assoc($lvls_edit)): ?>
                                    <option value="<?= e($lv['id']) ?>" <?= $lv['id']==$s['idlevel']? 'selected': '' ?>><?= e($lv['nama']) ?></option>
                                <?php endwhile; ?>
                            <?php endif; ?>
                        </select>
                    </div>
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label fw-600">Graduation Year</label>
                            <input type="number" name="tahun" class="form-control" value="<?= e($s['tahun_lulus']) ?>" min="1990" max="2099" required>
                        </div>
                        <div class="col-md-8">
                            <label class="form-label fw-600">Notes</label>
                            <textarea name="keterangan" class="form-control" rows="2"><?= e($s['keterangan']) ?></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-outline-dark" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" name="update_study" class="btn btn-dark">Update Record</button>
                </div>
            </form>
        </div>
    </div>
    <script>
    document.addEventListener('DOMContentLoaded', function(){
        var modal = document.getElementById('editStudyModal');
        if(modal && modal.parentNode !== document.body) document.body.appendChild(modal);
        var bs = new bootstrap.Modal(document.getElementById('editStudyModal'));
        bs.show();
    });
    </script>
    <?php endif; endif; ?>
        <p class="text-secondary">Track your educational journey and academic records.</p>
    </div>
    <button type="button" class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#addModal">+ Add Record</button>
</div>

<div class="table-responsive">
    <table class="table table-hover align-middle">
        <thead class="table-light">
            <tr>
                <th>Institution</th>
                <th>Level</th>
                <th style="width: 100px;">Year</th>
                <th>Notes</th>
                <th style="width:110px;">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($studies && mysqli_num_rows($studies) > 0): ?>
                <?php while($row = mysqli_fetch_assoc($studies)): ?>
                <tr>
                    <td class="fw-600"><?= e($row['nama']) ?></td>
                    <td><span class="badge" style="background: var(--color-accent); color: white;"><?= e($row['lvl_nama']) ?></span></td>
                    <td><?= e($row['tahun_lulus']) ?></td>
                    <td class="text-secondary small"><?= e($row['keterangan']) ?></td>
                    <td>
                        <a href="index.php?page=studies&edit=<?= e($row['id']) ?>" class="btn btn-sm btn-outline-secondary me-1">Edit</a>
                        <form method="POST" class="d-inline" onsubmit="return confirm('Delete this record?');">
                            <input type="hidden" name="study_id" value="<?= e($row['id']) ?>">
                            <button type="submit" name="delete_study" class="btn btn-outline-danger btn-sm">Delete</button>
                        </form>
                    </td>
                </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr><td colspan="5" class="text-center text-secondary py-4">No records yet.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<div class="modal fade" id="addModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <form class="modal-content" method="POST">
            <div class="modal-header border-0">
                <h5 class="modal-title fw-bold">Add Educational Record</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label fw-600">Institution Name</label>
                    <input type="text" name="nama" class="form-control" placeholder="e.g., SDN Pancasila, SMA 2" required>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-600">Education Level</label>
                    <select name="idlevel" class="form-select" required>
                        <option value="">-- Select Level --</option>
                        <?php if ($lvls && mysqli_num_rows($lvls) > 0): ?>
                            <?php $lvls_copy = mysqli_query($conn, "SELECT * FROM level"); ?>
                            <?php while($lv = mysqli_fetch_assoc($lvls_copy)): ?>
                                <option value="<?= e($lv['id']) ?>"><?= e($lv['nama']) ?></option>
                            <?php endwhile; ?>
                        <?php endif; ?>
                    </select>
                </div>
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label fw-600">Graduation Year</label>
                        <input type="number" name="tahun" class="form-control" placeholder="2024" min="1990" max="2099" required>
                    </div>
                    <div class="col-md-8">
                        <label class="form-label fw-600">Notes</label>
                        <textarea name="keterangan" class="form-control" rows="2" placeholder="Achievements, major, or additional info"></textarea>
                    </div>
                </div>

                    <script>
                    document.addEventListener('DOMContentLoaded', function(){
                        var modal = document.getElementById('addModal');
                        if(modal && modal.parentNode !== document.body){
                            document.body.appendChild(modal);
                        }
                    });
                    </script>
            </div>
            <div class="modal-footer border-0">
                <button type="button" class="btn btn-outline-dark" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" name="save_study" class="btn btn-dark">Save Record</button>
            </div>
        </form>
    </div>
</div>