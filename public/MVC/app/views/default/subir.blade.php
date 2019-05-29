<div class="container">
    <a href="../index">Volver</a>
    <form action="" enctype="multipart/form-data" method="post" >
        <input type="hidden" name="nombre" value="<?php echo $archivo ?>">
        <input required type="file" name="archivo">
        <button type="submit" class="btn btn-success">cambiar</button>
    </form>
</div>