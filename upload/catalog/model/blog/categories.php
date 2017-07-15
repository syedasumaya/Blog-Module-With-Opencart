<?php

class ModelBlogCategories extends Model {

    public function getTotalCategories($data = array()) {

        $sql = "SELECT COUNT(DISTINCT blog_category_id) AS total FROM " . DB_PREFIX . "blog_category
                WHERE blog_category_status = 1 ";

        $query = $this->db->query($sql);
        return $query->row['total'];
    }

    public function getCategories($data) {

        $sql = "SELECT * FROM " . DB_PREFIX . "blog_category WHERE blog_category_status = 1 ";

        $sort_data = array(
            'blog_category_name'
        );

        if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
            $sql .= " ORDER BY " . $data['sort'];
        } else {
            $sql .= " ORDER BY blog_category_name";
        }

        if (isset($data['order']) && ($data['order'] == 'ASC')) {
            $sql .= " ASC";
        } else {
            $sql .= " DESC";
        }

        if (isset($data['start']) || isset($data['limit'])) {
            if ($data['start'] < 0) {
                $data['start'] = 0;
            }

            if ($data['limit'] < 1) {
                $data['limit'] = 20;
            }

            $sql .= " LIMIT " . (int) $data['start'] . "," . (int) $data['limit'];
        }

        $query = $this->db->query($sql);
        return $query->rows;
    }

    public function getCategory($category_id) {
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "blog_category WHERE blog_category_id = '" . (int) $category_id . "' AND blog_category_status = '1'");

        return $query->row;
    }

}
