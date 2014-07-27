<header class="navigation">
  <h1 class="site-name" title="良錡石材">
    <span class="hide">良錡石材</span>
    <?= img_tag("frontend/nav-logo.png", array(titile=>"良錡石材 商標", alt=>"良錡石材 商標")) ?>
  </h1>
  <nav role="navigation">
    <h2 class="hide">網站主選單</h2>
    <ul class="mune-group list-unstyled">
      <li class="mune-item">
        <p class="mune-title"><i class="icon"></i><span class="en">Cllections</span><span class="zh">石 材 系 列</span></p>
        <div class="mune-sub-group">
          <h3 class="mune-sub-title"><span class="hide">石材系列</span>Cllections</h3>
          <div class="tag-list">
            <ul class="list-inline">
              <li class="tag-item"><a href="#">華麗</a></li>
              <li class="tag-item"><a href="#">極簡</a></li>
              <li class="tag-item"><a href="#">新品</a></li>
              <li class="tag-item"><a href="#">特價優惠</a></li>
              <li class="tag-item"><a href="#">深色</a></li>
              <li class="tag-item"><a href="#">特價優惠</a></li>
              <li class="tag-item"><a href="#">淺色</a></li>
              <li class="tag-item"><a href="#">花紋</a></li>
              <li class="tag-item"><a href="#">新品</a></li>
              <li class="more"><a href="">更多標籤<i class="fa fa-fw fa-angle-right"></i></a></li>
            </ul>
          </div>
          <div class="mune-sub">
            <ul class="list-unstyled">
              <?php $categories = Category::all_with_quantity('product'); foreach ($categories as $category) { ?>
                <li class="mune-sub-item">
                  <a href="/collections?category=<?= $category['id'] ?>">
                    <?= $category['name'] ?>
                  </a>
                </li>
              <?php } ?>
                <li><a href="">1</a></li>
                <li><a href="">2</a></li>
                <li><a href="">3</a></li>
                <li><a href="">4</a></li>
                <li><a href="">5</a></li>
                <li><a href="">6</a></li>
                <li><a href="">7</a></li>
                <li><a href="">8</a></li>
                <li><a href="">9</a></li>
                <li><a href="">10</a></li>
                <li><a href="">11</a></li>
                <li><a href="">12</a></li>
                <li><a href="">13</a></li>
                <li><a href="">14</a></li>
                <li><a href="">15</a></li>
                <li><a href="">16</a></li>
                <li><a href="">17</a></li>
                <li><a href="">18</a></li>
                <li><a href="">19</a></li>
                <li><a href="">20</a></li>
                <li><a href="">21</a></li>
                <li><a href="">22</a></li>
                <li><a href="">23</a></li>
                <li><a href="">24</a></li>
                <li><a href="">25</a></li>
                <li><a href="">26</a></li>
                <li><a href="">27</a></li>
                <li><a href="">28</a></li>
                <li><a href="">29</a></li>
                <li><a href="">30</a></li>
                <li><a href="">31</a></li>
                <li><a href="">32</a></li>
                <li><a href="">33</a></li>
                <li><a href="">34</a></li>
                <li><a href="">35</a></li>
                <li><a href="">36</a></li>
                <li><a href="">37</a></li>
                <li><a href="">38</a></li>
                <li><a href="">39</a></li>
                <li><a href="">40</a></li>
                <li><a href="">41</a></li>
                <li><a href="">42</a></li>
                <li><a href="">43</a></li>
                <li><a href="">44</a></li>
                <li><a href="">45</a></li>
                <li><a href="">46</a></li>
                <li><a href="">47</a></li>
                <li><a href="">48</a></li>
                <li><a href="">49</a></li>
                <li><a href="">50</a></li>
                <li><a href="">51</a></li>
                <li><a href="">52</a></li>
                <li><a href="">53</a></li>
                <li><a href="">54</a></li>
                <li><a href="">55</a></li>
                <li><a href="">56</a></li>
                <li><a href="">57</a></li>
                <li><a href="">58</a></li>
                <li><a href="">59</a></li>
                <li><a href="">60</a></li>
                <li><a href="">61</a></li>
                <li><a href="">62</a></li>
                <li><a href="">63</a></li>
                <li><a href="">64</a></li>
                <li><a href="">65</a></li>
                <li><a href="">66</a></li>
                <li><a href="">67</a></li>
                <li><a href="">68</a></li>
                <li><a href="">69</a></li>
                <li><a href="">70</a></li>
                <li><a href="">71</a></li>
                <li><a href="">72</a></li>
                <li><a href="">73</a></li>
                <li><a href="">74</a></li>
                <li><a href="">75</a></li>
                <li><a href="">76</a></li>
                <li><a href="">77</a></li>
                <li><a href="">78</a></li>
                <li><a href="">79</a></li>
                <li><a href="">80</a></li>
                <li><a href="">81</a></li>
                <li><a href="">82</a></li>
                <li><a href="">83</a></li>
                <li><a href="">84</a></li>
                <li><a href="">85</a></li>
                <li><a href="">86</a></li>
                <li><a href="">87</a></li>
                <li><a href="">88</a></li>
                <li><a href="">89</a></li>
                <li><a href="">90</a></li>
                <li><a href="">91</a></li>
                <li><a href="">92</a></li>
                <li><a href="">93</a></li>
                <li><a href="">94</a></li>
                <li><a href="">95</a></li>
                <li><a href="">96</a></li>
                <li><a href="">97</a></li>
                <li><a href="">98</a></li>
                <li><a href="">99</a></li>
                <li><a href="">100</a></li>
            </ul>
          </div>
        </div>
      </li>
      <li class="mune-item">
        <p class="mune-title"><i class="icon"></i><span class="en">Case Study</span><span class="zh">成 功 案 例</span></p>
        <div class="mune-sub-group">
          <h3 class="mune-sub-title"><span class="hide">成功案例</span>Case Study</h3>
          <div class="tag-list">
            <ul class="list-inline">
              <li class="tag-item"><a href="#">華麗</a></li>
              <li class="tag-item"><a href="#">極簡</a></li>
              <li class="tag-item"><a href="#">新品</a></li>
              <li class="tag-item"><a href="#">特價優惠</a></li>
              <li class="tag-item"><a href="#">深色</a></li>
              <li class="tag-item"><a href="#">特價優惠</a></li>
              <li class="tag-item"><a href="#">淺色</a></li>
              <li class="tag-item"><a href="#">花紋</a></li>
              <li class="tag-item"><a href="#">新品</a></li>
              <li class="more"><a href="">更多標籤<i class="fa fa-fw fa-angle-right"></i></a></li>
            </ul>
          </div>
          <div class="mune-sub">
            <ul class="list-unstyled">
              <?php $categories = Category::all_with_quantity('case'); foreach ($categories as $category) { ?>
                <li class="mune-sub-item">
                  <a href="/case_study?category=<?= $category['id'] ?>">
                    <?= $category['name'] ?>
                  </a>
                </li>
              <?php } ?>
            </ul>
          </div>
        </div>
      </li>
      <li class="mune-item">
        <p class="mune-title"><i class="icon"></i><span class="en">Blog</span><span class="zh">部 落 格</span></p>
        <div class="mune-sub-group">
          <h3 class="mune-sub-title"><span class="hide">部落格</span>Blog</h3>
          <div class="tag-list">
            <ul class="list-inline">
              <li class="tag-item"><a href="#">華麗</a></li>
              <li class="tag-item"><a href="#">極簡</a></li>
              <li class="tag-item"><a href="#">新品</a></li>
              <li class="tag-item"><a href="#">特價優惠</a></li>
              <li class="tag-item"><a href="#">深色</a></li>
              <li class="tag-item"><a href="#">特價優惠</a></li>
              <li class="tag-item"><a href="#">淺色</a></li>
              <li class="tag-item"><a href="#">花紋</a></li>
              <li class="tag-item"><a href="#">新品</a></li>
              <li class="more"><a href="">更多標籤<i class="fa fa-fw fa-angle-right"></i></a></li>
            </ul>
          </div>
          <div class="mune-sub">
            <ul class="list-unstyled">
              <?php $categories = Category::all_with_quantity('article'); foreach ($categories as $category) { ?>
                <li class="mune-sub-item">
                  <a href="/blog?category=<?= $category['id'] ?>">
                    <?= $category['name'] ?>
                  </a>
                </li>
              <?php } ?>
            </ul>
          </div>
        </div>
      </li>
      <li class="mune-item">
        <p class="mune-title"><a href="/about_us"><i class="icon"></i><span class="en">About US</span><span class="zh">關 於 良 錡</span></a></p>
      </li>
      <li class="mune-item">
        <p class="mune-title"><a href="/contact"><i class="icon"></i><span class="en">Contact</span><span class="zh">聯 絡 我 們</span></a></p>
      </li>
      <li class="mune-item search">
        <input type="checkbox" id="search" class="hide">
        <p class="mune-title"><label for="search"><i class="icon"></i><span class="en">Search</span><span class="zh">搜 尋</span></label></p>
        <label class="overlay" for="search"></label>
        <form class="search-box">
          <input type="text" name="search" placeholder="您可搜尋新聞、產品、anything...">
          <button tyoe="submit">SEARCH</button>
        </form>
      </li>
    </ul>
  </nav>
  <nav class="social" role="social media menu">
    <h2 class="hide">社交平台選單</h2>
    <ul class="social-mune list-unstyled">
      <li><a href="https://www.facebook.com/pages/良錡石材-水晶時代各種石材設計與裝潢介紹/107145262639568"><i class="icon icon-fb"></i>facebook</a></li>
      <li><a href="#"><i class="icon icon-google-plus"></i>google+</a></li>
      <li><a href="#"><i class="icon icon-mail"></i>mail</a></li>
    </ul>
  </nav>
</header>