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
}