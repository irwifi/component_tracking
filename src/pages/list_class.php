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
        <th>SN</th>
        <th>Component Class Name</th>
        <th>Supplier</th>
        <th>Expected Life (in Hours)</th>
        <th>Action</th>
      </tr>
    </thead>

    <tbody>
      <? foreach($cls_list as $class) {?>
          <tr>
            <td></td>
            <td><?=$class["cls_name"]?></td>
            <td><?=$class["cls_supplier"]?></td>
            <td><?=$class["cls_life"]?></td>
            <td>
              <input type="button" value="Edit Detail">
              <form class="button_form" id="form_cls_del_<?=$class["cls_id"]?>" method="post" action="index.php?page=list_class">
                <input type="hidden" name="form_cls_del" value="ClassDelete">
                <input type="hidden" name="cls_id" value="<?=$class["cls_id"]?>">
                <input type="button" value="Delete" class="delete_class" data-id="<?=$class["cls_id"]?>">
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
      $(this).attr({"disabled": true});
      $("#form_cls_del_" + $(this).attr("data-id")).submit();
    });
  });
</script>