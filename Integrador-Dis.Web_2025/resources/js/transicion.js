document.addEventListener("DOMContentLoaded", () => {
  const contenedor = document.getElementById("pantalla");

  document.body.addEventListener("click", async (e) => {
    const boton = e.target.closest("button[data-url]");

    if (boton) {
      e.preventDefault();
      const url = boton.getAttribute("data-url");

      if (!url || !contenedor) return;

      // animación fade out
      contenedor.classList.add("fade-out");

      setTimeout(async () => {
        try {
          const respuesta = await fetch(url);
          const texto = await respuesta.text();

          const nuevoDoc = new DOMParser().parseFromString(texto, "text/html");
          const nuevoContenido = nuevoDoc.getElementById("pantalla");

          if (nuevoContenido) {
            contenedor.innerHTML = nuevoContenido.innerHTML;
            contenedor.classList.remove("fade-out");
            contenedor.classList.add("fade-in");

            setTimeout(() => contenedor.classList.remove("fade-in"), 300);
          } else {
            console.error("No se encontró el div#pantalla en la respuesta.");
          }
        } catch (error) {
          console.error("Error al cargar contenido:", error);
        }
      }, 300);
    }
  });
});