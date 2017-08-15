<?
  if(isset($_POST["form_hour_log_entry"]) && $_POST["form_hour_log_entry"] === "HourLogEntry") {
    if(!empty($_POST["log_machine_id"])) {
      $stmt = $conn->prepare("INSERT INTO tbl_hour_log (log_machine_id, log_entry_on, log_entry_by, log_hours) VALUES (:log_machine_id, :log_entry_on, :log_entry_by, :log_hours)");
      $stmt->bindParam(':log_machine_id', $_POST["log_machine_id"]);
      $stmt->bindParam(':log_entry_on', $_POST["log_entry_on"]);
      $stmt->bindParam(':log_entry_by', $_POST["log_entry_by"]);
      $stmt->bindParam(':log_hours', $_POST["log_hours"]);
      $inserted = $stmt->execute();

      if($inserted > 0) {
        $_SESSION["message"] = "success";
        $_SESSION[$_SESSION["message"] . "_msg"] = "1 new log detail added";

        $stmt = $conn->prepare("UPDATE tbl_machine SET mac_hours = mac_hours + :updated_hours WHERE mac_id = :mac_id");
        $stmt->bindParam(':updated_hours', $_POST["log_hours"]);
        $stmt->bindParam(':mac_id', $_POST["log_machine_id"]);
        $stmt->execute();

        $stmt = $conn->prepare("UPDATE tbl_component SET cmp_used_hours = cmp_used_hours + :updated_hours WHERE cmp_machine_id = :mac_id");
        $stmt->bindParam(':updated_hours', $_POST["log_hours"]);
        $stmt->bindParam(':mac_id', $_POST["log_machine_id"]);
        $stmt->execute();

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
  }
?>

<div>
  <div class="form_box">
    <ul class="err_box">
      <li>Enter complete detail</li>
    </ul>

    <form id="form_hour_log_entry" method="post" action="index.php?page=hour_log_entry">
      <div>Enter machine hour log</div>
      <div>
        <span class="label">Machine</span>
        <select name="log_machine_id">
          <option value="0">Select the Machine</option>
          <? foreach($mac_list as $machine) {?>
            <option value="<?=$machine['mac_id']?>"><?=$machine['mac_name']?></option>
          <? }?>
        </select>
      </div>
      <div><span class="label">Entry Date</span><input type="text" name="log_entry_on" placeholder="Entry Date"></div>
      <div><span class="label">Hours</span><input type="text" name="log_hours" placeholder="Hours"></div>
      <div><span class="label">Entered By</span><input type="text" name="log_entry_by" placeholder="Entered By"></div>
      <input type="hidden" name="form_hour_log_entry" value="HourLogEntry">
      <input type="button" id="btn_hour_log_entry" value="Log Hours">
    </form>
  </div>
</div>

<script>
  $(() => {
    $("#btn_hour_log_entry").on("click", () => {
      $(".err_box").hide();
      if($("#form_hour_log_entry select[name='log_machine_id'] option:selected").val() === "0" || $("#form_hour_log_entry input[name='log_entry_on']").val() === "" || $("#form_hour_log_entry input[name='log_hours']").val() === "" || $("#form_hour_log_entry input[name='log_entry_by']").val() === "") {
        $(".err_box").show();
      } else {
        $("#form_hour_log_entry").submit();
      }
    });
  });
</script>