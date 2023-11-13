<?php
if (isset($_POST['lunasi'])) {
    $id_pembayaran = $_POST['id_pembayaran'];
    $tgl_bayarb = $_POST['tgl_bayarb'];
    $kekurangan = $_POST['kekurangan'];
    $jumlah_bl = $_POST['jmlh_bl'];
    $jumlah_bb = $_POST['jmlh_bb'];

    $total = $jumlah_bl + $kekurangan;
    $total1 = $jumlah_bl + $jumlah_bb;
    $sisa = $jumlah_bb - $kekurangan;
    $sisa1 = $kekurangan - $jumlah_bb;
    $kurang = $kekurangan - $jumlah_bb;

    if ($jumlah_bb >  $kekurangan) {
        $query = mysqli_query($koneksi, "UPDATE pembayaran SET tanggal_bayar='$tgl_bayarb',jumlah_bayar='$total' WHERE id_pembayaran='$id_pembayaran'");
        echo "<script>alert('SPP terbayar || saldo anda dikembalikan sebesar: Rp " . number_format($sisa, 2, ',', '.') . "');location.href ='index.php?page=laporan';</script>";
    } elseif ($jumlah_bb < $kekurangan) {
        $query = mysqli_query($koneksi, "UPDATE pembayaran SET tanggal_bayar='$tgl_bayarb',jumlah_bayar='$total1' WHERE id_pembayaran='$id_pembayaran'");
        echo "<script>alert('SPP terbayar || kekurangan sebesar: Rp " . number_format($kurang, 2, ',', '.') . "');location.href ='index.php?page=laporan';</script>";
    } else {
        $query = mysqli_query($koneksi, "UPDATE pembayaran SET tanggal_bayar='$tgl_bayarb',jumlah_bayar='$total1' WHERE id_pembayaran='$id_pembayaran'");
        echo "<script>alert('SPP terbayar || saldo anda dikembalikan sebesar: Rp " . number_format($sisa1, 2, ',', '.') . "');location.href ='index.php?page=laporan';</script>";
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
<h1 class="h3 mb-2 text-gray-800">History Siswa</h1>
<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>NO</th>
                        <th>Nama Petugas</th>
                        <th>Nama siswa</th>
                        <th>Tanggal bayar</th>
                        <th>Bulan bayar</th>
                        <th>Tahun bayar</th>
                        <th>SPP</th>
                        <th>Jumlah bayar</th>
                        <th>status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (isset($_GET['nisn'])) {
                        $nisn = $_GET['nisn'];
                        $i = 1;
                        $query = mysqli_query($koneksi, "SELECT * FROM pembayaran INNER JOIN petugas ON pembayaran.id_petugas=petugas.id_petugas INNER JOIN siswa ON pembayaran.nisn=siswa.nisn INNER JOIN spp ON pembayaran.id_spp=spp.id_spp WHERE pembayaran.nisn='$nisn'");
                    }

                    while ($data = mysqli_fetch_array($query)) {
                    ?>
                        <tr>
                            <td><?php echo $i++ ?></td>
                            <td><?php echo $data['nama_petugas'] ?></td>
                            <td><?php echo $data['nama_siswa'] ?></td>
                            <td><?php echo date('d-m-Y', strtotime($data['tanggal_bayar'])) ?></td>
                            <td><?php echo $data['bulan_bayar'] ?></td>
                            <td><?php echo $data['tahun_bayar'] ?></td>
                            <td><?php echo $data['tahun'] ?> - Rp <?php echo number_format($data['nominal'], 2, ',', '.') ?></td>
                            <td> Rp. <?php echo number_format($data['jumlah_bayar'], 2, '.', '.') ?></td>
                            <td>
                                <?php
                                if ($data['nominal'] >  $data['jumlah_bayar']) {
                                    echo 'kurang';
                                } else {
                                    echo 'lunas';
                                }
                                ?>
                            </td>
                            <td>
                                <?php
                                if ($data['nominal'] == $data['jumlah_bayar']) {
                                ?>
                                    <button type="button" class="btn btn-success btn-sm">
                                        Lunas
                                    </button>
                                <?php
                                } else {
                                ?>
                                    <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#editpembayaran<?php echo $data['id_pembayaran'] ?>">
                                        Lunasi
                                    </button>
                                <?php
                                }
                                ?>
                            </td>
                        </tr>
                        <div class="modal fade" id="editpembayaran<?php echo $data['id_pembayaran'] ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Edit Data Pembayaran</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <form action="" method="post">
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <input type="hidden" name="id_pembayaran" value="<?php echo $data['id_pembayaran'] ?>">
                                                <label class="form-label">Nama siswa</label>
                                                <input type="text" name="nisn" class="form-control" value="<?php echo $data['nama_siswa'] ?>" disabled>
                                            </div>
                                            <div class="mb-4">
                                                <label class="form-label">Tanggal bayar</label>
                                                <input type="date" name="tgl_bayarl" class="form-control" value="<?php echo $data['tanggal_bayar'] ?>" disabled>
                                                <input type="hidden" name="tgl_bayarb" class="form-control" value="<?php echo date('Y-m-d') ?>">
                                            </div>
                                            <div class="mb-4">
                                                <label class="form-label">Bulan bayar</label>
                                                <input type="text" name="bln_bayar" class="form-control" value="<?php echo $data['bulan_bayar'] ?>" disabled>
                                            </div>
                                            <div class="mb-4">
                                                <label class="form-label">Tahun bayar</label>
                                                <input type="text" name="thn_bayar" class="form-control" value="<?php echo $data['tahun_bayar'] ?>" disabled>
                                            </div>
                                            <div class="mb-4">
                                                <label class="form-label">kekurangan</label>
                                                <input type="text" name="kekurangan" class="form-control" value="<?php echo $data['nominal'] - $data['jumlah_bayar'] ?>" readonly>
                                            </div>
                                            <div class="mb-4">
                                                <label class="form-label">SPP</label>
                                                <input type="text" name="id_spp" class="form-control" value="<?php echo $data['nominal'] ?>" disabled>
                                            </div>
                                            <div class="mb-4">
                                                <input type="hidden" name="jmlh_bl" value="<?= $data['jumlah_bayar'] ?>">
                                                <label class="form-label">jumlah bayar</label>
                                                <input type="text" name="jmlh_bb" class="form-control">
                                            </div>
                                            <div class="modal-footer">
                                                <div class="col-sm-12">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                                    <button type="submit" class="btn btn-primary" name="lunasi">Simpan</button>
                                                </div>
                                            </div>
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
            <?php
            if (!empty($_SESSION['user']['level']) && !empty($_SESSION['user']['level'] == 'admin')) {
            ?>
                <div class="container" style="text-align: center;">
                    <a href="cetak_history.php?nisn=<?php echo $_GET['nisn'] ?>" class="btn btn-success btn-sm" target="_blank"><i class="fa fa-print"></i></a>
                </div>
            <?php
            }
            ?>
        </div>
    </div>
</div>
<script>
    let tablet = new DataTable('#laporan');
</script>