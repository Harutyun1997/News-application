<?php
require_once '../include/file_loaded.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['loading']) || isset($_POST['start']) || isset($_POST['day']) || isset($_POST['category_id'])) {

        $limit = 10;
        $limitCategories = 5;
        $category_id = '';
        $result = '';
        if (isset($_POST['loading'])) {
            $categories = new Categories();
            $categories->show_limit = $limitCategories;
            $result = $categories->get_top_categories();
        }

        $start = $_POST['start'] ?? 0;
        $day = $_POST['day'] ?? 0;
        $category_id = $_POST['category_id'] ?? '';
        $news = new News();
        $news->start = (int)$start;
        $news->limit = (int)$limit;
        $news->day = (int)$day;
        $news->category_id = (int)$category_id;
        $news->categories = $result;
        $data = $news->get_all_count_news_top_categories();
        echo json_encode($data);
        exit();
    } elseif (isset($_POST['category']) && isset($_POST['title']) && isset($_POST['content'])) {
        $new = new News();
        $arr = $_POST;

        foreach ($arr as $key => $value) {
            if ($key !== 'content') {
                $arr[$key] = $new->clear_html_css_js($value);
            } else {
                $text = json_decode($value, true);
                $str = $text ?? $value;
                $arr[$key] = mysqli_real_escape_string($link, $str);
            }
        };

        $categories = new Categories();
        $categories->category = $arr['category'];
        $category_id = $categories->get_id_category();
        date_default_timezone_set('Europe/Moscow');
        $today = date('Y-m-d h:i:s');
        if (!empty($_POST['post_id'])) {
            $new->id = $_POST['post_id'];
        }
        $new->title = $arr['title'];
        $new->category_id = $category_id[0][0];
        $new->text = $arr['content'];
        $new->date = $today;
        $result = $new->save();
        if ($result) {
            echo "Good";
        }
        exit();
    } elseif (isset($_POST['remove'])) {
        $new = new News();
        $new->id = $_POST['remove'];
        $result = $new->delete();
        if ($result) {
            echo "Good";
        }
        exit();
    } else {
        exit();
    }
} else {
    exit();
}