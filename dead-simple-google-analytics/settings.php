<div class="wrap">
    <h2>Dead Simple Google Analytics</h2>
    <div class="description">
        Google Analytics settings for your website.
    </div>
    <form method="post" action="options.php">
        <?php @settings_fields('dsga-group'); ?>
        <?php @do_settings_fields('dsga-group'); ?>

        <table class="form-table">
            <tbody>
                <tr>
                    <th scope="row">
                        <label for="dsga_tracking_id">Tracking ID (e.g. UA-XXXX-X)</label>
                    </th>
                    <td>
                        <input type="text" id="dsga_tracking_id" name="dsga_tracking_id" value="<?php echo get_option('dsga_tracking_id'); ?>" />
                    </td>
                </tr>
                <tr>
                    <th scope="row">Tracking type</th>
                    <td>
                        <label for="tt_classic">Classic</label>
                        <?php $tt = get_option('dsga_tracking_type'); ?>
                        <input type="radio" id="tt_classic" name="dsga_tracking_type" value="classic"<?php if ($tt == 'classic') echo ' checked="checked"'; ?> />
                        <label for="tt_universal">Universal</label>
                        <input type="radio" id="tt_universal" name="dsga_tracking_type" value="universal"<?php if ($tt == 'universal') echo ' checked="checked"'; ?> />
                    </td>
                </tr>
                <tr>
                    <th scope="row">
                        <label for="dsga_tracking_domain">Tracking domain (mandatory for universal tracking type. E.g. example.com)</label>
                    </th>
                    <td>
                        <input type="text" id="dsga_tracking_domain" name="dsga_tracking_domain" value="<?php echo get_option('dsga_tracking_domain'); ?>" />
                    </td>
                </tr>
            </tbody>
        </table>
        <?php @submit_button(); ?>
    </form>
</div>
