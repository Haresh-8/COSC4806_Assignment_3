<?php require_once 'app/views/templates/headerPublic.php'; ?>

<div class="container mt-5">
    <h2>Create Account</h2>
    <form method="POST" action="/create/register">
        <div class="mb-3">
            <label>Username</label>
            <input class="form-control" type="text" name="username" required>
        </div>
        <div class="mb-3">
            <label>Password</label>
            <input class="form-control" type="password" name="password" required>
        </div>
        <button class="btn btn-success">Register</button>
    </form>
    <p class="mt-3">Already have an account? <a href="/login">Login</a></p>
</div>

<?php require_once 'app/views/templates/footer.php'; ?>
