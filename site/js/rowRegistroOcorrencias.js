function rowSearch(faltas, divId){
        query = faltas.map( f =>{ return {id: f.idFalta, nome: f.nome, motivo: f.motivo, dia: f.dia, visto: f.visto} })

    let result = ""

    if(!query[0]){
        result = "Não há faltas";

    }else{
        let list = ""

        query.forEach(falta => {   

            list = list + `<tr>
                                <td>${ falta.id } - </td>
                                <td>
                                    <td>
                                        <a href="registro_ocorrencias.php?idFalta=${ falta.id }">${ falta.nome }</a> - ${falta.motivo} | ${ formatData(falta.dia) }
                                    </td>
                                </td>
                            </tr>`;
        });

        result = `<table>${ list }</table>`
        
    }

    return document.getElementById(divId).innerHTML = result;
}

function formatData(data){
    dataArray = data.split('-')
    return `${dataArray[2]}/${dataArray[1]}/${dataArray[0]}`;
}