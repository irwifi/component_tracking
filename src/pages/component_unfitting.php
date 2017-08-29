<?
  if(isset($_POST["form_component_unfitting"]) && $_POST["form_component_unfitting"] === "ComponentUnfitting") {
    if(!empty($_POST["cmp_id"])) {
      $stmt = $conn->prepare("UPDATE tbl_component SET cmp_status = 5, cmp_expired_on = :cmp_expired_on, cmp_removed_by = :cmp_removed_by, cmp_defect_type = :cmp_defect_type, cmp_expired_hour = :cmp_expired_hour WHERE cmp_id = :cmp_id");
      $stmt->bindParam(':cmp_id', $_POST["cmp_id"]);
      $stmt->bindParam(':cmp_expired_on', $_POST["cmp_expired_on"]);
      $stmt->bindParam(':cmp_removed_by', $_POST["cmp_removed_by"]);
      $stmt->bindParam(':cmp_defect_type', $_POST["cmp_defect_type"]);
      $stmt->bindParam(':cmp_expired_hour', $_POST["cmp_expired_hour"]);
      $updated = $stmt->execute();

      if($updated > 0) {
        $_SESSION["message"] = "success";
        $_SESSION[$_SESSION["message"] . "_msg"] = "1 Component unfitted from the machine";
        header("Location: index.php?page=list_component&status=expired");
      }
      // there was some error
    } else {
      // send error message
    }
    exit;
  } else {
    $page_title = "Component Unfitting";

    $stmt = $conn->prepare("SELECT distinct mac_id, mac_name FROM tbl_machine, tbl_component where cmp_machine_id = mac_id and cmp_status = 2");
    $stmt->execute();
    $mac_list = $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $mac_list = $stmt->fetchAll();

    $stmt = $conn->prepare("SELECT cmp_id, cmp_name, cmp_machine_id FROM tbl_component WHERE cmp_status = 2");
    $stmt->execute();
    $cmp_list = $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $cmp_list = $stmt->fetchAll();
  }
?>

<div class="portlet light bordered">
  <div class="portlet-title">
      <div class="caption">
          <i class="icon-equalizer font-red-sunglo"></i>
          <span class="caption-subject font-red-sunglo bold uppercase">Component Unfitting</span>
          <span class="caption-helper">enter unfitting info</span>
      </div>
  </div>

  <div class="portlet-body">
      <!-- BEGIN FORM-->
        <form id="form_component_unfitting" class="form-horizontal" method="post" action="index.php?page=component_unfitting">
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
                      <select class="form-control" name="mac_id">
                        <option value="">Select the Machine</option>
                        <? foreach($mac_list as $machine) {?>
                          <option value="<?=$machine['mac_id']?>"><?=$machine['mac_name']?></option>
                        <? }?>
                      </select>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-3 control-label">Component</label>
                    <div class="col-md-4">
                      <select class="form-control" name="cmp_id">
                        <option value="">Select the Machine</option>
                        <? foreach($cmp_list as $component) {?>
                          <option value="<?=$component['cmp_id']?>"><?=$component['cmp_name']?></option>
                        <? }?>
                      </select>
                    </div>
                </div>

                <div class="form-group last">
                    <label class="col-md-3 control-label">Component Expired Date</label>
                    <div class="col-md-4">
                      <div class="input-group date date-picker" data-date-format="yyyy-mm-dd">
                          <input type="text" name="cmp_expired_on" class="form-control" placeholder="Expired Date" readonly>
                          <span class="input-group-btn">
                              <button class="btn default" type="button">
                                  <i class="fa fa-calendar"></i>
                              </button>
                          </span>
                      </div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-3 control-label">Defect Type</label>
                    <div class="col-md-4">
                        <input type="text" name="cmp_defect_type" class="form-control" placeholder="Defect Type">
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-3 control-label">Removed By</label>
                    <div class="col-md-4">
                        <input type="text" name="cmp_removed_by" class="form-control" placeholder="Removed By">
                    </div>
                </div>

                <div class="form-group last">
                    <label class="col-md-3 control-label">Reading on hour meter</label>
                    <div class="col-md-4">
                        <input type="text" name="cmp_expired_hour" class="form-control" placeholder="Hour Meter Reading">
                    </div>
                </div>
            </div>

            <div class="form-actions">
                <div class="row">
                    <div class="col-md-offset-3 col-md-9">
                        <input type="hidden" name="form_component_unfitting" value="ComponentUnfitting">
                        <input type="hidden" name="cmp_id" value="<?=$cmp_info["cmp_id"]?>">
                        <input type="hidden" name="cmp_action" value="<?=$cmp_info["cmp_id"]?>">
                        <button type="submit" id="btn_component_unfitting" class="btn btn-circle green">Submit</button>
                    </div>
                </div>
            </div>
        </form>
      <!-- END FORM-->
  </div>
</div>

<script>
  $(() => {
    $("#form_component_unfitting select[name='mac_id']").on("click", ()=>{
      $(".machine_first").hide();
        $("#form_component_unfitting select[name='cmp_id']").val("0");
       $("#form_component_unfitting select[name='cmp_id']").show();
       $("#form_component_unfitting select[name='cmp_id'] option").hide();
       $("#form_component_unfitting select[name='cmp_id'] option[data-mac=" + $("#form_component_unfitting select[name='mac_id']").val() + "]").show();
    });
  });
</script>