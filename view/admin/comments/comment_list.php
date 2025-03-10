<div class="container-fluid">
    <!-- Place your content here -->
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Comments</h3>
                </div>
                <a href="/comments/create" class="btn btn-primary mb-3 w-25 mt-3 ms-3">Create comment</a>
                <table class="table table-bordered table-striped">
                    <thead class="table-dark">
                        <tr>
                            <th>User</th>
                            <th>Comment</th>
                            <th>Product</th>
                            <th>Image</th>
                            <th>Time</th>
                            <th>Rating</th>
                            <th>Like</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($comments as $comment): ?>
                        <tr>
                            <td><?= $comment['nameUser'] ?></td>
                            <td><?= $comment['content'] ?></td>
                            <td><?= $comment['nameProduct'] ?></td>
                            <td>
                                <?php if (empty($comment['media_urls'])): ?>
                                <span>---</span>
                                <?php else: ?>
                                <?php 
                                     $mediaUrls = explode(', ', $comment['media_urls']); 
                                     $mediaTypes = explode(', ', $comment['media_types']);
                                 ?>
                                <?php foreach ($mediaUrls as $index => $mediaUrl): ?>
                                <?php if (strpos($mediaTypes[$index], 'image') !== false): ?>
                                <img src="http://localhost:8000/<?= trim($mediaUrl) ?>" alt="Image"
                                    style="width: 70px; height: 70px; margin-right: 5px;">
                                <?php elseif (strpos($mediaTypes[$index], 'video') !== false): ?>
                                <video style="width: 70px; height: 70px; margin-right: 5px;" controls>
                                    <source src="http://localhost:8000/<?= trim($mediaUrl) ?>"
                                        type="<?= trim($mediaTypes[$index]) ?>">
                                    Your browser does not support the video tag.
                                </video>
                                <?php endif; ?>
                                <?php endforeach; ?>
                                <?php endif; ?>
                            </td>

                            <td><?= $comment['created_at'] ?></td>
                            <td><?= $comment['rating'] ?></td>
                            <td><?= $comment['likes'] ?></td>
                            <td><?= $comment['status'] ?></td>
                            <td>
                                <a href="/products/<?= $comment['idProduct'] ?>" class="btn btn-info btn-sm">View</a>
                                <a href="/comments/edit/<?= $comment['id'] ?>" class="btn btn-warning btn-sm">Edit</a>
                                <a href="javascript:void(0);" onclick="deleteComment(this)" data-id="<?= $comment['id'] ?>" class="btn btn-danger btn-sm">Delete</a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    function deleteComment(element) {
        var id = element.getAttribute('data-id');
        if (confirm("Bạn có chắc chắn muốn xóa?")) {
            window.location.href = "/comments/delete/" + id;
        }
    }
</script>