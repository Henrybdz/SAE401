class Carousel {
    constructor() {
        this.currentIndex = 0;
        this.container = document.querySelector('.carousel-inner');
        this.prevBtn = document.querySelector('.carousel-btn.prev');
        this.nextBtn = document.querySelector('.carousel-btn.next');
        this.dotsContainer = document.querySelector('.carousel-dots');
        this.items = [];
        this.isTransitioning = false;

        this.init();
    }

    async init() {
        try {
            const response = await fetch('Donnees/avis.json');
            const data = await response.json();
            this.items = data.avis;

            this.renderItems();
            this.renderDots();
            this.addEventListeners();

            // Pré-activer le premier élément avant de le montrer
            const firstItem = document.querySelector('.carousel-item');
            if (firstItem) {
                firstItem.style.opacity = '0';
                firstItem.classList.add('active');
                // Forcer un reflow
                firstItem.offsetHeight;
                firstItem.style.opacity = '1';
            }
            this.showItem(0, true);

            this.startAutoScroll();
        } catch (error) {
            console.error('Erreur lors du chargement des avis:', error);
        }
    }

    renderItems() {
        this.items.forEach((item, index) => {
            const itemElement = document.createElement('div');
            itemElement.className = 'carousel-item';
            itemElement.style.opacity = '0';

            const stars = '★'.repeat(item.note) + '☆'.repeat(5 - item.note);

            itemElement.innerHTML = `
                <h2 class="avis-title">"${item.titre}"</h2>
                <p class="avis-text">${item.texte}</p>
                <p class="avis-author">${item.auteur}</p>
                <div class="avis-rating">${stars}</div>
            `;

            this.container.appendChild(itemElement);
        });
    }

    renderDots() {
        this.items.forEach((_, index) => {
            const dot = document.createElement('div');
            dot.className = 'carousel-dot';
            dot.addEventListener('click', () => {
                if (!this.isTransitioning) {
                    this.showItem(index);
                }
            });
            this.dotsContainer.appendChild(dot);
        });
    }

    showItem(index, isInitial = false) {
        if (this.isTransitioning && !isInitial) return;

        this.isTransitioning = true;
        const items = document.querySelectorAll('.carousel-item');
        const dots = document.querySelectorAll('.carousel-dot');

        // Fade out current item
        const currentItem = document.querySelector('.carousel-item.active');
        if (currentItem && !isInitial) {
            currentItem.style.opacity = '0';
        }

        // Wait for fade out
        setTimeout(() => {
            items.forEach(item => item.classList.remove('active'));
            dots.forEach(dot => dot.classList.remove('active'));

            // Add active class and fade in new item
            items[index].classList.add('active');
            dots[index].classList.add('active');

            // Force reflow
            items[index].offsetHeight;
            items[index].style.opacity = '1';

            this.currentIndex = index;

            // Reset transition flag after animation
            setTimeout(() => {
                this.isTransitioning = false;
            }, 500);
        }, isInitial ? 0 : 500);
    }

    nextItem() {
        if (!this.isTransitioning) {
            const nextIndex = (this.currentIndex + 1) % this.items.length;
            this.showItem(nextIndex);
        }
    }

    prevItem() {
        if (!this.isTransitioning) {
            const prevIndex = (this.currentIndex - 1 + this.items.length) % this.items.length;
            this.showItem(prevIndex);
        }
    }

    addEventListeners() {
        this.prevBtn.addEventListener('click', () => this.prevItem());
        this.nextBtn.addEventListener('click', () => this.nextItem());
    }

    startAutoScroll() {
        setInterval(() => {
            if (!this.isTransitioning) {
                this.nextItem();
            }
        }, 5000);
    }
}

// Initialiser le carrousel quand le DOM est chargé
document.addEventListener('DOMContentLoaded', () => {
    new Carousel();
});