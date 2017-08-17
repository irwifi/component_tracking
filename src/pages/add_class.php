<?
  if(isset($_POST["from_add_class"]) && $_POST["from_add_class"] === "AddClass") {
    if(!empty($_POST["cls_name"])) {
      if($_POST["cls_action"] === "add") {
        $stmt = $conn->prepare("INSERT INTO tbl_class (cls_name, cls_supplier, cls_life) VALUES (:cls_name, :cls_supplier, :cls_life)");
        $action_msg = "1 new Component Class detail added";
      } else {
        $stmt = $conn->prepare("UPDATE tbl_class SET cls_name = :cls_name, cls_supplier = :cls_supplier, cls_life = :cls_life WHERE cls_id = :cls_id");
        $stmt->bindParam(':cls_id', $_POST["cls_id"]);
        $action_msg = "1 Component Class detail edited";
      }

      $stmt->bindParam(':cls_name', $_POST["cls_name"]);
      $stmt->bindParam(':cls_supplier', $_POST["cls_supplier"]);
      $stmt->bindParam(':cls_life', $_POST["cls_life"]);
      $inserted = $stmt->execute();

      if($inserted > 0) {
        $_SESSION["message"] = "success";
        $_SESSION[$_SESSION["message"] . "_msg"] = $action_msg;
        header("Location: index.php?page=list_class");
      }
      // there was some error
    } else {
      // send error message
    }
    exit;
  } else {
    $page_title = "Add New Component Class";
    $cls_info = ["cls_name"=>"", "cls_supplier"=>"", "cls_life"=>"", "cls_action"=>"add", "cls_button" => "Add Class"];

    if(isset($_GET["action"]) && $_GET["action"] === "edit") {
      $page_title = "Edit Component Class Detail";
      $stmt = $conn->prepare("SELECT cls_id, cls_name, cls_supplier, cls_life FROM tbl_class WHERE cls_id = :cls_id");
      $stmt->bindParam(':cls_id', $_GET["cls_id"]);
      $stmt->execute();
      $cls_info = $stmt->fetch();
      $cls_info["cls_action"] = "edit";
      $cls_info["cls_button"] = "Edit Class";
    }
  }
?>

<div>
  <div class="form_box">
    <ul class="err_box">
      <li>Enter complete component Class detail</li>
    </ul>

    <form id="form_add_class" method="post" action="index.php?page=add_class">
      <div>Enter Component Class detail</div>
      <div><span class="label">Component Class Name</span><input type="text" name="cls_name" placeholder="Class Name" value="<?=$cls_info["cls_name"]?>"></div>
      <div><span class="label">Component Supplier</span><input type="text" name="cls_supplier" placeholder="Supplier" value="<?=$cls_info["cls_supplier"]?>"></div>
      <div><span class="label">Expected Life</span><input type="text" name="cls_life" placeholder="Expected Life (in Hours)" value="<?=$cls_info["cls_life"]?>"></div>
      <div>
        <input type="hidden" name="from_add_class" value="AddClass">
        <input type="hidden" name="cls_id" value="<?=$cls_info["cls_id"]?>">
        <input type="hidden" name="cls_action" value="<?=$cls_info["cls_action"]?>">
        <input type="button" id="btn_add_class" value="<?=$cls_info["cls_button"]?>">
      </div>
    </form>
  </div>
</div>

<script>
  $(() => {
    $("#btn_add_class").on("click", () => {
      $(".err_box").hide();
      if($("#form_add_class input[name='cls_name']").val() === "" || $("#form_add_class input[name='cls_supplier']").val() === "" || $("#form_add_class input[name='cls_life']").val() === "") {
        $(".err_box").show();
      } else {
        $("#form_add_class").submit();
      }
    });
  });
</script>