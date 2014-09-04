<html>
  <head>
    <title>Lc Stone 客戶詢問</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  </head>
  <body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" style="background-color: #f4f3f9;">
    <table id="ask" width="800" border="0" cellpadding="0" cellspacing="0" style="margin: 0 auto">
      <tr>
        <td colspan="3">
          <img src="http://nowyoufindme.no-ip.org:8888/public/email/edm_01.png" width="800" height="192" alt="" style="display: block;">
        </td>
      </tr>
      <tr>
        <td style="width: 104px;">
          <img src="http://nowyoufindme.no-ip.org:8888/public/email/edm_02.png" width="104" height="136" alt="" style="display: block;">
        </td>
        <td style="width: 588px; height: 136px; background: url(http://nowyoufindme.no-ip.org:8888/public/email/edm_03.png) center no-repeat transparent; vertical-align: top;">
          <h1 style="line-height: 68px; margin: 1.5em 0 0; text-align: center; font-family: '微軟正黑體'; color: #5F5A5D;">
            <?php if ($productList) {
              echo '產品詢問';
            } else {
              echo "訪客來信";
            } ?>
          </h1>
        </td>
        <td style="width: 108px;">
          <img src="http://nowyoufindme.no-ip.org:8888/public/email/edm_04.png" width="108" height="136" alt="" style="display: block;">
        </td>
      </tr>
      <tr>
        <td colspan="3" style="background: url(http://nowyoufindme.no-ip.org:8888/public/email/edm_05.png) center repeat-y transparent;">
          <div style="width: 550px; margin: 0 auto; color: #585858;">
            <table style="color: #585858;">
              <tbody style="font-size: 14px; line-height: 2em;">
                <tr>
                  <td style="width: 18%; padding: 10px 0; vertical-align: top; font-weight: bold; text-align: right;">訪客姓名：</td>
                  <td style="width: 82%; padding: 10px 0; vertical-align: top;"><?= $guest ?></td>
                </tr>
                <?php if ($company) { ?>
                  <tr>
                    <td style="width: 18%; padding: 10px 0; vertical-align: top; font-weight: bold; text-align: right;">單位：</td>
                    <td style="width: 82%; padding: 10px 0; vertical-align: top;"><?= $company ?></td>
                  </tr>
                <?php } ?>
                <tr>
                  <td style="width: 18%; padding: 10px 0; vertical-align: top; font-weight: bold; text-align: right;">E-Mail：</td>
                  <td style="width: 82%; padding: 10px 0; vertical-align: top;">
                    <a href="mailto:<?= $email ?>" target="_blank" style="text-decoration: blink; color: #42AED8;"><?= $email ?></a>
                  </td>
                </tr>
                <tr>
                  <td style="width: 18%; padding: 10px 0; vertical-align: top; font-weight: bold; text-align: right;">留言內容：</td>
                  <td style="width: 82%; padding: 10px 0; vertical-align: top;"><?= $message ?></td>
                </tr>
              </tbody>
            </table>
            <?php if ($productList) { ?>
              <hr style="border-style: dashed; border-color: #D3D3D3; border-width: 1px 0 0; margin-bottom: 2em;">
              <h2 style="font-size: 16px; text-align: center;">產品詢問清單</h2>
              <ol style="list-style: none; padding: 0; width: 100%; margin: 0 auto;">
                <li style="padding: 5px; font-size: 14px; line-height: 30px; float: left; width: 45%; margin-bottom: 1em;">
                  <div style="float: left; width: 30px; height: 30px; border-radius: 50%; overflow: hidden;">
                    <img src="http://nowyoufindme.no-ip.org:8888/files/assets/3/thumb/l_stone03.jpg" alt="" style="width: 100%; height: 100%;">
                  </div>
                  <a href="/collections/12" target="_blink" style="display: inline-block; margin-left: 10px; text-decoration: blink; color: #42AED8;">黃木紋亂片</a>
                </li>
                <li style="padding: 5px; font-size: 14px; line-height: 30px; float: left; width: 45%; margin-bottom: 1em;">
                  <div style="float: left; width: 30px; height: 30px; border-radius: 50%; overflow: hidden;">
                    <img src="http://nowyoufindme.no-ip.org:8888/files/assets/3/thumb/l_stone03.jpg" alt="" style="width: 100%; height: 100%;">
                  </div>
                  <a href="/collections/12" target="_blink" style="display: inline-block; margin-left: 10px; text-decoration: blink; color: #42AED8;">黃木紋亂片</a>
                </li>
                <li style="padding: 5px; font-size: 14px; line-height: 30px; float: left; width: 45%; margin-bottom: 1em;">
                  <div style="float: left; width: 30px; height: 30px; border-radius: 50%; overflow: hidden;">
                    <img src="http://nowyoufindme.no-ip.org:8888/files/assets/3/thumb/l_stone03.jpg" alt="" style="width: 100%; height: 100%;">
                  </div>
                  <a href="/collections/12" target="_blink" style="display: inline-block; margin-left: 10px; text-decoration: blink; color: #42AED8;">黃木紋亂片</a>
                </li>
              </ol>
            <?php } ?>
          </div>
        </td>
      </tr>
      <tr>
        <td colspan="3">
          <img src="http://nowyoufindme.no-ip.org:8888/public/email/edm_06.png" width="800" height="70" alt="" style="display: block;">
        </td>
      </tr>
    </table>
  </body>
</html>