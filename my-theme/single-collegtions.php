<?php
// Lägg till metabox till redigeringsidan för "Collegtions"
function sc_add_metabox()
{
    add_meta_box(
        'pc_collegtions_metabox',
        'Collegtions-information',
        'pc_collegtions_metabox_callback',
        'Collegtions',
        'advanced',
        'high'
    );
}
add_action('add_meta_boxes', 'sc_add_metabox');

// Funktion för att rendera metaboxen
function sc_collegtions_metabox_callback($post)
{
    // Hämta befintliga metadata
    $collegtions_name = get_post_meta($post->ID, 'collegtions_name', true);
    $collegtions_description = get_post_meta($post->ID, 'collegtions_description', true);

    // Skapa formulärfält
    ?>
    <table>
        <tr>
            <th><label for="collegtions_name">Namn:</label></th>
            <td><input type="text" id="collegtions_name" name="collegtions_name" value="<?php echo $collegtions_name; ?>">
            </td>
        </tr>
        <tr>
            <th><label for="collegtions_description">Beskrivning:</label></th>
            <td><textarea id="collegtions_description"
                    name="collegtions_description"><?php echo $collegtions_description; ?></textarea></td>
        </tr>
    </table>
    <?php
}

// Funktion för att spara metadata
function sc_save_metabox_data($post_id)
{
    // Kontrollera om det är en "Collegtions"-inläggstyp
    if ('Collegtions' !== get_post_type($post_id)) {
        return;
    }

    // Hämta formulärfält
    $collegtions_name = $_POST['collegtions_name'];
    $collegtions_description = $_POST['collegtions_description'];

    // Spara metadata
    update_post_meta($post_id, 'collegtions_name', $collegtions_name);
    update_post_meta($post_id, 'collegtions_description', $collegtions_description);
}
add_action('save_post', 'sc_save_metabox_data');