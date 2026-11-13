document.addEventListener('DOMContentLoaded', () => {

    const botonesBorrarColab = document.querySelectorAll('.boton_cancelar');

    botonesBorrarColab.forEach(boton => {

        boton.addEventListener('click', (e) => {

            if (!confirm('¿Quieres eliminar este colaborador?')) {
                e.preventDefault();
            }

        });

    });

    const botonesBorrarProyecto = document.querySelectorAll('.borrar_proyecto');

    botonesBorrarProyecto.forEach(boton => {

        boton.addEventListener('click', (e) => {

            if (!confirm('¿Seguro que quieres eliminar este proyecto? Esta acción no se puede deshacer.')) {
                e.preventDefault();
            }

        });

    });

    

});