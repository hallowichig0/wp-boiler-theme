<?php
/**
 * The template for displaying widget archive page
 *
 * @package Bootstrap4
 */

?>

<!-- Archives Widget -->
<div class="card my-4">
<h5 class="card-header">Archives</h5>
    <div class="card-body">
        <div class="row">
			<?php echo get_archive_by_year_and_month(); ?>
        </div>
    </div>
</div>