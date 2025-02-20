<section id="accountInformation" class="py-5 h-100">
        <div class="container">
            <div class="row">
                <div class="col-md-12 shadow-lg p-3 mb-5 bg-white rounded w-75 mx-auto">
                    <h2 class="text-center">THÔNG TIN TÀI
                        KHOẢN</h2>
                    <div class="form-login w-50 m-auto">
                        <form action="users/updateAccount" class="mt-4" method="POST" enctype="multipart/form-data">
                            <div class="name-value">
                                <img class="" src="http://localhost:8000/<?php echo htmlspecialchars($user['avatar']); ?>" alt="Profile Image" style="border-radius:50%; width: 150px; height: 150px; margin: 0 160px">
                                <input type="file" name="avatar" id="avatar" accept="./image/" class="form-control value-forgot d-block w-100 mt-3 bg-transparent" value="<?php echo htmlspecialchars($user['avatar']); ?>">
                            </div>  
                            <br>
                            <div class="name-value">
                                <label for="name" class="form-label m-0">Tên <span class="text-danger">*</span></label>
                                <input type="text" name="name" id="name" class="form-control value-forgot d-block w-100" value="<?php echo htmlspecialchars($user['name']); ?> " required>
                            </div>
                            <div class="email-value mt-4">
                                <label for="email" class="form-label m-0">Email <span class="text-danger">*</span></label>
                                <input type="email" name="email" id="email" class="form-control value-forgot d-block w-100" value="<?php echo htmlspecialchars($user['email']); ?>" required>
                               
                            </div>
                            <div class="number-phone mt-4">
                                <label for="phone" class="form-label m-0 d-block">Số điện thoại <span class="text-danger">*</span></label>
                                <input type="text" name="phone" id="phone" class="form-control  value-forgot d-block w-100" value="<?php echo htmlspecialchars($user['phone']); ?>" required>
                                
                            </div>
                            <a href="/users/updateAccountPassword" class="change-password  text-decoration-none text-info mt-4 d-block">Đặt lại mật khẩu ? </a>
                                
                            <button class="btn btn-info w-50 d-block m-auto text-dark fw-bold btn-submit mt-5">CẬP NHẬT</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>