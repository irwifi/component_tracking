<?
  if(isset($_POST["form_cmp_del"]) && $_POST["form_cmp_del"] === "ComponentDelete") {
    $cmp_id = $_POST["cmp_id"];
    if(!empty($cmp_id)) {
      $stmt = $conn->prepare("DELETE FROM tbl_component WHERE cmp_id = :cmp_id");
      $stmt->bindParam(':cmp_id', $cmp_id);
      $deleted = $stmt->execute();

      if($deleted > 0) {
        $_SESSION["message"] = "warning";
        $_SESSION[$_SESSION["message"] . "_msg"] = "1 Component detail deleted";
      }
    }

    header("Location: index.php?page=list_component");
    exit;
  } else {
    $page_title = "List of Components";
    $status_cond = "";
    $cond_select = "";
    $cond_table = "";
    $listing_type = "";

    if(isset($_GET["status"])) {
      $listing_type = $_GET["status"];
      switch($listing_type) {
        case "unfitted":
          $status_cond = " and cmp_status = 1";
          $page_title = "List of Unfitted Components";
          $cond_select = ", c.cmp_arrival_on";
          break;
        case "active":
          $status_cond = " and cmp_status = 2";
          $page_title = "List of Active Components";
          $cond_select = ", c.cmp_fitted_on, m.mac_name";
          $cond_table = ", tbl_machine m";
          break;
        case "expiring":
          $status_cond = " and (cmp_status = 3 or cmp_status = 4)";
          $page_title = "List of Expiring Components";
          $cond_select = ", cl.cls_life, m.mac_name";
          $cond_table = ", tbl_machine m";
          break;
        case "expired":
          $status_cond = " and cmp_status = 5";
          $page_title = "List of Expired Components";
          $cond_select = ", c.cmp_expired_on";
          break;
      }
    }

    $qry = "SELECT c.cmp_id, cl.cls_name, c.cmp_name, c.cmp_type, c.cmp_vendor, c.cmp_status " . $cond_select . " FROM tbl_component c, tbl_class cl " . $cond_table . " where cl.cls_id = c.cmp_class_id" . $status_cond . " order by cmp_id";
    $stmt = $conn->prepare($qry);
    $stmt->execute();

    $cmp_list = $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $cmp_list = $stmt->fetchAll();
  }
?>

<div>
  <table class="main_table table table-bordered table-striped table-hover">
    <thead>
      <tr>
        <th>SN</th>
        <th>Component Id</th>
        <th>Component Name</th>
        <th>Component Class</th>
        <th>Component Type</th>
        <th>Vendor</th>
        <? switch($listing_type) {
          case "unfitted":
            ?>
              <th>Arrived Date</th>
            <?
            break;
          case "fitted":
            ?>
              <th>Fitted Date</th>
              <th>Machine</th>
            <?
            break;
          case "expiring":
            ?>
              <th>Expected Life</th>
              <th>Machine</th>
            <?
            break;
          case "expired":
            ?>
              <th>Expired Date</th>
            <?
            break;
        }?>
        <th>Status</th>
      </tr>
    </thead>

    <tbody>
      <? foreach($cmp_list as $component) {?>
          <tr>
            <td></td>
            <td>CMP<?=$component["cmp_id"]?></td>
            <td><?=$component["cmp_name"]?></td>
            <td><?=$component["cls_name"]?></td>
            <td><?=$component["cmp_type"]?></td>
            <td><?=$component["cmp_vendor"]?></td>

            <? switch($listing_type) {
              case "unfitted":
                ?>
                  <td><?=$component["cmp_arrival_on"]?></td>
                <?
                break;
              case "fitted":
                ?>
                  <td><?=$component["cmp_fitted_on"]?></td>
                  <td><?=$component["mac_name"]?></td>
                <?
                break;
              case "expiring":
                ?>
                  <td><?=$component["cls_life"]?></td>
                  <td><?=$component["mac_name"]?></td>
                <?
                break;
              case "expired":
                ?>
                  <td><?=$component["cmp_expired_on"]?></td>
                <?
                break;
            }?>

            <td><? switch($component["cmp_status"]) {
              case 1:
                echo "Unfitted";
                break;
              case 1:
                echo "Fitted";
                break;
              case 1:
                echo "Nearing Expected Life";
                break;
              case 1:
                echo "Expected Life Crossed";
                break;
              case 1:
                echo "Expired";
                break;
            }

            ?></td>
            <td>
              <a href="index.php?page=component_detail&cmp_id=<?=$component["cmp_id"]?>"><input type="button" value="Show Detail"></a>
              <form class="button_form" id="form_cmp_del_<?=$component["cmp_id"]?>" method="post" action="index.php?page=list_component">
                <input type="hidden" name="form_cmp_del" value="ComponentDelete">
                <input type="hidden" name="cmp_id" value="<?=$component["cmp_id"]?>">
                <input type="button" value="Delete" class="delete_component" data-id="<?=$component["cmp_id"]?>">
              </form>
            </td>
          </tr>
      <? }?>
    </tbody>
  </table>
</div>

<script>
  $(() => {
    $(".delete_component").on("click", function() {
      $('#myModal .modal-title').text("Component Delete Confirmation");
      $('#myModal .modal-body p').text("Are you sure you want to delete all the details of this component?");
      $('#myModal').modal();
      var delete_id = $(this).attr("data-id");
      $("#myModal .modal_action").on("click", function() {
        $('#myModal').hide();
        $("#form_cmp_del_" + delete_id).submit();
      });
    });
  });
</script>