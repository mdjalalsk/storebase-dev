<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package StoreBase
 */

get_header();
?>
    <!-- Hero -->
<div class="container">
    <div class="d-sm-flex align-items-center justify-content-between w-100 " style="height: 70vh;">
        <div class="col-md-4 mx-auto mb-4 mb-sm-0 headline">
            <span class="text-secondary text-uppercase">
                <?php echo esc_html( get_theme_mod( 'storebase_hero_subheadline', 'Subheadline' ) ); ?>
            </span>
            <h2 class="display-4 my-4 font-weight-bold" style="color: #9B5DE5;"><?php echo esc_html( get_theme_mod( 'storebase_hero_headline', 'Enter Your Headline Here' ) ); ?>
            </h2>
            <a href="<?php echo esc_url( get_theme_mod( 'storebase_hero_button_link', '#' ) ); ?>" class="btn px-5 py-3 text-white mt-3 mt-sm-0"
               style="border-radius: 30px; background-color: #9B5DE5;">
                <?php echo esc_html( get_theme_mod( 'storebase_hero_button_text', 'Get Started' ) ); ?>
            </a>
        </div>
        <!-- in mobile remove the clippath -->
        <div class="col-md-8 h-100 clipped"
             style="min-height: 350px;
                 background-image: url(<?php echo esc_url( get_theme_mod( 'storebase_hero_bg_image' ) ?: 'https://images.unsplash.com/photo-1551434678-e076c223a692?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=2850&q=80' ); ?>);
                 background-position: center;
                 background-size: cover;">

        </div>
    </div>
</div>
    <!-- Hero -->
    <!-- PRODUCT -->
    <section class="flat-row row-product-project shop-collection">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="title-section margin-bottom-41">
                        <h2 class="title">Shop Collection</h2>
                    </div>

                    <!-- Category Filters -->
                    <?php
                    $categories = get_terms([
                        'taxonomy' => 'product_cat',
                        'hide_empty' => true,
                    ]);
                    ?>
                    <ul class="flat-filter style-1 text-center max-width-682 clearfix">
                        <li class="active"><a href="#" data-filter="*">All Products</a></li>
                        <?php foreach ($categories as $category) : ?>
                            <li>
                                <a href="#"
                                   data-filter=".<?php echo esc_attr($category->slug); ?>"><?php echo esc_html($category->name); ?></a>
                            </li>
                        <?php endforeach; ?>
                    </ul>

                    <div class="divider h40"></div>

                    <!-- Product List -->
                    <div class="product-content product-fourcolumn clearfix">
                        <ul class="product style2 isotope-product clearfix">
                            <?php
                            $args = [
                                'post_type' => 'product',
                                'posts_per_page' => -1,
                            ];
                            $query = new WP_Query($args);
                            if ($query->have_posts()) :
                                while ($query->have_posts()) :
                                    $query->the_post();
                                    global $product;
                                    $product_categories = get_the_terms($product->get_id(), 'product_cat');
                                    $category_classes = '';
                                    if ($product_categories) {
                                        foreach ($product_categories as $cat) {
                                            $category_classes .= $cat->slug . ' ';
                                        }
                                    }
                                    ?>
                                    <li class="product-item <?php echo esc_attr(trim($category_classes)); ?>">
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
                                            <span class="new">New</span>
                                        </div>
                                        <div class="product-info clearfix mt-2">
                                <span class="product-title">
                                    <?php esc_html(the_title()); ?>
                                </span>
                                            <div class="price">
                                                <ins>
                                        <span class="amount">
                                            <?php echo $product->get_price_html(); ?></span>
                                                </ins>
                                            </div>
                                        </div>
                                        <div class="add-to-cart text-center">
                                            <a href="<?php echo esc_url($product->add_to_cart_url()); ?>">Add To
                                                Cart</a>
                                        </div>
                                        <a href="#" class="like"><i class="fa fa-heart-o"></i></a>
                                    </li>
                                <?php
                                endwhile;
                                wp_reset_postdata();
                            else :
                                ?>
                                <p>No products found</p>
                            <?php endif; ?>
                        </ul>
                    </div>

                </div>
            </div>
        </div>
    </section>
    <!-- END PRODUCT -->

<?php
get_footer();
