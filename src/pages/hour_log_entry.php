<?
  if(isset($_POST["form_hour_log_entry"]) && $_POST["form_hour_log_entry"] === "HourLogEntry") {
    if(!empty($_POST["log_machine_id"])) {
      if($_POST["log_action"] === "add") {
        $hour_diff = $_POST["log_hours"];
        $stmt = $conn->prepare("INSERT INTO tbl_hour_log (log_machine_id, log_entry_on, log_entry_by, log_hours) VALUES (:log_machine_id, :log_entry_on, :log_entry_by, :log_hours)");
        $action_msg = "1 new log detail added";
      } else {
        $stmt = $conn->prepare("SELECT :new_log_hours - log_hours as hour_diff FROM tbl_hour_log WHERE log_id = :log_id");
        $stmt->bindParam(':new_log_hours', $_POST["log_hours"]);
        $stmt->bindParam(':log_id', $_POST["log_id"]);
        $stmt->execute();
        $log_info = $stmt->fetch();
        $hour_diff = $log_info["hour_diff"];

        $stmt = $conn->prepare("UPDATE tbl_hour_log SET log_machine_id = :log_machine_id, log_entry_on = :log_entry_on, log_entry_by = :log_entry_by, log_hours = :log_hours WHERE log_id = :log_id");
        $stmt->bindParam(':log_id', $_POST["log_id"]);
        $action_msg = "1 log detail edited";
      }

      $stmt->bindParam(':log_machine_id', $_POST["log_machine_id"]);
      $stmt->bindParam(':log_entry_on', $_POST["log_entry_on"]);
      $stmt->bindParam(':log_entry_by', $_POST["log_entry_by"]);
      $stmt->bindParam(':log_hours', $_POST["log_hours"]);
      $affected = $stmt->execute();

      if($affected > 0) {
        $stmt = $conn->prepare("UPDATE tbl_machine SET mac_hours = mac_hours + :updated_hours WHERE mac_id = :mac_id");
        $stmt->bindParam(':updated_hours', $hour_diff);
        $stmt->bindParam(':mac_id', $_POST["log_machine_id"]);
        $stmt->execute();

        $stmt = $conn->prepare("UPDATE tbl_component SET cmp_used_hours = cmp_used_hours + :updated_hours WHERE cmp_machine_id = :mac_id");
        $stmt->bindParam(':updated_hours', $hour_diff);
        $stmt->bindParam(':mac_id', $_POST["log_machine_id"]);
        $stmt->execute();

        $_SESSION["message"] = "success";
        $_SESSION[$_SESSION["message"] . "_msg"] = $action_msg;
        header("Location: index.php?page=list_hour_log");
      }
      // there was some error
    } else {
      // send error message
    }
    exit;
  } else {
    $page_title = "Hour Log Entry";

    $stmt = $conn->prepare("SELECT mac_id, mac_name FROM tbl_machine");
    $stmt->execute();
    $mac_list = $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $mac_list = $stmt->fetchAll();

    $log_info = ["log_machine_id"=>"", "log_entry_on"=>"", "log_entry_by"=>"", "log_hours"=>"", "log_action"=>"add", "log_button" => "Enter Hours"];
    if(isset($_GET["action"]) && $_GET["action"] === "edit") {
      $page_title = "Edit Hour Log Detail";
      $stmt = $conn->prepare("SELECT log_id, log_machine_id, log_entry_on, log_entry_by, log_hours FROM tbl_hour_log WHERE log_id = :log_id");
      $stmt->bindParam(':log_id', $_GET["log_id"]);
      $stmt->execute();
      $log_info = $stmt->fetch();
      $log_info["log_action"] = "edit";
      $log_info["log_button"] = "Edit Log";
    }
  }
?>

<div class="portlet light bordered">
  <div class="portlet-title">
      <div class="caption">
          <i class="icon-equalizer font-red-sunglo"></i>
          <span class="caption-subject font-red-sunglo bold uppercase">Hour Log</span>
          <span class="caption-helper">enter hour log info</span>
      </div>
  </div>

  <div class="portlet-body">
      <!-- BEGIN FORM-->
        <form id="form_hour_log_entry" class="form-horizontal form_validation" method="post" action="index.php?page=hour_log_entry">
            <div class="form-body">
                <div class="alert alert-danger display-hide">
                    <button class="close" data-close="alert"></button> You have some form errors. Please check below.
                </div>
                <div class="alert alert-success display-hide">
                    <button class="close" data-close="alert"></button> Your form validation is successful!
                </div>

                <div class="form-group">
                    <label class="col-md-3 control-label">Machine</label>
                    <div class="col-md-4">
                      <select class="form-control" name="log_machine_id">
                        <option value="">Select the Machine</option>
                        <? foreach($mac_list as $machine) {?>
                          <option value="<?=$machine['mac_id']?>"><?=$machine['mac_name']?></option>
                        <? }?>
                      </select>
                    </div>
                </div>

                <div class="form-group last">
                    <label class="col-md-3 control-label">Entry Date</label>
                    <div class="col-md-4">
                      <div class="input-group date date-picker" data-date-format="yyyy-mm-dd">
                          <input type="text" name="log_entry_on" class="form-control" placeholder="Entry Date" readonly>
                          <span class="input-group-btn">
                              <button class="btn default" type="button">
                                  <i class="fa fa-calendar"></i>
                              </button>
                          </span>
                      </div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-3 control-label">Hours</label>
                    <div class="col-md-4">
                        <input type="text" name="log_hours" class="form-control" placeholder="Hours">
                    </div>
                </div>

                <div class="form-group last">
                    <label class="col-md-3 control-label">Entered By</label>
                    <div class="col-md-4">
                        <input type="text" name="log_entry_by" class="form-control" placeholder="Entered By">
                    </div>
                </div>
            </div>

            <div class="form-actions">
                <div class="row">
                    <div class="col-md-offset-3 col-md-9">
                        <input type="hidden" name="form_hour_log_entry" value="HourLogEntry">
                        <input type="hidden" name="log_id" value="<?=$log_info["log_id"]?>">
                        <input type="hidden" name="log_action" value="<?=$log_info["log_action"]?>">
                        <button type="submit" id="btn_hour_log_entry" class="btn btn-circle green">Submit</button>
                    </div>
                </div>
            </div>
        </form>
      <!-- END FORM-->
  </div>
</div>

<script>
  var validation_rules = {
    log_machine_id: {
        maxlength: 5,
        required: true,
        number: true
    },
    log_entry_on: {
      maxlength: 10,
      required: true
    },
    log_hours: {
      maxlength: 5,
      required: true,
      number: true
    },
    log_entry_by: {
      minlength: 3,
      maxlength: 50,
      required: true
    }
  };
</script>