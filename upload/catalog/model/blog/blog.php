<?php
class ModelBlogBlog extends Model {
    
    public function getArticles($data) {
        
        $sql = "SELECT b.*,cat.* FROM " . DB_PREFIX . "blog as b LEFT JOIN " . DB_PREFIX . "blog_category as cat
                ON cat.blog_category_id = b.blog_category WHERE b.blog_status = 1 AND cat.blog_category_status = 1 ";

        if($data['category_id'] != ''){   
            $sql .="AND cat.blog_category_id = '".$data['category_id']."'";
        }
        if(($data['start_date']!='') && ($data['end_date']!='')){
            $sql .= "AND CAST(b.blog_created_date AS DATE) BETWEEN '".$data['start_date']."' AND '".$data['end_date']."'";
        }
        
        $sort_data = array(
            'b.blog_title',
            'b.blog_created_date',
            'b.blog_modified_date',
            'b.blog_sort_order',
            'b.blog_status',
            'b.blog_hits',
            'b.blog_comments',
            'cat.blog_category_name',
        );

        if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
            $sql .= " ORDER BY " . $data['sort'];
        } else {
            $sql .= " ORDER BY b.blog_created_date";
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
    
    public function getTotalBlogs($data = array()){
        
        $sql = "SELECT COUNT(DISTINCT b.blog_id) AS total FROM " . DB_PREFIX . "blog as b LEFT JOIN " . DB_PREFIX . "blog_category as cat
                ON cat.blog_category_id = b.blog_category WHERE b.blog_status = 1 AND cat.blog_category_status = 1 ";
        
        if($data['category_id'] != ''){    
            $sql .= "AND cat.blog_category_id = '".$data['category_id']."'";
        }
        
        if(($data['start_date']!='') && ($data['end_date']!='')){
            $sql .= "AND CAST(b.blog_created_date AS DATE) BETWEEN '".$data['end_date']."' AND '".$data['start_date']."'";
        } 
        $query = $this->db->query($sql);
        return $query->row['total'];
    }

    public function getUser($user_id) {
		$query = $this->db->query("SELECT *, (SELECT ug.name FROM `" . DB_PREFIX . "user_group` ug WHERE ug.user_group_id = u.user_group_id) AS user_group FROM `" . DB_PREFIX . "user` u WHERE u.user_id = '" . (int)$user_id . "'");
		return $query->row;
	}
        
   public function getTotalComment($blog_id){
       
       $sql = "SELECT COUNT(DISTINCT c.comment_id) AS total FROM " . DB_PREFIX . "blog_comment as c
                 WHERE c.comment_blog_id = '".$blog_id."' AND c.comment_status = 1";
        
        $query = $this->db->query($sql);
        return $query->row['total'];
   } 
   
   public function getCategory($category_id){
       
       $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "blog_category WHERE blog_category_id ='".$category_id."' AND blog_category_status = 1");
       return $query->row;
   }
   
   public function getCategories(){
       $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "blog_category WHERE blog_category_status = 1");
       return $query->rows;
   }
   
   public function getFeatured($limit){
       $query = $this->db->query("SELECT b.* FROM " . DB_PREFIX . "blog as b LEFT JOIN " . DB_PREFIX . "blog_category as cat ON cat.blog_category_id = b.blog_category WHERE b.blog_featured = 1 AND b.blog_status =1 AND cat.blog_category_status = 1 LIMIT 0" .$limit);
       return $query->rows;
   }
   public function getPopular($setting){
       
       if($setting['popular_by'] == 'visit'){
       $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "blog ORDER BY blog_hits DESC LIMIT 0" .$setting['limit']);
       }else{
       $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "blog ORDER BY blog_comments DESC LIMIT 0" .$setting['limit']);    
       }
       return $query->rows;
   }
   
   public function getRecentPost($limit){
       
       $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "blog ORDER BY blog_created_date DESC LIMIT 0" .$limit);
       return $query->rows;
   }
   
   public function getArticle($blog_id){ 
       
       $query = $this->db->query("SELECT b.*,cat.*,c.*,u.username,(SELECT COUNT(DISTINCT c.comment_id) AS total FROM " . DB_PREFIX . "blog_comment as c
                WHERE c.comment_blog_id = b.blog_id AND c.comment_status = 1)AS total_comment FROM " . DB_PREFIX . "blog as b
                LEFT JOIN " . DB_PREFIX . "blog_category as cat ON cat.blog_category_id = b.blog_category
                LEFT JOIN " . DB_PREFIX . "blog_comment as c ON c.comment_blog_id = b.blog_id   
                LEFT JOIN " . DB_PREFIX . "user as u ON u.user_id = b.blog_creator    
                WHERE b.blog_id ='".$blog_id."' AND b.blog_status = 1 AND cat.blog_category_status = 1
               ");
       return $query->row;
   }
   public function getTags(){
      $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "blog ORDER BY blog_hits DESC");
      return $query->rows; 
   }
   
   public function updateBlogHits($data){
       $hits = $data['blog_hits']+1;
       $query = $this->db->query("UPDATE " . DB_PREFIX . "blog SET blog_hits ='".$hits."' WHERE blog_id='".$data['blog_id']."'");
       
       return true;
   }
   
   public function checkCustomer($data){
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "customer WHERE email='".$data['email']."' AND status = 1");
        $sql = $query->row; 
        if(count($sql)>0){
           return $customer = array(
               'customer_id' => $sql['customer_id'],
               'name' => $sql['firstname'].' '.$sql['lastname'],
               'email' => $sql['email'],
               'comment' => $data['comment'],
               'blog_id' => $data['blog_id'],
               'show_auto_publish_comment' => $data['show_auto_publish_comment']
               );
        }else{
            return false;
        }
        
   }
   
   public function insertComment($data){
       
       if($data['show_auto_publish_comment'] == 1){
           $comment_status = 1;
       }else{
           $comment_status = 0; 
       }
       $created_date =  date("Y-m-d h:i:s");
       
       $query = $this->db->query("INSERT INTO " . DB_PREFIX . "blog_comment SET 
                comment = '".$data['comment']."',
                comment_blog_id = '".$data['blog_id']."',   
                comment_user_id = '".$data['customer_id']."',   
                comment_user_name = '".$data['name']."',   
                comment_user_email = '".$data['email']."',   
                comment_created_date = '".$created_date."',   
                comment_modified_date = '".$created_date."',   
                comment_status = '".$comment_status."'  
                    
        ");
       return true;
   }
   
   public function getComments($data){
       
        $sql = "SELECT * FROM " . DB_PREFIX . "blog_comment
                 WHERE comment_blog_id = '".$data['blog_id']."' AND comment_status = 1
                ";
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

   public function saveAccessToken($longLivedAccessToken,$store_id){
      $accessToken = (string)$longLivedAccessToken;
      $code = 'blog';
      $this->db->query("DELETE FROM `" . DB_PREFIX . "setting` WHERE store_id = '" . (int)$store_id . "' AND `code` = '" . $this->db->escape($code) . "' AND `key` = 'blog_facebook_access_token'");
      
      $query = $this->db->query("INSERT INTO " . DB_PREFIX . "setting SET 
                `store_id` = '".$store_id."',
                `code` = '".$code."',   
                `key` = 'blog_facebook_access_token',   
                `value` = '".$accessToken."',   
                `serialized` = 0              
                    
        ");


      $this->db->query("DELETE FROM `" . DB_PREFIX . "setting` WHERE store_id = '" . (int)$store_id . "' AND `code` = '" . $this->db->escape($code) . "' AND `key` = 'blog_facebook_access_token_time'");
      $date = date('Y-m-d');
      $query = $this->db->query("INSERT INTO " . DB_PREFIX . "setting SET 
                `store_id` = '".$store_id."',
                `code` = '".$code."',   
                `key` = 'blog_facebook_access_token_time',   
                `value` = '".$date."',   
                `serialized` = 0              
                    
        ");
         return true; 
      
   }
    
}
