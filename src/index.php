<!DOCTYPE html>
<html lang="en">
<head>
  <title>Component Tracking</title>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css">
  <link href='https://fonts.googleapis.com/css?family=Iceland' rel='stylesheet'>
  <link rel="stylesheet" href="public/css/index.css">
</head>

<body>
  <div class="container-fluid">
    <div id="header" class="row">
      <div class="header_left  col-4">
        <div class="title">
          C O M P O N E N T<span class="title_large">T R A C K I N G</span>
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
                <div>Add New Machine</div>
                <div>Add Component Class</div>
                <div>Add New Component</div>
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
                <div>Machine</div>
                <div>Component Class</div>
                <div>All Components</div>
                <div>Active Components</div>
                <div>Expired Components</div>
                <div>Expiring Components</div>
                <div>Hour Log</div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="main_body">
      <?
        if(isset($page)) {

        } else {
          include "pages/dashboard.php";
        }
      ?>
    </div>
  </div>

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js"></script>
</body>
</html>