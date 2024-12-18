<?php
get_header();
$paged = get_query_var('paged') ? get_query_var('paged') : 1;
$orderby = isset($_GET['orderby']) ? sanitize_text_field($_GET['orderby']) : 'menu_order';

$args = array(
    'post_type' => 'product',
    'posts_per_page' => 12,
    "paged" => $paged,
    "orderby" => $orderby,
);
switch ($orderby) {
    case 'popularity':
        $args['orderby'] = 'meta_value_num';
        $args['meta_key'] = '_wc_average_rating';
        break;
    case 'rating':
        $args['orderby'] = 'meta_value_num';
        $args['meta_key'] = '_wc_average_rating';
        break;
    case 'date':
        $args['orderby'] = 'date';
        break;
    case 'price':
        $args['orderby'] = 'meta_value_num';
        $args['meta_key'] = '_price';
        $args['order'] = 'ASC';
        break;
    case 'price-desc':
        $args['orderby'] = 'meta_value_num';
        $args['meta_key'] = '_price';
        $args['order'] = 'DESC';
        break;
    default:
        $args['orderby'] = 'menu_order';
        break;
}
$product_loop = new WP_Query($args);
wp_reset_postdata();
?>
<?php
 do_action('woocommerce_before_main_content');
?>

<section class="flat-row main-shop shop-4col">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="filter-shop bottom_68 clearfix">
                            <?php woocommerce_result_count(); ?>
                            <ul class="flat-filter-search">
                                <li>
                                    <a href="#" class="show-filter"><?php esc_html_e('Filters','storebase');?></a>
                                </li>
                            </ul>
                        </div><!-- /.filte-shop -->
                        <div class="box-filter slidebar-shop clearfix">
                            <form class="woocommerce-ordering" method="get">
                                <select name="orderby" class="orderby" aria-label="Shop order">
                                    <option value="menu_order" <?php selected( 'menu_order', get_query_var( 'orderby' ) ); ?>><?php esc_html_e('Default sorting','storebase');?></option>
                                    <option value="popularity" <?php selected( 'popularity', get_query_var( 'orderby' ) ); ?>><?php esc_html_e('Sort by popularity','storebase');?></option>
                                    <option value="rating" <?php selected( 'rating', get_query_var( 'orderby' ) ); ?>><?php esc_html_e('Sort by average rating','storebase');?></option>
                                    <option value="date" <?php selected( 'date', get_query_var( 'orderby' ) ); ?>><?php esc_html_e('Sort by latest','storebase');?></option>
                                    <option value="price" <?php selected( 'price', get_query_var( 'orderby' ) ); ?>><?php esc_html_e('Sort by price: low to high','storebase');?></option>
                                    <option value="price-desc" <?php selected( 'price-desc', get_query_var( 'orderby' ) ); ?>><?php esc_html_e('Sort by price: high to low','storebase');?></option>
                                </select>
                                <input type="hidden" name="paged" value="1">
                            </form>

                        </div><!-- /.box-filter -->
                        <div class="product-content product-fourcolumn clearfix">
                            <ul class="product style2">

                            <?php
                                if ($product_loop->have_posts()) {
                                    while ($product_loop->have_posts()) : $product_loop->the_post();
                                        global $product; ?>
                                <li class="product-item">
                                    <div class="product-thumb clearfix">
                                        <?php
                                        $product_id = $product->get_id();
                                        $image_id = get_post_thumbnail_id($product_id);
                                        $image_url = wp_get_attachment_image_url($image_id, 'full');
                                        ?>
                                        <a href="<?php echo esc_url(get_permalink($product_id)); ?>">
                                            <?php
                                            if ($image_url) {
                                                echo '<img class=" p-3" src="' . esc_url($image_url) . '" alt="' . esc_attr(get_the_title($product_id)) . '">';
                                            } else {
                                                $fallback_image_url = get_theme_file_uri('/assets/images/shop/sh-3/1.jpg');
                                                echo '<img src="' . esc_url($fallback_image_url) . '" alt="No image available">';
                                            }
                                            ?>
                                        </a>
                                    </div>
                                    <div class="product-info clearfix mt-3">
                                        <span class="product-title">
                                            <a href="<?php echo esc_url(get_permalink($product_id));?>"><?php the_title() ?></a>
                                        </span>
                                        <div class="price">
                                            <ins>
                                                <span class="amount"><?php echo $product->get_price_html()?></span>
                                            </ins>
                                        </div>
                                    </div>
                                    <div class="add-to-cart text-center">
                                        <a href="<?php echo esc_url($product->add_to_cart_url()); ?>"><?php echo esc_html($product->add_to_cart_text()); ?></a>
                                    </div>
                                </li>
                                    <?php endwhile;
                                   } else {
                                     esc_html_e('No products found','storebase');
                                    }
                                 ?>
                            </ul><!-- /.product -->

                        </div><!-- /.product-content -->

                        <div class="product-pagination text-center margin-top-11 clearfix">
                            <ul class="flat-pagination">
                             <?php
                                global $wp_query;
                                $big = 999999999;

                             $pagination_links = paginate_links(array(
                                 'base' => str_replace($big, '%#%', esc_url(get_pagenum_link($big))),
                                 'format' => '?paged=%#%',
                                 'current' => max(1, get_query_var('paged')),
                                 'total' => $wp_query->max_num_pages,
                                 'prev_next' => true,
                                 'prev_text' => __('&laquo;','storebase'),
                                 'next_text' => __('&raquo;' , 'storebase'),
                                 'type' => 'array',
                             ));
                             if ($pagination_links) {
                                 foreach ($pagination_links as $link) {
                                     if (strpos($link, 'current') !== false) {
                                         echo '<li class="active">'.strip_tags($link).'</li>';
                                     } else {
                                         preg_match('/href="([^"]+)"/', $link, $matches);
                                         $url = $matches[1] ?? '#';

                                         echo '<li><a href="' . esc_url($url) . '">' . strip_tags($link) . '</a></li>';                                     }
                                 }
                             }
                                ?>

                            </ul>
                        </div>
                    </div><!-- /.col-md-12 -->
                </div><!-- /.row -->
            </div><!-- /.container -->
        </section><!-- /.flat-row -->
<?php
do_action('woocommerce_after_main_content');
?>
<?php
get_footer();