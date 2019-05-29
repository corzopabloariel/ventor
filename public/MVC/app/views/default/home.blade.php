<div class="container">
    <h1>Archivos subidos</h1>
    <ul>
        <?php
            foreach($archivos AS $a)
                echo "<li>{$a} <a href='subir/{$a}'><i class='ml-2 fas fa-edit'></i></a></li>";
        ?>
    </ul>
    <hr>
    <h1>Actualizar información</h1>
    <ul>
        <li><a href="producto">Productos</a> - Producto, Modelo, Marca, Familia y Parte</li>
        <li><a href="transporte">Transportes</a></li>
        <li><a href="vendedores">Vendedores</a></li>
        <li><a href="clientes">Clientes</a></li>
        <li><a href="usuarios">Empleados</a></li>
    </ul>
</div>