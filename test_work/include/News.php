<?php
require_once 'file_loaded.php';

class News extends database
{
    use  addElement;
    public static $table_name = 'news';
    public static $db_fields = [
        'id',
        'title',
        'text',
        'category_id',
        'date',
        'review'
    ];

    public $id;
    public $title;
    public $text;
    public $category_id;
    public $date;
    public $review;
    public $start;
    public $limit;
    public $day;
    public $categories;
    public $sql;

    public function get_all_count_news_top_categories()
    {
        $this->getClassName();
        date_default_timezone_set('Europe/Moscow');
        $today = date('Y-m-d', strtotime('+1 days'));
        $this->sql = '';
        switch ($this->day) {
            case 1:
                $date = date('Y-m-d');
                $this->sql = ' WHERE  `date` BETWEEN  "' . $date . '"   AND "' . $today . '" ';
                break;
            case 3:
                $date = date('Y-m-d', strtotime("-3 days"));
                $this->sql = ' WHERE  `date` BETWEEN  "' . $date . '"   AND "' . $today . '" ';
                break;
            case 7:
                $date = date('Y-m-d', strtotime("-1 week"));
                $this->sql = ' WHERE  `date` BETWEEN  "' . $date . '"   AND "' . $today . '" ';
                break;
            case 30:
                $date = date('Y-m-d', strtotime("-1 month"));
                $this->sql = ' WHERE  `date` BETWEEN  "' . $date . '"   AND "' . $today . '" ';
                break;
        }
        if (!empty($this->category_id)) {
            $this->sql = ' WHERE `category_id`=' . $this->category_id;
        }

        $result = [];
        if ($this->start === 0) {
            $count = $this->get_count_table();
            $result['count'] = $count[0][0];
        }
        if (!empty($this->categories)) {
            $result['categories'] = $this->categories;
        }
        $news = $this->get_news();
        foreach ($news as $key => $value) {
            $text = json_decode($value[2], true);
            isset($text) ? $str = $text : $str = $value[2];
            $news[$key]['img'] = $this->search_img($str);
        }
        $result['data'] = $news;
        return $result;
    }


    public function get_news()
    {
        $sql = "SELECT  n.*,c.`category`  FROM ." . static::$table_name . " n
INNER JOIN categories c
ON n.category_id = c.id $this->sql LIMIT  $this->start,$this->limit;";
        return $this->get_sql_result($sql);
    }

    public function get_new()
    {
        $sql = "SELECT  n.*,c.`category`  FROM ." . static::$table_name . " n
INNER JOIN categories c
ON n.category_id = c.id
WHERE n.id = $this->id;";
        return $this->get_sql_result($sql);
    }

    public function get_count_table()
    {
        $sql = "SELECT COUNT(*) FROM " . static::$table_name . $this->sql;
        return $this->get_sql_result($sql);
    }

    public function search_img($str)
    {
        $start = strpos($str, "<img");
        $res = substr($str, $start);
        $end = strpos($res, '>') + 1;
        $result = mb_substr($res, 0, $end);

        if (!($start && $end)) {
            global $base_url;
            $url = $base_url . 'assets/images/source.gif" alt="New post" title="New post"/>';
            $result = '<img src="' . $url;
        }
        return $result;
    }

    public function add_review()
    {
        $sql = "UPDATE " . static::$table_name . " SET review =$this->review WHERE id=$this->id";
        return $this->set_sql_result($sql);
    }
}

trait addElement
{
    public function getClassName()
    {
        return 'Privet';
    }
}
