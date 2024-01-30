
<div class="inside">
    <h3 class="hndle">
        <label for="title">
            <?php
            _e('Devices list', 'pushbullet-configurator');
            ?>
        </label>
    </h3>
    <?php
    // Fetch, prepare, sort, and filter our data...
    $table->prepare_items();
    // echo "put table of locked entries here";
    ?>
    <form id="tables-filter" method="post">
        <!-- For plugins, we also need to ensure that the form posts back to our current page -->
        <input type="hidden" name="page" value="<?php echo esc_attr($page); ?>"/>
        <?php
        if (!empty($tab)) {
            echo '<input type="hidden" name="tab" value="' . esc_attr($tab) . '" />';
        }
        ?>
        <!-- Now we can render the completed list table -->
        <?php $table->display(); ?>
    </form>
</div>