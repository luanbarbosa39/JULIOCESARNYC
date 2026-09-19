class MyHeader extends HTMLElement {
    connectedCallback() {
        this.innerHTML = `
        <nav class="navbar navbar-dark">
            <div class="container-fluid flex-column p-0">
                <!-- Logo row - desktop only -->
                <div class="logo-row d-none d-lg-flex w-100 justify-content-center py-3">
                    <a href="index.html"><img src="img/jclogo.png" class="nav-logo" alt="Júlio César NYC"></a>
                </div>
                <!-- Nav links row - desktop -->
                <div class="nav-row d-none d-lg-flex w-100 justify-content-center border-top border-bottom" style="border-color: #2a2a2a !important;">
                    <ul class="navbar-nav flex-row">
                        <li class="nav-item"><a class="nav-link" href="about.html">ABOUT</a></li>
                        <li class="nav-item"><a class="nav-link" href="collection.html">COLLECTIONS</a></li>
                        <li class="nav-item"><a class="nav-link" href="press.html">PRESS</a></li>
                        <li class="nav-item"><a class="nav-link" href="contact.html">CONTACT</a></li>
                        <li class="nav-item"><a class="nav-link text-nowrap" href="https://somethingdelightful.com/vogue-patterns/designer-patterns/julio-cesar-nyc/" target="_blank">VOGUE PATTERNS</a></li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">FIND US</a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="https://www.instagram.com/acasadeantonia/" target="_blank">A Casa de Antonia</a></li>
                                <li><a class="dropdown-item" href="https://www.instagram.com/pinga.store" target="_blank">Pinga Store</a></li>
                                <li><a class="dropdown-item" href="https://www.instagram.com/jete.online/" target="_blank">Jeté</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
                <!-- Mobile top bar -->
                <div class="d-lg-none d-flex w-100 align-items-center justify-content-between px-3 py-2">
                    <a class="navbar-brand mb-0" href="index.html">Júlio César NYC</a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#mobileMenu" aria-controls="mobileMenu" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                </div>
            </div>
        </nav>

        <!-- Mobile Offcanvas Menu -->
        <div class="offcanvas offcanvas-end" tabindex="-1" id="mobileMenu" aria-labelledby="mobileMenuLabel">
            <div class="offcanvas-header">
                <h5 class="offcanvas-title" id="mobileMenuLabel">Júlio César NYC</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body">
                <ul class="navbar-nav">
                    <li class="nav-item"><a class="nav-link" href="index.html">HOME</a></li>
                    <li class="nav-item"><a class="nav-link" href="about.html">ABOUT</a></li>
                    <li class="nav-item"><a class="nav-link" href="collection.html">COLLECTIONS</a></li>
                    <li class="nav-item"><a class="nav-link" href="press.html">PRESS</a></li>
                    <li class="nav-item"><a class="nav-link" href="contact.html">CONTACT</a></li>
                    <li class="nav-item"><a class="nav-link" href="https://somethingdelightful.com/vogue-patterns/designer-patterns/julio-cesar-nyc/" target="_blank">VOGUE PATTERNS</a></li>
                    <li class="nav-item mt-3"><span class="nav-link text-muted small">FIND US</span></li>
                    <li class="nav-item"><a class="nav-link ps-4" href="https://www.instagram.com/acasadeantonia/" target="_blank">A Casa de Antonia</a></li>
                    <li class="nav-item"><a class="nav-link ps-4" href="https://www.instagram.com/pinga.store" target="_blank">Pinga Store</a></li>
                    <li class="nav-item"><a class="nav-link ps-4" href="https://www.instagram.com/jete.online/" target="_blank">Jeté</a></li>
                </ul>
                <div class="mt-4 text-center mobile-social">
                    <a href="https://www.facebook.com/juliocesaraltacostura" target="_blank" class="fa-brands fa-facebook" title="Facebook"></a>
                    <a href="https://instagram.com/julio.cesar.nyc" target="_blank" class="fa-brands fa-instagram" title="Instagram"></a>
                    <a href="https://www.tiktok.com/@julio.cesar.nyc?is_from_webapp=1&sender_device=pc" target="_blank" class="fa-brands fa-tiktok" title="TikTok"></a>
                </div>
            </div>
        </div>
        `;
    }
}
customElements.define('my-header', MyHeader)


class MyFooter extends HTMLElement {
    connectedCallback() {
        this.innerHTML = `
        <footer class="rodape">
        <div class="container">
            <div class="row" style="padding-bottom: 2%;">
                <div class="col-lg-12 text-center">
                        <a href="https://www.facebook.com/juliocesaraltacostura" target="_blank" class="fa-brands fa-facebook" title="Facebook"></a>
                        <a href="https://instagram.com/julio.cesar.nyc" target="_blank" class="fa-brands fa-instagram" title="Instagram"></a>
                        <a href="https://www.tiktok.com/@julio.cesar.nyc?is_from_webapp=1&sender_device=pc" target="_blank" class="fa-brands fa-tiktok" title="TikTok"></a>
                        <a href="https://www.youtube.com/@juliocesarnyc6235/" target="_blank" class="fa-brands fa-youtube" title="YouTube"></a>
                        <a href="https://br.pinterest.com/JulioCNYC/" target="_blank" class="fa-brands fa-pinterest" title="Pinterest"></a>
                </div>
                <div class="col-lg-12 text-center">
                        <button class="btn btn-primary btn-sm" id="btn-translate" onclick="translatePage()">Português</button>
                        <button class="btn btn-primary btn-sm" id="btn-original" onclick="loadOriginal()">English</button>
                        <p>Copyright &copy; Julio Cesar NYC 2025</p>
                </div>
            </div>
        </div>
        </footer>
        `;
    }
}
customElements.define('my-footer', MyFooter)


function translatePage() {
  var currentUrl = window.location.href;
  var currentFile = currentUrl.substring(currentUrl.lastIndexOf('/') + 1);
  var newUrl = currentFile.replace(".html", "_pt.html");
  var shouldTranslate = true;
  if (shouldTranslate) {
    window.location.href = newUrl;
  }
}
function loadOriginal() {
  var currentUrl = window.location.href;
  var currentFile = currentUrl.substring(currentUrl.lastIndexOf('/') + 1);
  var newUrl = currentFile.replace("_pt.html", ".html");
  window.location.href = newUrl;
}
