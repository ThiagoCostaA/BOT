<?php

#Conexão ao servidor de MYSQL

$servidor = 'localhost';
$usuario = 'root';
$senha = '';
$banco = 'bot';
$conn = mysqli_connect($servidor,$usuario,$senha,$banco);

?>

<?php

#Início do Chatbot

$menu1 = 

"
Olá, Somos a Pizzaria TNR                                                                               Vamos começar seu atendimento                                                                           Nos informe o código de sua preferência:

\n*1* - Status de pedido                                                                                                         *2* - Cardápio de Pizzas Tradicionais                                                                                                                                                                                                                                   *3* - Cardápio de Pizzas Doces                                                                                                         *4* - Para encerrar a qualquer momento seu atendimento";

$menu2 = 

"\n*Nos informe o código da pizza de sua prereência:*

*1010* - Pizza de Mussarela *R$40,00*                                                                                                  *1011* - Pizza de Calabresa *R$35,99*                                                                                                  *1012* - Pizza de Frango com Catupiry *R$49,90*                                                                                                  *1013* - Pizza Portuguesa *R$40,00*                                                                                                  *1014* - Pizza de Atum *R$35,99*                                                                                                  *1015* - Pizza de Escarola *R$49,90*                                                                                                  *1016* - Pizza 5 Queijos *R$40,00*                                                                                                  *1017* - Pizza Napolitana *R$35,99*                                                                                                  *1018* - Pizza de Alho e Óleo *R$49,90*";

$menu3 = "*Nos informe o código da bebida de sua preferência:*    
*2010* - Coca-Cola 350ml *R$ 3,99*                                                                                                  *2011* - Guaraná Antarctica 350ml *R$ 2,99*                                                                                                  *2012* - Pepsi 350ml *R$ 12,00*                                                                                                  *2013* - Fanta Laranja 350 Ml *R$ 3,59*                                                                                                  *2014* - Fanta Uva 350 Ml *R$ 3,59*                                                                       *2015* - Schweppes 350 Ml *R$ 3,90*                                                                       *2016* - *Não quero bebida*";

$menu4 = "Pedido anotado, escreva abaixo o seu endereço completo:";

$menu5 = "Algum ponto de referência?";

$menu6 = "Qual a forma de pagamento? Aceitamos:                                                                                                Dinheiro                                                                                                                  Cartão de Crédito/Débito";

$menu7 = "Ok muito obrigado, pedido registrado \n";

$pizza_doce = 

"\n*Nos informe o código da pizza de sua prereência:*

*3010* - Pizza de Abacaxi c/ Coco *R$40,00*                                                                                                  *3011* - Pizza de Chocolate c/ Banana *R$35,99*                                                                                                  *3012* - Pizza de Chocolate c/ Morango *R$49,90*                                                                                                  *3013* - Pizza de Chocolate c/ M&M’s *R$40,00*                                                                                                  *3014* - Pizza de Chocolate Branco c/ M&M’s *R$35,99*                                                                                                  *3015* - Pizza de Banana c/ Canela *R$49,90*";


$data = date('d-m-Y');

$msg = $_GET['msg'];
$telefone_cliente = $_GET['telefone'];

$sql = "SELECT * FROM pedido WHERE telefone ='$telefone_cliente'";  
$num_pedido = $conn -> query($sql);
$dados = mysqli_fetch_array($num_pedido);

$pedido = $dados['num_pedido'] - 1;

$status_pedido_padrao = 'Em produção';

?>

<?php
$msg = $_GET['msg'];
$telefone_cliente = $_GET['telefone'];

#Verifica se o número do cliente já está registado no banco de dados
    $sql = "SELECT * FROM usuario WHERE telefone = '$telefone_cliente'";
    $query = mysqli_query($conn, $sql);
    $total = mysqli_num_rows($query);


while($rows_usuarios = mysqli_fetch_array($query)){
$status = $rows_usuarios['status'];

}

if( $total > 0){

 	#Númrero está registrado no Banco e começa o BOT   
    
if ($status == 1) {

    #Aparece as opões inicias
    echo $menu1;
    $resposta = $menu1 ;

}

if($status == 2){

    #Verifica o status 
 
    if($msg == '4'){

        close();
    }
    elseif($msg == '1'){

        echo "Qual o número do pedido?";

        $sql = "UPDATE usuario SET status = '17' WHERE telefone = '$telefone_cliente'";
        $query = mysqli_query($conn, $sql);
    }
    elseif ($msg == '2' ){
        echo $menu2;
        $resposta = $menu2 ;

        #Inseri o número do pedido para o cliente
        $sql = "INSERT INTO pedido (num_pedido, telefone, status_pedido) VALUES ('$pedido', '$telefone_cliente', '$status_pedido_padrao')";
        $query = mysqli_query($conn, $sql);
    }

    elseif ($msg == '3' ){

        echo $pizza_doce;

        #Inseri o número do pedido para o cliente
        $sql = "INSERT INTO pedido (num_pedido, telefone, status_pedido) VALUES ('$pedido', '$telefone_cliente', '$status_pedido_padrao')";
        $query = mysqli_query($conn, $sql);

        $sql = "UPDATE usuario SET status = '18' WHERE telefone = '$telefone_cliente'";
        $query = mysqli_query($conn, $sql);

    }
    else{
        #Caso a pessoa digitar um número incorreto
        $status_inicial = '1';

        $sql = "UPDATE usuario SET status = '$status_inicial' WHERE telefone = '$telefone_cliente'";
        $query = mysqli_query($conn, $sql);
        echo "Código não identifcado, nos informe um dos seguintes:";
        echo "\n*1* - Status de pedido                                                                                                         *2* - Cardápio de Pizzas Tradicionais                                                                                                                                                                                                                                   *3* - Cardápio de Pizzas Doces                                                                                                         *4* - Para encerrar a qualquer momento seu atendimento";
    }
}


#Menu da Pizza Doce
if($status == 18){
    if($msg == '4'){
        cancel_and_end();
      
    }elseif($msg == '3010'|| $msg == '3011'|| $msg == '3012'|| $msg == '3013'|| $msg == '3014'|| $msg == '3015'){
        #Buca o número de pedido atual
        $sql = "SELECT * FROM pedido WHERE telefone ='$telefone_cliente'";  
        $num_pedido = $conn -> query($sql);
        $dados = mysqli_fetch_array($num_pedido);
            
        $pedido_atual = $dados['num_pedido'];
            
        #Faz a atualização com o número do lanche do pedido
        $sql = "UPDATE pedido SET pizza_doce = '$msg' WHERE num_pedido = '$pedido_atual'";
        $query = mysqli_query($conn, $sql);

        $status_inicial = '3';

        $sql = "UPDATE usuario SET status = '$status_inicial' WHERE telefone = '$telefone_cliente'";
        $query = mysqli_query($conn, $sql);
    
        echo $menu3;
        $resposta = $menu3 ;
    }else{
       
        $status_inicial = '18';

        $sql = "UPDATE usuario SET status = '$status_inicial' WHERE telefone = '$telefone_cliente'";
        $query = mysqli_query($conn, $sql);
        echo "Código não identifcado, nos informe um dos seguintes:";
        echo "\n*3010* - Pizza de Abacaxi c/ Coco *R$40,00*                                                                                                  *3011* - Pizza de Chocolate c/ Banana *R$35,99*                                                                                                  *3012* - Pizza de Chocolate c/ Morango *R$49,90*                                                                                                  *3013* - Pizza de Chocolate c/ M&M’s *R$40,00*                                                                                                  *3014* - Pizza de Chocolate Branco c/ M&M’s *R$35,99*                                                                                                  *3015* - Pizza de Banana c/ Canela *R$49,90*";
    }
}


#Verifica o status do pedido que o cliente soliitar pela opção 2
if($status == 17){

    $sql = "SELECT * FROM pedido WHERE num_pedido ='$msg'";
    $num_pedido = $conn -> query($sql);
    $dados = mysqli_fetch_array($num_pedido);
    
 
    if($msg == '4'){

        $status_inicial = '1';

        $sql = "UPDATE usuario SET status = '$status_inicial' WHERE telefone = '$telefone_cliente'";
        $query = mysqli_query($conn, $sql);

        echo "Atendimento encerrado, obrigado pelo contato.";
    }
    elseif($dados == ''){
        echo 'Código não localizado nos informe o código correto ou nos envie *4* para encerrar o atedimento';
  
        $sql = "UPDATE usuario SET status = '17' WHERE telefone = '$telefone_cliente'";
        $query = mysqli_query($conn, $sql);
    }
    else{
        $sql = "SELECT * FROM pedido WHERE num_pedido ='$msg'";
        $num_pedido = $conn -> query($sql);
        $dados = mysqli_fetch_array($num_pedido);
        $pedido_descritor = $dados['status_pedido'];

        echo "\nO status do pedido $msg é: $pedido_descritor";

        $sql = "UPDATE usuario SET status = '0' WHERE telefone = '$telefone_cliente'";
        $query = mysqli_query($conn, $sql);
        
        echo "\nAtendimento encerrado, obrigado pelo contato";
    }   
}

#Menu da Pizza Tradicional

if($status == 3){

    if($msg == '4'){
        cancel_and_end();
      
    }elseif($msg == '1010'|| $msg == '1011'|| $msg == '1012'|| $msg == '1013'|| $msg == '1014'|| $msg == '1015'|| $msg == '1016'|| $msg == '1017'|| $msg == '1018'){
        #Buca o número de pedido atual
        $sql = "SELECT * FROM pedido WHERE telefone ='$telefone_cliente'";  
        $num_pedido = $conn -> query($sql);
        $dados = mysqli_fetch_array($num_pedido);
            
        $pedido_atual = $dados['num_pedido'];
            
        #Faz a atualização com o número do lanche do pedido
        $sql = "UPDATE pedido SET pizza_tradicional = '$msg' WHERE num_pedido = '$pedido_atual'";
        $query = mysqli_query($conn, $sql);
    
        echo $menu3;
        $resposta = $menu3 ;
    }else{
       
        $status_inicial = '2';

        $sql = "UPDATE usuario SET status = '$status_inicial' WHERE telefone = '$telefone_cliente'";
        $query = mysqli_query($conn, $sql);
        echo "Código não identifcado, nos informe um dos seguintes:";
        echo "\n*1010* - Pizza de Mussarela *R$40,00*                                                                                                  *1011* - Pizza de Calabresa *R$35,99*                                                                                                  *1012* - Pizza de Frango com Catupiry *R$49,90*                                                                                                  *1013* - Pizza Portuguesa *R$40,00*                                                                                                  *1014* - Pizza de Atum *R$35,99*                                                                                                  *1015* - Pizza de Escarola *R$49,90*                                                                                                  *1016* - Pizza 5 Queijos *R$40,00*                                                                                                  *1017* - Pizza Napolitana *R$35,99*                                                                                                  *1018* - Pizza de Alho e Óleo *R$49,90*";
    }
}

if($status == 4){

    if($msg == '2010'|| $msg == '2011'|| $msg == '2012'|| $msg == '2013'|| $msg == '2014'|| $msg == '2015'|| $msg == '2016'){
        #Buca o número de pedido atual
        $sql = "SELECT * FROM pedido WHERE telefone ='$telefone_cliente'";
        $num_pedido = $conn -> query($sql);
        $dados = mysqli_fetch_array($num_pedido);

        $pedido_atual = $dados['num_pedido'];

        #Inseri o número da bebida
        $sql = "UPDATE pedido SET bebida_pedido = '$msg' WHERE num_pedido = '$pedido_atual'";
        $query = mysqli_query($conn, $sql);

        echo $menu4;
        $resposta = $menu4 ;
    }elseif ($msg == '4'){
        cancel_and_end();
    }else{
       
        $status_inicial = '3';

        $sql = "UPDATE usuario SET status = '$status_inicial' WHERE telefone = '$telefone_cliente'";
        $query = mysqli_query($conn, $sql);
        echo "Código não identifcado, nos informe um dos seguintes:";
        echo "\n*2010* - Coca-Cola 350ml *R$ 3,99*                                                                                                  *2011* - Guaraná Antarctica 350ml *R$ 2,99*                                                                                                  *2012* - Pepsi 350ml *R$ 12,00*                                                                                                  *2013* - Fanta Laranja 350 Ml *R$ 3,59*                                                                                                  *2014* - Fanta Uva 350 Ml *R$ 3,59*                                                                       *2015* - Schweppes 350 Ml *R$ 3,90*                                                                       *2016* - Não quero bebida*";
    }
}

if($status == 5){
    if($msg == '4'){
        cancel_and_end();
    }else{
        echo $menu5;
    $resposta = $menu5 ;
    }
}

if($status == 6){

    if($msg == '4'){
        cancel_and_end();
    }else{
        echo $menu6;
        $resposta = $menu6 ;
    }
}


if($status == 7){

    if($msg == '4'){        
       cancel_and_end();
    }else{
        #Buca o número de pedido atual
        $sql = "SELECT * FROM pedido WHERE telefone ='$telefone_cliente'";
        $num_pedido = $conn -> query($sql);
        $dados = mysqli_fetch_array($num_pedido);

        $pedido_atual = $dados['num_pedido'];

        #Inseri o método de pagamento
        $sql = "UPDATE pedido SET forma_pgto = '$msg' WHERE num_pedido = '$pedido_atual'";
        $query = mysqli_query($conn, $sql);

        echo $menu7;
        $resposta = $menu7;

        $sql = "SELECT * FROM pedido WHERE telefone ='$telefone_cliente'";
        $num_pedido = $conn -> query($sql);
        $dados = mysqli_fetch_array($num_pedido);
        
        echo 'Seu pedido é: '.$dados['num_pedido'];

        $pizza_tradicinal_cliente = $dados['pizza_tradicional'];
        $pizza_doce_cliente = $dados['pizza_doce'];
        $bebida_cliente =$dados['bebida_pedido'];

        #Busca do preco do pedido em duas tabelas

        $sql = "SELECT * FROM preco WHERE id_pizza ='$pizza_tradicinal_cliente'";
        $preco_produto = $conn -> query($sql);
        $dados_preco_pizza_tradicional = mysqli_fetch_array($preco_produto);

        $preco_atual = 0;
        
        if($dados_preco_pizza_tradicional == true){
            $preco_produto1 = $dados_preco_pizza_tradicional['preco_produto'];
            $preco_atual += $preco_produto1;
        }

        # Pizza Doce

        $sql = "SELECT * FROM preco WHERE id_pizza ='$pizza_doce_cliente'";
        $preco_produto = $conn -> query($sql);
        $dados_preco_pizza_doce = mysqli_fetch_array($preco_produto);

        if($dados_preco_pizza_doce == true){
            $preco_produto2 = $dados_preco_pizza_doce['preco_produto'];
            $preco_atual += $preco_produto2;
        }

        #Bebida

        $sql = "SELECT * FROM preco WHERE id_pizza ='$bebida_cliente'";
        $preco_produto = $conn -> query($sql);
        $dados_preco_bebida = mysqli_fetch_array($preco_produto);

        if($dados_preco_bebida == true){
            $preco_bebida = $dados_preco_bebida['preco_produto'];
            $preco_atual += $preco_bebida;
        }

        echo "\nO preco total do pedido em ficou em *R$$preco_atual*";

        echo "\nAgora só resta esperar e apreciar sua refeição quando chegar                                                                                               Nosso prazo de entrega é de 40/50 minutos.";
        echo "\nQualquer dúvida sobre o pedido, entraremos em contato";
        echo "\nDigite *3* para *cancelar* o seu pedido.                                                                                                  Digite *4* para *encerrar* o atendimento.                                                                                                  Digite *5* para *consultar* o status do seu último pedido.                                                                                                  Digite *6* para abrir o menu de *Pizza Doces* e adicionar uma pizza desse sabor                                                                                                  Digite *7* para abrir o menu de *Pizzas Tradicionais* e adicionar uma pizza desse sabor";
        
    }
}


if($status == 8){
    if($msg == '3'){
        cancel();
    }elseif ($msg == '4') {
        close();
    }elseif($msg == '5'){
        verify_last_status();
    }elseif($msg == '6'){
        echo $pizza_doce;

        #Inseri o número do pedido para o cliente
    
        $sql = "UPDATE usuario SET status = '19' WHERE telefone = '$telefone_cliente'";
        $query = mysqli_query($conn, $sql);
    }elseif($msg == '7'){
        echo $menu2;

        #Inseri o número do pedido para o cliente

        $sql = "UPDATE usuario SET status = '20' WHERE telefone = '$telefone_cliente'";
        $query = mysqli_query($conn, $sql);
    }else{
        echo 'Código não localizado';
        echo "\nDigite *3* para *cancelar* o seu pedido.                                                                                                  Digite *4* para *encerrar* o atendimento.                                                                                                  Digite *5* para *consultar* o status do seu último pedido.                                                                                                  Digite *6* para abrir o menu de *Pizza Doces*                                                                                                  Digite *7* para abrir o menu de *Pizzas Tradicionais*";

    }
}

#Abrir novamente o menu de pizzas doces
if($status == 19){
    if($msg == '4'){
        close();
      
    }elseif($msg == '3010'|| $msg == '3011'|| $msg == '3012'|| $msg == '3013'|| $msg == '3014'|| $msg == '3015'){
        #Buca o número de pedido atual
        $sql = "SELECT * FROM pedido WHERE telefone ='$telefone_cliente'";  
        $num_pedido = $conn -> query($sql);
        $dados = mysqli_fetch_array($num_pedido);
            
        $pedido_atual = $dados['num_pedido'];
    
        #Faz a atualização com o número do lanche do pedido
        $sql = "UPDATE pedido SET pizza_doce = '$msg' WHERE num_pedido = '$pedido_atual'";
        $query = mysqli_query($conn, $sql);

        $status_inicial = '0';

        $sql = "UPDATE usuario SET status = '$status_inicial' WHERE telefone = '$telefone_cliente'";
        $query = mysqli_query($conn, $sql);

        
        $pizza_tradicinal_cliente = $dados['pizza_tradicional'];
        $pizza_doce_cliente = $dados['pizza_doce'];
        $bebida_cliente =$dados['bebida_pedido'];

        #Buca o número de pedido atual
        $sql = "SELECT * FROM pedido WHERE telefone ='$telefone_cliente'";
        $num_pedido = $conn -> query($sql);
        $dados = mysqli_fetch_array($num_pedido);

        $pedido_atual = $dados['num_pedido'];

        $sql = "SELECT * FROM pedido WHERE telefone ='$telefone_cliente'";
        $num_pedido = $conn -> query($sql);
        $dados = mysqli_fetch_array($num_pedido);
        
        echo 'Seu pedido é: '.$dados['num_pedido'];

        $pizza_tradicinal_cliente = $dados['pizza_tradicional'];
        $pizza_doce_cliente = $dados['pizza_doce'];
        $bebida_cliente =$dados['bebida_pedido'];

        #Busca do preco do pedido em duas tabelas

        $sql = "SELECT * FROM preco WHERE id_pizza ='$pizza_tradicinal_cliente'";
        $preco_produto = $conn -> query($sql);
        $dados_preco_pizza_tradicional = mysqli_fetch_array($preco_produto);

        $preco_atual = 0;
        
        if($dados_preco_pizza_tradicional == true){
            $preco_produto1 = $dados_preco_pizza_tradicional['preco_produto'];
            $preco_atual += $preco_produto1;
        }

        # Pizza Doce

        $sql = "SELECT * FROM preco WHERE id_pizza ='$pizza_doce_cliente'";
        $preco_produto = $conn -> query($sql);
        $dados_preco_pizza_doce = mysqli_fetch_array($preco_produto);

        if($dados_preco_pizza_doce == true){
            $preco_produto2 = $dados_preco_pizza_doce['preco_produto'];
            $preco_atual += $preco_produto2;
        }

        #Bebida

        $sql = "SELECT * FROM preco WHERE id_pizza ='$bebida_cliente'";
        $preco_produto = $conn -> query($sql);
        $dados_preco_bebida = mysqli_fetch_array($preco_produto);

        if($dados_preco_bebida == true){
            $preco_bebida = $dados_preco_bebida['preco_produto'];
            $preco_atual += $preco_bebida;
        }

        echo "\nO preco total do pedido em ficou em *R$$preco_atual*";

        echo "\nPizza adicionada no pedido, obrigado pelo contato";  
        
    }else{
       
        $status_inicial = '19';

        $sql = "UPDATE usuario SET status = '$status_inicial' WHERE telefone = '$telefone_cliente'";
        $query = mysqli_query($conn, $sql);
        echo "Código não identifcado, nos informe um dos seguintes:";
        echo "\n*3010* - Pizza de Abacaxi c/ Coco *R$40,00*                                                                                                  *3011* - Pizza de Chocolate c/ Banana *R$35,99*                                                                                                  *3012* - Pizza de Chocolate c/ Morango *R$49,90*                                                                                                  *3013* - Pizza de Chocolate c/ M&M’s *R$40,00*                                                                                                  *3014* - Pizza de Chocolate Branco c/ M&M’s *R$35,99*                                                                                                  *3015* - Pizza de Banana c/ Canela *R$49,90*";
    }
}

#Abrir novamente o menu de pizzas salgadas
if($status == 20){

    if($msg == '4'){
        close();
      
    }elseif($msg == '1010'|| $msg == '1011'|| $msg == '1012'|| $msg == '1013'|| $msg == '1014'|| $msg == '1015'|| $msg == '1016'|| $msg == '1017'|| $msg == '1018'){
        #Buca o número de pedido atual
        $sql = "SELECT * FROM pedido WHERE telefone ='$telefone_cliente'";  
        $num_pedido = $conn -> query($sql);
        $dados = mysqli_fetch_array($num_pedido);
            
        $pedido_atual = $dados['num_pedido'];
    
        #Faz a atualização com o número do lanche do pedido
        $sql = "UPDATE pedido SET pizza_tradicional = '$msg' WHERE num_pedido = '$pedido_atual'";
        $query = mysqli_query($conn, $sql);

        $status_inicial = '0';

        $sql = "UPDATE usuario SET status = '$status_inicial' WHERE telefone = '$telefone_cliente'";
        $query = mysqli_query($conn, $sql);

        
        $pizza_tradicinal_cliente = $dados['pizza_tradicional'];
        $pizza_doce_cliente = $dados['pizza_doce'];
        $bebida_cliente =$dados['bebida_pedido'];

       
        #Buca o número de pedido atual
        $sql = "SELECT * FROM pedido WHERE telefone ='$telefone_cliente'";
        $num_pedido = $conn -> query($sql);
        $dados = mysqli_fetch_array($num_pedido);

        $pedido_atual = $dados['num_pedido'];

        echo $menu7;

        $sql = "SELECT * FROM pedido WHERE telefone ='$telefone_cliente'";
        $num_pedido = $conn -> query($sql);
        $dados = mysqli_fetch_array($num_pedido);
        
        echo 'Seu pedido é: '.$dados['num_pedido'];

        $pizza_tradicinal_cliente = $dados['pizza_tradicional'];
        $pizza_doce_cliente = $dados['pizza_doce'];
        $bebida_cliente =$dados['bebida_pedido'];

        #Busca do preco do pedido em duas tabelas

        $sql = "SELECT * FROM preco WHERE id_pizza ='$pizza_tradicinal_cliente'";
        $preco_produto = $conn -> query($sql);
        $dados_preco_pizza_tradicional = mysqli_fetch_array($preco_produto);

        $preco_atual = 0;
        
        if($dados_preco_pizza_tradicional == true){
            $preco_produto1 = $dados_preco_pizza_tradicional['preco_produto'];
            $preco_atual += $preco_produto1;
        }

        # Pizza Doce

        $sql = "SELECT * FROM preco WHERE id_pizza ='$pizza_doce_cliente'";
        $preco_produto = $conn -> query($sql);
        $dados_preco_pizza_doce = mysqli_fetch_array($preco_produto);

        if($dados_preco_pizza_doce == true){
            $preco_produto2 = $dados_preco_pizza_doce['preco_produto'];
            $preco_atual += $preco_produto2;
        }

        #Bebida

        $sql = "SELECT * FROM preco WHERE id_pizza ='$bebida_cliente'";
        $preco_produto = $conn -> query($sql);
        $dados_preco_bebida = mysqli_fetch_array($preco_produto);

        if($dados_preco_bebida == true){
            $preco_bebida = $dados_preco_bebida['preco_produto'];
            $preco_atual += $preco_bebida;
        }

        echo "\nO preco total do pedido em ficou em *R$$preco_atual*";

        echo "\nPizza adicionada no pedido, obrigado pelo contato";  
    
    }else{
       
        $status_inicial = '20';

        $sql = "UPDATE usuario SET status = '$status_inicial' WHERE telefone = '$telefone_cliente'";
        $query = mysqli_query($conn, $sql);
        echo "Código não identifcado, nos informe um dos seguintes:";
        echo "\n*1010* - Pizza de Mussarela *R$40,00*                                                                                                  *1011* - Pizza de Calabresa *R$35,99*                                                                                                  *1012* - Pizza de Frango com Catupiry *R$49,90*                                                                                                  *1013* - Pizza Portuguesa *R$40,00*                                                                                                  *1014* - Pizza de Atum *R$35,99*                                                                                                  *1015* - Pizza de Escarola *R$49,90*                                                                                                  *1016* - Pizza 5 Queijos *R$40,00*                                                                                                  *1017* - Pizza Napolitana *R$35,99*                                                                                                  *1018* - Pizza de Alho e Óleo *R$49,90*";
    }
}

}else{
#Inserir novo usuário ao Banco
$sql = "INSERT INTO usuario (telefone, status) VALUES ('$telefone_cliente', '1')";
$query = mysqli_query($conn,$sql);

    if(!$query){}else{
        echo $menu1;
        $resposta = $menu1 ;
    }
////nao existe o numero no banco
}

?>

<?php

$sql = "SELECT * FROM usuario WHERE telefone = '$telefone_cliente'";
$query = mysqli_query($conn, $sql);
$total = mysqli_num_rows($query);

while($rows_usuarios = mysqli_fetch_array($query)){
$status = $rows_usuarios['status'];

}

if($status < 8){

    #Atualiza o status do usuário
    $status2 = $status + 1;

    $sql = "UPDATE usuario SET status = '$status2' WHERE telefone = '$telefone_cliente'";
    $query = mysqli_query($conn, $sql);
}

 #Zerar voltar o status do cliente para conseguirmos realizar um novo atendimento


 #Cancela o pedido e encerra o atendimento


    function cancel(){

        $servidor = 'localhost';    
        $usuario = 'root';
        $senha = '';
        $banco = 'bot';
        $conn = mysqli_connect($servidor,$usuario,$senha,$banco);

        $status_inicial = '0';
        $telefone_cliente = $_GET['telefone'];

        $sql = "SELECT * FROM pedido WHERE telefone ='$telefone_cliente'";
        $num_pedido = $conn -> query($sql);
        $dados = mysqli_fetch_array($num_pedido);
        
        $pedido_atual = $dados['num_pedido'];
   
        $sql = "DELETE FROM pedido WHERE num_pedido = '$pedido_atual'";
        $query = mysqli_query($conn, $sql);
   
        $sql = "UPDATE usuario SET status = '$status_inicial' WHERE telefone = '$telefone_cliente'";
        $query = mysqli_query($conn, $sql);
        
        echo "Pedido foi cancelado, obrigado pelo contato.";
    }


function close(){

    $servidor = 'localhost';    
    $usuario = 'root';
    $senha = '';
    $banco = 'bot';
    $conn = mysqli_connect($servidor,$usuario,$senha,$banco);
    
    $telefone_cliente = $_GET['telefone'];

    $status_inicial = '0';

    $sql = "UPDATE usuario SET status = '$status_inicial' WHERE telefone = '$telefone_cliente'";
    $query = mysqli_query($conn, $sql);
    
    echo "Atendimento encerrado, obrigado pelo contato.";
}


 #Verificar o status do pedido atual


    function verify_last_status(){

        $servidor = 'localhost';    
        $usuario = 'root';
        $senha = '';
        $banco = 'bot';
        $conn = mysqli_connect($servidor,$usuario,$senha,$banco);

        $telefone_cliente = $_GET['telefone'];

        $sql = "SELECT * FROM pedido WHERE telefone ='$telefone_cliente'";
        $num_pedido = $conn -> query($sql);
        $dados = mysqli_fetch_array($num_pedido);
        
        $pedido_atual = $dados['num_pedido'];
        
        $sql = "SELECT * FROM pedido WHERE num_pedido ='$pedido_atual'";
        $num_pedido = $conn -> query($sql);
        $dados = mysqli_fetch_array($num_pedido);
        
        echo "O status do pedido $pedido_atual é: ".$dados['status_pedido'];

        echo "\nPara *cancelar* o atendimento pressione *3*
        \nPara *encerrar* o atendimento pressione *4*";
    }

    function cancel_and_end(){

        $servidor = 'localhost';    
        $usuario = 'root';
        $senha = '';
        $banco = 'bot';
        $conn = mysqli_connect($servidor,$usuario,$senha,$banco);
        
        $telefone_cliente = $_GET['telefone'];

        $status_inicial = '0';

        $sql = "SELECT * FROM pedido WHERE telefone ='$telefone_cliente'";
        $num_pedido = $conn -> query($sql);
        $dados = mysqli_fetch_array($num_pedido);
        
        $pedido_atual = $dados['num_pedido'];

        $sql = "UPDATE usuario SET status = '$status_inicial' WHERE telefone = '$telefone_cliente'";
        $query = mysqli_query($conn, $sql);

        $sql = "DELETE FROM pedido WHERE num_pedido = '$pedido_atual'";
        $query = mysqli_query($conn, $sql);

        echo "Atendimento encerrado, obrigado pelo contato";
    }
?>