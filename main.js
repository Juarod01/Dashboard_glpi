
index();
$("#principal").click(function(){
    $("#chartSdo").css("display", "none");
    $("#chartPpal").css("display", "block");
    index();
});

$("#porEstado").click(function(){
    $("#chartPpal").css("display", "none");
    $("#chartSdo").css("display", "block");
    estado();
});

$("#porTipo").click(function(){
    $("#chartPpal").css("display", "none");
    $("#chartSdo").css("display", "block");
    tipo();
});

$("#filtrar").click(function(){
    var inicio = $("#fecha1").val()
    var fin = $("#fecha2").val()
    console.log(inicio)
    console.log(fin)
    estado(inicio, fin)
});



function index(){
    var chart1, options;
    $.ajax({
        url:"http://localhost/dashboard_glpi/consultas/casos/index.php",
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

function estado(inicio = "July 2020", fin){
    var chart1, options;
    $.ajax({
        url:"http://localhost/dashboard_glpi/consultas/casos/estado.php",
        type: "POST",
        dataType:"json",
        success:function(data){
            meses = data.meses;
            console.log(data)
            // console.log(meses)
            var eData =  meses.filter(d => d == inicio);
            // console.log(eData)
            options.series[0].data = data.abiertos;
            options.series[1].data = data.cerrados; 
            options.xAxis.categories = data.meses;

            chart1 = new Highcharts.Chart(options);
        }
    });
    options = {
        chart: {
            renderTo: 'contenedor2',
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
            console.log(data)
            options.series[0].data = data.incidencias;
            options.series[1].data = data.requerimientos; 
            options.series[2].data = data.problemas; 
            options.xAxis.categories = data.meses;

            chart1 = new Highcharts.Chart(options);
        }
    });
    options = {
        chart: {
            renderTo: 'contenedor2',
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