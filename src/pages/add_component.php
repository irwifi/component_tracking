<?
  if(isset($_POST["form_add_component"]) && $_POST["form_add_component"] === "AddComponent") {
    if(!empty($_POST["cmp_name"])) {
      $stmt = $conn->prepare("INSERT INTO tbl_component (cmp_class_id, cmp_name, cmp_type, cmp_vendor, cmp_arrival_on) VALUES (:cmp_class_id, :cmp_name, :cmp_type, :cmp_vendor, :cmp_arrival_on)");
      $stmt->bindParam(':cmp_class_id', $_POST["cmp_class_id"]);
      $stmt->bindParam(':cmp_name', $_POST["cmp_name"]);
      $stmt->bindParam(':cmp_type', $_POST["cmp_type"]);
      $stmt->bindParam(':cmp_vendor', $_POST["cmp_vendor"]);
      $stmt->bindParam(':cmp_arrival_on', $_POST["cmp_arrival_on"]);
      $inserted = $stmt->execute();

      if($inserted > 0) {
        $action_title = "COMPONENT ADDED";
        $action_msg = "1 new Component added";
        $_SESSION["alert"] = "success";
        $_SESSION["alert_title"] = $action_title;
        $_SESSION["alert_msg"] = $action_msg;
        header("Location: index.php?page=list_component");
      }
      // there was some error
    } else {
      // send error message
    }
    exit;
  } else {
    $page_title = "Add New Component";

    $stmt = $conn->prepare("SELECT cls_id, cls_name FROM tbl_class");
    $stmt->execute();
    $cls_list = $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $cls_list = $stmt->fetchAll();
  }
?>

<div class="portlet light bordered">
  <div class="portlet-title">
      <div class="caption">
          <i class="icon-equalizer font-red-sunglo"></i>
          <span class="caption-subject font-red-sunglo bold uppercase">Component</span>
          <span class="caption-helper">enter component info</span>
      </div>
  </div>

  <div class="portlet-body">
      <!-- BEGIN FORM-->
        <form id="form_add_component" class="form-horizontal form_validation" method="post" action="index.php?page=add_component">
            <div class="form-body">
                <div class="alert alert-danger display-hide">
                    <button class="close" data-close="alert"></button> You have some form errors. Please check below.
                </div>
                <div class="alert alert-success display-hide">
                    <button class="close" data-close="alert"></button> Your form validation is successful!
                </div>

                <div class="form-group">
                    <label class="col-md-3 control-label">Component Name</label>
                    <div class="col-md-4">
                        <input type="text" name="cmp_name" class="form-control" placeholder="Component Name">
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-3 control-label">Component Class</label>
                    <div class="col-md-4">
                      <select class="form-control" name="cmp_class_id">
                        <option value="">Select the Class</option>
                        <? foreach($cls_list as $class) {?>
                          <option value="<?=$class['cls_id']?>"><?=$class['cls_name']?></option>
                        <? }?>
                      </select>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-3 control-label">Component Type (Optional)</label>
                    <div class="col-md-4">
                        <input type="text" name="cmp_type" class="form-control" placeholder="Component Type">
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-3 control-label">Vendor</label>
                    <div class="col-md-4">
                        <input type="text" name="cmp_vendor" class="form-control" placeholder="Vendor">
                    </div>
                </div>

                <div class="form-group last">
                    <label class="col-md-3 control-label">Arrived Date</label>
                    <div class="col-md-4">
                      <div class="input-group date date-picker" data-date-format="yyyy-mm-dd">
                          <input type="text" name="cmp_arrival_on" class="form-control" placeholder="Arrived Date" readonly>
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
                        <input type="hidden" name="form_add_component" value="AddComponent">
                        <input type="hidden" name="cmp_id" value="<?=$cmp_info["cmp_id"]?>">
                        <input type="hidden" name="cmp_action" value="<?=$cmp_info["cmp_action"]?>">
                        <button type="submit" id="btn_add_component" class="btn btn-circle green">Submit</button>
                    </div>
                </div>
            </div>
        </form>
      <!-- END FORM-->
  </div>
</div>

<script>
  var validation_rules = {
    cmp_name: {
        minlength: 3,
        maxlength: 50,
        required: true
    },
    cmp_class_id: {
      maxlength: 5,
      required: true,
      number: true
    },
    cmp_vendor: {
      minlength: 3,
      maxlength: 50,
      required: true
    },
    cmp_arrival_on: {
      minlength: 3,
      maxlength: 10,
      required: true
    }
  };
</script>