<?
  if(isset($_GET["cmp_id"])) {
    $cmp_id = $_GET["cmp_id"];
    $page_title = "Component Info";

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

<div class="portlet light bordered">
    <div class="portlet-title">
        <div class="caption">
            <i class="icon-equalizer font-green-haze"></i>
            <span class="caption-subject font-green-haze bold uppercase">View Component Info</span>
            <span class="caption-helper">CMP<?=$cmp_id?></span>
        </div>
    </div>
    <div class="portlet-body form">
        <!-- BEGIN FORM-->
        <form class="form-horizontal" role="form">
            <div class="form-body">
                <!-- <h2 class="margin-bottom-20"> View Machine Info - <?=$mac_info["mac_name"]?> </h2> -->
                <h3 class="form-section">Component Info</h3>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label col-md-3">Component Name:</label>
                            <div class="col-md-9">
                                <p class="form-control-static"> <?=$cmp_info["cmp_name"]?> </p>
                            </div>
                        </div>
                    </div>
                    <!--/span-->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label col-md-3">Component Class:</label>
                            <div class="col-md-9">
                                <p class="form-control-static"> <?=$cmp_info["cls_name"]?> </p>
                            </div>
                        </div>
                    </div>
                    <!--/span-->
                </div>
                <!--/row-->
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label col-md-3">Type:</label>
                            <div class="col-md-9">
                                <p class="form-control-static"> <?=$cmp_info["cmp_type"]?> </p>
                            </div>
                        </div>
                    </div>
                    <!--/span-->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label col-md-3">Vendor:</label>
                            <div class="col-md-9">
                                <p class="form-control-static"> <?=$cmp_info["cmp_vendor"]?> </p>
                            </div>
                        </div>
                    </div>
                    <!--/span-->
                </div>
                <!--/row-->
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label col-md-3">Arrived Date:</label>
                            <div class="col-md-9">
                                <p class="form-control-static"> <?=$cmp_info["cmp_arrival_on"]?> </p>
                            </div>
                        </div>
                    </div>
                    <!--/span-->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label col-md-3">Status:</label>
                            <div class="col-md-9">
                                <p class="form-control-static">
                                  <? switch($cmp_info["cmp_status"]) {
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
                                </p>
                            </div>
                        </div>
                    </div>
                    <!--/span-->
                </div>
                <!--/row-->
            </div>

            <div class="form-actions">
                <div class="row">
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-md-offset-3 col-md-9">
                                <a href="index.php?page=add_component&action=edit&cmp_id=<?=$cmp_info["cmp_id"]?>">
                                  <button type="submit" class="btn green">
                                    <i class="fa fa-pencil"></i> Edit Component Info
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

    <? if($cmp_info["cmp_fitted_on"] !== "0000-00-00") {?>
      <div class="portlet-body form">
          <!-- BEGIN FORM-->
          <form class="form-horizontal" role="form">
              <div class="form-body">
                  <!-- <h2 class="margin-bottom-20"> View Machine Info - <?=$mac_info["mac_name"]?> </h2> -->
                  <h3 class="form-section">Component Fitting Info</h3>
                  <div class="row">
                      <div class="col-md-6">
                          <div class="form-group">
                              <label class="control-label col-md-3">Fitted Date:</label>
                              <div class="col-md-9">
                                  <p class="form-control-static"> <?=$cmp_info["cmp_fitted_on"]?> </p>
                              </div>
                          </div>
                      </div>
                      <!--/span-->
                      <div class="col-md-6">
                          <div class="form-group">
                              <label class="control-label col-md-3">Fitted By:</label>
                              <div class="col-md-9">
                                  <p class="form-control-static"> <?=$cmp_info["cmp_fitted_by"]?> </p>
                              </div>
                          </div>
                      </div>
                      <!--/span-->
                  </div>
                  <!--/row-->
                  <div class="row">
                      <div class="col-md-6">
                          <div class="form-group">
                              <label class="control-label col-md-3">Machine:</label>
                              <div class="col-md-9">
                                  <p class="form-control-static"> <?=$cmp_info["mac_name"]?> </p>
                              </div>
                          </div>
                      </div>
                      <!--/span-->
                      <div class="col-md-6">
                          <div class="form-group">
                              <label class="control-label col-md-3">Fitting Hour Meter Reading:</label>
                              <div class="col-md-9">
                                  <p class="form-control-static"> <?=$cmp_info["cmp_fitted_hour"]?> </p>
                              </div>
                          </div>
                      </div>
                      <!--/span-->
                  </div>
                  <!--/row-->
              </div>

              <div class="form-actions">
                  <div class="row">
                      <div class="col-md-6">
                          <div class="row">
                              <div class="col-md-offset-3 col-md-9">
                                  <a href="index.php?page=add_component&action=edit&cmp_id=<?=$cmp_info["cmp_id"]?>">
                                    <button type="submit" class="btn green">
                                      <i class="fa fa-pencil"></i> Edit Fitting Info
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
    <?}?>

    <? if($cmp_info["cmp_expired_on"] !== "0000-00-00") {?>
      <div class="portlet-body form">
          <!-- BEGIN FORM-->
          <form class="form-horizontal" role="form">
              <div class="form-body">
                  <!-- <h2 class="margin-bottom-20"> View Machine Info - <?=$mac_info["mac_name"]?> </h2> -->
                  <h3 class="form-section">Component Unfitting Info</h3>
                  <div class="row">
                      <div class="col-md-6">
                          <div class="form-group">
                              <label class="control-label col-md-3">Expired Date:</label>
                              <div class="col-md-9">
                                  <p class="form-control-static"> <?=$cmp_info["cmp_expired_on"]?> </p>
                              </div>
                          </div>
                      </div>
                      <!--/span-->
                      <div class="col-md-6">
                          <div class="form-group">
                              <label class="control-label col-md-3">Defect Type:</label>
                              <div class="col-md-9">
                                  <p class="form-control-static"> <?=$cmp_info["cmp_defect_type"]?> </p>
                              </div>
                          </div>
                      </div>
                      <!--/span-->
                  </div>
                  <!--/row-->
                  <div class="row">
                      <div class="col-md-6">
                          <div class="form-group">
                              <label class="control-label col-md-3">Removed By:</label>
                              <div class="col-md-9">
                                  <p class="form-control-static"> <?=$cmp_info["cmp_removed_by"]?> </p>
                              </div>
                          </div>
                      </div>
                      <!--/span-->
                      <div class="col-md-6">
                          <div class="form-group">
                              <label class="control-label col-md-3">Unfitting Hour Meter Reading:</label>
                              <div class="col-md-9">
                                  <p class="form-control-static"> <?=$cmp_info["cmp_expired_hour"]?> </p>
                              </div>
                          </div>
                      </div>
                      <!--/span-->
                  </div>
                  <!--/row-->
              </div>

              <div class="form-actions">
                  <div class="row">
                      <div class="col-md-6">
                          <div class="row">
                              <div class="col-md-offset-3 col-md-9">
                                  <a href="index.php?page=add_component&action=edit&cmp_id=<?=$cmp_info["cmp_id"]?>">
                                    <button type="submit" class="btn green">
                                      <i class="fa fa-pencil"></i> Edit Unfitting Info
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
    <?}?>

    <? if($cmp_info["cmp_fitted_on"] !== "0000-00-00") {?>
      <div class="portlet-body form">
          <!-- BEGIN FORM-->
          <form class="form-horizontal" role="form">
              <div class="form-body">
                  <!-- <h2 class="margin-bottom-20"> View Machine Info - <?=$mac_info["mac_name"]?> </h2> -->
                  <h3 class="form-section">Component Hour Info</h3>
                  <div class="row">
                      <div class="col-md-6">
                          <div class="form-group">
                              <label class="control-label col-md-3">Component Used Hours:</label>
                              <div class="col-md-9">
                                  <p class="form-control-static"> <?=$cmp_info["cmp_used_hours"]?> </p>
                              </div>
                          </div>
                      </div>
                      <!--/span-->
                  </div>
                  <!--/row-->
              </div>
          </form>
          <!-- END FORM-->
      </div>
    <?}?>
</div>