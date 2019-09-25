function rowSearch(funcionarios, inputId, divId){
    let input = document.getElementById(inputId).value.toLowerCase(),
        query = funcionarios.map( f =>{ return {nome: f.nome, id: f.idFunc, rg: f.rg} }).filter( n =>{ return n.nome.toLowerCase().includes(input) })

    let result = ""

    if(!query[0]){
        result = "Não consegui encontrar";

    }else{
        let list = ""

        query.forEach(funcionario => {
            list = list + `<tr>
                                <td>${ funcionario.id }</td>
                                <td>
                                    <td>
                                        <a href="faltas.php?funcId=${ funcionario.id }">${ funcionario.nome }</a>
                                    </td>
                                </td>
                            </tr>`;
        });

        result = `<table>${ list }</table>`
        
    }

    return document.getElementById(divId).innerHTML = result;
}