let months = ["01", "02", "03", "04", "05", "'06", "07", "08", "09", "10", "11", "12"];
let fecha = new Date();
let fecha2 = fecha.getTime()-(12*(30*24*60*60*1000))
let fechaInicio = new Date(fecha2);
let inicio = fechaInicio.getFullYear() + "-" + months[fechaInicio.getMonth()];
let fin = fecha.getFullYear() + "-" + months[fecha.getMonth()];

index();
$("#principal").click(function(){
    $("#chartSdo").css("display", "none");
    $("#chartPpal").css("display", "block");
    index();
});

function porEstado(){
    $.post("estado.php", function(data){
        $("#chartPpal").css("display", "none");
        $("#chartSdo").css("display", "block");
        $("#chartSdo").html(data);
        estado(inicio, fin);
    });
}
function porTipo(){
    $.post("tipo.php", function(data){
        $("#chartPpal").css("display", "none");
        $("#chartSdo").css("display", "block");
        $("#chartSdo").html(data);
        tipo(inicio, fin);
    });
}

function index(){
    var chart1, options;
    $.ajax({
        url:"http://localhost/dashboard_glpi/consultas/casos/index.php",
        type: "POST",
        dataType:"json",
        success:function(data){
            for (let i = 0; i <= data.length; i++) {
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
        },{
            // name:'2020',
            // data:[]
        },{

        }
    ],     
    }
}

function estado(i, f){
    var chart1, options;
    $.ajax({
        url:"http://localhost/dashboard_glpi/consultas/casos/estado.php",
        type: "POST",
        dataType:"json",
        success:function(data){
            meses = data.abiertos;
            let abiertos = [], cerrados = [], meses2 = []

            for (let j = 0; j < meses.length; j++) {
                if (meses[j][0] >= i && meses[j][0] <= f) {
                    abiertos.push(data.abiertos[j][1])
                    cerrados.push(data.cerrados[j][1])
                    meses2.push(data.meses[j])
                }
            }

            options.series[0].data = abiertos;
            options.series[1].data = cerrados; 
            options.xAxis.categories = meses2;

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

function tipo(i, f){
    var chart1, options;
    $.ajax({
        url:"http://localhost/dashboard_glpi/consultas/casos/tipo.php",
        type: "POST",
        dataType:"json",
        success:function(data){
            meses = data.incidencias;
            let incidencias = [], requerimientos = [], problemas = [], meses2 = []

            for (let j = 0; j < meses.length; j++) {
                if (meses[j][0] >= i && meses[j][0] <= f) {
                    incidencias.push(data.incidencias[j][1])
                    requerimientos.push(data.requerimientos[j][1])
                    problemas.push(data.problemas[j][1])
                    meses2.push(data.meses[j])
                }
            }
            // console.log(data)
            options.series[0].data = incidencias;
            options.series[1].data = requerimientos; 
            options.series[2].data = problemas; 
            options.xAxis.categories = meses2;

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