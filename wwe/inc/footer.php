</div>
<div style="clear:both;"></div>
<?php
if ($db) {
    $db = NULL;
}
if (is_array($_SESSION['mesgs']) && is_array($_SESSION['mesgs']['confirm'])) {
    foreach ($_SESSION['mesgs']['confirm'] as $mesg) {
?>
        <div class="alertbox messagebox">
            <span class="closebtn">&times;</span>
            <?= $mesg; ?>
        </div>
    <?php
    }
    unset($_SESSION['mesgs']['confirm']);
}
if (is_array($_SESSION['mesgs']) && is_array($_SESSION['mesgs']['errors'])) {
    foreach ($_SESSION['mesgs']['errors'] as $err) {
    ?>
        <div class="alertbox errorbox">
            <span class="closebtn">&times;</span>
            <?= $err; ?>
        </div>
<?php
    }
    unset($_SESSION['mesgs']['errors']);
}
?>

<script>
    var close = document.getElementsByClassName("closebtn");
    var i;

    for (i = 0; i < close.length; i++) {
        close[i].onclick = function() {

            var div = this.parentElement;

            div.style.opacity = "0";

            setTimeout(function() {
                div.style.display = "none";
            }, 600);
        }
    }
</script>
<footer class="w3-container w3-padding-64 w3-center w3-opacity w3-light-grey w3-xlarge">
  <i class="fab fa-facebook w3-hover-opacity" aria-hidden="true"></i>
  <i class="fab fa-instagram w3-hover-opacity" aria-hidden="true"></i>
  <i class="fab fa-snapchat w3-hover-opacity" aria-hidden="true"></i>
  <i class="fab fa-pinterest-p w3-hover-opacity" aria-hidden="true"></i>
  <i class="fab fa-twitter w3-hover-opacity" aria-hidden="true"></i>
  <i class="fab fa-linkedin w3-hover-opacity" aria-hidden="true"></i>
</footer>

</body>

</html>