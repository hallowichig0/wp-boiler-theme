<?php
/**
 * The sidebar containing the main widget area
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Bootstrap4
 */

if (is_home()) {
?>
    <!-- Sidebar Widgets Column -->
    <aside id="secondary" class="widget-area col-sm-12 col-md-4" role="complementary">
    <?php dynamic_sidebar( 'sidebar-blog' ); ?>
    <?php
    if(class_exists( 'Kirki' )){

        $widgets = get_theme_mod('sidebar_blog_widget_repeater');

        foreach($widgets as $widget):
            $select_widget = $widget['sidebar_blog_select_widget'];
            if($select_widget == 'search'){
                get_widget_search();
            }elseif($select_widget == 'category'){
                get_widget_category();
            }elseif($select_widget == 'archive'){
                get_widget_archive();
            }
        endforeach;
        
    }
    ?>

    </aside><!-- #second -->

<?php
}