<?
  session_start();
  ob_start();

  include "common/config.php";
  include "common/connect.php";

  if(isset($_GET["page"])) {
    $page = $_GET["page"];
  } else {
    $page = "dashboard";
  }
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Component Tracking</title>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"> -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css">
  <link href='https://fonts.googleapis.com/css?family=Iceland' rel='stylesheet'>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="plugins/flatpickr_date/flatpickr.min.css">
  <link rel="stylesheet" href="public/css/index.css">

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <!-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script> -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js"></script>
  <script src="plugins/flatpickr_date/flatpickr.min.js"></script>
</head>

<body>
  <div class="container-fluid">
    <div id="header" class="row">
      <div class="header_left  col-4">
        <div class="title">
          <a href="index.php">C O M P O N E N T<span class="title_large">T R A C K I N G</span></a>
        </div>
      </div>

      <div class="header_right  col-8">
        <div id="header_search">
          <input type="text" name="hcomp_text" placeholder="Component">
          <input type="button" name="hcomp_search" value="Search">
        </div>

        <div id="header_hour_log">
          <select name="hlog_machine">
            <option value="0">Select the Machine</option>
          </select>
          <input type="text" name="hlog_hour" placeholder="Hours">
          <input type="button" name="hlog_enter" value="Enter Log">
        </div>

        <div class="navbar_row">
          <!-- <div class="dash_link">Go to Dashboard</div> -->
          <div id="navbar">
            <div class="menu">Setup
              <div class="sub_menu">
                <a href="index.php?page=add_machine"><div>Add New Machine</div></a>
                <a href="index.php?page=add_class"><div>Add Component Class</div></a>
                <a href="index.php?page=add_component"><div>Add New Component</div></a>
              </div>
            </div>
            <div class="menu">Entry
              <div class="sub_menu">
                <a href="index.php?page=hour_log_entry"><div>Hour Log Entry</div></a>
                <a href="index.php?page=component_fitting"><div>Component Fitting</div></a>
                <a href="index.php?page=component_unfitting"><div>Component Unfitting</div></a>
              </div>
            </div>
            <div class="menu">List & Search
              <div class="sub_menu">
                <a href="index.php?page=list_machine"><div>Machine</div></a>
                <a href="index.php?page=list_class"><div>Component Class</div></a>
                <a href="index.php?page=list_component"><div>All Components</div></a>
                <a href="index.php?page=list_component&status=active"><div>Active Components</div></a>
                <a href="index.php?page=list_component&status=expired"><div>Expired Components</div></a>
                <a href="index.php?page=list_component&status=expiring"><div>Expiring Components</div></a>
                <a href="index.php?page=list_component&status=unfitted"><div>Unfitted Components</div></a>
                <a href="index.php?page=list_hour_log"><div>Hour Log</div></a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="main_body">
      <div class="page_title"></div>
      <div class="msg_box alert"></div>

      <? include "pages/" . $page . ".php";?>
    </div>
  </div>

  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Modal Header</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
          <p>Modal Text</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="modal_action btn btn-primary">Yes</button>
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>

  <script>
    $(() => {
    // Applying datepicker <<<<<<<<<<
        $(".datepicker input").attr("data-input", "");
        $(".datepicker").append('<a class="input-button" title="toggle" data-toggle><i class="fa fa-calendar" aria-hidden="true"></i></a><a class="input-button" title="clear" data-clear><i class="fa fa-times" aria-hidden="true"></i></a>').flatpickr({wrap: true});
    // Applying datepicker >>>>>>>>>>

      <? if(isset($page_title)) {?>
          $(".page_title").text("<?=$page_title?>").show();
      <? }?>

	// Applying session message <<<<<<<<<<
        <? if(isset($_SESSION["message"])) {
            $alert_type = $_SESSION["message"];
            $alert_msg = $_SESSION[$_SESSION["message"] . "_msg"];
            unset($_SESSION[$_SESSION["message"] . "_msg"]);
            unset($_SESSION["message"]);?>
              $(".msg_box").addClass("alert-<?=$alert_type?>").text("<?=$alert_msg?>").show();
        <? }?>
	// Applying session message >>>>>>>>>>
    });
  </script>
</body>
</html>