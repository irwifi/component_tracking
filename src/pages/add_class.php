<?
  if(isset($_POST["from_add_class"]) && $_POST["from_add_class"] === "AddClass") {
    if(!empty($_POST["cls_name"])) {
      $stmt = $conn->prepare("INSERT INTO tbl_class (cls_name, cls_supplier, cls_life) VALUES (:cls_name, :cls_supplier, :cls_life)");
      $stmt->bindParam(':cls_name', $_POST["cls_name"]);
      $stmt->bindParam(':cls_supplier', $_POST["cls_supplier"]);
      $stmt->bindParam(':cls_life', $_POST["cls_life"]);
      $inserted = $stmt->execute();

      if($inserted > 0) {
        $_SESSION["message"] = "success";
        $_SESSION[$_SESSION["message"] . "_msg"] = "1 new Component Class detail added";
         header("Location: index.php?page=list_class");
      }
      // there was some error
    } else {
      // send error message
    }
    exit;
  } else {
    $page_title = "Add New Component Class";
  }
?>

<div>
  <div class="form_box">
    <ul class="err_box">
      <li>Enter complete component Class detail</li>
    </ul>

    <form id="form_add_class" method="post" action="index.php?page=add_class">
      <div>Enter Component Class detail</div>
      <div><span class="label">Component Class Name</span><input type="text" name="cls_name" placeholder="Class Name"></div>
      <div><span class="label">Component Supplier</span><input type="text" name="cls_supplier" placeholder="Supplier"></div>
      <div><span class="label">Expected Life</span><input type="text" name="cls_life" placeholder="Expected Life (in Hours)"></div>
      <div>
        <input type="hidden" name="from_add_class" value="AddClass">
        <input type="button" id="btn_add_class" value="Add Class">
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