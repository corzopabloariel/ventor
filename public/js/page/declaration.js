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
                    `<a class="navbar-brand position-absolute hidden-tablet" href="URLBASE">`,
                        `/image/`,
                    `</a>`,
                    `<div class="row justify-content-end flex-column w-100">`,
                        `<ul class="list-unstyled d-flex justify-content-end pt-2 mb-1 align-items-center info">`,
                            `<li>`,
                                `<a href="#"><i class="fas fa-user-circle mr-2"></i>Zona de clientes</a>`,
                                `<ul class="submenu list-unstyled shadow-sm rounded" id="login">`,
                                    `<li><div></div></li>`,
                                    `<li class="border-top"><a href="URLBASE/registro" class="text-center text-uppercase d-block">crear una nueva cuenta</a></li>`,
                                `</ul>`,
                            `</li>`,
                            `<li class="buscador">/BUSCADOR/</li>`,
                            `<li class="redes">/REDES/</li>`,
                        `</ul>`,
                        `<ul id="ulNavFixed" class="list-unstyled mb-0 menu d-flex pb-3 justify-content-end align-items-center">`,
                        `/nav/`,
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