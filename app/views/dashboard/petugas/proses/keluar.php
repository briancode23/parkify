<h3>Keluar Parkir</h3>

<p>Plat: <?= $data['plat_nomor'] ?></p>
<p>Masuk: <span id="masuk"><?= $data['waktu_masuk'] ?></span></p>

<p>
    Durasi:
    <strong><span id="durasi">0</span> jam</strong>
</p>

<p>
    Total Bayar:
    <strong>Rp <span id="total">0</span></strong>
</p>

<button onclick="submitKeluar()">Proses Keluar</button>

<script>
const waktuMasuk = new Date("<?= $data['waktu_masuk'] ?>").getTime();
const tarifPerJam = <?= $data['tarif_per_jam'] ?>;

function hitungRealtime() {
    const now = new Date().getTime();
    let durasiMenit = Math.ceil((now - waktuMasuk) / 60000);
    let durasiJam = Math.ceil(durasiMenit / 60);

    document.getElementById('durasi').innerText = durasiJam;
    document.getElementById('total').innerText =
        (durasiJam * tarifPerJam).toLocaleString('id-ID');
}

setInterval(hitungRealtime, 1000);
</script>
