<?php
function connectDB()
{
    $dsn = 'mysql:host=localhost;dbname=geovendasteste';
    $username = 'root';
    $password = '';

    try {
        return new PDO($dsn, $username, $password);
    } catch (PDOException $e) {
        die("Connection failed: " . $e->getMessage());
    }
}

function handleGet()
{
    $pdo = connectDB();

    try {
        $stmt = $pdo->query("SELECT id, produto, cor, tamanho, deposito, data_disponibilidade, quantidade FROM estoque");

        $resultados = array();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $resultados[] = $row;
        }

        return json_encode($resultados);
    } catch (PDOException $e) {
        http_response_code(500);
        return json_encode(["error" => "Erro no servidor. Não foi possível trazer os dados."]);
    }
}


function handlePost($input)
{
    if (empty($input)) {
        http_response_code(400);
        return json_encode(["error" => "Input inválido!"]);
    }

    $pdo = connectDB();

    try {
        $pdo->beginTransaction();

        foreach ($input as $item) {
            if (isset($item['id'])) {
                $id = $item['id'];
                $stmt = $pdo->prepare("
                    UPDATE estoque
                    SET produto = :produto,
                        cor = :cor,
                        tamanho = :tamanho,
                        deposito = :deposito,
                        data_disponibilidade = :data_disponibilidade,
                        quantidade = :quantidade
                    WHERE id = :id;
                ");
                $stmt->bindParam(':id', $id);
            } else {
                $stmt = $pdo->prepare("
                    INSERT INTO estoque (produto, cor, tamanho, deposito, data_disponibilidade, quantidade)
                    VALUES (:produto, :cor, :tamanho, :deposito, :data_disponibilidade, :quantidade)
                ");
            }

            $stmt->bindParam(':produto', $item['produto']);
            $stmt->bindParam(':cor', $item['cor']);
            $stmt->bindParam(':tamanho', $item['tamanho']);
            $stmt->bindParam(':deposito', $item['deposito']);
            $stmt->bindParam(':data_disponibilidade', $item['data_disponibilidade']);
            $stmt->bindParam(':quantidade', $item['quantidade']);
            $stmt->execute();
        }

        $pdo->commit();

        return json_encode(["message" => "Sucesso ao atualizar dados!"]);
    } catch (PDOException $e) {
        $pdo->rollBack();
        http_response_code(500);
        return json_encode(["error" => "Erro no servidor. Não foi possível inserir os dados."]);
    }
}
