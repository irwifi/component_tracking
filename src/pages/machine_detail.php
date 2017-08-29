<?
  if(isset($_GET["mac_id"])) {
    $mac_id = $_GET["mac_id"];
    $page_title = "Machine Info";

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

<div class="portlet light bordered">
    <div class="portlet-title">
        <div class="caption">
            <i class="icon-equalizer font-green-haze"></i>
            <span class="caption-subject font-green-haze bold uppercase">View Machine Info</span>
            <span class="caption-helper">MACH<?=$mac_id?></span>
        </div>
    </div>
    <div class="portlet-body form">
        <!-- BEGIN FORM-->
        <form class="form-horizontal" role="form">
            <div class="form-body">
                <!-- <h2 class="margin-bottom-20"> View Machine Info - <?=$mac_info["mac_name"]?> </h2> -->
                <!-- <h3 class="form-section">Info</h3> -->
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label col-md-3">Machine Name:</label>
                            <div class="col-md-9">
                                <p class="form-control-static"> <?=$mac_info["mac_name"]?> </p>
                            </div>
                        </div>
                    </div>
                    <!--/span-->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label col-md-3">Machine Type:</label>
                            <div class="col-md-9">
                                <p class="form-control-static"> <?=$mac_info["mac_type"]?> </p>
                            </div>
                        </div>
                    </div>
                    <!--/span-->
                </div>
                <!--/row-->
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label col-md-3">Registration Number:</label>
                            <div class="col-md-9">
                                <p class="form-control-static"> <?=$mac_info["mac_reg_no"]?> </p>
                            </div>
                        </div>
                    </div>
                    <!--/span-->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label col-md-3">Color:</label>
                            <div class="col-md-9">
                                <p class="form-control-static"> <?=$mac_info["mac_color"]?> </p>
                            </div>
                        </div>
                    </div>
                    <!--/span-->
                </div>
                <!--/row-->
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label col-md-3">Current Location:</label>
                            <div class="col-md-9">
                                <p class="form-control-static"> <?=$mac_info["mac_location"]?> </p>
                            </div>
                        </div>
                    </div>
                    <!--/span-->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label col-md-3">Purchased Date:</label>
                            <div class="col-md-9">
                                <p class="form-control-static"> <?=$mac_info["mac_purchased_on"]?> </p>
                            </div>
                        </div>
                    </div>
                    <!--/span-->
                </div>
                <!--/row-->
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label col-md-3">Hours Run:</label>
                            <div class="col-md-9">
                                <p class="form-control-static"> <?=$mac_info["mac_hours"]?> </p>
                            </div>
                        </div>
                    </div>
                    <!--/span-->
                </div>
            </div>

            <div class="form-actions">
                <div class="row">
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-md-offset-3 col-md-9">
                                <a href="index.php?page=add_machine&action=edit&mac_id=<?=$mac_info["mac_id"]?>">
                                  <button type="button" class="btn green">
                                    <i class="fa fa-pencil"></i> Edit
                                  </button>
                                </a>
                                <!-- <button type="button" class="btn default">Cancel</button> -->
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6"> </div>
                </div>
            </div>
        </form>
        <!-- END FORM-->
    </div>
</div>