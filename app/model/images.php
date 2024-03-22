<?php

namespace App\model;


class Images {
    private $id = 0;
    private $id_product = 0;
    private $src = "";
    private $alt = "";
    private $is_thumbnail = 0;
    private $is_banner = 0;

    public function setId($id) {
        return $this->id = $id;
    }

    public function getId() {
        return $this->id;
    }

    public function setIdProduct($id_product) {
        return $this->id_product = $id_product;
    }

    public function getIdProduct() {
        return $this->id_product;
    }

    public function setSrc($src) {
        return $this->src = $src;
    }

    public function getSrc() {
        return $this->src;
    }

    public function setAlt($alt) {
        return $this->alt = $alt;
    }

    public function getAlt() {
        return $this->alt;
    }

    public function setIsThumbnail($is_thumbnail) {
        return $this->is_thumbnail = $is_thumbnail;
    }

    public function getIsThumbnail() {
        return $this->is_thumbnail;
    }

    public function setIsBanner($is_banner) {
        return $this->is_banner = $is_banner;
    }

    public function getIsBanner() {
        return $this->is_banner;
    }

    public function getThumbnailsById($idProduct)
    {
        $db = new database();
        $sql = "SELECT * FROM images WHERE is_thumbnail = 1 AND id_product = $idProduct";
        $result = $db->pdo_queryAll($sql);
        return $result;
    }
}

?>