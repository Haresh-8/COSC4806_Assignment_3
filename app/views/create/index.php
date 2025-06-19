<?php require_once 'app/views/templates/headerPublic.php'; ?>

<div class="container mt-5">
    <h2>Create Account</h2>

    <?php if (!empty($_SESSION['error'])): ?>
        <div class="alert alert-danger"><?= $_SESSION['error']; unset($_SESSION['error']); ?></div>
    <?php endif; ?>

    <form method="post" action="/create/store">
        <div class="mb-3">
            <label>Username</label>
            <input type="text" name="username" required class="form-control">
        </div>
        <div class="mb-3">
            <label>Password</label>
            <input type="password" name="password" required class="form-control" minlength="6">
            <div class="form-text text-muted">Password must be at least 6 characters.</div>
        </div>
        <button type="submit" class="btn btn-success">Register</button>
    </form>

    <div class="mt-3">
        <a href="/welcome" class="btn btn-secondary">Back</a>
    </div>
</div>

<?php require_once 'app/views/templates/footer.php'; ?>
