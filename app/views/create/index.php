<?php require_once 'app/views/templates/headerPublic.php'; ?>

<div class="container mt-5">
    <h2>Create Account</h2>

    <!-- Show error or success message -->
    <?php if (!empty($_SESSION['error'])): ?>
        <div class="alert alert-danger"><?= $_SESSION['error']; unset($_SESSION['error']); ?></div>
    <?php endif; ?>

    <?php if (!empty($_SESSION['message'])): ?>
        <div class="alert alert-success"><?= $_SESSION['message']; unset($_SESSION['message']); ?></div>
    <?php endif; ?>

    <!-- Registration Form -->
    <form method="post" action="/create/store">
        <div class="mb-3">
            <label for="username">Username</label>
            <input 
                type="text" 
                name="username" 
                id="username"
                required 
                class="form-control"
            >
        </div>
        <div class="mb-3">
            <label for="password">Password</label>
            <input 
                type="password" 
                name="password" 
                id="password"
                required 
                minlength="6" 
                class="form-control"
            >
            <div class="form-text text-muted">Password must be at least 6 characters.</div>
        </div>
        <button type="submit" class="btn btn-success">Register</button>
    </form>

    <!-- Navigation -->
    <div class="mt-3">
        <a href="/welcome" class="btn btn-secondary">Back</a>
    </div>
</div>

<?php require_once 'app/views/templates/footer.php'; ?>
