<?= content_css_tag("frontsite/unit/contact.scss") ?>
<section class="main-wrap mini-height row">
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
  <main class="content col-6 col-md-12 ">
    <div class="content-inner">
      <h1 class="content-title">Contact Us</h1>
      <div class="ask-list">
        <p>產品詢問清單</p>
        <ol>
          <li>
            <a href="" data-lorem="1s"></a>
            <span class="cancel" data-cancel-itme="A"><i class="fa fa-fw fa-times"></i></span>
          </li>
          <li>
            <a href="" data-lorem="1s"></a>
            <span class="cancel" data-cancel-itme="A"><i class="fa fa-fw fa-times"></i></span>
          </li>
          <li>
            <a href="" data-lorem="1s"></a>
            <span class="cancel" data-cancel-itme="A"><i class="fa fa-fw fa-times"></i></span>
          </li>
        </ol>
      </div>
    </div>
  </main>
</section>
<?= js_tag("http://maps.google.com/maps/api/js?sensor=false") ?>
<?= js_tag("lib/gmaps/gmaps.js") ?>
<?= js_tag("frontsite/contact.js") ?>