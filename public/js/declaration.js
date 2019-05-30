const ENTIDADES = {

    clientes: {
        ATRIBUTOS: {
            username: {TIPO:"TP_STRING",VISIBILIDAD:"TP_VISIBLE_TABLE",NOMBRE:"usuario"},
            nombre: {TIPO:"TP_STRING",VISIBILIDAD:"TP_VISIBLE_TABLE",NOMBRE:"nombre",CLASS:"text-uppercase"},
            email: {TIPO:"TP_STRING",VISIBILIDAD:"TP_VISIBLE_TABLE"},
            descuento: {TIPO:"TP_STRING",VISIBILIDAD:"TP_INVISIBLE",NOMBRE:"desc. (%)",CLASS:"text-center"},
        }
    },

    numeros: {
        ATRIBUTOS: {
            orden: {TIPO:"TP_STRING",MAXLENGTH:3,VISIBILIDAD:"TP_VISIBLE",CLASS:"text-uppercase text-center",WIDTH:"150px"},
            provincia: {TIPO:"TP_STRING",MAXLENGTH:150,VISIBILIDAD:"TP_VISIBLE",CLASS:"text-uppercase"},
            nombre: {TIPO:"TP_STRING",MAXLENGTH:50,NECESARIO:1,VISIBILIDAD:"TP_VISIBLE",CLASS:"text-uppercase",NOMBRE:"título"},
            persona: {TIPO:"TP_STRING",MAXLENGTH:150,VISIBILIDAD:"TP_VISIBLE",NOMBRE:"nombre completo"},
            interno: {TIPO:"TP_STRING",MAXLENGTH:50,VISIBILIDAD:"TP_VISIBLE",CLASS:"text-right"},
            email: {TIPO:"TP_JSON",VISIBILIDAD:"TP_VISIBLE",NOMBRE:"Email"}
        },
        FORM: [
            {
                orden: '<div class="col-5 col-md-3">/orden/</div>',
                BTN: '<div class="d-flex col-3 col-md-3">/BTN/</div>'
            },
            {
                provincia: '<div class="col-12 col-md-6">/provincia/</div>',
            },
            {
                nombre: '<div class="col-12 col-md-6">/nombre/</div>',
            },
            {
                persona: '<div class="col-12 col-md-6">/persona/</div>'
            },
            {
                interno: '<div class="col-12 col-md-6">/interno/</div>'
            }
        ],
        FUNCIONES: {
            image: {onchange:{F:"readURL(this,'/id/')",C:"id"}}
        }
    },
    novedades: {
        ATRIBUTOS: {
            orden: {TIPO:"TP_STRING",MAXLENGTH:3,VISIBILIDAD:"TP_VISIBLE",CLASS:"text-uppercase text-center",WIDTH:"150px"},
            nombre: {TIPO:"TP_STRING",MAXLENGTH:150,VISIBILIDAD:"TP_VISIBLE"},
            image: {TIPO:"TP_FILE",NECESARIO:1,VALID:"Archivo seleccionado",INVALID:"Seleccione archivo - 209x297",BROWSER:"Buscar",VISIBILIDAD:"TP_VISIBLE",ACCEPT:"image/*",NOMBRE:"imagen",WIDTH:"190px"},
            documento: {TIPO:"TP_FILE",NECESARIO:1,VALID:"Documento seleccionado",INVALID:"Seleccione documento",BROWSER:"Buscar",VISIBILIDAD:"TP_VISIBLE_FORM",ACCEPT:"image/jpeg,application/pdf",NOMBRE:"documento",WIDTH:"190px",SIMPLE:1},
            url: {TIPO:"TP_STRING",VISIBILIDAD:"TP_VISIBLE_FORM"}
        },
        FORM: [
            {
                orden: '<div class="col-5 col-md-3">/orden/</div>',
                BTN: '<div class="d-flex col-3 col-md-3">/BTN/</div>'
            },
            {
                image: '<div class="col-12 col-md-6">/image/</div>'
            },
            {
                nombre: '<div class="col-12 col-md-6">/nombre/</div>',
            },
            {
                documento: '<div class="col-12 col-md-6">/documento/</div>',
            }
        ],
        FUNCIONES: {
            image: {onchange:{F:"readURL(this,'/id/')",C:"id"}}
        }
    },
    emails: {
        ATRIBUTOS: {
            formulario: {TIPO:"TP_ENUM",ENUM:{ atencion: "Atención al Cliente", pagos: "Información de Pagos", consulta: "Consulta General", trabaje: "Trabaje con nosotros", contacto: "Contacto"},VISIBILIDAD:"TP_VISIBLE",COMUN:1,CLASS:"text-uppercase"},
            email: {TIPO:"TP_ENUM",VISIBILIDAD:"TP_VISIBLE",COMUN:1}
        },
        FORM: [
            {
                BTN: '<div class="d-flex col-3 col-md-3">/BTN/</div>'
            },
            {
                formulario: '<div class="col-12 col-md-6">/formulario/</div>'
            },
            {
                email: '<div class="col-12 col-md-6">/email/</div>',
            }
        ]
    },
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
    descargas: {
        ATRIBUTOS: {
            orden: {TIPO:"TP_STRING",MAXLENGTH:3,VISIBILIDAD:"TP_VISIBLE",CLASS:"text-uppercase text-center",WIDTH:"150px"},
            image: {TIPO:"TP_FILE",NECESARIO:1,VALID:"Archivo seleccionado",INVALID:"Seleccione archivo - 190x190",BROWSER:"Buscar",VISIBILIDAD:"TP_VISIBLE",ACCEPT:"image/*",NOMBRE:"imagen",WIDTH:"190px"},
            documento: {TIPO:"TP_FILE",NECESARIO:1,VALID:"Documento seleccionado",INVALID:"Seleccione documento",BROWSER:"Buscar",VISIBILIDAD:"TP_VISIBLE",ACCEPT:"image/jpeg,application/pdf",NOMBRE:"documento",WIDTH:"190px",SIMPLE:1},
            nombre: {TIPO:"TP_STRING",MAXLENGTH:50,VISIBILIDAD:"TP_VISIBLE"}
        },
        FORM: [
            {
                orden: '<div class="col-5 col-md-3">/orden/</div>',
                BTN: '<div class="d-flex col-3 col-md-3">/BTN/</div>'
            },
            {
                image: '<div class="col-12 col-md-6 col-lg-3">/image/</div>',
            },
            {
                documento: '<div class="col-12 col-md-6">/documento/</div>',
            },
            {
                nombre: '<div class="col-12 col-md-6">/nombre/</div>'
            }
        ],
        FUNCIONES: {
            image: {onchange:{F:"readURL(this,'/id/')",C:"id"}},
            documento: {onchange:{F:"readURL(this,'/id/')",C:"id"}}
        }
    },
    descargasprecio: {
        ATRIBUTOS: {
            orden: {TIPO:"TP_STRING",MAXLENGTH:3,VISIBILIDAD:"TP_VISIBLE",CLASS:"text-uppercase text-center",WIDTH:"150px"},
            image: {TIPO:"TP_FILE",NECESARIO:1,VALID:"Archivo seleccionado",INVALID:"Seleccione archivo - 190x190",BROWSER:"Buscar",VISIBILIDAD:"TP_VISIBLE",ACCEPT:"image/*",NOMBRE:"imagen",WIDTH:"190px"},
            nombre: {TIPO:"TP_STRING",MAXLENGTH:50,VISIBILIDAD:"TP_VISIBLE"}
        },
        FORM: [
            {
                orden: '<div class="col-5 col-md-5">/orden/</div>',
            },
            {
                image: '<div class="col-12 col-md-8">/image/</div>',
            },
            {
                nombre: '<div class="col-12 col-md-8">/nombre/</div>'
            }
        ],
        FUNCIONES: {
            image: {onchange:{F:"readURL(this,'/id/')",C:"id"}},
            documento: {onchange:{F:"readURL(this,'/id/')",C:"id"}}
        }
    },
    descargasparte: {
        ATRIBUTOS: {
            orden2: {TIPO:"TP_STRING",MAXLENGTH:3,VISIBILIDAD:"TP_VISIBLE",CLASS:"text-uppercase text-center",WIDTH:"150px",NOMBRE:"orden"},
            image2: {TIPO:"TP_FILE",NECESARIO:1,VALID:"Archivo seleccionado",INVALID:"Seleccione archivo - 190x190",BROWSER:"Buscar",VISIBILIDAD:"TP_VISIBLE",ACCEPT:"image/*",NOMBRE:"imagen",WIDTH:"190px"},
            nombre2: {TIPO:"TP_STRING",MAXLENGTH:50,VISIBILIDAD:"TP_VISIBLE",NOMBRE:"nombre"}
        },
        FORM: [
            {
                orden2: '<div class="col-5 col-md-5">/orden2/</div>',
            },
            {
                image2: '<div class="col-12 col-md-8">/image2/</div>',
            },
            {
                nombre2: '<div class="col-12 col-md-8">/nombre2/</div>'
            }
        ],
        FUNCIONES: {
            image2: {onchange:{F:"readURL(this,'/id/')",C:"id"}},
            documento: {onchange:{F:"readURL(this,'/id/')",C:"id"}}
        }
    },
    descargasprecioEXT: {
        ATRIBUTOS: {
            documento: {TIPO:"TP_FILE",NECESARIO:1,VALID:"Documento seleccionado",INVALID:"Seleccione documento",BROWSER:"Buscar",VISIBILIDAD:"TP_VISIBLE",ACCEPT:"image/jpeg,application/pdf,.dbf,.DBF,.txt,.xls",NOMBRE:"documento",WIDTH:"190px",SIMPLE:1},
            formato: {TIPO:"TP_ENUM",ENUM: { dbf: "Formato DBF", pdf: "Formato PDF", txt: "Formato TXT", xls: "Formato XLS"},MAXLENGTH:50,VISIBILIDAD:"TP_VISIBLE", COMUN: 1}
        },
        FORM: [
            {
                documento: '<div class="col-12 col-md-6">/documento/</div>',
                formato: '<div class="col-12 col-md-6">/formato/</div>'
            }
        ],
        FUNCIONES: {
            documento: {onchange:{F:"readURL(this,'/id/')",C:"id"}}
        }
    },
    descargasparteEXT: {
        ATRIBUTOS: {
            documento: {TIPO:"TP_FILE",NECESARIO:1,VALID:"Documento seleccionado",INVALID:"Seleccione documento",BROWSER:"Buscar",VISIBILIDAD:"TP_VISIBLE",ACCEPT:"image/jpeg,application/pdf",NOMBRE:"documento",WIDTH:"190px",SIMPLE:1},
            nombre: {TIPO:"TP_STRING",MAXLENGTH:50,VISIBILIDAD:"TP_VISIBLE"}
        },
        FORM: [
            {
                documento: '<div class="col-12 col-md-6">/documento/</div>',
                nombre: '<div class="col-12 col-md-6">/nombre/</div>'
            }
        ],
        FUNCIONES: {
            documento: {onchange:{F:"readURL(this,'/id/')",C:"id"}}
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
    recursos: {
        ATRIBUTOS: {
            orden: {TIPO:"TP_STRING",MAXLENGTH:3,VISIBILIDAD:"TP_VISIBLE",CLASS:"text-uppercase text-center",WIDTH:"150px"},
            titulo: {TIPO:"TP_STRING",MAXLENGTH:100,VISIBILIDAD:"TP_VISIBLE",NOMBRE:"título"},
            descripcion: {TIPO:"TP_TEXT",EDITOR:1,VISIBILIDAD:"TP_VISIBLE",FIELDSET:1,NOMBRE:"descripción"},
            zona: {TIPO:"TP_STRING",MAXLENGTH:100,VISIBILIDAD:"TP_VISIBLE",NOMBRE:"zona"},
            in_zone: {TIPO:"TP_ENUM",ENUM:{1: "Domicilio en zona: SI",0: "Domicilio en zona: NO"},VISIBILIDAD:"TP_VISIBLE",COMUN:1,NOMBRE:"-",CLASS:"text-uppercase text-center"}
        },
        JSON: {
            titulo: {
                es: "español"
            },
            zona: {
                es: "español"
            },
            descripcion: {
                es: "español"
            },
        },
        FORM: [
            {
                orden: '<div class="col-3 col-md-3">/orden/</div>',
                in_zone: '<div class="col-5 col-md-4">/in_zone/</div>',
                BTN: '<div class="d-flex col-3 col-md-2">/BTN/</div>'
            },
            {
                titulo: '<div class="col-12 col-md-6">/titulo/</div>',
                zona: '<div class="col-12 col-md-6">/zona/</div>',
            },
            {
                descripcion: '<div class="col-12">/descripcion/</div>',
            }
        ]
    },

    calidad: {
        ATRIBUTOS: {
            TIT_principal: {TIPO:"TP_STRING",VISIBILIDAD:"TP_VISIBLE",NOMBRE:"título principal"},
            SUBTIT_principal: {TIPO:"TP_STRING",VISIBILIDAD:"TP_VISIBLE",NOMBRE:"subtítulo principal"},
            texto_principal: {TIPO:"TP_TEXT",EDITOR:1,VISIBILIDAD:"TP_VISIBLE",FIELDSET:1,NOMBRE:"texto principal"},
            slogan_principal: {TIPO:"TP_STRING",VISIBILIDAD:"TP_VISIBLE",NOMBRE:"slogan principal"},
            
            TIT_calidad: {TIPO:"TP_STRING",VISIBILIDAD:"TP_VISIBLE",NOMBRE:"título calidad"},
            texto_calidad: {TIPO:"TP_TEXT",EDITOR:1,VISIBILIDAD:"TP_VISIBLE",FIELDSET:1,NOMBRE:"texto calidad"},
            
            TIT_garantia: {TIPO:"TP_STRING",VISIBILIDAD:"TP_VISIBLE",NOMBRE:"título garantia"},
            texto_garantia: {TIPO:"TP_TEXT",EDITOR:1,VISIBILIDAD:"TP_VISIBLE",FIELDSET:1,NOMBRE:"texto garantía"},
        },
        JSON: {
            TIT_principal: {
                es: "español"
            },
            SUBTIT_principal: {
                es: "español"
            },
            texto_principal: {
                es: "español"
            },
            slogan_principal: {
                es: "español"
            },
            TIT_calidad: {
                es: "español"
            },
            texto_calidad: {
                es: "español"
            },
            TIT_garantia: {
                es: "español"
            },
            texto_garantia: {
                es: "español"
            },
        },
        FORM: [
            {
                BTN: '<div class="d-flex col-6 col-md-2">/BTN/</div>'
            },
            {
                TIT_principal: '<div class="col-12 col-md-6">/TIT_principal/</div>',
                SUBTIT_principal: '<div class="col-12 col-md-6">/SUBTIT_principal/</div>',
            },
            {
                slogan_principal: '<div class="col-12">/slogan_principal/</div>',
            },
            {
                texto_principal: '<div class="col-12">/texto_principal/</div>',
            },
            {
                TIT_calidad: '<div class="col-12">/TIT_calidad/</div>',
            },
            {
                texto_calidad: '<div class="col-12">/texto_calidad/</div>',
            },
            {
                TIT_garantia: '<div class="col-12">/TIT_garantia/</div>',
            },
            {
                texto_garantia: '<div class="col-12">/texto_garantia/</div>',
            },
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
            subcategorias: {TIPO:"TP_ENUM",VISIBILIDAD:"TP_VISIBLE_TABLE",NOMBRE:"Subcategorías",CLASS:"text-uppercase text-center"},
            familia_id: {TIPO:"TP_ENUM",VISIBILIDAD:"TP_VISIBLE",NOMBRE:"Relacionado"}
            //asociado: {TIPO:"TP_STRING",MAXLENGTH: 100,VISIBILIDAD:"TP_VISIBLE",NOMBRE:"Relacionado"}
        },
        FORM: [
            {
                orden: '<div class="col-5 col-md-3">/orden/</div>',
                BTN: '<div class="d-flex col-5 col-md-3">/BTN/</div>'
            },
            {
                nombre: '<div class="col-12 col-md-6">/nombre/</div>'
            },
            {
                familia_id: '<div class="col-12 col-md-6">/familia_id/</div>'
            },
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
    pedidos: {
        ATRIBUTOS: {
            cliente_id: {TIPO:"TP_ENUM",VISIBILIDAD:"TP_VISIBLE",NOMBRE:"cliente"},
            transporte_id: {TIPO:"TP_ENUM",VISIBILIDAD:"TP_VISIBLE",NOMBRE:"transporte"}
        },
        FORM: [
            {
                cliente_id: '<div class="col-12 col-md-6">/cliente_id/</div>',
                transporte_id: '<div class="col-12 col-md-6">/transporte_id/</div>'
            },
        ],
        FUNCIONES: {
            cliente_id: {onchange: "buscarTransporte(this);"}
        }
    },
    pedidoProducto: {
        ATRIBUTOS: {
            stmpdh_art: {TIPO:"TP_STRING",NECESARIO:1,MAXLENGTH:15,VISIBILIDAD:"TP_VISIBLE",CLASS:"text-uppercase text-center",NOMBRE:"código",WIDTH:"150px"},
            stmpdh_tex: {TIPO:"TP_STRING",MAXLENGTH:10,VISIBILIDAD:"TP_VISIBLE", NOMBRE:"NOMBRE",WIDTH:"180px"},
            codigo_ima: {TIPO:"TP_FILE",VISIBILIDAD:"TP_VISIBLE",WIDTH:"120px",NOMBRE:"imagen"},
            //usr_stmpdh: {TIPO:"TP_STRING",VISIBILIDAD:"TP_VISIBLE",NOMBRE:"cantidad"},
            //cantminvta: {TIPO:"TP_STRING",VISIBILIDAD:"TP_VISIBLE",NOMBRE:"Cant. mínima"},
            precio: {TIPO:"TP_STRING",VISIBILIDAD:"TP_VISIBLE",CLASS:"text-right",WIDTH:"100px"},
            familia_id: {TIPO:"TP_RELACION",VISIBILIDAD:"TP_VISIBLE",NOMBRE:"familia"},
            //modelo_id: {TIPO:"TP_RELACION",VISIBILIDAD:"TP_VISIBLE",NOMBRE:"Modelo",WIDTH: "200px"},
            parte_id: {TIPO:"TP_RELACION",VISIBILIDAD:"TP_VISIBLE",NOMBRE:"parte",WIDTH: "100px"},
            
        },

    },
    subcategorias: {
        ATRIBUTOS: {
            orden: {TIPO:"TP_STRING",MAXLENGTH:3,VISIBILIDAD:"TP_VISIBLE",CLASS:"text-uppercase text-center",WIDTH:"100px"},
            image: {TIPO:"TP_FILE",NECESARIO:1,VALID:"Archivo seleccionado",INVALID:"Seleccione archivo - 240x230",BROWSER:"Buscar",VISIBILIDAD:"TP_VISIBLE",ACCEPT:"image/*",NOMBRE:"imagen",WIDTH:"108px"},
            nombre: {TIPO:"TP_STRING",MAXLENGTH: 100,VISIBILIDAD:"TP_VISIBLE"},
            hsl: {TIPO:"TP_STRING",VISIBILIDAD:"TP_INVISIBLE"},
            categoria_id: {TIPO:"TP_ENUM",VISIBILIDAD:"TP_VISIBLE",NOMBRE:"Relacionado"},
            //subcategorias: {TIPO:"TP_ENUM",VISIBILIDAD:"TP_VISIBLE_TABLE",NOMBRE:"Subcategorías",CLASS:"text-uppercase text-center"}
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
                categoria_id: '<div class="col-12 col-md-6">/categoria_id/</div>'
            },
            {
                image: '<div class="col-12 col-md-6">/image/</div>',
            },
        ],
        FUNCIONES: {
            image: {onchange:{F:"readURL(this,'/id/')",C:"id"}}
        }
    },

    marcas: {
        ATRIBUTOS: {
            marcaT: {TIPO:"TP_STRING",MAXLENGTH: 100,VISIBILIDAD:"TP_VISIBLE"},
            modelo_y_a: {TIPO:"TP_STRING",MAXLENGTH: 100,VISIBILIDAD:"TP_VISIBLE"},
            //mod: {TIPO:"TP_ENUM",VISIBILIDAD:"TP_VISIBLE_TABLE",CLASS:"text-uppercase text-center",NOMBRE:"modelos"}
        },
        FORM: [
            {
                BTN: '<div class="d-flex col-3 col-md-3">/BTN/</div>'
            }
        ],
        FUNCIONES: {
            image: {onchange:{F:"readURL(this,'/id/')",C:"id"}}
        }
    },
    transportes: {
        ATRIBUTOS: {
            tracod: {TIPO:"TP_STRING",MAXLENGTH: 100,VISIBILIDAD:"TP_VISIBLE",NOMBRE:"código"},
            descrp: {TIPO:"TP_STRING",MAXLENGTH: 100,VISIBILIDAD:"TP_VISIBLE",NOMBRE:"descripción"},
            tradir: {TIPO:"TP_STRING",MAXLENGTH: 100,VISIBILIDAD:"TP_VISIBLE",NOMBRE:"dirección"},
            telefn: {TIPO:"TP_STRING",MAXLENGTH: 100,VISIBILIDAD:"TP_VISIBLE",NOMBRE:"teléfono"},
            respon: {TIPO:"TP_STRING",MAXLENGTH: 100,VISIBILIDAD:"TP_VISIBLE",NOMBRE:"responsable"},
        },
        FORM: [
            {
                BTN: '<div class="d-flex col-3 col-md-3">/BTN/</div>'
            }
        ],
        FUNCIONES: {
            image: {onchange:{F:"readURL(this,'/id/')",C:"id"}}
        }
    },
    vendedores: {
        ATRIBUTOS: {
            vnddor: {TIPO:"TP_STRING",MAXLENGTH: 100,VISIBILIDAD:"TP_VISIBLE",NOMBRE:"código",CLASS:"text-center"},
            descrp: {TIPO:"TP_STRING",MAXLENGTH: 100,VISIBILIDAD:"TP_VISIBLE",NOMBRE:"descripción"},
            natmer: {TIPO:"TP_STRING",MAXLENGTH: 100,VISIBILIDAD:"TP_VISIBLE",CLASS:"text-center"},
            nrotel: {TIPO:"TP_STRING",MAXLENGTH: 100,VISIBILIDAD:"TP_VISIBLE",NOMBRE:"teléfono"},
            mail: {TIPO:"TP_STRING",MAXLENGTH: 100,VISIBILIDAD:"TP_VISIBLE"},
        },
        FORM: [
            {
                BTN: '<div class="d-flex col-3 col-md-3">/BTN/</div>'
            }
        ],
        FUNCIONES: {
            image: {onchange:{F:"readURL(this,'/id/')",C:"id"}}
        }
    },
    modelos: {
        ATRIBUTOS: {
            nombre: {TIPO:"TP_STRING",MAXLENGTH: 100,VISIBILIDAD:"TP_VISIBLE"},
        },
        FORM: [
            {
                nombre: '<div class="col-8">/nombre/</div>',
                BTN: '<div class="col-3">/BTN/</div>',
            }
        ]
    },
    origenes: {
        ATRIBUTOS: {
            image: {TIPO:"TP_FILE",NECESARIO:1,VALID:"OK",INVALID:"28x14",BROWSER:"Buscar",VISIBILIDAD:"TP_VISIBLE",ACCEPT:"image/*",NOMBRE:"imagen",WIDTH:"108px"},
            nombre: {TIPO:"TP_STRING",MAXLENGTH: 100,VISIBILIDAD:"TP_VISIBLE"}
        },
        FORM: [
            {
                BTN: '<div class="d-flex col-3 col-md-3">/BTN/</div>'
            },
            {
                image: '<div class="col-6 col-md-4 col-lg-2">/image/</div>',
                nombre: '<div class="col-12 col-md-6">/nombre/</div>'
            }
        ],
        FUNCIONES: {
            image: {onchange:{F:"readURL(this,'/id/')",C:"id"}}
        }
    },
    
    terminos: {
        ATRIBUTOS: {
            titulo: {TIPO:"TP_STRING",VISIBILIDAD:"TP_VISIBLE",NOMBRE:"título"},
            texto: {TIPO:"TP_TEXT",EDITOR:1,VISIBILIDAD:"TP_VISIBLE",FIELDSET:1,NOMBRE:"texto"}
        },
        JSON: {
            titulo: {
                es: "español"
            },
            texto: {
                es: "español"
            },
        },
        FORM: [
            {
                BTN: '<div class="d-flex col-3 col-md-2">/BTN/</div>'
            },
            {
                titulo: '<div class="col-12">/titulo/</div>',
                texto: '<div class="col-12 mt-2">/texto/</div>',
            }
        ]
    },
    redes: {
        ATRIBUTOS: {
            redes: {TIPO:"TP_ENUM",ENUM:{facebook:'Facebook',instagram:'Instagram',twitter:'Twitter',youtube:'YouTube',linkedin:'LinkedIn'},NECESARIO:1,VISIBILIDAD:"TP_VISIBLE",CLASS:"text-uppercase",NOMBRE:"red social",COMUN:1},
            url: {TIPO:"TP_STRING",VISIBILIDAD:"TP_VISIBLE",NOMBRE:"link del sitio"},
        },
        FORM: [
            {
                redes: '<div class="col-4 col-md-2">/redes/</div>',
                url: '<div class="col-8 col-md-6">/url/</div>',
                BTN: '<div class="d-flex col-3 col-md-2">/BTN/</div>'
            }
        ]
    },
    metadatos: {
        ATRIBUTOS: {
            seccion: {TIPO:"TP_ENUM",ENUM:{home:"Home",empresa:"Empresa",productos:"Productos",descargas:"Descargas",calidad:"Calidad",contacto: "Contacto"},NECESARIO:1,VISIBILIDAD:"TP_VISIBLE_TABLE",CLASS:"text-uppercase",NOMBRE:"sección",WIDTH:"150px"},
            metas: {TIPO:"TP_TEXT",VISIBILIDAD:"TP_VISIBLE",FIELDSET:1,NOMBRE:"metadatos (,)"},
            descripcion: {TIPO:"TP_TEXT",VISIBILIDAD:"TP_VISIBLE",FIELDSET:1,NOMBRE:"descripción"}
        },
        FORM: [
            {
                seccion: '/seccion/',
                BTN: '<div class="d-flex col-3 col-md-3">/BTN/</div>'
            },
            {
                descripcion: '<div class="col-12">/descripcion/</div>',
                metas: '<div class="col-12 mt-2">/metas/</div>'
            }
        ]
    },
    empresa_general: {
        ATRIBUTOS: {
            pago: {TIPO:"TP_TEXT",EDITOR:1,VISIBILIDAD:"TP_VISIBLE",FIELDSET:1,NOMBRE:"Pagos vigentes"},
            banco: {TIPO:"TP_TEXT",EDITOR:1,VISIBILIDAD:"TP_VISIBLE",FIELDSET:1,NOMBRE:"Cuentas bancarias"}
        },
        FORM: [
            {
                pago: '<div class="col-12 col-md-6">/pago/</div>',
                banco: '<div class="col-12 col-md-6">/banco/</div>',
            }
        ]
    },
    empresa_email: {
        ATRIBUTOS: {
            email: {TIPO:"TP_EMAIL",MAXLENGTH:150,VISIBILIDAD:"TP_VISIBLE"}
        },
        FORM: [
            {
                email: '<div class="col-12">/email/</div>'
            }
        ]
    },
    empresa_telefono: {
        ATRIBUTOS: {
            telefono: {TIPO:"TP_PHONE",MAXLENGTH:30,VISIBILIDAD:"TP_VISIBLE"},
            tipo: {TIPO:"TP_ENUM",ENUM:{tel:"Teléfono",cel:"Celular",wha:"Whatsapp"},NECESARIO:1,VISIBILIDAD:"TP_VISIBLE_FORM",CLASS:"text-uppercase",NOMBRE:"Tipo",COMUN: 1}
        },
        FORM: [
            {
                tipo: '<div class="col-5">/tipo/</div>',
                telefono: '<div class="col-7">/telefono/</div>',
            }
        ]
    },
    empresa_domicilio: {
        ATRIBUTOS: {
            calle: {TIPO:"TP_STRING",VISIBILIDAD:"TP_VISIBLE"},
            altura: {TIPO:"TP_ENTERO",VISIBILIDAD:"TP_VISIBLE"},
            barrio: {TIPO:"TP_STRING",VISIBILIDAD:"TP_VISIBLE"}
        },
        FORM: [
            {
                calle: '<div class="col-12 col-md-8">/calle/</div>',
                altura: '<div class="col-4">/altura/</div>',
            },
            {
                barrio: '<div class="col-12 col-md-6">/barrio/</div>'
            }
        ]
    },
    empresa_images: {
        ATRIBUTOS: {
            logo: {TIPO:"TP_FILE",NECESARIO:1,VALID:"Logotipo OK",INVALID:"Logotipo - 257x65",BROWSER:"Buscar",VISIBILIDAD:"TP_VISIBLE",ACCEPT:"image/*",NOMBRE:"imagen",WIDTH:"250px"},
            logoFooter: {TIPO:"TP_FILE",NECESARIO:1,VALID:"Logotipo Footer OK",INVALID:"Logotipo Footer - 257x65",BROWSER:"Buscar",VISIBILIDAD:"TP_VISIBLE",ACCEPT:"image/*",NOMBRE:"imagen",WIDTH:"250px"},
            favicon: {TIPO:"TP_FILE",NECESARIO:1,VALID:"Favicon OK",INVALID:"Favicon",BROWSER:"Buscar",VISIBILIDAD:"TP_VISIBLE",ACCEPT:"image/x-icon,image/png",NOMBRE:"imagen",WIDTH:"250px"},
        },
        FORM: [
            {
                logo: '<div class="col-7 col-md-5">/logo/</div>',
                logoFooter: '<div class="col-5 col-md-5">/logoFooter/</div>',
                favicon: '<div class="col-3 col-md-2">/favicon/</div>'
            }
        ],
        FUNCIONES: {
            logo: {onchange:{F:"readURL(this,'/id/')",C:"id"}},
            logoFooter: {onchange:{F:"readURL(this,'/id/')",C:"id"}},
            favicon: {onchange:{F:"readURL(this,'/id/')",C:"id"}}
        }
    },
    usuarios: {
        ATRIBUTOS: {
            username: {TIPO:"TP_STRING",MAXLENGTH:30,NECESARIO:1,VISIBILIDAD:"TP_VISIBLE",NOMBRE:"usuario"},
            name: {TIPO:"TP_STRING",MAXLENGTH:100,NECESARIO:1,VISIBILIDAD:"TP_VISIBLE",NOMBRE:"nombre"},
            password: {TIPO:"TP_PASSWORD",VISIBILIDAD:"TP_VISIBLE_FORM",NOMBRE:"contraseña"},
            is_admin: {TIPO:"TP_ENUM",VISIBILIDAD:"TP_VISIBLE",ENUM:{1:"Administrador",0:"Cliente",2:"Vended0or",11:"ADM Ventor"},NOMBRE:"Tipo",CLASS:"text-uppercase"},
        },
        FORM: [
            {
                BTN: '<div class="col-3 col-md-2">/BTN/</div>'
            },
            {
                is_admin: '<div class="col-12 col-md-6">/is_admin/</div>',
            },
            {
                name: '<div class="col-12 col-md-6">/name/</div>',
            },
            {
                username: '<div class="col-3">/username/</div>',
                password: '<div class="col-3">/password/</div>',
            }
        ],
    },
    
    familias: {
        ATRIBUTOS: {
            usr_stmati: {TIPO:"TP_STRING",MAXLENGTH: 200,VISIBILIDAD:"TP_VISIBLE",NOMBRE:"nombre"}
        },
        FORM: [
            {
                BTN: '<div class="d-flex col-3 col-md-3">/BTN/</div>'
            },
            {
                usr_stmati: '<div class="col-12 col-md-6">/nombre/</div>'
            }
        ],
    },
    partes: {
        ATRIBUTOS: {
            cod: {TIPO:"TP_STRING",MAXLENGTH: 200,VISIBILIDAD:"TP_VISIBLE",NOMBRE:"código"},
            descrp: {TIPO:"TP_STRING",MAXLENGTH: 200,VISIBILIDAD:"TP_VISIBLE",NOMBRE:"descripción"},
            familia_id: {TIPO:"TP_STRING",MAXLENGTH: 200,VISIBILIDAD:"TP_VISIBLE",NOMBRE:"Familia"}
        },
        FORM: [
            {
                BTN: '<div class="d-flex col-3 col-md-3">/BTN/</div>'
            },
            {
                cod: '<div class="col-12 col-md-6">/cod/</div>'
            }
        ],
    },
    productos: {
        ATRIBUTOS: {
            stmpdh_art: {TIPO:"TP_STRING",NECESARIO:1,MAXLENGTH:15,VISIBILIDAD:"TP_VISIBLE",CLASS:"text-uppercase text-center",NOMBRE:"código",WIDTH:"150px"},
            use: {TIPO:"TP_TEXT",NECESARIO:1,MAXLENGTH:100,EDITOR:1,VISIBILIDAD:"TP_INVISIBLE",FIELDSET:1},
            stmpdh_tex: {TIPO:"TP_STRING",MAXLENGTH:10,VISIBILIDAD:"TP_VISIBLE", NOMBRE:"NOMBRE",WIDTH:"250px"},
            codigo_ima: {TIPO:"TP_FILE",VISIBILIDAD:"TP_VISIBLE",WIDTH:"120px",NOMBRE:"imagen"},
            usr_stmpdh: {TIPO:"TP_STRING",VISIBILIDAD:"TP_VISIBLE",NOMBRE:"cantidad"},
            cantminvta: {TIPO:"TP_STRING",VISIBILIDAD:"TP_VISIBLE",NOMBRE:"Cant. mínima"},
            precio: {TIPO:"TP_STRING",VISIBILIDAD:"TP_VISIBLE",CLASS:"text-right",WIDTH:"100px"},
            mercadolibre: {TIPO:"TP_STRING",MAXLENGTH:150,VISIBILIDAD:"TP_VISIBLE_FORM"},
            catalogo: {TIPO:"TP_FILE",NECESARIO:1,VALID:"Catálogo seleccionado",INVALID:"Seleccione catálogo",BROWSER:"Buscar",VISIBILIDAD:"TP_VISIBLE_FORM",ACCEPT:"image/jpeg,application/pdf",SIMPLE:1},
            familia_id: {TIPO:"TP_RELACION",VISIBILIDAD:"TP_VISIBLE",NOMBRE:"familia"},
            modelo_id: {TIPO:"TP_RELACION",VISIBILIDAD:"TP_VISIBLE",NOMBRE:"Modelo",WIDTH: "200px"},
            parte_id: {TIPO:"TP_RELACION",VISIBILIDAD:"TP_VISIBLE",NOMBRE:"parte",WIDTH: "100px"},
            grupo_web: {TIPO:"TP_STRING",VISIBILIDAD:"TP_INVISIBLE"},
            fecha_ingr: {TIPO:"TP_FECHA",EDITOR:1,VISIBILIDAD:"TP_VISIBLE",CLASS:"text-center",SIMPLE:1,NOMBRE:"fecha ingreso",WIDTH:"120px"},
            nro_refere: {TIPO:"TP_STRING",VISIBILIDAD:"TP_VISIBLE",NOMBRE:"NRO. Referencia"},
            //web_marcas: {TIPO:"TP_STRING",NECESARIO:1,VISIBILIDAD:"TP_INVISIBLE",CLASS:"text-uppercase",NOMBRE:"marcas"},
            //modelo_y_a: {TIPO:"TP_STRING",VISIBILIDAD:"TP_INVISIBLE",NOMBRE:"modelo"},
            //parte: {TIPO:"TP_STRING",NECESARIO:1,VISIBILIDAD:"TP_INVISIBLE",CLASS:"text-uppercase",DISABLED: 1},
            //parte_dbf_: {TIPO:"TP_STRING",NECESARIO:1,VISIBILIDAD:"TP_INVISIBLE",CLASS:"text-uppercase"},
            //usr_stmati: {TIPO:"TP_STRING",NECESARIO:1,VISIBILIDAD:"TP_INVISIBLE",CLASS:"text-uppercase"},
        },
        FORM: [
            {
                orden: '<div class="col-5 col-md-3">/orden/</div>',
                BTN: '<div class="d-flex col-3 col-md-3">/BTN/</div>'
            },
            {
                image: '<div class="col-12 col-md-6">/image/</div>',
                catalogo: '<div class="col-12 col-md-6">/catalogo/</div>',
            },
            {
                codigo: '<div class="col-12 col-md-3">/codigo/</div>',
                cantidad: '<div class="col-12 col-md-3">/cantidad/</div>',
                precio: '<div class="col-12 col-md-4">/precio/</div>',
            },
            {
                nombre: '<div class="col-12">/nombre/</div>',
            },
            {
                mercadolibre: '<div class="col-12 col-md-9">/mercadolibre/</div>',
                novedad: '<div class="col-12 col-md-3">/novedad/</div>'
            },
            {
                familia_id: '<div class="col-12 col-md-6">/familia_id/</div>',
                categoria_id: '<div class="col-12 col-md-6">/categoria_id/</div>',
            },
            {
                origen_id: '<div class="col-12 col-md-6">/origen_id/</div>',
                marca_id: '<div class="col-12 col-md-6">/marca_id/</div>'
            }
        ],
        FUNCIONES: {
            image: {onchange:{F:"readURL(this,'/id/')",C:"id"}},
            familia_id: {onchange: "changeFamilia(this, '#categoria_id');"},
        }
    },
    formulario_login: {
        ATRIBUTOS: {
            username: {TIPO:"TP_STRING",VISIBILIDAD:"TP_VISIBLE",NOMBRE:"Usuario"},
            password: {TIPO:"TP_PASSWORD",VISIBILIDAD:"TP_VISIBLE",NOMBRE:"Contraseña"},
        },
        FORM: [
            {
                username: '<div class="col-12">/username/</div>',
            },
        ]
    },
    formulario_cliente: {
        ATRIBUTOS: {
            nombre: {TIPO:"TP_STRING",NECESARIO:1,VISIBILIDAD:"TP_VISIBLE",NOMBRE:"Nombre y Apellido"},
            telefono: {TIPO:"TP_STRING",VISIBILIDAD:"TP_VISIBLE",NOMBRE:"Teléfono"},
            domicilio: {TIPO:"TP_STRING",VISIBILIDAD:"TP_VISIBLE",NECESARIO: 1},
            localidad: {TIPO:"TP_STRING",NECESARIO:1,VISIBILIDAD:"TP_VISIBLE"},
            email: {TIPO:"TP_EMAIL",VISIBILIDAD:"TP_VISIBLE",NECESARIO:1,NOMBRE:"Email"},
            localidad: {TIPO:"TP_STRING",NECESARIO:1,VISIBILIDAD:"TP_VISIBLE"},
        },
        FORM: [
            {
                nombre: '<div class="col-12 col-md-6">/nombre/</div>',
                telefono: '<div class="col-12 col-md-6">/telefono/</div>',
            },
            {
                domicilio: '<div class="col-12 col-md-6">/domicilio/</div>',
                localidad: '<div class="col-12 col-md-6">/localidad/</div>',
            },
            {
                email: '<div class="col-12">/email/</div>',
            }
        ]
    },
    formulario_atencion: {
        ATRIBUTOS: {
            nroCliente: {TIPO:"TP_STRING",NECESARIO:1,VISIBILIDAD:"TP_VISIBLE",NOMBRE:"Nro. Cliente"},
            razon: {TIPO:"TP_STRING",VISIBILIDAD:"TP_VISIBLE",NOMBRE:"Razón Social"},
            fecha: {TIPO:"TP_FECHA",NECESARIO:1,VISIBILIDAD:"TP_VISIBLE",SIMPLE:1},
            importe: {TIPO:"TP_STRING",NECESARIO:1,VISIBILIDAD:"TP_VISIBLE",CLASS:"importe"},
            banco: {TIPO:"TP_STRING",NECESARIO:1,VISIBILIDAD:"TP_VISIBLE"},
            sucursal: {TIPO:"TP_STRING",NECESARIO:1,VISIBILIDAD:"TP_VISIBLE"},
            facturas: {TIPO:"TP_STRING",NECESARIO:1,VISIBILIDAD:"TP_VISIBLE",NOMBRE:"Facturas canceladas"},
            descuento: {TIPO:"TP_STRING",NECESARIO:1,VISIBILIDAD:"TP_VISIBLE",NOMBRE:"Descuento efectuado"},
            
            observaciones: {TIPO:"TP_TEXT",VISIBILIDAD:"TP_VISIBLE"},
        },
        FORM: [
            {
                nroCliente: '<div class="col-12 col-md-6">/nroCliente/</div>',
                razon: '<div class="col-12 col-md-6">/razon/</div>',
            },
            {
                fecha: '<div class="col-12 col-md-6">/fecha/</div>',
                importe: '<div class="col-12 col-md-6">/importe/</div>',
            },
            {
                banco: '<div class="col-12 col-md-6">/banco/</div>',
                sucursal: '<div class="col-12 col-md-6">/sucursal/</div>',
            },
            {
                facturas: '<div class="col-12 col-md-6">/facturas/</div>',
                descuento: '<div class="col-12 col-md-6">/descuento/</div>',
            },
            {
                observaciones: '<div class="col-12">/observaciones/</div>',
            }
        ]
    },
    formulario_general: {
        ATRIBUTOS: {
            empresa: {TIPO:"TP_STRING",VISIBILIDAD:"TP_VISIBLE", NECESARIO: 1,NOMBRE:"Empresa o Nombre"},
            telefono: {TIPO:"TP_STRING",VISIBILIDAD:"TP_VISIBLE",NOMBRE:"Teléfono"},
            email: {TIPO:"TP_STRING",NECESARIO:1,VISIBILIDAD:"TP_VISIBLE",NOMBRE:"E-mail"},
            localidad: {TIPO:"TP_STRING",VISIBILIDAD:"TP_VISIBLE"},
            
            mensaje: {TIPO:"TP_TEXT",NECESARIO: 1,VISIBILIDAD:"TP_VISIBLE"},
        },
        FORM: [
            {
                empresa: '<div class="col-12">/empresa/</div>',
            },
            {
                email: '<div class="col-12 col-md-6">/email/</div>',
                telefono: '<div class="col-12 col-md-6">/telefono/</div>',
            },
            {
                localidad: '<div class="col-12">/localidad/</div>'
            },
            {
                mensaje: '<div class="col-12">/mensaje/</div>',
            }
        ]
    },
    formulario_redes: {
        ATRIBUTOS: {
            url: {TIPO:"TP_STRING",VISIBILIDAD:"TP_VISIBLE",PLACEHOLDER:"URL al perfil público",AYUDA: "Por ejemplo: https://ar.linkedin.com/in/john-doe"},
        },
        FORM: [
            {
                url: '<div class="col-12">/url/</div>',
            }
        ]
    },
    formulario_educacion: {
        ATRIBUTOS: {
            titulo: {TIPO:"TP_STRING",VISIBILIDAD:"TP_VISIBLE",PLACEHOLDER:"Título"},
            pais: {TIPO:"TP_ENUM",ENUM:{argentina:"Argentina"},VISIBILIDAD:"TP_VISIBLE",COMUN:1,NOMBRE:"Selecciona un país"},
            area: {TIPO:"TP_ENUM",
                    ENUM:{
                        sociales:"Ciencias Sociales, del Comportamiento, de la Comunicación, Administración, Trabajo y Derecho",
                        ingenieria:"Ingeniería, Tecnología, Industria, Arquitectura y Construcción",
                        salud:"Ciencias de la Salud y Servicios Sociales",
                        arte:"Artes y humanidades",
                        vida:"Ciencias de la Vida, de la Tierra, del Espacio, Químicas, Físicas y Exactas",
                        pedagodia:"Pedagogía",
                        servicios:"Servicios: Turismo, Hostelería, Deportes, Belleza, Transporte, Medio Ambiente y Seguridad",
                        agronomia:"Agronomía, Agricultura, Ganadería, Pesca y Veterinaria"
                    },VISIBILIDAD:"TP_VISIBLE",COMUN:1,NOMBRE:"Área de Estudio"},
            nivel: {TIPO:"TP_ENUM",ENUM:{primario:"Primario",secundario:"Secundario",terciario:"Terciario",universitario:"Universitario"},VISIBILIDAD:"TP_VISIBLE",COMUN:1,NOMBRE:"Nivel de Estudio"},
            estado: {TIPO:"TP_ENUM",ENUM:{finalizado:"Finalizado",encurso:"En Curso",abandonado:"Abandonado"},VISIBILIDAD:"TP_VISIBLE",COMUN:1,NOMBRE:"Estado de Estudio"},
            actual: {TIPO:"TP_CHECK",VISIBILIDAD:"TP_VISIBLE_FORM",NOMBRE:"Actualmente asisto"},
            desde: {TIPO:"TP_FECHA",NECESARIO:1,VISIBILIDAD:"TP_VISIBLE",SIMPLE:1, NOMBRE:"Desde"},
            hasta: {TIPO:"TP_FECHA",VISIBILIDAD:"TP_VISIBLE",SIMPLE:1, NOMBRE:"Hasta"},
            descripcion: {TIPO:"TP_TEXT",VISIBILIDAD:"TP_VISIBLE",NOMBRE:"Descripción"},
        },
        FORM: [
            {
                titulo: '<div class="col-12 col-md-6">/titulo/</div>',
                pais: '<div class="col-12 col-md-6">/pais/</div>',
            },
            {
                area: '<div class="col-12 col-md-4">/area/</div>',
                nivel: '<div class="col-12 col-md-4">/nivel/</div>',
                estado: '<div class="col-12 col-md-4">/estado/</div>',
            },
            {
                actual: '<div class="col-12">/actual/</div>'
            },
            {
                desde: '<div class="col-12 col-md-6">/desde/</div>',
                hasta: '<div class="col-12 col-md-6">/hasta/</div>',
            },
            {
                descripcion: '<div class="col-12">/descripcion/</div>'
            }
        ],
        FUNCIONES: {
            actual: {onchange:{F:"readONLY(this,'/hasta/')",C:"hasta"}}
        },
        MINUSCULA: 1
    },
    formulario_curriculum: {
        ATRIBUTOS: {
            curriculum: {TIPO:"TP_FILE",NECESARIO:1,VALID:"Curriculum Vitae seleccionado",INVALID:"Seleccione Curriculum Vitae",BROWSER:"CARGAR ARCHIVO",VISIBILIDAD:"TP_VISIBLE_FORM",ACCEPT:"image/jpeg,application/pdf",NOMBRE:"Curriculum Vatae",SIMPLE:1},
        },
        FORM: [
            {
                curriculum: '<div class="col-12">/curriculum/</div>',
            }
        ]
    },
    formulario_trabajo: {
        ATRIBUTOS: {
            puesto: {TIPO:"TP_STRING",VISIBILIDAD:"TP_VISIBLE",PLACEHOLDER:"Nombre del Puesto / Título"},
            empresa: {TIPO:"TP_STRING",VISIBILIDAD:"TP_VISIBLE",PLACEHOLDER:"Nombre de Empresa / Negocio"},
            industria: {TIPO:"TP_STRING",VISIBILIDAD:"TP_VISIBLE",PLACEHOLDER:"Tipo de Industria"},
            area: {TIPO:"TP_STRING",VISIBILIDAD:"TP_VISIBLE",PLACEHOLDER:"Área de trabajo"},
            seniority: {TIPO:"TP_ENUM",NOMBRE:"Seniority",ENUM:{senior:"Senior",semisenior:"Semi senior",junior:"Junior"},VISIBILIDAD:"TP_VISIBLE",COMUN:1},
            pais: {TIPO:"TP_ENUM",ENUM:{argentina:"Argentina"},VISIBILIDAD:"TP_VISIBLE",COMUN:1,NOMBRE:"Selecciona un país"},
            actual: {TIPO:"TP_CHECK",VISIBILIDAD:"TP_VISIBLE_FORM",NOMBRE:"Actualmente trabajo aquí"},
            desde: {TIPO:"TP_FECHA",NECESARIO:1,VISIBILIDAD:"TP_VISIBLE",SIMPLE:1, NOMBRE:"Desde"},
            hasta: {TIPO:"TP_FECHA",VISIBILIDAD:"TP_VISIBLE",SIMPLE:1, NOMBRE:"Hasta"},
            descripcion: {TIPO:"TP_TEXT",VISIBILIDAD:"TP_VISIBLE",NOMBRE:"Descripción"},
        },
        FORM: [
            {
                puesto: '<div class="col-12 col-md-6">/puesto/</div>',
                seniority: '<div class="col-12 col-md-6">/seniority/</div>',
            },
            {
                empresa: '<div class="col-12 col-md-6">/empresa/</div>',
                pais: '<div class="col-12 col-md-6">/pais/</div>',
            },
            {
                industria: '<div class="col-12 col-md-6">/industria/</div>',
                area: '<div class="col-12 col-md-6">/area/</div>',
            },
            {
                actual: '<div class="col-12">/actual/</div>'
            },
            {
                desde: '<div class="col-12 col-md-6">/desde/</div>',
                hasta: '<div class="col-12 col-md-6">/hasta/</div>',
            },
            {
                descripcion: '<div class="col-12">/descripcion/</div>'
            }
        ],
        FUNCIONES: {
            actual: {onchange:{F:"readONLY(this,'/hasta/')",C:"hasta"}}
        },
        MINUSCULA: 1
    },
    formulario_recursos: {
        ATRIBUTOS: {
            nombre: {TIPO:"TP_STRING",NECESARIO:1,VISIBILIDAD:"TP_VISIBLE",NOMBRE:"Nombre"},
            apellido: {TIPO:"TP_STRING",NECESARIO:1,VISIBILIDAD:"TP_VISIBLE",NOMBRE:"Apellido"},
            fecha: {TIPO:"TP_FECHA",NECESARIO:1,VISIBILIDAD:"TP_VISIBLE",SIMPLE:1, NOMBRE:"Fecha de nacimiento"},
            domicilio: {TIPO:"TP_STRING",NECESARIO:1,VISIBILIDAD:"TP_VISIBLE",NOMBRE:"Domicilio"},
            cp: {TIPO:"TP_STRING",VISIBILIDAD:"TP_VISIBLE",NECESARIO:1,NOMBRE:"código postal"},
            provincia: {TIPO:"TP_STRING",VISIBILIDAD:"TP_VISIBLE",NECESARIO:1,NOMBRE:"Provincia"},
            localidad: {TIPO:"TP_STRING",VISIBILIDAD:"TP_VISIBLE",NECESARIO:1,NOMBRE:"Localidad"},
            nacionalidad: {TIPO:"TP_STRING",VISIBILIDAD:"TP_VISIBLE",NECESARIO:1,NOMBRE:"Nacionalidad"},
            dni: {TIPO:"TP_STRING",VISIBILIDAD:"TP_VISIBLE",NECESARIO:1,NOMBRE:"DNI (Documento de Identidad)"},
            estado: {TIPO:"TP_STRING",VISIBILIDAD:"TP_VISIBLE",NECESARIO:1,NOMBRE:"Estado Civil"},
            email: {TIPO:"TP_EMAIL",VISIBILIDAD:"TP_VISIBLE",NECESARIO:1,NOMBRE:"Email"},
            telefono: {TIPO:"TP_PHONE",VISIBILIDAD:"TP_VISIBLE",NECESARIO:1,NOMBRE:"Teléfono"},
            
            observaciones: {TIPO:"TP_TEXT",VISIBILIDAD:"TP_VISIBLE"},
        },
        FORM: [
            {
                nombre: '<div class="col-12 col-md-6">/nombre/</div>',
                apellido: '<div class="col-12 col-md-6">/apellido/</div>',
            },
            {
                domicilio: '<div class="col-12 col-md-6">/domicilio/</div>',
                cp: '<div class="col-12 col-md-6">/cp/</div>',
            },
            {
                provincia: '<div class="col-12 col-md-6">/provincia/</div>',
                localidad: '<div class="col-12 col-md-6">/localidad/</div>',
            },
            {
                nacionalidad: '<div class="col-12 col-md-6">/nacionalidad/</div>',
                dni: '<div class="col-12 col-md-6">/dni/</div>',
            },
            {
                fecha: '<div class="col-12 col-md-6">/fecha/</div>',
                estado: '<div class="col-12 col-md-6">/estado/</div>',
            },
            {
                email: '<div class="col-12 col-md-6">/email/</div>',
                telefono: '<div class="col-12 col-md-6">/telefono/</div>',
            }
        ],
        MINUSCULA: 1,
        PLACEHOLDER: 1
    }
    
}