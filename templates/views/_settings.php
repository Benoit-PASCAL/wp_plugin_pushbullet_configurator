<form action="" method="post">
    <table class="form-table" role="presentation">
        <tbody>
        <?php

        foreach ($table as $row) {

        ?>
            <tr>
                <th scope="row">
                    <label for="token">
                        <?php
                        _e( ucfirst($row->name), 'pushbullet-configurator');
                        ?>
                    </label>
                </th>
                <td>
                    <input name="<?= esc_attr($row->name); ?>" type="text" id="<?= esc_attr($row->name); ?>" value="<?= esc_attr($row->value); ?>" class="regular-text">

                    <?php if( $row->name == 'token' ) { ?>

                    <p class="description">
                        <?php
                        _e('You can create an Access Token on your <a href="https://www.pushbullet.com/#settings/account" target="_blank">Pushbullet account page</a>.', 'pushbullet-configurator');
                        ?>
                    </p>

                    <?php
                    }
                    ?>
                </td>
            </tr>
        <?php

        }

        ?>
        </tbody>
    </table>
    <p class="submit">
        <input type="submit" name="submit" id="submit" class="button button-primary" value="<?php echo __('Save Changes') ?>">
    </p>
</form>