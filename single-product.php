<?php
if (!defined('ABSPATH')) {
    exit;
}
get_header();
global $product;
if (!is_a($product, 'WC_Product')) {
    $product = wc_get_product(get_the_ID());
}
?>

    <section class="flat-row main-shop shop-detail">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <div class="wrap-flexslider">
                        <div class="inner">
                            <div class="flexslider style-1 has-relative">
                                <ul class="slides">
                                    <?php
                                    $gallery_image_ids = $product->get_gallery_image_ids();

                                    if (!empty($gallery_image_ids)) {
                                        foreach ($gallery_image_ids as $attachment_id) {
                                            $image = wp_get_attachment_image_url($attachment_id, 'full');
                                            $image_thumbnail = wp_get_attachment_image_url($attachment_id, 'thumbnail');
                                            ?>
                                            <li data-thumb="<?php echo esc_url($image_thumbnail); ?>">
                                                <img src="<?php echo esc_url($image); ?>"
                                                     alt="<?php echo esc_attr($product->get_title()); ?>"/>
                                                <div class="flat-icon style-1">
                                                    <a href="<?php echo esc_url($image); ?>" class="zoom-popup"><span
                                                                class="fa fa-search-plus"></span></a>
                                                </div>
                                            </li>
                                            <?php
                                        }
                                    } else {
                                        $thumbnail_url = wp_get_attachment_image_url($product->get_image_id(), 'full');
                                        ?>
                                        <li>
                                            <img src="<?php echo esc_url($thumbnail_url); ?>"
                                                 alt="<?php echo esc_attr($product->get_title()); ?>">
                                        </li>
                                        <?php
                                    }
                                    ?>
                                </ul>
                            </div><!-- /.flexslider -->
                        </div>
                    </div>
                </div><!-- /.col-md-6 -->

                <div class="col-md-6">
                    <div class="product-detail">
                        <div class="inner">
                            <div class="content-detail">
                                <h2 class="product-title"><?php the_title() ?></h2>
                                <div class="flat-star style-1">
                                    <?php
                                    $average_rating = $product->get_average_rating();
                                    $review_count = $product->get_review_count();

                                    if ($average_rating) : ?>
                                        <?php for ($i = 1; $i <= 5; $i++) : ?>
                                            <?php if ($i <= $average_rating) : ?>
                                                <i class="fa fa-star"></i>
                                            <?php elseif ($i - $average_rating < 1) : ?>
                                                <i class="fa fa-star-half-o"></i>
                                            <?php else : ?>
                                                <i class="fa fa-star-o"></i>
                                            <?php endif; ?>
                                        <?php endfor; ?>
                                        <?php if ($review_count) : ?>
                                            <span>(<?php echo esc_html($review_count); ?>)</span>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                </div>
                                <?php
                                $short_description = apply_filters('woocommerce_short_description', $product->get_short_description());
                                if ($short_description) : ?>
                                    <p class="product-short-description">
                                        <?php echo $short_description; ?>
                                    </p>
                                <?php endif; ?>
                                <div class="price">
                                    <?php echo $product->get_price_html(); ?>
                                </div>
                                <?php
                                if ($product->is_type('simple')) {
                                    woocommerce_simple_add_to_cart();
                                }
                                if ($product->is_type('variable')) {
                                    woocommerce_variable_add_to_cart();
                                }
                                if ($product->is_type('grouped')) {
                                    woocommerce_grouped_add_to_cart();
                                }
                                if ($product->is_type('external')) {
                                    woocommerce_external_add_to_cart();
                                }
                                ?>
                                <div class="product-categories">
                                    <?php
                                    $categories = wc_get_product_category_list($product->get_id());
                                    if ($categories) : ?>
                                        <span>Categories: </span>
                                        <?php echo $categories; ?>
                                    <?php endif; ?>
                                </div>
                                <div class="product-tags">
                                    <?php
                                    $tags = wc_get_product_tag_list($product->get_id());
                                    if ($tags) : ?>
                                        <span>Tags: </span>
                                        <?php echo $tags; ?>
                                    <?php endif; ?>
                                </div>

                            </div>
                        </div>
                    </div><!-- /.product-detail -->
                </div>
            </div><!-- /.row -->
        </div><!-- /.container -->
    </section><!-- /.flat-row -->
<?php
$product_tabs = apply_filters('woocommerce_product_tabs', array());
$total_tabs = count($product_tabs);
if (!empty($product_tabs)) : ?>
    <section class="flat-row shop-detail-content">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="flat-tabs style-1 has-border">
                        <div class="inner">
                            <ul class="menu-tab">
                                <?php foreach ($product_tabs as $key => $product_tab) : ?>

                                    <li>
                                        <?php echo wp_kses_post(apply_filters('woocommerce_product_' . $key . '_tab_title', $product_tab['title'], $key)); ?>
                                    </li>
                                <?php endforeach; ?>

                            </ul>
                            <div class="content-tab">
                                <?php
                                foreach ($product_tabs as $key => $product_tab) : ?>
                                    <div class="content-inner">
                                        <div class="flat-grid-box border-width border-width-1 has-padding clearfix">
                                            <?php
                                            if (isset($product_tab['callback']) && is_callable($product_tab['callback'])) {
                                                call_user_func($product_tab['callback'], null, null, $product_tab);
                                            }
                                            ?>
                                        </div><!-- /.flat-grid-box -->
                                    </div><!-- /.content-inner -->
                                <?php endforeach; ?>

                            </div>
                            <?php do_action('woocommerce_product_after_tabs'); ?>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section><!-- /.shop-detail-content -->
<?php endif; ?>
<?php
$related_ids = wc_get_related_products($product->get_id(), 4);
?>
<?php if ($related_ids) : ?>
    <section class="flat-row shop-related">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="title-section margin-bottom-55">
                        <h2 class="title"><?php _e('Related Products', 'storebase'); ?></h2>
                    </div>

                    <div class="product-content product-fourcolumn clearfix">
                        <ul class="product style2">
                            <?php
                            foreach ($related_ids as $related_id) {
                                $related_product = wc_get_product($related_id);
                                ?>
                                <li class="product-item">
                                    <div class="product-thumb clearfix p-2">
                                        <a href="<?php echo esc_url(get_permalink($related_product->get_id())); ?>">
                                            <img src="<?php echo esc_url(wp_get_attachment_url($related_product->get_image_id())); ?>"
                                                 alt="<?php echo esc_attr($related_product->get_name()); ?>">
                                        </a>
                                    </div>
                                    <div class="product-info clearfix my-2">
                                        <span class="product-title"><?php echo esc_html($related_product->get_name()); ?></span>
                                        <div class="price">
                                            <?php echo $related_product->get_price_html(); ?>
                                        </div>
                                    </div>
                                    <div class="add-to-cart text-center">
                                        <a href="<?php echo esc_url($related_product->add_to_cart_url()); ?>"><?php echo esc_html($related_product->add_to_cart_text()); ?></a>
                                    </div>
                                </li>
                                <?php
                            }
                            ?>
                        </ul><!-- /.product -->
                    </div><!-- /.product-content -->
                </div>
            </div><!-- /.row -->
        </div>
    </section>
<?php
endif;
get_footer();

