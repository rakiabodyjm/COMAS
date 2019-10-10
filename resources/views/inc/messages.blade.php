@if(count($errors)>0)
    @foreach($errors->all() as $error)
    <script type="text/javascript">

        $(document).ready(function(){
            $.notify({
                message: "{{$error}}",
                icon: "pe-7s-attention",
               
            },{
                type: 'danger',
                delay: 7000,
                template: '<div data-notify="container" class="col-xs-11 col-sm-9 alert alert-{0}" role="alert">'+
                '<span data-notify="icon"></span> ' +
                '<span data-notify="title">{1}</span> ' +
                '<span data-notify="message">{2}</span>'+
                '<button type="button" aria-hidden="true" class="close" data-notify="dismiss">x</button>'
                ,
                placement: {
                    from: "top",
                    align: "center"
                }
    
            })
        });       
    </script>

    @endforeach
@endif

@if(session('success'))
  
        <script type="text/javascript">

            $(document).ready(function(){
                $.notify({
                    message: "{{session('success')}}",
                    icon: "pe-7s-check",
                   
                },{
                    type: 'success',
                    delay: 7000,
                    template: '<div data-notify="container" class="col-xs-11 col-sm-9 alert alert-{0}" role="alert">'+
                    '<span data-notify="icon"></span> ' +
                    '<span data-notify="title">{1}</span> ' +
                    '<span data-notify="message">{2}</span>'+
                    '<button type="button" aria-hidden="true" class="close" data-notify="dismiss">x</button>'
                    ,
                    placement: {
                        from: "top",
                        align: "center"
                    }
        
                })
            });       
        </script>
@endif

@if(session('error'))
        <script type="text/javascript">

            $(document).ready(function(){
                $.notify({
                    message: "{{session('error')}}",
                    icon: "pe-7s-attention",
                   
                },{
                    type: 'danger',
                    delay: 7000,
                    template: '<div data-notify="container" class="col-xs-11 col-sm-9 alert alert-{0}" role="alert">'+
                    '<span data-notify="icon"></span> ' +
                    '<span data-notify="title">{1}</span> ' +
                    '<span data-notify="message">{2}</span>'+
                    '<button type="button" aria-hidden="true" class="close" data-notify="dismiss">x</button>'
                    ,
                    placement: {
                        from: "top",
                        align: "center"
                    }
        
                })
            });       
        </script>
@endif



<!--THE SCRIPT FOR NOTIFICATION-->


