<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Create Store</h3>
                </div>
                <form method="POST" class="m-5">
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                        <?php if (isset($errors['name'])) { echo "<p class='text-danger'>{$errors['name']}</p>"; } ?>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <input type="text" class="form-control" id="description" name="description">
                    </div>
                    <div class="form-group">
                        <label for="province">Tỉnh/Thành phố</label>
                        <select id="province" name="province" class="form-control" required>
                            <option value="">Chọn một tỉnh</option>
                            <?php foreach ($provinces as $province) { ?>
                                <option value="<?php echo $province['province_id']; ?>"><?php echo $province['name']; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="district">Quận/Huyện</label>
                        <select id="district" name="district" class="form-control" required>
                            <option value="">Chọn một quận/huyện</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="wards">Phường/Xã</label>
                        <select id="wards" name="wards" class="form-control" required>
                            <option value="">Chọn một xã</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="address" class="form-label">Address</label>
                        <input type="text" class="form-control" id="address" name="address" required>
                    </div>
                    <div class="mb-3">
                        <label for="phone" class="form-label">Phone</label>
                        <input type="text" class="form-control" id="phone" name="phone" pattern="[0-9]{10,11}" required>
                        <small class="text-muted">Số điện thoại phải có 10-11 số.</small>
                    </div>
                    <div class="mb-3">
                        <label for="start_time" class="form-label">Start Time</label>
                        <input type="time" class="form-control" id="start_time" name="start_time" required>
                    </div>
                    <div class="mb-3">
                        <label for="end_time" class="form-label">End Time</label>
                        <input type="time" class="form-control" id="end_time" name="end_time" required>
                    </div>
                    <button type="submit" class="btn btn-success">Create</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function () {
    function loadProvinces() {
        $.get("/location/provinces", function (data) {
            let options = '<option value="">Chọn một tỉnh</option>';
            data.forEach(province => {
                options += `<option value="${province.province_id}">${province.name}</option>`;
            });
            $("#province").html(options);
        }).fail(function () {
            alert("Lỗi khi tải danh sách tỉnh.");
        });
    }

    function loadDistricts(provinceId) {
        $.get(`/location/districts/${provinceId}`, function (data) {
            let options = '<option value="">Chọn một quận/huyện</option>';
            data.forEach(district => {
                options += `<option value="${district.district_id}">${district.name}</option>`;
            });
            $("#district").html(options);
            $("#wards").html('<option value="">Chọn một xã</option>');
        }).fail(function () {
            alert("Lỗi khi tải danh sách quận/huyện.");
        });
    }

    function loadWards(districtId) {
        $.get(`/location/wards/${districtId}`, function (data) {
            let options = '<option value="">Chọn một xã</option>';
            data.forEach(ward => {
                options += `<option value="${ward.ward_id}">${ward.name}</option>`;
            });
            $("#wards").html(options);
        }).fail(function () {
            alert("Lỗi khi tải danh sách phường/xã.");
        });
    }

    $("#province").change(function () {
        loadDistricts($(this).val());
    });

    $("#district").change(function () {
        loadWards($(this).val());
    });

    loadProvinces();
});
</script>