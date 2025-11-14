;(function($){
    var Dialog = function (cfg){
        this.config = {
            width:180,
            height:150,
            msg:'Thao tác thành công',
            winDom:window,
            delay:0,
            bg:true,
            bgWhite:false,
            clickDomCancel:false,
            callback:null,
            type:"success"
        }

        $.extend(this.config,cfg);

        // Vật chứa tồn tại liền trở về
        if (Dialog.prototype.modelBox ) return;

        this.render(this.config.type);

        return this;
    }

    //Tại bế bao khu vực bên trong Đem Dialog Bộc lộ ra đi
    window.Dialog = Dialog;

    //Định nghĩa ngoại tầng
    //modelBox Hộp Nội dung khu vực ngoại tầng vật chứa
    Dialog.prototype.modelBox = null;

    Dialog.prototype.render = function(type){

        //Ban đầu phủ lên vật chứa
        this.renderUI(type);

        //Khóa lại sự kiện
        this.clickDom(); 

        //Ban đầu hóa hộp lớn nhỏ
        this.initBox();

        Dialog.prototype.modelBox.appendTo(this.config.winDom.document.body);
    };

    //Ban đầu phủ lên
    Dialog.prototype.renderUI = function(type){
        Dialog.prototype.modelBox = $("<div id='animationTipBox'></div>");

        //Nhắc nhở loại hình Phán đoán
        type == "load" && this.loadRender();
        type == "success" && this.successRender();
        type == "error" && this.errorRender();
        type == "tip" && this.tipRender();



        //Phải chăng biểu hiện lồng chụp
        if(this.config.bg){
            this.config.bgWhite ? this._mask = $("<div class='mask_white'></div>") : this._mask = $("<div class='mask'></div>");
            this._mask.appendTo(this.config.winDom.document.body);
        }  

        //config.delay Định thời gian lồng chụp biến mất
        _this_ = this;
        !this.config.delay && typeof this.config.callBack === "function" && (this.config.delay = 1);
        this.config.delay && setTimeout(function(){_this_.close();},_this_.config.delay);
        
        
    };

    Dialog.prototype.clickDom = function(){
        var _this = this;           
        
        //Điểm kích trống không lập tức hủy bỏ
        this.config.clickDomCancel && this._mask && this._mask.click(function(){_this.close();});                       
    };

    Dialog.prototype.initBox = function(){           
        Dialog.prototype.modelBox.css({
            width       : this.config.width+'px',
            height      : this.config.height+'px',
            marginLeft  : "-"+(this.config.width/2)+'px',
            marginTop   : "-"+(this.config.height/2)+'px'
        }); 
    };

    //Thành công hiệu quả
    Dialog.prototype.successRender = function(){
        var suc = "<div class='success'>";
            suc +=" <div class='icon'>";
            suc +=      "<div class='line_short'></div>";
            suc +=      "<div class='line_long'></div>  ";      
            suc +=  "</div>";
            suc +=" <div class='dec_txt'>"+this.config.msg+"</div>";
            suc += "</div>";
        Dialog.prototype.modelBox.append(suc);
    };

    //Tăng thêm hiệu quả
    Dialog.prototype.loadRender = function(){
        var load = "<div class='load'>";
            load += "<div class='icon_box'>";
        for(var i = 1; i < 4; i++ ){
            load += "<div class='cirBox"+i+"'>";
            load +=     "<div class='cir1'></div>";
            load +=     "<div class='cir2'></div>";
            load +=     "<div class='cir3'></div>";
            load +=     "<div class='cir4'></div>";
            load += "</div>";
        }
        load += "</div>";
        load += "</div>";
        load += "<div class='dec_txt'>"+this.config.msg+"</div>";
        Dialog.prototype.modelBox.append(load);
    };

    //Nhắc nhở hiệu quả
    Dialog.prototype.tipRender = function(){
        var tip = "<div class='tip'>";
            tip +="     <div class='icon'>i</div>";
            tip +="     <div class='dec_txt'>"+this.config.msg+"</div>";
            tip += "</div>";
        Dialog.prototype.modelBox.append(tip);
    };

    //Sai lầm hiệu quả
    Dialog.prototype.errorRender = function(){
        var err  = "<div class='lose'>";
            err +=  "   <div class='icon'>";
            err +=  "       <div class='icon_box'>";
            err +=  "           <div class='line_left'></div>";
            err +=  "           <div class='line_right'></div>";
            err +=  "       </div>";
            err +=  "   </div>";
            err +=  "<div class='dec_txt'>"+this.config.msg+"</div>";
            err +=  "</div>";
        Dialog.prototype.modelBox.append(err);
    };

    //Quan bế
    Dialog.prototype.close = function(){    
        Dialog.prototype.destroy();
        this.destroy();
        this.config.delay && typeof this.config.callBack === "function" && this.config.callBack();                
    };

    //Tiêu hủy
    Dialog.prototype.destroy = function(){
        this._mask && this._mask.remove();
        Dialog.prototype.modelBox && Dialog.prototype.modelBox.remove(); 
        Dialog.prototype.modelBox = null;
    };

    //Hàm số truyền lại
    
    popup = function(cfg){
        return new Dialog(cfg);
    }

})(Zepto);