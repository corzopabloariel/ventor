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
                        ACTIVE: "active"
                    },
        },
        HTML : [
            `<nav class="navbar navbar-expand-lg pb-0 navbar-light">`,
                `<div class="container border-bottom">`,
                    `<a class="navbar-brand position-absolute hidden-tablet" href="/">`,
                        `/image/`,
                    `</a>`,
                    `<div class="row justify-content-end flex-column w-100">`,
                        `<ul class="list-unstyled d-flex justify-content-end pt-2 mb-1 align-items-center info">`,
                            `<li>/ZONACLIENTE/</li>`,
                            `<li>/BUSCADOR/</li>`,
                            `<li>/REDES/</li>`,
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
                        ELEMENT: {"/":"Inicio",empresa: "Empresa", productos: "Productos", descargas: "Descargas", calidad: "Calidad", contacto: "Contacto"},
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