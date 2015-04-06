<?php

include_once ("../connect/connect_to_mysql.php");

require_once ("../class/time.class.php");

require_once ("../class/display.class.php");

$disp = new display();

$time = new time();

$id = $_POST['id'];
$id = strip_tags($id);
$id = mysql_real_escape_string($id);

$func = $_POST['func'];
$func = strip_tags($func);
$func = mysql_real_escape_string($func);

$thisRandNum = $_POST['randnum'];
$thisRandNum = strip_tags($thisRandNum);
$thisRandNum = mysql_real_escape_string($thisRandNum);

$select_day = "";
$select_year = "";

$firstname = "";
$middlename = "";
$lastname = "";
$gender = "";
$birthday = "";
$country = "";
$state = "";
$city = "";
$zip = "";

$bio_body = "";

$meta_keys = "";
$metasearch = "";
$metaask = "";
$en_metasearch = 0;
$en_metaask = 0;

$website = "";
$youtube = "";
$facebook = "";
$twitter = "";

$user_pic = "";
$remove_pic = "";

$sql_default = mysql_query("SELECT * FROM user_details WHERE owner_id='$id'");

switch($func) {

case 'show_basicInfo':

                      while ($row = mysql_fetch_array($sql_default)) {
       
                        $firstname = $row["firstname"];
                        $lastname = $row["lastname"];
                        $gender = $row["gender"];
       
                        $birthday = $row["birthday"];
                        $birthday = explode("-", $birthday);
                        $b_d = $birthday[2];
                        // $b_d = substr_replace ($b_d, '', 0);
                        $b_d = (int)$b_d;
                        $b_m = $birthday[1];
                        $str_month = time::diff_months($b_m);
                        $b_y = $birthday[0];
       
                        $country = $row["country"];
                        $state = $row["state"];
                        $city = $row["city"];
                        
                        $original_timezone = $row['timezone'];
                      }
                      
                      for ($x=2011; $x>=1900; $x--) {
                            /* if ($x == $b_y) {
                                  $select_year .= '<option id="' . $x . '" name="' . $x . '" value="' . $x . '" selected="selected">' . $x . '</option>';
                            } else { */
                                  $select_year .= '<option id="' . $x . '" name="' . $x . '" value="' . $x . '">' . $x . '</option>';
                            // }
                      }
                      
                      for ($y=1; $y<=31; $y++) {
                             /* if ($y == $b_d) {
                                   $select_day .= '<option id="' . $y . '" name="' . $y . '" value="' . $y . '" selected="selected">' . $y . '</option>';
                             } else { */
                                   $select_day .= '<option id="' . $y . '" name="' . $y . '" value="' . $y . '">' . $y . '</option>';
                             // }
                      }
                       
                      $timezones = $time->get_gmt_timezones_array ();
                      
                      foreach ($timezones as $timezone => $value) {
                                 if ($timezone == $original_timezone) {
                                   $timezones_option = '<option value="' . $timezone . '">' . $value . '</option>'; 
                                 }
                      }

                      foreach ($timezones as $timezone => $value) {
                                 $timezones_option .= '<option value="' . $timezone . '">' . $value . '</option>'; 
                      }
                      
                      $content = '<table width="750" align="center" cellpadding="10" cellspacing="0" style="border: none; background-color: #FBFBFB;"> 
                                    <form method="post" id="basicForm" enctype="multipart/form-data">
                                    <tr>
                                      <td width="602">
                                      <table width="100%" border="0" align="center">
                                        <tr>
                                          <td width="12%"><strong>First Name:</strong></td>
                                          <td width="40%"><input name="firstname" type="text" class="formFields" id="firstname" value="' . $firstname . '" style="width: 99%;" maxlength="32" /></td>
                                          <td width="48%">&nbsp;</td>
                                        </tr>
                                      </table>
                                      <table width="100%" border="0" align="center">
                                        <tr>
                                          <td width="12%"><strong>Last Name:</strong></td>
                                          <td width="40%"><input name="lastname" type="text" class="formFields" id="lastname" value="' . $lastname . '" style="width: 99%;" maxlength="32" /></td> 
                                          <td width="48%">&nbsp;</td>
                                        </tr>
                                      </table>
                                      <br />
                                      <table width="100%" border="0" align="center">
                                        <tr>
                                          <td width="12%"><strong>Gender:</strong></td>
                                          <td width="40%">
                                          <script language="javascript" type="text/javascript">
                                          document.getElementById("' . $gender . '").selected=true;
                                          document.getElementById("' . $str_month . '").selected=true;
                                          document.getElementById("' . $b_d . '").selected=true;
                                          document.getElementById("' . $b_y . '").selected=true;
                                          </script>
                                          <div class="">
                                            <select name="gender" id="gender" class="">
                                              <option id="Male" value="male">Male</option>
                                              <option id="Female" value="female">Female</option>
                                            </select>
                                          </div>
                                          </td>
                                          <td width="48%">&nbsp;</td>
                                        </tr>
                                      </table>
                                      <br />
                                      <table width="100%" border="0" align="center">
                                        <tr>
                                          <td width="12%"><strong>Date of Birth:</strong></td>
                                          <td width="40%">
                                          <!-- <div class=""> -->
                                            <select name="birth_month" class="" id="birth_month">
                                              <option id="January" value="01">January</option>
                                              <option id="February" value="02">February</option>
                                              <option id="March" value="03">March</option>
                                              <option id="April" value="04">April</option>
                                              <option id="May" value="05">May</option>
                                              <option id="June" value="06">June</option>
                                              <option id="July" value="07">July</option>
                                              <option id="August" value="08">August</option>
                                              <option id="September" value="09">September</option>
                                              <option id="October" value="10">October</option>
                                              <option id="November" value="11">November</option>
                                              <option id="December" value="12">December</option>
                                            </select>
                                          <!-- </div> -->
                                          <!-- <div class=""> -->
                                            <select name="birth_day" class="" id="birth_day">
                                              ' . $select_day . '
                                            </select>
                                          <!-- </div> -->
                                          <!-- <div class=""> -->
                                            <select name="birth_year" class="" id="birth_year">
                                              ' . $select_year . '
                                            </select>
                                          <!-- </div> -->
                                          </td>
                                          <td width="48%">&nbsp;</td>
                                        </tr>
                                      </table>
                                      <br />
                                      <table width="100%" border="0" align="center">
                                        <tr>
                                          <td width="12%"><strong>Country:</strong></td>
                                          <td width="40%">
                                          <div class="">
                                          <select name="country" id="country" class="">
                                          <option value="' . $country . '">' . $country . '</option>
                                          <option value="United States of America">United States of America</option>
                                          <option value="Afghanistan">Afghanistan</option>
                                          <option value="Albania">Albania</option>
                                          <option value="Algeria">Algeria</option>
                                          <option value="American Samoa">American Samoa</option>
                                          <option value="Andorra">Andorra</option>
                                          <option value="Angola">Angola</option>
                                          <option value="Anguilla">Anguilla</option>
                                          <option value="Antigua and Barbuda">Antigua and Barbuda</option>
                                          <option value="Argentina">Argentina</option>
                                          <option value="Armenia">Armenia</option>
                                          <option value="Aruba">Aruba</option>
                                          <option value="Australia">Australia</option>
                                          <option value="Austria">Austria</option>
                                          <option value="Azerbaijan">Azerbaijan</option>
                                          <option value="Bahamas">Bahamas</option>
                                          <option value="Bahrain">Bahrain</option>
                                          <option value="Bangladesh">Bangladesh</option>
                                          <option value="Barbados">Barbados</option>
                                          <option value="Belarus">Belarus</option>
                                          <option value="Belgium">Belgium</option>
                                          <option value="Belize">Belize</option>
                                          <option value="Benin">Benin</option>
                                          <option value="Bermuda">Bermuda</option>
                                          <option value="Bhutan">Bhutan</option>
                                          <option value="Bolivia">Bolivia</option>
                                          <option value="Bonaire">Bonaire</option>
                                          <option value="Bosnia and Herzegovina">Bosnia and Herzegovina</option>
                                          <option value="Botswana">Botswana</option>
                                          <option value="Brazil">Brazil</option>
                                          <option value="British Indian Ocean Ter">British Indian Ocean Ter</option>
                                          <option value="Brunei">Brunei</option>
                                          <option value="Bulgaria">Bulgaria</option>
                                          <option value="Burkina Faso">Burkina Faso</option>
                                          <option value="Burundi">Burundi</option>
                                          <option value="Cambodia">Cambodia</option>
                                          <option value="Cameroon">Cameroon</option>
                                          <option value="Canada">Canada</option>
                                          <option value="Canary Islands">Canary Islands</option>
                                          <option value="Cape Verde">Cape Verde</option>
                                          <option value="Cayman Islands">Cayman Islands</option>
                                          <option value="Central African Republic">Central African Republic</option>
                                          <option value="Chad">Chad</option>
                                          <option value="Channel Islands">Channel Islands</option>
                                          <option value="Chile">Chile</option>
                                          <option value="China">China</option>
                                          <option value="Christmas Island">Christmas Island</option>
                                          <option value="Cocos Island">Cocos Island</option>
                                          <option value="Columbia">Columbia</option>
                                          <option value="Comoros">Comoros</option>
                                          <option value="Congo">Congo</option>
                                          <option value="Cook Islands">Cook Islands</option>
                                          <option value="Costa Rica">Costa Rica</option>
                                          <option value="Cote D Ivoire">Cote D Ivoire</option>
                                          <option value="Croatia">Croatia</option>
                                          <option value="Cuba">Cuba</option>
                                          <option value="Curacao">Curacao</option>
                                          <option value="Cyprus">Cyprus</option>
                                          <option value="Czech Republic">Czech Republic</option>
                                          <option value="Denmark">Denmark</option>
                                          <option value="Djibouti">Djibouti</option>
                                          <option value="Dominica">Dominica</option>
                                          <option value="Dominican Republic">Dominican Republic</option>
                                          <option value="East Timor">East Timor</option>
                                          <option value="Ecuador">Ecuador</option>
                                          <option value="Egypt">Egypt</option>
                                          <option value="El Salvador">El Salvador</option>
                                          <option value="Equatorial Guinea">Equatorial Guinea</option>
                                          <option value="Eritrea">Eritrea</option>
                                          <option value="Estonia">Estonia</option>
                                          <option value="Ethiopia">Ethiopia</option>
                                          <option value="Falkland Islands">Falkland Islands</option>
                                          <option value="Faroe Islands">Faroe Islands</option>
                                          <option value="Fiji">Fiji</option>
                                          <option value="Finland">Finland</option>
                                          <option value="France">France</option>
                                          <option value="French Guiana">French Guiana</option>
                                          <option value="French Polynesia">French Polynesia</option>
                                          <option value="French Southern Ter">French Southern Ter</option>
                                          <option value="Gabon">Gabon</option>
                                          <option value="Gambia">Gambia</option>
                                          <option value="Georgia">Georgia</option>
                                          <option value="Germany">Germany</option>
                                          <option value="Ghana">Ghana</option>
                                          <option value="Gibraltar">Gibraltar</option>
                                          <option value="Great Britain">Great Britain</option>
                                          <option value="Greece">Greece</option>
                                          <option value="Greenland">Greenland</option>
                                          <option value="Grenada">Grenada</option>
                                          <option value="Guadeloupe">Guadeloupe</option>
                                          <option value="Guam">Guam</option>
                                          <option value="Guatemala">Guatemala</option>
                                          <option value="Guinea">Guinea</option>
                                          <option value="Guyana">Guyana</option>
                                          <option value="Haiti">Haiti</option>
                                          <option value="Hawaii">Hawaii</option>
                                          <option value="Honduras">Honduras</option>
                                          <option value="Hong Kong">Hong Kong</option>
                                          <option value="Hungary">Hungary</option>
                                          <option value="Iceland">Iceland</option>
                                          <option value="India">India</option>
                                          <option value="Indonesia">Indonesia</option>
                                          <option value="Iran">Iran</option>
                                          <option value="Iraq">Iraq</option>
                                          <option value="Ireland">Ireland</option>
                                          <option value="Isle of Man">Isle of Man</option>
                                          <option value="Israel">Israel</option>
                                          <option value="Italy">Italy</option>
                                          <option value="Jamaica">Jamaica</option>
                                          <option value="Japan">Japan</option>
                                          <option value="Jordan">Jordan</option>
                                          <option value="Kazakhstan">Kazakhstan</option>
                                          <option value="Kenya">Kenya</option>
                                          <option value="Kiribati">Kiribati</option>
                                          <option value="Korea North">Korea North</option>
                                          <option value="Korea South">Korea South</option>
                                          <option value="Kuwait">Kuwait</option>
                                          <option value="Kyrgyzstan">Kyrgyzstan</option>
                                          <option value="Laos">Laos</option>
                                          <option value="Latvia">Latvia</option>
                                          <option value="Lebanon">Lebanon</option>
                                          <option value="Lesotho">Lesotho</option>
                                          <option value="Liberia">Liberia</option>
                                          <option value="Libya">Libya</option>
                                          <option value="Liechtenstein">Liechtenstein</option>
                                          <option value="Lithuania">Lithuania</option>
                                          <option value="Luxembourg">Luxembourg</option>
                                          <option value="Macau">Macau</option>
                                          <option value="Macedonia">Macedonia</option>
                                          <option value="Madagascar">Madagascar</option>
                                          <option value="Malaysia">Malaysia</option>
                                          <option value="Malawi">Malawi</option>
                                          <option value="Maldives">Maldives</option>
                                          <option value="Mali">Mali</option>
                                          <option value="Malta">Malta</option>
                                          <option value="Marshall Islands">Marshall Islands</option>
                                          <option value="Martinique">Martinique</option>
                                          <option value="Mauritania">Mauritania</option>
                                          <option value="Mauritius">Mauritius</option>
                                          <option value="Mayotte">Mayotte</option>
                                          <option value="Mexico">Mexico</option>
                                          <option value="Midway Islands">Midway Islands</option>
                                          <option value="Moldova">Moldova</option>
                                          <option value="Monaco">Monaco</option>
                                          <option value="Mongolia">Mongolia</option>
                                          <option value="Montserrat">Montserrat</option>
                                          <option value="Morocco">Morocco</option>
                                          <option value="Mozambique">Mozambique</option>
                                          <option value="Myanmar">Myanmar</option>
                                          <option value="Nambia">Nambia</option>
                                          <option value="Nauru">Nauru</option>
                                          <option value="Nepal">Nepal</option>
                                          <option value="Netherland Antilles">Netherland Antilles</option>
                                          <option value="Netherlands">Netherlands</option>
                                          <option value="Nevis">Nevis</option>
                                          <option value="New Caledonia">New Caledonia</option>
                                          <option value="New Zealand">New Zealand</option>
                                          <option value="Nicaragua">Nicaragua</option>
                                          <option value="Niger">Niger</option>
                                          <option value="Nigeria">Nigeria</option>
                                          <option value="Niue">Niue</option>
                                          <option value="Norfolk Island">Norfolk Island</option>
                                          <option value="Norway">Norway</option>
                                          <option value="Oman">Oman</option>
                                          <option value="Pakistan">Pakistan</option>
                                          <option value="Palau Island">Palau Island</option>
                                          <option value="Palestine">Palestine</option>
                                          <option value="Panama">Panama</option>
                                          <option value="Papua New Guinea">Papua New Guinea</option>
                                          <option value="Paraguay">Paraguay</option>
                                          <option value="Peru">Peru</option>
                                          <option value="Philippines">Philippines</option>
                                          <option value="Pitcairn Island">Pitcairn Island</option>
                                          <option value="Poland">Poland</option>
                                          <option value="Portugal">Portugal</option>
                                          <option value="Puerto Rico">Puerto Rico</option>
                                          <option value="Qatar">Qatar</option>
                                          <option value="Reunion">Reunion</option>
                                          <option value="Romania">Romania</option>
                                          <option value="Russia">Russia</option>
                                          <option value="Rwanda">Rwanda</option>
                                          <option value="St Barthelemy">St Barthelemy</option>
                                          <option value="St Eustatius">St Eustatius</option>
                                          <option value="St Helena">St Helena</option>
                                          <option value="St Kitts-Nevis">St Kitts-Nevis</option>
                                          <option value="St Lucia">St Lucia</option>
                                          <option value="St Maarten">St Maarten</option>
                                          <option value="St Pierre and Miquelon">St Pierre and Miquelon</option>
                                          <option value="St Vincent and Grenadines">St Vincent and Grenadines</option>
                                          <option value="Saipan">Saipan</option>
                                          <option value="Samoa">Samoa</option>
                                          <option value="Samoa American">Samoa American</option>
                                          <option value="San Marino">San Marino</option>
                                          <option value="Sao Tome and Principe">Sao Tome and Principe</option>
                                          <option value="Saudi Arabia">Saudi Arabia</option>
                                          <option value="Senegal">Senegal</option>
                                          <option value="Seychelles">Seychelles</option>
                                          <option value="Serbia and Montenegro">Serbia and Montenegro</option>
                                          <option value="Sierra Leone">Sierra Leone</option>
                                          <option value="Singapore">Singapore</option>
                                          <option value="Slovakia">Slovakia</option>
                                          <option value="Slovenia">Slovenia</option>
                                          <option value="Solomon Islands">Solomon Islands</option>
                                          <option value="Somalia">Somalia</option>
                                          <option value="South Africa">South Africa</option>
                                          <option value="Spain">Spain</option>
                                          <option value="Sri Lanka">Sri Lanka</option>
                                          <option value="Sudan">Sudan</option>
                                          <option value="Suriname">Suriname</option>
                                          <option value="Swaziland">Swaziland</option>
                                          <option value="Sweden">Sweden</option>
                                          <option value="Switzerland">Switzerland</option>
                                          <option value="Syria">Syria</option>
                                          <option value="Tahiti">Tahiti</option>
                                          <option value="Taiwan">Taiwan</option>
                                          <option value="Tajikistan">Tajikistan</option>
                                          <option value="Tanzania">Tanzania</option>
                                          <option value="Thailand">Thailand</option>
                                          <option value="Togo">Togo</option>
                                          <option value="Tokelau">Tokelau</option>
                                          <option value="Tonga">Tonga</option>
                                          <option value="Trinidad and Tobago">Trinidad and Tobago</option>
                                          <option value="Tunisia">Tunisia</option>
                                          <option value="Turkey">Turkey</option>
                                          <option value="Turkmenistan">Turkmenistan</option>
                                          <option value="Turks and Caicos Is">Turks and Caicos Is</option>
                                          <option value="Tuvalu">Tuvalu</option>
                                          <option value="Uganda">Uganda</option>
                                          <option value="Ukraine">Ukraine</option>
                                          <option value="United Arab Emirates">United Arab Emirates</option>
                                          <option value="United Kingdom">United Kingdom</option>
                                          <option value="United States of America">United States of America</option>
                                          <option value="Uruguay">Uruguay</option>
                                          <option value="Uzbekistan">Uzbekistan</option>
                                          <option value="Vanuatu">Vanuatu</option>
                                          <option value="Vatican City State">Vatican City State</option>
                                          <option value="Venezuela">Venezuela</option>
                                          <option value="Vietnam">Vietnam</option>
                                          <option value="Virgin Islands (Brit)">Virgin Islands Brit</option>
                                          <option value="Virgin Islands (USA)">Virgin Islands USA</option>
                                          <option value="Wake Island">Wake Island</option>
                                          <option value="Wallis and Futana Is">Wallis and Futana Is</option>
                                          <option value="Yemen">Yemen</option>
                                          <option value="Zaire">Zaire</option>
                                          <option value="Zambia">Zambia</option>
                                          <option value="Zimbabwe">Zimbabwe</option>
                                          </select>
                                          </div>
                                          </td> 
                                          <td width="48%">&nbsp;</td>
                                        </tr>
                                      </table>
           
                                      <table width="100%" border="0" align="center">
                                        <tr>
                                          <td width="12%"><strong>State:</strong></td>
                                          <td width="40%"><input name="state" type="text" class="formFields" id="state" value="' . $state . '" style="width: 99%;" maxlength="32" /></td>
                                          <td width="48%">&nbsp;</td>
                                        </tr>
                                      </table> 
          
                                      <table width="100%" border="0" align="center">
                                        <tr> 
                                          <td width="12%"><strong>City:</strong></td>         
                                          <td width="40%"><input name="city" type="text" class="formFields" id="city" value="' . $city . '" style="width: 99%;" maxlength="32" /></td>
                                          <td width="48%">&nbsp;</td>
                                        </tr> 
                                      </table>
                                      
                                      <table width="100%" border="0" align="center">
                                        <tr>
                                          <td width="12%"><strong>Time zone:</strong></td>
                                          <td width="40%">
                                            <select name="timezone" id="timezone">
                                              ' . $timezones_option . '
                                            </select>
                                          </td>
                                          <td width="48%"></td>
                                        </tr>
                                      </table>
                                      
                                      </td>
                                    </tr>

                                    <tr>
                                      <td width="56" valign="top">
                                        <a name="updateBtn2" class="save_btns" id="updateBtn2" onclick="javascript: sendBasic();">Update Profile</a>
                                        <input name="parse_var" type="hidden" value="location" />
                                        <input name="thisWipit" type="hidden" value="' . $thisRandNum . '; ?>" />
                                      </td>
                                    </tr>
                                      </form>
                                  </table>
                                  ';
                                  break;
       
       
        
case 'show_profilePic':
                       ////// Mechanism to display Pic. See if they have uploaded a pic or not //////////////
                       $cache_buster = rand(999999999,9999999999999); // Put on an image URL will help always show new when changed
                       $check_pic = "../members/$id/image01.jpg";
                       $default_pic = "members/0/image01.jpg";
                       
                       $result_div = '/post_results/';
                      
                       $user_pic = $disp->display_pic($check_pic, $id, 200, 200);
                      
                       if (file_exists($check_pic)) {
                          // $user_pic = "<img src=\"$check_pic\" width=\"200px\" />"; // forces picture to be 200px wide and no more
                          $remove_pic = '<a href="#" onclick="return false" onmousedown="javascript: remove_photo(' . $id . ');">Remove photo</a>';
                       } else {
                          // $user_pic = "<img src=\"$default_pic\" width=\"200px\" />"; // forces picture to be 100px wide and no more
                       } 

                       $content = '
                                   <form method="post" id="picForm" name="picForm" enctype="multipart/form-data">
                                     <table width="750" align="center" cellpadding="10" cellspacing="0" style="border: none; background-color: #FBFBFB;">
                                       <tr> 
                                         <td width="250"> 
                                           ' . $user_pic . '<br /><br />
                                           ' . $remove_pic . '
                                         </td>
                                         <td width="400">
                                           <span><input name="Profile_Pic" type="file" class="formFields" id="Profile_Pic" onchange="javascript: check_profile_pic(this.form.id, ' . $result_div . ', this.id);" /></span>500 kb max 
                                         </td>
                                         <td width="56">
                                           <input name="Function" type="hidden" value="post_profilePic" />
                                           <input name="oid" type="hidden"  value="' . $id . '" />
                                           <a name="updateBtn1" class="save_btns" id="updateBtn1" onclick="javascript: update_profile_pic(this.form.id, ' . $result_div . ', Profile_Pic.id);">Update Profile</a>
                                         </td>
                                       </tr>
                                     </table>
                                   </form>
                                   ';
                        break;

case 'show_link':
                  while ($row = mysql_fetch_array($sql_default)) {
                     $website = $row["website"];
                     $youtube = $row["youtube"];
                     $facebook = $row["facebook"];
                     $twitter = $row["twitter"];
                  }

                  $content = '
                              <table width="750" align="center" cellpadding="10" cellspacing="0" style="border: none; background-color: #FBFBFB;">
                                <form method="post" id="linkForm" enctype="multipart/form-data">
                                  <tr>
                                    <td width="111">Your Website: <span class="brightRed">*</span></td>
                                    <td width="471"><strong>http://</strong>
                                    <input name="website" type="text" class="formFields" id="website" value="' . $website . '" size="36" maxlength="32" /></td>
                                  </tr>
                                  <tr>
                                    <td>Youtube Channel: <span class="brightRed">*</span></td>
                                    <td><strong>http://www.youtube.com/user/</strong>
                                    <input name="youtube" type="text" class="formFields" id="youtube" value="' . $youtube . '" size="20" maxlength="40" /></td>   
                                  </tr>
                                  <tr>
                                    <td>Facebook ID:<span class="brightRed">*</span></td>
                                    <td><strong>http://www.facebook.com/profile.php?id=</strong>
                                    <input name="facebook" type="text" class="formFields" id="facebook" value="' . $facebook . '" size="20" maxlength="40" /></td>
                                  </tr>
                                  <tr>
                                    <td>Twitter Username:<span class="brightRed">*</span></td>
                                    <td><strong>http://www.twitter.com/</strong>
                                    <input name="twitter" type="text" class="formFields" id="twitter" value="' . $twitter . '" size="20" maxlength="40" /></td>
                                  </tr>
                                  <tr>
                                    <td width="56" rowspan="3" valign="top">
                                      <a name="updateBtn3" class="save_btns" id="updateBtn3" onclick="javascript: sendLink();">Update Profile</a>
                                      <input name="parse_var" type="hidden" value="links" />
                                      <input name="thisWipit" type="hidden" value="' . $thisRandNum . '" />
                                    </td>  
                                  </tr>
                                </form>
                              </table>';

                  break;
                  
case 'show_desc':
                 while ($row = mysql_fetch_array($sql_default)) {
                    $bio_body = $row["bio_body"];
                    $bio_body = stripslashes($bio_body);
                    $bio_body = str_replace("<br />", "", $bio_body);
                    $bio_body = str_replace("&#39;", "'", $bio_body);
                    // $bio_body = str_replace("&#39;", "`", $bio_body);
                    // $bio_body = stripslashes($bio_body);
                 }
                 $content = '<table width="750" align="center" cellpadding="10" cellspacing="0" style="border: none; background-color: #FBFBFB;">
                               <form method="post" name="descForm" enctype="multipart/form-data">
                               <tr>
                                 <td width="602" valign="top"><strong>About Me:</strong><br /><br />
                                 <textarea name="bio_body" id="bio_body" cols="" rows="6" class="formFields" style="width: 80%;">' . $bio_body . '</textarea></td>
                               </tr>
                               <tr>
                                 <td width="56" valign="top">
                                   <a name="updateBtn4" class="save_btns" id="updateBtn4" onclick="javascript: sendDesc();">Update Profile</a>
                                   <input name="parse_var" type="hidden" value="bio" />
                                   <input name="thisWipit" type="hidden" value="' . $thisRandNum . '" />
                                 </td>
                               </tr>
                               </form>
                             </table>';           
                  break;
                  
case 'show_meta':
                 $sql_meta = mysql_query("SELECT * FROM metas WHERE owner_id='$id'");
                  while ($row = mysql_fetch_array($sql_meta)){
                      $meta_keys = $row['meta_keys'];
                      $search_keys = $row['search_keys'];
                      $event_keys = $row['event_keys'];
                      $en_metasearch = $row['en_metasearch'];
                      $en_metaask = $row['en_metaask'];
                      $en_eventKeys = $row['en_event_keys'];
                  }
                  
                  if ($en_metasearch == 1) {
                      $show_enms = 'checked="checked"';
                  }else {
                      $show_enms = '';
                  }
                  
                  if ($en_metaask == 1) {
                      $show_enma = 'checked="checked"';
                  }else {
                      $show_enma = '';
                  } 
                  
                  if ($en_eventKeys == true) {
                      $show_enek = 'checked="checked"';
                  } else {
                      $show_enek = '';
                  }
                  
                  $content = '<table width="750" align="center" cellpadding="10" cellspacing="0" style="border: none; background-color: #FBFBFB;">
                                <form method="post" name="metaForm" enctype="multipart/form-data">
                                
                                <tr>
                                  <td width="602" valign="top"><strong>Meta Keys:</strong><br /><br />
                                    <textarea name="meta_keys" id="meta_keys" cols="" rows="6" class="formFields" style="width: 80%;">' . $meta_keys . '</textarea><br /><br />
                                      <input name="metaask" type="checkbox" id="metaask" value="yes" ' . $show_enma . ' />
                                      <a style="font-weight: bold;">Enable the use of your Meta Keys and receive notifications when other users post question that you are interested in.</a>
                                    <div style="font-weight: bold; margin-top: 10px;">* Please remember to seperate keywords with commas eg. <a style="color: blue;">"keyword1,keyword2,keyword3"</a></div>
                                  </td>
                                </tr>
                                
                                <tr>
                                  <td>
                                    <textarea name="search_keys" id="search_keys" cols="" rows="6" class="formFields" style="width: 80%;">' . $search_keys . '</textarea><br /><br />
                                    <input name="metasearch" type="checkbox" id="metasearch" value="yes" ' . $show_enms . ' />
                                    <a style="font-weight: bold;">Enable the use of your Meta Keys and get searchable by other users using the keywords have you entered.</a>
                                    <div style="font-weight: bold; margin-top: 10px;">* Please remember to seperate keywords with commas eg. <a style="color: blue;">"keyword1,keyword2,keyword3"</a></div>
                                  </td>
                                </tr>
                                
                                <tr>
                                  <td> 
                                    <textarea name="event_keys" id="event_keys" cols="" rows="6" class="formFields" style="width: 80%;">' . $event_keys . '</textarea><br /><br />
                                    <input name="en_event_keys" type="checkbox" id="en_event_keys" value="yes" ' . $show_enek . ' />
                                    <a style="font-weight: bold;">Enable the use of your Event Keys and receive notifications when other users create events that you are interested in.</a>
                                    <div style="font-weight: bold; margin-top: 10px;">* Please remember to seperate keywords with commas eg. <a style="color: blue;">"keyword1,keyword2,keyword3"</a></div>
                                  </td>
                                </tr>
                                
                                <tr>
                                  <td width="56" valign="top">
                                    <a name="updateBtn4" class="save_btns" id="updateBtn4" onclick="javascript: sendMeta();">Update Profile</a>
                                    <input name="parse_var" type="hidden" value="meta" />
                                    <input name="thisWipit" type="hidden" value="' . $thisRandNum . '" />
                                  </td>
                                </tr>
                                
                                </form>
                              </table>';
                  
}                

echo $content;

?>

