class Explore {

    /**
     * 
     * @param {HTMLCanvasElement} elem 
     * @param {any[]} mozos
     * @param {HTMLImageElement[]} images
     */
    constructor(canvas, mozos, images) {
        this.canvas = canvas;
        this.graphics = canvas.getContext('2d');
        this.mozos = mozos.map((value, index) => new Mozo(this.images[value], 256 * index, 256 * index));
        this.images = images;
        this.dt = 0;
        this.now = Date.now();
        this.past = this.now;
        window.onresize = () => undefined;
        canvas.onmousedown = () => undefined;
        canvas.onmousemove = () => undefined;
        canvas.onmouseup = () => undefined;
        setInterval(() => this.update(), 16);
    }

    draw() { 
        for (let i = 0; i < this.mozos.length; i++) {
            this.mozos[i].draw(this.graphics);
        }
    }

    update() {
        this.now = Date.now();
        this.dt = (this.past - this.now) / 1000;
        for (let i = 0; i < this.mozoss.length; i++) {
            this.mozos[i].update(dt);
        }
        this.past = this.now
    }
}