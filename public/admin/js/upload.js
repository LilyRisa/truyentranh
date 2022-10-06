class uploadImg{

    constructor(file){
        this.file = file;
    }
    getType(){
        return this.file.type;
    }
    getSize(){
        return this.file.size;
    }
    getName(){
        return this.file.name;
    }
    doUpload(url){
        let that = this; // bind -> class uploadImg in ajax
        let formData = new FormData();
        let progress_bar_id = this.progress;
        // add assoc key values, this will be posts values
        formData.append("file", this.file, this.getName());
        formData.append("upload_file", true);
    
        return new Promise((resolve, reject) => {
            $.ajax({
                type: "POST",
                url: url,
                xhr: function () {
                    let myXhr = new window.XMLHttpRequest();;
                    if (myXhr.upload) {
                        myXhr.upload.addEventListener('progress', that.progressHandling, false);
                    }

                    return myXhr;
                },
                async: true,
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                timeout: 60000
            }).done((data) => {
                $(progress_bar_id + " .progress-bar").css("width", "95%");
                $(progress_bar_id + " .status").text("95%");
                resolve(data);
                // console.log(data);
                // $(progress_bar_id+'').hide();
                // your callback here
            }).fail(e => {
                reject(e);
            })
    });
    }
    setProgressBar(id){
        this.progress = id;
    }
    progressHandling(event){
        let percent = 0;
        let position = event.loaded || event.position;
        let total = event.total;
        console.log(position+'|'+total);
        
        let progress_bar_id = this.progress;
        if (event.lengthComputable) {
            percent = Math.ceil(position / total * 100) - 10;
        }
        console.log(percent);
        // update progressbars classes so it fits your code
        $("#progress-wrp .progress-bar").css("width", +percent + "%");
        $("#progress-wrp .status").text(percent + "%");
    }
}