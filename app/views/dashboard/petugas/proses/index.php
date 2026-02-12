<h2><?= $title ?></h2>

<a href="?url=parkir/masuk">+ Kendaraan Masuk</a>
<a href="?url=parkir/struk/<?= $row['id_parkir'] ?>" target="_blank">
    <button>Cetak Struk</button>
</a>
<a href="?url=parkir/strukMasuk/<?= $row['id_parkir'] ?>" target="_blank">
    <button>Struk Masuk</button>
</a>

<a href="?url=parkir/strukKeluar/<?= $row['id_parkir'] ?>" target="_blank">
    <button>Struk Keluar</button>
</a>



<table border="1" cellpadding="8">
    <tr>
        <th>No</th>
        <th>Plat</th>
        <th>Waktu Masuk</th>
        <th>Aksi</th>
    </tr>

    <?php $no = 1; foreach ($parkir as $p): ?>
    <tr>
        <td><?= $no++ ?></td>
        <td><?= $p['plat_nomor'] ?></td>
        <td><?= $p['waktu_masuk'] ?></td>
        <td>
            <a href="?url=parkir/keluar/<?= $p['id_parkir'] ?>"
               onclick="return confirm('Keluarkan kendaraan?')">
               Keluar
            </a>
        </td>
    </tr>
    <?php endforeach ?>
</table>
