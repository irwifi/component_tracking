<?
  if(isset($_POST["form_component_fitting"]) && $_POST["form_component_fitting"] === "ComponentFitting") {
    if(!empty($_POST["cmp_id"])) {
      $stmt = $conn->prepare("UPDATE tbl_component SET cmp_status = 2, cmp_fitted_on = :fitted_on, cmp_fitted_by = :fitted_by, cmp_machine_id = :mac_id, cmp_fitted_hour = :fitted_hour WHERE cmp_id = :cmp_id");
      $stmt->bindParam(':cmp_id', $_POST["cmp_id"]);
      $stmt->bindParam(':fitted_on', $_POST["cmp_fitted_on"]);
      $stmt->bindParam(':fitted_by', $_POST["cmp_fitted_by"]);
      $stmt->bindParam(':mac_id', $_POST["mac_id"]);
      $stmt->bindParam(':fitted_hour', $_POST["fitted_hour"]);
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

<div>
  <div class="form_box">
    <ul class="err_box">
      <li>Enter complete detail</li>
    </ul>

    Enter component fitting detail
    <form id="form_component_fitting" method="post" action="index.php?page=component_fitting">
      <div>
        <span class="label">Select Component</span>
        <select name="cmp_id">
          <option value="0">Select the component</option>
          <? foreach($cmp_list as $component) {?>
            <option value="<?=$component['cmp_id']?>"><?=$component['cmp_name']?></option>
          <? }?>
        </select>
      </div>

      <div>
        <span class="label">Select Machine</span>
        <select name="mac_id">
          <option value="0">Select the machine</option>
          <? foreach($mac_list as $machine) {?>
            <option value="<?=$machine['mac_id']?>"><?=$machine['mac_name']?></option>
          <? }?>
        </select>
      </div>

      <div><span class="label">Reading on hour meter</span><input type="text" name="cmp_fitted_hour" placeholder="Hour Meter Reading"></div>
      <div><span class="label">Fitted Date</span><input type="text" name="cmp_fitted_on" placeholder="Fitted Date"></div>
      <div><span class="label">Fitted By</span><input type="text" name="cmp_fitted_by" placeholder="Fitted By"></div>
      <div>
        <input type="hidden" name="form_component_fitting" value="ComponentFitting">
        <input type="button" id="btn_component_fitting" value="Fit Component">
      </div>
    </form>
  </div>
</div>

<script>
  $(() => {
    $("#btn_component_fitting").on("click", () => {
      $(".err_box").hide();
      if($("#form_component_fitting select[name='cmp_id']").val() === "0" || $("#form_component_fitting select[name='mac_id']").val() === "0" || $("#form_component_fitting input[name='cmp_fitted_hour']").val() === "" || $("#form_component_fitting input[name='cmp_fitted_on']").val() === "" || $("#form_component_fitting input[name='cmp_fitted_by']").val() === "") {
        $(".err_box").show();
      } else {
        $("#form_component_fitting").submit();
      }
    });
  });
</script>