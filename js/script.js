document.getElementById('chef-form').addEventListener('submit', async function (e) {
    e.preventDefault();

    const nombres = document.getElementById('nombres').value.trim();
    const descripcion = document.getElementById('descripcion').value;
    const genero = document.getElementById('genero').value;

    if (!nombres || !genero || !descripcion) {
        alert("Todos los campos son obligatorios");
        return;
    }

    // Enviar datos al backend
    try {
        const response = await fetch('../php/api.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ descripcion, nombres, genero })
        });
        const newChef = await response.json();

        if (response.ok) {
            alert(newChef.message || "Chef agregado correctamente.");
            // Limpiar el formulario después de agregar
            document.getElementById('chef-form').reset();
            // Actualizar la tabla
            loadChefs();
        } else {
            alert(newChef.error || "Error al agregar el chef.");
        }
    } catch (error) {
        alert("Error al enviar los datos: " + error.message);
    }
});

async function loadChefs() {
    try {
        const response = await fetch('../php/api.php'); // Llamada al backend para obtener los datos
        if (!response.ok) {
            throw new Error('Error al cargar los datos');
        }

        const chefs = await response.json(); // Parsear la respuesta a JSON

        const tbody = document.getElementById('chefs-list');
        tbody.innerHTML = ''; // Limpiar el contenido existente

        // Verificar si hay datos
        if (chefs.length === 0) {
            tbody.innerHTML = '<tr><td colspan="4" class="text-center">No hay datos disponibles</td></tr>';
            return;
        }

        // Crear las filas de la tabla dinámicamente con solo los campos deseados
        chefs.forEach(chef => {
            const row = document.createElement('tr');
            row.innerHTML = `
                <td>${chef.id}</td>
                <td>${chef.descripcion}</td>
                <td>${chef.nombres}</td>
                <td>${chef.genero}</td>
                <td>
                    <button class="btn btn-warning btn-sm me-2" onclick="updateChef(${chef.id})">Actualizar</button>
                    <button class="btn btn-danger btn-sm" onclick="deleteChef(${chef.id})">Eliminar</button>
                </td>
            `;
            tbody.appendChild(row);
        });
    } catch (error) {
        alert("Error al cargar los chefs: " + error.message);
    }
}

async function deleteChef(id) {
    try {
        const response = await fetch('../php/api.php', {
            method: 'DELETE',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ id })
        });

        if (!response.ok) {
            throw new Error('Error al eliminar el chef');
        }

        // Actualizar la tabla
        loadChefs();
    } catch (error) {
        alert("Error al eliminar el chef: " + error.message);
    }
}

// Cargar datos al iniciar
loadChefs();

async function updateChef(id) {
    const nombres = prompt("Ingrese el nuevo nombre del chef:");
    const descripcion = prompt('Descripcion (Administrador/Chef)');
    const genero = prompt("Ingrese el nuevo género del chef (M/F/Otro):");

    if (!nombres || !genero || !descripcion) {
        alert("Todos los campos son obligatorios.");
        return;
    }

    try {
        // Enviar datos al backend para actualizar
        const response = await fetch('../php/api.php', {
            method: 'PUT',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ id, descripcion, nombres, genero })
        });

        const result = await response.json();

        if (response.ok) {
            alert(result.message || "Chef actualizado correctamente.");
            loadChefs(); // Recargar la lista
        } else {
            alert(result.error || "Error al actualizar el chef.");
        }
    } catch (error) {
        alert("Error al actualizar el chef: " + error.message);
    }
}
