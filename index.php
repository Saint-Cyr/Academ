<!DOCTYPE html>
<html>

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
            <div>
                <div class = "row" ng-model="template">
                    <br>
                    <div class="page-content">
                        <div class="alert alert-success" role="alert">The mark <span style="font-weight: bold;"> <span ng-bind="mark">{{ mark }}</span></span> has been added to <span style="font-weight: bold;">Saint-Cyr MAPOUKA - #STD123</span> successfully !</div>
                    <!--<div class="alert alert-danger" role="alert">Oh snap ! something went wrong when adding mark for Saint-Cyr MAPOUKA</div>-->
                    <div class="col-lg-4">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                General Informations
                            </div>
                            <div class="panel-body">
                                <div class="col-xs-12 col-sm-12" style="color: black;">
                                    <p> <strong>Class: <span id="class" style="color: blue;"> GRAD 1 </span></strong></p>
                                    <p> <strong>Term: <span id="term" style="color: blue;"> Three </span></strong></p>
                                    <p> <strong>Student Number: <span id="class_student_number" style="color: blue;"> 60 </span></strong></p>
                                    <p> <strong>Highest Class Mark: <span id="hight_mark" style="color: blue;"> 90 % </span></strong></p>
                                    <p> <strong>Avarage Class Mark: <span id="average_mark" style="color: blue;"> 75 % </span></strong></p>
                                    <p> <strong>Lowest Class Mark: <span id="low_mark" style="color: blue;"> 60 % </span></strong></p>
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
                                    <p> <strong>Full Name: <span id="student_name" style="color: blue;">  </span></strong></p>
                                    <p> <strong>Last Mark: <span id="student_last_mark" style="color: blue;">  </span></strong></p>
                                    <p> <strong>Last Position: <span id="student_last_position" style="color: red;">  </span></strong></p>
                                    <p> <strong>Student #ID: <span id="student_id" style="color: blue;">  </span></strong></p>
                                    <p> <strong>Last Performance: <span id="student_performance" style="color: red;">  </span></strong></p>
                                    <p> <strong>Parent phone: <span id="student_parent_phone" style="color: red;">  </span></strong></p>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="">
                            <img id="student_image" src="next.jpg" alt="Generic placeholder thumbnail" class="img-thumbnail" width="260px">
                        </div>
                    </div>
                    <div class = "col-sm-6 col-md-3">
                      
                       <div class = "caption">
                           <br>
                           <form onsubmit="submission()">
                               <input required="required" type="text", class="form-control" id="current_mark"
                                      style="opacity: 0"  placeholder="Input the current mark"/>
                               
                           </form>
                           <button id="pause">Pause</button>
                                                       
                            
                         
                       </div>
                    </div>
                </div>
                
            </div>
        </div>
    </body>
    <script type="text/javascript" src="lib/jquery.scannerdetection.js"></script>
    <script type="text/javascript">
        
        var students = [
            {"id":1, "name":"Saint-Cyr MAPOUKA", "barcode":"6951670901262", "last_mark":18.50, "image":"2.jpg",
            "parent_phone":"+233 000 000 00", "last_position":"2nd", "performance":"EXTRA ORDINARY"},
            {"id":2, "name":"Mexan MAPOUKA", "barcode":"2001532314403", "lastMark":19.50, "picture":"2.jpg", 
                "parentPhone":"+233 268 568 006", "lastPosition":"1st", "performance":"EXCELLENT"}
        ];
        
        function submission(){
            alert('submitted !');
            $('#student_image').attr('src', '1.gif');
        }
        
        

        
	$(document).scannerDetection({
	timeBeforeScanTest: 200, // wait for the next character for upto 200ms
	startChar: [120], // Prefix character for the cabled scanner (OPL6845R)
	endChar: [13], // be sure the scan is complete if key 13 (enter) is detected
	avgTimeByChar: 40, // it's not a barcode if a character takes longer than 40ms
	onComplete: function(barcode, qty){
            //Set the found variable to true
            if(students.includes(students.barcode)){alert("OK");}
            var found = true;
            for(var key in students){
                    if(students[key].barcode && (students[key].barcode == barcode)){
                        $('#student_name').text(students[key].name);
                        $('#student_id').text(students[key].id);
                        $('#student_last_mark').text(students[key].last_mark);
                        $('#student_image').text(students[key].image);
                        $('#student_parent_phone').text(students[key].parent_phone);
                        $('#student_last_position').text(students[key].last_position);
                        $('#student_performance').text(students[key].performance);
                        $('#student_image').attr('src', students[key].image);
                        $('#current_mark').focus();
                        //Change the value style attibute
                        $('#current_mark').attr('style', 'opacity: 1');
                        break;
                    }else{
                        var audioElement = document.createElement('audio');
                        audioElement.setAttribute('src', '1.mp3');
                        audioElement.play();
                        $('#student_image').attr('src', '11.jpg');
                        //audioElement.pause();
                        alert('Sorry this student is not part of Section 5em 2');
                    }
        
            }}        	
    });
    
    
    
    </script>
</html>

