<?php
if (isset($_POST['simpan'])) {
    $nama_kelas = $_POST['nama_kelas'];
    $kopetensi_keahlian = $_POST['kopetensi_keahlian'];


    $query = mysqli_query($koneksi, "INSERT INTO kelas (nama_kelas,kopetensi_keahlian) values('$nama_kelas','$kopetensi_keahlian')");

    if ($query) {
        echo '<script>alert("Data Berhasil ditambah");location.href="?page=kelas"</script>';
    }
}
if (isset($_POST['edit'])) {
    $id_kelas = $_POST['id_kelas'];
    $nama_kelas = $_POST['nama_kelas'];
    $kopetensi_keahlian = $_POST['kopetensi_keahlian'];

    $query = mysqli_query($koneksi, "UPDATE kelas SET nama_kelas='$nama_kelas',kopetensi_keahlian='$kopetensi_keahlian' WHERE id_kelas='$id_kelas'");

    if ($query) {
        echo '<script>alert("Data Berhasil diedit");location.href="?page=kelas"</script>';
    }
}

if (isset($_POST['hapus'])) {
    $id_kelas = $_POST['id_kelas'];

    $query = mysqli_query($koneksi, "DELETE FROM kelas WHERE id_kelas='$id_kelas'");

    if ($query) {
        echo '<script>alert("Data Berhasil diihapus");location.href="?page=kelas"</script>';
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
<h1 class="h3 mb-2 text-gray-800"> Data Kelas</h1>
<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#tambahkelas">
            +Tambah kelas
        </button>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama kelas</th>
                        <th>kopetensi keahlian</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $i = 1;
                    $query = mysqli_query($koneksi, "SELECT * FROM kelas");
                    while ($data = mysqli_fetch_array($query)) {
                    ?>
                        <tr>
                            <td><?php echo $i++ ?></td>
                            <td><?php echo $data['nama_kelas'] ?></td>
                            <td><?php echo $data['kopetensi_keahlian'] ?></td>
                            <td>
                            <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#editkelas<?php echo $data['id_kelas'] ?>">
                                    <i class="fa fa-edit"></i>
                                </button>
                                <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#hapuskelas<?php echo $data['id_kelas'] ?>">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                        <div class="modal fade" id="editkelas<?php echo $data['id_kelas'] ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Edit Data Kelas</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <form action="" method="post">
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <input type="hidden" name="id_kelas" value="<?php echo $data['id_kelas'] ?>">
                                                <label class="form-label">Nama Kelas</label>
                                                <input type="text" name="nama_kelas" class="form-control" value="<?php echo $data['nama_kelas'] ?>" required>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Kompetensi Keahlian</label>
                                                <input type="text" name="kopetensi_keahlian" class="form-control" value="<?php echo $data['kopetensi_keahlian'] ?>" required>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-primary" name="edit">Save</button>
                                            </div>
                                        </div>
                                    </form>

                                </div>
                            </div>
                        </div>
                        <div class="modal fade" id="hapuskelas<?php echo $data['id_kelas'] ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Hapus Data Kelas</h5>
                                    </div>
                                    <form action="" method="post">
                                        <div class="modal-body">
                                            <input type="hidden" name="id_kelas" value="<?php echo $data['id_kelas'] ?>">
                                            <div class="text-center">
                                                <span>Yakin ingin hapus data?</span><br>
                                                <div class="text-danger">
                                                    Nama Kelas - <?php echo $data['nama_kelas'] ?><br>
                                                    Jurusan - <?php echo $data['kopetensi_keahlian'] ?>
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
                </tbody>
            </table>
        </div>
    </div>
</div>
<script>
    let tablet = new DataTable('#kelas');
</script>
<div class="modal fade" id="tambahkelas" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Data Kelas</h5>
            </div>
            <form action="" method="post">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">nama kelas</label>
                        <input type="text" name="nama_kelas" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">kopetensi keahlian</label>
                        <input type="text" name="kopetensi_keahlian" class="form-control" required>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" name="simpan">Save</button>
                    </div>
            </form>

        </div>
    </div>
</div>