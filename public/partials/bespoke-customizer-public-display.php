<?php

/**
 * Provide a public-facing view for the plugin
 *
 * This file is used to markup the public-facing aspects of the plugin.
 *
 * @link       #
 * @since      1.0.0
 *
 * @package    Bespoke_Customizer
 * @subpackage Bespoke_Customizer/public/partials
 */

?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link href="<?php echo plugin_dir_url( __FILE__ ) ?>../open-iconic/css/open-iconic-bootstrap.css" rel="stylesheet">
    <div id="customizer_container"></div>

<!-- Note: when deploying, replace "development.js" with "production.min.js". -->
 <script src="https://unpkg.com/react@16/umd/react.development.js" crossorigin></script>
 <script src="https://unpkg.com/react-dom@16/umd/react-dom.development.js" crossorigin></script>
 <script src="https://unpkg.com/babel-standalone@6/babel.min.js"></script>

 <!-- Load our React component. -->
 <script src="<?php echo plugin_dir_url( __FILE__ ) ?>../js/customizer.js"></script>