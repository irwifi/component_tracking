<?
  if(isset($_GET["cmp_id"])) {
    $cmp_id = $_GET["cmp_id"];
    $page_title = "Machine Detail";

    $stmt = $conn->prepare("SELECT cmp_id, cmp_name, cls_name, cmp_type, cmp_vendor, cmp_arrival_on, cmp_status, cmp_fitted_on, cmp_fitted_by, mac_name, cmp_expired_on, cmp_defect_type, cmp_removed_by, cmp_used_hours, cmp_fitted_hour, cmp_expired_hour FROM tbl_component, tbl_class, tbl_machine where cmp_id = :cmp_id and cls_id = cmp_class_id and mac_id = cmp_machine_id");
    $stmt->bindParam(':cmp_id', $cmp_id);
    $selected = $stmt->execute();

    if($selected > 0) {
      $cmp_info = $stmt->fetch();
    } else {
      // there was some error
      exit;
    }
  }
?>

<div>
  <div class="info_box">
    Detail of component CMP<?=$cmp_id?>
    <div><span class="label">Component Name</span><?=$cmp_info["cmp_name"]?></div>
    <div><span class="label">Component Class</span><?=$cmp_info["cls_name"]?></div>
    <div><span class="label">Type</span><?=$cmp_info["cmp_type"]?></div>
    <div><span class="label">Vendor</span><?=$cmp_info["cmp_vendor"]?></div>
    <div><span class="label">Arrived Date</span><?=$cmp_info["cmp_arrival_on"]?></div>
    <div><span class="label">Status</span><? switch($cmp_info["cmp_status"]) {
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
      }?>
    </div>
    <input type="button" value="Edit Component Detail" />
    <? if($cmp_info["cmp_fitted_on"] !== "0000-00-00") {?>
      <div><span class="label">Fitted Date</span><?=$cmp_info["cmp_fitted_on"]?></div>
      <div><span class="label">Fitted By</span><?=$cmp_info["cmp_fitted_by"]?></div>
      <div><span class="label">Machine</span><?=$cmp_info["mac_name"]?></div>
      <div><span class="label">Fitting Hour Meter Reading</span><?=$cmp_info["cmp_fitted_hour"]?></div>
      <input type="button" value="Edit Fitting Detail" />
    <?}?>

    <? if($cmp_info["cmp_expired_on"] !== "0000-00-00") {?>
      <div><span class="label">Expired Date</span><?=$cmp_info["cmp_expired_on"]?></div>
      <div><span class="label">Defect Type</span><?=$cmp_info["cmp_defect_type"]?></div>
      <div><span class="label">Removed By</span><?=$cmp_info["cmp_removed_by"]?></div>
      <div><span class="label">Unfitting Hour Meter Reading</span><?=$cmp_info["cmp_expired_hour"]?></div>
      <input type="button" value="Edit Unfitting Detail" />
    <?}?>

    <? if($cmp_info["cmp_fitted_on"] !== "0000-00-00") {?>
      <div><span class="label">Component Used Hours</span><?=$cmp_info["cmp_used_hours"]?></div>
    <?}?>
  </div>
</div>