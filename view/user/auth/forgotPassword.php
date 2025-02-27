<section id="myOrder" class="py-3">
<h1 class="text-center my-4 text-white">Forgot Password</h1>
<?php if (isset($error)): ?>
    <div class="alert alert-danger text-center" role="alert">
        <?= $error ?>
    </div>
<?php endif; ?>
<div class="container">
    <form method="POST" class="w-50 bg-white mx-auto border p-4 mb-3 rounded shadow">
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" name="email" id="email" class="form-control" placeholder="Enter your email" required>
        </div>
        <button type="submit" class="btn btn-primary w-100">Submit</button>
    </form>
</div>
</section>