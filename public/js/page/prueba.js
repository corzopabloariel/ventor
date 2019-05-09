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

            _return = _return.replace(`/${x}/`,aux);
        }
        return _return;
    };
    this.formaAdecuada = function(objeto,data) {
        switch(data.TIPO) {
            case "TP_IMG":
                return this.image(data);
            case "TP_NAV":
                return this.nav(data);
            case "TP_MARCA":
                return this.marca(data);
            case "TP_DATOS":
                return this.datos(data);
        }
    }
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
    }
    this.nav = function(data) {
        let html = "";
        for(let x in data.ELEMENT) {
            html += `<li class="hidden-tablet"><a href="${dataPYRUS.URLBASE}/${x}">${data.ELEMENT[x]}</a></li>`;
        }

        return html;
    }
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
    }
    this.datos = function(data) {
        let html = "";
        console.log(dataPYRUS)
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
    }
    /* ----------------- */
	return this.constructor();
};