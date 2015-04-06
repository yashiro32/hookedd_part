<!-- <div id="login_form">
          <form action="login.php" method="post" enctype="multipart/form-data" name="signinform" id="signinform">
            <table>
            <tr>
              <td width="23%"><font size="+2">Log in</font></td>
              <td width="77%"><font color="#FF0000"><?php // print "$errorMsg"; ?></font></td>
            </tr>
            <tr>
              <td><strong>Email:</strong></td>
              <td><input name="email" type="text" id="email" autocomplete="on" style="width:60%;" /></td>
            </tr>
            <tr>
              <td><strong>Password:</strong></td>
              <td><input name="pass" type="password" id="pass" maxlength="24" style="width:60%;"/></td>
            </tr>
            <tr>
              <td align="right">&nbsp;</td>
              <td><input name="remember" type="checkbox" id="remember" value="yes" checked="checked" />
              Remember Me</td>
            </tr>
            <tr>
              <td>&nbsp;</td>
              <td><input name="myButton" type="submit" id="myButton" value="Sign In" /></td>
            </tr>
            <tr>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td colspan="2">Forgot your password? <a href="forgot_pass.php">Click Here</a>
              <br /></td>
            </tr>
            <tr>
              <td colspan="2">Need an Account? <a href="register.php">Click Here</a><br /><br />
              </td>
            </tr>
          </table>
          </form>
</div> -->

<div id="header-main">
  <!-- <div class="head"> -->
    <div class="header">
	  <div class="logo"><a href="index.php"><img src="images/main_logo.png" width="150px" height="29px" /></a></div><!--end of logo-->
			
	  <!-- <div style="float: left; padding: 2px; padding-right: 0px; padding-top: 15px; margin: 20px 0px 0px 20px;">
        <form name="search_form" method="post" action="search.php">
          <input name="search" id="search" onclick="javascript:click_search(this.id);" onblur="javascript:onblur_search(this.id);" placeholder="Type in your search here" value="Type in your search here" style="width: 200px; padding: 5px 4px; height: auto; font-size: 13px; border: 1px solid #888; -moz-border-radius: 3px; -webkit-border-radius: 3px; border-radius: 3px; color:#1034BA;" />
          <span><input type="button" name="search_submit" value="SEARCH" onclick="javascript: search_redirect('question');" style="border: none; background: black; -moz-border-radius: 3px; -webkit-border-radius: 3px; border-radius: 3px; color: white; font-weight: bold; padding: 7px 7px; cursor: pointer;" /></span>
        </form>
      </div> -->
			
	  <div class="header-right">
	    <form action="login.php" method="post" enctype="multipart/form-data" name="signinform" id="signinform">				
          <table width="476" border="0" cellspacing="0" cellpadding="0" class="login-section">
            <tr>
              <td width="189">
                <p class="txt-white">Email&nbsp;:-</p>
              </td>
              
              <td width="183">
                <p class="txt-white">Password&nbsp;:-</p>
              </td>
              
              <td width="74">
                &nbsp;
              </td>
            </tr>
            
            <tr>
              <td>
                <input name="email" type="text" id="email" class="input" autocomplete="on" />
              </td>
              
              <td>
                <input name="pass" type="password" id="pass" class="input" />
              </td>
              
              <td>
                <input name="myButton" type="submit" id="myButton" value="" class="button01-top" style="width:75px; height:25px; background-color:none;" />
              </td>
            </tr>
            
            <tr>
              <td>
                <p class="txt-white">
                  <input name="remember" type="checkbox" id="remember" value="yes" checked="checked" style="height:auto; border:none" />
                  Keep me logged in
                </p>
              </td>
              
              <td>
                <p>
                  <a href="forgot_pass.php" class="txt-whitelink">Forgot your Password</a>
                </p>
              </td>
              
              <td>
                &nbsp;
              </td>
            </tr>
          </table>
        </form>
      </div><!--end of header-right-->
	</div><!--end of header-->
  <!-- </div> -->
</div>










