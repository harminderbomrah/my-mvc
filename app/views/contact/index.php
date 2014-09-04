<?= content_css_tag("frontsite/unit/contact.scss") ?>
<?= render_partial("partial/top-nav") ?>
<section class="main-wrap mini-height border-bottom row">
  <aside class="map col-6 col-md-12">
    <div id="map"></div>
    <div class="map-bottom-bar">
      <div class="map-message">WE ARE HERE !</div>
      <ul class="map-info list-unstyled">
        <li>良錡石材企業公司</li>
        <li>地址：249 新北市八里區中華路一段37-1號</li>
        <li>電話：+886 2 8630-1299</li>
      </ul>
    </div>
  </aside>
  <main class="content col-6 col-md-12">
    <div class="content-inner">
      <h1 class="content-title">Contact Us</h1>
      <div class="ask-list" data-ng-app="contact" data-ng-controller="contactForm">
        <form class="ask-list-inner" name="guestAskList" data-ng-submit='submit(guestAskList)' data-ng-show='!success' data-ng-init='extend(<?= json_encode($askList) ?>)' role='form' novalidate>
          <p class="ask-list-head" data-ng-show="data.product.length">產品詢問清單 <span class="cancel-list" data-ng-click="cancelList()"><i class="fa fa-fw fa-trash-o"></i> 清除清單</span></p>
          <ol data-ng-show="data.product.length">
            <li data-ng-repeat="list in data.product">
              <a href="/collections/{{list.id}}" target="_blink" data-ng-bind="list.title"></a>
              <span class="cancel" data-ng-click="cancelProduct(list.id, $index)"><i class="fa fa-fw fa-times"></i></span>
            </li>
          </ol>
          <p></p>
          <div class="form-group" data-ng-class="{'error': guestAskList.guest.$invalid && !guestAskList.guest.$pristine}">
            <label class="form-label" for="guest">Name</label>
            <input id="guest" name="guest" type="text" data-ng-model="data.guest" required>
          </div>
          <div class="form-group">
            <label class="form-label" for="company">Company</label>
            <input id="company" name="company" type="text" data-ng-model="data.company">
          </div>
          <div class="form-group" data-ng-class="{'error': guestAskList.email.$invalid && !guestAskList.email.$pristine}">
            <label class="form-label" for="email">E-mail</label>
            <input id="email" name="email" type="email" data-ng-model="data.email" required>
          </div>
          <div class="form-group" data-ng-class="{'error': guestAskList.message.$invalid && !guestAskList.message.$pristine}">
            <label class="form-label" for="message">Messages</label>
            <textarea id="message" name="message" data-ng-model="data.message" rows="5" required></textarea>
          </div>
          <p class="text-right">
            <button class="btn" type="submit" data-ng-disabled="send">
              <span ng-show="!send">送出</span>
              <i class="fa fa-lg fa-spinner fa-spin" ng-show="send"></i>
            </button>
          </p>
        </form>
        <div class="send-success text-center" data-ng-show="success">
          <p class="success-title"><i class="fa fz-fw fa-child"></i> 感謝您的詢問</p>
          <span class="success-msg">我們會儘快答覆您的問題</span>
        </div>
      </div>
    </div>
  </main>
</section>
<?= js_tag("http://maps.google.com/maps/api/js?sensor=false") ?>
<?= js_tag("lib/angular/angular.min.js") ?>
<?= js_tag("app/backend/services.js") ?>
<?= js_tag("lib/gmaps/gmaps.js") ?>
<?= js_tag("frontsite/contact.js") ?>