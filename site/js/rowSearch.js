function rowSearch(funcionarios, inputId, divId){
    const input = document.getElementById(inputId).value.toLowerCase(),
        query = funcionarios.map(({nome, idFunc, rg}) => ({nome, rg, id: idFunc })).filter(({nome}) => nome.toLowerCase().includes(input));

    let result = '';
    let list = ''!

    if(!query[0]) return document.getElementById(divId).innerHTML = "Não consegui encontrar";

    query.forEach(funcionario => {
        list = list + `<tr>
                            <td>${ funcionario.id }</td>
                            <td>${ funcionario.nome }</td>
                            <td>
                                <a href="funcionarios.php?funcId=${ funcionario.id }">
                                    <img src="./assets/edit.png">
                                </a>
                                <a href="funcionarios.php?deleteId=${ funcionario.id }">
                                    <img src="./assets/delete.png">
                                </a>
                            </td>
                        </tr>`;
        });
    result = `<table>${ list }</table>`
    return document.getElementById(divId).innerHTML = result;
}
