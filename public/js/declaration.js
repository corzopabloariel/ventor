const ENTIDADES = {
    slider: {
        ATRIBUTOS: {
            orden: {TIPO:"TP_STRING",MAXLENGTH:3,VISIBILIDAD:"TP_VISIBLE",CLASS:"text-uppercase text-center",WIDTH:"150px"},
            link: {TIPO:"TP_ENUM",ENUM:{productos: "Productos"},MAXLENGTH:100,VISIBILIDAD:"TP_VISIBLE",CLASS:"text-uppercase text-center",WIDTH:"150px",COMUN:1},
            image: {TIPO:"TP_FILE",NECESARIO:1,VALID:"Archivo seleccionado",INVALID:"Seleccione archivo - 1400x479",BROWSER:"Buscar",VISIBILIDAD:"TP_VISIBLE",ACCEPT:"image/*",NOMBRE:"imagen",WIDTH:"250px"},
            seccion: {TIPO:"TP_ENUM",ENUM:{home:"Home",empresa:"Empresa",ofertas:"Ofertas",pagos: "Pagos y envios"},NECESARIO:1,VISIBILIDAD:"TP_VISIBLE_FORM",CLASS:"text-uppercase",NOMBRE:"sección"},
            texto: {TIPO:"TP_TEXT",EDITOR:1,VISIBILIDAD:"TP_VISIBLE",FIELDSET:1,NOMBRE:"texto"}
        },
        JSON: {
            texto: {
                es: "español"
            },
        },
        FORM: [
            {
                orden: '<div class="col-5 col-md-3">/orden/</div>',
                BTN: '<div class="d-flex col-3 col-md-3">/BTN/</div>'
            },
            {
                image: '<div class="col-12 col-md-6">/image/</div>',
            },
            {
                link: '<div class="col-12 col-md-6">/link/</div>',
            },
            {
                texto: '<div class="col-12">/texto/</div>'
            }
        ],
        FUNCIONES: {
            image: {onchange:{F:"readURL(this,'/id/')",C:"id"}}
        }
    },
    empresa: {
        ATRIBUTOS: {
            page: {TIPO:"TP_ENUM",ENUM:{slider:"Slider"},NECESARIO:1,VISIBILIDAD:"TP_VISIBLE_FORM",CLASS:"text-uppercase",NOMBRE:"secciones",MULTIPLE: 1},
            texto: {TIPO:"TP_TEXT",EDITOR:1,VISIBILIDAD:"TP_VISIBLE",FIELDSET:1,NOMBRE:"texto"},
            TIT_vision: {TIPO:"TP_STRING",VISIBILIDAD:"TP_VISIBLE",NOMBRE:"título visión"},
            vision: {TIPO:"TP_TEXT",EDITOR:1,VISIBILIDAD:"TP_VISIBLE",FIELDSET:1,NOMBRE:"visión"},
            TIT_mision: {TIPO:"TP_STRING",VISIBILIDAD:"TP_VISIBLE",NOMBRE:"título misión"},
            mision: {TIPO:"TP_TEXT",EDITOR:1,VISIBILIDAD:"TP_VISIBLE",FIELDSET:1,NOMBRE:"misión"}
        },
        JSON: {
            texto: {
                es: "español"
            },
            vision: {
                es: "español"
            },
            TIT_vision: {
                es: "español"
            },
            mision: {
                es: "español"
            },
            TIT_mision: {
                es: "español"
            },
        },
        FORM: [
            {
                BTN: '<div class="d-flex col-3 col-md-2">/BTN/</div>'
            },
            {
                page: '<div class="col-7 col-md-6">/page/</div>',
            },
            {
                texto: '<div class="col-12">/texto/</div>',
            },
            {
                TIT_vision: '<div class="col-12">/TIT_vision/</div>',
                vision: '<div class="col-12 mt-1">/vision/</div>',
            },
            {
                TIT_mision: '<div class="col-12">/TIT_mision/</div>',
                mision: '<div class="col-12 mt-1">/mision/</div>',
            }
        ]
    },

    empresa_numeros: {
        ATRIBUTOS: {
            numero: {TIPO:"TP_ENTERO",NECESARIO:1,VISIBILIDAD:"TP_VISIBLE",NOMBRE:"número"},
            texto: {TIPO:"TP_STRING",NECESARIO:1,VISIBILIDAD:"TP_VISIBLE"},
        },
        FORM: [
            {
                numero: '<div class="col-12 col-md-4">/numero/</div>',
                texto: '<div class="col-12 col-md-8">/texto/</div>'
            }
        ]
    },
    empresa_anios: {
        ATRIBUTOS: {
            anio: {TIPO:"TP_ENUM",VISIBILIDAD:"TP_VISIBLE",NECESARIO:1,NOMBRE:"año",ENUM: null,COMUN:1},
            texto: {TIPO:"TP_TEXT",EDITOR:1,VISIBILIDAD:"TP_VISIBLE",FIELDSET:1,NOMBRE:"texto"}
        },
        FORM: [
            {
                anio: '<div class="col-12">/anio/</div>',
                texto: '<div class="col-12 mt-1">/texto/</div>'
            }
        ]
    },

    categorias: {
        ATRIBUTOS: {
            orden: {TIPO:"TP_STRING",MAXLENGTH:3,VISIBILIDAD:"TP_VISIBLE",CLASS:"text-uppercase text-center",WIDTH:"100px"},
            image: {TIPO:"TP_FILE",NECESARIO:1,VALID:"Archivo seleccionado",INVALID:"Seleccione archivo - 108x108",BROWSER:"Buscar",VISIBILIDAD:"TP_VISIBLE",ACCEPT:"image/*",NOMBRE:"imagen",WIDTH:"108px"},
            nombre: {TIPO:"TP_STRING",MAXLENGTH: 100,VISIBILIDAD:"TP_VISIBLE"},
            color: {TIPO:"TP_COLOR",VISIBILIDAD:"TP_VISIBLE"},
            hsl: {TIPO:"TP_STRING",VISIBILIDAD:"TP_INVISIBLE"},
            subcategorias: {TIPO:"TP_ENUM",VISIBILIDAD:"TP_VISIBLE_TABLE",NOMBRE:"Subcategorías",CLASS:"text-uppercase text-center"}
        },
        FORM: [
            {
                orden: '<div class="col-5 col-md-3">/orden/</div>',
                BTN: '<div class="d-flex col-3 col-md-3">/BTN/</div>'
            },
            {
                nombre: '<div class="col-12 col-md-6">/nombre/</div>'
            },
            /*{
                padre_id: '<div class="col-12 col-md-6">/padre_id/</div>'
            },*/
            {
                color: '<div class="col-12 col-md-6">/color/</div>',
                hsl: '/hsl/'
            },
            {
                image: '<div class="col-12 col-md-6 col-lg-4">/image/</div>',
            },
        ],
        FUNCIONES: {
            color: {onchange: "changeColor(this,0);"},
            image: {onchange:{F:"readURL(this,'/id/')",C:"id"}}
        }
    },
    subcategorias: {
        ATRIBUTOS: {
            orden: {TIPO:"TP_STRING",MAXLENGTH:3,VISIBILIDAD:"TP_VISIBLE",CLASS:"text-uppercase text-center",WIDTH:"100px"},
            image: {TIPO:"TP_FILE",NECESARIO:1,VALID:"Archivo seleccionado",INVALID:"Seleccione archivo - 240x230",BROWSER:"Buscar",VISIBILIDAD:"TP_VISIBLE",ACCEPT:"image/*",NOMBRE:"imagen",WIDTH:"108px"},
            nombre: {TIPO:"TP_STRING",MAXLENGTH: 100,VISIBILIDAD:"TP_VISIBLE"},
            hsl: {TIPO:"TP_STRING",VISIBILIDAD:"TP_INVISIBLE"},
            //padre_id: {TIPO:"TP_ENUM",VISIBILIDAD:"TP_VISIBLE_TABLE",NOMBRE:"Categoría"}
        },
        FORM: [
            {
                orden: '<div class="col-5 col-md-3">/orden/</div>',
                BTN: '<div class="d-flex col-3 col-md-3">/BTN/</div>'
            },
            {
                nombre: '<div class="col-12 col-md-6">/nombre/</div>'
            },
            {
                image: '<div class="col-12 col-md-6">/image/</div>',
            },
        ],
        FUNCIONES: {
            image: {onchange:{F:"readURL(this,'/id/')",C:"id"}}
        }
    }
}