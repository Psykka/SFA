function rowSearch(funcionarios, inputId, divId) {
    let input = document.getElementById(inputId).value.toLowerCase(),
        query = funcionarios.map(f => { return { nome: f.nome, id: f.idFunc, rg: f.rg } }).filter(n => { return n.nome.toLowerCase().includes(input) })

    let result = "";

    if (!query[0]) {
        result = "Não consegui encontrar";

    } else {
        let list = "";


        for(i = 0; i <= query.length; i++) {
            if(query[i]){
            list = list + `<tr>
                                <td>${ query[i].id }</td>
                                <td>${ query[i].nome }</td>
                                <td>
                                    <a href="funcionarios.php?funcId=${ query[i].id}">
                                        <img src="./assets/edit.png">
                                    </a>
                                    <a href="funcionarios.php?deleteId=${ query[i].id}">
                                    <img src="./assets/delete.png">
                                    </a>
                                </td>
                            </tr>`;
            }
        }

        result = `<table>${list}</table>`;

    }

    return document.getElementById(divId).innerHTML = result;
}