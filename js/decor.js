class Decor {
    constructor (image, x, y, camera) {
        this.image = image;
        this.cx = x;
        this.cy = y;
        this.camera = camera;
        this.scale = 2/5;
        this.width = this.image.width * this.scale * this.camera.wscale;
        this.height = this.image.height * this.scale * this.camera.hscale;
    }
    get x() {
        return this.cx * this.camera.wscale;
    }

    get y() {
        return this.cy * this.camera.hscale;
    }
    draw(graphics) {
        graphics.drawImage(this.image, this.x, this.y, this.width, this.height);
    }

    onresize() {
        this.width = this.image.width * this.scale * this.camera.wscale;
        this.height = this.image.height * this.scale * this.camera.hscale;
    }
}