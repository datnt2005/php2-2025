<main style="background-color: var(--color-main);">
<?php if (isset($error)): ?>
    <div class="alert alert-danger text-center" role="alert">
        <?= $error ?>
    </div>
<?php endif; ?>
    <div class="container form pt-5 pb-5">
        <div class="row">
            <div class="col-md-6">
                <div class="form_login--image">
                    <img src="/public/images/login15pr.jpg" alt class="w-100"
                        style="height: 600px; object-fit: cover; object-position: center; border-radius: 10px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-login p-5">
                    <h2 class="fs-3 fw-bold text-center text-white">ĐĂNG KÍ</h2>
                    <p class="text-center text-white">Đăng kí để có những trải nghiệm tốt nhất của
                        cửa
                        hàng chúng tôi</p>

                    <form action="" class="mt-4" method="POST">
                        <div class="name-value">
                            <label for class="form-label m-0">Tên <span class="text-danger">*</span></label>
                            <input type="text" name="name" id="name" class="input-value d-block w-100" required>

                        </div>

                        <div class="email-value mt-4">
                            <label for class="form-label m-0">Email <span class="text-danger">*</span></label>
                            <input type="email" name="email" id="email" class="input-value d-block w-100" required>

                        </div>
                        <div class="password-value mt-4">

                            <label for class="form-label m-0">Mật khẩu <span class="text-danger">*</span></label>
                            <input type="password" name="password" id="password" class="input-value d-block w-100" required>


                        </div>
                        <div class="terms mt-3 d-flex">
                            <input type="checkbox" name="term" id="term" class="" required>
                            <label class="m-2" for="">Tôi đã đọc và đồng ý với các <a href="#"
                                    class="text-decoration-none text-warning">điều khoản</a></label>
                        </div>

                        <button class="btn btn-primary w-100 btn-submit mt-4"
                            onclick="alertSuccessfully('ĐĂNG KÍ')">ĐĂNG KÍ</button>
                    </form>
                    <div class="text-end mt-1">
                        <p class="m-0 text-white">Bạn đã có tài khoản? <a href="login  "
                                class="text-decoration-none text-warning ">Đăng nhập</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>