<?php
// echo '<pre>';
// print_r($_GET);
// echo '</pre>';

?>

<section class="product-area">
    <div class="container">
        <div class="shop-top">
            <form action="" id="form-prod-category" method="post">
                <div class="row">
                    <div class="col-lg-9">
                        <div class="category-select">
                            <select class="niceSelect" name="cate_id">
                                <option value="">Danh mục</option>
                                <?php foreach ($dataCateList as $cateItem) : ?>
                                    <option value="<?php echo $cateItem['id'] ?>"><?php echo $cateItem['name'] ?></option>
                                <?php endforeach ?>

                            </select>


                            <select class="niceSelect" name="color">
                                <option value="">Color</option>
                                <?php foreach ($dataColor as $colorItem) : ?>
                                    <option><?php echo $colorItem['value'] ?></option>
                                <?php endforeach ?>
                            </select>

                            <select class="niceSelect" name="size">
                                <option value="">Size</option>
                                <?php foreach ($dataSize as $sizeItem) : ?>
                                    <option><?php echo $sizeItem['value'] ?></option>
                                <?php endforeach ?>
                            </select>


                            <select class="niceSelect" name="price">
                                <option value="">Khoảng giá</option>
                                <option>0 - 100</option>
                                <option>100 - 500</option>
                                <option>500 - 1000</option>
                                <option>1000 - 15000000</option>
                            </select>

                            <select class="niceSelect" name="order">
                                <option value="create_At - DESC">Mới nhất</option>
                                <option value="sold - DESC">Bán chạy nhất</option>
                                <option value="price - ASC">Giá: Thấp đến cao</option>
                                <option value="price - DESC">Giá: Cao đến thấp</option>
                            </select>

                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="filter-select">
                            <span class="me-3">
                                <button onclick="filterProdCate()" type="button" class="btn btn-custom">Áp dụng</button>
                            </span>
                            <span>
                                <a href="Product" class="btn btn-custom btn-bg-danger">Xoá tất cả</a>
                            </span>
                        </div>
                    </div>
            </form>

        </div>
    </div>

    <div class="main-product">
        <div id="main-product" class="row">


        </div>
    </div>



    </div>
</section>