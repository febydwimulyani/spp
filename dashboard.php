<?php
if (!empty($_SESSION['user']['level'])) {
?>
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Pembayaran SPP</h1>
    </div>

    <!-- Content Row -->
    <div class="row">

        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Jumlah Kelas</div>
                            <?php
                            $query = mysqli_query($koneksi, "SELECT COUNT(*) AS total FROM kelas");
                            $sum = mysqli_fetch_assoc($query);
                            ?>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $sum['total'] ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-user fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Jumlah Petugas</div>
                            <?php
                            $query = mysqli_query($koneksi, "SELECT COUNT(*) AS total FROM petugas");
                            $sum = mysqli_fetch_assoc($query);
                            ?>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $sum['total'] ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-user fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Jumlah Siswa</div>
                            <?php
                            $query = mysqli_query($koneksi, "SELECT COUNT(*) AS total FROM siswa");
                            $sum = mysqli_fetch_assoc($query);
                            ?>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $sum['total'] ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-users fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Jumlah Kelas</div>
                            <?php
                            $query = mysqli_query($koneksi, "SELECT SUM(jumlah_bayar) AS total FROM pembayaran");
                            $sum = mysqli_fetch_assoc($query);
                            ?>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">Rp <?php echo number_format($sum['total'], 2,  ",", ".") ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-users fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
<?php
} else {
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
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $nisn = $_SESSION['user']['nisn'];
                        $i = 1;
                        $query = mysqli_query($koneksi, "SELECT * FROM pembayaran INNER JOIN petugas ON pembayaran.id_petugas=petugas.id_petugas INNER JOIN siswa ON pembayaran.nisn=siswa.nisn INNER JOIN spp ON pembayaran.id_spp=spp.id_spp WHERE pembayaran.nisn='$nisn'");


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
                            </tr>
                        <?php
                        }
                        ?>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
<?php
}

?>