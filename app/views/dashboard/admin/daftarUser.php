<h2>Daftar User</h2>

<ul>
<?php foreach ($users as $user): ?>
    <li><?= $user['name']; ?></li>
<?php endforeach; ?>
</ul>
