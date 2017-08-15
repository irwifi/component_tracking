<?
  if(isset($_POST["from_add_component"]) && $_POST["from_add_component"] === "AddComponent") {
    if(!empty($_POST["cmp_name"])) {
      $stmt = $conn->prepare("INSERT INTO tbl_component (cmp_class_id, cmp_name, cmp_type, cmp_vendor, cmp_arrival_on) VALUES (:cmp_class_id, :cmp_name, :cmp_type, :cmp_vendor, :cmp_arrival_on)");
      $stmt->bindParam(':cmp_class_id', $_POST["cmp_class_id"]);
      $stmt->bindParam(':cmp_name', $_POST["cmp_name"]);
      $stmt->bindParam(':cmp_type', $_POST["cmp_type"]);
      $stmt->bindParam(':cmp_vendor', $_POST["cmp_vendor"]);
      $stmt->bindParam(':cmp_arrival_on', $_POST["cmp_arrival_on"]);
      $inserted = $stmt->execute();

      if($inserted > 0) {
        $_SESSION["message"] = "success";
        $_SESSION[$_SESSION["message"] . "_msg"] = "1 New Component detail added";
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

<div>
  <div class="form_box">
    <ul class="err_box">
      <li>Enter complete component detail</li>
    </ul>

    Enter Component detail
    <form id="form_add_component" method="post" action="index.php?page=add_component">
      <div><span class="label">Component Name</span><input type="text" name="cmp_name" placeholder="Component Name"></div>
      <div>
        <span class="label">Component Class</span>
        <select name="cmp_class_id">
          <option value="0">Select the Class</option>
          <? foreach($cls_list as $class) {?>
            <option value="<?=$class['cls_id']?>"><?=$class['cls_name']?></option>
          <? }?>
        </select>
      </div>
      <div><span class="label">Component Type (Optional)</span><input type="text" name="cmp_type" placeholder="Component Type"></div>
      <div><span class="label">Vendor</span><input type="text" name="cmp_vendor" placeholder="Vendor"></div>
      <div><span class="label">Arrived Date</span><input type="text" name="cmp_arrival_on" placeholder="Arrived Date"></div>
      <div>
        <input type="hidden" name="from_add_component" value="AddComponent">
        <input type="button" id="btn_add_component" value="Add Component">
      </div>
    </form>
  </div>
</div>

<script>
  $(() => {
    $("#btn_add_component").on("click", () => {
      $(".err_box").hide();
      if($("#form_add_component select[name='cmp_class_id']").val() === "0" || $("#form_add_component input[name='cmp_name']").val() === "" || $("#form_add_component input[name='cmp_vendor']").val() === "" || $("#form_add_component input[name='cmp_arrival_on']").val() === "") {
        $(".err_box").show();
      } else {
        $("#form_add_component").submit();
      }
    });
  });
</script>