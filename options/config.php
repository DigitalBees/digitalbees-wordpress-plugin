<?php
if (array_key_exists("settings-updated", $_GET)) {
    echo '<div class="updated"><p>Your configuration is saved correctly!</p></div>';
}
?>
<div class="wrap">
<?php screen_icon("options-general")?>
<h2 id="dbees-config">DigitalBees Video Options</h2>
    <form method="post" action="options.php#dbees-config">
    <?php wp_nonce_field('update-options'); ?>
        <table class="form-table">
            <tbody>
                <tr valign="top">
                <th width="92" scope="row">Your ApiKey</th>
                    <td width="406">
                        <input name="<? echo DIGITALBEES_API_KEY ?>" type="text" value="<?php echo get_option(DIGITALBEES_API_KEY); ?>" />
                    </td>
                </tr>
                <tr valign="top">
                <th width="92" scope="row">Your ApiSecret</th>
                    <td width="406">
                        <input name="<? echo DIGITALBEES_API_SECRET ?>" type="text" value="<?php echo get_option(DIGITALBEES_API_SECRET); ?>" />
                    </td>
                </tr>
                <th width="92" scope="row">Playler width *</th>
                    <td width="406">
                        <input name="<? echo DIGITALBEES_PLAYER_WIDTH ?>" type="text" value="<?php echo get_option(DIGITALBEES_PLAYER_WIDTH); ?>" />
                    </td>
                </tr>
                <th width="92" scope="row">Playler height</th>
                    <td width="406">
                        <input name="<? echo DIGITALBEES_PLAYER_HEIGHT ?>" type="text" value="<?php echo get_option(DIGITALBEES_PLAYER_HEIGHT); ?>" />
                    </td>
                </tr>
                <tr valign="top">
                    <th width="92" scope="row"></th>
                    <td width="406" align='right'>
                       <input type="submit" class="button-primary" value="Save Changes"/>
                       <input type="hidden" name="action" value="update" />

                       <input type="hidden" name="page_options" value="<?php echo implode(",", array(DIGITALBEES_API_KEY, DIGITALBEES_API_SECRET, DIGITALBEES_PLAYER_WIDTH, DIGITALBEES_PLAYER_HEIGHT))?>"/>
                    </td>
                </tr>
          </tbody>
        </table>
    </form>
</div>