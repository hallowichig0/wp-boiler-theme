<form id="searchform" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>">
    <div class="input-group">
        <input type="text" class="search-field form-control" name="s" placeholder="Search for..." value="<?php the_search_query(); ?>">
        <span class="input-group-btn">
            <input class="btn btn-secondary" type="submit" value="Search">
        </span>
    </div>
</form>