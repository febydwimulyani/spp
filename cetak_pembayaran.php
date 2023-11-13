<?php
include 'koneksi.php';
if (empty($_SESSION['user']['level'] =='admin')) {
    ?>
    <script>
        window.history.back();
    </script>
    <?php
}
?>
<script>
    window.print();
</script>
<table border=1 cellpadding="5" cellspacing="0" width="100%">
    <tr>
        <th colspan="9">Cetak Pembayaran</th>
    </tr>

    <tr>
        <th>NO</th>
        <th>Nama Petugas</th>
        <th>Nama siswa</th>
        <th>Tanggal bayar</th>
        <th>Bulan bayar</th>
        <th>Tahun bayar</th>
        <th>SPP</th>
        <th>Jumlah bayar</th>
    </tr>
    </thead>
    <tbody>
        <?php
        $i = 1;
        $query = mysqli_query($koneksi, "SELECT * FROM pembayaran INNER JOIN petugas ON pembayaran.id_petugas=petugas.id_petugas INNER JOIN siswa ON pembayaran.nisn=siswa.nisn INNER JOIN spp ON pembayaran.id_spp=spp.id_spp");
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
            </tr>
        <?php
        }
        ?>
        </tr>
    </tbody>
</table>