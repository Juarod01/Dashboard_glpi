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
        tablaSatisfaccion(inicio, fin);
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
        tablaTecnico(inicio, fin);
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

            const totalCasos = abiertos.reduce(function(contador, casos){
                return contador + casos
            }, 0)
            $("#totalCasos").text("Casos en total: " + totalCasos);

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
            const casosIncidencias = incidencias.reduce(function(contador, casos){
                return contador + casos
            }, 0)
            const casosRequerimientos = requerimientos.reduce(function(contador, casos){
                return contador + casos
            }, 0)
            const totalCasos = casosIncidencias + casosRequerimientos
            $("#totalCasos").text("Casos en total: " + totalCasos);

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
            let newData = datos.filter(registro => registro.fecha >= i && registro.fecha <= f)
            .map(function(registro){
                return {name: registro.localizacion, y: registro.casos}
            });

            const totalCasos = newData.reduce(function(contador, casos){
                return contador + casos.y
            }, 0)
            console.log(totalCasos)
            $("#totalCasos").text("Casos en total: " + totalCasos);

            const sumatoria = newData.reduce((acumulador, valorActual) => {
                const yaExiste = acumulador.find(elemento => elemento.name === valorActual.name);
                if (yaExiste) {
                    return acumulador.map((elemento)=>{
                        if (elemento.name === valorActual.name) {
                            let name = elemento.name
                            let y = elemento.y + valorActual.y
                            return { name, y }
                        }
                        return elemento;
                    });
                }
                return [...acumulador, valorActual]
            }, []);
            sumatoria.sort(function(a,b) {
                return a.y - b.y;
            })
            .reverse()
            let dataReducida = sumatoria.slice(0,15);
            
            options.series[0].data = dataReducida;
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
            let newData = datos.filter(registro => registro[0] >= i && registro[0] <= f)
            .map(function(registro){
                return {name: registro[1], y: registro[2]}
            });
            const totalCasos = newData.reduce(function(contador, casos){
                return contador + casos.y
            }, 0)
            $("#totalCasos").text("Casos en total: " + totalCasos);
            const sumatoria = newData.reduce((acumulador, valorActual) => {
                const yaExiste = acumulador.find(elemento => elemento.name === valorActual.name);
                if (yaExiste) {
                    return acumulador.map((elemento)=>{
                        if (elemento.name === valorActual.name) {
                            let name = elemento.name
                            let y = elemento.y + valorActual.y
                            return { name, y }
                        }
                        return elemento;
                    });
                }
                return [...acumulador, valorActual]
            }, []);
            sumatoria.sort(function(a,b) {
                return a.y - b.y;
            })
            .reverse()

            options.series[0].data = sumatoria;
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
            let newData = datos.filter(registro => registro[0] >= i && registro[0] <= f)
            .map(function(registro){
                return {name: registro[2], y: 1}
            });
            const totalCasos = newData.reduce(function(contador, casos){
                return contador + casos.y
            }, 0)
            $("#totalCasos").text("Casos en total: " + totalCasos);
            const sumatoria = newData.reduce((acumulador, valorActual) => {
                const yaExiste = acumulador.find(elemento => elemento.name === valorActual.name);
                if (yaExiste) {
                    return acumulador.map((elemento)=>{
                        if (elemento.name === valorActual.name) {
                            let name = elemento.name
                            let y = elemento.y + valorActual.y
                            return { name, y }
                        }
                        return elemento;
                    });
                }
                return [...acumulador, valorActual]
            }, []);
            sumatoria.sort(function(a,b) {
                return a.y - b.y;
            })
            .reverse()
            let dataReducida = sumatoria.slice(0,15);

            options.series[0].data = dataReducida;
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
            type: 'category'
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
            // Filtrar por el tiempo indicado
            let newData = dataSet.filter(registro => registro[0] >= i && registro[0] <= f)
            .map(function(registro){
                return registro
            });
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
                    categoria[j][3] = ((categoria[j][2] / categoria[j][1])*100).toFixed(2) + "%";
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
                let porcentaje = ((registro.cerrado / registro.casos)*100).toFixed(2) + "%"
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

function tablaTecnico(i, f){
    $.ajax({
        url:"consultas/tablas_casos/tecnico.php",
        type: "POST",
        dataType:"json",
        success:function(data){
            let dataSet = data.tecnico;
            // Filtrar por el tiempo indicado
            let newData = dataSet.filter(registro => registro[0] >= i && registro[0] <= f)
            .map(function(registro){
                return {name: registro[2], casos: 1, abierto: registro[3], enEspera: registro[4], solucionado: registro[5], cerrado: registro[6]}
            });

            const sumatoria = newData.reduce((acumulador, valorActual) => {
                const yaExiste = acumulador.find(elemento => elemento.name === valorActual.name);
                if (yaExiste) {
                    return acumulador.map((elemento)=>{
                        if (elemento.name === valorActual.name) {
                            let name = elemento.name
                            let casos = elemento.casos + valorActual.casos
                            let abierto = elemento.abierto + valorActual.abierto
                            let enEspera = elemento.enEspera + valorActual.enEspera
                            let solucionado = elemento.solucionado + valorActual.solucionado
                            let cerrado = elemento.cerrado + valorActual.cerrado
                            return { name, casos, abierto, enEspera, solucionado, cerrado }
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
                let porcentaje = ((registro.cerrado / registro.casos)*100).toFixed(2) + "%"
                return [
                    registro.name,
                    registro.casos,
                    registro.abierto,
                    registro.enEspera,
                    registro.solucionado,
                    registro.cerrado,
                    porcentaje
                ]
            });

            $(document).ready(function() {
                $('#casosTecnico').DataTable( {
                    // dom: 'Plfrtip',
                    data: dataFinal,
                    columns: [
                        { title: "Técnico" },
                        { title: "Casos" },
                        { title: "Abiertos" },
                        { title: "En espera" },
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

function tablaSatisfaccion(i, f){
    $.ajax({
        url:"consultas/tablas_casos/satisfaccion.php",
        type: "POST",
        dataType:"json",
        success:function(data){
            let dataSet = data.satisfaccion;
            // Filtrar por el tiempo indicado
            let newData = dataSet.filter(registro => registro[4] >= i && registro[4] <= f)
            .map(function(registro){
                return [
                        ticket= registro[0], 
                        titulo= registro[1], 
                        solicitante= registro[2], 
                        tecnico= registro[3], 
                        abierto= registro[4], 
                        cerrado= registro[5],
                        satisfaccion= registro[6]
                ]
            });
            console.log(newData)

            // Ordenar por numero de casos, la funcion sort, los ordena de forma ascendente, posterior se realiza reserse
            // sumatoria.sort(function(a,b) {
            //     return a.casos - b.casos;
            // })
            // .reverse();

            $(document).ready(function() {
                $('#casosSatisfaccion').DataTable( {
                    // dom: 'Plfrtip',
                    data: newData,
                    columns: [
                        { title: "Ticket" },
                        { title: "Título" },
                        { title: "Solicitante" },
                        { title: "Técnico" },
                        { title: "Abierto" },
                        { title: "Cerrado" },
                        { title: "Satisfacción" },
                    ],
                    // order: [[ 1, "desc" ]]
                } );
            } );
            
        }
    });

}