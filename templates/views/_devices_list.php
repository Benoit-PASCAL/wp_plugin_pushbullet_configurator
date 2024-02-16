<div class="inside">
    <h3 class="hndle" style=" display: inline-block; margin-right: 5px;">
        <label for="title">
            <?php  _e('Devices list', 'pushbullet-configurator'); ?>
        </label>
    </h3>
    <a href="<?= $_SERVER['REQUEST_URI'] . '&action=test-alert&type=push' ?>" class="page-title-action">
        <?php _e('Try sending a push', 'pushbullet-configurator');?>
    </a>
    <a href="<?= $_SERVER['REQUEST_URI'] . '&action=test-alert&type=sms' ?>" class="page-title-action">
        <?php _e('Try sending an SMS', 'pushbullet-configurator'); ?>
        <small>(<?php _e('be careful, it\'s not unlimited', 'pushbullet-configurator') ?></small>
    </a>
    <?php $table->prepare_items(); ?>
    <form id="tables-filter" method="post">
        <?php $table->display(); ?>
    </form>
</div>