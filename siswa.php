<?php
if (isset($_POST['simpan'])) {
    $nisn = $_POST['nisn'];
    $nis = $_POST['nis'];
    $nama_siswa = $_POST['nama_siswa'];
    $id_kelas = $_POST['id_kelas'];
    $alamat = $_POST['alamat'];
    $no_tlpon = $_POST['no_tlpon'];
    $password = md5($_POST['password']);

    $cek = mysqli_query($koneksi, "SELECT *FROM siswa WHERE nisn='$nisn'");
    $cek_nisn = mysqli_num_rows($cek);
    $cek1 = mysqli_query($koneksi, "SELECT *FROM siswa WHERE nis='$nis'");
    $cek_nis = mysqli_num_rows($cek1);

    if ($cek_nisn > 0) {
        echo '<script>alert("Nisn Sudah Di Gunakan");location.href="?page=siswa";</script>';
    } elseif ($cek_nis > 0) {
        echo '<script>alert("Nis Sudah Di Gunakan");location.href="?page=siswa";</script>';
    } else {
        $query = mysqli_query($koneksi, "INSERT INTO siswa (nisn,nis,nama_siswa,id_kelas,alamat,no_tlpon
        ,password) values('$nisn','$nis','$nama_siswa','$id_kelas','$alamat','$no_tlpon','$password')");

        if ($query) {
            echo '<script>alert("Data Berhasil di Tambah");location.href="?page=siswa"</script>';
        }
    }
}

if (isset($_POST['edit'])) {
    $oldnisn = $_POST['oldnisn'];
    $nisn = $_POST['nisn'];
    $nis = $_POST['nis'];
    $nama_siswa = $_POST['nama_siswa'];
    $id_kelas = $_POST['id_kelas'];
    $alamat = $_POST['alamat'];
    $no_tlpon = $_POST['no_tlpon'];
    $password = md5($_POST['password']);


    if (empty($_POST['password'])) {
        $query = mysqli_query($koneksi, "UPDATE siswa SET nisn='$nisn',nis='$nis',nama_siswa='$nama_siswa',id_kelas='$id_kelas',alamat='$alamat'
    ,no_tlpon='$no_tlpon' WHERE nisn='$oldnisn'");
        if ($query) {
            echo '<script>alert("Data Berhasil diedit");location.href="?page=siswa"</script>';
        }
    } else {
        $query = mysqli_query($koneksi, "UPDATE siswa SET nisn='$nisn',nama_siswa='$nama_siswa',id_kelas='$id_kelas',alamat='$alamat'
    ,no_tlpon='$no_tlpon',password='$password' WHERE nisn='$oldnisn'");
        if ($query) {
            echo '<script>alert("Data Berhasil diedit");location.href="?page=siswa"</script>';
        }
    }
}

if (isset($_POST['hapus'])) {
    $nisn = $_POST['nisn'];

    $query = mysqli_query($koneksi, "DELETE FROM siswa WHERE nisn='$nisn'");

    if ($query) {
        echo '<script>alert("Data Berhasil diihapus");location.href="?page=siswa"</script>';
    }
}

if (empty($_SESSION['user']['level'])) {
    ?>
        <script>
            window.history.back();
        </script>
    <?php
    }
?>

<h1 class="h3 mb-2 text-gray-800">Siswa</h1>
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <?php
        if (!empty($_SESSION['user']['level']) && !empty($_SESSION['user']['level'] == 'admin')) {
        ?>
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#tambahsiswa">
                +Tambah Siswa
            </button>
        <?php
        }
        ?>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="siswa" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Nisn</th>
                        <th>Nis</th>
                        <th>Nama siswa</th>
                        <th>Nama kelas</th>
                        <th>Kopetensi keahlian</th>
                        <th>Alamat</th>
                        <th>No tlpon</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $i = 1;
                    $query = mysqli_query($koneksi, "SELECT * FROM siswa INNER JOIN kelas ON siswa.id_kelas=kelas.id_kelas");
                    while ($data = mysqli_fetch_array($query)) {
                    ?>
                        <tr>
                            <td><?php echo $data['nisn'] ?></td>
                            <td><?php echo $data['nis'] ?></td>
                            <td><?php echo $data['nama_siswa'] ?></td>
                            <td><?php echo $data['nama_kelas'] ?></td>
                            <td><?php echo $data['kopetensi_keahlian'] ?></td>
                            <td><?php echo $data['alamat'] ?></td>
                            <td><?php echo $data['no_tlpon'] ?></td>
                            <td width="14%">
                                <?php
                                if (!empty($_SESSION['user']['level']) && !empty($_SESSION['user']['level'] == 'admin')) {
                                ?>
                                    <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#editsiswa<?php echo $data['nisn'] ?>">
                                        <i class="fa fa-edit"></i>
                                    </button>
                                    <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#hapussiswa<?php echo $data['nisn'] ?>">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                    <a href="?page=history&nisn=<?php echo $data['nisn'] ?>" class="btn btn-primary btn-sm"><i class="fa fa-archive"></i></a>

                                <?php
                                } else {
                                ?>
                                    <a href="?page=history&nisn=<?php echo $data['nisn'] ?>" class="btn btn-primary btn-sm"><i class="fa fa-archive"></i></a>
                                <?php
                                }
                                ?>
                            </td>
                        </tr>
                        <div class="modal fade" id="editsiswa<?php echo $data['nisn'] ?>" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="staticBackdropLabel">edit data siswa </h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="" method="post">
                                            <div class="modal-body">
                                                <div class="mb-3">
                                                    <input type="hidden" name="oldnisn" value="<?php echo $data['nisn'] ?>">
                                                    <label class="form-label">NISN</label>
                                                    <input type="text" name="nisn" class="form-control" value="<?php echo $data['nisn'] ?>" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">NIS</label>
                                                    <input type="text" name="nis" class="form-control" value="<?php echo $data['nis'] ?>" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Nama siswa</label>
                                                    <input type="text" name="nama_siswa" class="form-control" value="<?php echo $data['nama_siswa'] ?>" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Kelas dan Jurusan</label>
                                                    <div class="text-danger">
                                                        <select name="id_kelas" id="id_kelas" class="form-control" required>
                                                            <option value="">-pilih-</option>
                                                            <?php
                                                            $query1 = mysqli_query($koneksi, "SELECT * FROM kelas");
                                                            while ($kelas = mysqli_fetch_array($query1)) {
                                                            ?>
                                                                <option value="<?php echo $kelas['id_kelas'] ?>" <?php echo ($data['id_kelas'] == $kelas['id_kelas'] ? 'selected' : '') ?>>
                                                                    <?php echo $kelas['nama_kelas'] ?> - <?php echo $kelas['kopetensi_keahlian'] ?>
                                                                </option>
                                                            <?php
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Alamat</label>
                                                    <input type="text" name="alamat" class="form-control" value="<?php echo $data['alamat'] ?>" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">No_tlpon</label>
                                                    <input type="text" name="no tlpon" class="form-control" value="<?php echo $data['no_tlpon'] ?>" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">password</label>
                                                    <input type="password" name="password" class="form-control">
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
                        </div>
                        <div class="modal fade" id="hapussiswa<?php echo $data['nisn'] ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Hapus Data siswa</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <form action="" method="post">
                                        <div class="modal-body">
                                            <input type="hidden" name="nisn" value="<?php echo $data['nisn'] ?>">
                                            <div class="text-center">
                                                <span>Yakin ingin hapus data?</span><br>
                                                <div class="text-danger">
                                                    Nama siswa - <?php echo $data['nama_siswa'] ?>
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
    $(document).ready(function() {
        $('#siswa').DataTable();
    });
</script>
<div class="modal fade" id="tambahsiswa" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Tambah Data Siswa </h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="" method="post">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">NISN</label>
                            <input type="text" name="nisn" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">NIS</label>
                            <input type="text" name="nis" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Nama siswa</label>
                            <input type="text" name="nama_siswa" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Kelas dan Jurusan</label>
                            <select name="id_kelas" class="form-control">
                                <?php
                                $query = mysqli_query($koneksi, "SELECT * FROM kelas");
                                while ($data = mysqli_fetch_array($query)) {
                                ?>
                                    <option value="<?php echo $data['id_kelas'] ?>">
                                        <?php echo $data['nama_kelas'] ?> - <?php echo $data['kopetensi_keahlian'] ?>
                                    </option>
                                <?php
                                }
                                ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Alamat</label>
                            <input type="text" name="alamat" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">No_tlpon</label>
                            <input type="text" name="no_tlpon" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Password</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary" name="simpan">Save</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>