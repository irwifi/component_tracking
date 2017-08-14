<?
  if(isset($_POST["from_add_machine"]) && $_POST["from_add_machine"] === "AddMachine") {
    if(!empty($_POST["mac_name"])) {
      $stmt = $conn->prepare("INSERT INTO tbl_machine (mac_name, mac_type, mac_reg_no, mac_color, mac_location, mac_purchased_on) VALUES (:mac_name, :mac_type, :mac_reg_no, :mac_color, :mac_location, :mac_purchased_on)");
      $stmt->bindParam(':mac_name', $_POST["mac_name"]);
      $stmt->bindParam(':mac_type', $_POST["mac_type"]);
      $stmt->bindParam(':mac_reg_no', $_POST["mac_reg_no"]);
      $stmt->bindParam(':mac_color', $_POST["mac_color"]);
      $stmt->bindParam(':mac_location', $_POST["mac_location"]);
      $stmt->bindParam(':mac_purchased_on', $_POST["mac_purchased_on"]);
      $inserted = $stmt->execute();

      if($inserted > 0) {
        $_SESSION["message"] = "success";
        $_SESSION[$_SESSION["message"] . "_msg"] = "1 new Machine detail added";
        header("Location: index.php?page=list_machine");
      }
      // there was some error
    } else {
      // send error message
    }
    exit;
  } else {
    $page_title = "Add New Machine";
  }
?>

<div>
  <div class="form_box">
    <ul class="err_box">
      <li>Enter complete machine detail</li>
    </ul>

    <form id="form_add_machine" method="post" action="index.php?page=add_machine">
      <div>Enter machine detail</div>
      <div><span class="label">Machine Name</span><input type="text" name="mac_name" placeholder="Machine Name"></div>
      <div><span class="label">Type</span><input type="text" name="mac_type" placeholder="Type"></div>
      <div><span class="label">Registration Number</span><input type="text" name="mac_reg_no" placeholder="Registration Number"></div>
      <div><span class="label">Color</span><input type="text" name="mac_color" placeholder="Color"></div>
      <div><span class="label">Current Location</span><input type="text" name="mac_location" placeholder="Current Location"></div>
      <div><span class="label">Purchased Date</span><input type="text" name="mac_purchased_on" placeholder="Purchased Date"></div>
      <input type="hidden" name="from_add_machine" value="AddMachine">
      <input type="button" id="btn_add_machine" value="Add Machine">
    </form>
  </div>
</div>

<script>
  $(() => {
    $("#btn_add_machine").on("click", () => {
      $(".err_box").hide();
      if($("#form_add_machine input[name='mac_name']").val() === "" || $("#form_add_machine input[name='mac_type']").val() === "" || $("#form_add_machine input[name='mac_reg_on']").val() === "" || $("#form_add_machine input[name='mac_color']").val() === "" || $("#form_add_machine input[name='mac_location']").val() === "" || $("#form_add_machine input[name='mac_purchased_on']").val() === "") {
        $(".err_box").show();
      } else {
        $("#form_add_machine").submit();
      }
    });
  });
</script>