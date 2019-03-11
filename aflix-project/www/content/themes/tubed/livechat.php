

<meta charset="utf-8">
                    <meta name="viewport" content="width=device-width, initial-scale=1.0">
                    <!-- bootstrap -->
                    <link rel="stylesheet" href="css/bootstrap.min.css">
                    <link rel="stylesheet" href="<?= THEME_URL . '/assets/livechatcss/prism.css'; ?>">

                    <script src="<?= THEME_URL . '/assets/livechatjs/jquery.min.js'; ?>"></script>
                    <script src="<?= THEME_URL . '/assets/livechatjs/prism.js'; ?>"></script>


                    <script src="<?= THEME_URL . '/assets/livechatjs/chatSocketAchex.js'; ?>"></script>
                    <link rel="stylesheet" type="text/css" href="<?= THEME_URL . '/assets/livechatcss/chatSocketAchex.css'; ?>">



<!-- Modal -->

        
            <div id="Elchat">
              <script type="text/javascript">
                                $('#Elchat').ChatSocket({
                                    'lblEntradaNombre':'<?php echo @$p=Auth::user()->username;?>'
                            });
                            </script></div>
                

        
    
<script type="text/javascript">

document.getElementById("ElchatlistaOnline").remove();
document.getElementById("txtEntrar").value = "<?php echo @$p=Auth::user()->username;?>";

</script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
<script>
$(document).ready(function(){
    $('#happy123').click(function(){
        alert("wana close ?");
        //$('#smallModal').modal('hide');
    });
});
</script>


