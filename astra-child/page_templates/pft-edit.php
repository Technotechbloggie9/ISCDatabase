<?php
/**
*Function-name.
*pft_edit_form
*Summary.
*A function to show the
*editing form for performer_form_template.php
*Description.
*Using dot concatenation to
*format prefilled html form for display
*Required by performer_form_template.php
*
*/
function pft_edit_form($performerID, $firstName, $lastName, $performerBio, $userWebsite, $imgPath){
  $htmloutput = "".
  "<div style='height: 9em;''>".
  "  <span class='title1'>Edit Performer with ID: ". $performer_id ." </span>".
  "  <br>".
  "  <hr>".
  " </div>".
  "<span>&nbsp&nbsp&nbsp</span>".
  "<form id='form_editpf' method='POST' enctype='multipart/form-data' action='#'>".
  "  <p>".
  "    <div class='row'>".
  "      <div class='column' style='width: 50%;''>".
  "        <div style='height: 11em;'>".
  "          <label for='txtFirstName1' class='medium1'>Edit Performer First Name (required)</label>".
  "          <div>".
  "          <input type='text' class='medium1' id='txtFirstName1' name='txtFirstName1' value='".$firstName."' size='22em' maxlength='50' style='width:auto; box-shadow: 5px 5px 2px grey;' required />".
  "          </div>".
  "          <br>".
  "        </div>".
  "        <span>&nbsp&nbsp&nbsp</span>".
  "        <div class='column' style='width: 50%;'>".
  "          <div style='height: 11em;'>".
  "            <label for='txtLastName1' class='medium1'>Edit Performer Last Name (required)</label>".
  "            <div>".
  "              <input type='text' class='medium1' id='txtLastName1' name='txtLastName1' value='". $lastName."' size='22em' maxlength='50' style='width:auto; box-shadow: 5px 5px 2px grey;' required />".
  "            </div>".
  "            <br>".
  "          </div>".
  "        <div style='height: 28em; margin-bottom: 5px;'>".
  "          <label for='txtBio1' class='medium1'>Edit Bio</label>".
  "          <div>".
  "            <textarea type='text' id='txtBio1' name='txtBio1' rows='11' cols='22' maxlength='500' style='width:auto; box-shadow: 5px 5px 2px grey;'>". $performer_bio ."</textarea>".
  "          </div>".
  "          <br>".
  "        </div>".
  "        <span>&nbsp&nbsp&nbsp</span>".
  "        <span>&nbsp&nbsp&nbsp</span>".
  "        <div style='height: 10em; margin-top: 2px;'>".
  "          <label for='txtEmail1' class='medium1'>Edit Email (required)</label>".
  "          <div>".
  "            <input type='text' class='medium1' id='txtEmail1' name='txtEmail1' value='". $performer_email ."' size='22em' maxlength='50' style='width:auto; box-shadow: 5px 5px 2px grey;' required />".
  "          </div>".
  "          <br>".
  "        </div>".
  "        <span>&nbsp&nbsp&nbsp</span>".
  "        <div style='height: 10em;'>".
  "          <label for='txtWebsite1' class='medium1'>Edit Website</label>".
  "          <div>".
  "            <input type='text' class='medium1' id='txtWebsite1' name='txtWebsite1' value='". $userWebsite ."' size='22em' maxlength='50' style='width:auto; box-shadow: 5px 5px 2px grey;'/>".
  "          </div>".
  "          <br>".
  "        </div>".
  "        <br>".
  "        <span>&nbsp&nbsp&nbsp</span>".
  "        <div style='height: 9em;>".
  "         <label for='txtPath1'  class='medium1' >Edit Profile Image Path</label>".
  "         <span class='mono1'>(If replacing old image ensure path input is blank)</span><div>".
  "         <input type='text' class='medium1' id='txtImgPath1' name='txtImgPath' value='". $imgPath ."' size='22em' maxlength='50' style='width:auto; box-shadow: 5px 5px 2px grey;'/>".
  "        </div></div><br>".
  "        <div style='height: 9em;>".
  "          <label for='imgpfp1'  class='medium1' >Select New Image For Profile Picture</label>".
  "          <span class='mono1'>(If replacing old image ensure path input is blank)</span>".
  "         <div>".
  "            <input type='file' id='imgpfp1' name='imgpfp1' accept='image/*' />".
  "          </div>".
  "          <br>".
  "        </div>".
  "        <span>&nbsp&nbsp&nbsp</span>".
  "        <br>".
  "        <div style='height: 30em;'>".
  "          <label for='txtKeywords' class='medium1'>Add Keywords</label>".
  "          <div style='margin-top: -10px; margin-bottom: 1em;''>".
  "            <label for='txtKeywords' class='normal1 mono1' style='margin-top: 1em;'>(enter a new line after each keyword to create multiple keywords)</label>".
  "          </div>".
  "          <div>".
  "            <textarea type='text' id='txtKeywords' name='txtKeywords' rows='11' cols='22' style='width:auto; box-shadow: 5px 5px 2px grey;'></textarea>".
  "          </div>".
  "          <br>".
  "        </div>".
  "      <span>&nbsp&nbsp&nbsp</span>".
  "      </div>".
  "        <br>".
  "        <input type='submit' id='submit_editpf' name='submit_editpf' value='Submit' style='font-size: 200%; margin-top: 8px;'/>".
  "      </div>".
  "    </div>".
  "  </p>".
  "</form>";

  return $htmloutput;
}
?>