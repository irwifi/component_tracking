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

<div class="row">
  <div class="col-3">
  <div style="color:#F00;">
    <h4>Features yet to come</h4>
    <ul>
      <li>Fitting of component</li>
      <li>Unfitting of component</li>
      <li>Warning of expiring component</li>
      <li>Detecting premature expiry of components</li>
      <li>Edit machine detail</li>
      <li>Edit component class detail</li>
      <li>Edit component detail</li>
    </ul>
  </div>

  <div>
    <h4>Features</h4>
    <ul>
      <li>Adding new machine</li>
      <li>Showing list of machines</li>
      <li>Showing detail of a machine</li>
      <li>Deleting a machine</li>
      <li>Adding new component class</li>
      <li>Showing list of component classes</li>
      <li>Deleting a component class</li>
      <li>Adding new component</li>
      <li>Showing list of all components</li>
      <li>Showing list of unfitted components</li>
      <li>Showing list of active components</li>
      <li>Showing list of expiring components</li>
      <li>Showing list of expired components</li>
      <li>Showing detail of a component</li>
      <li>Deleting a component</li>
      <li>Entering hour log</li>
      <li>Showing list of log records</li>
      <li>Deleting log entry</li>
      <li>Smart message alerting after operations like add, update, delete</li>
      <li>Modal based delete confirmation</li>
      <li>Smart hour calculation for components</li>
    </ul>
  </div>
  </div>

  <div class="col-9">
    <div class="align_right font_small blue_link"><a href="index.php?page=list_component&status=expiring">Show Expiring Components</a></div>

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
</div>