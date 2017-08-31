<?
  if(isset($_POST["form_component_fitting"]) && $_POST["form_component_fitting"] === "ComponentFitting") {
    if(!empty($_POST["cmp_id"])) {
      $stmt = $conn->prepare("UPDATE tbl_component SET cmp_status = 2, cmp_fitted_on = :fitted_on, cmp_fitted_by = :fitted_by, cmp_machine_id = :mac_id, cmp_fitted_hour = :fitted_hour WHERE cmp_id = :cmp_id");
      $stmt->bindParam(':cmp_id', $_POST["cmp_id"]);
      $stmt->bindParam(':fitted_on', $_POST["cmp_fitted_on"]);
      $stmt->bindParam(':fitted_by', $_POST["cmp_fitted_by"]);
      $stmt->bindParam(':mac_id', $_POST["mac_id"]);
      $stmt->bindParam(':fitted_hour', $_POST["cmp_fitted_hour"]);
      $updated = $stmt->execute();

      if($updated > 0) {
        $_SESSION["message"] = "success";
        $_SESSION[$_SESSION["message"] . "_msg"] = "1 Component fitted to the machine";
        header("Location: index.php?page=list_component&status=active");
      }
      // there was some error
    } else {
      // send error message
    }
    exit;
  } else {
    $page_title = "Component Fitting";

    $stmt = $conn->prepare("SELECT mac_id, mac_name FROM tbl_machine");
    $stmt->execute();
    $mac_list = $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $mac_list = $stmt->fetchAll();

    $stmt = $conn->prepare("SELECT cmp_id, cmp_name FROM tbl_component WHERE cmp_status = 1");
    $stmt->execute();
    $cmp_list = $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $cmp_list = $stmt->fetchAll();
  }
?>

<div class="portlet light bordered">
  <div class="portlet-title">
      <div class="caption">
          <i class="icon-equalizer font-red-sunglo"></i>
          <span class="caption-subject font-red-sunglo bold uppercase">Component Fitting</span>
          <span class="caption-helper">enter fitting info</span>
      </div>
  </div>

  <div class="portlet-body">
      <!-- BEGIN FORM-->
        <form id="form_component_fitting" class="form-horizontal" method="post" action="index.php?page=component_fitting">
            <div class="form-body">
                <div class="alert alert-danger display-hide">
                    <button class="close" data-close="alert"></button> You have some form errors. Please check below.
                </div>
                <div class="alert alert-success display-hide">
                    <button class="close" data-close="alert"></button> Your form validation is successful!
                </div>

                <div class="form-group">
                    <label class="col-md-3 control-label">Component</label>
                    <div class="col-md-4">
                      <select class="form-control" name="cmp_id">
                        <option value="">Select the component</option>
                        <? foreach($cmp_list as $component) {?>
                          <option value="<?=$component['cmp_id']?>"><?=$component['cmp_name']?></option>
                        <? }?>
                      </select>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-3 control-label">Machine</label>
                    <div class="col-md-4">
                      <select class="form-control" name="mac_id">
                        <option value="">Select the Machine</option>
                        <? foreach($mac_list as $machine) {?>
                          <option value="<?=$machine['mac_id']?>"><?=$machine['mac_name']?></option>
                        <? }?>
                      </select>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-3 control-label">Reading on hour meter</label>
                    <div class="col-md-4">
                        <input type="text" name="cmp_fitted_hour" class="form-control" placeholder="Hour Meter Reading">
                    </div>
                </div>

                <div class="form-group last">
                    <label class="col-md-3 control-label">Fitted Date</label>
                    <div class="col-md-4">
                      <div class="input-group date date-picker" data-date-format="yyyy-mm-dd">
                          <input type="text" name="cmp_fitted_on" class="form-control" placeholder="Fitted Date" readonly>
                          <span class="input-group-btn">
                              <button class="btn default" type="button">
                                  <i class="fa fa-calendar"></i>
                              </button>
                          </span>
                      </div>
                    </div>
                </div>

                <div class="form-group last">
                    <label class="col-md-3 control-label">Fitted By</label>
                    <div class="col-md-4">
                        <input type="text" name="cmp_fitted_by" class="form-control" placeholder="Fitted By">
                    </div>
                </div>
            </div>

            <div class="form-actions">
                <div class="row">
                    <div class="col-md-offset-3 col-md-9">
                        <input type="hidden" name="form_component_fitting" value="ComponentFitting">
                        <input type="hidden" name="cmp_id" value="<?=$cmp_info["cmp_id"]?>">
                        <input type="hidden" name="cmp_action" value="<?=$cmp_info["cmp_action"]?>">
                        <button type="submit" id="btn_component_fitting" class="btn btn-circle green">Submit</button>
                    </div>
                </div>
            </div>
        </form>
      <!-- END FORM-->
  </div>
</div>
