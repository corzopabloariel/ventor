const BODY = {
    header : {
        ATRIBUTOS: {
            image:  {
                        TIPO:"TP_IMG",
                        WIDTH: "257px",
                        HEIGHT: "65px",
                        DEFAULT: 1,
                        TIME: 1
                    },
            nav:    {
                        TIPO:"TP_NAV",
                        ELEMENT: {empresa: "Empresa", productos: "Productos", descargas: "Descargas", atencion: "Atención al Cliente", calidad: "Calidad", trabaje: "Trabaje con nosotros", contacto: "Contacto"},
                        ACTIVE: "active",
                        SUB: {
                            atencion: {
                                transmision: "Análisis de transmisión",
                                pagos: "Información sobre pagos",
                                consulta: "Consulta general"
                            }
                        }
                    },
            BUSCADOR: {
                TIPO:"TP_SEARCH",
                FORMAT: [
                    `<form class="position-relative d-flex" action="/ACTION/" method="post">`,
                        `<button type="submit" class="btn"><i class="fas fa-search"></i></button>`,
                        `<input placeholder="/PLACEHOLDER/" type="text" name="/NAME/" class="form-control form-control-sm"/>`,
                    `</form>`
                ]
            },
            REDES: {
                TIPO:"TP_SOCIAL"
            }
        },
        HTML : [
            `<nav class="navbar navbar-expand-lg pb-0 navbar-light">`,
                `<div class="container">`,
                    `<a class="navbar-brand position-absolute" href="URLBASE">`,
                        `/image/`,
                    `</a>`,
                    `<div class="row justify-content-end flex-column w-100">`,
                        `<ul class="list-unstyled d-flex justify-content-end pt-2 mb-1 align-items-center info">`,
                            //`<li class="logo"><a class="" href="URLBASE">/image/</a></li>`,
                            `<li class="border-left-0 btnMenuModal"><button class="navbar-toggler btn btn-light rounded-0" type="button" data-toggle="modal" data-target="#menuNav"><i class="fas fa-bars"></i></button></li>`,
                            `<li class="zonaCliente"><a href="#"><i class="fas fa-user-circle mr-2"></i>Zona de clientes</a>`,
                                `<ul class="submenu list-unstyled shadow-sm rounded" id="login">`,
                                    `<li><div></div></li>`,
                                    //`<li class="border-top text-center"><a href="URLBASE/registro" class="text-center d-inline-block text-uppercase" style="color:#009AD6;"><small>crear una nueva cuenta</small></a></li>`,
                                `</ul>`,
                            `</li>`,
                            `<li class="buscador hidden-tablet">/BUSCADOR/</li>`,
                            `<li class="redes">/REDES/</li>`,
                        `</ul>`,
                        `<ul id="ulNavFixed" class="hidden-tablet list-unstyled mb-0 menu d-flex pb-3 justify-content-end align-items-center">`,
                        `/nav/`,
                        `</ul>`,
                    `</div>`,
                `</div>`,
            `</nav>`
        ]
    },
    headerLog: {
        ATRIBUTOS: {
            image:  {
                        TIPO:"TP_IMG",
                        WIDTH: "257px",
                        HEIGHT: "65px",
                        DEFAULT: 1,
                        TIME: 1
                    },
            nav:    {
                        TIPO:"TP_NAV",
                        ELEMENT: {pedido: "Pedido", carrito: "Carrito", descargas: "Descargas"},
                        ACTIVE: "active",
                        NOHIDDEN: 1,
                    },
            BUSCADOR: {
                TIPO:"TP_SEARCH",
                FORMAT: [
                    `<form class="position-relative d-flex" action="/ACTION/" method="post">`,
                        `<button type="submit" class="btn"><i class="fas fa-search"></i></button>`,
                        `<input placeholder="/PLACEHOLDER/" type="text" name="/NAME/" class="form-control form-control-sm"/>`,
                    `</form>`
                ]
            },
            REDES: {
                TIPO:"TP_SOCIAL"
            },
            DATOS: {
                TIPO:"TP_PERSONA"
            }
        },
        HTML : [
            `<nav class="navbar navbar-expand-lg pb-0 navbar-light logueado">`,
                `<div class="container">`,
                    `<a class="navbar-brand position-absolute" href="URLBASE">`,
                        `/image/`,
                    `</a>`,
                    `<div class="row justify-content-end flex-column w-100">`,
                        `<ul class="list-unstyled d-flex justify-content-end pt-2 mb-1 align-items-center info">`,
                            `<li>`,
                                `<span style="color:#0099D6;"><i class="fas fa-user-circle mr-2"></i>Bienvenido, /DATOS/ (<a onclick="limpiar()" href="URLLOGOUT">cerrar sesión</a>)</span>`,
                            `</li>`,
                            `<li class="redes">/REDES/</li>`,
                        `</ul>`,
                        `<ul id="ulNavFixed" class="list-unstyled mb-0 menu d-flex pb-3 justify-content-end align-items-center">`,
                        `/nav/`,
                        `<li class="buscador hidden-tablet border-left" style="padding-left:20px">/BUSCADOR/</li>`,
                        `</ul>`,
                    `</div>`,
                `</div>`,
            `</nav>`
        ]
    },
    footer : {
        ATRIBUTOS: {
            image:  {
                        TIPO:"TP_IMG",
                        WIDTH: "257px",
                        HEIGHT: "65px",
                        CLASS: "mx-auto d-block",
                        DEFAULT: 1,
                        TIME: 1
                    },
            nav:    {
                        TIPO:"TP_NAV",
                        ELEMENT: {"":"Inicio",empresa: "Empresa", productos: "Productos", descargas: "Descargas", calidad: "Calidad", contacto: "Contacto"},
                        ACTIVE: "active",
                        NOHIDDEN: 1,
                    },
            datos:  {
                        TIPO:"TP_DATOS",
                        ELEMENT: {domicilio:'<i class="fas fa-map-marker-alt"></i>',telefono: '<i class="fas fa-phone-volume"></i>',email: '<i class="far fa-envelope"></i>'}
            },
            osole:  {
                        TIPO:"TP_MARCA",
                        URL: "http://osolelaravel.com/",
                        ANIO: 1
                    },
        },
        HTML : [
            `<footer class="d-flex justify-content-center align-items-center">`,
                `<div class="container w-100">`,
                    `<div class="row justify-content-center">`,
                        `<div class="col-12 col-md-3"><h4 class="title text-uppercase">sitemap</h4><ul class="list-unstyled mb-0 sitemap">/nav/</ul></div>`,
                        `<div class="col-12 col-md-6 d-flex justify-content-center align-items-center">/image/</div>`,
                        `<div class="col-12 col-md-3 info"><h4 class="title text-uppercase">ventor</h4>/datos/</div>`,
                    `</div>`,
                    `<div class="row justify-content-center marca border-top">`,
                        `<div class="col-12">/osole/</div>`,
                    `</div>`,
                `</div>`,
            `</footer>`
        ]
    }
}