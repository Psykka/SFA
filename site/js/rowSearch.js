function rowSearch(funcionarios, inputId, divId){
    let input = document.getElementById(inputId).value.toLowerCase(),
        query = funcionarios.map( f =>{ return {nome: f.nome, id: f.idFunc} }).filter( n =>{ return n.nome.toLowerCase().includes(input) })

    let result = ""

    if(!query[0]){
        result = "Não consegui encontrar";

    }else{
        let list = ""

        query.forEach(funcionario => {
            list = list + `<tr>
                                <td>${ funcionario.id }</td>
                                <td>${ funcionario.nome }</td>
                                <td>
                                    <a href="funcionarios.php?funcId=${ funcionario.id }">Editar</a>
                                </td>
                            </tr>`;
        });

        result = `<table>${ list }</table>`
        
    }

    return document.getElementById(divId).innerHTML = result;
}