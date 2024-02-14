<form action="" method="post">
    <table class="form-table" role="presentation">
        <tbody>
        <?php
            foreach ($form->items as $row) {
        ?>
            <tr>
                <th scope="row">
                    <label for="<?php $form->get_input_name($row) ?>">
                        <?php
                        _e( $form->get_label($row), 'pushbullet-configurator');
                        ;
                        ?>
                    </label>
                </th>
                <td>
                    <?php if($form->get_input_main_type($row) === 'select') { ?>
                        <select name="<?= esc_attr($form->get_input_name($row)); ?>" id="<?= esc_attr($form->get_input_name($row)); ?>">
                            <?php
                                $form->get_select_options($row);
                            ?>
                        </select>
                    <?php } else { ?>
                        <input name="<?= esc_attr($form->get_input_name($row)); ?>" type="<?= $form->get_input_type($row) ?>" id="<?= esc_attr($form->get_input_name($row)); ?>" value="<?= esc_attr($row->value); ?>" class="regular-text">
                    <?php } ?>

                    <?php if($form->has_description($row)) { ?>
                    <p class="description">
                        <?php
                        _e($form->get_description($row), 'pushbullet-configurator');
                        ?>
                    </p>
                    <?php } ?>
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