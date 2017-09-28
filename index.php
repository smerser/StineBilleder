<?php
//    include('login.php');
//error_reporting(0)
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="author"     content="Soren Merser">
        <meta name="copyright"  content="Copyright &copy; 2017 Soren Merser">
        <meta name="viewport"   content="width=device-width, initial-scale=1.0">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.4/angular.min.js"></script>
        <script src="static/js/CollapsibleLists.js"></script>
        <!--<link rel="stylesheet" type="text/css" href="static/css/index2.css">-->

        <script>

            $(document).ready(function(){

                $('#pwd').focus();

                CollapsibleLists.applyTo(document.getElementById('newList'));

                $('#imgBig').click(function() {
                    $('#imgBig').attr("src", "").hide();
                    $('#overlay').css('display', 'none').hide();
                    $('#overlayContent').css('overflow', 'hidden').hide();
                });

                $('a.file').on('click',function(e) {
                    e.preventDefault();
                    var aID = $(this).attr('href');
                    $('#imgBig').attr("src", aID).show();
                    $('#overlayContent').show();
                    $('#overlay').show();
                    });

                $("img.file").show();

            });     // END DOCUMENT.READY.FUNCTION

        </script>

        <title>Stines Billeder</title>

        <style>
            a:not(.file) {
                text-decoration: none;
                font-weight: bold;
                color: black;
                font-size: 18px;
                pointer-events: none;
                cursor: default;
                }
            a.file {
                text-decoration: none;
                text-decoration: underline;
                color: blue;
            }
            ul {
                list-style-type: none;
                margin: auto;
            }
            body {
                padding-top: 5%;
                color: green;
                background-color: lightgrey;
                }
            div {
              display: table;
              margin-right: auto;
              margin-left: auto;
            }
            #overlay {
                position: fixed;
                width: 100%;
                height: 100%;
                top: 0px;
                left: 0px;
                background-color: #000;
                opacity: 1;
                filter: alpha(opacity=70) important;
                display: none;
                z-index: 100;
            }
            #overlayContent {
               position: fixed;
               width: 100%;
               height: 100%;
               top: 100px;
               text-align: center;
               overflow:hidden;
               display: none;
               z-index: 100;
            }
            img.file { height: 32px; width: 32px; vertical-align: middle; }
        </style>

    </head>

    <body>

        <div id="overlay"></div>
        <div id="overlayContent"><img id="imgBig" src="" alt="" width="100%" ></div>

        <div><h1> Lotus Regnbue Billeder </h1></div>
        <img data-scalestrategy="crop" width="300" height="88" src="static/img/PPOnFly.png" style="display:block;">

<?php

    $display = 'none';
//    if(($is_ok = checklogin())) {
        $display = 'display';


        function dir_to_jstree_array($dir, $order = "a", $ext = array()) {
          if(empty($ext)) {
             $ext = array (
                "jpg", "jpeg", "png", "tif", "gif87"
             );
          }

          $listDir = array(
                     'title' => basename($dir),
                'categories' => array()
          );

          $files = array();
          $dirs  = array();

          if($handler = opendir($dir)) {
             while (($sub = readdir($handler)) !== FALSE) {
                if ($sub != "." && $sub != "..") {
                   if(is_file($dir."/".$sub)) {
                      $extension = strtolower(pathinfo($dir."/".$sub, PATHINFO_EXTENSION));
                      if(in_array($extension, $ext)) {
                         $files[] = array(
                             'title' => $sub,
                             'path' => substr($dir, 2),
                             'class' => 'file',
                             'thumbnail' => preg_replace('/\\..+$/', '.gif', $sub)
                         );
                      }
                   }
                   elseif (is_dir($dir."/".$sub)) {
                      $dirs[] = $dir."/".$sub;
                   }
                }
             }

             if($order === "a") {
               asort($dirs);
             }
             else {
                arsort($dirs);
             }

             foreach($dirs as $d) {
                $listDir['categories'][]= dir_to_jstree_array($d);
             }

             if($order === "a") {
                asort($files);
             }
             else {
                arsort($files);
             }

             foreach($files as $file) {
                $listDir['categories'][]= $file;
             }

             closedir($handler);
          }
          return $listDir;
        }   // END FUNCTION dir_to_jstree_array


        $r = json_encode(dir_to_jstree_array("./Fotos"));
//    }   // END LOGIN

?>  <!-- END PHP -->

        <script>

        // Angular app
        var app = angular.module('app', []);

        app.controller('AppCtrl', function ($scope) {
            $scope.categories = [ <?php echo $r; ?> ];
        });

        </script>

        <div ng-app="app" ng-controller='AppCtrl'>
            <script type="text/ng-template" id="categoryTree">
                <a
                    class="{{ category.class }}"
                    href="{{ category.path }}/{{ category.title }}">
                    {{ category.title }}
                    <img class="{{ category.class }}" src="{{ category.path }}/{{ category.thumbnail }}" hidden>
                </a>
                <ul ng-if="category.categories">
                    <li ng-repeat="category in category.categories" ng-include="'categoryTree'">
                    </li>
                </ul>
            </script>
            <ul class="collapsibleList" id="newList">
                <li ng-repeat="category in categories" ng-include="'categoryTree'"></li>
            </ul>
        </div>
                </div>  <!-- End div.container -->
    </body>
<html>

