<!DOCTYPE html>
<html ng-app="myApp">

<head>
  <title>Edusol</title>
  <!--<script data-require="jquery@*" data-semver="2.0.3" src="http://code.jquery.com/jquery-2.0.3.min.js"></script>-->
  <script data-require="jquery@*" data-semver="2.0.3" src="vendor/jquery-3.1.0.min.js"></script>

  <!--<script data-require="angular.js@1.2.13" data-semver="1.2.13" src="http://code.angularjs.org/1.2.13/angular.js"></script>-->
  <script data-require="angular.js@1.2.13" data-semver="1.2.13" src="vendor/angular-1.2.13/angular.js"></script>
  <!--<script data-require="angular.js@1.2.13" data-semver="1.2.13" src="http://code.angularjs.org/1.2.13/angular-animate.js"></script>-->
  <script data-require="angular.js@1.2.13" data-semver="1.2.13" src="vendor/angular-1.2.13/angular-animate.js"></script>

<!-- Latest compiled and minified CSS -->
<!--<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css">-->
<link rel="stylesheet" href="vendor/bootstrap.min.css">
<!-- Latest compiled and minified JavaScript -->
<!--<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js"></script>-->
<script src="vendor/bootstrap.min.js"></script>

  <link rel="stylesheet" href="style.css" />
  <link rel="stylesheet" href="css/font-awesome.min.css"/>
  <script src="app.js"></script>
</head>
    <body>
        <div class="container">
            <div ng-controller="myController">
                <div class = "row" ng-model="template">
                    <br>
                    <div class="page-content">
                        <div class="alert alert-success" role="alert">The mark <span style="font-weight: bold;">80</span> has been added to <span style="font-weight: bold;">Saint-Cyr MAPOUKA - #STD123</span> successfully !</div>
                    <!--<div class="alert alert-danger" role="alert">Oh snap ! something went wrong when adding mark for Saint-Cyr MAPOUKA</div>-->
                    <div class="col-lg-4">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                General Informations
                            </div>
                            <div class="panel-body">
                                <div class="col-xs-12 col-sm-12" style="color: black;">
                                    <p> <strong>Class: <span style="color: blue;"> GRAD 1 </span></strong></p>
                                    <p> <strong>Term: <span style="color: blue;"> Three </span></strong></p>
                                    <p> <strong>Student Number: <span style="color: blue;"> 60 </span></strong></p>
                                    <p> <strong>Highest Class Mark: <span style="color: blue;"> 90 % </span></strong></p>
                                    <p> <strong>Avarage Class Mark: <span style="color: blue;"> 75 % </span></strong></p>
                                    <p> <strong>Lowest Class Mark: <span style="color: blue;"> 60 % </span></strong></p>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                               Current Student
                            </div>
                            <div class="panel-body">
                                <div class="col-xs-12 col-sm-12" style="color: black;">
                                    <p> <strong>Full Name: <span ng-bind="studentName" style="color: blue;"> {{ studentName }} </span></strong></p>
                                    <p> <strong>Last Mark: <span ng-bind="lastMark" style="color: blue;"> {{ lastMark }} </span></strong></p>
                                    <p> <strong>Last Position: <span ng-bind="lastPosition" style="color: red;"> {{ lastPosition }} </span></strong></p>
                                    <p> <strong>Student #ID: <span ng-bind="studentId" style="color: blue;"> {{ studentId }} </span></strong></p>
                                    <p> <strong>Last Performance: <span ng-bind="performance" style="color: red;"> {{ performance }} </span></strong></p>
                                    <p> <strong>Parent phone: <span ng-bind="parentPhone" style="color: red;"> {{ parentPhone }} </span></strong></p>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="">
                            <img src = "{{ picture }}" alt = "Generic placeholder thumbnail" class="img-thumbnail" width="260px">
                        </div>
                    </div>
                    <div class = "col-sm-6 col-md-3">
                      
                       <div class = "caption">
                           <br>
                           <input type="text", class="form-control" ng-model="currentMark" placeholder="Input the current mark"/> 
                          <form ng-submit="getStudent()">
                              <input style="opacity: 0.5;" autocomplete="off" type="text" ng-model="barcode" autofocus="" id="barcode" rfocus="Input1"/>
                          </form>
                              <p  ng-click="submission()" class = "btn btn-primary" role = "button">
                                Save & Next
                             </p> 
                          </p>
                       </div>
                    </div>
                </div>
                
            </div>
        </div>
    </body>
    <script>
        
        var students = [
            {"id":1, "name":"Saint-Cyr MAPOUKA", "barcode":"9780964729230", "lastMark":18.50, "picture":"2.jpg",
            "parentPhone":"+233 000 000 00", "lastPosition":"2nd", "performance":"EXTRA ORDINARY"},
            {"id":2, "name":"Mexan MAPOUKA", "barcode":"8992929754008", "lastMark":19.50, "picture":"mexan.jpg", 
                "parentPhone":"+233 268 568 006", "lastPosition":"1st", "performance":"EXCELLENT"}
        ];
        
        
        angular.module('myApp', []).controller('myController', ['$scope', '$http', function myController($scope, $http){
                $scope.studentName = '';
                $scope.studentId = '';
                $scope.lastMark = '';
                $scope.picture = 'blank.jpg';
                
            
            $scope.submission = function(){
                    alert('Name: '+$scope.studentName+', ID: '+$scope.studentId+', Current Mark: '+$scope.currentMark+', Barcode: '+$scope.barcode);
                    //Send it to the server
                    $http.get('http://localhost/TEST/index2.json').success(function(response){
                });
                $scope.studentName = '';
                $scope.studentId = '';
                $scope.lastMark = '';
                $scope.barcode = '';
                
                
            }
            
            
            
            $scope.getStudent = function(){
                for(var key in students){
                    if(students[key].barcode == $scope.barcode){
                        $scope.studentName = students[key].name;
                        $scope.studentId = students[key].id;
                        $scope.lastMark = students[key].lastMark;
                        $scope.picture = students[key].picture;
                        $scope.parentPhone = students[key].parentPhone;
                        $scope.lastPosition = students[key].lastPosition;
                        $scope.performance = students[key].performance;
                    }  
                }
            }
            
            
        }]);
    
        
    myApp.directive('rfocus',function(){
    return {
        restrict: 'A',
        controller: function($scope, $element, $attrs){
            var fooName = 'setFocus' + $attrs.rfocus; 
            $scope[fooName] = function(){
                $element.focus();                
            } 
        },
    }    
});
  
        
    </script>
</html>

