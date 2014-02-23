<!DOCTYPE html>
<html ng-app="intrepidApp" ng-controller="AppCtrl">
  <head>
    <title ng-bind="pageTitle"></title>

    <meta charset="UTF-8">

    <!-- font awesome from BootstrapCDN -->
    <link href="http://netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.css" rel="stylesheet">

    <!-- compiled CSS -->
    <link rel="stylesheet" type="text/css" href="assets/ng-boilerplate-0.3.1.css" />

    <!-- compiled JavaScript -->
    <script type="text/javascript" src="vendor/angular/angular.js"></script>
    <script type="text/javascript" src="vendor/angular-bootstrap/ui-bootstrap-tpls.min.js"></script>
    <script type="text/javascript" src="vendor/placeholders/angular-placeholders-0.0.1-SNAPSHOT.min.js"></script>
    <script type="text/javascript" src="vendor/angular-ui-router/release/angular-ui-router.js"></script>
    <script type="text/javascript" src="vendor/angular-ui-utils/modules/route/route.js"></script>
    <script type="text/javascript" src="src/app/404/404.js"></script>
    <script type="text/javascript" src="src/app/404/404.specc.js"></script>
    <script type="text/javascript" src="src/app/about/about.js"></script>
    <script type="text/javascript" src="src/app/app.js"></script>
    <script type="text/javascript" src="src/app/forum/forum.js"></script>
    <script type="text/javascript" src="src/app/home/home.js"></script>
    <script type="text/javascript" src="src/app/login/login.js"></script>
    <script type="text/javascript" src="src/app/members/members.js"></script>
    <script type="text/javascript" src="src/app/register/register.js"></script>
    <script type="text/javascript" src="templates-common.js"></script>
    <script type="text/javascript" src="templates-app.js"></script>

  </head>

<body>
  <div id="wrapper">

    <div id="header-wrapper">
      <div id="header-holder">
      <div id="title">
        Intrepid Gaming
      </div>

      <div id="navigation">
        <ul>
          <a href="#/"><li>Home</li></a>
          <a href="#/forum"><li>Forum</li></a>
          <a href="#/members"><li>Members</li></a>
          <a href="#/register"><li>Sign up</li></a>
        </ul>
      </div>

      <div id="nav-padder"></div>
      </div>
    </div>
    <div class="cl"></div>

    <div id="body-wrapper">

      <div id="container">
        <div class="title">
          title comes here yo
        </div>
        <div class="container-body"  ui-view="main"></div>      
        <div class="foot">
        </div>
      </div>
    </div>

    <div id="footer-wrapper">

      <div id="footer-padder">
      </div>
      <div id="footer-base">
      <div id="footer-text">
        YOLO
      </div>
    </div>
      <div id="footer-bottom-padder"></div>
    </div>

  </div>
</body>
</html>
