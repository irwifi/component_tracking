<?
  if(isset($_POST["form_add_machine"]) && $_POST["form_add_machine"] === "AddMachine") {
    if(!empty($_POST["mac_name"])) {
      if($_POST["mac_action"] === "add") {
        $stmt = $conn->prepare("INSERT INTO tbl_machine (mac_name, mac_type, mac_reg_no, mac_color, mac_location, mac_purchased_on) VALUES (:mac_name, :mac_type, :mac_reg_no, :mac_color, :mac_location, :mac_purchased_on)");
        $action_title = "MACHINE ADDED";
        $action_msg = "1 new Machine detail added";
      } else {
        $stmt = $conn->prepare("UPDATE tbl_machine SET mac_name = :mac_name, mac_type = :mac_type, mac_reg_no = :mac_reg_no, mac_color = :mac_color, mac_location = :mac_location, mac_purchased_on = :mac_purchased_on WHERE mac_id = :mac_id");
        $stmt->bindParam(':mac_id', $_POST["mac_id"]);
        $action_title = "MACHINE EDITED";
        $action_msg = "1 machine detail edited";
      }

      $stmt->bindParam(':mac_name', $_POST["mac_name"]);
      $stmt->bindParam(':mac_type', $_POST["mac_type"]);
      $stmt->bindParam(':mac_reg_no', $_POST["mac_reg_no"]);
      $stmt->bindParam(':mac_color', $_POST["mac_color"]);
      $stmt->bindParam(':mac_location', $_POST["mac_location"]);
      $stmt->bindParam(':mac_purchased_on', $_POST["mac_purchased_on"]);
      $inserted = $stmt->execute();

      if($inserted > 0) {
        $_SESSION["alert"] = "success";
        $_SESSION["alert_title"] = $action_title;
        $_SESSION["alert_msg"] = $action_msg;
        header("Location: index.php?page=list_machine");
      }
      // there was some error
    } else {
      // send error message
    }
    exit;
  } else {
    $page_title = "Add New Machine";
    $mac_info = ["mac_name"=>"", "mac_type"=>"", "mac_reg_no"=>"", "mac_color"=>"", "mac_location"=>"", "mac_purchased_on"=>"", "mac_action"=>"add", "mac_button" => "Add Machine"];

    if(isset($_GET["action"]) && $_GET["action"] === "edit") {
      $page_title = "Edit Machine Detail";
      $stmt = $conn->prepare("SELECT mac_id, mac_name, mac_type, mac_reg_no, mac_color, mac_location, mac_purchased_on FROM tbl_machine WHERE mac_id = :mac_id");
      $stmt->bindParam(':mac_id', $_GET["mac_id"]);
      $stmt->execute();
      $mac_info = $stmt->fetch();
      $mac_info["mac_action"] = "edit";
      $mac_info["mac_button"] = "Edit Machine";
    }
  }
?>

<div class="portlet light bordered">
  <div class="portlet-title">
      <div class="caption">
          <i class="icon-equalizer font-red-sunglo"></i>
          <span class="caption-subject font-red-sunglo bold uppercase">Machine</span>
          <span class="caption-helper">enter machine info</span>
      </div>
  </div>

  <div class="portlet-body">
      <!-- BEGIN FORM-->
        <form id="form_add_machine" class="form-horizontal form_validation" method="post" action="index.php?page=add_machine">
            <div class="form-body">
                <div class="alert alert-danger display-hide">
                    <button class="close" data-close="alert"></button> You have some form errors. Please check below.
                </div>
                <div class="alert alert-success display-hide">
                    <button class="close" data-close="alert"></button> Your form validation is successful!
                </div>

                <div class="form-group">
                    <label class="col-md-3 control-label">Machine Name</label>
                    <div class="col-md-4">
                        <input type="text" name="mac_name" class="form-control" placeholder="Machine Name" value="<?=$mac_info["mac_name"]?>">
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-3 control-label">Type</label>
                    <div class="col-md-4">
                        <input type="text" name="mac_type" class="form-control" placeholder="Type" value="<?=$mac_info["mac_type"]?>">
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-3 control-label">Registration Number</label>
                    <div class="col-md-4">
                        <input type="text" name="mac_reg_no" class="form-control" placeholder="Registration Number" value="<?=$mac_info["mac_reg_no"]?>">
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-3 control-label">Color</label>
                    <div class="col-md-4">
                        <input type="text" name="mac_color" placeholder="Color" class="form-control" value="<?=$mac_info["mac_color"]?>">
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-3 control-label">Current Location</label>
                    <div class="col-md-4">
                        <input type="text" name="mac_location" class="form-control" placeholder="Current Location" value="<?=$mac_info["mac_location"]?>">
                    </div>
                </div>

                <div class="form-group last">
                    <label class="col-md-3 control-label">Purchased Date</label>
                    <div class="col-md-4">
                      <div class="input-group date date-picker" data-date-format="yyyy-mm-dd">
                          <input type="text" name="mac_purchased_on" class="form-control" placeholder="Purchased Date" value="<?=$mac_info["mac_purchased_on"]?>" readonly>
                          <span class="input-group-btn">
                              <button class="btn default" type="button">
                                  <i class="fa fa-calendar"></i>
                              </button>
                          </span>
                      </div>
                    </div>
                </div>
            </div>
            <div class="form-actions">
                <div class="row">
                    <div class="col-md-offset-3 col-md-9">
                        <input type="hidden" name="form_add_machine" value="AddMachine">
                        <input type="hidden" name="mac_id" value="<?=$mac_info["mac_id"]?>">
                        <input type="hidden" name="mac_action" value="<?=$mac_info["mac_action"]?>">
                        <button type="submit" id="btn_add_machine" class="btn btn-circle green">Submit</button>
                    </div>
                </div>
            </div>
        </form>
      <!-- END FORM-->
  </div>
</div>

<script>
  var validation_rules = {
    mac_name: {
        minlength: 3,
        maxlength: 50,
        required: true
    },
    mac_type: {
      minlength: 3,
      maxlength: 50,
      required: true
    },
    mac_reg_no: {
      minlength: 3,
      maxlength: 50,
      required: true
    },
    mac_color: {
      minlength: 3,
      maxlength: 50,
      required: true
    },
    mac_location: {
      minlength: 3,
      maxlength: 50,
      required: true
    },
    mac_purchased_on: {
      required: true,
      maxlength: 10
    }
  };
</script>