<?php //var_dump($_POST);  ?>
<div class="inside">
    <h3 class="hndle" style=" display: inline-block; margin-right: 5px;">
        <label for="title">
            <?php
            _e('Pushes list', 'pushbullet-configurator');
            ?>
        </label>
    </h3>
    <form action="" method="post" style="display: inline-block">
        <button type="submit" name="action" value="create" class="page-title-action">
            <?php _e('Send a push', 'pushbullet-configurator'); ?>
        </button>
    </form>
    <?php $table->prepare_items(); ?>
    <form id="tables-filter" method="post">
        <?php $table->display(); ?>
    </form>
</div>