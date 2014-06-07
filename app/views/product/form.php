<?= content_css_tag("plugin/chosen.scss") ?>
<?= content_css_tag("nyfm/unit/form.scss") ?>
<div class="main-form product" data-ng-controller="productForm" data-ng-init='extend(<?= json_encode($initial) ?>)'>
  <form class="form-horizontal" name="productForm" data-ng-submit="action.submit(productForm)" role="form" novalidate>
    <div class="row">
      <div class="col-lg-9">
        <div class="form-group" data-ng-class="{'has-error': productForm.title.$invalid && !productForm.title.$pristine}">
          <input type="text" class="form-control input-lg" name="title" id="title" placeholder="Title" data-ng-model="productData.title" required>
        </div>
        <div class="panel panel-default">
          <div class="panel-heading">
            <label>Spec</label>
          </div>
          <div class="panel-body">
            <table class="table">
              <tbody>
                <tr data-ng-repeat="spec in productData.specs">
                  <td class="col-md-3" data-ng-class="{'has-error': productForm.item.$invalid && !productForm.item.$pristine}">
                    <select class="form-control" name="item" id="item" data-placeholder="Choose Item" data-ng-model="spec.item" data-ng-options="option.id as option.name for option in relationData.specs" chosen="choseOptions">
                      <option value=""></option>
                    </select>
                  </td>
                  <td class="col-md-8">
                    <textarea class="form-control" name="detail" id="detail" rows="3" data-ng-model="spec.detail"></textarea>
                  </td>
                  <td class="col-md-1 text-right" data-ng-show="productData.specs.length > 1">
                    <a class="remove-item" href="#" data-ng-click="action.removeItem($index)"><i class="fa fa-times-circle"></i></a>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
          <div class="panel-footer text-center">
            <a href="#" class="btn btn-sm btn-primary" data-ng-disabled="initial.addDisabled" data-ng-click="action.addSpec($event)">Add</a>
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
            <a class="btn btn-sm btn-default" href="/admin/article" target="_self">Cancel</a>
            <button type="submit" class="btn btn-sm btn-primary">Submit</button>
          </div>
        </div>
        <div class="panel panel-default">
          <div class="panel-heading">
            <label>Images</label>
          </div>
          <div class="panel-body">
            <a class="upload" href="#" data-ng-click="action.fileUpLoad()">
              <i class="fa fa-upload fa-5x fa-fw" data-ng-show="!productData.img"></i>
              <div class="img" data-ng-show="productData.img">
                <i class="fa fa-refresh fa-5x fa-fw"></i>
                <img class="img-rounded" data-ng-src="{{productData.img}}">
              </div>
            </a>
          </div>
        </div>
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
  </form>
</div>
<?= js_tag("app/backend/controllers/product-form.js") ?>
<?= js_tag("app/backend/controllers/fileManage.js") ?>
<?= js_tag("plugin/chosen/chosen.jquery.js") ?>