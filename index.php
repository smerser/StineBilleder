<?php
include('login.php');   // Code
$is_ok = checklogin();  // Call
$display = 'none';
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="author"     content="Soren Merser">
        <meta name="copyright"  content="Copyright &copy; 2017 Soren Merser">
        <meta name="viewport"   content="width=device-width, initial-scale=1.0">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.4.8/angular.min.js"></script>
        <link rel="stylesheet" type="text/css" href="static/css/index.css">

        <script>

            $(document).ready(function(){

                $('#pwd').focus();

    /*          // Zoom thumbnails on mouse over
                $('img').hover(function() {
                        $(this).animate({ width: "100%", height: "100%" });
                     }).mouseleave( function () {
                        $(this).animate({ width: "16", height: "16" });
                });
    */

               $('#imgBig').click(function() {
                    $('#imgBig').attr("src", "").hide();
                    $('#overlay').css('display', 'none').hide();
                    $('#overlayContent').css('overflow', 'hidden').hide();
                });

            });     // END DOCUMENT.READY.FUNCTION

        </script>

        <title>Stines Billeder</title>
    </head>

    <body>
        <div id="overlay"></div>
        <div id="overlayContent">
            <img id="imgBig" src="" alt="" width="800"></div>
            <br/><img src="static/img/StineSjogrenMerser.gif" width="66%">
            <h2> Lotus Regnbue Billeder </h2>


<?php

if($is_ok){
    $display = 'display';

    class SortingIterator implements IteratorAggregate
    {

            private $iterator = null;

            public function __construct(Traversable $iterator, $callback)
            {
                    if (!is_callable($callback)) {
                            throw new InvalidArgumentException('Given callback is not callable!');
                    }

                    $array = iterator_to_array($iterator);
                    usort($array, $callback);
                    $this->iterator = new ArrayIterator($array);
            }

            public function getIterator()
            {
                    return $this->iterator;
            }
    }

    function mysort($a, $b)
    {
            //return $a->getPathname() > $b->getPathname();
            return filemtime($a) < filemtime($b);   // new first
    }


    $it = new SortingIterator(new RecursiveIteratorIterator(new RecursiveDirectoryIterator('./Fotos/')), 'mysort');


    $i = 1;
    $source = array();
    foreach ($it as $file) {
        $ext  = strtolower(pathinfo($file, PATHINFO_EXTENSION));
        $time = filemtime($file);
        $date = date("d F Y", $time);
        if(exif_imagetype($file) &&  $ext != 'ico' && $ext != 'gif'){
            $file = substr($file->getPathname(), 8);
            array_push($source, ['ref'=>$i, 'filename'=>$file, 'date'=>$date, 'time'=>$time]);
            $i++;
        }
    }

    }   // END LOGIN

?>  <!-- END PHP -->

        <script>

            // Angular app
            var my_app = angular.module('BilledApp', []).config(function($interpolateProvider) {
              $interpolateProvider.startSymbol('{$');
              $interpolateProvider.endSymbol('$}');
            });

            my_app.controller("AppCtrl", function($scope){
                $scope.data     = <?php echo json_encode($source); ?>;
                $scope.sortBy   = ['-time']; // new first
                $scope.goto     = function(path) {
                    $('#imgBig').attr("src", 'Fotos/'+ path).show();
                    $('#overlayContent').show();
                    $('#overlay').show();
                    }
                }
            );

        </script>

        <div ng-app="BilledApp" ng-controller="AppCtrl" class="container">
            <table class='center scroll' style="display:<?php echo $display; ?>">
                <thead>
                    <tr>
                        <td class="search"><input placeholder="Find ref."   ng-model="search.ref" size="12">     </td>
                        <td class="search"><input placeholder="Find billed" ng-model="search.filename" size="22"></yd>
                        <td class="search"><input placeholder="Find dato"   ng-model="search.date" size="22">    </td>
                        <td> </td>
                    </tr>
                    <tr>
                         <th ng-click="sortBy=['ref'];      reverse=!reverse;"> &#x2195; Ref. </th>
                         <th ng-click="sortBy=['filename']; reverse=!reverse;"> &#x2195; Navn </th>
                         <th ng-click="sortBy=['time'];     reverse=!reverse;"> &#x2195; Dato </th>
                         <th> </th>
                    </tr>
                </thead>
                <tbody class="hover">
                    <tr ng:repeat="row in data  | filter:search:strict | orderBy:sortBy:reverse as result" ng-click="goto(row.filename)">
                        <td class="ref">  # {$ row.ref $}                               </td>
                        <td>                {$ row.filename $}                          </td>
                        <td>                {$ row.date $}                              </td>
                        <td> <img src="{$ row.filename $}.gif" height="16" width="16"/> </td>
                    </tr>
                </tbody>
            </table>
        </div>  <!-- End div.container -->

    </body>
<html>

