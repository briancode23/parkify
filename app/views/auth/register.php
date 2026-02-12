<h2>Registrasi User</h2>

<?php if (isset($error)): ?>
    <p style="color:red"><?= $error ?></p>
<?php endif; ?>

<form action="?url=auth/store" method="post">
    <label>Nama Lengkap</label><br>
    <input type="text" name="nama" required><br><br>

    <label>Username</label><br>
    <input type="text" name="username" required><br><br>

    <label>Password</label><br>
    <input type="password" name="password" required><br><br>

    <label>Role</label><br>
    <select name="role" required>
        <option value="user">User</option>
        <option value="petugas">Petugas</option>
        <option value="admin">Admin</option>
    </select><br><br>

    <button type="submit">Daftar</button>
</form>

<p>Sudah punya akun?
    <a href="?url=auth/login">Login</a>
</p>
