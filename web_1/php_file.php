  /*
         if ($icur_game_cnt == 0) {
           print_r($s_single_match);
           if ($s_single_match["instant_win_type"] != "") {
             if ($s_single_match["instant_win_type"] == "rf") {
                  ?>
                  <tr><td>
                   <?php echo "Royal Flush!!!"; ?>
                  </td>
                  </tr>
                  <?php
              } elseif ($s_single_match["instant_win_type"] == "sf") {
                  ?>
                  <tr><td>
                   <?php echo "Straight Flush!!!"; ?>
                  </td>
                  </tr>
                  <?php
              } elseif ($s_single_match["instant_win_type"] == "4k") {
                ?>
                  <tr><td>
                   <?php echo "4 of a Kind!!!"; ?>
                  </td>
                  </tr>
                  <?php
                
              } elseif ($s_single_match["instant_win_type"] == "fh") {
                ?>
                  <tr><td>
                   <?php echo "Full House!!!"; ?>
                  </td>
                  </tr>
                  <?php
              } elseif ($s_single_match["instant_win_type"] == "f") {
                ?>
                  <tr><td>
                   <?php echo "Flush!!!"; ?>
                  </td>
                  </tr>
                  <?php
                
              } elseif ($s_single_match["instant_win_type"] == "s") {
                ?>
                  <tr><td>
                   <?php echo "Straight!!!"; ?>
                  </td>
                  </tr>
                  <?php
              } elseif ($s_single_match["instant_win_type"] == "3k") {
                ?>
                  <tr><td>
                   <?php echo "3 of a Kind!!!"; ?>
                  </td>
                  </tr>
                  <?php
                
                
              } elseif ($s_single_match["instant_win_type"] == "2p") {
                ?>
                  <tr><td>
                   <?php echo "Two Pairs!!!"; ?>
                  </td>
                  </tr>
                  <?php
              } elseif ($s_single_match["instant_win_type"] == "pj") {
                ?>
                  <tr><td>
                   <?php echo "Pairs!!!"; ?>
                  </td>
                  </tr>
                  <?php
                
              } ?>
                <tr><td>
              
               <?php
               
                      print "<h1>" . $s_single_match["instant_win_type"] . "</h1>";
                      //print_r($s_single_match["instant_match"]);
                      if (is_array($s_single_match["instant_cards_win"])) {
                        
                           $inst_pos = 0;
                           foreach ($s_single_match["instant_cards_win"] as $s_inst_card) {
                              echo $s_inst_card;
                              if ($inst_pos != 0) {
                                 echo " - ";
                              }

                              $inst_pos++;
                           }          
                           if ($inst_pos < 5) {
                             $crd_played_pos = 0;
                             
                             foreach ($lotto_single_game["played_cards"] as $played_crd) {

                               $crd_match_already = 0;
                               foreach ($s_single_match["instant_cards_win"] as $s_inst_crd) {
                                   if (strtolower($s_inst_crd) == strtolower($played_crd)) {
                                        $crd_match_already = 1;                                      
                                     }

                               } 
                               
                               if ($crd_match_already == 0) {
                                 echo $played_crd;
                                 if ($crd_played_pos < 4) {
                                  echo " - "; 
                                 }  
                               }
                               
                             }
                             
                            $crd_played_pos++; 
                           }              
                        }

                    ?>
                    </td>
                    <?php 
                    
                    if ($s_single_match["instant_win_prze_amt"] != "" || $s_single_match["instant_win_prze_amt"] != null) {
                      
                   ?>
                  </tr>
                  <tr>
                  <td>
                  <?php print money_format('%(#12n',$s_single_match["instant_win_prze_amt"]); ?>
                  </td>
                  </tr>
                  <?php  } ?>
           }
         }
        
     
    ?>



   <?php
      } 
    } 

    ?>