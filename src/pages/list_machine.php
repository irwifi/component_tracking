<?
  if(isset($_POST["form_mac_del"]) && $_POST["form_mac_del"] === "MachineDelete") {
    $mac_id = $_POST["mac_id"];
    if(!empty($mac_id)) {
      $stmt = $conn->prepare("DELETE FROM tbl_machine WHERE mac_id = :mac_id");
      $stmt->bindParam(':mac_id', $mac_id);
      $deleted = $stmt->execute();

      if($deleted > 0) {
        $_SESSION["message"] = "warning";
        $_SESSION[$_SESSION["message"] . "_msg"] = "1 Machine detail deleted";
      }
    }

    header("Location: index.php?page=list_machine");
    exit;
  } else {
    $page_title = "List of Machines";

    $stmt = $conn->prepare("SELECT mac_id, mac_name, mac_hours FROM tbl_machine");
    $stmt->execute();

    $mac_list = $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $mac_list = $stmt->fetchAll();
  }
?>

<div>
  <table class="main_table table table-bordered table-striped table-hover">
    <thead>
      <tr>
        <th>SN</th>
        <th>Machine</th>
        <th>Hours Run</th>
        <th>Action</th>
      </tr>
    </thead>

    <tbody>
      <? foreach($mac_list as $machine) {?>
          <tr>
            <td></td>
            <td><?=$machine["mac_name"]?></td>
            <td><?=$machine["mac_hours"]?></td>
            <td>
              <input type="button" value="Edit Detail">
              <form class="button_form" id="form_mac_del_<?=$machine["mac_id"]?>" method="post" action="index.php?page=list_machine">
                <input type="hidden" name="form_mac_del" value="MachineDelete">
                <input type="hidden" name="mac_id" value="<?=$machine["mac_id"]?>">
                <input type="button" value="Delete" class="delete_machine" data-id="<?=$machine["mac_id"]?>">
              </form>
            </td>
          </tr>
      <? }?>
    </tbody>
  </table>
</div>

<script>
  $(() => {
    $(".delete_machine").on("click", function() {
      $(this).attr({"disabled": true});
      $("#form_mac_del_" + $(this).attr("data-id")).submit();
    });
  });
</script>