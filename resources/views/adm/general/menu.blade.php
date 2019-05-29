<div class="sidebar-header">
    <i class="fas fa-bars"></i>
    <h3 class="m-0">Menu</h3>
</div>
<div class="position-relative" style="height: calc(100% - 73px); overflow-y:auto; overflow-x: hidden;">
    <div class="w-100 position-absolute">
        @if(Auth::user()["is_admin"] == 2)
        <ul class="list-unstyled components m-0 p-0">
            <li>
                <a data-link="a" href="{{ route('clientes.index') }}">
                    <i class="fas fa-id-card-alt"></i>
                    <span class="nav-label">Clientes</span>
                </a>
            </li>
            <li>
                <a data-link="a" href="{{ route('pedido.index') }}">
                    <i class="fas fa-cash-register"></i>
                    <span class="nav-label">Pedidos</span>
                </a>
            </li>
            <li>
                <a data-link="a" href="{{ route('empresa.usuarios.datos') }}">
                    <i class="fas fa-user-cog"></i>
                    <span class="nav-label">Mis datos</span>
                </a>
            </li>
            <li><hr/></li>
            <li>
                <a class="bg-danger text-white" href="{{ route('adm.logout') }}">
                    <i class="fas fa-power-off text-white"></i>
                    <span class="nav-label">Salir</span>
                </a>
            </li>
        </ul>
        @else
        <ul class="list-unstyled components m-0 p-0">
            <li class="">
                <a href="#homeSubmenu" data-toggle="collapse" aria-expanded="false">
                    <i class="fas fa-home"></i>
                    <span class="nav-label">Home</span>
                </a>
                <ul class="collapse list-unstyled" id="homeSubmenu">
                    <li>
                        <a data-link="u" href="{{ route('slider.index', ['seccion' => 'home']) }}">
                            <i class="fas fa-spider"></i>
                            <span class="nav-label">Slider</span>
                        </a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="#empresaSubmenu" data-toggle="collapse" aria-expanded="false">
                    <i class="fas fa-building"></i>
                    <span class="nav-label">Empresa</span>
                </a>
                <ul class="collapse list-unstyled" id="empresaSubmenu">
                    <li>
                        <a data-link="u" href="{{ route('contenido.edit', ['seccion' => 'empresa']) }}">
                            <i class="fas fa-file-contract"></i>
                            <span class="nav-label">Contenido</span>
                        </a>
                    </li>
                    <li>
                        <a data-link="u" href="{{ route('slider.index', ['seccion' => 'empresa']) }}">
                            <i class="fas fa-spider"></i>
                            <span class="nav-label">Slider</span>
                        </a>
                    </li>
                </ul>
            </li>
            <li>
                <a data-link="a" href="{{ route('transporte.index') }}">
                    <i class="fas fa-truck-loading"></i>
                    <span class="nav-label">Transportes</span>
                </a>
            </li>
            <li>
                <a data-link="a" href="{{ route('vendedor.index') }}">
                    <i class="fas fa-portrait"></i>
                    <span class="nav-label">Vendedores</span>
                </a>
            </li>
            <li>
                <a href="#productoSubmenu" data-toggle="collapse" aria-expanded="false">
                    <i class="fas fa-industry"></i>
                    <span class="nav-label">Productos</span>
                </a>
                <ul class="collapse list-unstyled" id="productoSubmenu">
                    <li>
                        <a data-link="u" href="{{ route('categorias.index') }}">
                            <i class="fas fa-columns"></i>
                            <span class="nav-label">Categorías de productos (zona pública)</span>
                        </a>
                    </li>
                    <li>
                        <a data-link="u" href="{{ route('familias.index') }}">
                            <i class="fas fa-tasks"></i>
                            <span class="nav-label">Familia de productos</span>
                        </a>
                    </li>
                    <li>
                        <a data-link="u" href="{{ route('partes.index') }}">
                            <i class="fab fa-modx"></i>
                            <span class="nav-label">Partes de productos</span>
                        </a>
                    </li>
                    <li>
                        <a data-link="u" href="{{ route('marcas.index') }}">
                            <i class="fas fa-registered"></i>
                            <span class="nav-label">Marcas y modelos</span>
                        </a>
                    </li>
                    <li>
                        <a data-link="u" href="{{ route('productosIndex') }}">
                            <i class="fas fa-clipboard-list"></i>
                            <span class="nav-label">Todos los productos</span>
                        </a>
                    </li>
                    
                    @if(Auth::user()["username"] == "EMP_12661482" || Auth::user()["username"] == "pablo")
                    <li>
                        <a data-link="u" href="{{ route('productos.carga') }}">
                        <i class="fas fa-file-upload"></i>
                            <span class="nav-label">Carga masiva</span>
                        </a>
                    </li>
                    @endif
                </ul>
            </li>
            <li>
                <a href="#descargaSubmenu" data-toggle="collapse" aria-expanded="false">
                    <i class="fas fa-download"></i>
                    <span class="nav-label">Descargas</span>
                </a>
                <ul class="collapse list-unstyled" id="descargaSubmenu">
                    <li>
                        <a data-link="u" href="{{ route('descargas.index') }}">
                            <i class="fas fa-lock-open"></i>
                            <span class="nav-label">Pública</span>
                        </a>
                    </li>
                    <li>
                        <a data-link="u" href="{{ route('descargas.private') }}">
                            <i class="fas fa-lock"></i>
                            <span class="nav-label">Privada</span>
                        </a>
                    </li>
                </ul>
            </li>
            <li>
                <a data-link="a" href="{{ route('contenido.edit', ['seccion' => 'calidad']) }}">
                    <i class="fas fa-quidditch"></i>
                    <span class="nav-label">Calidad</span>
                </a>
            </li>
            <li>
                <a data-link="a" href="{{ route('recursos.index') }}">
                    <i class="fas fa-walking"></i>
                    <span class="nav-label">Recursos humanos</span>
                </a>
            </li>
            <li><hr/></li>
            <li>
                <a data-link="a" href="{{ route('pedido.index') }}">
                    <i class="fas fa-cash-register"></i>
                    <span class="nav-label">Pedidos</span>
                </a>
            </li>
            <li>
                <a data-link="a" href="{{ route('clientes.index') }}">
                    <i class="fas fa-id-card-alt"></i>
                    <span class="nav-label">Clientes</span>
                </a>
            </li>
            <li><hr/></li>
            <li>
                <a href="#pageSubmenu" data-toggle="collapse" aria-expanded="false">
                    <i class="fas fa-compass"></i>
                    <span class="nav-label">VENTOR</span>
                </a>
                <ul class="collapse list-unstyled" id="pageSubmenu">
                    <li>
                        <a data-link="u" href="{{ route('empresa.datos') }}">
                            <span>Datos</span>
                        </a>
                    </li>
                    <li>
                        <a data-link="u" href="{{ route('empresa.redes.index') }}">
                            <i class="fas fa-comment"></i>
                            <span class="nav-label">Redes sociales</span>
                        </a>
                    </li>
                    <li>
                        <a data-link="u" href="{{ route('empresa.metadatos.index') }}">
                            <i class="fas fa-bullhorn"></i>
                            <span class="nav-label">Metadatos</span>
                        </a>
                    </li>
                    <li>
                        <a data-link="u" href="{{ route('empresa.numeros') }}">
                            <i class="fas fa-phone-square"></i>
                            <span class="nav-label">Números</span>
                        </a>
                    </li>
                </ul>
            </li>
            <li>
                <a data-link="a" href="{{ route('contenido.edit', ['seccion' => 'terminos']) }}">
                    <i class="fas fa-clipboard-check"></i>
                    <span class="nav-label">Términos y condiciones</span>
                </a>
            </li>
            @if(Auth::user()["is_admin"])
            <li>
                <a data-link="a" href="{{ route('empresa.usuarios.index') }}">
                    <i class="fas fa-users"></i>
                    <span class="nav-label">Usuarios</span>
                </a>
            </li>
            @endif
            <li>
                <a data-link="a" href="{{ route('empresa.usuarios.datos') }}">
                    <i class="fas fa-user-cog"></i>
                    <span class="nav-label">Mis datos</span>
                </a>
            </li>
            <li><hr/></li>
            <li>
                <a href="https://osole.freshdesk.com/support/home" target="_blank">
                <i class="fas fa-ticket-alt"></i>
                    <span class="nav-label">Soporte</span>
                </a>
            </li>
            <li>
                <a onclick="limpiar(this)" class="bg-danger text-white" href="{{ route('adm.logout') }}">
                    <i class="fas fa-power-off text-white"></i>
                    <span class="nav-label">Salir</span>
                </a>
            </li>
        </ul>
        @endif
    </div>
</div>