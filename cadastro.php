<html>
    <head>
        <meta charset="UTF-8">
        <title>Cadastro de Funcionários - Vida Animal</title>

        <!-- CSS externo -->
        <link rel="stylesheet" href="estilo.css">
    </head>
    <body>
        <script type="text/javascript">
        function verifica_formulario() {
            if (cadastro.nome.value==""){
                alert("Preencher o Nome");
                cadastro.nome.focus();
                return false;
            }
            if (cadastro.endereco.value==""){
                alert("Preencher o Endereço");
                cadastro.endereco.focus();
                return false;
            }
            if (cadastro.numero.value==""){
                alert("Preencher o Número");
                cadastro.numero.focus();
                return false;
            }
            if (cadastro.complemento.value==""){
                alert("Preencher o Complemento");
                cadastro.complemento.focus();
                return false;
            }
            if (cadastro.celular.value==""){
                alert("Preencher o Celular");
                cadastro.celular.focus();
                return false;
            }
            if (cadastro.bairro.value==""){
                alert("Preencher o Bairro");
                cadastro.bairro.focus();
                return false;
            }
            if (cadastro.cep.value==""){
                alert("Preencher o CEP");
                cadastro.cep.focus();
                return false;
            }
            if (cadastro.cidade.value==""){
                alert("Preencher a Cidade");
                cadastro.cidade.focus();
                return false;
            }
            if (cadastro.uf.selectedIndex==0){
                alert("Selecione o estado");
                cadastro.uf.focus();
                return false;
            }
            if (cadastro.email.value==""){
                alert("Preencher o E-mail");
                cadastro.email.focus();
                return false;
            }
            if ((cadastro.email.value.indexOf("@")==-1)||(cadastro.email.value.indexOf(".")==-1)){
                alert("E-mail inválido");
                cadastro.email.focus();
                return false;
            }
            if (cadastro.cargo.selectedIndex==0){
                alert("Selecione o Cargo");
                cadastro.cargo.focus();
                return false;
            }
            if (cadastro.departamento.selectedIndex==0){
                alert("Selecione o Departamento");
                cadastro.departamento.focus();
                return false;
            }
            if (cadastro.usuario.value==""){
                alert("Preencher o Usuário");
                cadastro.usuario.focus();
                return false;
            }
            if (cadastro.senha.value==""){
                alert("Preencher a Senha");
                cadastro.senha.focus();
                return false;
            }
            return true;
        }
        </script>

        <?php
        //Mostra a mensagem de erro do campo e o link para voltar ao formulario
        function mostra_erro($campo){
            echo "Campo ".$campo." incorreto ";
            echo "<a href='javascript:history.back()'>Voltar</a>";
            exit;
        }

        //Retorna true se o texto existir dentro do campo (o espaco na frente evita a posicao 0)
        function contem($valor, $texto){
            if (strrpos(" ".$valor, $texto)>0){
                return true;
            }
            return false;
        }

        //PROCESSAMENTO ANTI-SQL INJECTION
        function verifica_sql($valor, $campo){
            if ((contem($valor,"select"))||(contem($valor,"SELECT"))||
                (contem($valor,"update"))||(contem($valor,"UPDATE"))||
                (contem($valor,"insert"))||(contem($valor,"INSERT"))||
                (contem($valor,"delete"))||(contem($valor,"DELETE"))||
                (contem($valor,"drop"))||(contem($valor,"DROP"))||
                (contem($valor,"'"))
                ){
                mostra_erro($campo);
            }
        }

        //Nao permite os caracteres especiais * # ! @ < >
        function verifica_especiais($valor, $campo){
            if ((contem($valor,"*"))||(contem($valor,"#"))||(contem($valor,"!"))||
                (contem($valor,"@"))||(contem($valor,"<"))||(contem($valor,">"))
                ){
                mostra_erro($campo);
            }
        }

        function processa_formulario(){
            //Nao permite campos em branco
            if ($_GET["nome"]==""){ mostra_erro("Nome"); }
            if ($_GET["endereco"]==""){ mostra_erro("Endereço"); }
            if ($_GET["numero"]==""){ mostra_erro("Número"); }
            if ($_GET["complemento"]==""){ mostra_erro("Complemento"); }
            if ($_GET["celular"]==""){ mostra_erro("Celular"); }
            if ($_GET["bairro"]==""){ mostra_erro("Bairro"); }
            if ($_GET["cep"]==""){ mostra_erro("CEP"); }
            if ($_GET["cidade"]==""){ mostra_erro("Cidade"); }
            if ($_GET["uf"]==""){ mostra_erro("UF"); }
            if ($_GET["email"]==""){ mostra_erro("E-mail"); }
            if ($_GET["cargo"]==""){ mostra_erro("Cargo"); }
            if ($_GET["departamento"]==""){ mostra_erro("Departamento"); }
            if ($_GET["usuario"]==""){ mostra_erro("Usuário"); }
            if ($_GET["senha"]==""){ mostra_erro("Senha"); }

            //Caracteres especiais nos campos nome, endereco, cidade e bairro
            verifica_especiais($_GET["nome"], "Nome");
            verifica_especiais($_GET["endereco"], "Endereço");
            verifica_especiais($_GET["cidade"], "Cidade");
            verifica_especiais($_GET["bairro"], "Bairro");

            //E-mail precisa ter "@" e "."
            if ((contem($_GET["email"],"@")==false)||(contem($_GET["email"],".")==false)){
                mostra_erro("E-mail");
            }

            //Celular so aceita numeros
            if (is_numeric($_GET["celular"])==false){
                mostra_erro("Celular");
            }

            //CEP com 8 numeros (o traco e retirado)
            $cep=str_replace("-", "", $_GET["cep"]);
            if ((is_numeric($cep)==false)||(strlen($cep)!=8)){
                mostra_erro("CEP");
            }

            //SQL injection em todos os campos digitados
            verifica_sql($_GET["nome"], "Nome");
            verifica_sql($_GET["endereco"], "Endereço");
            verifica_sql($_GET["numero"], "Número");
            verifica_sql($_GET["complemento"], "Complemento");
            verifica_sql($_GET["bairro"], "Bairro");
            verifica_sql($_GET["cidade"], "Cidade");
            verifica_sql($_GET["email"], "E-mail");
            verifica_sql($_GET["usuario"], "Usuário");
            verifica_sql($_GET["senha"], "Senha");
        }

        if ((isset($_GET["nome"]))&&(isset($_GET["email"]))){
            processa_formulario();
        }
        ?>

        <form name="cadastro" method="GET" action="cadastro.php" onsubmit="return verifica_formulario()">
            <table width="100%">
                <tr>
                    <th colspan="4">Cadastro de Funcionários</th>
                </tr>

                <tr>
                    <td width="18%" align="right"><b>Nome:</b></td>
                    <td colspan="3"><input type="text" name="nome" size="60" maxlength="30"></td>
                </tr>

                <tr>
                    <td align="right"><b>Endereço:</b></td>
                    <td width="35%"><input type="text" name="endereco" size="30" maxlength="50"></td>
                    <td width="15%" align="right"><b>Número:</b></td>
                    <td><input type="text" name="numero" size="8" maxlength="6"></td>
                </tr>

                <tr>
                    <td align="right"><b>Complemento:</b></td>
                    <td><input type="text" name="complemento" size="30" maxlength="40"></td>
                    <td align="right"><b>Celular:</b></td>
                    <td><input type="text" name="celular" size="15" maxlength="15"></td>
                </tr>

                <tr>
                    <td align="right"><b>Bairro:</b></td>
                    <td><input type="text" name="bairro" size="30" maxlength="30"></td>
                    <td align="right"><b>CEP:</b></td>
                    <td><input type="text" name="cep" size="15" maxlength="9"></td>
                </tr>

                <tr>
                    <td align="right"><b>Cidade:</b></td>
                    <td><input type="text" name="cidade" size="30" maxlength="40"></td>
                    <td align="right"><b>UF:</b></td>
                    <td>
                        <select name="uf">
                            <option value="">Selecione</option>
                            <option value="SP">SP</option>
                            <option value="AM">AM</option>
                            <option value="RJ">RJ</option>
                            <option value="MG">MG</option>
                        </select>
                    </td>
                </tr>

                <tr>
                    <td align="right"><b>E-mail:</b></td>
                    <td><input type="text" name="email" size="30" maxlength="50"></td>
                    <td align="right"><b>Cargo:</b></td>
                    <td>
                        <select name="cargo">
                            <option value="">Selecione</option>
                            <option value="veterinario">Veterinário(a)</option>
                            <option value="recepcao">Recepção</option>
                            <option value="banho_tosa">Banho e Tosa</option>
                        </select>
                    </td>
                </tr>

                <tr>
                    <td align="right"><b>Departamento:</b></td>
                    <td colspan="3">
                        <select name="departamento">
                            <option value="">Selecione</option>
                            <option value="clinica">Clínica Médica</option>
                            <option value="estetica">Estética Animal</option>
                            <option value="adm">Administrativo</option>
                        </select>
                    </td>
                </tr>

                <tr>
                    <td align="right"><b>Usuário:</b></td>
                    <td><input type="text" name="usuario" size="20" maxlength="8"></td>
                    <td align="right"><b>Senha:</b></td>
                    <td><input type="password" name="senha" size="20" maxlength="8"></td>
                </tr>

                <tr>
                    <td colspan="4" align="center" style="padding-top: 15px; padding-bottom: 15px;">
                        <input type="submit" value="Cadastrar" style="background-color: #59bcf5; color: #FFFFFF; font-weight: bold; border-color: #0a5eb8; padding-left: 25px; padding-right: 25px;">
                        <input type="reset" value="Limpar" style="padding-left: 25px; padding-right: 25px;">
                    </td>
                </tr>
            </table>
        </form>

        <?php
        if ((isset($_GET["nome"]))&&(isset($_GET["email"]))){
            //$_GET vai capturar os dados digitados no formulario para usar na query insert
            $nome        =$_GET["nome"];
            $endereco    =$_GET["endereco"];
            $numero      =$_GET["numero"];
            $complemento =$_GET["complemento"];
            $bairro      =$_GET["bairro"];
            $cidade      =$_GET["cidade"];
            $cep         =str_replace("-", "", $_GET["cep"]);
            $uf          =$_GET["uf"];
            $email       =$_GET["email"];
            $cargo       =$_GET["cargo"];
            $departamento=$_GET["departamento"];
            $usuario     =$_GET["usuario"];
            $senha       =$_GET["senha"];

            $host    ="localhost"; //Endereco do Servidor MySQL
            $username="root";      //Usuario administrador do MySQL
            $password="";          //Senha administrador do MySQL (em casa nao tem senha)
            $db_name ="empresa";   //nome da base de dados MySQL
            $con=mysqli_connect("$host", "$username", "$password", "$db_name") or die("cannot connect");  //Cria conexao banco de dados
            if (mysqli_connect_errno()) {                          //testa se a conexao foi estabelecida corretamente
                echo "Falhou ao conectar ao MySQL: " . mysqli_connect_error();
                exit();
            }

            //O id nao e preenchido pois ele e acrescentado automaticamente
            $sql="INSERT INTO `funcionarios`
            (`nome`, `endereco`, `numero`, `complemento`, `bairro`, `cidade`, `cep`, `uf`, `email`, `cargo`, `departamento`, `usuario`, `senha`)
            VALUES ('".$nome."','".$endereco."','".$numero."','".$complemento."','".$bairro."','".$cidade."','".$cep."','".$uf."','".$email."','".$cargo."','".$departamento."','".$usuario."','".$senha."')";

            $result = mysqli_query($con,$sql);    //Roda a query na tabela funcionarios usando a conexao e guarda em $result
            if (!$result) {
                die("Erro na inclusao: " . mysqli_error($con));             //se a query sql estiver incorreta vai parar aqui
            }else{
                mysqli_close($con); //Fecha a conexao com banco de dados
                echo "Funcionário cadastrado com sucesso";
            }
        }
        ?>
    </body>
</html>
