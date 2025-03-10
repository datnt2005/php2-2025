<section id="forgotPassword" class="h-100">
    <div class="container">
        <div class="row ">
            <div class="col-md-12">
                <h2 class="text-center text-white mt-5">ĐẶT LẠI MẬT KHẨU</h2>
                <?php if (isset($error)): ?>
                <div class="alert alert-danger text-center" role="alert">
                    <?= $error ?>
                </div>
                <?php endif; ?>
                <div class="form-login">
                    <form action class="mt-4 w-50 mx-auto" method="POST" enctype="multipart/form-data">
                        <div class="otp">
                            <p class="text-white text-center mb-3 fs-5">Vui lòng điền đầy đủ để đặt lại mật khẩu.</p>
                            <label for="email" class="form-label">Email</label>
                            <input type="text" name="email" id="email" class="form-control"
                                value="<?= is_array($_SESSION['email']) ? implode(', ', $_SESSION['email']) : $_SESSION['email'] ?>"
                                placeholder="Enter your email" required>
                            <label for="otp" class="form-label mt-3">OTP <span class="text-danger">*</span></label>
                            <input type="text" name="otp" id="otp" class="value-forgot d-block w-100" value required>
                        
                        </div>
                        <div class="newPassword mt-4">
                            <label for="newPassword" class="form-label m-0">Nhập mật khẩu mới <span
                                    class="text-danger">*</span></label>
                            <input type="password" name="password" id="password" class="value-forgot d-block w-100" value required>
                           
                        </div>
                        <div class="confirmPassword-value mt-4">
                            <label for="passwordConfirm" class="form-label m-0">Nhập lại mật khẩu mới<span
                                    class="text-danger">*</span></label>
                            <input type="password" name="passwordConfirm" id="passwordConfirm"
                                class="value-forgot d-block w-100" value>
                           
                        </div>
                        <button class="btn btn-info w-50 d-block m-auto text-dark fw-bold btn-submit mt-4" name="action"
                            value="reset">Đặt lại mật khẩu</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>