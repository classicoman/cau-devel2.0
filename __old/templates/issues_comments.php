<link rel="stylesheet" type="text/css" href="css/comments.css"/>

<div id="issues_comments">
    <div id="label"><b>Comentaris:</b></div>
    <div id="issues_comments_sub">
<?php        
        /* Print the list of Comments */
        include 'issues_comments_sub.php';       
?>
    </div>
</div>
<!-- Add a comment - Zone -->
<div id="add_comment">
    <div id="textarea"> <textarea id="comment_js"></textarea> </div>    
    <div id="sendBtn"><img src="images/6_social_send_now.png" /></div>
</div>


<script>
//Add a New comment
$("#sendBtn").click( function(e) {
    if ($("#comment_js").val()!="")  {
        //Escape with encodeURIComponent()
        var name = encodeURIComponent(document.getElementById('comment_js').value);
    
        loadXMLDoc('issues_comments_sub',
                   '<?php echo "ajax/issues_comments_subX.php?op=NEW&issue=$issue&member=".$rowmember['id']."&name=" ?>'+name);
    } 
});

//Per a canviar el color de la icona quan és espitjada o s'hi passa per sobre
$('#sendBtn img')
    .mouseover(function() { 
        var src = "images/6_social_send_now2.png";
        $(this).attr("src", src);
    })
    .mouseout(function() {
        var src = "images/6_social_send_now.png";
        $(this).attr("src", src);
    });
</script>