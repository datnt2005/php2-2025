<div class="container-fluid">
    <!-- Alert box for system notifications -->
    <!-- <div class="alert-box">
            <strong>Thông báo:</strong> 
        </div> -->

    <!-- Row for the cards -->
    <div class="row mb-3">
        <div class="card-container">
            <div class="card">
                <h2>Tổng Đơn Hàng</h2>
                <p id="totalRevenue"><?php echo number_format($totalRevenue); ?></p>
            </div>
            <div class="card">
                <h2>Doanh thu thực tế</h2>
                <p id="totalRevenueSuccess"><?php echo number_format($totalRevenueSuccess); ?></p>
            </div>
            <div class="card">
                <h2>Đơn hàng hóa đơn</h2>
                <p id="totalOrders"><?php echo number_format($totalOrders); ?></p>
            </div>
            <div class="card">
                <h2>Sản phẩm đã bán</h2>
                <p id="totalSoldProducts"><?php echo number_format($totalSoldProducts); ?> </p>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row">
            <!-- Biểu đồ doanh thu hàng tháng -->
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Doanh thu</h5>
                    </div>
                    <div class="card-body">
                        <canvas id="revenueChart"></canvas>
                        <h5 class="mt-3">Tổng doanh thu: <span id="total-revenue-monthly"
                                class="fw-bold"><?php echo number_format($totalRevenue); ?></span>
                        </h5>
                    </div>
                </div>
            </div>
            <!-- Biểu đồ tồn kho -->
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Tồn kho sản phẩm</h5>
                    </div>
                    <div class="card-body">
                        <canvas id="stockChart"></canvas>
                        <h5 class="mt-3">Tổng số lượng sản phẩm tồn kho: <span id="total-stock"
                                class="fw-bold"><?php echo $totalStock; ?></span></h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid">
    <!-- Row for the charts -->
    <div class="row mt-3">
        <!-- Order Status Chart -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Đơn hàng theo trạng thái</h5>
                </div>
                <div class="card-body">
                    <canvas id="orderStatusChart" style="max-width: 600px; max-height: 600px;"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Sản phẩm bán chạy</h5>
                </div>
                <div class="card-body">
                    <canvas id="bestSellingChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>
</div>

<script>
// Dữ liệu doanh thu hàng tháng và theo ngày
const months = <?php echo json_encode($months); ?>;
const monthlyRevenues = <?php echo json_encode($monthlyRevenues); ?>;
const orderDates = <?php echo json_encode($orderDates); ?>;
const dailyRevenues = <?php echo json_encode($dailyRevenues); ?>;

// Dữ liệu tồn kho
const productNames = <?php echo json_encode($productNames); ?>;
const stockCounts = <?php echo json_encode($stockCounts); ?>;

document.addEventListener("DOMContentLoaded", function() {
    // Dữ liệu từ PHP
    const dailyRevenues = <?php echo json_encode($data['dailyRevenues']); ?>;
    const orderDates = <?php echo json_encode($data['orderDates']); ?>;

    // Tạo biểu đồ doanh thu theo ngày
    const ctx = document.getElementById('revenueChart').getContext('2d');
    new Chart(ctx, {
        type: 'line', // Loại biểu đồ (line, bar, pie, ...)
        data: {
            labels: orderDates, // Ngày tháng
            datasets: [{
                label: 'Doanh thu theo ngày',
                data: dailyRevenues, // Doanh thu theo ngày
                borderColor: 'blue',
                backgroundColor: 'rgba(0, 0, 255, 0.2)',
                fill: true
            }]
        }
    });
});

document.addEventListener("DOMContentLoaded", function() {
    // Dữ liệu tồn kho
    const productNames = <?php echo json_encode($data['productNames']); ?>;
    const stockCounts = <?php echo json_encode($data['stockCounts']); ?>;

    // Kiểm tra nếu dữ liệu tồn kho có rỗng không
    if (productNames.length === 0 || stockCounts.length === 0) {
        console.warn("Không có dữ liệu tồn kho.");
        return;
    }

    // Vẽ biểu đồ tồn kho
    const ctxStock = document.getElementById('stockChart').getContext('2d');
    new Chart(ctxStock, {
        type: 'bar',
        data: {
            labels: productNames,
            datasets: [{
                label: 'Số lượng tồn kho',
                data: stockCounts,
                backgroundColor: 'rgba(153, 102, 255, 0.2)',
                borderColor: 'rgba(153, 102, 255, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
});

document.addEventListener("DOMContentLoaded", function () {
        const statusLabels = <?php echo json_encode($statusLabels); ?>;
        const statusCounts = <?php echo json_encode($statusCounts); ?>;

        const ctxStatus = document.getElementById('orderStatusChart').getContext('2d');
        new Chart(ctxStatus, {
            type: 'pie',
            data: {
                labels: statusLabels,
                datasets: [{
                    label: 'Trạng thái đơn hàng',
                    data: statusCounts,
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.6)',  // Chờ xử lý - đỏ
                        'rgba(54, 162, 235, 0.6)',  // Đang xử lý - xanh dương
                        'rgba(255, 206, 86, 0.6)',  // Đã giao hàng - vàng
                        'rgba(75, 192, 192, 0.6)',  // Hoàn thành - xanh lá
                        'rgba(153, 102, 255, 0.6)'  // Đã huỷ - tím
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)'
                    ],
                    borderWidth: 1,
                    width:25
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'right'
                    }
                }
            }
        });
    });

    document.addEventListener("DOMContentLoaded", function () {
        const bestSellingNames = <?php echo json_encode($bestSellingNames); ?>;
        const bestSellingCounts = <?php echo json_encode($bestSellingCounts); ?>;

        const ctxBestSelling = document.getElementById('bestSellingChart').getContext('2d');
        new Chart(ctxBestSelling, {
            type: 'bar',
            data: {
                labels: bestSellingNames,
                datasets: [{
                    label: 'Số lượng bán ra',
                    data: bestSellingCounts,
                    backgroundColor: 'rgba(255, 159, 64, 0.6)',
                    borderColor: 'rgba(255, 159, 64, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    });
</script>

<style>
.card-container {
    display: flex;
    justify-content: space-between;
    gap: 20px;
    margin-bottom: 20px;
}

.card {
    background-color: #fff;
    border-radius: 8px;
    padding: 20px;
    flex: 1;
    text-align: center;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

.card h2 {
    font-size: 18px;
    margin: 0;
    color: #666;
}

.card p {
    font-size: 24px;
    font-weight: bold;
    color: #333;
}

.table {
    width: 100%;
    margin-top: 20px;
    border-collapse: collapse;
}

.table th,
.table td {
    padding: 10px;
    border: 1px solid #ddd;
    text-align: center;
}

.table th {
    background-color: #f5f5f5;
    font-weight: bold;
}

.chart-container {
    margin-top: 30px;
}

canvas {
    width: 100% !important;
    height: auto !important;
}

.alert-box {
    background-color: #f8d7da;
    color: #721c24;
    padding: 10px;
    margin: 20px 0;
    border-radius: 5px;
}
</style>