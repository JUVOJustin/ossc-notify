<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/pure/pure-min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/pure/grids-responsive-min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/style.css">  
        <title>HSD WS18 Klausurbenachrichtigung</title>
</head>
<body>
    <div class="pure-g">

        <div class="pure-u-1 pure-u-lg-1-2 info">
            <h1>Endlich informiert werden!</h1>
            <p>Trage deine E-Mail Adresse in den Verteiler ein.<br> Du erhälst automatisch eine E-Mail sobald sich im OSSC etwas geändert hat.<br> Das Skript ist nur für den <b>Studiengang BMI SS18</b> nützlich</p>

            <?php if ($valid) {
                echo '<p class="success">Du hast eine Bestätigungsmail erhalten</p>';
            } elseif ($verified == TRUE) {
                echo '<p class="success">Du bist nun verifiziert und erhälst künftig Benachrichtigungen</p>';
            } else{
                echo validation_errors();
            } ?>
        </div>

        <div class="pure-u-1 pure-u-lg-1-2 subscribe-form">
            <?php echo form_open('subscriptionhandler', array('class' => 'pure-form pure-form-aligned') ); ?>
            <fieldset>
                <div class="pure-control-group">
                    <label for="emailaddress">E-Mail</label><input type="email" id="emailaddress" name="emailaddress" placeholder="mail@tld.com" required>
                </div>

                <div class="pure-control-group" hidden>
                    <label for="checkbox-cp">Datenschutz</label><input type="checkbox" id="checkbox-cp" name="privacy-cp" value="true">
                </div>

                <div class="pure-controls">
                    <button type="submit" class="pure-button pure-button-primary">In Verteiler eintragen</button>
                </div>

            </fieldset>
            <?php echo form_close(); ?>
        </div>

    </div>
</body>
</html>