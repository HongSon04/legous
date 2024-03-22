<?php

namespace App\controller;


class Controller
{
   public function index()
   {
      if (!empty($_SESSION['admin'])) {
         header("Location: /adminDashboard");
      }
      view("v_home");
   }
   //function cho trang chitiet
   public function productDetail()
   {
      view("v_productDetail");
   }
   public function product()
   {
      view("v_shop");
   }

   public function productCategory()
   {
      include_once('./app/view/v_productCate.php');
   }
}

