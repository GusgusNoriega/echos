# ECHOS - Tema WordPress

**Autor:** Gustavo Noriega  
**Versión:** 1.0.0  
**Descripción:** Tema personalizado para ECHOS Perú — Infraestructura para eventos.

---

## 📦 Instalación

1. Copia la carpeta `echos-theme` dentro de `wp-content/themes/` de tu instalación de WordPress.
2. Renombra la carpeta a `echos` (opcional, pero recomendado).
3. Ve a **Apariencia → Temas** en el panel de administración de WordPress.
4. Activa el tema **"ECHOS - Infraestructura para Eventos"**.

---

## 📄 Plantillas de Página Disponibles

El tema incluye **6 plantillas de página** que puedes asignar a cualquier página creada en WordPress:

| Template | Nombre en WP | Descripción |
|----------|-------------|-------------|
| `template-inicio.php` | **Inicio** | Página principal con hero slider, clientes, proyectos, servicios y contacto |
| `template-productos.php` | **Productos** | Listado de productos con grid |
| `template-producto.php` | **Producto Individual** | Detalle de un producto con características, ficha técnica y galería |
| `template-servicios-infraestructura.php` | **Servicio - Infraestructura** | Servicio de infraestructura con sistemas, productos y proyectos |
| `template-servicios-iluminacion.php` | **Servicio - Iluminación** | Servicio de iluminación con productos y servicios adicionales |
| `template-servicios-stands.php` | **Servicio - Stands para Ferias** | Servicio de stands con mobiliario, servicios adicionales y proyectos |

---

## 🔧 Cómo Asignar una Plantilla a una Página

1. Ve a **Páginas → Añadir nueva** en el panel de WordPress.
2. Escribe el título de la página (ej: "Inicio", "Productos", etc.).
3. En el panel lateral derecho, busca **"Atributos de página"** → **"Plantilla"**.
4. Selecciona la plantilla correspondiente del menú desplegable.
5. Publica la página.

### Páginas sugeridas a crear:

- **Inicio** → Plantilla: `Inicio`
- **Productos** → Plantilla: `Productos`
- **Esfera Cinética** (o cualquier producto) → Plantilla: `Producto Individual`
- **Infraestructura** → Plantilla: `Servicio - Infraestructura`
- **Iluminación** → Plantilla: `Servicio - Iluminación`
- **Stands para Ferias** → Plantilla: `Servicio - Stands para Ferias`

---

## 📁 Estructura del Tema

```
echos-theme/
├── style.css                  # Metadatos del tema (WordPress)
├── functions.php              # Funciones, enqueue de estilos/scripts
├── header.php                 # Header global de WordPress
├── footer.php                 # Footer global con popup
├── index.php                  # Template fallback (obligatorio en WP)
├── screenshot.png             # Imagen de previsualización del tema
├── README.md                  # Este archivo
├── assets/
│   ├── css/
│   │   ├── styles.css         # CSS base global
│   │   ├── popup.css          # CSS del popup
│   │   ├── productos.css      # CSS del listado de productos
│   │   ├── producto.css       # CSS del producto individual
│   │   ├── servicios-1.css    # CSS de infraestructura
│   │   ├── servicios-2.css    # CSS de iluminación
│   │   └── servicios-3.css    # CSS de stands para ferias
│   ├── js/
│   │   ├── app.js             # Hero slider + carrusel proyectos + contacto
│   │   ├── popup.js           # Popup de descuento
│   │   ├── producto.js        # Slider de producto recomendados
│   │   ├── servicios-1.js     # Slider de infraestructura
│   │   ├── servicios-2.js     # Slider de iluminación
│   │   └── servicios-3.js     # Sliders de stands (3 sliders)
│   └── img/
│       ├── inicio/            # Imágenes principales
│       └── popup/             # Imagen del popup
└── page-templates/
    ├── template-inicio.php
    ├── template-productos.php
    ├── template-producto.php
    ├── template-servicios-infraestructura.php
    ├── template-servicios-iluminacion.php
    └── template-servicios-stands.php
```

---

## ⚡ Configuración de Página de Inicio

Para que la página de inicio se muestre automáticamente:

1. Ve a **Ajustes → Lectura** en el panel de WordPress.
2. Selecciona **"Una página estática"**.
3. En **"Portada"**, selecciona la página que creaste con la plantilla **Inicio**.
4. Guarda los cambios.

---

## 📝 Notas

- Los CSS y JS se cargan condicionalmente según la plantilla activa (optimización).
- Las rutas de imágenes usan `get_template_directory_uri()` para ser compatibles con WordPress.
- El tema no es administrable (no usa ACF ni campos personalizados), el contenido está directamente en los templates.
- Para modificar textos o imágenes, edita directamente los archivos PHP de los templates.

---

## Home Administrable (Nuevo)

La plantilla `Inicio` ahora es administrable desde el editor de la pagina (metabox **Inicio: Secciones Administrables**).

### Secciones que puedes editar

- Hero (CTA + slides)
- Clientes (titulo, subtitulo, logos)
- Conocenos
- Proyectos (cards + boton)
- Servicios (items + boton)
- Contacto (textos, tabs y placeholders)

### Nueva estructura modular

- `inc/home/defaults.php`: valores por defecto de la portada
- `inc/home/data.php`: merge entre defaults y datos guardados
- `inc/admin/home-metabox.php`: UI de administracion y guardado seguro
- `template-parts/home/section-*.php`: render por seccion
- `assets/js/admin-home-sections.js`: repetidores + selector de imagen en admin
- `assets/css/admin-home-sections.css`: estilos del metabox

### Escalar a futuras vistas

Para hacer otra vista administrable, replica este patron:

1. Crea `inc/<vista>/defaults.php` y `inc/<vista>/data.php`.
2. Crea `inc/admin/<vista>-metabox.php`.
3. Divide el template en `template-parts/<vista>/section-*.php`.
4. Carga todo con `require_once` desde `functions.php`.
