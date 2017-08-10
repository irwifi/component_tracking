<?
  if(isset($_POST["from_add_machine"]) && $_POST["from_add_machine"] === "AddMachine") {
    $machine = $_POST["machine"];
    if(!empty($machine)) {
      $stmt = $conn->prepare("INSERT INTO tbl_machine (mac_name) VALUES (:mac_name)");
      $stmt->bindParam(':mac_name', $machine);
      $inserted = $stmt->execute();

      if($inserted > 0) {
        $_SESSION["message"] = "success";
        $_SESSION[$_SESSION["message"] . "_msg"] = "1 New Machine detail added";
      }
    }

    header("Location: index.php?page=list_machine");
    exit;
  } else {
    $page_title = "Add New Machine";
  }
?>

<div>
  <div class="form_box">
    <ul class="err_box">
      <li>Enter Machine detail</li>
    </ul>

    Enter the Machine Name
    <form id="form_add_machine" method="post" action="index.php?page=add_machine">
      <input type="text" name="machine" placeholder="Machine">
      <input type="hidden" name="from_add_machine" value="AddMachine">
      <input type="button" id="btn_add_machine" value="Add Machine">
    </form>
  </div>
</div>

<script>
  $(() => {
    $("#btn_add_machine").on("click", () => {
      $(".err_box").hide();
      if($("#form_add_machine input[name='machine']").val() === "") {
        $(".err_box").show();
      } else {
        $("#form_add_machine").submit();
      }
    });
  });
</script>