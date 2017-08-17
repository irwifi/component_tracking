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
            <option value="<?=$machine['mac_id']?>" <? if($machine['mac_id'] == $log_info["log_machine_id"]) {echo "selected=true";}?>><?=$machine['mac_name']?></option>
          <? }?>
        </select>
      </div>
      <div class="datepicker"><span class="label">Entry Date</span><input type="text" name="log_entry_on" placeholder="Entry Date" value="<?=$log_info["log_entry_on"]?>"></div>
      <div><span class="label">Hours</span><input type="text" name="log_hours" placeholder="Hours" value="<?=$log_info["log_hours"]?>"></div>
      <div><span class="label">Entered By</span><input type="text" name="log_entry_by" placeholder="Entered By" value="<?=$log_info["log_entry_by"]?>"></div>
      <input type="hidden" name="form_hour_log_entry" value="HourLogEntry">
      <input type="hidden" name="log_id" value="<?=$log_info["log_id"]?>">
      <input type="hidden" name="log_action" value="<?=$log_info["log_action"]?>">
      <input type="button" id="btn_hour_log_entry" value="<?=$log_info["log_button"]?>">
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