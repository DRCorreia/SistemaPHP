<?php
include_once 'C:\xampp\htdocs\tcc\envia_mail.php';
include_once 'C:\xampp\htdocs\tcc\database\conexao.php';

?>
<?php
if ( $_SERVER['REQUEST_METHOD'] == 'POST' ) {
    if(isset($_POST['btnEnviar'])){
        $bd= new BD();
        $conn = $bd->getConnection();
        $login = $_POST["login"];
        $sql = "SELECT * from funcionario WHERE email = :email";
        $query = $conn->prepare($sql);
        $query->bindParam(":email", $login);
        $query->execute();
        $total = $query->rowCount();
        if($total){
            $email = new Email();
            $email->esqueceuSenha($login);
        }
        else{
            echo "<script>
		    window.alert('Insira um email válido');
		    window.location.href = 'http://localhost/tcc/esqueceu.php';
		    </script>";
		    exit;
        }
    }
    if(isset($_POST['btnVoltar'])){
        echo "<script>
        window.location.href = 'http://localhost/tcc/login.php';
        </script>";
        exit;
    }
}
?>
<!DOCTYPE html>
<head>
    <meta charset="UTF-8">
    <title>Esqueceu a senha</title>
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <link href="./css/esqueceu.css" rel="stylesheet">
</head>
<body>
<web-particles id="tsparticles" options='{"fps_limit":60,"interactivity":{"detectsOn":"canvas","events":{"onClick":{"enable":true,"mode":"push"},"onHover":{"enable":true,"mode":"repulse"},"resize":true},"modes":{"push":{"particles_nb":4},"repulse":{"distance":200,"duration":0.4}}},"particles":{"color":{"value":"#ffffff"},"links":{"color":"#ffffff","distance":150,"enable":true,"opacity":0.4,"width":1},"move":{"bounce":false,"direction":"none","enable":true,"outMode":"out","random":false,"speed":2,"straight":false},"number":{"density":{"enable":true,"area":800},"value":80},"opacity":{"value":0.5},"shape":{"type":"circle"},"size":{"random":true,"value":5}},"detectRetina":true}'></web-particles>
<script src="https://cdn.jsdelivr.net/npm/tsparticles@1.28.0/dist/tsparticles.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@webcomponents/webcomponentsjs@2.5.0/custom-elements-es5-adapter.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@webcomponents/webcomponentsjs@2.5.0/webcomponents-loader.js"></script>
<script type="module" src="https://cdn.jsdelivr.net/npm/web-particles@1.1.0/dist/web-particles.min.js"></script>
<script async="" defer="" src="https://buttons.github.io/buttons.js"></script>
<div id="login">
    <h3 class="text-center text-white pt-5">Esqueceu a senha</h3>
    <div class="container">
        <div id="login-row" class="row justify-content-center align-items-center">
            <div id="login-column" class="col-md-6">
                <div class="login-box col-md-12">
                    <form id="login-form" class="form" method="POST" action=<?php echo $_SERVER["PHP_SELF"];?>>
                        <h3 class="text-center text-info" color="#fffafa"><font color="#fffafa">Entrar em contato com o suporte</font></h3>
                        <div class="form-group"><br>
                            <label for="username" class="text-info"><font color="#fffafa">Login:</font></label><br>
                            <input type="text" name="login" id="username" class="form-control" placeholder="Digite seu usuário...">
                        </div>
                        <table>
                            <tr>
                                <td>
                                    <div class="form-group">
                                        <input type="submit" style="background-color:#4169E1; border-color:#4169E1; margin-right:235px;" name="btnEnviar" class="btn btn-info btn-md" value="Enviar">
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group">
                                        <input type="submit" style="background-color:#4169E1; border-color:#4169E1 " name="btnVoltar" class="btn btn-info btn-md" value="Voltar">
		                            </div>
                                </td>
                            </tr>
                        </table>    
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
