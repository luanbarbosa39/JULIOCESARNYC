class MyHeader extends HTMLElement {
    connectedCallback() {
        this.innerHTML = 
        `
        <head>
<style type="text/css">
               nav {
                  box-shadow: 0 2px 4px 0 rgba(0,0,0,.2);
                }
                .dropdown-menu {
                    background-color: #040404;  
                    color: white;
                    -webkit-transform:scale(1.1); 
                      -moz-transform:scale(1.1); 
                        -o-transform:scale(1.1);
                           transform:scale(1.1);
                           transition: all 100ms;}
                       
                @media screen and (max-width: 700px) {
                         .mainlogo{
                          display:none;
                         }
                .navbar-nav .open .dropdown-menu {
                    width: 100%
                }
            </style>

        <!-- Navigation -->
   
 <nav class="nav navbar">
        <div class="container-fluid">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <!-- navbar-brand is hidden on larger screens, but visible when the menu is collapsed -->
                <a class="navbar-brand" href="index.html">Júlio César NYC</a>
            </div>
            <div class="mainlogo">
                <a class="navbar-brand mainlogo hidden-sm" href="index.html"><img src="img/jclogo.png" style="width: 15%"></a>
            </div>
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1" style="margin:0;padding:0">
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="about_pt.html">SOBRE |</a></li>
                    <li><a href="collection_pt.html">COLEÇÕES |</a></li>
                    <LI><a href="press_pt.html">IMPRENSA |</a></LI>
                    <li><a href="contact_pt.html">CONTATO |</a></li>
                    <li><a href="https://somethingdelightful.com/vogue-patterns/designer-patterns/julio-cesar-nyc/" target="_blank">Vogue Patterns |</a></li>
                    <li class="dropdown" id="nos-encontre">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Nos encontre<span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li><a href="https://www.instagram.com/acasadeantonia/" target="_blank">A Casa de Antonia</a></li>
                            <li><a href="https://www.instagram.com/pinga.store" target="_blank">Pinga Store</a></li>
                            <li><a href="https://www.instagram.com/jete.online/" target="_blank">Jeté</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

<script>
        <script>
        $(document).ready(function () {
            $('#nos-encontre').click(function (e) {
                e.stopPropagation(); // Impede que o clique seja propagado para o documento
                if ($('#nos-encontre').hasClass('open')) {
                    $('#nos-encontre').removeClass('open');
                } else {
                    $('#nos-encontre').addClass('open');
                    $('#change-language').removeClass('open');
                }
            });

            $('#change-language').click(function (e) {
                e.stopPropagation(); // Impede que o clique seja propagado para o documento
                if ($('#change-language').hasClass('open')) {
                    $('#change-language').removeClass('open');
                } else {
                    $('#change-language').addClass('open');
                    $('#nos-encontre').removeClass('open');
                }
            });

            $(document).click(function () {
                $('#nos-encontre').removeClass('open');
                $('#change-language').removeClass('open');
            });
        });
    </script>
    </script>

   </head>
    `
    }
}
customElements.define('my-header', MyHeader)


class MyFooter extends HTMLElement {
    connectedCallback() {
        this.innerHTML = 
        `
        <footer class="rodape">
        <div class="container" style="">
            <div class="row" style="padding-bottom: 2%;">
                <div class="col-lg-12 text-center">
                    <p>Copyright &copy; Julio Cesar NYC 2024</p>
                        <a href="https://www.facebook.com/juliocesaraltacostura" target="_blank" class="fa-brands fa-facebook"></a>
                        <a href="https://instagram.com/julio.cesar.nyc" target="_blank" class="fa-brands fa-instagram"></a>
                        <a href="https://www.tiktok.com/@julio.cesar.nyc?is_from_webapp=1&sender_device=pc" target="_blank" class="fa-brands fa-tiktok"></a>
                        <a href="https://www.youtube.com/@juliocesarnyc6235/" target="_blank" class="fa-brands fa-youtube"></a>
                        <a href="https://br.pinterest.com/JulioCNYC/" target="_blank" class="fa-brands fa-pinterest"></a>
                </div>
                <div class="col-lg-12 text-center">
                        <button class="btn btn-primary btn-sm" id="btn-translate" onclick="translatePage()">Portugues</button>
                        <button class="btn btn-primary btn-sm" id="btn-original" onclick="loadOriginal()">English</button>  
                </div>
            </div>
        </div>            
                             <style type="text/css">
                                .img-responsive_img-full{
                                    width: 100%
                                }
                                .fa-brands {
                                padding: 20px;
                                font-size: 30px;
                                width: 30px;
                                text-align: center;
                                text-decoration: none;
                                border-radius: 50%;
                            }
                                .fa-brands:hover {
                                    opacity: 0.8;
                                    transition: 0.3s
                                }
                                .rodape {
                                    background-color: #1c1c1b;
                                }

                            </style>
<script type="text/javascript">
  function translatePage() {
  }
        </footer>
        
    `
    }
}
customElements.define('my-footer', MyFooter)


function translatePage() {
  var currentUrl = window.location.href;
  var currentFile = currentUrl.substring(currentUrl.lastIndexOf('/') + 1);
  var newUrl = currentFile.replace(".html", "_pt.html");
  
  // Verificar se a função deve ser ativada ou não
  var shouldTranslate = false; // Altere esta variável conforme necessário
  
  if (shouldTranslate) {
    // Redirecionar para a nova URL
    window.location.href = newUrl;
  }
}
function loadOriginal() {
  var currentUrl = window.location.href;
  var currentFile = currentUrl.substring(currentUrl.lastIndexOf('/') + 1);
  var newUrl = currentFile.replace("_pt.html", ".html");
  window.location.href = newUrl;
}