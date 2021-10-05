
    <?php
        /*
        get_results function
        refers to sql query and saves the result
        inverted brackets ?><?php are to escape php,


        */
        global $wpdb;
        $result = $wpdb->get_results( "SELECT username FROM wp_users");
        foreach ( $result as $print )   { ?>
          <tr>
                  <td>  <?php echo $print->username; ?> </td>
          </tr>
            <?php }
          //this may not be referred to by the main plugin code in TestCode
      ?>
