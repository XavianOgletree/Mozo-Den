
class Mozo {
    /**
     * 
     * @param {HTMLImageElement} image 
     * @param {number} x 
     * @param {number} y 
     */
    constructor(image, x, y, camera, id, name) {
        this.id = id;
        this.name = name;
        this.image = image;
        this.camera = camera;
        // center x and y
        this.cx = x;
        this.cy = y;

        // offset x and y
        this.ox = 0;
        this.oy = 0;

        // draw scale, display width, and display height
        this.scale = 1/5;
        this.width = image.width * this.scale * camera.wscale;
        this.height = image.height * this.scale *  camera.hscale;
        
        /*
            angle: the direction of travel
            radius: the size of 
        */
        this.target = { x: 0, y: 0 };
        this.max_radius = 300;
        this.distance = 0;
        this.cdistance = 0;
        this.speed = 200;
        this.move = false;
        this.t
    }

    get x() {
        return (this.cx + this.ox) * this.camera.wscale;
    }

    get y() {
        return (this.cy + this.oy) *this.camera.hscale;
    }
    /**
     * 
     * @param {number} dt 
     */

    easing(start, stop) {
        let x = ((stop - start) / stop);
        return 0.5 * (Math.sin(Math.PI * Math.pow(x, 0.8)) + 0.3 * Math.sin(Math.PI * 2 * Math.PI));
    }

    update(dt) {
        if (this.move) {
            let ease = this.easing(this.distance, this.cdistance);
            let dox = this.speed * ease * dt * Math.cos(this.angle - Math.PI);
            let doy = this.speed * ease * dt * Math.sin(this.angle - Math.PI);
            let ddistance = Math.sqrt(dox * dox + doy * doy);
            if (this.distance - ddistance < 0.001) {
                this.ox = this.target.x;
                this.oy = this.target.y;
                this.move = false;
            } else {
                this.distance -= ddistance;
                this.ox += dox;
                this.oy += doy;
            }
        }
        if (Math.random() > 0.99 && !this.move) {
            this.move = true;
            let theta = Math.random() * 2 * Math.PI;
            this.target = {
                x: this.max_radius * Math.random() * Math.cos(theta),
                y: this.max_radius * Math.random() * Math.sin(theta),
            }
        
            let dx = this.target.x - this.ox;
            let dy = this.target.y - this.oy;
            this.distance = Math.sqrt(dx * dx + dy * dy);
            this.cdistance = this.distance;
            this.angle = Math.atan2(this.target.y - this.oy, this.target.x - this.ox);
        }
        
    }

    random_position() {
        let theta = Math.random() * 2 * PI;
        return {
            x: this.cx + 10 * Math.cos(theta),
            y: this.cy + 10 * Math.sin(theta),
        }
    }

    get_angle(x1, x2, y1, y2) {
        dy = y2 - y1;
        dx = x1 - x2;
        return Math.atan(dy / dx);
    }

    /**
     * 
     * @param {CanvasRenderingContext2D} graphics 
     */
    draw(graphics) {
        graphics.drawImage(this.image, this.x, this.y, this.width, this.height);
        graphics.fillText(`${this.name}`, this.x, this.y - 15);
    }

    /**
     * 
     * @param {number} mx 
     * @param {number} my 
     */
    onclick(mx, my) {
        let lmx = mx - this.x, lmy = my - this.y;
        if (lmx >= 0 && lmx <= this.width && lmy >= 0 && lmy <= this.height) {
            console.log("clicked");
            return true;
        }
        return false;
    }

    onresize() {
        this.width = this.image.width * this.scale * this.camera.wscale;
        this.height = this.image.height * this.scale * this.camera.hscale;
    }
    
}

