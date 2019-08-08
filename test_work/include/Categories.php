<?php
require_once 'file_loaded.php';

class  Categories extends database
{
    public static $table_name = 'categories';
    public static $db_fields = [
        'id',
        'category',
    ];
    public $id;
    public $category;
    public $show_limit;

    public function get_top_categories()
    {
        $sql = 'SELECT n.`category_id`,c.`category`,COUNT(n.id)AS `count`  FROM news n
INNER JOIN ' . static::$table_name . ' c
ON n.category_id = c.id
GROUP BY n.`category_id`
ORDER BY `count` DESC
LIMIT ' . $this->show_limit . ';';
        return $this->get_sql_result($sql);
    }

    public function get_id_category()
    {
        $sql = "SELECT id FROM categories WHERE category = '$this->category'";
        return $this->get_sql_result($sql);
    }
}