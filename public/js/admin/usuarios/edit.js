function toggleVeterinarioFields() {
    var rol = document.getElementById('rol').value;
    var vetFields = document.getElementById('veterinario_fields');
    
    if (rol === 'veterinario') {
        vetFields.style.display = 'block';
        // Hacer campos requeridos si es veterinario
        document.getElementById('especialidad').required = true;
        document.getElementById('cedula_profesional').required = true;
    } else {
        vetFields.style.display = 'none';
        // Quitar requeridos si no es veterinario
        document.getElementById('especialidad').required = false;
        document.getElementById('cedula_profesional').required = false;
    }
}

// Ejecutar al cargar la página por si hay old('rol') o el rol predeterminado
window.onload = function() {
    if(document.getElementById('rol').value) {
        toggleVeterinarioFields();
    }
};
