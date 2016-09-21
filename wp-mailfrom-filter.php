<?php

/**
 * wp-mailfrom-filter.php
 * ----------------------------------------------------------------------------------
 * Prevent passing an incorrect email address to wp_mail(). 
 * Example of an incorrect address:
 * wordpress@*.multisitedomein.tld
 * this sometimes occurs on NGINX servers with a multisite WP install.
 * ----------------------------------------------------------------------------------
 *
 * @author  Paul van Buuren
 * @license GPL-2.0+
 * @version 1.0.0 
 * @desc.   Sept 2016 - eerste versie
 * @link    http://wbvb.nl/plugins/wp-mailfrom-filter/
 */



function wbvb_filter_multisite_sendfrom_email( $email ){

  $findme = '*.';
  $pos    = strpos( $email, $findme);
  
  if ($pos === false) {
    // *. not in the $email string
    return $email;
  }
  else {
  
    $sitename = strtolower( $_SERVER['HTTP_HOST'] ); // NOT $_SERVER['SERVER_NAME'], see /wp-includes/pluggable.php (326)
  
    if ( substr( $sitename, 0, 4 ) == 'www.' ) {
      $sitename = substr( $sitename, 4 );
    }
    if ( substr( $sitename, 0, 2 ) == '*.' ) {
      $sitename = substr( $sitename, 2 );
    }
    
    $myfront  = "wordpress@";
    $myback   = $sitename;
    $myfrom   = $myfront . $myback;
  
    return $myfrom;
  
  }
  

}

add_filter("wp_mail_from", "wbvb_filter_multisite_sendfrom_email");
