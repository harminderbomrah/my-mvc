<?= content_css_tag("plugin/chosen.scss") ?>
<?= content_css_tag("backsite/unit/form.scss") ?>
<div class="main-form product" data-ng-controller="productForm" data-ng-init='extend(<?= json_encode($initial) ?>)'>
  <form class="form-horizontal" name="productForm" data-ng-submit="action.submit(productForm)" role="form" novalidate>
    <div class="row">
      <div class="col-lg-9">
        <div class="form-group" data-ng-class="{'has-error': productForm.title.$invalid && !productForm.title.$pristine}">
          <input type="text" class="form-control input-lg" name="title" id="title" placeholder="Title" data-ng-model="productData.title" required>
        </div>
        <div class="panel panel-default">
          <div class="panel-heading">
            <label>Depiction</label>
          </div>
          <div class="panel-body">
            <textarea class="form-control" name="depiction" id="depiction" rows="3" data-ng-model="productData.depiction"></textarea>
          </div>
        </div>
        <div class="panel panel-default">
          <div class="panel-heading">
            <label>Spec</label>
          </div>
          <div class="panel-body">
            <div class="form-group">
              <label for="coo" class="col-sm-2 control-label">產地</label>
              <div class="col-sm-4">
                <input type="text" name="coo" class="form-control" id="coo" data-ng-model="productData.specs.countryOfOrigin">
              </div>
            </div>
            <div class="form-group">
              <label for="coo" class="col-sm-2 control-label">吸水率</label>
              <div class="col-sm-4">
                <rating class="range" data-ng-model="productData.specs.waterAbsorption" state-on="'fa fa-fw hover fa-tint'" state-off="'fa fa-fw fa-tint'"></rating>
              </div>
            </div>
            <div class="form-group">
              <label for="coo" class="col-sm-2 control-label">耐用度</label>
              <div class="col-sm-4">
                <rating class="range" data-ng-model="productData.specs.durability" state-on="'fa fa-fw hover fa-shield'" state-off="'fa fa-fw fa-shield'"></rating>
              </div>
            </div>
            <div class="form-group">
              <label for="coo" class="col-sm-2 control-label">評價</label>
              <div class="col-sm-4">
                <rating class="range" data-ng-model="productData.specs.evaluate" state-on="'fa fa-fw hover fa-star'" state-off="'fa fa-fw fa-star'"></rating>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-3">
        <div class="panel panel-default">
          <div class="panel-heading">
            <label>Category</label>
          </div>
          <div class="panel-body">
            <div class="form-group" data-ng-class="{'has-error': productForm.category.$invalid && !productForm.category.$pristine}">
              <select class="form-control" name="category" id="category" data-placeholder="Choose Category" data-ng-model="productData.category" data-ng-options="option.id as option.name for option in relationData.categorys" chosen="choseOptions" required>
                <option value=""></option>
              </select>
            </div>
          </div>
          <div class="panel-footer text-right">
            <a class="btn btn-sm btn-default" href="/admin/product" target="_self">Cancel</a>
            <button type="submit" class="btn btn-sm btn-primary">Submit</button>
          </div>
        </div>
        <div class="row">
          <div class="col-lg-12 col-md-4 col-sm-4">
            <div class="panel panel-default">
              <div class="panel-heading">
                <label>Images</label>
              </div>
              <div class="panel-body">
                <a class="upload" href="#" data-ng-click="action.fileUpLoad()">
                  <i class="fa fa-upload fa-5x fa-fw" data-ng-show="productData.img.length == 0"></i>
                  <div class="img" data-ng-show="productData.img.length > 0">
                    <i class="fa fa-refresh fa-5x fa-fw"></i>
                    <div class="img-preview">
                      <div class="row" data-ng-repeat="previews in previewGroup">
                        <div class="col-xs-4" data-ng-repeat="preview in previews">
                          <img class="img-rounded" data-ng-src="{{preview}}">
                        </div>
                      </div>
                    </div>
                  </div>
                </a>
                <div class="clearImg">
                  <button type="button" class="btn btn-sm btn-flat btn-warning" data-ng-click="action.clearImg()" data-ng-show="productData.img.length > 0">Clear Image</button>
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-12 col-md-8 col-sm-8">
            <div class="panel panel-default">
              <div class="panel-heading">
                <label for="tag">Tag</label>
              </div>
              <div class="panel-body">
                <div class="form-group">
                  <select class="form-control" name="tag" id="tag" data-placeholder="Choose Tag" multiple data-ng-model="productData.tag" data-ng-options="option.id as option.name for option in relationData.tag" chosen="choseOptions">
                    <option value=""></option>
                  </select>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </form>
</div>
<?= js_tag("app/backend/controllers/product-form.js") ?>
<?= js_tag("app/backend/controllers/fileManage/defaultFileManage.js") ?>
<?= js_tag("plugin/ngFileUpload/angular-file-upload.js") ?>
<?= js_tag("plugin/masonry/angular-masonry.js") ?>
<?= js_tag("plugin/chosen/chosen.jquery.js") ?>
