<!DOCTYPE html>
<html ng-app="myApp">

<head>
  <title>Point of Sale Interface</title>
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
  <script src="app.js"></script>
</head>

<body data-ng-controller="POSController">
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <div class="jumbotron">
          <h2><span class="text-warning">Morning</span> <span class="text-success">Food</span></h2>
          <span class="pull-right text-muted">Today is Jan 14, 2015</span>
          <div class="text-muted">1429 Stockholm, Sweden</div>
        </div>
      </div>
    </div>

    <div class="row">
      <form name="itemForm">
    
          <input type="password" name="barcode"  style="opacity: 0;" id="barcodeId"
                 ng-model="barcode" ng-model-options="{ debounce: 500 }" autofocus="true" ng-focus="focused()" ng-blur="blurred()"/>
    </label>
    <br />
    
  </form>
  
      <div class="col-sm-6" onclick="document.getElementById('barcodeId').focus(); return false;">
          <a href="" ><img src="barecode.jpg" width="200" for="barcodeId"/></a>
          <span ng-model="fileName">
              <img src="{{ fileName }}.jpg" width="234"/>
          </span>
          <span ng-model="focusImage">
              <img src="{{ focusImage }}.gif" width="70"/>
          </span>
          
      </div>

      <div class="col-sm-6">
        <div class="well">
          <div class="panel panel-primary">
            <div class="panel-heading">
              <h3 class="panel-title">Order Summary</h3>
            </div>
            <div class="panel-body" style="max-height:320px; overflow:auto;">
              <div class="text-warning" ng-hide="order.length">
                Noting ordered yet !
              </div>
              <ul class="list-group">
                <li class="list-group-item" ng-repeat="item in order">
                  <span> {{item.detail}}</span>
                  
                  <div class="btn-group pull-right" role="group" aria-label="...">
                      <button type="button" class="btn btn-xs " ng-disabled="" ng-click="subtractItem(item, $index)">
                        <span type="button" class="glyphicon glyphicon-minus"></span>
                      </button>
                      <button type="button" class="btn  btn-xs" ng-click="addItem(item, $index)">
                        <span class="glyphicon glyphicon-plus"></span>
                      </button>
                       <button type="button" class="btn btn-danger btn-xs"  ng-click="deleteItem($index)">
                        <span class="glyphicon glyphicon-trash"></span>
                      </button>                     
                  </div>
                  <div class="label label-success pull-right">${{item.totalPrice}}</div>
                  <div class="label label-default pull-right">{{item.orderedItemCnt}}</div>

                </li>
              </ul>

            </div>
            <div class="panel-footer" ng-show="order.length">
              <div class="label label-danger ">Total: ${{getSum()}}</div>
            </div>
            <div class="panel-footer" ng-show="order.length">
              <div class="text-muted">
                Do not let go of customer without taking payment !
              </div>
            </div>
            <div class="pull-right">
                <input type="text" ng-model="cacheAmount" />
                <span class="btn btn-default" ng-click="getChange()" ng-disabled="!order.length">
                    {{ getChange() }}
                </span>
              <span class="btn btn-default" ng-click="clearOrder()" ng-disabled="!order.length">Clear</span>
              <span class="btn btn-danger" ng-click="checkout()" ng-disabled="!order.length">Checkout</span>
            </div>

          </div>
        </div>
      </div>
    </div>
  </div>

</body>

</html>

