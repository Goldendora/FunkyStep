
import '../css/app.css';


import 'bootstrap/dist/js/bootstrap.bundle.min.js';


import * as bootstrap from 'bootstrap';
window.bootstrap = bootstrap;

// ==== Código de Funkystep ====

// Cambio automático de imagen decorativa
document.addEventListener('DOMContentLoaded', () => {
    const img = document.getElementById('visual2');
    if (!img) return;

    const images = [
        "/images/decoration/image1.png",
        "/images/decoration/image2.png",
        "/images/decoration/image3.png",
        "/images/decoration/image4.png",
        "/images/decoration/image5.png",
        "/images/decoration/image6.png"
    ];

    let index = 0;
    setInterval(() => {
        img.classList.add('slide');
        setTimeout(() => {
            index = (index + 1) % images.length;
            img.src = images[index];
            img.classList.remove('slide');
        }, 800);
    }, 4000);
});

// Mostrar modal de producto dinámicamente
window.showProductModal = function (name, image, brand, category, description, price, discount, stock) {
    document.getElementById('modalTitle').textContent = name;
    document.getElementById('modalImage').src = image;
    document.getElementById('modalBrand').textContent = "Marca: " + brand;
    document.getElementById('modalCategory').textContent = "Categoría: " + category;
    document.getElementById('modalDescription').textContent = description;
    document.getElementById('modalPrice').textContent = "$" + price + " COP";
    document.getElementById('modalDiscount').textContent = discount > 0 ? "Descuento: -" + discount + "%" : "";
    document.getElementById('modalStock').textContent = "Disponibles: " + stock + " unidades";

    const modal = new bootstrap.Modal(document.getElementById('productModal'));
    modal.show();
};

// Activar animación de escritura
document.addEventListener('DOMContentLoaded', () => {
    const cursor = document.querySelector('.cursor');
    if (!cursor) return;

    const observer = new IntersectionObserver(
        entries => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    cursor.classList.add('typewriter-animation');
                    observer.unobserve(cursor);
                }
            });
        },
        { threshold: 0.6, rootMargin: '0px 0px -20% 0px' }
    );

    observer.observe(cursor);
});

// Función para hacer burbujas arrastrables
function hacerArrastrable(el) {
    let offsetX = 0, offsetY = 0, arrastrando = false;

    el.addEventListener("mousedown", (e) => {
        arrastrando = true;
        offsetX = e.clientX - el.offsetLeft;
        offsetY = e.clientY - el.offsetTop;
        el.style.cursor = "grabbing";
    });

    document.addEventListener("mousemove", (e) => {
        if (arrastrando) {
            el.style.left = (e.clientX - offsetX) + "px";
            el.style.top = (e.clientY - offsetY) + "px";
        }
    });

    document.addEventListener("mouseup", () => {
        arrastrando = false;
        el.style.cursor = "grab";
    });

    el.style.position = "absolute";
    el.style.cursor = "grab";
}

document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll(".bubble-wrap").forEach(b => hacerArrastrable(b));
});
document.addEventListener('DOMContentLoaded', () => {
    const userMenu = document.getElementById('userMenu');
    if (userMenu) {
        const dd = bootstrap.Dropdown.getOrCreateInstance(userMenu, {
            popperConfig: { strategy: 'fixed' }
        });
        userMenu.addEventListener('click', (e) => {
            e.preventDefault(); // evita salto por href="#"
            dd.toggle();
        });
    }

    const guestMenu = document.getElementById('guestMenu');
    if (guestMenu) {
        const dd2 = bootstrap.Dropdown.getOrCreateInstance(guestMenu, {
            popperConfig: { strategy: 'fixed' }
        });
        guestMenu.addEventListener('click', (e) => {
            e.preventDefault();
            dd2.toggle();
        });
    }
});
