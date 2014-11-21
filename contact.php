<?PHP
/*
    email contact tutorial available from
    http://www.html-form-guide.com/contact-form/simple-php-contact-form.html
*/
require_once("./include/fgcontactform.php");

$formproc = new FGContactForm();


//1. Add your email address here.
//You can add more than one receipients.
$formproc->AddRecipient('daviruiz@outlook.com'); //<<---Put your email address here


//2. For better security. Get a random string from this link: http://tinyurl.com/randstr
// and put it here
$formproc->SetFormRandomKey('CnRrspl1FyEylUj');


if(isset($_POST['submitted']))
{
   if($formproc->ProcessForm())
   {
        $formproc->RedirectToURL("thank-you.php");
   }
}

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../favicon.ico">

    <title>Nerd Tech</title>

    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css">
    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap-theme.min.css">
    <!-- Custom styles for this template -->
    <link href="http://getbootstrap.com/examples/theme/theme.css" rel="stylesheet">
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" type="text/css" href="css/nerdtech-theme.css">
    <link rel="STYLESHEET" type="text/css" href="contact.css" />
    <script type='text/javascript' src='scripts/gen_validatorv31.js'></script>


  </head>

  <body role="document">
    <!-- Color Choices: http://paletton.com/#uid=72A1T0kwWsPldHvr0-xz2lBGJdL -->

    <!-- Fixed navbar -->
    <nav class="navbar navbar-custom navbar-fixed-top" role="navigation">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar-custom">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#">David Ruiz</a>
        </div>

        <div id="navbar" class="navbar-collapse collapse">
          <ul class="nav navbar-nav">
            <li><a href="index.html">About Me</a></li>
            <li><a href="projects.html">Projects</a></li>
            <li><a href="blog.html">Captain's Log</a></li>
            <li class="active"><a href="contact.html">Contact Me</a></li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav>

    <div class="container theme-showcase" role="main">
      <div class="jumbotron main-msg">
        <!-- Form Code Start -->
        <form id='contactus' action='<?php echo $formproc->GetSelfScript(); ?>' method='post' accept-charset='UTF-8'>
          <fieldset >
          <legend>Contact us</legend>

          <input type='hidden' name='submitted' id='submitted' value='1'/>
          <input type='hidden' name='<?php echo $formproc->GetFormIDInputName(); ?>' value='<?php echo $formproc->GetFormIDInputValue(); ?>'/>
          <input type='text'  class='spmhidip' name='<?php echo $formproc->GetSpamTrapInputName(); ?>' />

          <div class='short_explanation'>* required fields</div>

          <div><span class='error'><?php echo $formproc->GetErrorMessage(); ?></span></div>
          <div class='container'>
              <label for='name' >Your Full Name*: </label><br/>
              <input type='text' name='name' id='name' value='<?php echo $formproc->SafeDisplay('name') ?>' maxlength="50" /><br/>
              <span id='contactus_name_errorloc' class='error'></span>
          </div>
          <div class='container'>
              <label for='email' >Email Address*:</label><br/>
              <input type='text' name='email' id='email' value='<?php echo $formproc->SafeDisplay('email') ?>' maxlength="50" /><br/>
              <span id='contactus_email_errorloc' class='error'></span>
          </div>

          <div class='container'>
              <label for='message' >Message:</label><br/>
              <span id='contactus_message_errorloc' class='error'></span>
              <textarea rows="10" cols="50" name='message' id='message'><?php echo $formproc->SafeDisplay('message') ?></textarea>
          </div>


          <div class='container'>
              <input type='submit' name='Submit' value='Submit' />
          </div>

          </fieldset>
        </form>
      </div>

    </div> <!-- /container -->


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- client-side Form Validations:
    Uses the excellent form validation script from JavaScript-coder.com-->

    <script type='text/javascript'>
    // <![CDATA[

        var frmvalidator  = new Validator("contactus");
        frmvalidator.EnableOnPageErrorDisplay();
        frmvalidator.EnableMsgsTogether();
        frmvalidator.addValidation("name","req","Please provide your name");

        frmvalidator.addValidation("email","req","Please provide your email address");

        frmvalidator.addValidation("email","email","Please provide a valid email address");

        frmvalidator.addValidation("message","maxlen=2048","The message is too long!(more than 2KB!)");

    // ]]>
    </script>
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js"></script>
  </body>
</html>
