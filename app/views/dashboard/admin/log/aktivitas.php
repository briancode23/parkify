<h2><?= $title ?></h2>
<a href="?url=log/exportPdf" target="_blank">
    <button>Export PDF</button>
</a>

<br><br>

<table border="1" cellpadding="8">
    <tr>
        <th>No</th>
        <th>User</th>
        <th>Aktivitas</th>
        <th>Waktu</th>
    </tr>

    <?php $no = 1; foreach ($log as $row): ?>
    <tr>
        <td><?= $no++ ?></td>
        <td><?= $row['nama_lengkap'] ?></td>
        <td><?= $row['aktivitas'] ?></td>
        <td><?= $row['waktu_aktivitas'] ?></td>
    </tr>
    <?php endforeach ?>
</table>
