<?
  if(isset($_GET["mac_id"])) {
    $mac_id = $_GET["mac_id"];
    $page_title = "Machine Detail";

    $stmt = $conn->prepare("SELECT mac_id, mac_name, mac_type, mac_reg_no, mac_color, mac_location, mac_purchased_on, mac_hours FROM tbl_machine where mac_id = :mac_id");
    $stmt->bindParam(':mac_id', $mac_id);
    $selected = $stmt->execute();

    if($selected > 0) {
      $mac_info = $stmt->fetch();
    } else {
      // there was some error
      exit;
    }
  }
?>

<div>
  <div class="info_box">
    Detail of machine MACH<?=$mac_id?>
    <div><span class="label">Machine Name</span><?=$mac_info["mac_name"]?></div>
    <div><span class="label">Machine Type</span><?=$mac_info["mac_type"]?></div>
    <div><span class="label">Registration Number</span><?=$mac_info["mac_reg_no"]?></div>
    <div><span class="label">Color</span><?=$mac_info["mac_color"]?></div>
    <div><span class="label">Current Location</span><?=$mac_info["mac_location"]?></div>
    <div><span class="label">Purchased Date</span><?=$mac_info["mac_purchased_on"]?></div>
    <div><span class="label">Hours Run</span><?=$mac_info["mac_hours"]?></div>
    <a href="index.php?page=add_machine&action=edit&mac_id=<?=$mac_info["mac_id"]?>"><input type="button" value="Edit Detail" /></a>
  </div>
</div>