<h1 class="text-center my-4">Login</h1>
<?php if (isset($error)): ?>
<div class="alert alert-danger text-center" role="alert">
    <?= $error ?>
</div>
<?php endif; ?>
<div class="container">
    <form method="POST" class="w-50 mx-auto border p-4 rounded shadow">
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" name="email" id="email" class="form-control" placeholder="Enter your email" required>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" name="password" id="password" class="form-control" placeholder="Enter your password"
                required>
        </div>
        <button type="submit" class="btn btn-primary w-100">Login</button>
        <a href='google/login' style="text-decoration: none">
            <div id="g_id_onload"
                data-client_id="284544138294-js7c7nrmu14e6a34dlmer48r384vcvh2.apps.googleusercontent.com"
                data-context="signin" data-ux_mode="redirect"
                data-login_uri="http://localhost:8000/google/login"
                data-auto_prompt="false">
            </div>

            <div style="width: 300px; margin-top: 20px; height: 30px; margin-left: 150px;" class="g_id_signin"
                data-type="standard" data-shape="pill" data-theme="outline" data-text="signin_with" data-size="medium"
                data-logo_alignment="left" data-width="200px">
            </div>
        </a>

    </form>
    <p class="text-center mt-3">
        Don't have an account? <a href="/register">Register</a>
    </p>
    <p class="text-center mt-3"><a class="text-center mt-3" href="/forgotPassword">Forgot password?</a></p>
</div>
<script src="https://accounts.google.com/gsi/client" async></script>