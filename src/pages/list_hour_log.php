<?
  if(isset($_POST["form_log_del"]) && $_POST["form_log_del"] === "LogDelete") {
    $log_id = $_POST["log_id"];
    if(!empty($log_id)) {
      $stmt = $conn->prepare("DELETE FROM tbl_hour_log WHERE log_id = :log_id");
      $stmt->bindParam(':log_id', $log_id);
      $deleted = $stmt->execute();

      if($deleted > 0) {
        $_SESSION["message"] = "warning";
        $_SESSION[$_SESSION["message"] . "_msg"] = "1 hour log detail deleted";
      }
    }

    header("Location: index.php?page=list_hour_log");
    exit;
  } else {
    $page_title = "List of hour log records";

    $stmt = $conn->prepare("SELECT log_id, mac_name, log_entry_on, log_entry_by, log_hours FROM tbl_hour_log, tbl_machine WHERE mac_id = log_machine_id order by log_id");
    $stmt->execute();

    $log_list = $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $log_list = $stmt->fetchAll();
  }
?>

<div>
  <table class="main_table table table-bordered table-striped table-hover">
    <thead>
      <tr>
        <th>SN</th>
        <th>Machine</th>
        <th>Entry Date</th>
        <th>Entered By</th>
        <th>Hours</th>
        <th>Action</th>
      </tr>
    </thead>

    <tbody>
      <? foreach($log_list as $log) {?>
          <tr>
            <td></td>
            <td><?=$log["mac_name"]?></td>
            <td><?=$log["log_entry_on"]?></td>
            <td><?=$log["log_entry_by"]?></td>
            <td><?=$log["log_hours"]?></td>
            <td>
              <input type="button" value="Edit Detail">
              <form class="button_form" id="form_log_del_<?=$log["log_id"]?>" method="post" action="index.php?page=list_hour_log">
                <input type="hidden" name="form_log_del" value="LogDelete">
                <input type="hidden" name="log_id" value="<?=$log["log_id"]?>">
                <input type="button" value="Delete" class="delete_log" data-id="<?=$log["log_id"]?>">
              </form>
            </td>
          </tr>
      <? }?>
    </tbody>
  </table>
</div>

<script>
  $(() => {
    $(".delete_log").on("click", function() {
       $('#myModal .modal-title').text("Log Record Delete Confirmation");
      $('#myModal .modal-body p').text("Are you sure you want to delete this log record?");
      $('#myModal').modal();
      var delete_id = $(this).attr("data-id");
      $("#myModal .modal_action").on("click", function() {
        $('#myModal').hide();
        $("#form_log_del_" + delete_id).submit();
      });
    });
  });
</script>