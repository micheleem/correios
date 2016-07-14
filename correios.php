<!DOCTYPE>
<html>
    <head>
        <meta charset = "UTF-8"/>
    </head>
    <body>
        <form action="" method="GET">
            Informe o CEP: <input type="text" name="cep">
            <input type="submit" value="BUSCAR">
        </form>
        <?php
        class Correios{
            public function cep($cep){
                $ch = curl_init();
                $dadosCEP = array( 
                    CURLOPT_URL => 'http://m.correios.com.br/movel/buscaCepConfirma.do',
                    CURLOPT_POST => true,
                    CURLOPT_POSTFIELDS => "cepEntrada=".$cep."&metodo=buscarCep",
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_HEADER => false
                );
                curl_setopt_array($ch, $dadosCEP);
                $resposta = curl_exec($ch);
                $resposta = utf8_encode($resposta);
                $string = trim(preg_replace('/\s\s+/','',$resposta));
                preg_match_all('/respostadestaque\">(.*?)<\/span/', $string, $resultado);
                return $resultado[1];
                curl_close($ch);
            }
         }
            if (isset($_GET['cep'])){
                $cep = $_GET['cep'];
                if(empty($cep)){
                    echo "informe o cep";
                }else{
                    $obj = new Correios;
                    $endereco = $obj->cep($cep);
                    echo("<br/>".$endereco[0]);
                    echo("<br/>".$endereco[1]);
                    echo("<br/>".$endereco[2]);
                    echo("<br/>".$endereco[3]);
                }
            }
        ?>
    </body>
</html>
