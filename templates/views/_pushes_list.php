<?php //var_dump($_POST);  ?>
<div class="inside">
    <h3 class="hndle" style=" display: inline-block; margin-right: 5px;">
        <label for="title">
            <?php
            _e('Pushes list', 'pushbullet-configurator');
            ?>
        </label>
    </h3>
    <a href="<?= $_SERVER['REQUEST_URI'] ?>&action=create" class="page-title-action">
        <?php _e('Envoyer un push', 'pushbullet-configurator'); ?>
    </a>
    <?php $table->prepare_items(); ?>
    <form id="tables-filter" method="post">
        <?php $table->display(); ?>
    </form>
</div>