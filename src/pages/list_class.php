<?
  if(isset($_POST["form_cls_del"]) && $_POST["form_cls_del"] === "ClassDelete") {
    $cls_id = $_POST["cls_id"];
    if(!empty($cls_id)) {
      $stmt = $conn->prepare("DELETE FROM tbl_class WHERE cls_id = :cls_id");
      $stmt->bindParam(':cls_id', $cls_id);
      $deleted = $stmt->execute();

      if($deleted > 0) {
        $_SESSION["message"] = "warning";
        $_SESSION[$_SESSION["message"] . "_msg"] = "1 Component Class detail deleted";
      }
    }

    header("Location: index.php?page=list_class");
    exit;
  } else {
    $page_title = "List of Component Classes";

    $stmt = $conn->prepare("SELECT cls_id, cls_name, cls_supplier, cls_life FROM tbl_class order by cls_id");
    $stmt->execute();

    $cls_list = $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $cls_list = $stmt->fetchAll();
  }
?>

<div>
  <table class="main_table table table-bordered table-striped table-hover">
    <thead>
      <tr>
        <th>#</th>
        <th>Component Class Name</th>
        <th>Supplier</th>
        <th>Expected Life (in Hours)</th>
        <th>Action</th>
      </tr>
    </thead>

    <tbody>
      <? $count =0; foreach($cls_list as $class) {$count++; ?>
          <tr>
            <td><?=$count?></td>
            <td><?=$class["cls_name"]?></td>
            <td><?=$class["cls_supplier"]?></td>
            <td><?=$class["cls_life"]?></td>
            <td>
              <a href="index.php?page=add_class&action=edit&cls_id=<?=$class["cls_id"]?>" class="btn btn-outline btn-circle btn-sm green"><i class="fa fa-edit"></i> Edit</a>

              <form class="button_form inline" id="form_cls_del_<?=$class["cls_id"]?>" method="post" action="index.php?page=list_class">
                <input type="hidden" name="form_cls_del" value="ClassDelete">
                <input type="hidden" name="cls_id" value="<?=$class["cls_id"]?>">
                <a href="javascript:;" class="btn btn-outline btn-circle dark btn-sm black delete_class" data-id="<?=$class["cls_id"]?>"><i class="fa fa-trash-o"></i> Delete </a>
              </form>
            </td>
          </tr>
      <? }?>
    </tbody>
  </table>
</div>

<script>
  $(() => {
    $(".delete_class").on("click", function() {
       $('#myModal .modal-title').text("Component Class Delete Confirmation");
      $('#myModal .modal-body p').text("Are you sure you want to delete all the details of this component class?");
      $('#myModal').modal();
      var delete_id = $(this).attr("data-id");
      $("#myModal .modal_action").on("click", function() {
        $('#myModal').hide();
        $("#form_cls_del_" + delete_id).submit();
      });
    });
  });
</script>