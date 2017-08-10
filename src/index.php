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
  <link rel="stylesheet" href="public/css/index.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
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
                <div>Hour Log</div>
                <div>Component Fitting</div>
                <div>Component Unfitting</div>
              </div>
            </div>
            <div class="menu">List & Search
              <div class="sub_menu">
                <a href="index.php?page=list_machine"><div>Machine</div></a>
                <a href="index.php?page=list_class"><div>Component Class</div></a>
                <a href="index.php?page=list_component"><div>All Components</div></a>
                <a href="index.php?page=list_component&comp_type=active"><div>Active Components</div></a>
                <a href="index.php?page=list_component&comp_type=expired"><div>Expired Components</div></a>
                <a href="index.php?page=list_component&comp_type=expiring"><div>Expiring Components</div></a>
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

  <script>
    $(() => {
      <? if(isset($page_title)) {?>
          $(".page_title").text("<?=$page_title?>").show();
      <? }?>

      <? if(isset($_SESSION["message"])) {
          $alert_type = $_SESSION["message"];
          $alert_msg = $_SESSION[$_SESSION["message"] . "_msg"];
          unset($_SESSION[$_SESSION["message"] . "_msg"]);
          unset($_SESSION["message"]);?>
            $(".msg_box").addClass("alert-<?=$alert_type?>").text("<?=$alert_msg?>").show();
      <? }?>
    });
  </script>

  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</body>
</html>