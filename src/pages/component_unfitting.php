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

<div>
  <div class="form_box">
    <ul class="err_box">
      <li>Enter complete detail</li>
    </ul>

    Enter component unfitting detail
    <form id="form_component_unfitting" method="post" action="index.php?page=component_unfitting">
      <div>
      <div>
        <span class="label">Select Machine</span>
        <select name="mac_id">
          <option value="0">Select the machine</option>
          <? foreach($mac_list as $machine) {?>
            <option value="<?=$machine['mac_id']?>"><?=$machine['mac_name']?></option>
          <? }?>
        </select>
      </div>

        <span class="label">Select Component</span>
        <span class="machine_first">Select Machine First</span>
        <select name="cmp_id" class="hide">
          <option value="0">Select the component</option>
          <? foreach($cmp_list as $component) {?>
            <option value="<?=$component['cmp_id']?>" data-mac="<?=$component['cmp_machine_id']?>"><?=$component['cmp_name']?></option>
          <? }?>
        </select>
      </div>

      <div class="datepicker"><span class="label">Component Expired Date</span><input type="text" name="cmp_expired_on" placeholder="Expired Date"></div>
      <div><span class="label">Defect Type</span><input type="text" name="cmp_defect_type" placeholder="Defect Type"></div>
      <div><span class="label">Removed By</span><input type="text" name="cmp_removed_by" placeholder="Removed By"></div>
      <div><span class="label">Reading on hour meter</span><input type="text" name="cmp_expired_hour" placeholder="Hour Meter Reading"></div>
      <div>
        <input type="hidden" name="form_component_unfitting" value="ComponentUnfitting">
        <input type="button" id="btn_component_unfitting" value="Unfit Component">
      </div>
    </form>
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

    $("#btn_component_unfitting").on("click", () => {
      $(".err_box").hide();
      if($("#form_component_unfitting select[name='mac_id']").val() === "0" || ($("#form_component_unfitting select[name='cmp_id']").length === 0 || $("#form_component_unfitting select[name='cmp_id']").val() === "0") || $("#form_component_unfitting select[name='cmp_expired_on']").val() === "" || $("#form_component_unfitting input[name='cmp_defect_type']").val() === "" || $("#form_component_unfitting input[name='cmp_removed_by']").val() === "" || $("#form_component_unfitting input[name='cmp_expired_hour']").val() === "") {
        $(".err_box").show();
      } else {
        $("#form_component_unfitting").submit();
      }
    });
  });
</script>