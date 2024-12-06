<?php 
session_start();
if (!isset($_SESSION['login'])) {
    header("Location: index.php");
    exit;
}
include('partiels/navbar.php') 
?>



<!-- description section starts here -->
<section class="description text-center">
    <div class="titre text-center">
        <h1>Module 3</h1>
    </div>

 </section>




 <?php include('partiels/footer.php') ?>



    
</body>  
</html>
