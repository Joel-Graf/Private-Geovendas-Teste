<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciamento de Estoque</title>
    <link rel="stylesheet" type="text/css" href="style.css" />
</head>

<body>
    <div class="container">
        <h2 class="text-center mb-4">Gerenciamento de Estoque</h2>

        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Produto</th>
                    <th>Cor</th>
                    <th>Tamanho</th>
                    <th>Depósito</th>
                    <th>Data de Disponibilidade</th>
                    <th>Quantidade</th>
                </tr>
            </thead>
            <tbody>
                <?php
                require 'api_functions.php';

                $dados_estoque_json = handleGet();
                $dados_estoque = json_decode($dados_estoque_json, true);

                if (is_array($dados_estoque)) {
                    foreach ($dados_estoque as $item) {
                        echo "<tr>";
                        echo "<td>" . $item['produto'] . "</td>";
                        echo "<td>" . $item['cor'] . "</td>";
                        echo "<td>" . $item['tamanho'] . "</td>";
                        echo "<td>" . $item['deposito'] . "</td>";
                        echo "<td>" . $item['data_disponibilidade'] . "</td>";
                        echo "<td>" . $item['quantidade'] . "</td>";
                        echo "</tr>";
                    }
                }
                ?>
            </tbody>
        </table>
    </div>
</body>

</html>