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
    <script type="text/javascript" src="vendor/angular-cookies/angular-cookies.min.js"></script>
    <script type="text/javascript" src="src/app/404/404.js"></script>
    <script type="text/javascript" src="src/app/404/404.specc.js"></script>
    <script type="text/javascript" src="src/app/about/about.js"></script>
    <script type="text/javascript" src="src/app/app.js"></script>
    <script type="text/javascript" src="src/app/forum/forum.js"></script>
    <script type="text/javascript" src="src/app/forum/post.js"></script>
    <script type="text/javascript" src="src/app/forum/topic.js"></script>
    <script type="text/javascript" src="src/app/home/home.js"></script>
    <script type="text/javascript" src="src/app/login/login.js"></script>
    <script type="text/javascript" src="src/app/members/members.js"></script>
    <script type="text/javascript" src="src/app/register/register.js"></script>
    <script type="text/javascript" src="templates-common.js"></script>
    <script type="text/javascript" src="templates-app.js"></script>

  </head>

<body>
  <div id="wrapper">

    <div id="wrapper-header">
      
      <div id="header-holder">

        <div id="header-title">
          Intrepid Gaming
        </div>
          <div id="header-navigation">
            <ul>
              <a href="#/"><li>Home</li></a>
              <a href="#/forum"><li>Forum</li></a>
              <a href="#/members"><li>Members</li></a>
              <a href="#/register"><li>Sign up</li></a>
            </ul>
          </div>
        <div class="tab-down"></div>
      </div>
    </div>
    <div class="cl"></div>

    <div id="wrapper-container">
      <div class="tab-up page-title-debug">{{ simplePageTitle }}</div>
      <div id="container-body">

        <div id="upper-container">
          <div class="note">{{ loginMsg }}</div>
          <div id="login-panel-holder">
            <div class="login-style"></div>

              <div class="login-fields" data-ng-show="!currentUser">

                <form data-ng-submit="login()">
                  <input type="text" placeholder="Username..." class="field" data-ng-model="formData.username">
                  <input type="password" placeholder="Password..." class="field" data-ng-model="formData.password"><br>
                  <input type="button" value="Apply" class="button" data-ng-click="redirectToApply()"> 
                  <input type="submit" value="Login" class="button">
                </form>

              </div>

              <div class="login-fields debug-login-fields" data-ng-show="currentUser">
                  <h3>Welcome back, <b>{{ currentUser.username }}</b></h3>
                  <input type="button" value="Log out" class="button button-right" data-ng-click="logout()">
              </div>

            <div class="login-style style-right"></div>
            </div>      
          </div>

        <div id="bottom-container" ui-view="main">

        </div>

      </div>
      <div class="tab-down"></div>
    </div>
    <!-- ... -->
    <div id="wrapper-footer">
      <div class="tab-up"></div>
      <div id="footer-text-holder">
        <div id="footer-text">
          intrepid gaming @ 2014. All rights reserved.
        </div>
      </div>
      <div class="tab-down"></div>
    </div>

  </div>
</body>
</html>
