<?php
$erro = "";



if($erro == ""){
        try{
            require_once("../../includes/connections/connection.php");

            $cd_postagem = $_POST['id'];
            $cd_perfil = 1;
            
            $sql = "SELECT * FROM tb_descurtida WHERE cd_postagem = '$cd_postagem' AND cd_perfil = '$cd_perfil' LIMIT 1";
            $dados = $conn->query($sql);        
            $result = $dados->fetchAll(PDO::FETCH_ASSOC);
            
            if($result == true ){ //aqui ele quer tirar o deslike
                $sql = "DELETE FROM tb_descurtida WHERE cd_postagem = '$cd_postagem' AND cd_perfil = '$cd_perfil' LIMIT 1";
                $linhaAfetadas = $conn->exec($sql);
                echo false;   
            }else{                

                $sql1 = "SELECT * FROM tb_curtida WHERE cd_postagem = '$cd_postagem' AND cd_perfil = '$cd_perfil' LIMIT 1";
                $dados1 = $conn->query($sql1);        
                $result1 = $dados1->fetchAll(PDO::FETCH_ASSOC);

                if($result1 == true){ 
                    $sql = "DELETE FROM tb_curtida WHERE cd_postagem = '$cd_postagem' AND cd_perfil = '$cd_perfil' LIMIT 1";
                    $linhaAfetadas = $conn->exec($sql);

                    $sql = $conn->prepare("INSERT INTO tb_descurtida (cd_postagem, cd_perfil) 
                    values (:cd_postagem, :cd_perfil)");
                    $sql->bindParam(':cd_postagem', $cd_postagem);
                    $sql->bindParam(':cd_perfil', $cd_perfil);    
                    $sql->execute();
                    echo 'outro';

                }else{
                    
                $sql = $conn->prepare("INSERT INTO tb_descurtida (cd_postagem, cd_perfil) 
                values (:cd_postagem, :cd_perfil)");
                $sql->bindParam(':cd_postagem', $cd_postagem);
                $sql->bindParam(':cd_perfil', $cd_perfil);    
                $sql->execute();
                echo true;
                }
            }

        }catch(PDOException $exception){
            echo "Erro: " . $exception->getMessage() . " - Código " . $exception->getCode();
        }
    }else{
        echo "Erro: " . $erro;
    }
?>