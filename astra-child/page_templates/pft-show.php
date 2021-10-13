
<?php
/*
Part of refactor by Nathan Eggers
Last Edit 6/8/2021
*/
/**
*Function-name.
*pft_head
*Summary.
*A function to create the head for event_form_template.php
*Description.
*Using heredoc formatting (<<<_TAGNAME_) to
*format html head for later insertion
*Required by performer_form_template.php
*
*/

function pft_head(){


  $headoutput = <<<_HEAD_
  <head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <style>
      .title1{
        font-size: 300%;
      }
      input.big1{
        line-height: 200%;
      }
      input.medium1{
        line-height: 150%;
      }
      input.normal1{
        line-height: 100%;
      }
      input.small1{
        line-height: 80%;
      }
      label.fancy1{
        font-family: "Apple Chancery", "Monotype Corsiva", cursive;
      }
      label.mono1{
        font-family: "Mono", Mono, monospace;
      }
      label.official1{
        font-family: "Times New Roman", Times, serif;
      }
      label.hbig1{
        font-size: 300%;
      }
      label.big1{
        font-size: 200%;
      }
      label.medium1{
        font-size: 150%;
      }
      label.normal1{
        font-size: 100%;
      }
      label.small1{
        font-size: 80%;
      }
      .fltright{
        float: right;
      }
      .fltleft{
        float: left;
      }
  </style>
  </head>
  _HEAD_;
  return $headoutput;
}
/**
*Function-name.
*pft_show_form
*Summary.
*A function to show the form for performer_form_template.php
*Description.
*Using heredoc formatting (<<<_TAGNAME_) to
*format html form for display
*Required by performer_form_template.php
*
*/
function pft_show_form(){
  $htmloutput = <<<_OUT_
  <div style="height: 9em;">
    <span class="title1">Create Performer</span>
    <br>
    <hr>
  </div>
  <span>&nbsp&nbsp&nbsp</span>
  <form id="form_createpf" method="POST" enctype="multipart/form-data" action="#">
    <p>
      <div class="row">
        <div class="column" style="width: 50%;">
          <div style="height: 11em;">
            <label for="txtFirstName" class="medium1">Enter Performer First Name (required)</label>
            <div>
              <input type="text" class="medium1" id="txtFirstName" name="txtFirstName" size="22em" maxlength="50" style="width:auto; box-shadow: 5px 5px 2px grey;" required />
            </div>
            <br>
          </div>
          <span>&nbsp&nbsp&nbsp</span>
          <div class="column" style="width: 50%;">
            <div style="height: 11em;">
              <label for="txtLastName" class="medium1">Enter Performer Last Name (required)</label>
              <div>
                <input type="text" class="medium1" id="txtLastName" name="txtLastName" size="22em" maxlength="50" style="width:auto; box-shadow: 5px 5px 2px grey;" required />
              </div>
              <br>
            </div>
          <div style="height: 28em; margin-bottom: 5px;">
            <label for="txtBio" class="medium1">Enter Bio</label>
            <div>
              <textarea type="text" id="txtBio" name="txtBio" rows="11" cols="22" maxlength="500" style="width:auto; box-shadow: 5px 5px 2px grey;"></textarea>
            </div>
            <br>
          </div>
          <span>&nbsp&nbsp&nbsp</span>
          <span>&nbsp&nbsp&nbsp</span>
          <div style="height: 10em; margin-top: 2px;">
            <label for="txtEmail" class="medium1">Enter Email (required)</label>
            <div>
              <input type="text" class="medium1" id="txtEmail" name="txtEmail" size="22em" maxlength="50" style="width:auto; box-shadow: 5px 5px 2px grey;" required />
            </div>
            <br>
          </div>
          <span>&nbsp&nbsp&nbsp</span>
          <div style="height: 10em;">
            <label for="txtWebsite" class="medium1">Enter Website</label>
            <div>
              <input type="text" class="medium1" id="txtWebsite" name="txtWebsite" size="22em" maxlength="50" style="width:auto; box-shadow: 5px 5px 2px grey;"/>
            </div>
            <br>
          </div>
          <br>
          <span>&nbsp&nbsp&nbsp</span>
          <div style="height: 9em;">
            <label for="imgpfp"  class="medium1" >Select Image For Profile Picture  (required)</label>
            <div>
              <input type="file" id="imgpfp" name="imgpfp" accept="image/*" required />
            </div>
            <br>
          </div>
          <span>&nbsp&nbsp&nbsp</span>
          <br>
          <div style="height: 30em;">
            <label for="txtKeywords" class="medium1">Enter Keywords</label>
            <div style="margin-top: -10px; margin-bottom: 1em;">
              <label for="txtKeywords" class="normal1 mono1" style="margin-top: 1em;">(enter a new line after each keyword to create multiple keywords)</label>
            </div>
            <div>
              <textarea type="text" id="txtKeywords" name="txtKeywords" rows="11" cols="22" style="width:auto; box-shadow: 5px 5px 2px grey;"></textarea>
            </div>
            <br>
          </div>
        <span>&nbsp&nbsp&nbsp</span>
        </div>
          <br>
          <input type="submit" id="submit_createpf" name="submit_createpf" value="Submit" style="font-size: 200%; margin-top: 8px;"/>
        </div>
      </div>
    </p>
  </form>
  _OUT_;
  return $htmloutput;
}
/*
Outputs: names and ids are same:
txtFirstName, txtBio, txtKeywords,txtLastName, txtEmail, txtWebsite, imgpfp
submit name: submit_createpf
form name: form_createpf
*/
?>
