function rowSearch(funcionarios, inputId, divId){
    let input = document.getElementById(inputId).value.toLowerCase(),
        query = funcionarios.map( f =>{ return {nome: f.nome, id: f.idFunc, rg: f.rg} }).filter( n =>{ return n.nome.toLowerCase().includes(input) })

    let result = ""

    if(!query[0]){
        result = "Não consegui encontrar";

    }else{
        let list = ""

        for(i = 0; i <= 4; i++) {
            if(query[i]){
            list = list + `<tr>
                                <td>${ query[i].id }</td>
                                <td>
                                    <td>
                                        <a href="faltas.php?funcId=${ query[i].id }">${ query[i].nome }</a>
                                    </td>
                                </td>
                            </tr>`;
            }
        }

        result = `<table>${ list }</table>`
        
    }

    return document.getElementById(divId).innerHTML = result;
}