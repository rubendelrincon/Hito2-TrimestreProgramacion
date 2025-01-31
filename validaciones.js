document.getElementById('registroForm').addEventListener('submit', function(event) {
    // Obtener los valores de los campos
    const nombre = document.getElementById('nombre').value.trim();
    const apellido = document.getElementById('apellido').value.trim();
    const email = document.getElementById('email').value.trim();
    const edad = parseInt(document.getElementById('edad').value.trim());
    const plan_base = document.getElementById('plan_base').value.trim();
    const duracion = document.getElementById('duracion').value.trim();
   
    // Verificar si se ha seleccionado algún paquete adicional
    const paquetes = document.querySelectorAll('input[name="paquete[]"]:checked');
    const paquetesSeleccionados = Array.from(paquetes).map(paquete => paquete.value);

    // Validaciones
    if (!nombre || !apellido || !email || !edad || !plan_base || !duracion) {
        alert('Por favor, completa todos los campos.');
        event.preventDefault(); // Prevenir envío
    }
    else if (!email.includes('@')) {
        alert('Por favor, introduce un correo electrónico válido.');
        event.preventDefault(); // Prevenir envío
    }
    else if (edad < 18 && plan_base !== "Infantil" && paquetesSeleccionados.length > 0) {
        alert('Para seleccionar un plan distinto al infantil, debes ser mayor de edad.');
        event.preventDefault(); // Prevenir envío
    }
    else if (paquetesSeleccionados.includes("Deporte") && duracion !== "Anual") {
        alert('Para seleccionar el paquete de deportes, la duración debe ser anual.');
        event.preventDefault(); // Prevenir envío
    }
});