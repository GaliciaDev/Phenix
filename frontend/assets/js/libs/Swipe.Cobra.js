class Slider {
    constructor(sliderElement) {
        this.sliderElement = sliderElement;
        this.slides = sliderElement.querySelector('.slides');
        this.slide = sliderElement.querySelectorAll('.slide');
        this.index = 0;
        this.startX = 0;
        this.endX = 0;
        this.isDragging = false;
        this.sensitivity = 30; // Adjusted swipe sensitivity
        this.initEvents();
        this.createNavigationButtons();
        this.createIndicators();
        this.updateIndicators();
    }

    initEvents() {
        this.slides.addEventListener('touchstart', this.touchStart.bind(this));
        this.slides.addEventListener('touchend', this.touchEnd.bind(this));
        this.slides.addEventListener('mousedown', this.mouseDown.bind(this));
        this.slides.addEventListener('mousemove', this.mouseMove.bind(this));
        this.slides.addEventListener('mouseup', this.mouseUp.bind(this));
        this.slides.addEventListener('mouseleave', this.mouseLeave.bind(this));
        window.addEventListener('resize', this.resize.bind(this));
    }

    touchStart(e) {
        this.startX = e.touches[0].clientX;
    }

    touchEnd(e) {
        this.endX = e.changedTouches[0].clientX;
        this.handleGesture();
    }

    mouseDown(e) {
        this.startX = e.clientX;
        this.isDragging = true;
        e.preventDefault();
    }

    mouseMove(e) {
        if (this.isDragging) {
            this.endX = e.clientX;
        }
    }

    mouseUp(e) {
        if (this.isDragging) {
            this.endX = e.clientX;
            this.handleGesture();
            this.isDragging = false;
        }
    }

    mouseLeave(e) {
        if (this.isDragging) {
            this.endX = e.clientX;
            this.handleGesture();
            this.isDragging = false;
        }
    }

    handleGesture() {
        if (this.startX - this.endX > this.sensitivity) {
            this.index = (this.index < this.slide.length - 1) ? this.index + 1 : 0;
        }
        if (this.endX - this.startX > this.sensitivity) {
            this.index = (this.index > 0) ? this.index - 1 : this.slide.length - 1;
        }
        this.showSlide();
    }

    showSlide() {
        this.slides.style.transform = `translateX(${-this.index * 100}%)`;
        this.updateIndicators();
    }

    resize() {
        // Example: Adjust slide height dynamically on resize if needed
        this.slides.style.height = `${this.slide[this.index].clientHeight}px`;
    }

    createNavigationButtons() {
        const prevButton = document.createElement('button');
        const nextButton = document.createElement('button');
        prevButton.className = 'nav-button prev';
        nextButton.className = 'nav-button next';
        prevButton.innerText = '❮'; // Left arrow
        nextButton.innerText = '❯'; // Right arrow

        prevButton.addEventListener('click', () => {
            this.index = (this.index > 0) ? this.index - 1 : this.slide.length - 1;
            this.showSlide();
        });

        nextButton.addEventListener('click', () => {
            this.index = (this.index < this.slide.length - 1) ? this.index + 1 : 0;
            this.showSlide();
        });

        this.sliderElement.appendChild(prevButton);
        this.sliderElement.appendChild(nextButton);
    }

    createIndicators() {
        this.indicators = document.createElement('div');
        this.indicators.className = 'indicators';
        this.sliderElement.appendChild(this.indicators);
        this.slide.forEach((_, i) => {
            const dot = document.createElement('span');
            dot.className = 'dot';
            this.indicators.appendChild(dot);
        });
    }

    updateIndicators() {
        const dots = this.indicators.querySelectorAll('.dot');
        dots.forEach((dot, i) => {
            dot.classList.toggle('active', i === this.index);
        });
    }
}

document.addEventListener('DOMContentLoaded', () => {
    const sliderElement = document.querySelector('.slider');
    new Slider(sliderElement);
});