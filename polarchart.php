<?php 
        global $wpdb;
        $user = wp_get_current_user();
        $userID = $user->ID;
        //print_r($user);
?>   
<script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
<script src="https://www.chartjs.org/dist/2.9.3/Chart.min.js"></script>
<script src="https://www.chartjs.org/samples/latest/utils.js"></script>

<style>
@media screen and (max-width: 992px) {
        table {
            width: 50%;
            font: 17px Calibri;
        }
}
@media screen and (max-width: 992px) {
        table, th, td {
            border: solid 1px #DDD;
            border-collapse: collapse;
            padding: 2px 3px;
            text-align: center;
            width:50;
        }
}

      /* Create four equal columns that floats next to each other */
.column {
  float: left;
  width: 50%;
  padding: 20px;
}

/* Clear floats after the columns */
.row:after {
  content: "";
  display: table;
  clear: both;
}      
            /* On screens that are 992px wide or less, go from four columns to two columns */
@media screen and (max-width: 992px) {
  .column {
    width: 50%;
  }
}
@media screen and (max-width: 1200px) {
  .column {
    width: 50%;
  }
}

/* On screens that are 600px wide or less, make the columns stack on top of each other instead of next to each other */
@media screen and (max-width: 600px) {
  .column {
    width: 100%;
  }
}

                                                    /* Responsive for Table */

    
            /* On screens that are 992px wide or less, go from four columns to two columns */
@media screen and (max-width: 992px) {
  .emptable {
    width: 40%;
  }
}
@media screen and (max-width: 1200px) {
  .emptable {
    width: 40%;
  }
}

/* On screens that are 600px wide or less, make the columns stack on top of each other instead of next to each other */
@media screen and (max-width: 600px) {
  .emptable {
    width: 40%;
  }
}

</style>
<div class="row">
    <div class="column">
        <div>  
            <canvas id="chart-area" height="450" width="600"></canvas>
                <input type="button" id="addRow" value="Add New Row" onclick="addRowLife()" /> 
            <div id="cont">
        <table id="empTable">
    <thead>
<tr>
    <th>#</th>
        <th>Label</th>
            <th>Value</th>
                </tr>
            </thead>
        <tbody>
    </tbody></table>
</div>
    </div>
</div>
    <div class="row">
        <div class="column">
            <div>
         <canvas id="chart-area2" height="450" width="600"></canvas>
    <input type="button" id="addRow2" value="Add New Row" onclick="addRowbusiness()" />
<div id="cont2">
    <table id="empTable2">
        <thead>
            <tr>
             <th>#</th>
            <th>Label</th>
        <th>Value</th>
    </tr>
</thead>
    <tbody>
        </tbody></table>
            </div>
        </div>
</div>
 <!--THE CONTAINER WHERE WE'll ADD THE DYNAMIC TABLE-->





    
<script>
    var randomScalingFactor = function() {
        return Math.round(Math.random() * 100);
    };
 
    var chartColors = window.chartColors;
    var color = Chart.helpers.color;
    /*  datasets: [{
                life.data,
                life.backgroundColor,
                label: 'My dataset' // for legend 
            }],
            life.labels */
    var config1 = {
        data: {
            datasets: [{
                data: life.data,
                backgroundColor:life.backgroundColor,
                label: 'Life' // for legend 
            }],
            labels:life.labels
        },
        options: {
            responsive: true,
            legend: {
                position: 'bottom',
            },
            title: {
                display: true,
                text: 'Wheel of Life'
            },
            scale: {
                ticks: {
                    beginAtZero: true
                },
                reverse: false
            },
            animation: {
                animateRotate: false,
                animateScale: true
            }
        }
    };

    var config2 = {
        data: {
            datasets: [{
                data: business.data,
                backgroundColor:  business.backgroundColor,
                label: 'My dataset' // for legend 
            }],
            labels:business.labels 
        },
        options: {
            responsive: true,
            legend: {
                position: 'bottom',
            },
            title: {
                display: true,
                text: 'Wheel of business'
            },
            scale: {
                ticks: {
                    beginAtZero: true
                },
                reverse: false
            },
            animation: {
                animateRotate: false,
                animateScale: true
            }
        }
    };

    

    
    window.onload = function() {
        var ctx1 = document.getElementById('chart-area').getContext("2d");
        window.myPolarArea = Chart.PolarArea(ctx1, config1);

     
        var ctx2 = document.getElementById('chart-area2').getContext("2d");
        window.myPolarArea_2 = Chart.PolarArea(ctx2, config2);
		
		populate_table();
    };
      
	function populate_table(){
		if( life.data !== undefined && life.data.length != 0){
				jQuery.each(life.data , function(key , value){
					 var empTab = document.getElementById('empTable').getElementsByTagName('tbody')[0];
						
						var rowCnt = empTab.rows.length;        // GET TABLE ROW COUNT.
						var tr = empTab.insertRow(rowCnt);      // TABLE ROW.
					   // tr = empTab.insertRow(rowCnt);

						for (var c = 0; c < arrHead.length; c++) {
							var td = document.createElement('td');          // TABLE DEFINITION.
							td = tr.insertCell(c);

							if (c == 0) {           // FIRST COLUMN.
								// ADD A BUTTON.
								var button = document.createElement('input');

								// SET INPUT ATTRIBUTE.
								button.setAttribute('type', 'button');
								button.setAttribute('value', 'Remove');
								// button.setAttribute('index', (life.data.length - key));
								button.setAttribute('index', key);
								// ADD THE BUTTON's 'onclick' EVENT.
								button.setAttribute('class', 'removeRow_life');
								button.style.backgroundColor = life.backgroundColor[key];
								td.appendChild(button);
							}
							else {
								// CREATE AND ADD TEXTBOX IN EACH CELL.
								if(arrHead[c] == "Value" ){
									var ele = document.createElement('input');
									ele.setAttribute('type', 'text');
									ele.setAttribute('value',value);
									// ele.setAttribute('index', (life.data.length - key));
									ele.setAttribute('index',key);
									ele.setAttribute('class', arrHead[c]);
									td.appendChild(ele);
								}
								if(arrHead[c] == "label" ){
									 var ele = document.createElement('input');
									ele.setAttribute('type', 'text');
									ele.setAttribute('value',life.labels[key]);
									// ele.setAttribute('index', (life.data.length - key));
									ele.setAttribute('index', key);
									ele.setAttribute('class', arrHead[c]);
									td.appendChild(ele);
								}
								
							}
						}
				})
				
		}
		if( business.data !== undefined && business.data.length != 0  ){
				jQuery.each(business.data , function(key , value){
					 var empTab = document.getElementById('empTable2').getElementsByTagName('tbody')[0];
						
						var rowCnt = empTab.rows.length;        // GET TABLE ROW COUNT.
						var tr = empTab.insertRow(rowCnt);      // TABLE ROW.
					   // tr = empTab.insertRow(rowCnt);

						for (var c = 0; c < arrHead.length; c++) {
							var td = document.createElement('td');          // TABLE DEFINITION.
							td = tr.insertCell(c);

							if (c == 0) {           // FIRST COLUMN.
								// ADD A BUTTON.
								var button = document.createElement('input');

								// SET INPUT ATTRIBUTE.
								button.setAttribute('type', 'button');
								button.setAttribute('value', 'Remove');
								// button.setAttribute('index', (life.data.length - key));
								button.setAttribute('index', key);
								// ADD THE BUTTON's 'onclick' EVENT.
								button.setAttribute('class', 'removeRow_business');
								button.style.backgroundColor = business.backgroundColor[key];
								td.appendChild(button);
							}
							else {
								// CREATE AND ADD TEXTBOX IN EACH CELL.
								if(arrHead[c] == "Value" ){
									var ele = document.createElement('input');
									ele.setAttribute('type', 'text');
									ele.setAttribute('value',value);
									// ele.setAttribute('index', (life.data.length - key));
									ele.setAttribute('index',key);
									ele.setAttribute('class', arrHead[c]);
									td.appendChild(ele);
								}
								if(arrHead[c] == "label" ){
									 var ele = document.createElement('input');
									ele.setAttribute('type', 'text');
									ele.setAttribute('value',business.labels[key]);
									// ele.setAttribute('index', (life.data.length - key));
									ele.setAttribute('index', key);
									ele.setAttribute('class', arrHead[c]);
									td.appendChild(ele);
								}
								
							}
						}
				})
				
		}
	}
  
    // var pieVal = 0;
    // var pieVal2 = 0;
 /*   document.getElementById("color").addEventListener('change', function() {
        pieVal = document.getElementById("color").value;
    });

    document.getElementById("color2").addEventListener('change', function() {
       
    });*/


   
</script>

                                    <!-- start another script here -->

<script>
    // ARRAY FOR HEADER.
    var arrHead = new Array();
    arrHead = ['', 'label', 'Value'];      // SIMPLY ADD OR REMOVE VALUES IN THE ARRAY FOR TABLE HEADERS.

    // FIRST CREATE A TABLE STRUCTURE BY ADDING A FEW HEADERS AND
    // ADD THE TABLE TO YOUR WEB PAGE.
  

    // ADD A NEW ROW TO THE TABLE.s
    function addRowLife() {


		
       var color = get_random_color();
       var index = add_polar(life , "Life" , color );

		
		
	
        var empTab = document.getElementById('empTable').getElementsByTagName('tbody')[0];

        var rowCnt = empTab.rows.length;        // GET TABLE ROW COUNT.
        var tr = empTab.insertRow(rowCnt);      // TABLE ROW.
       // tr = empTab.insertRow(rowCnt);

        for (var c = 0; c < arrHead.length; c++) {
            var td = document.createElement('td');          // TABLE DEFINITION.
            td = tr.insertCell(c);

            if (c == 0) {           // FIRST COLUMN.
                // ADD A BUTTON.
                var button = document.createElement('input');

                // SET INPUT ATTRIBUTE.
                button.setAttribute('type', 'button');
                button.setAttribute('value', 'Remove');
                button.setAttribute('index', index);
                // ADD THE BUTTON's 'onclick' EVENT.
                button.setAttribute('class', 'removeRow_life');
				button.style.backgroundColor = color;
                td.appendChild(button);
            }
            else {
                // CREATE AND ADD TEXTBOX IN EACH CELL.
                var ele = document.createElement('input');
                ele.setAttribute('type', 'text');
                ele.setAttribute('value', arrHead[c] == "Value"? 99 : "Group");
                ele.setAttribute('index', index);
                ele.setAttribute('class', arrHead[c]);
                td.appendChild(ele);
            }
        }
    }

    function add_polar(data , title , color = "red"){
		
		if(data.data === undefined ){
			data.data = [];
			data.labels = [];
			data.backgroundColor = [];
		}
		 var index =  data.data.push(100);
				data.labels.push("Group");
				data.backgroundColor.push(color);
		
		if(title == "Life"){
			
				var config1 = {
						data: {
							datasets: [{
								data: data.data,
								backgroundColor:data.backgroundColor,
								label: title // for legend 
							}],
							labels:data.labels
						},
						options: {
							responsive: true,
							legend: {
								position: 'bottom',
							},
							title: {
								display: true,
								text: 'Wheel of ' + title
							},
							scale: {
								ticks: {
									beginAtZero: true
								},
								reverse: false
							},
							animation: {
								animateRotate: false,
								animateScale: true
							}
						}
					};


				var dataSerialized = JSON.stringify(config1.data.datasets[0].data);
				var backgroundColorSerialized = JSON.stringify(config1.data.datasets[0].backgroundColor);
				var labelsSerialized = JSON.stringify(config1.data.labels);

				var dataExtracted = JSON.parse(dataSerialized);
				var backgroundColorExtracted = JSON.parse(backgroundColorSerialized);
				var labelsExtracted = JSON.parse(labelsSerialized);


			console.log(config1.data.datasets[0].data.length);
				jQuery.ajax({
							type: 'POST',
							url: '<?php echo admin_url('admin-ajax.php'); ?>',
							data: {"action": "save_data_polar" , "data" : dataExtracted , "backgroundColor" : backgroundColorExtracted , "labels" : labelsExtracted ,  "selectedData": index ,  "class":"life"},
							success: function(data){
								console.log(data);
								
								if(config1.data.datasets[0].data.length == 1){
									  var ctx1 = document.getElementById('chart-area').getContext("2d");
									window.myPolarArea = Chart.PolarArea(ctx1, config1);
								}
								else{ 
									window.myPolarArea.update();
								}
								
								
								reIndexCount(jQuery("table#empTable tbody tr"));
							}
						});
		}
		if(title == "Business"){
			
			  
				var config2 = {
						data: {
							datasets: [{
								data: data.data,
								backgroundColor:data.backgroundColor,
								label: title // for legend 
							}],
							labels:data.labels
						},
						options: {
							responsive: true,
							legend: {
								position: 'bottom',
							},
							title: {
								display: true,
								text: 'Wheel of ' + title
							},
							scale: {
								ticks: {
									beginAtZero: true
								},
								reverse: false
							},
							animation: {
								animateRotate: false,
								animateScale: true
							}
						}
					};


				var dataSerialized = JSON.stringify(config2.data.datasets[0].data);
				var backgroundColorSerialized = JSON.stringify(config2.data.datasets[0].backgroundColor);
				var labelsSerialized = JSON.stringify(config2.data.labels);

				var dataExtracted = JSON.parse(dataSerialized);
				var backgroundColorExtracted = JSON.parse(backgroundColorSerialized);
				var labelsExtracted = JSON.parse(labelsSerialized);


			
				jQuery.ajax({
							type: 'POST',
							url: '<?php echo admin_url('admin-ajax.php'); ?>',
							data: {"action": "save_data_polar" , "data" : dataExtracted , "backgroundColor" : backgroundColorExtracted , "labels" : labelsExtracted ,  "selectedData": index ,  "class":"business"},
							success: function(data){
								console.log(data);
								
								
								
								if(config2.data.datasets[0].data.length == 1){
									  var ctx2 = document.getElementById('chart-area2').getContext("2d");
									window.myPolarArea_2 = Chart.PolarArea(ctx2, config2);
								}
								else{ 
									window.myPolarArea_2.update();
								}
								
								reIndexCount(jQuery("table#empTable2 tbody tr"));
							}
						});
		}
       


        // window.myPolarArea.update();

        return index - 1;
    }
	
	
	// Recalculate the count of index attr on add and remove
	function reIndexCount(elem){
		elem.each(function(index){
			 var selectindex = jQuery(this).find("[index]");
			console.log(( elem.length - index ));
			   // selectindex.attr("index" ,( elem.length - index ))
			   selectindex.attr("index" ,index)
		})
	}
	
    function get_random_color() {
        var o = Math.round, r = Math.random, s = 255;
         return 'rgba(' + o(r()*s) + ',' + o(r()*s) + ',' + o(r()*s) + ',' + "0.5   " + ')';
    }

    // update ROW label.

    // jQuery("body").on("click" , ".label" , function(){
    //     var rowjQuery = jQuery(this).closest("tr");
    //     var index  =(rowjQuery[0].rowIndex - 1);


    // })


    jQuery("body").on("change" , "#empTable .Value" , function(event){
            if (event.target.value <= 100) {

                var rowjQuery = jQuery(this).closest("tr");

               var label = rowjQuery.find(".label").val();

               console.log( );
                var index  = jQuery(this).attr("index");
               
                config1.data.datasets[0].data[index] = event.target.value;
                config1.data.labels[index] = label;
                var dataSerialized = JSON.stringify(config1.data.datasets[0].data);
                var backgroundColorSerialized = JSON.stringify(config1.data.datasets[0].backgroundColor);
                var labelsSerialized = JSON.stringify(config1.data.labels);

                var dataExtracted = JSON.parse(dataSerialized);
                var backgroundColorExtracted = JSON.parse(backgroundColorSerialized);
                var labelsExtracted = JSON.parse(labelsSerialized);


            
                jQuery.ajax({
                            type: 'POST',
                            url: '<?php echo admin_url('admin-ajax.php'); ?>',
                            data: {"action": "save_data_polar" , "data" : dataExtracted , "backgroundColor" : backgroundColorExtracted , "labels" : labelsExtracted ,  "selectedData": index ,  "class":"life"},
                            success: function(data){
                                console.log(data);
                                window.myPolarArea.update();
                            }
                        });

            
            
            
            }
        });




/// Update label row

jQuery("body").on("change" , "#empTable .label" , function(event){
                var rowjQuery = jQuery(this).closest("tr");

               var value = rowjQuery.find(".Value").val();

               console.log( value);
                // var index  =(rowjQuery[0].rowIndex - 1);
                var index  = jQuery(this).attr("index");
               
                config1.data.datasets[0].data[index] = value;
                config1.data.labels[index] = event.target.value;
                var dataSerialized = JSON.stringify(config1.data.datasets[0].data);
                var backgroundColorSerialized = JSON.stringify(config1.data.datasets[0].backgroundColor);
                var labelsSerialized = JSON.stringify(config1.data.labels);

                var dataExtracted = JSON.parse(dataSerialized);
                var backgroundColorExtracted = JSON.parse(backgroundColorSerialized);
                var labelsExtracted = JSON.parse(labelsSerialized);


            

                //window.myPolarArea.update();
                jQuery.ajax({
                            type: 'POST',
                            url: '<?php echo admin_url('admin-ajax.php'); ?>',
                            data: {"action": "save_data_polar" , "data" : dataExtracted , "backgroundColor" : backgroundColorExtracted , "labels" : labelsExtracted ,  "selectedData": index ,  "class":"life"},
                            success: function(data){
                                console.log(data);
                                window.myPolarArea.update();
                            }
                        });

            
            
            
            
        });

    // DELETE TABLE ROW.


    jQuery("body").on("click" , ".removeRow_life" , function(){
            
        // var empTab = document.getElementById('empTable');
        // empTab.deleteRow(oButton.parentNode.parentNode.rowIndex);       // BUTTON -> TD -> TR.


        var rowJavascript = this.parentNode.parentNode;
            var rowjQuery = jQuery(this).closest("tr");
       //   alert("JavaScript Row Index : " + (rowJavascript.rowIndex - 1) + "\njQuery Row Index : " + (rowjQuery[0].rowIndex - 1));
      
		var thisclick = jQuery(this);

     
		jQuery(".removeRow_life").prop('disabled', true);
        // var index  =(rowjQuery[0].rowIndex - 1);
        var index  =jQuery(this).attr("index");
        console.log(index );

		 
		   life.data.splice(index , 1 );
          life.backgroundColor.splice(index ,1 );
          life.labels.splice(index , 1 );
        var config1 = {
                data: {
                    datasets: [{
                        data: life.data,
                        backgroundColor:life.backgroundColor,
                        label: "Life" // for legend 
                    }],
                    labels:life.labels
                },
                options: {
                    responsive: true,
                    legend: {
                        position: 'bottom',
                    },
                    title: {
                        display: true,
                        text: 'Wheel of Life' 
                    },
                    scale: {
                        ticks: {
                            beginAtZero: true
                        },
                        reverse: false
                    },
                    animation: {
                        animateRotate: false,
                        animateScale: true
                    }
                }
            };
            console.log(config1);
			
		 var dataSerialized = JSON.stringify(config1.data.datasets[0].data);
                var backgroundColorSerialized = JSON.stringify(config1.data.datasets[0].backgroundColor);
                var labelsSerialized = JSON.stringify(config1.data.labels);

                var dataExtracted = JSON.parse(dataSerialized);
                var backgroundColorExtracted = JSON.parse(backgroundColorSerialized);
                var labelsExtracted = JSON.parse(labelsSerialized);


            

                //
				
				
                 jQuery.ajax({
                            type: 'POST',
                            url: '<?php echo admin_url('admin-ajax.php'); ?>',
                            data: {"action": "save_data_polar" , "data" : dataExtracted , "backgroundColor" : backgroundColorExtracted , "labels" : labelsExtracted ,  "selectedData": index ,  "class":"life"},
                            success: function(data){
                                 window.myPolarArea.update();
								thisclick.parents("tr").remove();
								jQuery(".removeRow_life").prop('disabled', false);
								reIndexCount(jQuery("table#empTable tbody tr"));
                            }
                        });
			 
       

    })
</script>


<script>
 function addRowbusiness() {


		
       var color = get_random_color();
       var index = add_polar(business , "Business" , color );

		
		
	
        var empTab = document.getElementById('empTable2').getElementsByTagName('tbody')[0];

        var rowCnt = empTab.rows.length;        // GET TABLE ROW COUNT.
        var tr = empTab.insertRow(rowCnt);      // TABLE ROW.
       // tr = empTab.insertRow(rowCnt);

        for (var c = 0; c < arrHead.length; c++) {
            var td = document.createElement('td');          // TABLE DEFINITION.
            td = tr.insertCell(c);

            if (c == 0) {           // FIRST COLUMN.
                // ADD A BUTTON.
                var button = document.createElement('input');

                // SET INPUT ATTRIBUTE.
                button.setAttribute('type', 'button');
                button.setAttribute('value', 'Remove');
                button.setAttribute('index', index);
                // ADD THE BUTTON's 'onclick' EVENT.
                button.setAttribute('class', 'removeRow_business');
				button.style.backgroundColor = color;
                td.appendChild(button);
            }
            else {
                // CREATE AND ADD TEXTBOX IN EACH CELL.
                var ele = document.createElement('input');
                ele.setAttribute('type', 'text');
                ele.setAttribute('value', arrHead[c] == "Value"? 99 : "Group");
                ele.setAttribute('index', index);
                ele.setAttribute('class', arrHead[c]);
                td.appendChild(ele);
            }
        }
    }
	
    jQuery("body").on("change" , "#empTable2 .Value" , function(event){
            if (event.target.value <= 100) {

                var rowjQuery = jQuery(this).closest("tr");

               var label = rowjQuery.find(".label").val();

               console.log( );
                var index  = jQuery(this).attr("index");
               
                config2.data.datasets[0].data[index] = event.target.value;
                config2.data.labels[index] = label;
                var dataSerialized = JSON.stringify(config2.data.datasets[0].data);
                var backgroundColorSerialized = JSON.stringify(config2.data.datasets[0].backgroundColor);
                var labelsSerialized = JSON.stringify(config2.data.labels);

                var dataExtracted = JSON.parse(dataSerialized);
                var backgroundColorExtracted = JSON.parse(backgroundColorSerialized);
                var labelsExtracted = JSON.parse(labelsSerialized);


            
                jQuery.ajax({
                            type: 'POST',
                            url: '<?php echo admin_url('admin-ajax.php'); ?>',
                            data: {"action": "save_data_polar" , "data" : dataExtracted , "backgroundColor" : backgroundColorExtracted , "labels" : labelsExtracted ,  "selectedData": index ,  "class":"business"},
                            success: function(data){
                                console.log(data);
                                window.myPolarArea_2.update();
                            }
                        });

            
            
            
            }
        });
		
		
/// Update label row

jQuery("body").on("change" , "#empTable2 .label" , function(event){
                var rowjQuery = jQuery(this).closest("tr");

               var value = rowjQuery.find(".Value").val();

               console.log( value);
                // var index  =(rowjQuery[0].rowIndex - 1);
                var index  = jQuery(this).attr("index");
               
                config2.data.datasets[0].data[index] = value;
                config2.data.labels[index] = event.target.value;
                var dataSerialized = JSON.stringify(config2.data.datasets[0].data);
                var backgroundColorSerialized = JSON.stringify(config2.data.datasets[0].backgroundColor);
                var labelsSerialized = JSON.stringify(config2.data.labels);

                var dataExtracted = JSON.parse(dataSerialized);
                var backgroundColorExtracted = JSON.parse(backgroundColorSerialized);
                var labelsExtracted = JSON.parse(labelsSerialized);


            

                //window.myPolarArea.update();
                jQuery.ajax({
                            type: 'POST',
                            url: '<?php echo admin_url('admin-ajax.php'); ?>',
                            data: {"action": "save_data_polar" , "data" : dataExtracted , "backgroundColor" : backgroundColorExtracted , "labels" : labelsExtracted ,  "selectedData": index ,  "class":"business"},
                            success: function(data){
                                console.log(data);
                                window.myPolarArea_2.update();
                            }
                        });

            
            
            
            
        });
		
		
		 // DELETE TABLE ROW.


    jQuery("body").on("click" , ".removeRow_business" , function(){
            
        // var empTab = document.getElementById('empTable');
        // empTab.deleteRow(oButton.parentNode.parentNode.rowIndex);       // BUTTON -> TD -> TR.


        var rowJavascript = this.parentNode.parentNode;
            var rowjQuery = jQuery(this).closest("tr");
       //   alert("JavaScript Row Index : " + (rowJavascript.rowIndex - 1) + "\njQuery Row Index : " + (rowjQuery[0].rowIndex - 1));
      
		var thisclick = jQuery(this);

     
		jQuery(".removeRow_business").prop('disabled', true);
        // var index  =(rowjQuery[0].rowIndex - 1);
        var index  =jQuery(this).attr("index");
        console.log(index );

		 
		   business.data.splice(index , 1 );
          business.backgroundColor.splice(index ,1 );
          business.labels.splice(index , 1 );
        var config2 = {
                data: {
                    datasets: [{
                        data: business.data,
                        backgroundColor:business.backgroundColor,
                        label: "Business" // for legend 
                    }],
                    labels:business.labels
                },
                options: {
                    responsive: true,
                    legend: {
                        position: 'bottom',
                    },
                    title: {
                        display: true,
                        text: 'Wheel of Business' 
                    },
                    scale: {
                        ticks: {
                            beginAtZero: true
                        },
                        reverse: false
                    },
                    animation: {
                        animateRotate: false,
                        animateScale: true
                    }
                }
            };
            console.log(config2);
			
		 var dataSerialized = JSON.stringify(config2.data.datasets[0].data);
                var backgroundColorSerialized = JSON.stringify(config2.data.datasets[0].backgroundColor);
                var labelsSerialized = JSON.stringify(config2.data.labels);

                var dataExtracted = JSON.parse(dataSerialized);
                var backgroundColorExtracted = JSON.parse(backgroundColorSerialized);
                var labelsExtracted = JSON.parse(labelsSerialized);


            

                //
				
				
                 jQuery.ajax({
                            type: 'POST',
                            url: '<?php echo admin_url('admin-ajax.php'); ?>',
                            data: {"action": "save_data_polar" , "data" : dataExtracted , "backgroundColor" : backgroundColorExtracted , "labels" : labelsExtracted ,  "selectedData": index ,  "class":"business"},
                            success: function(data){
                                 window.myPolarArea_2.update();
								thisclick.parents("tr").remove();
								jQuery(".removeRow_business").prop('disabled', false);
								reIndexCount(jQuery("table#empTable2 tbody tr"));
                            }
                        });
			 })
</script>
