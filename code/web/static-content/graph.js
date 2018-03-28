function drawHistory(history, type){
	console.log("history in drawHistory(his..)"+history);
	console.log(history);
	console.log(history[0][type]);
    var temps = [];
    var dates = [];
    var labels = [];
    var colour;
    for (var i = 0; i <= history.length; i++){
        if (history[i] != null){
            temps.push(history[i][type]);
            time = Date(history[i]['recordDate'])
            dates.push(time.substring(0,25));
        } 
    }
    
    if (type == "moisture"){
        var ctx = document.getElementById("myChart").getContext('2d');
        colour = 'rgba(255, 99, 132, 0.5)';
    } else if (type == "temp"){
        var ctx = document.getElementById("myChart1").getContext('2d');
        colour = 'rgba(75, 192, 192, 0.5)';
    }
    else if (type == "humidity"){
        var ctx = document.getElementById("myChart2").getContext('2d');
        colour = 'rgba(153, 102, 255, 0.5)';
    }
    
	var myChart = new Chart(ctx, {
		type: 'line',
		data: {
			labels: dates,
			datasets: [{
			    label: type,
			    data: temps,
			    backgroundColor: colour,
			    borderWidth: 1
			}]
		},
		options: {
            
            title: {
                display: true,
                text: type
            },
            
            legend: {
                display: false
            },
			scales: {
			    yAxes: [{

                    
			        ticks: {
			            beginAtZero:true
			        },
			    }],
			    xAxes: [{
			        ticks: {
			            autoskip: true
			        },

			    }],
                
              
                
			}
		}
	});

}
