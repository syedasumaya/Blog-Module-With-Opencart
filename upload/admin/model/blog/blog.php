<?php

class ModelBlogBlog extends Model {

    public function addCategory($data) {

        $this->db->query("INSERT INTO " . DB_PREFIX . "blog_category SET blog_category_name = '" . $this->db->escape($data['category_title']) . "', blog_category_description = '" . $this->db->escape($data['category_description']) . "', blog_category_sort_order = '" . $this->db->escape($data['sort_order']) . "', blog_category_seo_keyword = '" . $this->db->escape($data['seo_keyword']) . "',blog_category_status = '" . $this->db->escape($data['blog_category_status']) . "'");

        return true;
    }

    public function checkDuplicateEntry($fieldname, $table, $value) {

        $sql = $this->db->query("SELECT * FROM " . DB_PREFIX . $table . " WHERE " . $fieldname . " = '" . $value . "'");

        if ($sql->num_rows > 0) {
            return 0;
        } else {
            return 1;
        }
    }

    public function checkDuplicateEntryEdit($fieldname, $table, $value, $category_id) {

        $sql = $this->db->query("SELECT * FROM " . DB_PREFIX . $table . " WHERE " . $fieldname . " = '" . $value . "' AND blog_category_id <> '" . $category_id . "'");

        if ($sql->num_rows > 0) {
            return 0;
        } else {
            return 1;
        }
    }

    public function getAllCategories($data = array()) {
        //$sql = $this->db->query("SELECT * FROM " . DB_PREFIX . "blog_category");
        //return $sql->rows;
        $sql = "SELECT * FROM " . DB_PREFIX . "blog_category WHERE 1 ";

        if (!empty($data['filter_name'])) {
            $sql .= " AND blog_category_name LIKE '" . $this->db->escape($data['filter_name']) . "%'";
        }

        if (isset($data['filter_status']) && !is_null($data['filter_status'])) {
            $sql .= " AND blog_category_status = '" . (int) $data['filter_status'] . "'";
        }

        $sort_data = array(
            'blog_category_name',
            'blog_category_sort_order',
            'blog_category_status'
        );

        if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
            $sql .= " ORDER BY " . $data['sort'];
        } else {
            $sql .= " ORDER BY blog_category_name";
        }

        if (isset($data['order']) && ($data['order'] == 'DESC')) {
            $sql .= " DESC";
        } else {
            $sql .= " ASC";
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

    public function getAllComments($data = array()) {
        
        $sql = "SELECT c.*,b.blog_title FROM " . DB_PREFIX . "blog_comment as c LEFT JOIN  " . DB_PREFIX . "blog as b ON b.blog_id = c.comment_blog_id WHERE 1";

        if (!empty($data['filter_name'])) {
            $sql .= " AND b.blog_title LIKE '" . $this->db->escape($data['filter_name']) . "%'";
        }

        if (!empty($data['filter_email'])) {
            $sql .= " AND c.comment_user_email LIKE '" . $this->db->escape($data['filter_email']) . "%'";
        }
        if (isset($data['filter_status']) && !is_null($data['filter_status'])) {
            $sql .= " AND c.comment_status = '" . (int) $data['filter_status'] . "'";
        }
        if (!empty($data['filter_created_date'])) {
            $sql .= " AND c.comment_created_date LIKE '" . $this->db->escape($data['filter_created_date']) . "%'";
        }

        $sort_data = array(
            'c.comment',
            'c.comment_blog_id',
            'c.comment_user_email',
            'c.comment_created_date',
            'c.comment_modified_date',
            'c.comment_status'
        );

        if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
            $sql .= " ORDER BY " . $data['sort'];
        } else {
            $sql .= " ORDER BY c.comment_created_date";
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
        $sql = $this->db->query("SELECT * FROM " . DB_PREFIX . "blog_category WHERE `blog_category_id`='" . $category_id . "'");
        return $sql->row;
    }

    public function editCategory($category_id, $data) {
        $this->db->query("UPDATE " . DB_PREFIX . "blog_category SET blog_category_name ='" . $data['category_title'] . "', blog_category_description ='" . $data['category_description'] . "', blog_category_sort_order ='" . $data['sort_order'] . "', blog_category_seo_keyword ='" . $data['seo_keyword'] . "', blog_category_status = '" . $data['blog_category_status'] . "' WHERE blog_category_id ='" . $category_id . "'");
        return true;
    }

    public function deleteCategory($category_id) {
        $this->db->query("DELETE FROM " . DB_PREFIX . "blog_category WHERE blog_category_id ='" . $category_id . "'");
        return true;
    }

    public function deleteComment($comment_id) {
        $this->db->query("DELETE FROM " . DB_PREFIX . "blog_comment WHERE comment_id ='" . $comment_id . "'");
        return true;
    }

    public function addArticle($data) {
        if (isset($data['blog_related'])) {
            $related = implode(',', $data['blog_related']);
        } else {
            $related = "";
        }

        $this->db->query("INSERT INTO " . DB_PREFIX . "blog SET blog_title = '" . $this->db->escape($data['blog_title']) . "',
                    blog_description ='" . $this->db->escape($data['blog_description']) . "',
                    blog_category ='" . $data['blog_category'] . "',
                    blog_tags ='" . $this->db->escape($data['blog_tags']) . "',    
                    blog_hits ='" . $data['blog_hits'] . "',
                    blog_seo_keyword ='" . $data['blog_seo_keyword'] . "', 
                    blog_creator ='" . $data['blog_creator'] . "', 
                    blog_created_date ='" . $data['blog_created_date'] . "',
                    blog_modified_date ='" . $data['blog_created_date'] . "',
                    blog_status ='" . $data['blog_status'] . "',
                    blog_featured ='" . $data['blog_featured'] . "',
                    blog_related ='" . $related . "',
                    blog_image ='" . $data['blog_image'] . "', 
                    blog_sort_order ='" . $data['blog_sort_order'] . "'     
            ");
        return $this->db->getLastId();
    }

    public function getArticles($data) {
        
        $sql = "SELECT * FROM " . DB_PREFIX . "blog WHERE 1";

        if (!empty($data['filter_name'])) {
            $sql .= " AND blog_title LIKE '" . $this->db->escape($data['filter_name']) . "%'";
        }

        if (isset($data['filter_status']) && !is_null($data['filter_status'])) {
            $sql .= " AND blog_status = '" . (int) $data['filter_status'] . "'";
        }
        if (isset($data['filter_featured']) && !is_null($data['filter_featured'])) {
            $sql .= " AND blog_featured = '" . (int) $data['filter_featured'] . "'";
        }

        if (!empty($data['filter_created_date'])) {
            $sql .= " AND blog_created_date LIKE '" . $this->db->escape($data['filter_created_date']) . "%'";
        }

        $sort_data = array(
            'blog_title',
            'blog_created_date',
            'blog_modified_date',
            'blog_sort_order',
            'blog_status',
            'blog_hits',
            'blog_featured'
        );

        if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
            $sql .= " ORDER BY " . $data['sort'];
        } else {
            $sql .= " ORDER BY blog_title";
        }

        if (isset($data['order']) && ($data['order'] == 'DESC')) {
            $sql .= " DESC";
        } else {
            $sql .= " ASC";
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

    public function getArticle($blog_id) {
        $sql = $this->db->query("SELECT * FROM " . DB_PREFIX . "blog WHERE blog_id ='" . $blog_id . "'");
        return $sql->row;
    }

    public function getComment($comment_id) {

        $sql = $this->db->query("SELECT c.*,b.blog_title FROM " . DB_PREFIX . "blog_comment as c LEFT JOIN " . DB_PREFIX . "blog as b ON b.blog_id = c.comment_blog_id WHERE c.comment_id ='" . $comment_id . "'");
        return $sql->row;
    }

    public function editComment($comment_id, $data) {

        $modified_date = date("Y-m-d H:m:s");
        $comment = htmlentities($data['comment'], ENT_QUOTES, 'UTF-8');

        $this->db->query("UPDATE " . DB_PREFIX . "blog_comment SET 
                    comment_status ='" . $data['comment_status'] . "',
                    comment ='" . $comment . "',
                    comment_modified_date ='" . $modified_date . "'    
                    WHERE comment_id = '" . $comment_id . "'    
            ");

        return true;
    }

    public function publishComment($comment_id) {

        $modified_date = date("Y-m-d H:m:s");

        $this->db->query("UPDATE " . DB_PREFIX . "blog_comment SET 
                    comment_status = 1,
                    comment_modified_date ='" . $modified_date . "'    
                    WHERE comment_id = '" . $comment_id . "'    
            ");

        return true;
    }

    public function unpublishComment($comment_id) {

        $modified_date = date("Y-m-d H:m:s");

        $this->db->query("UPDATE " . DB_PREFIX . "blog_comment SET 
                    comment_status = 0,
                    comment_modified_date ='" . $modified_date . "'    
                    WHERE comment_id = '" . $comment_id . "'    
            ");

        return true;
    }

    public function editArticle($blog_id, $data) {

        $modified_date = date("Y-m-d H:m:s");
        if (isset($data['blog_related']) && $data['blog_related'] != '') {
            $related = implode(',', $data['blog_related']);
        } else {
            $related = '';
        }

        $this->db->query("UPDATE " . DB_PREFIX . "blog SET blog_title = '" . $this->db->escape($data['blog_title']) . "',
                    blog_description ='" . $this->db->escape($data['blog_description']) . "',
                    blog_category ='" . $data['blog_category'] . "',
                    blog_tags ='" . $this->db->escape($data['blog_tags']) . "',    
                    blog_hits ='" . $data['blog_hits'] . "',
                    blog_seo_keyword ='" . $data['blog_seo_keyword'] . "', 
                    blog_creator ='" . $data['blog_creator'] . "', 
                    blog_created_date ='" . $data['blog_created_date'] . "',
                    blog_modified_date ='" . $modified_date . "',
                    blog_status ='" . $data['blog_status'] . "',
                    blog_featured ='" . $data['blog_featured'] . "',
                    blog_related ='" . $related . "',    
                    blog_image ='" . $data['blog_image'] . "', 
                    blog_sort_order ='" . $data['blog_sort_order'] . "' 
                    WHERE blog_id = '" . $blog_id . "'    
            ");
        return true;
    }

    public function deleteArticle($blog_id) {

        $this->db->query("DELETE FROM " . DB_PREFIX . "blog WHERE blog_id ='" . $blog_id . "'");
        return true;
    }

    public function getTotalBlogs($data = array()) {

        $sql = "SELECT COUNT(DISTINCT blog_id) AS total FROM " . DB_PREFIX . "blog WHERE 1";

        if (!empty($data['filter_name'])) {
            $sql .= " AND blog_title LIKE '" . $this->db->escape($data['filter_name']) . "%'";
        }

        if (isset($data['filter_status']) && !is_null($data['filter_status'])) {
            $sql .= " AND blog_status = '" . (int) $data['filter_status'] . "'";
        }
        if (isset($data['filter_featured']) && !is_null($data['filter_featured'])) {
            $sql .= " AND blog_featured = '" . (int) $data['filter_featured'] . "'";
        }

        if (!empty($data['filter_created_date'])) {
            $sql .= " AND blog_created_date LIKE '" . $this->db->escape($data['filter_created_date']) . "%'";
        }

        $query = $this->db->query($sql);

        return $query->row['total'];
    }

    public function getTotalCategory($data = array()) {

        $sql = "SELECT COUNT(DISTINCT blog_category_id) AS total FROM " . DB_PREFIX . "blog_category WHERE 1";

        if (!empty($data['filter_name'])) {
            $sql .= " AND blog_category_name LIKE '" . $this->db->escape($data['filter_name']) . "%'";
        }

        if (!empty($data['filter_status'])) {
            $sql .= " AND blog_category_status LIKE '" . $this->db->escape($data['filter_status']) . "%'";
        }

        $query = $this->db->query($sql);

        return $query->row['total'];
    }

    public function getTotalComment() {

        $sql = "SELECT COUNT(DISTINCT comment_id) AS total FROM " . DB_PREFIX . "blog_comment WHERE 1";
        $query = $this->db->query($sql);
        return $query->row['total'];
    }
    
    public function removeAccessToken($store_id){
        $accessToken = '';
        $code = 'blog';
        $this->db->query("DELETE FROM `" . DB_PREFIX . "setting` WHERE store_id = '" . (int)$store_id . "' AND `code` = '" . $this->db->escape($code) . "' AND `key` = 'blog_facebook_access_token'");
      
      $query = $this->db->query("INSERT INTO " . DB_PREFIX . "setting SET 
                `store_id` = '".$store_id."',
                `code` = '".$code."',   
                `key` = 'blog_facebook_access_token',   
                `value` = '".$accessToken."',   
                `serialized` = 0              
                    
        ");
         return true; 
   }

}
