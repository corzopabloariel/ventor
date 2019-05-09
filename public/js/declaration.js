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
            subcategorias: {TIPO:"TP_ENUM",VISIBILIDAD:"TP_VISIBLE_TABLE",NOMBRE:"Subcategorías",CLASS:"text-uppercase text-center"}
        },
        FORM: [
            {
                orden: '<div class="col-5 col-md-3">/orden/</div>',
                BTN: '<div class="d-flex col-5 col-md-3">/BTN/</div>'
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
            subcategorias: {TIPO:"TP_ENUM",VISIBILIDAD:"TP_VISIBLE_TABLE",NOMBRE:"Subcategorías",CLASS:"text-uppercase text-center"}
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
    },

    marcas: {
        ATRIBUTOS: {
            image: {TIPO:"TP_FILE",NECESARIO:1,VALID:"Archivo seleccionado",INVALID:"Seleccione archivo - 230x230",BROWSER:"Buscar",VISIBILIDAD:"TP_VISIBLE",ACCEPT:"image/*",NOMBRE:"imagen",WIDTH:"108px"},
            nombre: {TIPO:"TP_STRING",MAXLENGTH: 100,VISIBILIDAD:"TP_VISIBLE"},
            mod: {TIPO:"TP_ENUM",VISIBILIDAD:"TP_VISIBLE_TABLE",CLASS:"text-uppercase text-center",NOMBRE:"modelos"}
        },
        FORM: [
            {
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
            is_admin: {TIPO:"TP_ENUM",VISIBILIDAD:"TP_VISIBLE",ENUM:{1:"Administrador",0:"Usuario"},NOMBRE:"Tipo",CLASS:"text-uppercase"},
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

    productos: {
        ATRIBUTOS: {
            codigo: {TIPO:"TP_STRING",NECESARIO:1,MAXLENGTH:15,VISIBILIDAD:"TP_VISIBLE_FORM",CLASS:"text-uppercase text-center",NOMBRE:"código"},
            nombre: {TIPO:"TP_TEXT",NECESARIO:1,MAXLENGTH:100,EDITOR:1,VISIBILIDAD:"TP_VISIBLE",FIELDSET:1,NOMBRE:"nombre"},
            orden: {TIPO:"TP_STRING",MAXLENGTH:10,VISIBILIDAD:"TP_VISIBLE_FORM",CLASS:"text-uppercase text-center",WIDTH:"150px"},
            image: {TIPO:"TP_FILE",NECESARIO:1,VALID:"Archivo seleccionado",INVALID:"Seleccione archivo - 362x347",BROWSER:"Buscar",VISIBILIDAD:"TP_VISIBLE",ACCEPT:"image/*",NOMBRE:"imagen",WIDTH:"125px"},
            link: {TIPO:"TP_STRING",VISIBILIDAD:"TP_INVISIBLE"},
            mercadolibre: {TIPO:"TP_STRING",MAXLENGTH:150,VISIBILIDAD:"TP_VISIBLE_FORM",NOMBRE:"link de mercadolibre"},
            catalogo: {TIPO:"TP_FILE",NECESARIO:1,VALID:"Catálogo seleccionado",INVALID:"Seleccione catálogo",BROWSER:"Buscar",VISIBILIDAD:"TP_VISIBLE_FORM",ACCEPT:"image/jpeg,application/pdf",NOMBRE:"catálogo",SIMPLE:1},
            familia_id: {TIPO:"TP_ENUM",NECESARIO:1,VISIBILIDAD:"TP_VISIBLE_FORM",CLASS:"text-uppercase",NOMBRE:"categoría"},
            categoria_id: {TIPO:"TP_ENUM",NECESARIO:1,VISIBILIDAD:"TP_VISIBLE_FORM",CLASS:"text-uppercase",NOMBRE:"categoría",DISABLED: 1},
            origen_id: {TIPO:"TP_ENUM",NECESARIO:1,VISIBILIDAD:"TP_VISIBLE_FORM",CLASS:"text-uppercase",NOMBRE:"origen"},
            marca_id: {TIPO:"TP_ENUM",NECESARIO:1,VISIBILIDAD:"TP_VISIBLE_FORM",CLASS:"text-uppercase",NOMBRE:"marca"},
            marcaTexto: {TIPO:"TP_STRING",VISIBILIDAD:"TP_VISIBLE_TABLE",NOMBRE:"marca"},
            categoriaTexto: {TIPO:"TP_STRING",VISIBILIDAD:"TP_VISIBLE_TABLE",NOMBRE:"categoría"},
            
            cantidad: {TIPO:"TP_ENTERO",EDITOR:1,VISIBILIDAD:"TP_VISIBLE_FORM",NOMBRE:"cantidad envasada",CLASS:"text-center",SIMPLE:1}
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
                cantidad: '<div class="col-12 col-md-3">/cantidad/</div>'
            },
            {
                nombre: '<div class="col-12">/nombre/</div>',
            },
            {
                mercadolibre: '<div class="col-12">/mercadolibre/</div>'
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
}