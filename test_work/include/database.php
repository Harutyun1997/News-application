<?php
require_once 'file_loaded.php';

class Database
{
    public static $table_name;
    public static $db_fields;
    public $id;

    protected function create_array()
    {
        $result = [];
        foreach (static::$db_fields as $value) {

            $result[$value] = $this->$value;
        }


        return $result;
    }

    public function save()
    {
        return isset($this->id) ? $this->update() : $this->create();

    }

    protected function create()
    {
        $order = $this->create_array();
        $sql = "INSERT INTO " . static::$table_name . "(" . implode(',', array_keys($order)) . ") VALUES('"
            . implode("','", array_values($order)) . "')";
        return $this->set_sql_result($sql);
    }

    protected function update()
    {
        $order = $this->create_array();

        foreach ($order as $key => $value) {
            if ($key && !empty($value)) {
                $attributes_pairs[] = "{$key} = '{$value}'";
            }
        }
        $sql = "UPDATE " . static::$table_name . " SET ";
        $sql .= join(",", $attributes_pairs) . " WHERE id = " . $this->id;
        return $this->set_sql_result($sql);
    }

    public function delete()
    {
        $sql = "DELETE FROM " . static::$table_name . " WHERE id=" . $this->id;
       return $this->set_sql_result($sql);
    }

    public function get_table()
    {
        $sql = "SELECT * FROM " . static::$table_name;

        return $this->get_sql_result($sql);
    }

    protected function get_sql_result($sql)
    {
        global $link;
        $result = mysqli_query($link, $sql);
        $categories = mysqli_fetch_all($result);
        return $categories;
    }

    protected function set_sql_result($sql)
    {
        global $link;
        $result = mysqli_query($link, $sql);
        return $result;
    }

    public function clear_html_css_js($data)
    {
        $data = preg_replace('/<script\b[^>]*>(.*?)<\/script>/i', "", $data);
        $data = preg_replace("#(</?\w+)(?:\s(?:[^<>/]|/[^<>])*)?(/?>)#ui", '', $data);
        $data = strip_tags($data, "");
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        $data = str_replace("\n", "", $data);
        $data = str_replace("\t", "", $data);
        $data = str_replace("'", "", $data);
        return $data;
    }
}