
<section id="forgotPassword">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="text-center text-white mt-5">QUÊN MẬT KHẨU
                        ?</h2>
                        <?php if (isset($error)): ?>
                            <div class="alert alert-danger text-center" role="alert">
                                <?= $error ?>
                            </div>
                        <?php endif; ?>
                    <div class="form-login">
                        <form action class="mt-4 w-50 mx-auto" method="POST">
                            <div class="email-value">
                                <p class="text-white text-center mb-3 fs-5">Vui lòng nhập địa chỉ email của bạn
                                    dưới đây để đặt lại mật khẩu.</p>
                                <label for="email" class="form-label m-0">Email <span
                                        class="text-danger">*</span></label>
                                <input type="email" name="email" id="email-forgot" class="value-forgot d-block w-100" value required>
                            </div>
                            
                            <button type="submit" class="btn btn-info w-50 d-block m-auto text-dark fw-bold btn-submit mt-4" name="action" value ="forgot">Đặt lại
                                mật khẩu</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>