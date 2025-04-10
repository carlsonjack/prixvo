<?php
/**
 * Theme functions and definitions
 *
 * @package WordPress
 * @subpackage Defaulut Theme
 * @author Defaulut Theme, Inc.
 *
 */
?>

<form action="<?php bloginfo('siteurl'); ?>" id="searchform" method="get">

    <div>

        <label for="s" class="screen-reader-text"><?php _e('Search for:', 'ultimate-auction-pro-software'); ?></label>

        <input type="text" id="s" name="s" value="" />

        <input type="submit" value="Search" id="searchsubmit" />

    </div>

</form>