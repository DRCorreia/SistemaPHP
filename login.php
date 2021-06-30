<?php
include_once 'C:\xampp\htdocs\tcc\model\usuario.php';
include_once 'C:\xampp\htdocs\tcc\dao\daousuario.php';
include_once 'C:\xampp\htdocs\tcc\controller\usuariocontroller.php';


session_start();
?>
<!DOCTYPE html>
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <link href="./css/login.css" rel="stylesheet">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
</head>
<body>
<?php
			if ( $_SERVER['REQUEST_METHOD'] == 'POST' ) {
                if(isset($_POST['btnAcessar'])){
				$usuario = new Usuario();
                echo $_POST['login'];
				$usuario->setLogin($_POST['login']);
				$usuario->setSenha($_POST['senha']);
				if(!$usuario->getLogin() || !$usuario->getSenha())
				{
                    echo "<script>
                    window.alert('Você deve inserir o login e a senha!');
                    window.location.href = 'http://localhost/tcc/login.php';
                    </script>";
                    exit;
				}
				$usuariocontroller = new UsuarioController();		
				$usuariocontroller->validarUsuario($usuario);		
			   }
            }
			if(isset($_SESSION['msg'])){
				echo $_SESSION['msg'];
				unset($_SESSION['msg']);
			}
			if(isset($_SESSION['msgcad'])){
				echo $_SESSION['msgcad'];
				unset($_SESSION['msgcad']);
			}
		?>
    <!-- tsParticles container -->
<web-particles id="tsparticles" options='{"fps_limit":60,"interactivity":{"detectsOn":"canvas","events":{"onClick":{"enable":true,"mode":"push"},"onHover":{"enable":true,"mode":"repulse"},"resize":true},"modes":{"push":{"particles_nb":4},"repulse":{"distance":200,"duration":0.4}}},"particles":{"color":{"value":"#ffffff"},"links":{"color":"#ffffff","distance":150,"enable":true,"opacity":0.4,"width":1},"move":{"bounce":false,"direction":"none","enable":true,"outMode":"out","random":false,"speed":2,"straight":false},"number":{"density":{"enable":true,"area":800},"value":80},"opacity":{"value":0.5},"shape":{"type":"circle"},"size":{"random":true,"value":5}},"detectRetina":true}'></web-particles>
<script src="https://cdn.jsdelivr.net/npm/tsparticles@1.28.0/dist/tsparticles.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@webcomponents/webcomponentsjs@2.5.0/custom-elements-es5-adapter.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@webcomponents/webcomponentsjs@2.5.0/webcomponents-loader.js"></script>
<script type="module" src="https://cdn.jsdelivr.net/npm/web-particles@1.1.0/dist/web-particles.min.js"></script>
<script async="" defer="" src="https://buttons.github.io/buttons.js"></script>
	<div id="login">
    <h3 class="text-center text-white pt-5">Área Restrita</h3>
    <div class="container">
        <div id="login-row" class="row justify-content-center align-items-center">
            <div id="login-column" class="col-md-6">
                <div class="login-box col-md-12">
                    <form id="login-form" class="form" method="POST" action=<?php echo $_SERVER["PHP_SELF"];?>>
                        <h3 class="text-center text-info"><font color="#fffafa">Login</font></h3>
                        <div class="form-group">
                            <label for="username" class="text-info"><font color="#fffafa">Login:</font></label><br>
                            <input type="text" name="login" id="username" class="form-control" placeholder="Digite seu usuário...">
                        </div>
                        <div class="form-group">
                            <label for="password" class="text-info"><font color="#fffafa">Senha:</font></label><br>
                            <input type="password" name="senha" id="password" class="form-control" placeholder="Digite a sua senha...">
                        </div>
                        <div class="form-group">
                            <input type="submit" style="background-color:#4169E1; border-color:#4169E1" name="btnAcessar" class="btn btn-info btn-md" value="Acessar">
                        </div><br><br>
                        <div id="register-link" class="text-right">
                            <a href="http://localhost/tcc/esqueceu.php" class="text-info"><font color="#fffafa"><p>Esqueceu a sua senha? Clique aqui</p></font></a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>