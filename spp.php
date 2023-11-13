<?php
if (isset($_POST['simpan'])) {
    $tahun = $_POST['tahun'];
    $nominal = $_POST['nominal'];

    $query = mysqli_query($koneksi, "INSERT INTO spp (tahun,nominal) values('$tahun','$nominal')");

    if ($query) {
        echo '<script>alert("Data Berhasil ditambah");location.href="?page=spp"</script>';
    }
}
if (isset($_POST['edit'])) {
    $id_spp = $_POST['id_spp'];
    $tahun = $_POST['tahun'];
    $nominal = $_POST['nominal'];

    $query = mysqli_query($koneksi, "UPDATE spp SET id_spp='$id_spp',tahun='$tahun',nominal='$nominal' WHERE id_spp='$id_spp'");

    if ($query) {
        echo '<script>alert("Data Berhasil diedit");location.href="?page=spp"</script>';
    }
}
if (isset($_POST['hapus'])) {
    $id_spp = $_POST['id_spp'];

    $query = mysqli_query($koneksi, "DELETE FROM spp WHERE id_spp='$id_spp'");

    if ($query) {
        echo '<script>alert("Data Berhasil diihapus");location.href="?page=spp"</script>';
    }
}

if (empty($_SESSION['user']['level'] =='admin')) {
    ?>
    <script>
        window.history.back();
    </script>
    <?php
}
?>
<h1 class="h3 mb-2 text-gray-800">Data spp</h1>
<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#tambahspp">
            +Tambah spp
        </button>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>NO</th>
                        <th>Tahun</th>
                        <th>Nominal</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $i = 1;
                    $query = mysqli_query($koneksi, "SELECT * FROM spp");
                    while ($data = mysqli_fetch_array($query)) {
                    ?>
                        <tr>
                            <td><?php echo $i++ ?></td>
                            <td><?php echo $data['tahun'] ?></td>
                            <td>Rp <?php echo number_format($data['nominal'], 2, ",", ".") ?></td>
                            <td>
                                <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#editspp<?php echo $data['id_spp'] ?>">
                                    <i class="fa fa-edit"></i>
                                </button>
                                <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#hapusspp<?php echo $data['id_spp'] ?>">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                        <div class="modal fade" id="editspp<?php echo $data['id_spp'] ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Edit Data Petugas</h5>
                                    </div>
                                    <form action="" method="post">
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <input type="hidden" name="id_spp" value="<?php echo $data['id_spp'] ?>">
                                                <label class="form-label">tahun</label>
                                                <input type="text" name="tahun" class="form-control" value="<?php echo $data['tahun'] ?>" required>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">nominal</label>
                                                <input type="text" name="nominal" class="form-control" value="<?php echo $data['nominal'] ?>" required>
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
                        <div class="modal fade" id="hapusspp<?php echo $data['id_spp'] ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Hapus Data spp</h5>
                                    </div>
                                    <form action="" method="post">
                                        <div class="modal-body">
                                            <input type="hidden" name="id_spp" value="<?php echo $data['id_spp'] ?>">
                                            <div class="text-center">
                                                <span>Yakin ingin hapus data?</span><br>
                                                <div class="text-danger">
                                                     SPP - <?php echo $data['tahun']?> - <?php echo $data['nominal']?>
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
    let tablet = new DataTable('#spp');
</script>
<div class="modal fade" id="tambahspp" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Data SPP</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="" method="post">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Tahun</label>
                        <input type="text" name="tahun" class="form-control"required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">nominal</label>
                        <input type="text" name="nominal" class="form-control"required>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" name="simpan">Save changes</button>
                    </div>
            </form>

        </div>
    </div>
</div>