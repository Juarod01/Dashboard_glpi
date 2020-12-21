
// $(window).load("http://localhost/dashboard_glpi/estado.php", index());
index();
$("#principal").click(function(){
    index();
});

$("#porEstado").click(function(){
    estado();
});

$("#porTipo").click(function(){
    tipo();
});


function index(){     
    var chart1, options;
    $.ajax({
        url:"http://localhost/dashboard_glpi/consultas/casos/graficos.php",
        type: "POST",
        dataType:"json",
        success:function(data){
            for (let i = 0; i < data.length; i++) {
                options.series[i].name = data[0].annos[i];
                options.series[i].data = data[1].data[i]; 
            }
            chart1 = new Highcharts.Chart(options);
        }
    });
    options = {
        chart:{
            renderTo: 'contenedor',
            type: 'spline',
            width: 1000
        },
        title:{
            text: 'Evolución de casos'
        },
        xAxis:{
            categories:['0', 'Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic']
        },
        yAxis:{
            title:{
                text: 'Casos'
            }
        },
        legend:{
            layout:'horizontal',
            align: 'center',
            verticalAlign:'top'
        },
        plotOptions: {
            series: {
                label: {
                    connectorAllowed: false
                },
                pointStart: 0
            }
        },
        series:
        [
            {
            // name:'2019',
            // data:[]
        },
        {
            // name:'2020',
            // data:[]
        }
    ],     
    }
}

function estado(){
    var chart1, options;
    $.ajax({
        url:"http://localhost/dashboard_glpi/consultas/casos/estado.php",
        type: "POST",
        dataType:"json",
        success:function(data){
            options.series[0].data = data[0].abiertos;
            options.series[1].data = data[1].cerrados; 
            options.xAxis.categories = data[2].meses;

            chart1 = new Highcharts.Chart(options);
        }
    });
    options = {
        chart: {
            renderTo: 'contenedor',
            type: 'column',
            width: 1000
        },
        xAxis: {
            categories:[],
        },
        yAxis: {
            title: {
                    text: 'Cantidad de casos'
            }    		
        },
        title: {
            text: 'Casos por estado'
        },
        subtitle: {
            text: 'Casos abiertos y cerrados en los últimos 12 meses'
        },
        plotOptions:{
            series:{
                cursor:'pointer',
                pointWidth: 20,
                fontSize: 5,
                dataLabels:{
                    enabled:true,
                }
            }
        },
        series: [{
            name: 'abiertos',
            data: []
        }, {
            name: 'cerrados',
            data: []
    
        }]
    };
}

function tipo(){
    var chart1, options;
    $.ajax({
        url:"http://localhost/dashboard_glpi/consultas/casos/tipo.php",
        type: "POST",
        dataType:"json",
        success:function(data){
            options.series[0].data = data[0].incidencias;
            options.series[1].data = data[1].requerimientos; 
            options.series[2].data = data[2].problemas; 
            options.xAxis.categories = data[3].meses;

            chart1 = new Highcharts.Chart(options);
        }
    });
    options = {
        chart: {
            renderTo: 'contenedor',
            type: 'column',
            width: 1000
        },
        xAxis: {
            categories:[],
        },
        yAxis: {
            title: {
                    text: 'Cantidad de casos'
            }    		
        },
        title: {
            text: 'Casos por tipo'
        },
        subtitle: {
            text: 'Cantidad de incidencias, requerimientos y problemas en los últimos 12 meses'
        },
        plotOptions:{
            series:{
                cursor:'pointer',
                pointWidth: 20,
                fontSize: 5,
                dataLabels:{
                    enabled:true,
                }
            },
        },
        series: [{
            name: 'Incidencias',
            data: []
        }, {
            name: 'Requerimientos',
            data: []
        }, {
            name: 'Problemas',
            data: []
    
        }]
    };
}