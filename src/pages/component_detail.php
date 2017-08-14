<?
  if(isset($_GET["cmp_id"])) {
    $cmp_id = $_GET["cmp_id"];
    $page_title = "Machine Detail";

    $stmt = $conn->prepare("SELECT cmp_id, cmp_name, cmp_class_id, cmp_type, cmp_vendor, cmp_arrival_on, cmp_status, cmp_fitted_on, cmp_fitted_by, cmp_machine_id, cmp_expired_on, cmp_defect_type, cmp_removed_by, cmp_used_hours FROM tbl_component where cmp_id = :cmp_id");
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
    <div><span class="label">Component Class</span><?=$cmp_info["cmp_class_id"]?></div>
    <div><span class="label">Type</span><?=$cmp_info["cmp_type"]?></div>
    <div><span class="label">Vendor</span><?=$cmp_info["cmp_vendor"]?></div>
    <div><span class="label">Arrived Date</span><?=$cmp_info["cmp_arrival_on"]?></div>
    <div><span class="label">Status</span><?=$cmp_info["cmp_status"]?></div>
    <input type="button" value="Edit Component Detail" />
    <? if($cmp_info["cmp_fitted_on"] !== "0000-00-00") {?>
      <div><span class="label">Fitted Date</span><?=$cmp_info["cmp_fitted_on"]?></div>
      <div><span class="label">Fitted By</span><?=$cmp_info["cmp_fitted_by"]?></div>
      <div><span class="label">Machine</span><?=$cmp_info["cmp_machine_id"]?></div>
      <input type="button" value="Edit Fitting Detail" />
    <?}?>

    <? if($cmp_info["cmp_expired_on"] !== "0000-00-00") {?>
      <div><span class="label">Expired Date</span><?=$cmp_info["cmp_expired_on"]?></div>
      <div><span class="label">Defect Type</span><?=$cmp_info["cmp_defect_type"]?></div>
      <div><span class="label">Removed By</span><?=$cmp_info["cmp_removed_by"]?></div>
      <input type="button" value="Edit Unfitting Detail" />
    <?}?>

    <? if($cmp_info["cmp_fitted_on"] !== "0000-00-00") {?>
      <div><span class="label">Component Used Hours</span><?=$cmp_info["cmp_used_hours"]?></div>
    <?}?>
  </div>
</div>