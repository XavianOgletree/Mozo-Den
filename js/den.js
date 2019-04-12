/**
 * /NEVER/. do I /EVER/ want to write camera translation and input translation
 * code /EVER/ again.
 */

class Den {
    /**
     * 
     * @param {HTMLCanvasElement} elem 
     * @param {any[]} mozos
     * @param {HTMLImageElement[]} images
     */
    constructor(mozos) {
        this.canvas = document.getElementById('mozo-world');
        this.images = {};
        for (let i = 0, imageNodes = document.getElementById('mozo-images').children; i < imageNodes.length; i++) {
            this.images[imageNodes[i].alt] = imageNodes[i];
        }
        let hscale = this.canvas.height / this.canvas.clientHeight;
        let wscale = this.canvas.width / this.canvas.clientWidth;
        let minscale = Math.min(hscale, wscale);

        this.camera = {
            hscale: this.canvas.height / this.canvas.clientHeight,
            wscale: this.canvas.width / this.canvas.clientWidth,
            scale: minscale,
            
        };
        this.camera.tx = -this.canvas.clientWidth * (this.camera.wscale) * 0.5;
        this.camera.ty = -this.canvas.clientHeight * (this.camera.hscale) * 0.5;

        this.graphics = this.canvas.getContext('2d');
        this.graphics.font = '24px Short Stack';
        let rand_x = () => Math.random() * this.canvas.clientWidth * (this.camera.wscale), 
            rand_y = () => Math.random() * this.canvas.clientHeight * (this.camera.hscale);
        this.mozos = mozos.map((v, i) => new Mozo(this.images[v.mozoSpecies], rand_x(), rand_y(), this.camera, v.entryID, v.mozoName));
        this.decors = [];
        for (let i = 0, values = ['grass-1', 'grass-2', 'rock-1', 'rock-2']; i < 150; i++) {
            let decor = values[Math.floor(Math.random() * values.length)];
            let w = this.canvas.clientWidth * (this.camera.wscale) * 3;
            let h = this.canvas.clientWidth * (this.camera.wscale) * 3;
            let x = Math.random() * w - w / 2;
            let y = Math.random() * h - h / 2;
            this.decors.push(new Decor(this.images[decor], x, y, this.camera));
        }
        this.now = Date.now();
        this.past = this.now;
        this.mx = 0;
        this.my = 0;
        this.old_mx = 0;
        this.old_my = 0; 
        this.mouse_pressed = false;
        this.mouse_dragged = false;
        this.form = document.forms['get-mozo-info'];
        window.onresize = () => this.onresize();
        this.canvas.onmousedown = (event) => this.onmousedown(event);
        this.canvas.onmousemove = (event) => this.onmousemove(event);
        this.canvas.onmouseup = (event) => this.onmouseup(event);
        this.canvas.onmouseleave = (event) => this.onmouseleave(event);
        setInterval(() => this.update(), 16);
    }

    draw() {
        this.mozos = this.mozos.sort((a, b) => a.y - b.y);
        this.graphics.translate(this.camera.tx * this.camera.wscale, this.camera.ty  * this.camera.hscale);
        this.graphics.clearRect(-Number.MAX_SAFE_INTEGER / 2, -Number.MAX_SAFE_INTEGER / 2, Number.MAX_SAFE_INTEGER, Number.MAX_SAFE_INTEGER);
        
        this.decors.forEach(v => v.draw(this.graphics));
        this.mozos.forEach(v => v.draw(this.graphics));
        
        this.graphics.resetTransform();
    }

    update() {
        this.now = Date.now();
        let dt = (this.past - this.now) / 1000;
        this.mozos.forEach(v => v.update(dt));
        this.draw();
        this.past = this.now
    }

    onresize() {
        this.camera.hscale = this.canvas.height / this.canvas.clientHeight;
        this.camera.wscale = this.canvas.width / this.canvas.clientWidth;
        this.camera.scale = Math.min(this.camera.wscale, this.camera.hscale);
        this.mozos.forEach(v => v.onresize());
        this.decors.forEach(v => v.resize());
        this.draw();
    }

    /**
     * 
     * @param {MouseEvent} event 
     */
    onmousedown(event) {
        this.mx = event.clientX - Math.ceil(this.canvas.getBoundingClientRect().left);
        this.my = event.clientY - Math.ceil(this.canvas.getBoundingClientRect().top);
        this.old_mx = this.mx;
        this.old_my = this.my;
        this.mouse_pressed = true;
    }
    /**
     * 
     * @param {MouseEvent} event 
     */
    onmousemove(event) {
        if (this.mouse_pressed) {
            this.mouse_dragged = this.mouse_pressed;
            this.mx = event.clientX - Math.ceil(this.canvas.getBoundingClientRect().left);
            this.my = event.clientY - Math.ceil(this.canvas.getBoundingClientRect().top);
            this.camera.tx -= this.old_mx - this.mx;
            this.camera.ty -= this.old_my - this.my;
            this.old_mx = this.mx;
            this.old_my = this.my;
        }
    }
    /**
     * 
     * @param {MouseEvent} event 
     */
    onmouseup(_) {
        if (!this.mouse_dragged) {
            for (let i = this.mozos.length - 1; i >= 0; i--) {
                let mx = (this.mx - this.camera.tx) * this.camera.wscale;
                let my = (this.my - this.camera.ty) * this.camera.hscale;
                if (this.mozos[i].onclick(mx, my)) {
                    this.form.elements['mozo-id'].value = this.mozos[i].id;
                    this.form.submit();
                }
            }
        }
        this.mouse_dragged = false;
        this.mouse_pressed = false;
    }

    onmouseleave(_) {
        this.mouse_dragged = false;
        this.mouse_pressed = false;
    }
}