<section id="myOrder" class="py-3">
<h1 class="text-center my-4 text-white">Reset Password</h1>
<?php if (isset($error)): ?>
    <div class="alert alert-danger text-center" role="alert">
        <?= $error ?>
    </div>
<?php endif; ?>
<div class="container">
    <form method="POST" class="w-50 mx-auto border bg-white mb-3 p-4 rounded shadow">

        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="text" name="email" id="email" class="form-control" 
       value="<?= is_array($_SESSION['email']) ? implode(', ', $_SESSION['email']) : $_SESSION['email'] ?>" 
       placeholder="Enter your email" required>
        </div>
        <div class="mb-3">
            <label for="otp" class="form-label">OTP</label>
            <input type="text" name="otp" id="otp" class="form-control" placeholder="Enter your OTP" required>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" name="password" id="password" class="form-control" placeholder="Enter your password" required>
        </div>
        <div class="mb-3">
            <label for="passwordConfirm" class="form-label">Password Confirm</label>
            <input type="password" name="passwordConfirm" id="passwordConfirm" class="form-control" placeholder="Enter your password confirm" required>
        </div>

        <button type="submit" class="btn btn-primary w-100">Submit</button>
    </form>
</div>
</section>