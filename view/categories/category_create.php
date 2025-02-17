<h1>Create Category</h1>
<form method="POST">
    <div class="mb-3">
        <label for="name" class="form-label">Category</label>
        <input type="text" class="form-control" id="name" name="name" >
        <?php if (isset($error)) { ?> <p class="text-danger"> <?php echo $error; ?> </p> <?php } ?>
    </div>
    <button type="submit" class="btn btn-success">Create</button>
</form>