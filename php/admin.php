<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prueba de CRUD</title>
    <link rel="stylesheet" href="/css/styleAdmin.css">
    <link rel="stylesheet" href="/css/head.css">
   
</head>

<body>

    <br>
    <h1 class="text-center">Bienvenido administrador</h1>
<div id="app">
    <form id="chef-form">
        <input type="text" id="nombres" placeholder="Nombre del Chef" required>
        <select id="genero" required>
            <option value="" disabled selected>Seleccione Género</option>
            <option value="M">Masculino</option>
            <option value="F">Femenino</option>
            <option value="Otro">Otro</option>
        </select>
        <select id="descripcion" required>
            <option value="" disabled selected>Seleccione Rol</option>
            <option value="administrador">Administrador</option>
            <option value="chef">Chef</option>
        </select>
        <button type="submit" class="btn-styled">Agregar Chef</button>
    </form>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Descripcion</th>
                <th>Nombres</th>
                <th>Género</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody id="chefs-list"></tbody>
    </table>
</div>


    <script src="../js/script.js"></script>

</body>
</html>


