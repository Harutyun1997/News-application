<?php
require_once '../include/Categories.php';
$categories = new Categories();
$data = $categories->get_table();
?>
<div class="modal fade" id="postModal" tabindex="-1" role="dialog" aria-labelledby="postModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="postModalLabel">Create new post</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="create-new-post" name="create-new-post">
                <div class="modal-body">
                    <input type="hidden" name="post_id">
                    <div class="form-group">
                        <label for="category">Category</label>
                        <select class="form-control" id="category" name="category" required>
                            <?php foreach ($data as $value) { ?>
                                <option> <?= $value[1] ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="post-title" class="col-form-label">Title</label>
                        <input type="text" name="title" class="form-control" id="post-title" required>
                    </div>
                    <div class="form-group">
                        <label for="post-text" class="col-form-label">Content</label>
                        <textarea class="form-control" name="content" id="post-text" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary new-create">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>