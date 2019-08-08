<?php
require_once '../include/file_loaded.php';
global $base_url;

if ($_SERVER["REQUEST_METHOD"] == "POST" && $_POST['post_id']) {
    $news = new News();
    $news->id = $_POST['post_id'];
    $data = $news->get_new();
    $review = $data[0][5] + 1;
    $news->id = $data[0][0];
    $news->review = $review;
    $result = $news->add_review();
    if ($result) {
        echo json_encode($data);
    }
}
require_once 'head.php';
?>

<body>
<div class="row m-0">
    <div class="col-11 p-3 ml-3">
        <div id="container" class="row">
        </div>
    </div>
</div>

<?php require_once 'footer.php' ?>

<script src="<?= $base_url ?>assets/js/draw_post.js"></script>

</body>
</html>