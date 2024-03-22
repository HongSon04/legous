<div class="containerAdmin_order-detail p30">
    <div class="localDashboard">
        <div class="col-12 d-flex">
            <div class="col-6">
                <div class="col-12">
                    <h2>Chỉnh Sửa Sản Phẩm</h2>
                </div>
                <div class="col-12">
                    <span class="label-large">Admin /</span><a href="#" class="label-large"
                        style="text-decoration: none;">Sản Phẩm</a>
                </div>
                <div>

                </div>
            </div>
        </div>
    </div>

    <div class="sliderDashboard_order-add-create sliderDashboard_order-detail rounded-4">
        <div class="body_sliderDashboard_order-add-create p20 row">
            <div class="col-7">
                <form action="">
                    <div class="left-order-add-create">
                        <h2>Tên Sản Phẩm</h2>
                        <input class="" type="text" placeholder="Nhập tên sản phẩm" aria-label="default input example">
                    </div>
                    <div class="describe-order_detail">
                        <h2>Chiết tiết sản phẩm</h2>
                        <textarea name="" id="" cols="30" rows="10" placeholder="Nhập mô tả sản phẩm"></textarea>
                    </div>
                    <div class="Dropdowns_categogy">
                        <h2>Danh mục</h2>
                        <div class="custom-select">
                            <!-- Dropdown -->
                            <select id="dropdown" onchange="updateInput()">
                                <option value="0">Chọn danh mục sản phẩm</option>
                                <option value="1">Tùy chọn 1</option>
                                <option value="2">Tùy chọn 2</option>
                                <option value="3">Tùy chọn 3</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <h2>Sản phẩm còn lại</h2>
                            <input style="" class="" type="text" placeholder="1000" aria-label="default input example">
                        </div>
                        <div class="col-6">
                            <h2>Bộ sưu tập</h2>
                            <div class="custom-select">
                                <!-- Dropdown -->
                                <select id="dropdown" onchange="updateInput()">
                                    <option value="0">sản phẩm bộ sưu tập</option>
                                    <option value="1">Tùy chọn 1</option>
                                    <option value="2">Tùy chọn 2</option>
                                    <option value="3">Tùy chọn 3</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <h2>Sản phẩm còn lại</h2>
                            <input style="" class="" type="text" placeholder="1.000.000"
                                aria-label="default input example">
                        </div>
                        <div class="col-6">
                            <h2>Giá khuyến mãi</h2>
                            <input style="" class="" type="text" placeholder="1.000.000"
                                aria-label="default input example">
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-5 col-md">
                <div class="right-order-add-create p30 d-flex justify-content-center flex-column ">
                    <div class="img_order-add-create rounded-4">
                        <img src="../assets/media/images/category/dragon ball/Gohan - ZBC Studio/ab0332c4e1a739a15332b87eca29d1c71afce4f8a289fbc786c188c0 (1).png"
                            alt="">
                    </div>
                    <hr>
                    <div style="width: 100%;" id="drop-area">
                        <h3>Kéo thả ảnh ở đây</h3>
                        <input type="file" id="fileInput" accept="image/*" multiple>
                    </div>

                    <div style="width: 100%;" id="demo" class="demo .box-shadow1">

                    </div>
                    <div style="width: 100%;" id="deleteButtonImg" class="button_delete_img row">
                        <div class="col-4"></div>
                        <div class="col-8 d-flex justify-content-between">
                            <button type="button " class="btn btn-primary ">Cập nhật</button>
                            <button type="button" id="deleteButtonAll" class="btn btn-danger">Xóa</button>
                            <button type="button" class="btn box-shadow1 ">Hủy</button>
                        </div>
                    </div>
                </div>
                <div class="">
                    <span class="flex"></span>
                </div>
            </div>

        </div>
    </div>

</div>