<?php
    include_once("connection.php");   //estabelece conexão

    header ('Content-type: text/html; charset=utf-8');

    if(isset($_POST["id"]))     //verifica se a variável existe, ou tem valor diferente de null
    {   // select que vai consultar no banco
        $queryInadimpCPF = "SELECT d.*, c.debtor_name, c.debtor_cpf, c.debtor_rg
                FROM Debt d
                INNER JOIN Debtor c ON d.debtor_id = c.debtor_cpf
                INNER JOIN Store s ON d.store_id = s.store_id
                WHERE d.debt_id = '".addslashes($_POST["id"])."'
                ORDER BY d.debt_id";
        //fim do select----------------------
        $dados = mysqli_query($con, $queryInadimpCPF) or die($mysqli->error); //envia para o banco a query

        $recebeJson = array();  //estabelece como um array
        while($dado = mysqli_fetch_assoc($dados)){
            $data["nome"] = $dado["debtor_name"];  
            $data["cpf"] = $dado["debtor_cpf"];
            $data["rg"] = $dado["debtor_rg"];
            $data["valor"] = $dado["debt_value"];
            $data["obs"] = $dado["debt_observation"];
            array_push($recebeJson, $data);             //pega os dados de data e passa para recebeJson
        }
        echo json_encode($recebeJson, JSON_FORCE_OBJECT); //escreve na pagina um objeto json
    }
    // tira o resultado da busca da memória
    mysqli_close($con);
?>
