<?
  $page_title = "Summary of Components";

  $qry = "SELECT c.cmp_id, cl.cls_name, c.cmp_name, c.cmp_status, cmp_used_hours, m.mac_name FROM tbl_component c, tbl_class cl, tbl_machine m where cl.cls_id = c.cmp_class_id and cmp_status = 2 and mac_id = cmp_machine_id order by cmp_id";
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
      <li>Component Unfitting</li>
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
      <li>Component Fitting</li>
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
          <th>Machine</th>
          <th>Status</th>
          <th>Hours Used</th>
          <th>Show Detail</th>
        </tr>
      </thead>

      <tbody>
        <? foreach($cmp_list as $component) {?>
            <tr>
              <td></td>
              <td>CMP<?=$component["cmp_id"]?></td>
              <td><?=$component["cmp_name"]?></td>
              <td><?=$component["mac_name"]?></td>
              <td><? switch($component["cmp_status"]) {
                case 1:
                  echo "Unfitted";
                  break;
                case 2:
                  echo "Fitted";
                  break;
                case 3:
                  echo "Nearing Expected Life";
                  break;
                case 4:
                  echo "Expected Life Crossed";
                  break;
                case 5:
                  echo "Expired";
                  break;
              }
              ?></td>
              <td><?=$component["cmp_used_hours"]?></td>
              <td>
                <a href="index.php?page=component_detail&cmp_id=<?=$component["cmp_id"]?>"><input type="button" value="Show Detail"></a>
              </td>
            </tr>
        <? }?>
      </tbody>
    </table>
  </div>
</div>