<?
  if(isset($_POST["form_add_class"]) && $_POST["form_add_class"] === "AddClass") {
    if(!empty($_POST["cls_name"])) {
      if($_POST["cls_action"] === "add") {
        $stmt = $conn->prepare("INSERT INTO tbl_class (cls_name, cls_supplier, cls_life) VALUES (:cls_name, :cls_supplier, :cls_life)");
        $action_title = "COMPONENT CLASS ADDED";
        $action_msg = "1 new Component Class detail added";
      } else {
        $stmt = $conn->prepare("UPDATE tbl_class SET cls_name = :cls_name, cls_supplier = :cls_supplier, cls_life = :cls_life WHERE cls_id = :cls_id");
        $stmt->bindParam(':cls_id', $_POST["cls_id"]);
        $action_title = "COMPONENT CLASS EDITED";
        $action_msg = "1 Component Class detail edited";
      }

      $stmt->bindParam(':cls_name', $_POST["cls_name"]);
      $stmt->bindParam(':cls_supplier', $_POST["cls_supplier"]);
      $stmt->bindParam(':cls_life', $_POST["cls_life"]);
      $inserted = $stmt->execute();

      if($inserted > 0) {
        $_SESSION["alert"] = "success";
        $_SESSION["alert_title"] = $action_title;
        $_SESSION["alert_msg"] = $action_msg;
        header("Location: index.php?page=list_class");
      }
      // there was some error
    } else {
      // send error message
    }
    exit;
  } else {
    $page_title = "Add New Component Class";
    $cls_info = ["cls_name"=>"", "cls_supplier"=>"", "cls_life"=>"", "cls_action"=>"add", "cls_button" => "Add Class"];

    if(isset($_GET["action"]) && $_GET["action"] === "edit") {
      $page_title = "Edit Component Class Detail";
      $stmt = $conn->prepare("SELECT cls_id, cls_name, cls_supplier, cls_life FROM tbl_class WHERE cls_id = :cls_id");
      $stmt->bindParam(':cls_id', $_GET["cls_id"]);
      $stmt->execute();
      $cls_info = $stmt->fetch();
      $cls_info["cls_action"] = "edit";
      $cls_info["cls_button"] = "Edit Class";
    }
  }
?>

<div class="portlet light bordered">
  <div class="portlet-title">
      <div class="caption">
          <i class="icon-equalizer font-red-sunglo"></i>
          <span class="caption-subject font-red-sunglo bold uppercase">Component Class</span>
          <span class="caption-helper">enter component class info</span>
      </div>
  </div>

  <div class="portlet-body">
      <!-- BEGIN FORM-->
        <form id="form_add_class" class="form-horizontal form_validation" method="post" action="index.php?page=add_class">
            <div class="form-body">
                <div class="alert alert-danger display-hide">
                    <button class="close" data-close="alert"></button> You have some form errors. Please check below.
                </div>
                <div class="alert alert-success display-hide">
                    <button class="close" data-close="alert"></button> Your form validation is successful!
                </div>

                <div class="form-group">
                    <label class="col-md-3 control-label">Component Class Name</label>
                    <div class="col-md-4">
                        <input type="text" name="cls_name" class="form-control" placeholder="Class Name" value="<?=$cls_info["cls_name"]?>">
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-3 control-label">Component Supplier</label>
                    <div class="col-md-4">
                        <input type="text" name="cls_supplier" class="form-control" placeholder="Supplier" value="<?=$cls_info["cls_supplier"]?>">
                    </div>
                </div>

                <div class="form-group last">
                    <label class="col-md-3 control-label">Expected Life</label>
                    <div class="col-md-4">
                        <input type="text" name="cls_life" class="form-control" placeholder="Expected Life (in Hours)" value="<?=$cls_info["cls_life"]?>">
                    </div>
                </div>
            </div>
            <div class="form-actions">
                <div class="row">
                    <div class="col-md-offset-3 col-md-9">
                        <input type="hidden" name="form_add_class" value="AddClass">
                        <input type="hidden" name="cls_id" value="<?=$cls_info["cls_id"]?>">
                        <input type="hidden" name="cls_action" value="<?=$cls_info["cls_action"]?>">
                        <button type="submit" id="btn_add_class" class="btn btn-circle green">Submit</button>
                    </div>
                </div>
            </div>
        </form>
      <!-- END FORM-->
  </div>
</div>

<script>
  var validation_rules = {
    cls_name: {
        minlength: 3,
        maxlength: 50,
        required: true
    },
    cls_supplier: {
      minlength: 3,
      maxlength: 50,
      required: true
    },
    cls_life: {
      maxlength: 5,
      required: true,
      number: true
    }
  };
</script>