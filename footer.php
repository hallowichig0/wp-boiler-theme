<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Bootstrap4
 */

?>
</main><!-- #primary -->
<footer class="py-4" style="background-color:<?php
if(class_exists( 'Kirki' )){
    $footer_bg = get_theme_mod('footer_background_setting');
    if(isset($footer_bg) && !empty($footer_bg)):
        echo $footer_bg;
    else:
        echo '#343a40';
    endif;
}else{
    echo '#343a40';
}
?>">
    <div class="container">
        <div class="row">
            <p class="m-0" style="color:<?php
            if(class_exists( 'Kirki' )){
                $footer_copyrightColor = get_theme_mod('footer_copyrightColor_setting');
                if(isset($footer_copyrightColor) && !empty($footer_copyrightColor)):
                    echo $footer_copyrightColor;
                else:
                    echo '#ffffff';
                endif;
            }else{
                echo '#ffffff';
            }
            ?>">
            <?php 
            if(class_exists( 'Kirki' )){
                $footer_copyright = get_theme_mod('footer_copyrightText_setting');
                if(isset($footer_copyright) && !empty($footer_copyright)):
                    echo 'Copyright &copy; ' . $footer_copyright;
                else:
                    echo 'Copyright &copy; Jayson Garcia' .' '. '2020-'.date("Y");
                endif;
            }else{
                echo 'Copyright &copy; Jayson Garcia' .' '. '2020-'.date("Y");
            }
            ?></p>
        </div>
    </div>
</footer>
<?php wp_footer(); ?>
</body>
</html>