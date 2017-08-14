<?
  $page_title = "Summary of Components";

  $stmt = $conn->prepare("SELECT cmp_id, cmp_name, mac_name, cmp_fitted_on, cmp_type, cmp_used_hours, cls_life - cmp_used_hours as remaining_hours FROM tbl_component c, tbl_class cl, tbl_machine m where cl.cls_id= c.cmp_class_id and m.mac_id = c.cmp_machine_id and cmp_status < 4");
  $stmt->execute();

  $cmp_list = $stmt->setFetchMode(PDO::FETCH_ASSOC);
  $cmp_list = $stmt->fetchAll();
?>

<div class="align_right font_small blue_link">Show Expiring Components</div>

<div>
  <table class="main_table table table-bordered table-striped table-hover">
    <thead>
      <tr>
        <th>SN</th>
        <th>Component</th>
        <th>Machine</th>
        <th>Fitted Date</th>
        <th>Hours to Expected Life</th>
        <th>Hours Used</th>
        <th>Show Detail</th>
      </tr>
    </thead>

    <tbody>
      <? foreach($cmp_list as $component) {?>
          <tr>
            <td></td>
            <td><?=$component["cmp_name"]?></td>
            <td><?=$component["mac_name"]?></td>
            <td><?=$component["cmp_fitted_on"]?></td>
            <td><?=$component["remaining_hours"]?></td>
            <td><?=$component["cmp_used_hours"]?></td>
            <td>
              <input type="button" value="Show Detail">
            </td>
          </tr>
      <? }?>
    </tbody>
  </table>
</div>