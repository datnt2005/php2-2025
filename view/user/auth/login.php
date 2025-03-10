<main style="background-color: var(--color-main); height: 720px;">
<?php if (isset($error)): ?>
<div class="alert alert-danger text-center" role="alert">
    <?= $error ?>
</div>
<?php endif; ?>
    <div class="container form pt-5">
        <div class="row">
            <div class="col-md-6">
                <div class="form_login--image">
                    <img src="/public/images/login15pr.jpg" alt class="w-100"
                        style="height: 600px; object-fit: cover; object-position: center; border-radius: 10px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-login">
                    <h2 class="fs-3 fw-bold text-center text-white">ĐĂNG NHẬP</h2>
                    <p class="text-center text-white">Đăng nhập để có những trải nghiệm tốt nhất của
                        cửa
                        hàng chúng tôi</p>

                    <form action="" class="mt-4" method="POST">
                        <div class="email-phone">
                            <label for class="form-label m-0 text-white fs-6">Email hoặc Tên đăng nhập<span
                                    class="text-danger">*</span></label>
                            <input type="text" name="email" id="email" class="input-value d-block w-100" required>
                        </div>
                        <div class="password-login mt-4">
                            <label for class="form-label m-0 text-white fs-6">Mật khẩu <span
                                    class="text-danger">*</span></label>
                            <input type="password" name="password" id="password" class="input-value d-block w-100">
                        </div>
                        <div class="forgot-pass text-end mt-3">
                            <a href="/forgotPassword" class="text- text-decoration-none text-warning">
                                Quên mật khẩu?
                            </a>
                        </div>
                        <button class="btn w-100 btn-submit btn-primary text-white fw-bold ">ĐĂNG NHẬP</button>
                        <a href='google/login' style="text-decoration: none">
                            <div id="g_id_onload"
                                data-client_id="284544138294-js7c7nrmu14e6a34dlmer48r384vcvh2.apps.googleusercontent.com"
                                data-context="signin" data-ux_mode="redirect"
                                data-login_uri="http://localhost:8000/google/login" data-auto_prompt="false">
                            </div>

                            <div style="width: 300px; margin-top: 20px; height: 30px; margin-left: 150px;"
                                class="g_id_signin" data-type="standard" data-shape="pill" data-theme="outline"
                                data-text="signin_with" data-size="medium" data-logo_alignment="left"
                                data-width="200px">
                            </div>
                        </a>
                    </form>

                    <p class="text-center mt-3 text-white">
                        Bạn chưa có tài khoản? <a href="/register" class="text-decoration-none text-warning">Register</a>
                    </p>

                </div>
            </div>
        </div>
    </div>
    </div>
</main>
<script src="https://accounts.google.com/gsi/client" async></script>