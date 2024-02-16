<div class="inside">
    <h3 class="hndle" style=" display: inline-block; margin-right: 5px;">
        <label for="title">
            <?php
            _e('New push', 'pushbullet-configurator');
            ?>
        </label>
    </h3>
    <a href="http://my-local-wordpress.lndo.site/wp-admin/admin.php?page=pushbullet-configurator&tab=pushes" class="page-title-action"><?php _e('Cancel') ?></a>
    <form action="" method="post">
        <input type="hidden" name="action" id="action" value="create">
        <input type="hidden" name="page" id="page" value="pushbullet-configurator">
        <input type="hidden" name="tab" id="tab" value="pushes">
        <table class="form-table" role="presentation">
            <tbody>
                <tr>
                    <th scope="row">
                        <label for="email">
                            <?php
                            _e('Email', 'pushbullet-configurator');
                            ?>
                        </label>
                    </th>
                    <td>
                        <input name="email" type="text" id="email" value="" class="regular-text">
                    </td>
                </tr>
                <tr>
                    <th scope="row">
                        <label for="title">
                            <?php
                            _e('Push title', 'pushbullet-configurator');
                            ?>
                        </label>
                    </th>
                    <td>
                        <input name="title" type="text" id="title" value="" class="regular-text">
                    </td>
                </tr>
                <tr>
                    <th scope="row">
                        <label for="body">
                            <?php
                            _e('Push body', 'pushbullet-configurator');
                            ?>
                        </label>
                    </th>
                    <td>
                        <textarea name="body" id="body" cols="30" rows="10"></textarea>
                    </td>
                </tr>
            </tbody>
        </table>
        <button class="button button-primary" type="submit" id="submit" value="Seend"><?php _e('Send', 'pushbullet-configurator') ?></button>
    </form>
</div>