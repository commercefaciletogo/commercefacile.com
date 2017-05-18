import base64toblob from 'base64toblob';

export default class ImageCompressor { 

    constructor(image, canvas, scale, quality, doneCompressing) {
        this.scale = scale;
        this.quality = quality;
        this.canvas = canvas;
        this.image = image;
        this.reader = {};
        this.result = {};
        this.img = {};
        this.doneCompressing = doneCompressing;
        this.fileOnLoad = this.fileOnLoad.bind(this);
        this.imageOnLoad = this.imageOnLoad.bind(this);
    }

    run() {
        this.readFile();
    }

    readFile() {
        this.reader = new FileReader();
        // on reader load somthing...
        this.reader.onload = this.fileOnLoad;
        // Convert the file to base64 text
        this.reader.readAsDataURL(this.image);
    }

    fileOnLoad() {
        // Make a fileInfo Object
        let fileInfo = {
            name: this.image.name,
            type: this.image.type,
            size: Math.round(this.image.size / 1000)+' kB',
            base64: this.reader.result,
            file: this.image
        }

        // Push it to the state
        this.result = fileInfo

        // DrawImage
        this.drawImage(this.result.base64)
    }

    drawImage(imgUrl) {
        this.img = new Image();
        this.img.onload = this.imageOnLoad;
        this.img.src = imgUrl;
    }

    imageOnLoad(event) {
        // Set Canvas Context
        let ctx = this.canvas.getContext('2d');

        // Image Size After Scaling
        let scale = this.scale / 100;
        let width = this.img.width * scale;
        let height = this.img.height * scale;

        // Set Canvas Height And Width According to Image Size And Scale
        this.canvas.setAttribute('width', width);
        this.canvas.setAttribute('height', height);

        ctx.drawImage(this.img, 0, 0, width, height);

        // Quality Of Image
        let quality = this.quality ? (this.quality / 100) : 1;

        // If all files have been proceed
        let base64 = this.canvas.toDataURL('image/jpeg', quality);

        let fileName = this.result.file.name;
        let lastDot = fileName.lastIndexOf(".");
        fileName = fileName.substr(0, lastDot) + '.jpeg';

        let objToPass = {
            canvas: this.canvas,
            original: this.result,
            compressed: {
                blob: this.toBlob(base64),
                base64: base64,
                name: fileName,
                file: this.buildFile(base64, fileName)
            },
        }

        objToPass.compressed.size = Math.round(objToPass.compressed.file.size / 1000)+' kB'
        objToPass.compressed.type = "image/jpeg"

        this.doneCompressing(objToPass)
    }

    toBlob(imgUrl) {
        let blob = base64toblob(imgUrl.split(',')[1], "image/jpeg");
        let url = window.URL.createObjectURL(blob);
        return url;
    }
    
    buildFile(blob, name) {
        return new File([blob], name);
    }
};