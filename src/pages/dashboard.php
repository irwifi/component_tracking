<?
  $page_title = "Summary of Components";
  $status_cond = " and cmp_status = 2";
  $cond_select = ", c.cmp_fitted_on, m.mac_name";
  $cond_table = ", tbl_machine m";

  $qry = "SELECT c.cmp_id, cl.cls_name, c.cmp_name, c.cmp_type, c.cmp_vendor, c.cmp_status " . $cond_select . " FROM tbl_component c, tbl_class cl " . $cond_table . " where cl.cls_id = c.cmp_class_id" . $status_cond . " order by cmp_id";
  $stmt = $conn->prepare($qry);
  $stmt->execute();

  $cmp_list = $stmt->setFetchMode(PDO::FETCH_ASSOC);
  $cmp_list = $stmt->fetchAll();
?>

<div class="align_right font_small blue_link"><a href="index.php?page=list_component&status=expiring">Show Expiring Components</a></div>

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
        <th>Fitted Date</th>
        <th>Machine</th>
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
            <td><?=$component["cmp_fitted_on"]?></td>
            <td><?=$component["mac_name"]?></td>
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