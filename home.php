<h3 class="text-center fw-bolder">Kontakt Uns</h3>
<center><hr class="bg-primary bg-opacity-100 opacity-100 my-1 border-1" width="50em"></center>
<div class="col-12 mt-5">
   <div class="container-fluid">
       <div class="row">
           <div class="col-md-4">
               <div class="card rounded-0 shadow mb-3">
                   <div class="card-body rounded-0">
                       <h5 class="fw-bold text-center"><i class="fa fa-envelope"></i> E-Mail an:</h5>
                       <center><hr class="bg-primary bg-opacity-100 opacity-100 my-1" width="50em"></center>
                        <div class="fs-5 text-center">info@schmidtverlag.com</div>
                   </div>
               </div>
               <div class="card rounded-0 shadow my-3">
                   <div class="card-body rounded-0">
                       <h5 class="fw-bold text-center"><i class="fa fa-phone"></i> Telefon:</h5>
                       <center><hr class="bg-primary bg-opacity-100 opacity-100 my-1" width="50em"></center>
                        <div class="fs-5 text-center">+49 123 45 789</div>
                   </div>
               </div>
               <div class="card rounded-0 shadow my-3">
                   <div class="card-body rounded-0">
                       <h5 class="fw-bold text-center"><i class="fa fa-map-marked-alt"></i> Adresse:</h5>
                       <center><hr class="bg-primary bg-opacity-100 opacity-100 my-1" width="50em"></center>
                        <div class="fs-5 text-center">Alt Berlin Straße 79, 10550, Mitte, Berlin DEUTSCHLAND</div>
                   </div>
               </div>
           </div>
           <div class="col-md-8">
                <div class="card shadow rounded-0">
                    <div class="card-body border-top-1 border-primary rounded-0">
                        <div class="container-fluid">
                            <h3 class="text-center fw-bolder">Senden Sie uns Ihren Namen</h3>
                            <center><hr class="bg-primary bg-opacity-100 opacity-100 my-1" width="50em"></center>
                            <form action="" id="contact-form">
                                <input type="hidden" name="id">
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <div class="form-group position-relative">
                                            <input type="text" id="firstname" name ="firstname" class="form-control form-control-sm rounded-0 form-control-border" required autocomplete="off" placeholder="hier Vorname eintragen">
                                            <small class="px-1 field-label">Vorname</small>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group position-relative">
                                            <input type="text" id="lastname" name ="lastname" class="form-control form-control-sm rounded-0 form-control-border" required autocomplete="off" placeholder="hier Nachname eintragen">
                                            <small class="px-1 field-label">Nachname</small>
                                        </div>
                                    </div>

                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-12 text-center">
                                        <button class="btn btn-primary bg-gradient rounded-pill btn-lg col-md-4"><i class="fa fa-paper-plane"></i> Nachricht senden</button>
                                        <button type="reset" class="btn btn-light border bg-gradient rounded-pill btn-lg col-md-4"><i class="fa fa-redo"></i> Reset</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
           </div>
       </div>
   </div>
</div>
<script>
    $(function(){
        $('#contact-form').submit(function(e){
            e.preventDefault();
            const _this= $(this)
            $('.pop-msg').remove()
            const _el = $("<div>")
                _el.addClass("alert pop-msg my-2")
                _el.html('<div class="d-flex w-100 align-items-center">'+
                         '<div class="text-msg col-11"></div>'+
                         '<div class="col-1"><button class="btn-close" id="pop-msg-btn"></button></div>'+
                        '</div>')
                _el.hide()
                _el.find('#pop-msg-btn').click(function(){
                    _el.hide('slideUp')
                    setTimeout(() => {
                        _el.remove()
                    }, 1000);
                })
            if(_this[0].checkValidity() === false){
                _this[0].reportValidity();
                return false;
            }
            console.log(_this.serialize())
            _this.find('input,select,textarea').attr('readonly',true)
            _this.find('button').attr('disabled',true)
            $.ajax({
                url:'Actions.php?a=save_message',
                method:'POST',
                type:'POST',
                data:$(this).serialize(),
                dataType:'json',
                error:err=>{
                    console.log(err)
                    _el.addClass('alert-danger')
                    _el.find('.text-msg').text("An error occurred.")
                    _this.before(_el)
                    _el.show()
                    _this.find('input,select,textarea').attr('readonly',false)
                    _this.find('button').attr('disabled',false)
                },
                success:function(resp){
                    if(!!resp.msg){
                        _el.find('.text-msg').text(resp.msg)
                    }
                    if(resp.status === 'success'){
                        _el.addClass('alert-success')
                        _this[0].reset(0)
                    }else{
                        _el.addClass('alert-danger')
                        if(!resp.msg){
                            _el.find('.text-msg').text('An error occurred.')
                        }
                    }
                    _this.before(_el)
                    _el.show()
                    _this.find('input,select,textarea').attr('readonly',false)
                    _this.find('button').attr('disabled',false)
                }
            })
        })
    })
</script>