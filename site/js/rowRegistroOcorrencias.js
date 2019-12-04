function rowSearch(faltas, divId){
        query = faltas.map( f =>{ return {id: f.idFalta, nome: f.nome, motivo: f.motivo, dia: f.dia, visto: f.visto} })

    let result = "";

    if(!query[0]){
        result = "Não há faltas";

    }else{
        let list = ""

        for(i = 0; i <= query.length; i++) {
            if(query[i]){
            list = list + `<tr>
                                <td>${ query[i].id } - </td>
                                <td>
                                    <td>
                                        <a href="registro_ocorrencias.php?idFalta=${ query[i].id }">${ query[i].nome }</a> - ${query[i].motivo} | ${ formatData(query[i].dia) }
                                    </td>
                                </td>
                            </tr>`;
            };
        };

        result = `<table>${ list }</table>`
        
    }

    return document.getElementById(divId).innerHTML = result;
}

function formatData(data){
    dataArray = data.split('-')
    return `${dataArray[2]}/${dataArray[1]}/${dataArray[0]}`;
}