<?php
Class UrlClass {
    function __construct(mysqli $link) {
        $this->mysqli = $link;
    }
       /* --------------------------------------------maincategory starts--------------------------------------------------------*/
    public function addUrl($data) {
        $full_url = $data['full_url'];
        $shorten_url = $data['shorten_url'];
        $sql = "INSERT INTO url(shorten_url,full_url) VALUES ('$shorten_url','$full_url')";
        $result = $this->mysqli->query($sql);
        return true;
    }
    public function allUrlList() {
        $sql = "SELECT * FROM url order by id desc";
        $result = $this->mysqli->query($sql);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $array[] = $row;
            }
            return $array;
        }
    }

        public function urlFetch($new_url) {
        $sql = "SELECT * FROM url where shorten_url = '$new_url' ";
        $result = $this->mysqli->query($sql);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $array[] = $row;
            }
            return $array;
        }
    }
     public function deleteUrl($id) {
        $sql = "delete from url where id='$id'";
        $result = $this->mysqli->query($sql);
        return true;
    }
    
    
}
?>