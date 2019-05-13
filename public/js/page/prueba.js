PyrusCuerpo = function( e = null, dataPYRUS = null , urlFile = null) {
    this.entidad = e; // entidad que se pasa por parametro
    this.objeto = null;

    this.constructor = function() {
		if(this.entidad === null || this.entidad === "") {
			console.log("AVISO: No se ha pasado ninguna entidad. Uso limitado");
			// no hago ninguna operacion de carga
			return false;
		}
        /* ------------------- */
        this.objeto = BODY[this.entidad];
        /* ------------------- */

    };
    this.html = function() {
        let html = this.objeto.HTML;
        let _return = "";
        if(html === undefined) return "";

        html.forEach(function(x) {
            _return += x;
        });
        for(let x in this.objeto.ATRIBUTOS) {
            aux = this.formaAdecuada(x,this.objeto.ATRIBUTOS[x]);
            regex = new RegExp(`/${x}/`, 'g');
            console.log(regex)
            _return = _return.replace(regex,aux);
            //_return = _return.replace(`/${x}/`,aux);
        }
        _return = _return.replace(/URLBASE/g, dataPYRUS.URLBASE);
        if(dataPYRUS.URLLOGOUT !== undefined)
            _return = _return.replace(/URLLOGOUT/g, dataPYRUS.URLLOGOUT);
        return _return;
    };
    this.formaAdecuada = function(objeto,data) {
        switch(data.TIPO) {
            case "TP_IMG":
                return this.image(data);
            case "TP_NAV":
                return this.nav(data, objeto);
            case "TP_MARCA":
                return this.marca(data);
            case "TP_DATOS":
                return this.datos(data);
            case "TP_SEARCH":
                return this.form(data);
            case "TP_SOCIAL":
                return this.social(data);
            case "TP_PERSONA":
                return this.persona(data);
        }
    }
    this.persona = function(data) {
        return `${dataPYRUS.datos.name} ${dataPYRUS.datos.lastname}`;
    }
    this.social = function(data) {
        let html = "";
        let ARR_redes = {facebook:'<i class="fab fa-facebook-square"></i>',instagram:'<i class="fab fa-instagram"></i>',twitter:'<i class="fab fa-twitter-square"></i>',youtube:'<i class="fab fa-youtube"></i>',linkedin:'<i class="fab fa-linkedin-in"></i>'};
        for(let x in dataPYRUS.REDES) {
            icon = ARR_redes[dataPYRUS.REDES[x].redes];
            link = dataPYRUS.REDES[x].url;
            html += `<a href="${link}" target="blank">${icon}</a>`;
        }
        return html;
    }
    this.form = function(data) {
        let html = "";

        data.FORMAT.forEach(function(x) {
            html += x;
        });
        for(let x in dataPYRUS.BUSCADOR) 
            html = html.replace(`/${x}/`,dataPYRUS.BUSCADOR[x]);
        return html;
    };
    this.image = function(data) {
        let complementos = "";
        let src = dataPYRUS.logo;
        let style = "";
        if(data.DEFAULT !== undefined) {
            if(complementos != "") complementos += " ";
            complementos += `onError="this.src='${dataPYRUS.imgDEFAULT}'"`;
        }
        if(data.TIME !== undefined) {
            let date = new Date();
            src += `?t=${date.getTime()}`;
            if(complementos != "") complementos += " ";
            complementos += `src="${src}"`;
        }
        
        style += `width: ${(data.WIDTH !== undefined) ? data.WIDTH : 'auto'};`
        style += `height: ${(data.HEIGHT !== undefined) ? data.HEIGHT : 'auto'};`
        return `<img ${complementos} style="${style}" />`;
    };
    this.nav = function(data, tipo = null) {
        let html = "";
        console.log(data)
        for(let x in data.ELEMENT) {
            clase = "hidden-tablet";
            if(data.NOHIDDEN !== undefined) clase = "";
            console.log(clase)
            html += `<li data-${x} class="${clase}">`;
                
                if(x != "" && data.SUB !== undefined) {
                    if(data.SUB[x] !== undefined) {
                        html += `<a data-href="${x}" href="#">${data.ELEMENT[x]}</a>`;
                        html += `<ul class="submenu list-unstyled shadow-sm">`;
                        for(let y in data.SUB[x]) {
                            html += `<li>`;
                                html += `<a href="${dataPYRUS.URLBASE}/${x}/${y}">${data.SUB[x][y]}</a>`;
                            html += `</li>`;
                        }
                        html += `</ul>`;
                    } else
                        html += `<a href="${dataPYRUS.URLBASE}/${x}">${data.ELEMENT[x]}</a>`;
                } else
                    html += `<a href="${dataPYRUS.URLBASE}/${x}">${data.ELEMENT[x]}</a>`;
            html += `</li>`;
        }

        return html;
    };
    this.marca = function(data) {
        let html = "";
        html += `<p class="mb-0 d-flex justify-content-between">`;
            if(data.ANIO !== undefined) {
                date = new Date();
                html += `<span>© ${date.getFullYear()}</span>`;
            }
            html += `<a href="${data.URL}" class="text-uppercase">by osole</a>`;
        html += `</p>`;

        return html;
    };
    this.datos = function(data) {
        let html = "";
        for(let x in data.ELEMENT) {
            html += `<li class="d-flex">`;
                html += data.ELEMENT[x];
                html += `<div class="ml-2">`;
                    switch(x) {
                        case "email":
                            dataPYRUS[x].forEach(function(e) {
                                html += `<a title="${e}" class="text-truncate d-block" href="mailto:${e}" target="blank">${e}</a>`;
                            });
                            break;
                        case "telefono":
                            dataPYRUS[x]["tel"].forEach(function(y) {
                                html += `<a title="${y}" class="text-truncate d-block" href="tel:${y}">${y}</a>`;
                            });
                            break;
                        case "domicilio":
                            html += `${dataPYRUS[x]["calle"]} ${dataPYRUS[x]["altura"]} - Ciudad Autónoma de Buenos Aires`;
                            break;
                    }
                html += `</div>`;
            html += `</li>`;
        }

        return html;
    };
    /* ----------------- */
	return this.constructor();
};