<?php
include_once 'C:\xampp\htdocs\tcc\model\usuario.php';
include_once 'C:\xampp\htdocs\tcc\model\movimento.php';
include_once 'C:\xampp\htdocs\tcc\model\prontuario.php';
include_once 'C:\xampp\htdocs\tcc\model\funcionario.php';
include_once 'C:\xampp\htdocs\tcc\dao\daousuario.php';
include_once 'C:\xampp\htdocs\tcc\controller\usuariocontroller.php';
include_once 'C:\xampp\htdocs\tcc\controller\movimentocontroller.php';
include_once 'C:\xampp\htdocs\tcc\controller\prontuariocontroller.php';

if(!session_start()){
session_start();
}
// Checa se tá logado
if((!isset($_SESSION['login'])) or (!isset($_SESSION['cd_usuario'])) or (!isset($_SESSION['permissao'])) or ($_SESSION["permissao"] != "2"))
{
	header('location:logout.php');
}
?>
<!DOCTYPE html>
<head>
    <meta charset="UTF-8">
    <title>Home</title>
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <link href="./css/home.css" rel="stylesheet">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
</head>
<body>
    <form class="main-container" method="POST" action=<?php echo $_SERVER["PHP_SELF"];?>><br>
		<div class="button-container">
		<button class="btn btn-success" style="margin-top: 0px; margin-left: 900px; margin-right: 15px; " type="submit" name="btnLogout">Sair</button>
		</div>
		</form>
<?php
	if($_SERVER['REQUEST_METHOD'] == 'POST'){
        if(isset($_POST['btnSolicitar'])){
        $movimento = new Movimento();
        $prontuario = new Prontuario();

        $prontuario->setNr_cpf($_POST['nr_cpf']);
        $movimento->setMotivo($_POST['motivo']);
        if(!$movimento->getMotivo() || !$prontuario->getNr_cpf())
		{
           echo "<script>
           window.alert('Você deve preencher todos os campos');
           window.location.href = 'http://localhost/tcc/home.php';
           </script>";
           exit;
		}
        
        $movimentocontroller = new MovimentoController();
        $movimentocontroller->inserirMovimento($movimento, $prontuario);
        }

        else if(isset($_POST['btnDevolver'])){
            $_POST['sim'] = ( isset($_POST['sim']) ) ? true : null;
            $_POST['nao']  = ( isset($_POST['nao']) )  ? true : null;
            $prontuario = new Prontuario();
            $prontuario->setCd_prontuario($_POST['cd_prontuario']);
            if($_POST['sim'] == NULL && $_POST['nao'] == NULL){
                echo "<script>
                window.alert('Você deve informar se o prontuário sofreu alguma alteração!');
                window.location.href = 'http://localhost/tcc/home.php';
                </script>";
                exit;
            }
            if(!($_POST['sim'] == NULL)){
              $trocadata = 1;
            }else $trocadata = 0; 
            if(!$prontuario->getCd_prontuario()){
				        echo "<script>
                window.alert('Você deve preencher o código do prontuário!');
                window.location.href = 'http://localhost/tcc/home.php';
                </script>";
                exit;
            }
            $prontuariocontroller = new ProntuarioController();
            $prontuariocontroller->baixarProntuario($prontuario,$trocadata);
        }
        else if(isset($_POST['btnLogout'])){
					echo "<script>
					window.location.href = 'http://localhost/tcc/login.php';
					</script>";
					$_SESSION["cd_usuario"]= NULL;
		            $_SESSION["cd_funcionario"] = NULL;
		            $_SESSION["login"]= NULL;
                    $_SESSION["senha"] = NULL;
                    $_SESSION["permissao"] = NULL;
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
	<!-- Used some part of the code from Chris Wright (https://codepen.io/chriswrightdesign/) in Home.php
       Used some part of the code from Matteo Bruni (https://codepen.io/matteobruni/pen/ZEeqGOq) in Login.php and Esqueceu.php-->
<div class="container">
  <h1 class="heading-primary">Área do Usuário </h1>
  <div class="accordion">
    <dl>
      <!-- description list -->

      <dt>
          <!-- accordion tab 1 - Delivery and Pickup Options -->
          <a href="#accordion1" aria-expanded="false" aria-controls="accordion1" class="accordion-title accordionTitle js-accordionTrigger">Solicitar um prontuário</a>
        </dt>
        <dd class="accordion-content accordionItem is-collapsed" id="accordion2" aria-hidden="true">
        <div class="container-fluid" style="padding-top: 20px;">
          <p class="headings">Dados para efetuar solicitação</p>
          <form class="main-container" method="POST" action=<?php echo $_SERVER["PHP_SELF"];?>>
            <div class="row">
              <div class="col-xs-4">
                <label for="fullname" class="label-style">CPF do paciente</label>
              </div>
              <div class="form-group col-lg-4">
                <input type="text" id="fullname" class="form-control" name="nr_cpf" placeholder="Digite o número do CPF">
              </div>
              <div class="hint">
                <i class="hint-icon">i</i>
                <p class="hint-description">Número do CPF vinculado ao prontuário</p>
              </div>
            </div>


            <div class="row">
              <div class="col-xs-4">
                <label for="companyname" class="label-style">Motivo da Solicitação</label>
              </div>
              <div class="form-group col-lg-4">
                <input type="text" id="companyname" class="form-control" name="motivo" placeholder="Motivo da solicitação">
              </div>
              <div class="hint">
                <i class="hint-icon">i</i>
                <p class="hint-description">Descreva o motivo da solicitação</p>
              </div>
            </div>
            <div class="button-container">
              <button class="btn btn-success" type="submit" name="btnSolicitar">Solicitar</button>
            </div>
        </div>
    </dd>
      <!--end accordion tab 1 -->

      <dt>
          <!-- accordion tab 2 - Shipping Info -->
          <a href="#accordion2" aria-expanded="false" aria-controls="accordion2" class="accordion-title accordionTitle js-accordionTrigger">Dar Baixa em um Prontuário</a>
        </dt>
      <dd class="accordion-content accordionItem is-collapsed" id="accordion2" aria-hidden="true">
        <div class="container-fluid" style="padding-top: 20px;">
          <p class="headings">Dados do Prontuário</p>
          <form class="main-container"  method="POST" action=<?php echo $_SERVER["PHP_SELF"];?>>
            <div class="row">
              <div class="col-xs-4">
                <label for="fullname" class="label-style">Código do Prontuário</label>
              </div>
              <div class="form-group col-lg-4">
                <input type="text" id="fullname" class="form-control" name="cd_prontuario" placeholder="Digite o código do prontuário">
              </div>
              <div class="hint">
                <i class="hint-icon">i</i>
                <p class="hint-description">Digite o código do prontuário</p>
              </div>
              <div class="col-xs-4">
                 <label for="fullname" class="label-style">Alguma alteração foi feita no prontuário?</label>
              </div>
            <div class="form-group">
            <input type="checkbox" class="form-control" name="sim" value="on">Sim
            <input type="checkbox" class="form-control" name="nao" value="on">Não
            </div>
            </div>
        </div>
        <div class="button-container">
              <button class="btn btn-success" type="submit" name="btnDevolver">Devolver</button>
              </form>
            </div>
      </dd>
      <!-- end accordion tab 2 -->

      <dt>
          <!-- accordion tab 3 - Payment Info -->
      <a href="#accordion3" aria-expanded="false" aria-controls="accordion3" class="accordion-title accordionTitle js-accordionTrigger">Listar Prontuários</a>
      </dt>
      <dd class="accordion-content accordionItem is-collapsed" id="accordion3" aria-hidden="true">
      <div class="button-container"><br>
      
      <?php
       $email = $_SESSION["login"];
       $bd = new BD();
       $conn = $bd->getConnection();
       $sql = 'SELECT cd_funcionario from funcionario where email= :email';  
       $query = $conn->prepare($sql);
       $query->bindParam(":email" , $email);
       $query->execute();
       $cd_funcionario = $query->fetch(PDO::FETCH_ASSOC);
       $sql = 'SELECT * from movimentos where situacao = "A" and cd_funcionario_origem = :cd_funcionario';  
       $query = $conn->prepare($sql);
       $query->bindParam(":cd_funcionario" , $cd_funcionario["cd_funcionario"]);
       $query->execute();
       echo"<table>
	     <tr>
	     <th>Os prontuários sob sua responsabilidade são:</th>
	     </tr>";
       while($dados= $query->fetch(PDO::FETCH_ASSOC)){
           $cd_prontuario = $dados["cd_prontuario"];
           echo "<tr><td>$cd_prontuario</td></tr>";
           }echo"</table>";
      ?>
            </div>
      </dd>
      <!-- end accordion tab 3 -->

    </dl>
    <!-- end description list -->
  </div>
  <!-- end accordion -->
</div>
<!-- end container -->
<script>
//uses classList, setAttribute, and querySelectorAll
//if you want this to work in IE8/9 youll need to polyfill these
(function() {
  var d = document,
    accordionToggles = d.querySelectorAll('.js-accordionTrigger'),
    setAria,
    setAccordionAria,
    switchAccordion,
    touchSupported = ('ontouchstart' in window),
    pointerSupported = ('pointerdown' in window);

  skipClickDelay = function(e) {
    e.preventDefault();
    e.target.click();
  }

  setAriaAttr = function(el, ariaType, newProperty) {
    el.setAttribute(ariaType, newProperty);
  };
  setAccordionAria = function(el1, el2, expanded) {
    switch (expanded) {
      case "true":
        setAriaAttr(el1, 'aria-expanded', 'true');
        setAriaAttr(el2, 'aria-hidden', 'false');
        break;
      case "false":
        setAriaAttr(el1, 'aria-expanded', 'false');
        setAriaAttr(el2, 'aria-hidden', 'true');
        break;
      default:
        break;
    }
  };
  //function
  switchAccordion = function(e) {
    e.preventDefault();
    var thisAnswer = e.target.parentNode.nextElementSibling;
    var thisQuestion = e.target;
    if (thisAnswer.classList.contains('is-collapsed')) {
      setAccordionAria(thisQuestion, thisAnswer, 'true');
    } else {
      setAccordionAria(thisQuestion, thisAnswer, 'false');
    }
    thisQuestion.classList.toggle('is-collapsed');
    thisQuestion.classList.toggle('is-expanded');
    thisAnswer.classList.toggle('is-collapsed');
    thisAnswer.classList.toggle('is-expanded');

    thisAnswer.classList.toggle('animateIn');
  };
  for (var i = 0, len = accordionToggles.length; i < len; i++) {
    if (touchSupported) {
      accordionToggles[i].addEventListener('touchstart', skipClickDelay, false);
    }
    if (pointerSupported) {
      accordionToggles[i].addEventListener('pointerdown', skipClickDelay, false);
    }
    accordionToggles[i].addEventListener('click', switchAccordion, false);
  }
})();
</script>
</body>
</html>