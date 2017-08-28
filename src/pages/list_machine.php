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

    $stmt = $conn->prepare("SELECT mac_id, mac_name, mac_type, mac_reg_no, mac_hours FROM tbl_machine order by mac_id");
    $stmt->execute();

    $mac_list = $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $mac_list = $stmt->fetchAll();
  }
?>

<div>
  <table class="main_table table table-bordered table-striped table-hover">
    <thead>
      <tr>
        <th>#</th>
        <th>Machine</th>
        <th>Type</th>
        <th>Registration Number</th>
        <th>Hours Run</th>
        <th>Action</th>
      </tr>
    </thead>

    <tbody>
      <? $count =0; foreach($mac_list as $machine) {$count++; ?>
          <tr>
            <td><?=$count?></td>
            <td><?=$machine["mac_name"]?></td>
            <td><?=$machine["mac_type"]?></td>
            <td><?=$machine["mac_reg_no"]?></td>
            <td><?=$machine["mac_hours"]?></td>
            <td>
              <a href="index.php?page=machine_detail&mac_id=<?=$machine["mac_id"]?>" class="btn btn-outline btn-circle green btn-sm purple"><i class="fa fa-share"></i> View </a>

              <form class="button_form inline" id="form_mac_del_<?=$machine["mac_id"]?>" method="post" action="index.php?page=list_machine">
                <input type="hidden" name="form_mac_del" value="MachineDelete">
                <input type="hidden" name="mac_id" value="<?=$machine["mac_id"]?>">
                <a href="javascript:;" class="btn btn-outline btn-circle dark btn-sm black delete_machine" data-id="<?=$machine["mac_id"]?>"><i class="fa fa-trash-o"></i> Delete </a>
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
      $('#myModal .modal-title').text("Machine Delete Confirmation");
      $('#myModal .modal-body p').text("Are you sure you want to delete all the details of this machine?");
      $('#myModal').modal();
      var delete_id = $(this).attr("data-id");
      $("#myModal .modal_action").on("click", function() {
        $('#myModal').hide();
        $("#form_mac_del_" + delete_id).submit();
      });
    });
  });
</script>