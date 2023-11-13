<?php
if (isset($_POST['simpan'])) {
    $nama_petugas = $_POST['nama_petugas'];
    $password = md5($_POST['password']);
    $username = $_POST['username'];
    $level = $_POST['level'];


    $query = mysqli_query($koneksi, "INSERT INTO petugas (nama_petugas,password,username,level) values('$nama_petugas','$password','$username','$level')");

    if ($query) {
        echo '<script>alert("Data Berhasil ditambah");location.href="?page=petugas"</script>';
    }
}
if (isset($_POST['edit'])) {
    $id_petugas = $_POST['id_petugas'];
    $nama_petugas = $_POST['nama_petugas'];
    $password = md5($_POST['password']);
    $username = $_POST['username'];
    $level = $_POST['level'];

    if (empty($_POST['password'])) {
        $query = mysqli_query($koneksi, "UPDATE petugas SET nama_petugas='$nama_petugas',username='$username',level='$level' WHERE id_petugas='$id_petugas'");

        if ($query) {
            echo '<script>alert("Data Berhasil diedit");location.href="?page=petugas"</script>';
        }
    } else {
        $query = mysqli_query($koneksi, "UPDATE petugas SET nama_petugas='$nama_petugas',password='$password',username='$username',level='$level' WHERE id_petugas='$id_petugas'");

        if ($query) {
            echo '<script>alert("Data Berhasil diedit");location.href="?page=petugas"</script>';
        }
    }
}
if (isset($_POST['hapus'])) {
    $id_petugas = $_POST['id_petugas'];

    $query = mysqli_query($koneksi, "DELETE FROM petugas WHERE id_petugas='$id_petugas'");

    if ($query) {
        echo '<script>alert("Data Berhasil diihapus");location.href="?page=petugas"</script>';
    }
}

if (empty($_SESSION['user']['level'] == 'admin')) {
?>
    <script>
        window.history.back();
    </script>
<?php
}
?>
<h1 class="h3 mb-2 text-gray-800">Data petugas</h1>
<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#tambahpetugas">
            +Tambah petugas
        </button>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>NO</th>
                        <th>Username</th>
                        <th>Nama_petugas</th>
                        <th>Level</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $i = 1;
                    $query = mysqli_query($koneksi, "SELECT * FROM petugas");
                    while ($data = mysqli_fetch_array($query)) {
                    ?>
                        <tr>
                            <td><?php echo $i++ ?></td>
                            <td><?php echo $data['nama_petugas'] ?></td>
                            <td><?php echo $data['username'] ?></td>
                            <td><?php echo $data['level'] ?></td>
                            <td>
                                <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#editpetugas<?php echo $data['id_petugas'] ?>">
                                    <i class="fa fa-edit"></i>
                                </button>
                                <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#hapuspetugas<?php echo $data['id_petugas'] ?>">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                        <div class="modal fade" id="editpetugas<?php echo $data['id_petugas'] ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Edit Data Petugas</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <form action="" method="post">
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <input type="hidden" name="id_petugas" value="<?php echo $data['id_petugas'] ?>">
                                                <label class="form-label">Nama Petugas</label>
                                                <input type="text" name="nama_petugas" class="form-control" value="<?php echo $data['nama_petugas'] ?>" required>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Userame</label>
                                                <input type="text" name="username" class="form-control" value="<?php echo $data['username'] ?>" required>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Password</label>
                                                <input type="password" name="password" class="form-control">
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Level</label>
                                                <select name="level" class="form-control" required>
                                                    <option value="">Pilih</option>
                                                    <option value="admin" <?php echo ($data['level'] == 'admin' ? 'selected' : '') ?>>Admin</option>
                                                    <option value="petugas" <?php echo ($data['level'] == 'petugas' ? 'selected' : '') ?>>Petugas</option>
                                                </select>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-primary" name="edit">Save changes</button>
                                            </div>
                                        </div>
                                    </form>

                                </div>
                            </div>
                        </div>
                        <div class="modal fade" id="hapuspetugas<?php echo $data['id_petugas'] ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Hapus Data Petugas</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <form action="" method="post">
                                        <div class="modal-body">
                                            <input type="hidden" name="id_petugas" value="<?php echo $data['id_petugas'] ?>">
                                            <div class="text-center">
                                                <span>Yakin ingin hapus data?</span><br>
                                                <div class="text-danger">
                                                    Nama Petugas - <?php echo $data['nama_petugas'] ?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-primary" name="hapus">Hapus</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    <?php
                    }
                    ?>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
<script>
    let tablet = new DataTable('#petugas');
</script>
<div class="modal fade" id="tambahpetugas" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Data Petugas</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="" method="post">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Nama Petugas</label>
                        <input type="text" name="nama_petugas" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Userame</label>
                        <input type="text" name="username" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Level</label>
                        <select name="level" class="form-control" required>
                            <option value="">Pilih</option>
                            <option value="admin">Admin</option>
                            <option value="petugas">Petugas</option>
                        </select>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" name="simpan">Save changes</button>
                    </div>
            </form>

        </div>
    </div>
</div>