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
        tablaTipo(inicio, fin);
    });
}

function porSatisfaccion(){
    $.post("satisfaccion.php", function(data){
        $("#chartPpal").css("display", "none");
        $("#chartSdo").css("display", "block");
        $("#chartSdo").html(data);
        satisfaccion(inicio, fin);
    });
}

function porLocalizacion(){
    $.post("localizacion.php", function(data){
        $("#chartPpal").css("display", "none");
        $("#chartSdo").css("display", "block");
        $("#chartSdo").html(data);
        localizacion(inicio, fin);
        tablaLocalizacion(inicio, fin);
    });
}

function porTecnico(){
    $.post("tecnico.php", function(data){
        $("#chartPpal").css("display", "none");
        $("#chartSdo").css("display", "block");
        $("#chartSdo").html(data);
        tecnico(inicio, fin);
    });
}

function porCategoria(){
    $.post("categoria.php", function(data){
        $("#chartPpal").css("display", "none");
        $("#chartSdo").css("display", "block");
        $("#chartSdo").html(data);
        categoria(inicio, fin);
        tablaCategoria(inicio, fin);
    });
}

function index(){
    var chart1, options;
    $.ajax({
        url:"consultas/casos/index.php",
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
            width: 1100
        },
        title:{
            text: 'Evolución de casos'
        },
        xAxis:{
            type: 'category'
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
        series: [{},{},{}]
    }
}

function estado(i, f){
    var chart1, options;
    $.ajax({
        url:"consultas/casos/estado.php",
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
            width: 1100
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
        url:"consultas/casos/tipo.php",
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
            width: 1100
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

function satisfaccion(i, f){
    var chart1, options;
    $.ajax({
        url:"consultas/casos/satisfaccion.php",
        type: "POST",
        dataType:"json",
        success:function(data){
            meses = data.promedio;
            let promedio = [], meses2 = []

            for (let j = 0; j < meses.length; j++) {
                if (meses[j][0] >= i && meses[j][0] <= f) {
                    promedio.push(data.promedio[j][1])
                    meses2.push(data.meses[j])
                }
            }
            // console.log(data)
            options.series[0].data = promedio;
            options.xAxis.categories = meses2;

            chart1 = new Highcharts.Chart(options);
        }
    });
    options = {
        chart: {
            renderTo: 'contenedor2',
            type: 'column',
            width: 1100
        },
        xAxis: {
            categories:[],
        },
        yAxis: {
            title: {
                    text: 'Promedio'
            }    		
        },
        title: {
            text: 'Promedio'
        },
        subtitle: {
            text: 'Promedio de satisfacción en los últimos 12 meses'
        },
        plotOptions:{
            series:{
                cursor:'pointer',
                pointWidth: 20,
                fontSize: 5,
                dataLabels:{
                    enabled:true,
                    format: '{point.y:.1f}%'
                }
            },
        },
        series: [{
            name: 'Satisfacción',
            data: []
        }]
    };
}

function localizacion(i, f){
    var chart1, options;
    $.ajax({
        url:"consultas/casos/localizacion.php",
        type: "POST",
        dataType:"json",
        success:function(data){
            let datos = data.localizacion;
            let areas = data.areas;
            let newData = [];
            // Filtrar por el tiempo indicado
            for (let j = 0; j < datos.length; j++) {
                if(datos[j].fecha >= i && datos[j].fecha <= f){
                    x = {name: datos[j].localizacion, y: datos[j].casos, drilldown: datos[j].localizacion}
                    newData.push(x);
                }
            }
            // Sumar cantidad de casos de localizaciones iguales
            for (let j = 0; j < newData.length; j++) {
                for (let k = 0; k < areas.length; k++) {
                    if (areas[k].y == undefined) {
                        if (areas[k].name == newData[j].name) {
                            areas[k].y = newData[j].y;
                        }
                    }else{
                        if (areas[k].name == newData[j].name) {
                            areas[k].y = areas[k].y + newData[j].y;
                        }
                    }
                }
            }
            // Llenar localizaciones que no tiene cantidad de casos, con 0
            for (let j = 0; j < areas.length; j++) {
                if (areas[j].y == undefined) {
                    areas[j].y = 0;
                }
            }
            // Ordenar por numero de casos, la funcion sort, los ordena de forma ascendente
            areas.sort(function(a,b) {
                return a.y - b.y;
            })
            // La funcion reverse, los deja ordenados de forma descendente
            areas.reverse();
            // Extrae los primeros 15 elementos del array
            let nuevo = areas.slice(0,15)

            options.series[0].data = nuevo;
            chart1 = new Highcharts.Chart(options);
        }
    });
    options = {
        chart: {
            renderTo: 'contenedor2',
            type: 'bar',
            width: 1100,
            height: 500
        },
        xAxis: {
            type: 'category'
        },
        yAxis: {
            title: {
                    text: 'Cantidad de casos'
            }    		
        },
        title: {
            text: 'Cantidad de casos por localización'
        },
        subtitle: {
            text: 'Top 15 de areas con mas casos generados'
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
            name: 'Areas',
            data: []
        }]
    };
}

function tecnico(i, f){
    var chart1, options;
    $.ajax({
        url:"consultas/casos/tecnico.php",
        type: "POST",
        dataType:"json",
        success:function(data){
            let datos = data.casosTecnicos;
            let tecnico = data.tecnico;
            let newData = [];
            // Filtrar por el tiempo indicado
            for (let j = 0; j < datos.length; j++) {
                if(datos[j][0] >= i && datos[j][0] <= f){
                    newData.push([datos[j][1], datos[j][2]]);
                }
            }
            // Sumar cantidad de casos de localizaciones iguales
            for (let j = 0; j < newData.length; j++) {
                for (let k = 0; k < tecnico.length; k++) {
                    if (tecnico[k][1] == undefined) {
                        if (tecnico[k] == newData[j][0]) {
                            tecnico[k][1] = newData[j][1];
                        }
                    }else{
                        if (tecnico[k][0] == newData[j][0]) {
                            tecnico[k][1] = tecnico[k][1] + newData[j][1];
                        }
                    }
                }
            }
            // Llenar localizaciones que no tiene cantidad de casos, con 0
            for (let j = 0; j < tecnico.length; j++) {
                if (tecnico[j][1] == undefined) {
                    tecnico[j][1] = 0;
                }
            }
            // Ordenar por numero de casos, la funcion sort, los ordena de forma ascendente
            tecnico.sort(function(a,b) {
                return a[1] - b[1];
            })
            // La funcion reverse, los deja ordenados de forma descendente
            tecnico.reverse();

            options.series[0].data = tecnico;
            options.xAxis.categories = tecnico;

            chart1 = new Highcharts.Chart(options);
        }
    });
    options = {
        chart: {
            renderTo: 'contenedor2',
            type: 'bar',
            width: 1100,
            height: 500
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
            text: 'Cantidad de casos atendidos por tecnico'
        },
        subtitle: {
            text: ''
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
            name: 'Tecnicos',
            data: []
        }]
    };
}

function categoria(i, f){
    var chart1, options;
    $.ajax({
        url:"consultas/casos/categoria.php",
        type: "POST",
        dataType:"json",
        success:function(data){
            let datos = data.dataCategoria;
            let categoria = data.Categoria;
            let newData = [];
            // Filtrar por el tiempo indicado
            for (let j = 0; j < datos.length; j++) {
                if(datos[j][0] >= i && datos[j][0] <= f){
                    newData.push(datos[j]);
                }
            }
            // Sumar cantidad de casos de categorias iguales
            for (let j = 0; j < newData.length; j++) {
                for (let k = 0; k < categoria.length; k++) {
                    if (categoria[k][1] == undefined) {
                        if (categoria[k] == newData[j][2]) {
                            categoria[k][1] = 1;
                        }
                    }else{
                        if (categoria[k][0] == newData[j][2]) {
                            categoria[k][1] = categoria[k][1] + 1;
                        }
                    }
                }
            }
            // Llenar categorias que no tiene cantidad de casos, con 0
            for (let j = 0; j < categoria.length; j++) {
                if (categoria[j][1] == undefined) {
                    categoria[j][1] = 0;
                }
            }
            // Ordenar por numero de casos, la funcion sort, los ordena de forma ascendente
            categoria.sort(function(a,b) {
                return a[1] - b[1];
            })
            // La funcion reverse, los deja ordenados de forma descendente
            categoria.reverse();
            // Retorna todas las categorias que tengan por lo menos 1 caso
            let nuevo = categoria.map(function(data){
                if (data[1]>0) {
                    return data
                }
            }).slice(0,15)
            // Extrae los primeros 15 elementos del array
            // nuevo.slice(0,15)

            options.series[0].data = nuevo;
            options.xAxis.categories = nuevo;

            chart1 = new Highcharts.Chart(options);
        }
    });
    options = {
        chart: {
            renderTo: 'contenedor2',
            type: 'bar',
            width: 1400,
            height: 500
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
            text: 'Cantidad de casos por categoría'
        },
        subtitle: {
            text: 'Top 15 de las categorías con mas casos'
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
            name: 'Categoría',
            data: []
        }]
    };
}

function tablaCategoria(i, f){
    $.ajax({
        url:"consultas/tablas_casos/categoria.php",
        type: "POST",
        dataType:"json",
        success:function(data){
            let dataSet = data.dataCategoria;
            let categoria = data.Categoria;
            let newData = [];
            // Filtrar por el tiempo indicado
            for (let j = 0; j < dataSet.length; j++) {
                if(dataSet[j][0] >= i && dataSet[j][0] <= f){
                    newData.push(dataSet[j]);
                }
            }
            // Sumar cantidad de casos de categorias iguales y cuenta las categorias que cumplen con el sla
            for (let j = 0; j < newData.length; j++) {
                for (let k = 0; k < categoria.length; k++) {
                    if (categoria[k][1] == undefined) {
                        if (categoria[k] == newData[j][2]) {
                            categoria[k][1] = 1;
                            if (newData[j][6] === "cumple") {
                                categoria[k][2] = 1;
                            }
                        }
                    }else{
                        if (categoria[k][0] == newData[j][2]) {
                            categoria[k][1] = categoria[k][1] + 1;
                            if (categoria[k][2] == undefined) {
                                if (newData[j][6] === "cumple") {
                                    categoria[k][2] = 1;
                                }
                            }else{
                                if (newData[j][6] === "cumple") {
                                    categoria[k][2] = categoria[k][2] + 1;
                                }
                            }
                        }
                    }
                }
            }
            // Llenar categorias que no tiene cantidad de casos, con 0
            for (let j = 0; j < categoria.length; j++) {
                if (categoria[j][1] == undefined) {
                    categoria[j][1] = 0;
                } 
                if(categoria[j][2] == undefined){
                    categoria[j][2] = 0;
                }
            }
            // Llena porcentaje
            for (let j = 0; j < categoria.length; j++) {
                if (categoria[j][1] != 0) {
                    categoria[j][3] = Math.round((categoria[j][2] / categoria[j][1])*100, -1) + "%";
                }else{
                    categoria[j][3] = 0;
                }
            }
            // Ordenar por numero de casos, la funcion sort, los ordena de forma ascendente
            categoria.sort(function(a,b) {
                return a[1] - b[1];
            })
            // La funcion reverse, los deja ordenados de forma descendente
            categoria.reverse();

            console.log(categoria);

            $(document).ready(function() {
                $('#categoriaSla').DataTable( {
                    data: categoria,
                    columns: [
                        { title: "Categoría" },
                        { title: "Cantidad de casos" },
                        { title: "Casos que cumplen SLA" },
                        { title: "Procentaje" },
                    ],
                    order: [[ 1, "desc" ]]
                } );
            } );
            
            $(document).ready(function() {
                $('#categoria').DataTable( {
                    data: newData,
                    dom: 'Plfrtip',
                    columns: [
                        { title: "Mes" },
                        { title: "Id" },
                        { title: "Categoría" },
                        { title: "SLA" },
                        { title: "Tiempo sla (horas)" },
                        { title: "Tiempo solucionado (horas)" },
                        { title: "Criterio" },
                        { title: "Estado" },
                    ],
                    searchPanes: {
                        order: ['Estado', 'Categoría', 'Criterio']
                    },
                } );
            } );
        }
    });

}

function tablaTipo(i, f){
    $.ajax({
        url:"consultas/tablas_casos/tipo.php",
        type: "POST",
        dataType:"json",
        success:function(data){
            let dataSet = data.datosPorTipo;
            let newData = [];
            // Filtrar por el tiempo indicado
            for (let j = 0; j < dataSet.length; j++) {
                if(dataSet[j][0] >= i && dataSet[j][0] <= f){
                    newData.push(dataSet[j]);
                }
            }

            $(document).ready(function() {
                $('#casosTipo').DataTable( {
                    dom: 'Plfrtip',
                    data: newData,
                    columns: [
                        { title: "Mes" },
                        { title: "Titulo" },
                        { title: "Id" },
                        { title: "Tipo" },
                        { title: "Estado" },
                    ]
                } );
            } );
            
        }
    });

}

function tablaLocalizacion(i, f){
    $.ajax({
        url:"consultas/tablas_casos/localizacion.php",
        type: "POST",
        dataType:"json",
        success:function(data){
            let dataSet = data.localizacion;
            // Filtrar por el tiempo indicado
            let newData = dataSet.filter(registro => registro[0] >= i && registro[0] <= f)
            .map(function(registro){
                return {name: registro[2], casos: 1, abierto: registro[3], solucionado: registro[4], cerrado: registro[5]}
            });

            const sumatoria = newData.reduce((acumulador, valorActual) => {
                const yaExiste = acumulador.find(elemento => elemento.name === valorActual.name);
                if (yaExiste) {
                    return acumulador.map((elemento)=>{
                        if (elemento.name === valorActual.name) {
                            let name = elemento.name
                            let casos = elemento.casos + valorActual.casos
                            let abierto = elemento.abierto + valorActual.abierto
                            let solucionado = elemento.solucionado + valorActual.solucionado
                            let cerrado = elemento.cerrado + valorActual.cerrado
                            return { name, casos, abierto, solucionado, cerrado }
                        }
                        return elemento;
                    });
                }
                return [...acumulador, valorActual]
            }, []);

            // Ordenar por numero de casos, la funcion sort, los ordena de forma ascendente, posterior se realiza reserse
            sumatoria.sort(function(a,b) {
                return a.casos - b.casos;
            })
            .reverse();

            let dataFinal = sumatoria.map(function(registro){
                let porcentaje = Math.round((registro.cerrado / registro.casos)*100, -1) + "%"
                return [
                    registro.name,
                    registro.casos,
                    registro.abierto,
                    registro.solucionado,
                    registro.cerrado,
                    porcentaje
                ]
            });

            $(document).ready(function() {
                $('#casosLocalizacion').DataTable( {
                    // dom: 'Plfrtip',
                    data: dataFinal,
                    columns: [
                        { title: "Localización" },
                        { title: "Casos" },
                        { title: "Abiertos" },
                        { title: "Solucionados" },
                        { title: "Cerrados" },
                        { title: "Porcentaje" },
                    ],
                    order: [[ 1, "desc" ]]
                } );
            } );
            
        }
    });

}